<!doctype html>
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 7]> <html class="no-js lt-ie9 lt-ie8" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 8]> <html class="no-js lt-ie9" <?php language_attributes(); ?>> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" <?php language_attributes(); ?>> <!--<![endif]-->
<head>
  <meta charset="<?php bloginfo('charset'); ?>">

  <title><?php wp_title(''); ?></title>

  <meta name="viewport" content="width=device-width">
  <link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> Feed" href="<?php echo home_url('/feed/'); ?>">
  <!-- More ideas for your <head> here: h5bp.com/d/head-Tips -->
  <meta name="author" content="">
  <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
  <div id="wrapper" class="container-fluid">

    <header>
      <?php if ( has_nav_menu('top') ) cosmos_nav_menu('top', 'basic-pills'); ?>
      <div class="row-fluid">
        <div class="span12">
          <hgroup>
            <h1><?php bloginfo('name'); ?></h1>
            <h2><?php bloginfo('description'); ?></h2>
          </hgroup>
        </div>
      </div>
    </header>

    <?php if ( has_nav_menu('primary') ) cosmos_nav_menu('primary', 'navbar-brand'); ?>
    <?php if ( has_nav_menu('secondary') ) cosmos_nav_menu('secondary', 'basic-pills'); ?>
