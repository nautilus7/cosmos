<?php

// http://codex.wordpress.org/Function_Reference/register_nav_menus
register_nav_menus(array(
	'top'       => 'Top',
	'primary'   => 'Primary',
	'secondary' => 'Secondary',
	'bottom'    => 'Bottom'
));

// Basic menu function
// Output matches bootstrap stracture
function cosmos_nav_menu($theme_location, $type) {

	$wrap_before = '';
	$wrap_after = '';

	switch ( $type ) {

	case 'basic-tabs' :
		$menu_class = 'nav nav-tabs';
		break;
	case 'stacked-tabs' :
		$menu_class = 'nav nav-tabs nav-stacked';
		break;
	case 'basic-pills' :
		$menu_class = 'nav nav-pills';
		break;
	case 'stacked-pills' :
		$menu_class = 'nav nav-pills nav-stacked';
		break;
	case 'list' :
		$menu_class = 'nav nav-list';
		break;
	case 'navbar' :
		$menu_class = 'nav';
		$wrap_before  = "<div class=\"navbar\">\n<div class=\"navbar-inner\">\n<div class=\"container\">\n";
		$wrap_before .= "<a class=\"btn btn-navbar\" data-toggle=\"collapse\" data-target=\".nav-collapse\">\n";
		$wrap_before .= "<span class=\"icon-bar\"></span>\n<span class=\"icon-bar\"></span>\n<span class=\"icon-bar\"></span>\n</a>\n";
		$wrap_before .= "<div class=\"nav-collapse\">\n";
		$wrap_after = "\n</div>\n</div>\n</div>\n</div>";
		break;
	case 'navbar-brand' :
		$menu_class = 'nav';
		$wrap_before  = "<div class=\"navbar\">\n<div class=\"navbar-inner\">\n<div class=\"container\">\n";
		$wrap_before .= "<a class=\"btn btn-navbar\" data-toggle=\"collapse\" data-target=\".nav-collapse\">\n";
		$wrap_before .= "<span class=\"icon-bar\"></span>\n<span class=\"icon-bar\"></span>\n<span class=\"icon-bar\"></span>\n</a>\n";
		$wrap_before .= "<a class=\"brand\" href=\"" . home_url('/') . "\">" . esc_html(get_bloginfo('name', 'display')) . "</a>\n";
		$wrap_before .= "<div class=\"nav-collapse\">\n";
		$wrap_after = "\n</div>\n</div>\n</div>\n</div>";
		break;
	}

	echo $wrap_before;

	wp_nav_menu(array(
		'theme_location' => $theme_location,
		'container' => false,
		'menu_class' => $menu_class,
		'walker' => new Bootstrap_Walker()
	));

	echo $wrap_after;
}

/*
function cosmos_nav_menu($theme_location, $type) {

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

  else {

    $wrap  = "<div class=\"navbar\">\n<div class=\"navbar-inner\">\n<div class=\"container\">\n";
    $wrap .= "<a class=\"btn btn-navbar\" data-toggle=\"collapse\" data-target=\".nav-collapse\">\n";
    $wrap .= "<span class=\"icon-bar\"></span>\n<span class=\"icon-bar\"></span>\n<span class=\"icon-bar\"></span>\n</a>\n";
    $wrap .= ( $type == 'navbar-brand' ) ? "<a class=\"brand\" href=\"" . home_url() . "\">" . get_bloginfo('name', 'display') . "</a>\n" : "";
    $wrap .= "<div class=\"nav-collapse\">\n";

    echo $wrap;

    wp_nav_menu(array(
      'theme_location' => $theme_location,
      'container' => false,
      'menu_class' => 'nav',
      'walker' => new Bootstrap_Walker()
    ));

    echo "\n</div>\n</div>\n</div>\n</div>";
  }

  //else {

    //echo 'Unknown menu type.';
    //echo 'Available types are "basic-tabs", "stacked-tabs", "basic-pills", "stacked-pills", "list", "navbar" and "navbar-brand".';
  //}
}
*/
class Bootstrap_Walker extends Walker_Nav_Menu {

	function start_lvl(&$output, $depth) {

		$indent = str_repeat("\t", $depth);
		$output	.= "\n$indent<ul class=\"dropdown-menu\">\n";
	}

	function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0) {

		global $wp_query;

		$indent = ( $depth ) ? str_repeat("\t", $depth) : '';

		//$id = apply_filters('nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args);
		//$id = strlen($id) ? ' id="' . esc_attr($id) . '"' : '';

		$classes = empty( $item->classes ) ? array() : (array) $item->classes;
		$classes[] = ( $args->has_children ) ? 'dropdown' : ''; // aditional element
		$classes[] = ( $item->current || $item->current_item_ancestor ) ? 'active' : '';

		$class_names = '';
		$class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args));
		$class_names = ' class="' . esc_attr($class_names) . '"';

		$output .= $indent . '<li' . $class_names . '>';

		$attributes  = !empty($item->attr_title) ? ' title="'  . esc_attr($item->attr_title) . '"'   : '';
		$attributes .= !empty($item->target)     ? ' target="' . esc_attr($item->target    ) . '"'   : '';
		$attributes .= !empty($item->xfn)        ? ' rel="'    . esc_attr($item->xfn       ) . '"'   : '';
		$attributes .= !empty($item->url)        ? ' href="'   . esc_attr($item->url       ) . '"'   : '';
		$attributes .= ( $args->has_children )   ? ' class="dropdown-toggle" data-toggle="dropdown"' : ''; // aditional element

		$item_output  = $args->before;
		$item_output .= '<a' . $attributes . '>';
		$item_output .= $args->link_before;
		$item_output .= apply_filters('the_title', $item->title, $item->ID);
		$item_output .= !empty($item->description) ? '<span>' . esc_attr($item->description) . '</span>' : ''; // aditional element
		$item_output .= $args->link_after;
		$item_output .= ( $args->has_children ) ? ' <b class="caret"></b>' : ''; // aditional element
		$item_output .= '</a>';
		$item_output .= $args->after;

		$output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
	}

	function display_element($element, &$children_elements, $max_depth, $depth = 0, $args, &$output) {

		if ( !$element ) {

			return;
		}

		$id_field = $this->db_fields['id'];

		//display this element
		if ( is_array($args[0]) ) {

			$args[0]['has_children'] = !empty($children_elements[$element->$id_field]);
		}

		elseif ( is_object($args[0]) ) {

			$args[0]->has_children = !empty($children_elements[$element->$id_field]);
		}

		$cb_args = array_merge(array(&$output, $element, $depth), $args);
		call_user_func_array(array(&$this, 'start_el'), $cb_args);
		$id = $element->$id_field;

		// descend only when the depth is right and there are childrens for this element
		if ( ( $max_depth == 0 || $max_depth > $depth + 1 ) && isset($children_elements[$id]) ) {

			foreach( $children_elements[$id] as $child ) {

				if ( !isset($newlevel) ) {

					$newlevel = true;
					//start the child delimiter
					$cb_args = array_merge(array(&$output, $depth), $args);
					call_user_func_array(array(&$this, 'start_lvl'), $cb_args);
				}

				$this->display_element($child, $children_elements, $max_depth, $depth + 1, $args, $output);
			}

			unset($children_elements[$id]);
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

// Page navigation
// alternate version of wordpress' paginate_links
function cosmos_page_nav($args = '') {

	global $wp_query, $wp_rewrite;

	//if ( !empty($wp_query->query_vars['s']) ) $pagination['add_args'] = array('s' => get_query_var('s'));

	$defaults = array(
		'base' => get_pagenum_link(1).'%_%', // %_% is replaced by format (below)
		'format' => ( $wp_rewrite->using_permalinks() ) ? 'page/%#%/' : '?page=%#%', // %#% is replaced by the page number
		'total' => $wp_query->max_num_pages,
		'current' => ( $wp_query->query_vars['paged'] > 1 ) ? $wp_query->query_vars['paged'] : 1,
		'show_all' => false,
		'prev_next' => true,
		'prev_text' => __('&laquo; Previous', 'cosmos'),
		'next_text' => __('Next &raquo;', 'cosmos'),
		'end_size' => 1,
		'mid_size' => 2,
		'add_args' => false, // array of query args to add
		'add_fragment' => ''
	);

	$args = wp_parse_args($args, $defaults);
	extract($args, EXTR_SKIP);

	// Who knows what else people pass in $args
	$total = (int) $total;

	if ( $total < 2 ) {

		return;
	}

	$current = (int) $current;
	$end_size = 0  < (int) $end_size ? (int) $end_size : 1; // Out of bounds?  Make it the default.
	$mid_size = 0 <= (int) $mid_size ? (int) $mid_size : 2;
	$add_args = is_array($add_args) ? $add_args : false;
	$page_links = array();
	$n = 0;
	$dots = false;

	if ( $prev_next && $current && 1 < $current ) {

		$link = str_replace('%_%', 2 == $current ? '' : $format, $base);
		$link = str_replace('%#%', $current - 1, $link);

		if ( $add_args ) {

			$link = add_query_arg($add_args, $link);
		}

		$link .= $add_fragment;
		$page_links[] = '<li><a href="' . esc_url(apply_filters('paginate_links', $link)) . '">' . $prev_text . '</a></li>';
	}

	for ( $n = 1; $n <= $total; $n++ ) {

		$n_display = number_format_i18n($n);

		if ( $n == $current ) {

			$page_links[] = '<li class="active"><a>' . $n_display . '</a></li>';
			$dots = true;
		}

		else {

			if ( $show_all || ( $n <= $end_size || ( $current && $n >= $current - $mid_size && $n <= $current + $mid_size ) || $n > $total - $end_size ) ) {

				$link = str_replace('%_%', 1 == $n ? '' : $format, $base);
				$link = str_replace('%#%', $n, $link);

				if ( $add_args ) {

					$link = add_query_arg($add_args, $link);
				}

				$link .= $add_fragment;
				$page_links[] = '<li><a href="' . esc_url(apply_filters('paginate_links', $link)) . '">' . $n_display . '</a></li>';
				$dots = true;
			}

			elseif ( $dots && !$show_all ) {

				$page_links[] = '<li class="disabled"><a>' . __('&hellip;') . '</a></li>';
				$dots = false;
			}
		}
	}

	if ( $prev_next && $current && ( $current < $total || -1 == $total ) ) {

		$link = str_replace('%_%', $format, $base);
		$link = str_replace('%#%', $current + 1, $link);

		if ( $add_args ) {

			$link = add_query_arg($add_args, $link);
		}

		$link .= $add_fragment;
		$page_links[] = '<li><a href="' . esc_url(apply_filters('paginate_links', $link)) . '">' . $next_text . '</a></li>';
	}

	$output  = "<div class=\"pagination\">\n\t<ul>\n\t";
	$output .= join("\n\t", $page_links);
	$output .= "\n\t</ul>\n</div>";

	echo $output;
}

// Post Navigation
// Create the "previous post" and "next post" links on single.php
// Modified versions of Wordpress' original functions to match bootstrap markup
function cosmos_previous_post_link($format='%link', $link='%title', $in_same_cat = false, $excluded_categories = '') {

	cosmos_adjacent_post_link($format, $link, $in_same_cat, $excluded_categories, true);
}

function cosmos_next_post_link($format='%link', $link='%title', $in_same_cat = false, $excluded_categories = '') {

	cosmos_adjacent_post_link($format, $link, $in_same_cat, $excluded_categories, false);
}

function cosmos_adjacent_post_link($format, $link, $in_same_cat = false, $excluded_categories = '', $previous = true) {

	if ( $previous && is_attachment() ) {

		$post = &get_post($GLOBALS['post']->post_parent);
	}

	else {

		$post = get_adjacent_post($in_same_cat, $excluded_categories, $previous);
	} 

	if ( !$post ) {

		return;
	}

	$title = $post->post_title;

	if ( empty($post->post_title) ) {

		$title = $previous ? __('Previous Post') : __('Next Post');
	}

	$title = apply_filters('the_title', $title, $post->ID);
	$date = mysql2date(get_option('date_format'), $post->post_date);
	$class = $previous ? 'previous' : 'next';
	$string = '<li class="' . $class . '"><a href="' . get_permalink($post) . '">';
	$link = str_replace('%title', $title, $link);
	$link = str_replace('%date', $date, $link);
	$link = $string . $link . '</a></li>';
	$format = str_replace('%link', $link, $format);
	$adjacent = $previous ? 'previous' : 'next';

	echo apply_filters("{$adjacent}_post_link", $format, $link);
}

// Modify Yoast's WP SEO Breadcrumbs to Match Twitter Bootstrap Breadcrumb Structure
function cosmos_bootstrap_breadcrumb() {

	if ( function_exists('yoast_breadcrumb') ) {

		$breadcrumbs = yoast_breadcrumb('<ul class="breadcrumb"><li>', '</li></ul>', false);
		echo str_replace('&raquo;', ' <span class="divider">/</span></li><li>', $breadcrumbs);
	}
}
