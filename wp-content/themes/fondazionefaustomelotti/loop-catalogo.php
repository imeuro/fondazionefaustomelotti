<?php

$HPcontent = get_field('opere_hp_catalogo','option');

// echo '<pre>';
// var_dump($HPcontent;
// echo '</pre>';

foreach ($HPcontent as $HP_tipologia) {
	$link = get_term_link( $HP_tipologia["HPTipologia"],"tipologia_opera" );
	$title = $HP_tipologia["HPTipologia"]->name;
	echo '<h2 class="header"><a href="'.$link.'">'.$title.'</a></h2>';
	echo '<ul class="items-tipologia home row">';
	//var_dump($HP_tipologia);
		
		foreach ($HP_tipologia["hpopera"] as $HP_opera) {
				echo '<li class="single-item-tipologia col-xs-6 col-sm-3">';
				echo '<a href="'.get_permalink($HP_opera).'">';
				if (has_post_thumbnail($HP_opera)) {
					echo '<figure>';
					echo 	get_the_post_thumbnail( $HP_opera, 'opera-tb', array('class' => 'pic-item-tipologia' ) );
					echo '	<span class="more-details"><span><strong>+</strong>Details</span></span>';
					echo '</figure>';
				} else {
					echo '<div class="nothumbavail">no image';
					echo '	<span class="more-details"><span><strong>+</strong>Details</span></span>';
					echo '</div>';
				}
				echo '</a>';
				echo '</li>';
		}
		
	echo '</ul>';
}
?>
