<?php /* Template Name: Biografia */ get_header(); ?>
	
	<section role="main">

    <?php if (have_posts()): while (have_posts()) : the_post(); ?>
	
		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

      <div class="col1">
        <?php 
        $children = get_pages('child_of=' . get_the_ID() . '&parent=' . get_the_ID());
        if ($children) :
        ?>
        <nav role="navigation">
          <?php foreach ($children as $child) : ?>
          <a href="<?php echo get_permalink($child->ID); ?>" title="<?php echo get_the_title($child->ID); ?>"><?php echo get_the_title($child->ID); ?></a>
          <?php endforeach; ?>
        </nav>
        <?php endif; ?>

        <?php if( have_rows('foto') ): ?>
        <div class="images">
          <?php while( have_rows('foto') ): the_row(); ?>
          <figure>
            <?php $img = get_sub_field('foto'); ?>
            <img src="<?php echo $img['sizes']['opera-tb']; ?>" alt="<?php echo $img['alt']; ?>">
          </figure>
          <?php endwhile; ?>
        </div>
        <?php endif; ?>
      </div>
      
      <div class="col2">
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