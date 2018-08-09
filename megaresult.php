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

add_action("admin_post_upsert_results","mr_do_upsert_results");
add_action("admin_menu", "mr_megaresult_admin_menu");

add_shortcode( 'megaresult', 'mr_megaresult_shortcode_handler' );

# register the admin menu on the sidebar
function mr_megaresult_admin_menu() {
  add_menu_page("MegaResult", "MegaResult", "manage_options", "megaresult-plugin", "mr_megaresult_admin_init","dashicons-awards");
}

# Display the admin config screen
function mr_megaresult_admin_init() {
  include_once 'megaresult_admin.php';
}

# upsert the contest results
function mr_do_upsert_results() {
	check_admin_referrer("upsert_results", "mr_upsert_results_nonce");

	$input = $_FILES["results_file"]["tmp_name"];
	$contest_scores = 0;
	$handle = fopen($input, "r");
	while( !feof($handle)) {
		fgets($handle);
		$contest_scores++;
	}
	echo $contest_scores;
}

# display results on a page on demand.
function mr_megaresult_shortcode_handler( $attrs, $content=null) {
  return "look, a shortcode!";
}