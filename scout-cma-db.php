<?php 
function cma_db_install(){

    $charset_collate = $wpdb->get_charset_collate();

    $table_name = CMA_DB_TABLE; 

    $sql = "CREATE TABLE $table_name (
    id mediumint(9) NOT NULL AUTO_INCREMENT,
    api_key text NOT NULL,
    PRIMARY KEY  (id)
    ) $charset_collate;";

    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta( $sql );

}

function cma_db_prime(){
    global $wpdb;
        
    $table_name = CMA_DB_TABLE;

    $wpdb->insert( 
        $table_name, 
        array( 
            'id' => 1, 
            'api_key' => ""
        ) 
    );
}



function cma_db_uninstall(){
    
}