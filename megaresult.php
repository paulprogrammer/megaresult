<?php
/*
Plugin Name: MegaResult Sports Result Display
Plugin URI: tbd
Version: 1.0.0
Author: Paul Williams
Author URI: tbd
*/

class WP_post_megaresult {

  private static $instance;

  private static $name = "MegaResult Sports Results";

  public static function get_instance() {
    if( null == self::$instance) {
      self::$instance = new WP_post_megaresult();
    }
    return self::$instance;
  }

  private function __construct() {
    // Add a filter to the attributes metabox to inject template into the cache.
    if ( version_compare( floatval( get_bloginfo( 'version' ) ), '4.7', '<' ) ) {
      wp_die("Not compatible with WordPress versions < 4.7");
    } 

    add_action('add_meta_boxes',array($this,'megaresult_metabox'));
    add_action('save_post',array($this,'save_megaresult_post_template',10,2));

    // Add a filter to the template include to determine if the page has our 
    // template assigned and return it's path
    add_filter(
      'template_include', 
      array( $this, 'megaresult_template') 
    );
  }

  public function megaresult_metabox($postType) {         
    if(get_option('wp_custom_post_template') == ''){ //get option value
      $postType_title = 'post';
      $postType_arr[] = $postType_title;
    }else{
      $postType_title = get_option('wp_custom_post_template');
      $postType_arr = explode(',',$postType_title);
    }
    if(in_array($postType, $postType_arr)){
      add_meta_box(
        'postparentdiv',
        __('Post Template'),
        array($this,'megaresult_template_meta_box'),
        $postType,
        'side', 
        'core'
      );
    }
  }

  public function megaresult_template_meta_box($post) {
    if ( $post->post_type != 'page' && 0 != count( wp_get_post_custom_templates() ) ) {
      $template = get_post_meta($post->ID,'_post_template',true);
    ?>
      <label class="screen-reader-text" for="post_template"><?php _e('Post Template') ?></label>
      <select name="post_template" id="post_template">
        <option value='default'><?php _e('Default Template'); ?></option>
        <?php $this->wp_custom_post_template_dropdown($template); ?>
      </select>
      <p><i><?php _e( 'Some themes have custom templates you can use for single posts template selecting from dropdown.'); ?></i></p>
    <?php
    }
  }

  protected function get_post_custom_templates() {
    if(function_exists('wp_get_themes')){
      $themes = wp_get_themes();
    }else{
      $themes = get_themes();
    }                       
    $theme = get_option( 'template' );
    $templates = $themes[$theme]['Template Files'];
    $post_templates = array();
  
    if ( is_array( $templates ) ) {
      $base = array( trailingslashit(get_template_directory()), trailingslashit(get_stylesheet_directory()) );
  
      foreach ( $templates as $template ) {
        $basename = str_replace($base, '', $template);
        if ($basename != 'functions.php') {
         // don't allow template files in subdirectories
         if ( false !== strpos($basename, '/') )
           continue;
 
         $template_data = implode( '', file( $template ));
 
         $name = '';
         if ( preg_match( '|WP Post Template:(.*)$|mi', $template_data, $name ) )
           $name = _cleanup_header_comment($name[1]);
 
         if ( !empty( $name ) ) {
           $post_templates[trim( $name )] = $basename;
         }
       }
     }
   }
   return $post_templates;
 }
 
 protected function custom_post_template_dropdown( $default = '' ) {
  $templates = $this->get_post_custom_templates();
  ksort( $templates );
  foreach (array_keys( $templates ) as $template ) {
    if ( $default == $templates[$template] )
      $selected = " selected='selected'";
    else
      $selected = '';
    echo "\n\t<option value='".$templates[$template]."' $selected>$template</option>";
   }
 }


  public function save_megaresult_post_template($post_id,$post) {
    if ($post->post_type !='page' && !empty($_POST['post_template']))
      update_post_meta($post->ID,'_post_template',$_POST['post_template']);
  }

  /**
   * Checks if the template is assigned to the page
   */
  public function megaresult_template( $template ) {
    
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