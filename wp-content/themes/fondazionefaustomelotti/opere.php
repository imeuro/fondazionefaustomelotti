<?php /* Template Name: Opere */ get_header(); ?>

<?php

$opere = get_posts(array(
  'post_type' => 'works',
  'posts_per_page' => -1,
  'meta_key' => 'year',
  'orderby' => 'meta_value_num',
  'order' => 'DESC'
));

?>
	
	<section role="main">
    
    <div class="filter">
      <label for="work-type-filter"><?php _e( 'Artwork Type', 'html5blank' ); ?></label>
      <select id="work-type-filter">
        <option value="*"><?php _e( 'All', 'html5blank' ); ?></option>
        <?php
        $types = get_terms('work_type');
        foreach ( $types as $type ) :
        ?>
        <option value="<?php echo $type->slug ?>"><?php echo $type->name ?></option>
        <?php endforeach; ?>
      </select>
    </div>
    
    <div class="items">
      <?php if (have_posts()): while (have_posts()) : the_post(); ?>
		  <article class="item authentic">
        <div class="content">

          <header>
            <h2><?php _e( 'Authentic', 'html5blank' ); ?></h2>
          </header>

          <?php the_content(); ?>

			  </div>
		  </article>
	    <?php endwhile; ?>
      <?php endif; ?>

      <?php if ($opere) : ?>
      <?php foreach ($opere as $opera) : ?>
      <article class="item <?php echo implode(' ', wp_get_post_terms($opera->ID, 'work_type', array('fields' => 'slugs'))); ?>">
        <a href="<?php echo get_permalink($opera->ID); ?>" title="<?php echo get_the_title($opera->ID); ?>">
          
          <?php if (has_post_thumbnail($opera->ID)) : ?>
          <?php $image = wp_get_attachment_image_src(get_post_thumbnail_id($opera->ID), 'opera-tb'); ?>
          <img src="<?php echo $image[0]; ?>" alt="<?php echo get_the_title($opera->ID); ?>">
          <?php endif; ?>

          <div class="info">
            <header>
			        <h2><?php echo get_the_title($opera->ID); ?></h2>
            </header>
            <p><?php echo get_field('year', $opera->ID); ?></p>
          </div>
        
        </a>
      </article>
      <?php endforeach; ?>
	    <?php endif; ?>

    </div>

    <div id="workWrapper">
      <div id="work">
        <div id="loading"></div>
        <div id="work-loader" class="single-works"></div>
        <div id="work-close">
          <a class="close" href="#" title="<?php _e( 'Close', 'html5blank' ); ?>"><?php _e( 'Close', 'html5blank' ); ?></a>
        </div>
	    </div>
	  </div>

  </section>

<?php get_footer(); ?>