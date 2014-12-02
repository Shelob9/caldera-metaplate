<?php

/**
 * Metaplate.
 *
 * @package   Metaplate
 * @author    David <david@digilab.co.za>
 * @license   GPL-2.0+
 * @link      
 * @copyright 2014 David
 */

use Handlebars\Handlebars;

/**
 * Plugin class.
 * @package Metaplate
 * @author  David <david@digilab.co.za>
 */
class Metaplate {

	/**
	 * Initialize the plugin by setting localization, filters, and administration functions.
	 *
	 */
	function __construct() {

		// Load plugin text domain
		add_action( 'init', array(
			caldera\metaplate\init::get_instance(),
			'load_plugin_textdomain'
			)
		);

		//render output
		$render = new caldera\metaplate\render();
		// add filter.
		add_filter( 'the_content', array( $render, 'render_metaplate' ), 9 );

		if ( is_admin() ) {
			new caldera\metaplate\admin\settings();
			new caldera\metaplate\admin\page();
		}


	}

}

