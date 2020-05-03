<?php /* Template Name: Fondazione */ get_header(); ?>

	<section role="main">

    <?php if (have_posts()): while (have_posts()) : the_post(); ?>

		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

      <div class="col1">

        <header>
          <h2><?php _e( 'Contacts', 'html5blank' ); ?></h2>
        </header>

        <?php if (get_field('map')) : ?>
        <div class="map">
          <?php the_field('map'); ?>
        </div>
        <?php endif; ?>

        <div class="contact1">
          <?php the_field('contact_1'); ?>
        </div>

        <div class="contact2">
          <?php the_field('contact_2'); ?>
        </div>

      </div>

			<div class="col2">

        <div class="content">
          <header>
            <h2><?php _e( 'About', 'html5blank' ); ?></h2>
          </header>

          <?php the_content(); ?>
        </div>

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

			<div class="col3">

        <div class="content">
          <?php the_field('col_3'); ?>
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
