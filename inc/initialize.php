<?php

// Enqueue Theme Stylesheets
function cosmos_enqueue_styles() {

  wp_enqueue_style('btsp'        , get_template_directory_uri() . '/css/bootstrap.css'           , array(), null, 'all');
  wp_enqueue_style('btsp-resp'   , get_template_directory_uri() . '/css/bootstrap-responsive.css', array(), null, 'all');
  wp_enqueue_style('font-awesome', get_template_directory_uri() . '/css/font-awesome.css'        , array(), null, 'all');
  wp_enqueue_style('style'       , get_template_directory_uri() . '/style.css'                   , array(), null, 'all');
}
add_action('wp_enqueue_scripts', 'cosmos_enqueue_styles');

// Enqueue Theme Scripts
function cosmos_enqueue_scripts() {

  // Load jquery from Google CDN (protocol relative) with local fallback when not available
  if ( false === ($url = get_transient('jquery_url')) ) {

    // Check if Google CDN is working
    $url = ( is_ssl() ? 'https:' : 'http:' ) . '//ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js';

    // Load local jquery if Google down
    if ( 200 != wp_remote_retrieve_response_code(wp_remote_head($url)) ) {

    	$url = get_template_directory_uri() . '/js/vendor/jquery-1.7.2.min.js';
    }

    // Cache the result for 5 minutes to save bandwidth
    set_transient('jquery_url', $url, 60*5);
  }

  // Deregister Wordpress' jquery and register theme's copy in the footer
  wp_deregister_script('jquery');
  wp_register_script('jquery', $url, array(), null, true);

  // Load other theme scripts here
  wp_enqueue_script('modernizr', get_template_directory_uri() . '/js/vendor/modernizr-2.5.3.min.js', array(        ), null, false);
  wp_enqueue_script('bootstrap', get_template_directory_uri() . '/js/vendor/bootstrap.min.js'      , array('jquery'), null, true );
  wp_enqueue_script('main'     , get_template_directory_uri() . '/js/main.js'                      , array('jquery'), null, true );
}
add_action('wp_enqueue_scripts', 'cosmos_enqueue_scripts');

// Register Image Sizes


//Add Support for Post-Thumbnails
add_theme_support('post-thumbnails');
