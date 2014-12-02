<?php
/**
 * Validate and add additional Handlebars helpers
 *
 * @package   @caldera_metaplate
 * @author    Josh Pollock <Josh@JoshPress.net>
 * @license   GPL-2.0+
 * @link      
 * @copyright 2014 Josh Pollock
 */

namespace caldera\metaplate;


class helper_loader {
	/**
	 * @var obj|\Handlebars\Handlebars
	 */
	public $handlebars;
	function __construct( $handlebars, $helpers ) {
		if ( is_a( $handlebars, 'Handlebars\Handlebars' ) ) {
			$this->handlebars = $handlebars;
			$this->add_helpers( $helpers );


			return $this->handlebars;
		}

	}

	private function add_helpers( $helpers ) {
		foreach( $helpers as $helper ) {
			$helper = $this->validate_helper_input( $helper );
			if ( is_array( $helper ) ) {
				$this->add_helper( $helper );
			}
		}
	}

	private function add_helper( $helper ) {
		$this->handlebars->addHelper(
			$helper[ 'name' ],
			array(
				$helper[ 'class' ],
				$helper[ 'callback' ]
			)
		);
	}

	/**
	 * Make sure each helper passed in is valid.
	 *
	 * @todo ensure helper class/callback are callable. Preferably, without creating object of the class.
	 *
	 * @param array $helper Array to add helper with.
	 *
	 * @return bool|array Returns the array if valid, false if not.
	 */
	private function validate_helper_input( $helper ) {
		if ( ! is_array( $helper ) || empty( $helper ) ) {
			return false;
		}

		if ( !  isset( $helper[ 'name' ] ) || ! isset( $helper[ 'class' ]  ) ) {
			return false;
		}

		//if not set, set callback name to "helper"
		if ( ! isset( $helper[ 'callback' ] ) ) {
			$helper[ 'callback' ] = 'helper';
		}

		return $helper;

	}


} 
