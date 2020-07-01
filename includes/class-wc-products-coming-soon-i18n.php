<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       http://aroundtheweb.in
 * @since      1.0.0
 *
 * @package    Wc_Products_Coming_Soon
 * @subpackage Wc_Products_Coming_Soon/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Wc_Products_Coming_Soon
 * @subpackage Wc_Products_Coming_Soon/includes
 * @author     Dipak Kumar Pusti <sipu.dipak@gmail.com>
 */
class Wc_Products_Coming_Soon_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'wc-pcs',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);
	}
}