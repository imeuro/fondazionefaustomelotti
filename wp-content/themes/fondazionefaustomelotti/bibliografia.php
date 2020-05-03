<?php /* Template Name: Bibliografia */ get_header(); ?>
	
	<section role="main">

    <?php if (have_posts()): while (have_posts()) : the_post(); ?>
	
		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		  
      <div class="col1">

        <header>
          <h2><?php _e( 'Catalogue Raisonné', 'html5blank' ); ?></h2>
        </header>

        <div class="scrollable-content" id="scrollbar1">
          <?php the_content(); ?>
        </div>
            
      </div>

      <div class="col2">

        <header>
          <h2><?php _e( 'Monographies', 'html5blank' ); ?></h2>
        </header>

        <div class="scrollable-content" id="scrollbar2">
          <?php the_field('monographs'); ?>
        </div>

      </div>

      <div class="col3">
      
        <header>
          <h2><?php _e( 'Writings by Fausto Melotti', 'html5blank' ); ?></h2>
        </header>

        <div class="scrollable-content" id="scrollbar3">
          <?php the_field('texts'); ?>
        </div>

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