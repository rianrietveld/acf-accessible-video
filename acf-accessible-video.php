<?php
/*
Plugin Name: Accessible Video's using ACF Pro
Plugin URI:  http://rianrietveld.com
Description: Add accessible video's in your content, using Advanced Custom Fields Pro
Version:     0.3
Author:      Rian Rietveld
Author URI:  http://rianrietveld.com
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Domain Path: /languages
Text Domain: acfav

Accessible Video's using ACF Pro is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.

Accessible Video's using ACF Pro is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

*/

/**
* Defining constants
 *
 * @since 0.1
 */

define( 'ACFAV_VERSION','0.3' );

if ( ! defined( 'ACFAV_BASE_FILE' ) ) {
    define( 'ACFAV_BASE_FILE', __FILE__ );
}

if ( ! defined( 'ACFAV_BASE_DIR' ) ){
    define( 'ACFAV_BASE_DIR', dirname( ACFAV_BASE_FILE ) );
}

if ( ! defined( 'ACFAV_PLUGIN_URL' ) ){
    define( 'ACFAV_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
}

if ( ! defined( 'ACFAV_PLUGIN_PATH' ) ){
    define( 'ACFAV_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
}

/**
 * The text domain for the plugin
 *
 * @since 0.1
 */
define( 'ACFAV_DOMAIN' , 'acfav' );

/**
 * Load the text domain for translation of the plugin
 *
 * @since 0.1
 */
add_action( 'plugins_loaded', 'acfav_load_textdomain' );
function acfav_load_textdomain() {
	load_plugin_textdomain( 'acfav', false, plugin_basename( dirname( __FILE__ ) ) . '/languages' );
}

register_activation_hook( __FILE__, 'acfav_activation_check' );

require_once( ACFAV_PLUGIN_PATH . 'lib/group.php' );

if ( ! is_admin() ) {
	require_once( ACFAV_PLUGIN_PATH . 'lib/front-end.php' );
}


/**
 * Adds css
 *
 * @since 0.1
 */
add_action( 'wp_enqueue_scripts', 'acfav_css' );
function acfav_css() {

	wp_register_style( 'acfav-css', ACFAV_PLUGIN_URL .  'css/acfav.css' );
	wp_enqueue_style('acfav-css');
}

/**
 * Adds js
 *
 * @since 0.1
 */
add_action( 'wp_enqueue_scripts', 'acfav_js' );
function acfav_js() {

	wp_register_script( 'acfav-toggle', ACFAV_PLUGIN_URL .  'js/acfav.js', array( 'jquery' ), '0.1', true );
	wp_enqueue_script('acfav-toggle');
}


/**
 * Checks for activated Advanced Custom fields version 5 or higher
 *
 * @author Rian Rietveld
 * @since 0.1
 */
function acfav_activation_check() {

	if ( ! is_plugin_active( 'advanced-custom-fields-pro/acf.php' ) ) {

		wp_die( sprintf( __( 'You need the plugin %1$s, version 5 or greater for this plugin to make any sense.', ACFAV_DOMAIN ), '<a href="http://www.advancedcustomfields.com/pro">Advanced Custom Fields Pro</a>') );
	}

}

