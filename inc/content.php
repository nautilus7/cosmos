<?php

// Set post excerpt length in words (default is 55)
function cosmos_excerpt_length() {

	return 55;
}
add_filter('excerpt_length', 'cosmos_excerpt_length', 10, 0);

// Customize the Post Excerpt More
function cosmos_excerpt_more() {

	//return '<a href="' . esc_url(get_permalink()) . '" title="" class="btn">' . esc_html__('Continue Reading', 'cosmos') . '</a>';
	return '&hellip;';
}
add_filter('excerpt_more', 'cosmos_excerpt_more', 10, 0);

// Display Post Author
function cosmos_post_author($args = '') {

	$args = wp_parse_args($args, array(
		'text' => '',
		'link' => true,
		'icon' => 'user',
		'before' => '<span class="post-author">',
		'after' => '</span>'
	));

	extract($args, EXTR_SKIP);

	if ( $link ) {

		$links  = '<a href="' . esc_attr(get_author_posts_url(get_the_author_meta('ID'))) . '" title="';
		$links .= esc_attr__('View all posts by ', 'cosmos') . esc_attr(get_the_author()) . '">';
		$links .= esc_html(get_the_author()) . '</a>';
	}

	else {

		$links = esc_html(get_the_author());
	}

	$output  = $before;
	$output .= ( empty($icon) ) ? '' : '<i class="icon-'. $icon . '"></i> ';
	$output .= esc_html($text) . $links;
	$output .= $after;

	echo $output;
}

// Display Post Date
function cosmos_post_date($args = '') {

	$args = wp_parse_args($args, array(
		'text' => '',
		'relative' => 7,
		'icon' => 'time',
		'before' => '<span class="post-date">',
		'after' => '</span>'
	));

	extract($args, EXTR_SKIP);

	if ( 60*60*24*$relative > ( current_time('timestamp') - get_the_time('U') ) ) {

		$format = human_time_diff(get_the_time('U'), current_time('timestamp')) . __(' ago', 'cosmos');
	}

	else {

		$format = get_the_date();
	}

	$output  = $before;
	$output .= ( empty($icon) ) ? '' : '<i class="icon-'. $icon . '"></i> ';
	$output .= esc_html($text);
	$output .= '<time datetime="' . esc_attr(get_the_time('c')) . '">' . esc_html($format) . '</time>';
	$output .= $after;

	echo $output;
}

// Display Post Category
function cosmos_post_category($args = '') {

	$args = wp_parse_args($args, array(
		'text' => '',
		'sep' => ', ',
		'icon' => 'bookmark',
		'before' => '<span class="post-category">',
		'after' => '</span>'
	));

	extract($args, EXTR_SKIP);
	$categories = get_the_category();

	if ( $categories ) {

		foreach ( $categories as $category ) {

			$url = get_category_link($category->term_id);
			$name = $category->name;
			$title = __('View all posts in ', 'cosmos') . $name;
			$links[] = '<a href="' . esc_attr($url) . '" title="' . esc_attr($title) . '">' . esc_html($name) . '</a>';
		}

		$output  = $before;
		$output .= ( empty($icon) ) ? '' : '<i class="icon-'. $icon . '"></i> ';
		$output .= esc_html($text) . join($sep, $links);
		$output .= $after;

		echo $output;
	}
}

// Display Post Tags
function cosmos_post_tag($args = '') {

	$args = wp_parse_args($args, array(
		'text' => '',
		'sep' => ', ',
		'icon' => 'tags',
		'before' => '<span class="post-tags">',
		'after' => '</span>'
	));

	extract($args, EXTR_SKIP);
	$tags = get_the_tags();

	if ( $tags ) {

		foreach ( $tags as $tag ) {

			$url = get_tag_link($tag->term_id);
			$name = $tag->name;
			$title = __('View all posts tagged ', 'cosmos') . $name;
			$links[] = '<a href="' . esc_attr($url) . '" title="' . esc_attr($title) . '">' . esc_html($name) . '</a>';
		}

		$output  = $before;
		$output .= ( empty($icon) ) ? '' : '<i class="icon-'. $icon . '"></i> ';
		$output .= esc_html($text) . join($sep, $links);
		$output .= $after;

		echo $output;
	}
}

// Display Post Comments
function cosmos_post_comments($args = '') {

	$args = wp_parse_args($args, array(
		'text' => '',
		'icon' => 'comment',
		'before' => '<span class="post-comments">',
		'after' => '</span>'
	));

	extract($args, EXTR_SKIP);

	echo $before;
	echo ( empty($icon) ) ? '' : '<i class="icon-'. $icon . '"></i> ';
	echo esc_html($text);
	comments_popup_link();
	echo $after;
}

// Get Current Post's Attachments
// (use inside the loop)
function cosmos_post_attachments($args) {

	return get_posts(wp_parse_args($args, array(
		'numberposts' => -1,
		'orderby'     => 'menu_order',
		'order'       => 'ASC',
		//'exclude'     => array(get_post_thumbnail_id()),
		'post_type'   => 'attachment',
		'post_parent' => get_the_ID()
	)));
}

// Get Featured Image or First Attached Image from Current Post
// (for home page and archive page loop)
function cosmos_post_thumbnail($args = '') {

	$args = wp_parse_args($args, array(
		'size' => 'post-thumbnail',
		'default' => '',
		'before' => '<span class="post-thumb">',
		'after' => '</span>'
	));

	extract($args, EXTR_SKIP);

	if ( has_post_thumbnail() ) {

		$img_id = get_post_thumbnail_id();
	}

	elseif ( $img = cosmos_post_attachments(array('post_mime_type' => 'image', 'numberposts' => 1)) ) {

		$img_id = $img[0]->ID;
	}

	else {

		$img_id = $default;
	}

	$img = wp_get_attachment_image_src($img_id, $size);

	$img_src = ( !empty($img_id) ) ? $img[0] : 'http://lorempixel.com/400/400/';
	$img_alt = get_post_meta($img_id, '_wp_attachment_image_alt', true);

	$output  = $before;
	$output .= '<a href="' . esc_url(get_permalink()) . '" title="' . esc_attr(get_the_title()) . '" class="thumbnail">';
	$output .= '<img src="' . esc_url($img_src) . '" alt="' . esc_attr($img_alt) . '"/></a>';
	$output .= $after;

	echo $output;
}
