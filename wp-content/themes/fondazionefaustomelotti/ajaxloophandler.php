<?php
// Our include
define('WP_USE_THEMES', false);
require_once('../../../wp-load.php');



if( isset($_GET['ajTax']) ) {
    $Tax = $_GET['ajTax'];
} else {
    $Tax = '';
}
if( isset($_GET['ajTerm']) ) {
    $Term = $_GET['ajTerm'];
} else {
    $Term = '';
}
if( isset($_GET['ajTermId']) ) {
    $TermId = $_GET['ajTermId'];
} else {
    $TermId = '';
}


// immagine scelta da redaz o no?
$realTermId = get_term_by( 'name', $Term, $Tax );
//var_dump($realTermId);

$chosenpost = get_field('sticky_opera_subcat', $Tax . '_' . $realTermId->term_id);
//var_dump($chosenpost);

//echo '$Tax: '.$Tax.' - $Term: '.$Term.' - $TermId: '.$TermId ;

query_posts(array(
	'post_type'				=> array( 'catalogo' ),
	'posts_per_page'	=> 1,
	'nopaging'				=> false,
		'tax_query' 			=> array(
			array(
				'taxonomy' 			=> $Tax,
				'field'    			=> 'slug',
				'terms'    			=> $Term,
				'include_children'=> false
			),
		),
));

// our loop
if (have_posts()) {
	//echo '<h2 class="header"><a href="'.get_term_link( $TermId,$Tax ).'">'.$Term.'</a></h2>';
	while (have_posts()){
		the_post();
		echo '<li class="single-item-tipologia col-xs-6 col-sm-3 single-item-1">';
		echo '<a href="'.get_term_link( $Term,$Tax ).'">';
		if ($chosenpost) {  // se la redaz ha scelto un a foto per la sottocategoria...
			$IMGID = $chosenpost[0]->ID;
		} else {
			$IMGID = $post->ID;
		}
		if (has_post_thumbnail($IMGID)) {
			echo '<figure>';
			echo 	get_the_post_thumbnail( $IMGID, 'opera-tb', array('class' => 'pic-item-tipologia' ) );
			echo '	<span class="more-details"><span><strong>+</strong>Details</span></span>';
			echo '</figure>';
			echo '<strong>'.$Term.'</strong>';
		} else {
			echo '<div class="nothumbavail">no image';
			echo '	<span class="more-details"><span><strong>+</strong>Details</span></span>';
			echo '</div>';
			echo '<strong>'.$Term.'</strong>';
		}
		echo '</a>';
		echo '</li>';

	}
	//echo '<li class="col-xs-12 text-right link-all"><a href="'.get_term_link( $tipologia->term_id,'tipologia_opera' ).'" class="dotted">See more</a></li>';
}
?>
