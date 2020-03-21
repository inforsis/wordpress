<?php
/*
Plugin Name: WP Newsletter Register
Description: Wordpress plugin for listing and remove e-mails registered on site.
Version: 1.0
Author: Jadson Moreira
Author URI: https://jadson.dev/
Plugin URI: https://github.com/inforsis/wp-newsletter-register
*/


/**
 * Define some useful constants
 **/
define('WP_NEWSLETTER_REGISTER_VERSION', '1.0');
define('WP_NEWSLETTER_REGISTER_DIR', plugin_dir_path(__FILE__));
define('WP_NEWSLETTER_REGISTER_URL', plugin_dir_url(__FILE__));



/**
 * Load files
 * 
 **/
function wp_newsletter_register_load(){
		
    if(is_admin()) //load admin files only in admin
        require_once(WP_NEWSLETTER_REGISTER_DIR.'includes/admin.php');
        
    require_once(WP_NEWSLETTER_REGISTER_DIR.'includes/core.php');
}

wp_newsletter_register_load();



/**
 * Activation, Deactivation and Uninstall Functions
 * 
 **/

register_activation_hook(__FILE__, 'wp_newsletter_register_activation');
function wp_newsletter_register_activation() {
    
	add_action('admin_menu', 'add_item_menu_inr');

	add_db_table_inr();

	//echo '<script>alert ("a")</script>';

    //register uninstaller
    register_uninstall_hook(__FILE__, 'wp_newsletter_register_uninstall');
}

register_deactivation_hook(__FILE__, 'wp_newsletter_register_deactivation');

function wp_newsletter_register_deactivation() {

	//echo '<script>alert ("b")</script>';

	//remove_db_table_inr();
    
	// actions to perform once on plugin deactivation go here
	    
}

function wp_newsletter_register_uninstall(){
    //echo '<script>alert ("c")</script>';
    //actions to perform once on plugin uninstall go here
    remove_db_table_inr();
	    
}

function add_item_menu_inr(){
    add_menu_page('Newsletter lista', 'Newsletter lista', 'manage_options', 'wp-newsletter-register', 'wp_newsletter_output' );
}

function jal_install () {
   global $wpdb;

}

function add_db_table_inr() {
	global $wpdb;
	global $table_name;

   	$table_name = $wpdb->prefix . 'email'; 
	$charset_collate = $wpdb->get_charset_collate();

	$sql = "CREATE TABLE $table_name (
	  id mediumint(5) NOT NULL AUTO_INCREMENT,
	  time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
	  email varchar(99) NOT NULL,
	  nome varchar(99),
	  ativo int(1) NOT NULL,
	  ip varchar(13) NOT NULL,
	  PRIMARY KEY  (id)
	) $charset_collate;";

	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	dbDelta( $sql );
}

function remove_db_table_inr() {
	global $wpdb;
	global $table_name;

   	$table_name = $wpdb->prefix . 'email'; 

	$wpdb->query('DROP TABLE IF EXISTS $table_name');
}

wp_newsletter_register_activation();

?>