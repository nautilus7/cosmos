<?php

//Remove the Toolbar from the Front End
show_admin_bar(false);

// clean Wordpress Head Section
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);
remove_action('wp_head', 'wp_generator');
remove_action('wp_head', 'feed_links', 2);
remove_action('wp_head', 'feed_links_extra', 3);

// Remove Recent Comments Widget CSS Style
function cosmos_remove_recent_comments_style() {

	global $wp_widget_factory;

	if ( isset($wp_widget_factory->widgets['WP_Widget_Recent_Comments']) ) {

		remove_action('wp_head', array($wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style'));
	}
}
add_action('widgets_init', 'cosmos_remove_recent_comments_style', 10, 0);


function cosmos_remove_img_dimensions($html) {

	return preg_replace('/(width|height)="\d*"\s/', '', $html); 
}
add_filter('the_content'         , 'cosmos_remove_img_dimensions');
add_filter('post_thumbnail_html' , 'cosmos_remove_img_dimensions');
add_filter('image_send_to_editor', 'cosmos_remove_img_dimensions');

// Nice redirect of the search page
function cosmos_search_redirect() {

	global $wp_rewrite;

	if ( $wp_rewrite->using_permalinks() && is_search() && !empty($_GET['s']) ) {

		wp_redirect(home_url('/search/' . str_replace(array(' ', '%20'), array('+', '+'), urlencode(get_query_var('s')))), 301);
		exit();
	}
}
add_action('template_redirect', 'cosmos_search_redirect');
