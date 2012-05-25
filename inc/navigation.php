<?php

// http://codex.wordpress.org/Function_Reference/register_nav_menus
register_nav_menus( array(
  'top'       => 'Top',
  'primary'   => 'Primary',
  'secondary' => 'Secondary',
  'bottom'    => 'Bottom'
));

//menu building
function cosmos_nav_menu( $theme_location, $type ) {

	if ( $type !== 'navbar' && $type !== 'navbar-brand' ) {

		if     ( $type == 'basic-tabs'    ) $menu_class = 'nav nav-tabs';
		elseif ( $type == 'stacked-tabs'  ) $menu_class = 'nav nav-tabs nav-stacked';
		elseif ( $type == 'basic-pills'   ) $menu_class = 'nav nav-pills';
		elseif ( $type == 'stacked-pills' ) $menu_class = 'nav nav-pills nav-stacked';
		elseif ( $type == 'list'          ) $menu_class = 'nav nav-list';
	
		wp_nav_menu(array(
						'theme_location' => $theme_location,
						'container' => false,
						'menu_class' => $menu_class,
						'walker' => new Bootstrap_Walker()
						));
	}

	elseif ( $type == 'navbar-brand' ) {

		$wrap = '<div class="navbar">' . "\n" . '<div class="navbar-inner">' . "\n" . '<div class="container">' . "\n";
		$wrap .= '<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">' . "\n";
		$wrap .= '<span class="icon-bar"></span>' . "\n";
		$wrap .= '<span class="icon-bar"></span>' . "\n";
		$wrap .= '<span class="icon-bar"></span>' . "\n" . '</a>' . "\n";
		$wrap .= '<a class="brand" href="' . home_url('/') . '">';

		echo "$wrap";

		bloginfo( 'name' );

		echo '</a>' . "\n" .'<div class="nav-collapse">' . "\n";

		wp_nav_menu(array(
						'theme_location' => $theme_location,
						'container' => false,
						'menu_class' => 'nav',
						'walker' => new Bootstrap_Walker()
						));

		echo "\n" . '</div>' . "\n" . '</div>' . "\n" . '</div>' . "\n" . '</div>';
	}

	elseif ( $type == 'navbar' ) {

		$wrap = '<div class="navbar">' . "\n" . '<div class="navbar-inner">' . "\n" . '<div class="container">' . "\n";
		$wrap .= '<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">' . "\n";
		$wrap .= '<span class="icon-bar"></span>' . "\n";
		$wrap .= '<span class="icon-bar"></span>' . "\n";
		$wrap .= '<span class="icon-bar"></span>' . "\n" . '</a>' . "\n";
		$wrap .= '<div class="nav-collapse">' . "\n";

		echo "$wrap";

		wp_nav_menu(array(
						'theme_location' => $theme_location,
						'container' => false,
						'menu_class' => 'nav',
						'walker' => new Bootstrap_Walker()
						));

		echo "\n" . '</div>' . "\n" . '</div>' . "\n" . '</div>' . "\n" . '</div>';
	}

	else {

		echo 'Unknown menu type.';
		echo 'Available types are "basic-tabs", "stacked-tabs", "basic-pills", "stacked-pills", "list", "navbar" and "navbar-brand".';
	}
}

class Bootstrap_Walker extends Walker_Nav_Menu {


	function start_lvl( &$output, $depth ) {

		$indent = str_repeat( "\t", $depth );
		$output	.= "\n$indent<ul class=\"dropdown-menu\">\n";

	}

	function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {

		$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

		$li_attributes = '';
		$class_names = $value = '';

		$classes = empty( $item->classes ) ? array() : (array) $item->classes;
		$classes[] = ($args->has_children) ? 'dropdown' : '';
		$classes[] = ($item->current || $item->current_item_ancestor) ? 'active' : '';
		$classes[] = 'menu-item-' . $item->ID;


		$class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args));
		$class_names = ' class="' . esc_attr($class_names) . '"';

		$id = apply_filters('nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args);
		$id = strlen($id) ? ' id="' . esc_attr($id) . '"' : '';

		$output .= $indent . '<li' . $id . $value . $class_names . $li_attributes . '>';

		$attributes  = !empty($item->attr_title) ? ' title="'  . esc_attr($item->attr_title) . '"' : '';
		$attributes .= !empty($item->target)     ? ' target="' . esc_attr($item->target    ) . '"' : '';
		$attributes .= !empty($item->xfn)        ? ' rel="'    . esc_attr($item->xfn       ) . '"' : '';
		$attributes .= !empty($item->url)        ? ' href="'   . esc_attr($item->url       ) . '"' : '';
		$attributes .= ($args->has_children) 	 ? ' class="dropdown-toggle" data-toggle="dropdown"' : '';

		$item_output  = $args->before;
		$item_output .= '<a' . $attributes . '>';
		$item_output .= $args->link_before . apply_filters('the_title', $item->title, $item->ID) . $args->link_after;
		$item_output .= ($args->has_children) ? ' <b class="caret"></b></a>' : '</a>';
		$item_output .= $args->after;

		$output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
	}

	function display_element($element, &$children_elements, $max_depth, $depth=0, $args, &$output) {

		if ( !$element )
			return;

		$id_field = $this->db_fields['id'];

		//display this element
		if ( is_array( $args[0] ) ) 
			$args[0]['has_children'] = ! empty($children_elements[$element->$id_field]);
		else if ( is_object( $args[0] ) ) 
			$args[0]->has_children = ! empty($children_elements[$element->$id_field]); 
			$cb_args = array_merge(array(&$output, $element, $depth), $args);
			call_user_func_array(array(&$this, 'start_el'), $cb_args);

			$id = $element->$id_field;

		// descend only when the depth is right and there are childrens for this element
		if ( ($max_depth == 0 || $max_depth > $depth+1 ) && isset($children_elements[$id] ) ) {

			foreach( $children_elements[ $id ] as $child ) {

				if ( !isset($newlevel) ) {
					$newlevel = true;
					//start the child delimiter
					$cb_args = array_merge(array(&$output, $depth), $args);
					call_user_func_array(array(&$this, 'start_lvl'), $cb_args);
				}
				$this->display_element($child, $children_elements, $max_depth, $depth + 1, $args, $output);
			}
				unset($children_elements[ $id ]);
		}

		if ( isset($newlevel) && $newlevel ) {
			//end the child delimiter
			$cb_args = array_merge(array(&$output, $depth), $args);
			call_user_func_array(array(&$this, 'end_lvl'), $cb_args);
		}

		//end this element
		$cb_args = array_merge(array(&$output, $element, $depth), $args);
		call_user_func_array(array(&$this, 'end_el'), $cb_args);

	}

}
// not used - ment to replace the function below
function cosmos_paginate_links() {

    global $wp_rewrite, $wp_query;

    $wp_query->query_vars['paged'] > 1 ? $current = $wp_query->query_vars['paged'] : $current = 1;

    $pagination = array(
        'base' => @add_query_arg('page','%#%'),
        'format' => '',
        'total' => $wp_query->max_num_pages,
        'current' => $current,
        'prev_text' => __('« Previous', 'cosmos'),
        'next_text' => __('Next »', 'cosmos'),
        'end_size' => 1,
        'mid_size' => 2,
        'show_all' => true,
        'type' => 'list'
    );

    if ( $wp_rewrite->using_permalinks() )
            $pagination['base'] = user_trailingslashit(trailingslashit(remove_query_arg('s', get_pagenum_link(1))) . 'page/%#%/', 'paged' );

    if ( !empty($wp_query->query_vars['s']) )
            $pagination['add_args'] = array('s' => get_query_var('s'));

    echo paginate_links($pagination);
}

//construct the page navigation
function cosmos_page_nav() {

	global $wp_query, $wp_rewrite;

	if ($wp_query->max_num_pages > 1) { $current_page = max( 1, get_query_var('paged')); 

		$args = array(
			'base' => get_pagenum_link(1).'%_%',
			'format' => 'page/%#%',
			'total' => $wp_query->max_num_pages,
			'current' => $current_page
		);

		echo bootstrap_paginate_links($args);
	}
}

// alternate version of wordpress' paginate_links
function bootstrap_paginate_links($args = '') {

	$defaults = array(
		'base' => '%_%', // http://example.com/all_posts.php%_% : %_% is replaced by format (below)
		'format' => '?page=%#%', // ?page=%#% : %#% is replaced by the page number
		'total' => 1,
		'current' => 0,
		'show_all' => false,
		'prev_next' => true,
		'prev_text' => __('&laquo; Previous'),
		'next_text' => __('Next &raquo;'),
		'end_size' => 1,
		'mid_size' => 2,
		'add_args' => false, // array of query args to add
		'add_fragment' => ''
	);

	$args = wp_parse_args($args, $defaults);
	extract($args, EXTR_SKIP);

	// Who knows what else people pass in $args
	$total = (int) $total;
	if ( $total < 2 )
		return;
	$current  = (int) $current;
	$end_size = 0  < (int) $end_size ? (int) $end_size : 1; // Out of bounds?  Make it the default.
	$mid_size = 0 <= (int) $mid_size ? (int) $mid_size : 2;
	$add_args = is_array($add_args) ? $add_args : false;
	$r = '';
	$page_links = array();
	$n = 0;
	$dots = false;

	if ( $prev_next && $current && 1 < $current ) :
		$link = str_replace('%_%', 2 == $current ? '' : $format, $base);
		$link = str_replace('%#%', $current - 1, $link);
		if ( $add_args )
			$link = add_query_arg( $add_args, $link );
		$link .= $add_fragment;
		$page_links[] = '<li><a href="' . esc_url(apply_filters('paginate_links', $link)) . '">' . $prev_text . '</a></li>';
	endif;
	for ( $n = 1; $n <= $total; $n++ ) :
		$n_display = number_format_i18n($n);
		if ( $n == $current ) :
			$page_links[] = '<li class="active"><a>' . $n_display . '</a></li>';
			$dots = true;
		else :
			if ( $show_all || ( $n <= $end_size || ( $current && $n >= $current - $mid_size && $n <= $current + $mid_size ) || $n > $total - $end_size ) ) :
				$link = str_replace('%_%', 1 == $n ? '' : $format, $base);
				$link = str_replace('%#%', $n, $link);
				if ( $add_args )
					$link = add_query_arg( $add_args, $link );
				$link .= $add_fragment;
				$page_links[] = '<li><a href="' . esc_url(apply_filters('paginate_links', $link)) . '">' . $n_display . '</a></li>';
				$dots = true;
			elseif ( $dots && !$show_all ) :
				$page_links[] = '<li class="disabled"><a>' . __('&hellip;') . '</a></li>';
				$dots = false;
			endif;
		endif;
	endfor;
	if ( $prev_next && $current && ( $current < $total || -1 == $total ) ) :
		$link = str_replace('%_%', $format, $base);
		$link = str_replace('%#%', $current + 1, $link);
		if ( $add_args )
			$link = add_query_arg( $add_args, $link );
		$link .= $add_fragment;
		$page_links[] = '<li><a href="' . esc_url( apply_filters('paginate_links', $link)) . '">' . $next_text . '</a></li>';
	endif;

	$r .= '<div class="pagination">' . "\n\t" . '<ul>' ."\n\t";
	$r .= join("\n\t", $page_links);
	$r .= "\n\t" . '</ul>' . "\n" . '</div>';

	return $r;
}

// post navigation
function cosmos_previous_post_link($format='%link', $link='%title', $in_same_cat = false, $excluded_categories = '') {
	cosmos_adjacent_post_link($format, $link, $in_same_cat, $excluded_categories, true);
}

function cosmos_next_post_link($format='%link', $link='%title', $in_same_cat = false, $excluded_categories = '') {
	cosmos_adjacent_post_link($format, $link, $in_same_cat, $excluded_categories, false);
}

function cosmos_adjacent_post_link($format, $link, $in_same_cat = false, $excluded_categories = '', $previous = true) {
	if ( $previous && is_attachment() )
		$post = & get_post($GLOBALS['post']->post_parent);
	else
		$post = get_adjacent_post($in_same_cat, $excluded_categories, $previous);

	if ( !$post )
		return;

	$title = $post->post_title;

	if ( empty($post->post_title) )
		$title = $previous ? __('Previous Post') : __('Next Post');

	$title = apply_filters('the_title', $title, $post->ID);
	$date = mysql2date(get_option('date_format'), $post->post_date);
	$class = $previous ? 'previous' : 'next';

	$string = '<li class="' . $class . '"><a href="' . get_permalink($post) . '">';
	$link = str_replace('%title', $title, $link);
	$link = str_replace('%date', $date, $link);
	$link = $string . $link . '</a></li>';

	$format = str_replace('%link', $link, $format);

	$adjacent = $previous ? 'previous' : 'next';
	echo apply_filters( "{$adjacent}_post_link", $format, $link );
}

// breacrumb for taxonomy or single pages (currently works if the post belongs to only one category, also needs to output the parent category)
function cosmos_breadcrumb() {

	if( !is_home() ) {

		echo '<ul class="breadcrumb">';
		echo '<li><a href="' . home_url('/') . '">' . get_bloginfo('name') . '</a><span class="divider">/</span></li>';

		if ( is_category() || is_single() ) {

			echo '<li>';
			the_category('<span class="divider">/</span>');
			echo '</li>';

			if ( is_single() ) {

				the_title('<li><span class="divider">/</span>', '</li>');
			}
		}

		elseif ( is_page() ) {

			the_title('<li><span class="divider">/</span>', '</li>');
		}

		echo '</ul>';
	}
}

// Modify Yoast's Breadcrumbs to match Twitter Bootstrap structure
if ( function_exists('yoast_breadcrumb') ) {

	$breadcrumbs = yoast_breadcrumb('<ul class="breadcrumb"><li>', '</li></ul>', false);
	echo str_replace('|', ' <span class="divider">/</span></li><li>', $breadcrumbs);

}