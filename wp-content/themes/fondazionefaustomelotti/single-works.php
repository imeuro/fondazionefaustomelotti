<?php get_header(); ?>
	
	<section role="main">

    <?php if (have_posts()): while (have_posts()) : the_post(); ?>
	
		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		  
      <div class="col1">

        <header>
          <h1><?php the_title(); ?>, <?php the_field('year'); ?></h1>
        </header>

        <div class="content">
          
          <?php the_content(); ?>

          <?php if (get_field('pdf')) : ?>
          <p><a class="pdf" href="<?php the_field('pdf'); ?>" title="<?php _e( 'Download the PDF of the work', 'html5blank' ); ?>" target="_blank"><?php _e( 'Download the PDF of the work', 'html5blank' ); ?></a></p>
          <?php endif; ?>

          <p class="copy">© Archivio Fausto Melotti</p>
        </div>
                    
      </div>

      <div class="col2">

        <?php if (has_post_thumbnail()) : ?>
        <figure>
          <?php the_post_thumbnail('full'); ?>
        </figure>
        <?php endif; ?>

        <div class="prev"><?php next_post_link_plus(array('post_type' => '"works"', 'in_same_tax' => 'language', 'meta_key' => 'year', 'order_by' => 'numeric', 'format' => '%link')); ?></div>
        <div class="next"><?php previous_post_link_plus(array('post_type' => '"works"', 'in_same_tax' => 'language', 'meta_key' => 'year', 'order_by' => 'numeric', 'format' => '%link')); ?></div>

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