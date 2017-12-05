<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       placeholder
 * @since      1.0.0
 *
 * @package    Woocommerce_Order_Tags
 * @subpackage Woocommerce_Order_Tags/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Woocommerce_Order_Tags
 * @subpackage Woocommerce_Order_Tags/includes
 * @author     Spencer Walden <spencer@chocolab.com.au>
 */
class Woocommerce_Order_Tags_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'woocommerce-order-tags',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
