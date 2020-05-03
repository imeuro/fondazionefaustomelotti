<?php
global $term;
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
// var_dump($term);
// echo "<br>______".$term->slug;
	$args = array (
		'post_type'								=> array( 'catalogo' ),
		'nopaging'								=> false,
		'posts_per_page'					=> 48,
		'paged' 									=> $paged,
		//'relation' => 'OR',
		'tax_query'								=> array(
			array(
				'taxonomy' 		=> $term->taxonomy,
				'field'    		=> 'slug',
				'terms'    		=> $term->slug,
			),
		),
	);

	if ($term->slug == 'animals' || $term->slug == 'bowls' || $term->slug == 'plates' || $term->slug == 'vases') { // se sottocategorie di ceramics aggiungo ordinameto per subtipo opera e anno
		$args['meta_query'] = array(
        'tipo_clause' => array(
            'key' 			=> 'subtipo_opera',
						'compare' => 'EXISTS'
        ),
        'anno_clause' => array(
            'key' 			=> 'anno_opera',
						'compare' => 'EXISTS'
        )
    );
		$args['orderby'] = array(
        'tipo_clause' => 'ASC',
        'anno_clause' => 'ASC'
    );
	} else {
		$args['meta_query'] = array(
        'anno_clause' => array(
            'key' 			=> 'anno_opera',
						'compare' => 'EXISTS'
        ),
        'codice_clause' => array(
            'key' 			=> 'codice_electa',
						'compare' => 'EXISTS'
        )
    );
		$args['orderby'] = array(
        'anno_clause' => 'ASC',
				'codice_clause' => 'ASC'
    );
	}

	$query_front_Catalogo = new WP_Query( $args );


	if ( $query_front_Catalogo->have_posts() ) {
		//if ($term->taxonomy == 'tipo_opera') { echo '_______sottocategoria!'; } else {echo '_______categoria!';}
		//if ($term->slug == 'animals' || $term->slug == 'bowls' || $term->slug == 'plates' || $term->slug == 'vases') { echo '<br>_______ceramics!'; } else {echo '<br>_______else!';}

		echo '<h2 class="text-right">'.$term->count.' results found</h2>';

		echo '<a class="backlink dotted taxonomy placeholder"><span class="glyphicon glyphicon-menu-left"></span></a>';

		echo '<ul class="items-tipologia infinitescroll row">';
		$i = 0;
		while ( $query_front_Catalogo->have_posts() ) {
			$i++;
			$query_front_Catalogo->the_post();


			/**
			temp functions, run just once!!!
			*/
			/**
			"circa" alla fine in ACF anno_opera
			*/
			/*
			$year = get_field('anno_opera');
			if (substr( $year, 0, 6 ) === "circa ") {
				$yearupd = substr( $year, 6 )." circa";
				echo $yearupd;
				update_field('anno_opera', $yearupd, $post->ID);
			}
			*/
			/**
			da taxonomy "subtipo_opera" a ACF "subtipo _opera"
			*/
			/*
			$terms = wp_get_post_terms($post->ID, 'subtipo_opera', array( 'fields' => 'names' ) );
			$termlist = '';
			if ( ! empty( $terms ) && ! is_wp_error( $terms ) ){
					foreach ( $terms as $term ) {
							$termlist .= $term;
					}
			}
			//echo '$termlist: '.$termlist;
			if ($termlist != '') {
				echo 'updating... with '.$termlist;
				update_field('subtipo_opera', $termlist, $post->ID);
			}
			*/


				echo '<li class="single-item-tipologia col-xs-6 col-sm-4 col-md-3 single-item-'.$i.'">';
				echo '<a href="'.get_permalink().'">';
				if (has_post_thumbnail()) {
					echo '<figure>';
					echo 	get_the_post_thumbnail( $post->ID, 'opera-tb', array('class' => 'pic-item-tipologia', 'alt' => get_the_title() ) );
					echo '	<span class="more-details"><span><strong>+</strong>Details</span></span>';
					echo '</figure>';
				} else {
					echo '<div class="nothumbavail">no image';
					echo '	<span class="more-details"><span><strong>+</strong>Details</span></span>';
					echo '</div>';
				}
				echo '	<strong>'.get_the_title();

				if ($_SERVER['SERVER_NAME'] != 'www.fondazionefaustomelotti.org') :
					echo '<br>'.get_field('subtipo_opera').'<small class="info-opera"><br>Code: '.get_field('codice_electa').'<br />Year: '.get_field('anno_opera').'</small>';
				endif;
				echo '  </strong>';
				echo '</a>';
				echo '</li>';
				if ($i == 4) { // defloaters
					$i=0;
				}

		}
		echo '</ul>';
	}

	wp_reset_postdata();
?>
