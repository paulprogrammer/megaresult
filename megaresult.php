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
  add_menu_page("MegaResult", "MegaResult", "manage_options", "megaresult-plugin/megaresult-admin.php", "mr_megaresult_admin_init");
}
function mr_megaresult_admin_init() {

}
add_action("admin_menu", "mr_megaresult_admin_menu");
