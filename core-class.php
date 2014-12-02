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
	 * @var      string
	 */
	protected $plugin_slug = 'metaplate';
	/**
	 * @var      object
	 */
	protected static $instance = null;
	/**
	 * @var      array
	 */
	protected $plugin_screen_hook_suffix = array();
	/**
	 * Initialize the plugin by setting localization, filters, and administration functions.
	 *
	 */
	private function __construct() {

		// Load plugin text domain
		add_action( 'init', array( $this, 'load_plugin_textdomain' ) );

		// Load admin style sheet and JavaScript.
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_stylescripts' ) );


	}

	/**
	 * Return an instance of this class.
	 *
	 *
	 * @return    object    A single instance of this class.
	 */
	public static function get_instance() {

		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	/**
	 * Load the plugin text domain for translation.
	 *
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain( $this->plugin_slug, FALSE, basename( MTPT_PATH ) . '/languages');

	}
	
	/**
	 * Register and enqueue admin-specific style sheet.
	 *
	 *
	 * @return    null
	 */
	public function enqueue_admin_stylescripts() {

		$screen = get_current_screen();

		
		if( false !== strpos( $screen->base, 'metaplate' ) ){

			wp_enqueue_style( 'metaplate-core-style', MTPT_URL . '/assets/css/styles.css' );
			wp_enqueue_style( 'metaplate-baldrick-modals', MTPT_URL . '/assets/css/modals.css' );
			wp_enqueue_script( 'metaplate-wp-baldrick', MTPT_URL . '/assets/js/wp-baldrick-full.min.js', array( 'jquery' ) , false, true );
			wp_enqueue_script( 'jquery-ui-autocomplete' );
			wp_enqueue_style( 'wp-color-picker' );
			wp_enqueue_script( 'wp-color-picker' );
						
			if( !empty( $_GET['edit'] ) ){
				wp_enqueue_style( 'metaplate-codemirror-style', MTPT_URL . '/assets/css/codemirror.css' );
				wp_enqueue_script( 'metaplate-codemirror-script', MTPT_URL . '/assets/js/codemirror.js', array( 'jquery' ) , false );
			}

			wp_enqueue_script( 'metaplate-core-script', MTPT_URL . '/assets/js/scripts.min.js', array( 'metaplate-wp-baldrick' ) , false );

		
		}


	}


}

