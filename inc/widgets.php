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

// Clean Markup Widget
// http://perishablepress.com/clean-markup-widget
class Clean_Markup extends WP_Widget {

	function __construct() {

		parent::__construct('clean_markup', 'Clean Markup', array('description'=>__('Simple widget for well-formatted markup &amp; text', 'cosmos')));
	}

	function widget($args, $instance) {

		extract($args, EXTR_SKIP);

		$markup = $instance['markup'];

		if ( $markup ) {

			echo $before_widget;
			echo $markup;
			echo $after_widget;
		}
	}

	function update($new_instance, $old_instance) {

		$instance = $old_instance;
		$instance['markup'] = $new_instance['markup'];

		return $instance;
	}

	function form($instance) {

		if ( $instance ) $markup = esc_attr($instance['markup']);
		else $markup = __('&lt;p&gt;Clean, well-formatted markup.&lt;/p&gt;', 'cosmos');

		?>
		<p>
			<label for="<?php echo $this->get_field_id('markup'); ?>"><?php _e('Markup/text'); ?></label>
			<textarea class="widefat" id="<?php echo $this->get_field_id('markup'); ?>" name="<?php echo $this->get_field_name('markup'); ?>" type="text" rows="16" cols="20" value="<?php echo $markup; ?>"><?php echo $markup; ?></textarea>
		</p>
		<?php
	}
}
add_action('widgets_init', create_function('', 'register_widget("Clean_Markup");'));

// Add class to bottom sidebar widgets based on how many they are
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
