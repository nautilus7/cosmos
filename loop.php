<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header>
		<h1><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>
	</header>
	<div class="row-fluid">
		<div class="span3">
			<?php cosmos_post_thumbnail(); ?>
		</div>
		<div class="span9">
			<?php the_excerpt(); ?>
		</div>
	</div>
	<footer>
		<?php cosmos_post_author(); cosmos_post_date(); cosmos_post_category(); cosmos_post_tag(); cosmos_post_comments(); ?>
	</footer>
</article>

<?php endwhile; ?>

<?php cosmos_page_nav(); ?>

<?php else: ?>

<p><?php _e('Sorry, no posts matched your criteria.', 'cosmos'); ?></p>

<?php endif; ?>
