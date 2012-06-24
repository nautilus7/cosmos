<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

<article <?php post_class(); ?>>

	<header class="page-header">
		<h1><?php the_title(); cosmos_post_author(array('before' => '<small>', 'after' => '</small>', 'text' => ' by ', 'icon' => false)); ?></h1>
	</header>

	<?php the_content(); ?>
	<?php comments_template(); ?>

</article>

<?php endwhile; ?>
<?php endif; ?>
