<?php get_header(); ?>
	
	<section role="main">
	
		<?php if (have_posts()): while (have_posts()) : the_post(); ?>

    <?php
    $bg_url = '';
    if (has_post_thumbnail()) {
      $image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'opera-tb');
      $bg_url = $image[0];
    }
    ?>

    <article>
      <a href="<?php the_permalink(); ?>" data-img="<?php echo $bg_url; ?>">
        <div class="info">
          <h2><?php the_title(); ?></h2>
          <?php if (get_field('sottotitolo')) : ?>
				  <div class="from-bottom">
             <p><?php the_field('sottotitolo'); ?></p>
				  </div>
          <?php endif; ?>
			  </div>
        <div class="labels">
          <div class="label"><?php the_time('Y'); ?></div>
          <div class="label">
            <?php 
            $term = get_field('tipo');
            echo $term->name;
            ?>
          </div>
        </div>
      </a>
    </article>
	
    <?php endwhile; ?>

    <?php else: ?>

	  <article>
		  <h2><?php _e( 'Sorry, nothing to display.', 'html5blank' ); ?></h2>
	  </article>

    <?php endif; ?>
		
		<?php get_template_part('pagination'); ?>
	
	</section>

<?php get_footer(); ?>