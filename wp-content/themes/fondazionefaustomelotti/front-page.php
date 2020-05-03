<?php get_header(); ?>

<?php

$bgs = get_posts(array(
  'post_type' => 'home-backgrounds',
  'posts_per_page' => 1,
  'meta_key' => 'exhibition',
  'meta_value' => 1,
  'orderby' => 'rand'
));

if (!$bgs) {
  $bgs = get_posts(array(
    'post_type' => 'home-backgrounds',
    'posts_per_page' => 1,
    'orderby' => 'rand'
  ));
}

?>

	<section role="main">

    <?php if ($bgs) : ?>
    <?php foreach ($bgs as $bg) : ?>

    <?php if (has_post_thumbnail($bg->ID)) : ?>
    <?php $image = wp_get_attachment_image_src(get_post_thumbnail_id($bg->ID), 'full'); ?>
    <style>
      body {
        background-image: url(<?php echo $image[0]; ?>);
      }
    </style>
    <?php endif; ?>

    <?php if (!empty($bg->post_content)) : ?>
		<article id="cartouche">
      <?php if (get_field('news', $bg->ID)) : ?>
      <a href="<?php the_field('news', $bg->ID) ?>">
      <?php else : ?>
      <div>
      <?php endif; ?>
        <header>
			    <h2><?php echo get_the_title($bg->ID); ?></h2>
        </header>
        <?php echo apply_filters('the_content', $bg->post_content); ?>
      <?php if (get_field('news', $bg->ID)) : ?>
      </a>
      <?php else : ?>
      </div>
      <?php endif; ?>
		</article>
    <?php endif; ?>
		
    <?php endforeach;?>
	  <?php endif; ?>
	
	</section>

<?php get_footer(); ?>