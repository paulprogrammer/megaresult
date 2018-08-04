<?php
/*
Plugin Name: MegaResult Sports Result Display
Plugin URI: tbd
Version: 1.0.1
Author: Paul Williams
Author URI: tbd
*/
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

global $wpdb;

function mr_megaresult_shortcode_handler( $attrs, $content=null) {
  return "look, a shortcode!";
}
add_shortcode( 'megaresult', 'mr_megaresult_shortcode_handler' );

function mr_megaresult_admin_menu() {
  add_menu_page("MegaResult", "MegaResult", "manage_options", "megaresult-plugin", "mr_megaresult_admin_init","dashicons-awards");
}
function mr_megaresult_admin_init() {
  include_once 'megaresult_admin.php';
}
add_action("admin_menu", "mr_megaresult_admin_menu");

function mr_do_upsert_results() {
	if( !( isset($_POST['mr_upsert_results']) 
		   && wp_verify_nonce( $_POST['nds_add_user_meta_nonce'], 'nds_add_user_meta_form_nonce') )) {
		// Bad post or nonce.  ERROOOOOOR
		wp_die( __("Invalid nonce specified", "MegaResult"))
	}

	$input = $_FILES["results_file"]["tmp_name"];
	$contest_scores = 0;
	$handle = fopen($input, "r");
	while( !feof($handle)) {
		fgets($handle);
		$contest_scores++;
	}
}
add_action("mr_upsert_results","mr_do_upsert_results");"