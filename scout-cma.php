<?php
/**
 * Plugin Name: CMA Form
 * Plugin URI: https://github.com/abarrett86
 * Description: 
 * Version: 0.1.0
 * Author: Alex Barrett
 * Author URI: https://github.com/abarrett86
 */
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );


define('CMA_API_OPTION', 'cma_api_key');
define('CMA_API_SUBMIT_TEXT', 'cma_submit_text_key');
define('CMA_SUCCESS_MESSAGE_OPTION', 'cma_success_message');
define('CMA_FAIL_MESSAGE_OPTION', 'cma_fail_message');
define('CMA_BAD_ADDRESS_MESSAGE_OPTION', 'cma_bad_address_message');

add_action('wp_enqueue_scripts','scout_cma_js');
function scout_cma_js() {
    wp_register_script( 'scout-cma-js', plugins_url( '/js/scout-cma.js', __FILE__ ), array( 'jquery' ), '', true);
    wp_register_script( 'scout-cma-widget-js', plugins_url( '/js/ScoutCMAWidget.js', __FILE__ ));

    wp_localize_script( 'scout-cma-widget-js', 'cma_options', array(
        'ajax_url' => admin_url( 'admin-ajax.php' ),
        'submit_text' => get_option(CMA_API_SUBMIT_TEXT)
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
    add_option( CMA_API_SUBMIT_TEXT, 'SEND ME THE VALUE OF MY HOME', false, true );
    add_option( CMA_SUCCESS_MESSAGE_OPTION, 'Thank-you. Please check your email for your Quick CMA.', false, true );
    add_option( CMA_FAIL_MESSAGE_OPTION, 'Whoops, something went wrong. Please try again.', false, true );
    add_option( CMA_BAD_ADDRESS_MESSAGE_OPTION, 'Your address could not be found.  Please check the address you entered and try again.', false, true );
}

function cma_deactivated(){
    delete_option( CMA_API_OPTION, '', false, true );
    delete_option( CMA_API_SUBMIT_TEXT, '', false, true );
    delete_option( CMA_SUCCESS_MESSAGE_OPTION, '', false, true );
    delete_option( CMA_FAIL_MESSAGE_OPTION, '', false, true );
    delete_option( CMA_BAD_ADDRESS_MESSAGE_OPTION, '', false, true );
}

add_action('admin_menu', 'cma_plugin_setup_menu');
 
function cma_plugin_setup_menu(){
    add_menu_page( 'CMA Plugin Page', 'CMA Plugin', 'manage_options', 'test-plugin', 'admin_init' );
}


function admin_init(){
    require('scout-cma-admin.php');
}

add_action( 'wp_ajax_cma_form', 'wp_ajax_cma_form' );

function wp_ajax_cma_form() {

    $api_key = get_option(CMA_API_OPTION);

    $curl = 'http://cloudcma.com/cmas/widget?api_key=' . urlencode($api_key) . '&email_to=' . urlencode($_REQUEST["email_to"]) . '&address=' . urlencode($_REQUEST["address"]) . '&sqft=' . urlencode($_REQUEST["sqft"]) . '&name=' . urlencode($_REQUEST["name"]);

    $ch = curl_init(); 
    
    // set url 
    curl_setopt($ch, CURLOPT_URL, ($curl)); 

    //return the transfer as a string 
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 

    // $output contains the output string 
    $output = curl_exec($ch); 

    $curlInfo = curl_getinfo($ch);

    // close curl resource to free up system resources 
    curl_close($ch);      

    $response = array();

    $response["status"] = "fail";
    $response["info"] = print_r($curlInfo, true);
    $response["output"] = print_r($output, true);

    switch($curlInfo["http_code"]){
        case "200":
            $response["status"] = "success";
            $response["message"] = get_option(CMA_SUCCESS_MESSAGE_OPTION);
        break;

        case "400":
            $response["message"] = get_option(CMA_BAD_ADDRESS_MESSAGE_OPTION);
        break;

        default:
            $response["message"] = get_option(CMA_FAIL_MESSAGE_OPTION);
        break;
    } 

    echo json_encode($response);
    
	wp_die(); // this is required to terminate immediately and return a proper response
}