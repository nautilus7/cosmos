<?php

// Set post excerpt length in words (default is 55)
function cosmos_excerpt_length() {

	return 55;
}
add_filter('excerpt_length', 'cosmos_excerpt_length');

// Returns a "Continue Reading" link for excerpts
function cosmos_excerpt_more() {

	return '<a href="' . esc_url(get_permalink()) . '" title="" class="btn">' . esc_html__('Continue Reading', 'cosmos') . '</a>';
}
add_filter('excerpt_more', 'cosmos_excerpt_more');

// Get post author 
function cosmos_post_author($text = '', $icon = true) {

	$output = ( empty($text) && $icon) ? '<span class="post-author clear"><i class="icon-user"></i> ' : '<span class="post-author">' . esc_html($text);
	$output .= '<a href="' . esc_url(get_author_posts_url(get_the_author_meta('id'))) . '" title="';
	$output .= esc_attr__('View all posts by ', 'cosmos') . esc_attr(get_the_author()) . '">' . esc_html(get_the_author()) . '</a></span>';

	echo $output;
}

// Get post date
function cosmos_post_date($text = '', $relative = true, $icon = true) {

	// If a string is set before the time, don't display the icon or relative time format
	if ( empty($text) ) {

		$output = ( $icon ) ? '<span class="post-date clear"><i class="icon-time"></i> ' : '<span class="post-date">';
		$output .= '<time datetime="' . esc_attr(get_the_time('c')) . '" pubdate>';

		// Use relative time only if posted in the last 24 hours
		if ( $relative && 24*60*60 > (current_time('timestamp') - get_the_time('U')) ) {

			$output .= esc_html(human_time_diff(get_the_time('U'), current_time('timestamp'))) . esc_html__(' ago', 'cosmos');
			$output .= '</time></span>';
		}

		else {

			$output .= esc_html(get_the_date()) . '</time></span>';
		}
	}

	else {

		$output = '<span class="post-date">' . esc_html($text);
		$output .= '<time datetime="' . esc_attr(get_the_time('c')) . '" pubdate>' . esc_html(get_the_date()) . '</time></span>';
	}

	echo $output;
}

// Get post categories
function cosmos_post_category($text = '', $separator = ', ', $icon = true) {

	$post_category = get_the_category();

	if ( $post_category ) {

		$category_links = array();

		foreach ( $post_category as $category ) {

			$link = esc_url(get_category_link($category->term_id));
			$title = esc_attr__('View all posts in ', 'cosmos') . esc_attr($category->name);
			$name = esc_html($category->name);

			$category_links[] = '<a href="' . "$link" . '" title="' . "$title" . '">' . "$name" . '</a>';
		}

		$output = ( empty($text) && $icon ) ? '<span class="post-category clear"><i class="icon-bookmark"></i> ' : '<span class="post-category">' . esc_html($text);
		$output .= join($separator, $category_links) . '</span>';

		echo $output;
	}
}

//Get post tags
function cosmos_post_tag($text = '', $separator = ', ', $icon = true) {

	$post_tags = get_the_tags();

	if ( $post_tags ) {

		$tag_links = array();

		foreach ( $post_tags as $tag ) {

			$link = esc_url(get_tag_link($tag->term_id));
			$title = esc_attr__('View all posts tagged ', 'cosmos') . esc_attr($tag->name);
			$name = esc_html($tag->name);

			$tag_links[] = '<a href="' . "$link" . '" title="' . "$title" . '">' . "$name" . '</a>';
		}

		$output = ( empty($text) && $icon ) ? '<span class="post-tags clear"><i class="icon-tags"></i> ' : '<span class="post-tags">' . esc_html($text);
		$output .= join($separator, $tag_links) . '</span>';

		echo $output;
	}
}

// Get post comments
function cosmos_post_comments($text = '', $icon = true) {

	if ( comments_open() ) {

		echo ( empty($text) && $icon ) ? '<span class="post-comments clear"><i class="icon-comment"></i> ' : '<span class="post-comments">' . esc_html($text);

		comments_popup_link( __('0 comments', 'twentyeleven'), __('1 comment', 'cosmos'), __('% comments', 'cosmos'), '', __('Comments off', 'cosmos'));

		echo '</span>';
	}
}

// Get current post's attachments (use inside the loop)
function cosmos_post_attachments($args) {

	return get_posts(wp_parse_args($args, array(

		'numberposts' => -1,
		'orderby'     => 'menu_order',
		'order'       => 'ASC',
		//'exclude'     => array(get_post_thumbnail_id()),
		'post_type'   => 'attachment',
		'post_parent' => get_the_ID(),
		)));
}

// Get post featured image or first attached image for the home page excerpt
function cosmos_post_thumbnail($fallback_img_id = '') {

	if ( has_post_thumbnail() ) {

		$img_id = get_post_thumbnail_id();
	}

	elseif ( $img = cosmos_post_attachments(array('post_mime_type' => 'image', 'numberposts' => 1)) ) {

		$img_id = $img[0]->ID;
	}

	else {

		$img_id = $fallback_img_id;
	}

	$img_src = ( !empty($img_id) ) ? wp_get_attachment_url($img_id) : 'http://lorempixel.com/400/400/';
	$img_alt = get_post_meta($img_id, '_wp_attachment_image_alt', true);

	echo '<a href="' . esc_url(get_permalink()) . '" title="' . esc_attr(get_the_title()) . '" class="thumbnail">';
	echo '<img src="' . esc_url($img_src) . '" alt="' . esc_attr($img_alt) . '"/>';
	echo '</a>';
}