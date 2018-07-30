<?php
/*
Plugin Name: MegaResult Sports Result Display
Plugin URI: tbd
Version: 1.0.0
Author: Paul Williams
Author URI: tbd
*/

class WP_page_megaresult {

	private static $instance;

  private static $name = "MegaResult Sports Results";

	public static function get_instance() {
		if( null == self::$instance) {
			self::$instance = new WP_page_megaresult();
		}
		return self::$instance;
	}

	private function __construct() {
		// Add a filter to the attributes metabox to inject template into the cache.
		if ( version_compare( floatval( get_bloginfo( 'version' ) ), '4.7', '<' ) ) {
      wp_die("Not compatible with WordPress versions < 4.7");
		} else {
			// Add a filter to the wp 4.7 version attributes metabox
			add_filter(
				'theme_page_templates', array( $this, 'add_new_template' )
			);
		}
	}

  // Add a filter to the save post to inject out template into the page cache
    add_filter(
      'wp_insert_post_data', 
      array( $this, 'register_project_templates' ) 
    );


    // Add a filter to the template include to determine if the page has our 
    // template assigned and return it's path
    add_filter(
      'template_include', 
      array( $this, 'view_project_template') 
    );

  /**
   * Adds our template to the page dropdown for v4.7+
   *
   */
  public function add_new_template( $posts_templates ) {
    $posts_templates = array_push( $posts_templates, self::$name );
    return $posts_templates;
  }

  /**
   * Checks if the template is assigned to the page
   */
  public function view_project_template( $template ) {
    
    // Get global post
    global $post;

    // Return template if post is empty
    if ( ! $post ) {
      return $template;
    }

    // Return default template if we don't have a custom one defined
    if ( self::$name !== get_post_meta( $post->ID, '_wp_page_template', true ) ) {
      return $template;
    } 

    $file = plugin_dir_path( __FILE__ ) . "/template_megaresult.php";
    // Just to be safe, we check if the file exist first
    if ( file_exists( $file ) ) {
      return $file;
    } else {
      echo $file;
    }

    // Return template
    return $template;
  }

} 
add_action( 'plugins_loaded', array( 'WP_page_megaresult', 'get_instance' ) );