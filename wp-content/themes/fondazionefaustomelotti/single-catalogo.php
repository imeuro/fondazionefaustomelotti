<?php get_header(); ?>

	<?php include('searchform-catalogo.php'); ?>

		<div class="hidden-xs col-sm-3">
			<div data-spy="affix" data-offset-top="0" data-offset-bottom="0">
					<?php include('sidelist-catalogo.php'); ?>
			</div>
		</div>

		<!-- section -->
		<section role="main">

		<?php if (have_posts()): while (have_posts()) : the_post(); ?>

			<article id="post-<?php the_ID(); ?>" <?php post_class(array('col-xs-12 col-sm-9')); ?>">

				<h1>ARTWORK: <strong><?php the_title(); ?></strong></h1>

				<header class="catalogo-opera-single">
					<span class="col-xs-6 text-left">
						<?php
						$operatax = wp_get_post_terms($post->ID, 'tipo_opera');
						if (empty($operatax)) {
							$operatax = wp_get_post_terms($post->ID, 'tipologia_opera');
						}
						if ($operatax) : ?>
							<a class="backlink dotted scheda" href="<?php echo get_term_link($operatax[0]->term_id); ?>" title="<?php echo 'To '.$operatax[0]->name; ?>"><span class="glyphicon glyphicon-menu-left"></span> <?php echo 'To '.$operatax[0]->name; ?></a>
						<?php
						endif; ?>
					</span>
					<span class="col-xs-6 text-right">
						<a class="dotted" href="javascript:slideGently('#operaDetails');" title=""><span class="glyphicon glyphicon-blackboard"></span> Details</a>
						<?php edit_post_link( '<span class="glyphicon glyphicon-pencil"></span> Edit', '&nbsp;&nbsp;&nbsp;&nbsp;', '', '', 'dotted' ); ?>

				</header>
				<?php // slider immagine
				$more_img_opera = get_field('more_img_opera');
				$post_thumbnail_id = get_post_thumbnail_id( $post );
				if ( has_post_thumbnail() && empty($more_img_opera)) : ?>
				<div class="swiper-container NO-swiper-dettaglio-opera">
		      <figure class="swiper-wrapper" id="gallery">
						<?php
						echo '<div class="swiper-slide"><a data-image="'.wp_get_attachment_image_url( $post_thumbnail_id, 'opera-tb' ).'" data-full-image="'.wp_get_attachment_image_url( $post_thumbnail_id, 'full' ).'">'.wp_get_attachment_image( $post_thumbnail_id, 'slide').'</a></div>';
						?>
					</figure>
			</div>
				<?php
				elseif ( has_post_thumbnail() && $more_img_opera) : ?>
				<div class="swiper-container swiper-dettaglio-opera">
					<div class="swiper-pagination"></div>
		      <figure class="swiper-wrapper" id="gallery">
		        <?php
						echo '<div class="swiper-slide"><a data-image="'.wp_get_attachment_image_url( $post_thumbnail_id, 'opera-tb' ).'" data-full-image="'.wp_get_attachment_image_url( $post_thumbnail_id, 'full' ).'">'.wp_get_attachment_image( $post_thumbnail_id, 'slide').'</a></div>';
						foreach($more_img_opera as $img_opera) {
							$pic=wp_get_attachment_image($img_opera[id],'slide');
							$full=wp_get_attachment_image_src($img_opera[id],'full');
							$thumb=wp_get_attachment_image_src($img_opera[id],'opera-tb');
            	echo '<div class="swiper-slide"><a data-image="'.$thumb[0].'" data-full-image="'.$full[0].'">'.$pic.'</a></div>';
						}
						?>
	        </figure>
					<div class="swiper-button-next"></div>
					<div class="swiper-button-prev"></div>
		    </div>
				<?php endif; ?>

				<?php
				if (empty(get_field('exhibited_opera')) || empty(get_field('literature_opera'))) : ?>
				<button class="tab_btn malcelato" data-tab="tab_Details">Details</button>
				<?php
				endif;
				if (!empty(get_field('exhibited_opera')) || !empty(get_field('literature_opera'))) : ?>
				<button class="tab_btn active" data-tab="tab_Details">Details</button>
				<?php
				endif;
				if (!empty(get_field('exhibited_opera'))) : ?>
				<button class="tab_btn" data-tab="tab_Exhibited">Exhibited</button>
				<?php
				endif;
				if (!empty(get_field('literature_opera'))) : ?>
				<button class="tab_btn" data-tab="tab_Literature">Literature</button>
				<?php
				endif;
				?>
				<aside id="operaDetails">
					<ul class="tab_Details active">
						<li class="row">
							<strong class="col-xs-6 col-sm-5">Code</strong>
							<span class="col-xs-6 col-sm-7"><?php the_field('codice_electa'); ?></span>
						</li>
						<li class="row">
							<strong class="col-xs-6 col-sm-5">Title</strong>
							<span class="col-xs-6 col-sm-7"><?php the_title(); ?></span>
						</li>
						<li class="row">
							<strong class="col-xs-6 col-sm-5">Date</strong>
							<span class="col-xs-6 col-sm-7"><?php
								if (!empty(get_field('anno_opera'))) :
									the_field('anno_opera');
								else :
									echo "N/A";
								endif; ?></span>
						</li>
						<li class="row">
							<strong class="col-xs-6 col-sm-5">Medium</strong>
							<span class="col-xs-6 col-sm-7">
							<?php
								$orderedoperamedium = get_the_terms($post->ID, 'materiali');
								if ($orderedoperamedium) :
									$i=0;
									foreach ($orderedoperamedium as $medium) {
										$i++;
										if ($i>1) :
											echo ', ';
										endif;
										echo $medium->name;
										//var_dump($medium);
									}
								endif;
							?>
							</span>
						</li>
						<li class="row">
							<strong class="col-xs-6 col-sm-5">Dimensions</strong>
							<span class="col-xs-6 col-sm-7">
								<?php
								if (!empty(get_field('misure_opera'))) :
									the_field('misure_opera');
								else :
									echo "N/A";
								endif;
								?>
							</span>
						</li>
						<?php
						if (!empty(get_field('museo_opera'))) : ?>
						<li class="row">
							<strong class="col-xs-6 col-sm-5">Museum</strong>
							<span class="col-xs-6 col-sm-7">
								<?php the_field('museo_opera'); ?>
							</span>
						</li>
						<?php
						endif;
						if (!empty(get_field('esemplari_opera'))) : ?>
						<li class="row">
							<strong class="col-xs-6 col-sm-5">Edition</strong>
							<span class="col-xs-6 col-sm-7">
								<?php the_field('esemplari_opera'); ?>
							</span>
						</li>
						<?php
						endif;
						if (!empty(get_field('annotazioni_opera'))) : ?>
						<li class="row">
							<strong class="col-xs-6 col-sm-5">Notes</strong>
							<span class="col-xs-6 col-sm-7">
								<?php the_field('annotazioni_opera'); ?>
							</span>
						</li>
						<?php
						endif;
						?>
					</ul>


					<?php
					if (!empty(get_field('exhibited_opera'))) : ?>
					<ul class="tab_Exhibited">
						<li>
							<span>
								<?php the_field('exhibited_opera'); ?>
							</span>
						</li>
					</ul>
					<?php
					endif;

					if (!empty(get_field('literature_opera'))) : ?>
					<ul class="tab_Literature">
						<li>
							<span>
								<?php the_field('literature_opera'); ?>
							</span>
						</li>
					</ul>
					<?php
					endif;
					?>

				</aside>

			</article>

			<div id="zoom-overlay">
				<div class="container-fluid">
					<header class="row">
						<div class="zoom-opera-title col-xs-12 col-sm-8 col-sm-offset-1">
							<h3><?php the_title(); ?></h3>
							<small><span class="glyphicon glyphicon-info-sign"></span> Move your mouse over the thumbnail on your right to zoom the image</small>
						</div>
						<div class="col-sm-2 text-right">
							<button class="close-zoom">CLOSE <span class="glyphicon glyphicon-remove"></span></button>
						</div>
					</header>
					<div class="row">
						<div class="col-xs-12 col-sm-5 col-sm-offset-1 text-center">
							<div id="zoom-box" style=""></div>
						</div>
						<div class="zoom-container col-xs-4 col-sm-5 text-center">
							<img id="zoom-thumb" src="<?php echo wp_get_attachment_image_url( $post_thumbnail_id, 'slide' ); ?>" data-zoom-image="<?php echo wp_get_attachment_image_url( $post_thumbnail_id, 'full' ); ?>"/>
						</div>
					</div>
				</div>
			</div>
			<style>
				div#zoom-box:after { background: url('<?php echo wp_get_attachment_image_url( $post_thumbnail_id, 'full' ); ?>') no-repeat center center; }
			</style>
		<?php endwhile; ?>

		<?php else: ?>

			<!-- article -->
			<article class="catalogo">

				<h1><?php _e( 'Sorry, nothing to display.', 'html5blank' ); ?></h1>

			</article>
			<!-- /article -->

		<?php endif; ?>

		</section>
		<!-- /section -->

<?php get_footer(); ?>
