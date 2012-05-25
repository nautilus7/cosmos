<?php get_header(); ?>

	<div id="content" class="row-fluid">

		<?php get_template_part('loop', 'single'); ?>

		<?php get_sidebar('right'); ?>

	</div>

<?php get_sidebar('bottom'); ?>

<?php get_footer(); ?>