<?php

// http://codex.wordpress.org/Function_Reference/register_sidebar
register_sidebar(array(
	'name'          => 'Left Sidebar',
	'id'            => 'sidebar-left',
	'before_widget' => '<div class="widget">',
	'after_widget'  => '</div>',
	'before_title'  => '<h4>',
	'after_title'   => '</h4>'
));

register_sidebar(array(
	'name'          => 'Right Sidebar',
	'id'            => 'sidebar-right',
	'before_widget' => '<div class="widget">',
	'after_widget'  => '</div>',
	'before_title'  => '<h4>',
	'after_title'   => '</h4>'
));

register_sidebar(array(
	'name'          => 'Bottom Sidebar',
	'id'            => 'sidebar-bottom',
	'before_widget' => '<div class="widget">',
	'after_widget'  => '</div>',
	'before_title'  => '<h5>',
	'after_title'   => '</h5>'
));

function cosmos_bottom_sidebar_class($params) {

	$sidebar_id = $params[0]['id'];

	if ( $sidebar_id == 'sidebar-bottom' ) {

		$total_widgets = wp_get_sidebars_widgets();
		$sidebar_widgets = count($total_widgets[$sidebar_id]);
		$class = 'class="span' . floor(12 / $sidebar_widgets) . ' ';

		$params[0]['before_widget'] = str_replace('class="', $class, $params[0]['before_widget']);
	}

	return $params;
}
add_filter('dynamic_sidebar_params','cosmos_bottom_sidebar_class');
