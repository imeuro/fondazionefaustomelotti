<?php /* Template Name: Catalogo */ get_header(); ?>
	<?php include('searchform-catalogo.php'); ?>

		<div class="hidden-xs col-sm-3">
			<div data-spy="affix" data-offset-top="0" data-offset-bottom="0">
					<?php include('sidelist-catalogo.php'); ?>
			</div>
		</div>

		<!-- section -->
		<section id="ArchivioCatalogo" role="main" class="col-xs-12 col-sm-9">

		<h1>ARTWORKS</h1>
		<div class="ajContent">
			<?php get_template_part('loop','catalogo'); ?>
		</div>

		<?php //get_template_part('pagination'); ?>

	</section>
	<!-- /section -->

<?php get_footer(); ?>
