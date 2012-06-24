<?php if ( have_posts() ) : ?>

	<article id="author" class="well clearfix">

		<h1><?php _e('Author: ', 'cosmos'); the_author_link(); ?></h1>
		<?php if ( get_avatar(get_the_author_meta('ID')) ) : ?>
			<div class="gravatar"><?php echo get_avatar(get_the_author_meta('ID')); ?></div>
		<?php endif; ?>
		<?php if ( get_the_author_meta('user_description') ) : ?>
			<p><?php the_author_meta('user_description'); ?></p>
		<?php else : ?>
			<p><?php _e('The Author hasn&#39;t written a bio yet&hellip;', 'cosmos'); ?></p>
		<?php endif; ?>

	</article>

<?php while ( have_posts() ) : the_post(); ?>

<article <?php post_class(); ?>>

	<h1><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>
	<div class="post-meta">
		<?php cosmos_post_date(); cosmos_post_category(); cosmos_post_tag(); cosmos_post_comments(); cosmos_post_thumbnail(); ?>
	</div>
	<?php the_excerpt(); ?>

</article>

<?php endwhile; ?>

<?php cosmos_page_nav(); ?>

<?php else: ?>

<p><?php _e('The author archive is empty', 'cosmos'); ?></p>

<?php endif; ?>
