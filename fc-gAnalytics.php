<?php
/**
 * Created by PhpStorm.
 * User: fcarrascosa
 */
/*
Plugin Name: Google Analytics for WordPress
Plugin URI:  https://labs.fcarrascosa.es/wordpress/plugins/gAnalytics/
Description: This plug-in Allows you to embed your Google Analytics code into your website.
Version:     1.0.1
Author:      Fernando Carrascosa
Author URI:  http://fcarrascosa.es/
License:     GPL3.0
License URI: https://www.gnu.org/licenses/gpl-3.0.en.html
Text Domain: fcarrascosa
Domain Path: /languages
*/

// Make sure we don't expose any info if called directly

if ( !function_exists( 'add_action' ) ){
    echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
    exit;
}

define ( 'FC_GOOGLE_ANALYTICS__PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define ( 'FC_GOOGLE_ANALYTICS__PLUGIN_DIR', plugin_dir_path( __FILE__ ) );

require_once( FC_GOOGLE_ANALYTICS__PLUGIN_DIR . 'class.fcarrascosa.ganalytics.admin.php' );
require_once( FC_GOOGLE_ANALYTICS__PLUGIN_DIR . 'class.fcarrascosa.ganalytics.front.php' );
