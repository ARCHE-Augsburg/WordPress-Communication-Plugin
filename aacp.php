<?php

/**
 * @link              http://example.com
 * @since             1.0.0
 * @package           Plugin_Name
 *
 * @wordpress-plugin
 * Plugin Name:       ARCHE Augsburg Communication Plugin
 * Plugin URI:        https://arche-augsburg.de
 * Description:       For communication issues
 * Version:           1.0.2
 * Author:            Christian Doernen, Michael Machus
 * Author URI:        
 * License:           
 * License URI:       
 * Text Domain:       ARCHE Augsburg Communication Plugin
 * Domain Path:       /languages
 */

define( 'AACP_PLUGIN_BASE_FILE', __FILE__ );

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently pligin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'PLUGIN_NAME_VERSION', '1.0.2' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-plugin-name-activator.php
 */
function activate_aacp() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-aacp-activator.php';
	aacp_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-plugin-name-deactivator.php
 */
function deactivate_aacp() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-aacp-deactivator.php';
	aacp_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_aacp' );
register_deactivation_hook( __FILE__, 'deactivate_aacp' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-aacp.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_aacp() {

	$plugin = new aacp_Core();
	$plugin->run();

}
run_aacp();
