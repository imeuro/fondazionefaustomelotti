<?php /* Template Name: Catalogo - Search Results */
get_header();
global $post;
global $swp_query;
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
?>
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

		<?php
		$search_term = $_GET['term'];
		$search_code = $_GET['code'];
		$search_tipologia_opera = $_GET['tipologia_opera'];
		//$search_materiali = $_GET['materiali'];
		$search_anno_opera = $_GET['periodo'];
		$search_museo = $_GET['museo'];


		if(!empty($search_tipologia_opera)) {
			// per capire se e una tipologia o tipo opera
			if ($search_tipologia_opera < 0) {
			 $tax = 'tipo_opera';
			 $search_tipologia_opera = $search_tipologia_opera*(-1);
		 	} else {
				$tax = 'tipologia_opera';
			}
		}

		$args_term ='';
		$args_tipologia ='';

		//base query:
		$args = array(
			'post_type' 				=> 'catalogo',
			'nopaging'					=> false,
			'posts_per_page'		=> 48,
			'paged' 						=> $paged,
			'meta_key'					=> 'anno_opera',
			'meta_key'					=> 'codice_electa',
			'orderby'						=> 'meta_value codice_electa',
			'order'							=> 'ASC'
		);

		// addendum:

		//simple query
		if(!empty($search_term)){
			$args_term = array(
				's' => $search_term,
			);
			$args = array_merge( $args_term, $args );
		}

		// codice electa (non usato ora, sostituito con ricerca tra virgolette es. "cod 001")
		if(!empty($search_code)){
			$args_term = array(
				'meta_key'		=> 'codice_electa',
				'meta_value'	=> $search_code
			);
			$args = array_merge( $args_term, $args );
		}

		// TASSONOMIE:
		$args_taxonomies = array(
			'tax_query' => array(
			)
		);
		if (!empty($search_tipologia_opera) && !empty($search_museo)) {
			$args_taxonomies['tax_query']['relation'] = 'AND';
		}

		if (!empty($search_tipologia_opera)) {
			$args_taxonomies['tax_query'][0] = array(
				'taxonomy' => $tax,
				'field'    => 'term_id',
				'terms'    => $search_tipologia_opera,
			);
		}

		if (!empty($search_museo)) {
			$args_taxonomies['tax_query'][1] = array(
				'taxonomy'  => 'museo',
				'field'   	=> 'term_id',
				'terms'   	=> $search_museo,
			);
		}

		if (!empty($args_taxonomies['tax_query'])) {
			$args = array_merge( $args_taxonomies, $args );
		}

		// anno opera
		if(!empty($search_anno_opera)){
			$periodo = explode('-', $search_anno_opera);
			$args_anno_opera = array(
				'meta_query' => array(
					'relation'  => 'AND',
					array(
						'key'     => 'anno_opera',
						'value'   => $periodo,
						'type'    => 'numeric',
						'compare' => 'BETWEEN',
					),
				),
			);

			$args = array_merge( $args_anno_opera, $args );
		}

		echo '<h5><b>Showing results</b>';
		if (!empty($search_term)) :
			$search_term=str_replace('\"','',$search_term);
			echo ' for <span class="dotted">'.$search_term.'</span>';
		endif;
		//if (!empty($search_code)) :
		//	echo ' for code: <span class="dotted">'.$search_code.'</span>';
		//endif;
		if (!empty($search_tipologia_opera)) :
			$category = get_term_by('term_id',$search_tipologia_opera,'tipologia_opera');
			echo ' in <span class="dotted">'.$category->name.'</span>';
		endif;
		if (!empty($search_materiali)) :
			$materiali = get_term_by('term_id',$search_materiali,'materiali');
			echo ' in <span class="dotted">'.$materiali->name.'</span>';
		endif;
		if (!empty($search_anno_opera)) :
			echo ' in Date: <span class="dotted">'.$search_anno_opera.'</span>';
		endif;
		echo '</h5>';

		$swp_query = new WP_Query( $args );

	if ( $swp_query->have_posts() ) {
		if ($swp_query->found_posts > 1) : $resword = 'results'; else :  $resword = 'result'; endif;
		echo '<h2 class="text-right">'.$swp_query->found_posts.' '.$resword.' found</h2>';
		echo '<a class="backlink dotted searchresults placeholder"><span class="glyphicon glyphicon-menu-left"></span></a>';
		echo '<ul class="items-tipologia infinitescroll row">';
		$i = 0;
		while ( $swp_query->have_posts() ) {
			$i++;
			$swp_query->the_post();
				echo '<li class="single-item-tipologia col-xs-6 col-sm-4 col-md-3 single-item-'.$i.'">';
				echo '<a href="'.get_permalink().'">';
				if (has_post_thumbnail()) {
					echo '<figure>';
					echo 	get_the_post_thumbnail( $post->ID, 'opera-tb', array('class' => 'pic-item-tipologia' ) );
					echo '	<span class="more-details"><span><strong>+</strong>Details</span></span>';
					echo '</figure>';
				} else {
					echo '<div class="nothumbavail">no image';
					echo '	<span class="more-details"><strong>+</strong>Details</span>';
					echo '</div>';
				}
				echo '	<strong>'.get_the_title().'<br />';
				//echo '	<small class="info-opera">Code: '.get_field('codice_electa').'<br />Year: '.get_field('anno_opera').'</small></strong>';
				echo '</a>';
				echo '</li>';
				if ($i == 4) { // defloaters
					$i=0;
				}

		}
		echo '</ul>';
	} else {
		?><p>Sorry, no results found.</p><?php
	}

	// Pagination fix
	$temp_query = $wp_query;
	$wp_query   = NULL;
	$wp_query   = $swp_query;

	//echo '<pre>';
	//var_dump($args);
	//echo '</pre>';

	wp_reset_postdata();

	get_template_part('pagination');

	// Reset main query object
	$wp_query = NULL;
	$wp_query = $temp_query;

	?>
	</div> <!-- ajContent -->
<?php get_footer(); ?>
