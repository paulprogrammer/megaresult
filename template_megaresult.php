<?php
/**
 * Template Name: MegaResult Sports Results Page
 */
wp_enqueue_script("datatables",get_template_directory()."/js/datatables.min.js");

function build_result_tables($results) {
  // Assume the first line is a field header list.
  $headers = fgetcsv($results);
  echo '<table class="results"><thead><tr>';
  foreach( $headers as $header) {
    echo "<th>".$header."</th>";
  }
  echo '</tr></thead><tbody>';

  while(($result = fgetcsv($results)) !== false) {
    echo '<tr>';
    foreach($result as $value) {
      echo " <td>$result</td>";
    }
    echo '</tr>\n';
  }

  echo '</tbody></table>'
}

?>
<article id="<?php the_ID(); ?>" <?php post_class(); ?>>
  <a href="<?php the_permalink(); ?>" rel="bookmark">
    <?php 
    if ( has_post_thumbnail() && ! post_password_required() && ! is_attachment() ) {  // check if the post has a Post Thumbnail assigned to it. 
      echo '<div class="featured-image">';
      the_post_thumbnail('lighthouse-full-width');
      echo '</div>';
    } 
    ?>
  </a>
  <header class="entry-header">
    <span class="screen-reader-text"><?php the_title(); ?></span>
    <h1 class="entry-title"><?php the_title(); ?></h1>
    <div class="entry-meta"></div>
  </header>
  <div class="entry-content">
    <?php the_content(); 

    $results_file = get_post_meta(the_ID(), "results_file", true);
    if(! preg_match("/^https?:\/\//", $results_file)) {
      $results_file = get_home_path() . $results_file;
    }
    $results = fopen($results_file, "rb");
    if( ! $results) {
      echo "Results Not Available";
    } else {
      build_result_tables($results);
      fclose($results);
    }

    wp_link_pages(array(
      'before'=>'<div class="page-links">'.esc_html__('Pages:','lighthouse'),
      'after'=>'</div>',
    ));
    ?>
  </div>
  <footer class="entry-footer">
    <?php edit_post_link( esc_html__("Edit",'lighthouse'), '<span class="edit-link">','</span>');?>
  </footer>
</article>