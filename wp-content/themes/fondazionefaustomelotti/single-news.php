<?php get_header(); ?>
	
	<section role="main">
	
    <?php if (have_posts()): while (have_posts()) : the_post(); ?>
	
		<article>
		
			<div class="col1">
        <h1><?php the_title(); ?></h1>
        <?php if (get_field('sottotitolo')) : ?>
        <p><?php the_field('sottotitolo'); ?></p>
        <?php endif; ?>
      </div>

      <div class="col2">

        <?php the_content(); ?>

        <?php if( have_rows('foto') ): ?>
        <div class="flexslider">
          <ul class="slides">
            <?php while( have_rows('foto') ): the_row(); ?>
            <li>
              <?php $img = get_sub_field('foto'); ?>
              <img src="<?php echo $img['sizes']['slide']; ?>" alt="<?php echo $img['alt']; ?>">
            </li>
            <?php endwhile; ?>
          </ul>
        </div>
        <?php endif; ?>

        <nav class="post-nav" role="navigation">
          <div class="prev">
            <?php next_post_link('%link', __( 'next news', 'html5blank' )); ?>
          </div>
          <div class="next">
            <?php previous_post_link('%link', __( 'previous news', 'html5blank' )); ?>
          </div>
        </nav>

      </div>

		</article>
		
    <?php endwhile; ?>	
  	<?php endif; ?>
	
	</section>

<?php get_footer(); ?>