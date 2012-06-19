<?php if ( have_posts() ) : ?>

	<article id="category" class="well clearfix">

		<h1><?php _e('Browsing category: ', 'cosmos'); single_cat_title(); ?></h1>
		<?php echo category_description(); ?>

	</article>

<?php while ( have_posts() ) : the_post(); ?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<header class="page-header">
		<h1><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>
	</header>
	<div class="post-meta">
		<?php cosmos_post_author(); cosmos_post_date(); cosmos_post_comments(); ?>
	</div>
	<div class="post-body">
		<?php the_excerpt(); ?>
	</div>

</article>

<?php endwhile; ?>

<?php cosmos_page_nav(); ?>

<?php else: ?>

<p><?php _e('Sorry, no articles here&hellip;', 'cosmos'); ?></p>

<?php endif; ?>
