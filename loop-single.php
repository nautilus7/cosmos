<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<header>
		<h1><?php the_title(); ?></h1>
		<?php cosmos_post_author(array('text' => 'Written by ', 'icon' => false)); ?>
	</header>

	<?php the_content(); ?>
	<?php cosmos_post_date(' on '); cosmos_post_category(' in '); cosmos_post_tag(' tagged '); cosmos_post_comments(' with '); ?>
	<?php comments_template(); ?>

</article>

<ul class="pager">
	<?php cosmos_previous_post_link('%link','older post'); ?>
	<?php cosmos_next_post_link('%link','newer post'); ?>
</ul>

<?php endwhile; ?>
<?php endif; ?>
