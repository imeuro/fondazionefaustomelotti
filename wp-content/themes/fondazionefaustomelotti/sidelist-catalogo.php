<?php
/*global $term;
$currentTerm = $term->name;
$tipologia_Terms = get_terms( array(
    'taxonomy' => 'tipologia_opera',
    'hide_empty' => false,
) );
$operatax = wp_get_post_terms($post->ID, 'tipologia_opera');
*/?>
<h4 class="sidelist-heading">Categories:</h4>

<?php
$sidemenu = 	array(
		'theme_location'  => 'sidelist',
		'menu'            => '',
		'container'       => 'div',
		'container_class' => 'menu-{menu slug}-container',
		'container_id'    => '',
		'menu_class'      => 'menu',
		'menu_id'         => '',
		'echo'            => true,
		'fallback_cb'     => 'wp_page_menu',
		'before'          => '',
		'after'           => '',
		'link_before'     => '',
		'link_after'      => '',
		'items_wrap'      => '<ul id="sidelist-tipologia" class="sidelist">%3$s</ul>',
		'depth'           => 0,
		'walker'          => ''
		);

wp_nav_menu( $sidemenu );
?>

<?php
	$searchres_ID = 898;
	if (function_exists('pll_get_post') && ($tr_id = pll_get_post($searchres_ID)) && !empty($tr_id))
		$searchres_ID = pll_get_post($searchres_ID);
	$searchres = get_post($searchres_ID);
	$baseurl = get_permalink($searchres->ID);
	//echo $baseurl.'kk';
?>
<h4 class="sidelist-heading">Date:</h4>
<ul id="sidelist-periodo" class="sidelist">
	<li>
		<a href="<?php echo $baseurl.'?periodo=1918-1929'; ?>">1918 - 1929</a>
	</li>
	<li>
		<a href="<?php echo $baseurl.'?periodo=1930-1939'; ?>">1930 - 1939</a>
	</li>
	<li>
		<a href="<?php echo $baseurl.'?periodo=1940-1949'; ?>">1940 - 1949</a>
	</li>
	<li>
		<a href="<?php echo $baseurl.'?periodo=1950-1959'; ?>">1950 - 1959</a>
	</li>
	<li>
		<a href="<?php echo $baseurl.'?periodo=1960-1969'; ?>">1960 - 1969</a>
	</li>
	<li>
		<a href="<?php echo $baseurl.'?periodo=1970-1979'; ?>">1970 - 1979</a>
	</li>
	<li>
		<a href="<?php echo $baseurl.'?periodo=1980-1986'; ?>">1980 - 1986</a>
	</li>
</ul>
