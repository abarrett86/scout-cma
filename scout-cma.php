<?php
/**
 * Plugin Name: CMA Form
 * Plugin URI: https://github.com/abarrett86
 * Description: 
 * Version: 0.0.1
 * Author: Alex Barrett
 * Author URI: https://github.com/abarrett86
 * License: GPL2
 */
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );


define('CMA_API_OPTION', 'cma_api_key');
define('CMA_SUCCESS_MESSAGE_OPTION', 'cma_success_message');
define('CMA_FAIL_MESSAGE_OPTION', 'cma_fail_message');

add_action('wp_enqueue_scripts','scout_cma_js');
function scout_cma_js() {
    wp_register_script( 'scout-cma-js', plugins_url( '/js/scout-cma.js', __FILE__ ), array( 'jquery' ), '', true);
    wp_register_script( 'scout-cma-widget-js', plugins_url( '/js/ScoutCMAWidget.js', __FILE__ ));

    wp_localize_script( 'scout-cma-widget-js', 'cma_options', array(
        'cma_api_key' => get_option(CMA_API_OPTION),
        'cma_success_message_key' => get_option(CMA_SUCCESS_MESSAGE_OPTION),
        'cma_fail_message_key' => get_option(CMA_FAIL_MESSAGE_OPTION)
    ));

    wp_enqueue_script( 'scout-cma-js' );
    wp_enqueue_script( 'scout-cma-widget-js' );
}

add_action( 'wp_enqueue_scripts', 'scout_cma_css' );
function scout_cma_css() {
	wp_enqueue_style( 'scount-cma-css', plugins_url( '/css/scout-cma.css', __FILE__ ));
}

add_shortcode('scoutcma', 'get_scout_cma');
function get_scout_cma(){
    ob_start();
    require('scout-cma-widget.php');
    $var=ob_get_contents(); 
    ob_end_clean();
    return $var;
}

register_activation_hook( __FILE__, 'cma_activated' );
register_deactivation_hook( __FILE__, 'cma_deactivated');

function cma_activated(){
    add_option( CMA_API_OPTION, '', false, true );
    add_option( CMA_SUCCESS_MESSAGE_OPTION, '', false, true );
    add_option( CMA_FAIL_MESSAGE_OPTION, '', false, true );
}

function cma_deactivated(){
    delete_option( CMA_API_OPTION, '', false, true );
    delete_option( CMA_SUCCESS_MESSAGE_OPTION, '', false, true );
    delete_option( CMA_FAIL_MESSAGE_OPTION, '', false, true );
}

add_action('admin_menu', 'cma_plugin_setup_menu');
 
function cma_plugin_setup_menu(){
    add_menu_page( 'CMA Plugin Page', 'CMA Plugin', 'manage_options', 'test-plugin', 'admin_init' );
}


function admin_init(){
    require('scout-cma-admin.php');
}