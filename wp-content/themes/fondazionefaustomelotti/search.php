<?php get_header(); ?>
	
	<section role="main">
	  
    <div class="summary">
		  <h1><?php echo sprintf( __( '%s Search Results for ', 'html5blank' ), $wp_query->found_posts ); echo get_search_query(); ?></h1>
		</div>

		<?php if (have_posts()): while (have_posts()) : the_post(); ?>
	
	    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		    
        <div class="content">
		      <h2>
			      <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a>
		      </h2>
		
		      <p><?php the_excerpt(); ?></p>
        </div>

        <?php if ( has_post_thumbnail()) : ?>
        <div class="image">
			    <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
				    <?php the_post_thumbnail(array(120,120)); ?>
			    </a>
        </div>
		    <?php endif; ?>
		
	    </article>
	
    <?php endwhile; ?>

    <?php else: ?>

	    <article>
        <div class="content">
		      <h2><?php _e( 'Sorry, nothing to display.', 'html5blank' ); ?></h2>
	      </div>
      </article>

    <?php endif; ?>
		
		<?php get_template_part('pagination'); ?>
	
	</section>

<?php get_footer(); ?>