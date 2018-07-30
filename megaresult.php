<?php
/*
Plugin Name: MegaResult Sports Result Display
Plugin URI: tbd
Version: 1.0.0
Author: Paul Williams
Author URI: tbd
*/


function mr_megaresult_shortcode_handler( $attrs, $content=null) {
  return "look, a shortcode!"
}

add_shortcode( 'megaresult', 'mr_megaresult_shortcode_handler' );