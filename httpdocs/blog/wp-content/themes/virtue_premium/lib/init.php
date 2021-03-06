<?php
/**
 * virtue initial setup and constants
 */
function kadence_setup() {
 global $pagenow; 
  register_nav_menus(array(
    'primary_navigation' => __('Primary Navigation', 'virtue'),
    'secondary_navigation' => __('Secondary Navigation', 'virtue'),
    'mobile_navigation' => __('Mobile Navigation', 'virtue'),
    'topbar_navigation' => __('Topbar Navigation', 'virtue'),
    'footer_navigation' => __('Footer Navigation', 'virtue'),
  ));
  add_theme_support( 'title-tag' );
  add_theme_support('post-thumbnails');
  add_image_size( 'widget-thumb', 80, 50, true );
  add_post_type_support( 'attachment', 'page-attributes' );
  add_theme_support( 'automatic-feed-links' );
  add_editor_style('/assets/css/editor-style-virtue.css');

  if ( is_admin() && 'themes.php' == $pagenow && isset( $_GET['activated'] ) ) {
      wp_redirect(admin_url("themes.php?page=kt_api_manager_dashboard"));
  }
  define( 'VIRTUE_VERSION', '3.8.9' );
}
add_action('after_setup_theme', 'kadence_setup');

if ( ! function_exists( '_wp_render_title_tag' ) ) :
  function virtue_render_title() {
    ?>
    <title><?php wp_title( '|', true, 'right' ); ?></title>
    <?php
  }
  add_action( 'wp_head', 'virtue_render_title' );
endif;


/**
 *Virtue SEO
 */
function kadence_wp_title( $title) {
  if(kadence_seo_switch()) {
    global $virtue_premium, $post;
    if ( get_post_meta( get_the_ID(), '_kad_seo_title', true )) { 
        $new_title = get_post_meta( get_the_ID(), '_kad_seo_title', true );
    }
    if(!empty($new_title)) { 
       $title = $new_title;
    } else if(!empty($virtue_premium['seo_sitetitle'])) {
        $title = $virtue_premium['seo_sitetitle'];
    }
  }

  return $title;
}
add_filter( 'pre_get_document_title', 'kadence_wp_title', 10);

function kt_fav_output_seo(){
  // Keep for fallback
  global $virtue_premium, $post;
  if(kadence_seo_switch()) {
      if ( get_post_meta( get_the_ID(), '_kad_seo_description', true )) { 
        echo '<meta name="description" content="'.get_post_meta( get_the_ID(), '_kad_seo_description', true ).'">';
      } else if (!empty($virtue_premium['seo_sitedescription'])) {
        echo '<meta name="description" content="'.$virtue_premium['seo_sitedescription'].'">';
      }
    }
  if(isset($virtue_premium['virtue_custom_favicon']['url']) && !empty($virtue_premium['virtue_custom_favicon']['url']) ) {
    echo '<link rel="shortcut icon" type="image/x-icon" href="'. esc_url($virtue_premium['virtue_custom_favicon']['url']).'" />';
  }
}
add_action('wp_head', 'kt_fav_output_seo', 5);

