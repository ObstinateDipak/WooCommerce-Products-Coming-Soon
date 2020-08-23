<?php

/**
 *
 * @link              http://aroundtheweb.in
 * @since             1.0.0
 * @package           Wc_Products_Coming_Soon
 *
 * @wordpress-plugin
 * Plugin Name:       Products Coming Soon
 * Description:       Enable nice coming soon templates for your WooCommerce products when they are out of stock temporarily.
 * Version:           0.0.1
 * Author:            Dipak Kumar Pusti
 * Author URI:        https://profiles.wordpress.org/dipakbbsr/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wc-pcs
 * Domain Path:       /languages
 *
 * WC requires at least: 3.0
 * WC tested up to: 4.4.1
 *
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'WCP_CS_VERSION', '0.0.1' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-wc-products-coming-soon.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function wc_pcs_initialize() {
	$plugin = new Wc_Products_Coming_Soon();
	$plugin->run();
}
wc_pcs_initialize();