<?php get_header(); ?>

	<div id="content" class="row-fluid">
		<div id="main" class="span8">
			<?php get_template_part('loop', 'category'); ?>
		</div>
		<aside id="sidebar-right" class="span4">
			<?php get_sidebar('right'); ?>
		</aside>
	</div>

	<?php get_sidebar('bottom'); ?>

<?php get_footer(); ?>
