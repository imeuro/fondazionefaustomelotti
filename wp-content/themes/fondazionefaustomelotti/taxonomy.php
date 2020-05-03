<?php get_header(); ?>

	<?php
	global $term;
	$term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
	?>

	<?php include('searchform-catalogo.php'); ?>

		<div class="hidden-xs col-sm-3">
			<div data-spy="affix" data-offset-top="0" data-offset-bottom="0">
					<?php include('sidelist-catalogo.php'); ?>
			</div>
		</div>

		<!-- section -->
		<section id="ArchivioCatalogo" role="main" class="col-xs-12 col-sm-9">
			<h1>ARTWORKS: <strong><?php echo $term->name; ?></strong></h1>
			<div class="ajContent">
				<?php get_template_part('loop','taxonomy'); ?>

				<?php
				echo '<div id="infscroll-next" class="col-xs-12 col-sm-6 col-sm-push-3 col-md-4 col-md-push-4">';
				get_template_part('pagination');
				echo '</div>'
				?>
			</div>
		</section>
		<!-- /section -->

<?php get_footer(); ?>
