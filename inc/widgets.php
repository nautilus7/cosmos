<?php

// http://codex.wordpress.org/Function_Reference/register_sidebar
register_sidebar(array(
  'name'          => 'Left Sidebar',
  'id'            => "sidebar-left",
  'before_widget' => '<li id="%1$s" class="widget %2$s">',
  'after_widget'  => '</li>',
  'before_title'  => '<h4 class="widgettitle">',
  'after_title'   => '</h4>'
));

register_sidebar(array(
  'name'          => 'Right Sidebar',
  'id'            => "sidebar-right",
  'before_widget' => '<li id="%1$s" class="widget %2$s">',
  'after_widget'  => '</li>',
  'before_title'  => '<h4 class="widgettitle">',
  'after_title'   => '</h4>'
));

register_sidebar(array(
  'name'          => 'Bottom Sidebar',
  'id'            => "sidebar-bottom",
  'before_widget' => '<div id="%1$s" class="span3 widget-bottom">',
  'after_widget'  => '</div>',
  'before_title'  => '<h5 class="widgettitle">',
  'after_title'   => '</h5>'
));

?>