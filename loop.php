<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<header>
		<h1><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>
		<div class="post-meta clearfix">
			<?php cosmos_post_author(array('text' => 'by ', 'icon' => false));
			cosmos_post_date();
			cosmos_post_category();
			cosmos_post_tag();
			cosmos_post_comments(); ?>
		</div>
	</header>

	<div class="row-fluid">
		<div class="span3">
			<?php cosmos_post_thumbnail(array('size' => 'archive')); ?>
		</div>
		<div class="span9">
			<?php the_excerpt(); ?>
			<a href="<?php esc_url(the_permalink()); ?>" title="" class="btn"><?php esc_html_e('Continue Reading', 'cosmos'); ?></a>
		</div>
	</div>

</article>

<?php endwhile; ?>

<?php cosmos_page_nav(); ?>

<?php else: ?>

<p><?php _e('Sorry, no posts matched your criteria.', 'cosmos'); ?></p>

<?php endif; ?>
