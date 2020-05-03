<?php get_header(); ?>
	
	<section role="main">

    <?php if (have_posts()): while (have_posts()) : the_post(); ?>
	
		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

      <div class="content">
			  <?php the_content(); ?>
			</div>
			
		</article>
		
	  <?php endwhile; ?>
	
	  <?php else: ?>
	
		<article>
			
      <div class="content">
			  <p><?php _e( 'Sorry, nothing to display.', 'html5blank' ); ?></p>
			</div>

		</article>
	
	  <?php endif; ?>
	
	</section>

<?php get_footer(); ?>