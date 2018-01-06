<?php
/**
 * Plugin Name: CMA Form
 * Plugin URI: https://github.com/abarrett86
 * Description: 
 * Version: 1.0.0
 * Author: Alex Barrett
 * Author URI: https://github.com/abarrett86
 * License: GPL2
 */
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

add_action( 'wp_head', 'scout_header' );
function scout_header() {

}

add_action('wp_enqueue_scripts','scout_cma_js');
function scout_cma_js() {
    wp_enqueue_script( 'scout-cma-js', plugins_url( '/js/scout-cma.js', __FILE__ ));
}

add_action( 'wp_enqueue_scripts', 'scout_cma_css' );
function scout_cma_css() {
	wp_enqueue_style( 'scount-cma-css', plugins_url( '/css/scout-cma.css', __FILE__ ));
}

error_log("here");
add_shortcode('scoutcma', 'get_scout_cma');
function get_scout_cma(){
    ob_start();
    require('scout-cma-widget.php');
    $var=ob_get_contents(); 
    ob_end_clean();
    return $var;
}
