<?php
/**
 * @TODO What this does.
 *
 * @package   @TODO
 * @author    Josh Pollock <Josh@JoshPress.net>
 * @license   GPL-2.0+
 * @link      
 * @copyright 2014 Josh Pollock
 */

namespace caldera\metaplate;

use Handlebars\Handlebars;

class render {

	/**
	 * Return the content with metaplate applied.
	 *
	 *
	 * @return    string    rendered HTML with templates applied
	 */
	public function render_metaplate( $content ) {

		global $post;

		$meta_stack = data::get_active_metaplates();
		if( empty( $meta_stack ) ){
			return $content;
		}

		$style_data = null;
		$script_data = null;

		$template_data = data::get_custom_field_data( $post->ID );
		//var_dump( $template_data );
		//die;
		$engine = new Handlebars;

		$engine->addHelper( 'is', array( 'caldera\helpers\is', 'helper' ) );
		$engine->addHelper( '_image', array( 'caldera\helpers\image', 'helper' ) );

		foreach( $meta_stack as $metaplate ){
			// apply filter to data for this metaplate
			$template_data = apply_filters( 'metaplate_data', $template_data, $metaplate );
			// check CSS
			$style_data .= $engine->render( $metaplate['css']['code'], $template_data );
			// check JS
			$script_data .= $engine->render( $metaplate['js']['code'], $template_data );

			switch ( $metaplate['placement'] ){
				case 'prepend':
					$content = $engine->render( $metaplate['html']['code'], $template_data ) . $content;
					break;
				case 'append':
					$content .= $engine->render( $metaplate['html']['code'], $template_data );
					break;
				case 'replace':
					$content = $engine->render( str_replace( '{{content}}', $content, $metaplate['html']['code']), $template_data );
					break;
			}
		}

		// insert CSS
		if( !empty( $style_data ) ){
			$content = '<style>' . $style_data . '</style>' . $content;
		}
		// insert JS
		if( !empty( $script_data ) ){
			$content .= '<script type="text/javascript">' . $script_data . '</script>';
		}

		return $content;

	}

} 
