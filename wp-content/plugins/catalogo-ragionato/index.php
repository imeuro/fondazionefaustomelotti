<?php
/*
Plugin Name: Catalogo Ragionato
Plugin URI: http://imeuro.io/
Description: Catalogo Ragionato delle opere in carico alla Fondazione Fausto Melotti
Version: 1.0
Author: Mauro Fioravanzi
Author URI: http://imeuro.io/
*/

// i need bootstrap & co
function catalogo_scriptsnstyles() {
  wp_enqueue_style( 'bootstrap', get_template_directory_uri() . '/bootstrap/css/bootstrap.css', array('reset') );
  wp_enqueue_script( 'bootstrap', get_template_directory_uri() . '/bootstrap/js/bootstrap.js', array('jquery'), '1.0.0', true );

	wp_enqueue_script( 'swiper', plugin_dir_url( __FILE__ ) . 'lib/Swiper-3.3.1/js/swiper.jquery.min.js', array( 'bootstrap' ), '1.0', true );
	wp_enqueue_style( 'swiper', plugin_dir_url( __FILE__ ) .'lib/Swiper-3.3.1/css/swiper.min.css', array('html5blank') );

	wp_enqueue_script( 'elevateZoom', plugin_dir_url( __FILE__ ) . 'lib/elevatezoom/jquery.elevateZoom-3.0.8.min.js', array( 'swiper' ), '1.0', true );

	$cacheBusterCSS = date("mdHi", filemtime( plugin_dir_path( __FILE__ ) .'catalogo-ragionato.css'));
	$cacheBusterJS = date("mdHi", filemtime( plugin_dir_path( __FILE__ ) . 'catalogo-ragionato.js'));

	//echo 'TEST $cacheBusterJS: '.$cacheBusterJS.' | '.plugin_dir_path( __FILE__ ) . 'catalogo-ragionato.js';

  wp_enqueue_style( 'cataloogo', plugin_dir_url( __FILE__ ) .'catalogo-ragionato.css', $cacheBusterCSS, 'all');
  wp_enqueue_script( 'catalogo', plugin_dir_url( __FILE__ ) . 'catalogo-ragionato.js', array('swiper'), $cacheBusterJS, true );
}
add_action( 'wp_enqueue_scripts', 'catalogo_scriptsnstyles' );



// Pagina Opzioni Catalogo (principalmente per foto in HP)
if( function_exists('acf_add_options_page') ) {

    acf_add_options_page(array(
      	'page_title'    => 'Opzioni Catalogo Ragionato',
        'menu_title'    => 'Opz. Catalogo',
        'menu_slug'     => 'catalogo-ragionato-options',
        'capability'    => 'edit_posts',
        'redirect'      => true,
        'icon_url'      => 'dashicons-forms',
        'position'      => 22
    ));

		acf_add_options_sub_page(array(
			'parent_slug'     => 'catalogo-ragionato-options',
			'page_title'    => 'Opzioni immagini categorie',
			'menu_title'    => 'Categorie',
		));
		acf_add_options_sub_page(array(
			'parent_slug'     => 'catalogo-ragionato-options',
			'page_title'    => 'Opzioni immagini sottocategorie',
			'menu_title'    => 'Sottocategorie',
		));


    // acf_add_options_sub_page(array(
    //     'page_title'    => 'update artworks (alpha!)',
    //     'menu_title'    => 'update artworks',
    //     'parent_slug'   => 'catalogo-ragionato-options',
    //     'menu_slug'     => 'update-artworks',
    //     'capability'    => 'edit_options',
    //     'redirect'      => false,
    //     'icon_url'      => 'dashicons-forms',
    //     'position'      => 22.1
    // ));



}


// Aggiornamento opere -> vedi ajax-update-artworks.php
add_action('admin_menu', 'update_artworks_submenu_page');
function update_artworks_submenu_page() {
    add_submenu_page(
        'tools.php',
        'Update Artworks (alpha!)',
        'Update Artworks',
        'manage_options',
        'update-artworks.php',
        'update_artworks_submenu_page_callback' );
}
require_once('ajax-update-artworks.php');




// Register Custom Post Type
function catalogo_ragionato_post_type() {

	$labels = array(
		'name'                  => 'Opere a Catalogo',
		'singular_name'         => 'Opera a catalogo',
		'menu_name'             => 'Catalogo',
		'name_admin_bar'        => 'Catalogo',
		'archives'              => 'Archivio opere',
		'slug'									=> 'catalogue-raisonne',
		//	'parent_item_colon'     => 'Parent Item:',
		'all_items'             => 'Tutte le opere',
		'add_new_item'          => 'Aggiungi opera',
		'add_new'               => 'Aggiungi opera',
		'new_item'              => 'Nuova opera',
		'edit_item'             => 'Modifica opera',
		'update_item'           => 'Aggiorna opera',
		'view_item'             => 'Visualizza opera',
		'search_items'          => 'Cerca opera',
		'not_found'             => 'Non trovata',
		'not_found_in_trash'    => 'Non trovata nel Cestino',
		'featured_image'        => 'Immagine Principale',
		'set_featured_image'    => 'Imposta Immagine Principale',
		'remove_featured_image' => 'Rimuovi Immagine Principale',
		'use_featured_image'    => 'Usa come Immagine Principale',
	//	'insert_into_item'      => 'Insert into item',
	//	'uploaded_to_this_item' => 'Uploaded to this item',
	//	'items_list'            => 'Items list',
	//	'items_list_navigation' => 'Items list navigation',
	//	'filter_items_list'     => 'Filter items list',
	);
	$args = array(
		'label'                 => 'Opera a catalogo',
		'description'           => 'Catalogo Ragionato delle opere della Fondazione',
		'labels'                => $labels,
		'supports'              => array( 'title', 'thumbnail', ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 20,
		'menu_icon'             => 'dashicons-book',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'page',
	);
	register_post_type( 'catalogo', $args );

}
add_action( 'init', 'catalogo_ragionato_post_type', 0 );

add_image_size( 'catalogo-thumb', '180', '125', true );

// add number of opere a catalogo in dashboard
add_filter( 'dashboard_glance_items', 'custom_glance_items', 10, 1 );
function custom_glance_items( $items = array() ) {
  $post_types = array( 'catalogo' );
  foreach( $post_types as $type ) {
    if( ! post_type_exists( $type ) ) continue;
    $num_posts = wp_count_posts( $type );
    if( $num_posts ) {
      $published = intval( $num_posts->publish );
      $post_type = get_post_type_object( $type );
      $text = _n( '%s ' . $post_type->labels->singular_name, '%s ' . $post_type->labels->name, $published, 'your_textdomain' );
      $text = sprintf( $text, number_format_i18n( $published ) );
      if ( current_user_can( $post_type->cap->edit_posts ) ) {
        $output = '<a href="edit.php?post_type=' . $post_type->name . '">' . $text . '</a>';
        echo '<li class="post-count ' . $post_type->name . '-count">' . $output . '</li>';
      } else {
        $output = '<span>' . $text . '</span>';
        echo '<li class="post-count ' . $post_type->name . '-count">' . $output . '</li>';
      }
    }
  }
  return $items;
}

// Register Custom Fields for "Catalogo" post type
function catalogo_ragionato_custom_fields() {
	// qui andr√† inserito il codice esportato da ACF

}
add_action( 'init', 'catalogo_ragionato_custom_fields', 0 );





//create a custom taxonomy name it topics for your posts

function catalogo_ragionato_custom_taxonomy() {

// Add new taxonomy, make it hierarchical like categories
//first do the translations part for GUI
/**
	IMPORTANTE!
 	materiali viene ridefinita poi a riga #456 ~
 	per fix ordinamento tags in ordine di inserimento
**/
  $labels = array(
    'name' => _x( 'Materiali', 'taxonomy general name' ),
    'singular_name' => _x( 'Materiale', 'taxonomy singular name' ),
    'search_items' =>  __( 'Cerca Materiali' ),
    'all_items' => __( 'Tutti i Materiali' ),
    'edit_item' => __( 'Modifica Materiale' ),
    'update_item' => __( 'Aggiorna Materiale' ),
    'add_new_item' => __( 'Aggiungi Nuovo Materiale' ),
    'new_item_name' => __( 'Nuovo Materiale' ),
    'menu_name' => __( 'Materiali' ),
  );
/**
	END
**/

	$labels2 = array(
    'name' => _x( 'Tipologie Opere', 'taxonomy general name' ),
    'singular_name' => _x( 'Tipologia Opera', 'taxonomy singular name' ),
    'search_items' =>  __( 'Cerca Tipologie Opere' ),
    'all_items' => __( 'Tutte le Tipologie Opere' ),
    'edit_item' => __( 'Modifica Tipologie Opere' ),
    'update_item' => __( 'Aggiorna Tipologie Opere' ),
    'add_new_item' => __( 'Aggiungi Nuova Tipologia Opere' ),
    'new_item_name' => __( 'Nuova Tipologia Opere' ),
    'menu_name' => __( 'Tipologie Opere' ),
  );


	$labels3 = array(
    'name' => _x( 'Tipo Opere', 'taxonomy general name' ),
    'singular_name' => _x( 'Tipo Opera', 'taxonomy singular name' ),
    'search_items' =>  __( 'Cerca per Tipo Opere' ),
    'all_items' => __( 'Tutti i Tipi Opere' ),
    'edit_item' => __( 'Modifica Tipo Opere' ),
    'update_item' => __( 'Aggiorna Tipo Opere' ),
    'add_new_item' => __( 'Aggiungi Nuovo Tipo Opere' ),
    'new_item_name' => __( 'Nuovo Tipo Opere' ),
    'menu_name' => __( 'Tipo Opere' ),
  );

	$labels4 = array(
		'name' => _x( 'SubTipo Opere', 'taxonomy general name' ),
		'singular_name' => _x( 'SubTipo Opera', 'taxonomy singular name' ),
		'search_items' =>  __( 'Cerca per SubTipo Opere' ),
		'all_items' => __( 'Tutti i SubTipi Opere' ),
		'edit_item' => __( 'Modifica SubTipo Opere' ),
		'update_item' => __( 'Aggiorna SubTipo Opere' ),
		'add_new_item' => __( 'Aggiungi Nuovo SubTipo Opere' ),
		'new_item_name' => __( 'Nuovo SubTipo Opere' ),
		'menu_name' => __( 'SubTipo Opere' ),
	);
	$labels5 = array(
		'name' => _x( 'Musei', 'taxonomy general name' ),
		'singular_name' => _x( 'Museo', 'taxonomy singular name' ),
		'search_items' =>  __( 'Cerca per Musei' ),
		'all_items' => __( 'Tutti i Musei' ),
		'edit_item' => __( 'Modifica Musei' ),
		'update_item' => __( 'Aggiorna Musei' ),
		'add_new_item' => __( 'Aggiungi Musei' ),
		'new_item_name' => __( 'Nuovo Museo' ),
		'menu_name' => __( 'Musei' )
	);



// Now register the taxonomy
/**
	IMPORTANTE!
 	materiali viene ridefinita poi a riga #456 ~
 	per fix ordinamento tags in ordine di inserimento
**/
  register_taxonomy('materiali',array('catalogo'), array(
    'hierarchical' => false,
    'labels' => $labels,
    'show_ui' => true,
    'show_admin_column' => true,
    'query_var' => true,
    'rewrite' => array( 'slug' => 'catalogo-materiali' ),
  ));
/**
	END
**/


	register_taxonomy('tipologia_opera',array('catalogo'), array(
    'hierarchical' => false,
    'labels' => $labels2,
    'show_ui' => true,
    'show_admin_column' => true,
    'query_var' => true,
    'rewrite' => array( 'slug' => 'catalogo-tipologie' ),
  ));

	register_taxonomy('tipo_opera',array('catalogo'), array(
    'hierarchical' => false,
    'labels' => $labels3,
    'show_ui' => true,
    'show_admin_column' => true,
    'query_var' => true,
    'rewrite' => array( 'slug' => 'catalogo-tipo' ),
  ));

	register_taxonomy('subtipo_opera',array('catalogo'), array(
    'hierarchical' => false,
    'labels' => $labels4,
    'show_ui' => true,
    'show_admin_column' => true,
    'query_var' => true,
    'rewrite' => array( 'slug' => 'catalogo-subtipo' ),
  ));
	register_taxonomy('museo',array('catalogo'), array(
    'hierarchical' => false,
    'labels' => $labels5,
    'show_ui' => false,
    'show_admin_column' => true,
    'query_var' => true,
  ));

}

// Register Custom Taxonomy
add_action( 'init', 'catalogo_ragionato_custom_taxonomy', 0 );

// polylang strings
add_action( 'plugins_loaded', 'load_custom_translations' );
function load_custom_translations() {
    require "translations.php"; // custom translations: after all plugins (polylang, mainly) are loaded!
}

// Register sidelist menu
function ffm_sidelist_navi() {

  $locations = array(
    'sidelist' => __( 'Navigation menu in sidebar', '' ),
  );
  register_nav_menus( $locations );

}
add_action( 'init', 'ffm_sidelist_navi' );

// sortable column in backend
// https://wpdreamer.com/2014/04/how-to-make-your-wordpress-admin-columns-sortable/
add_filter( 'manage_edit-catalogo_sortable_columns', 'ffm_sortable_columns' );
function ffm_sortable_columns( $sortable_columns ) {
  $sortable_columns[ 'column-taxonomy' ] = 'tipologia_opera';
   $sortable_columns[ 'column-meta' ] = 'anno_opera';
   $sortable_columns[ 'column-meta-2' ] = 'codice_electa';
   // $sortable_columns[ 'column-featured_image' ] = 'thumbnail_id';
	 return $sortable_columns;
}
add_action( 'pre_get_posts', 'manage_wp_posts_be_qe_pre_get_posts', 1 );
function manage_wp_posts_be_qe_pre_get_posts( $query ) {
   if ( $query->is_main_query() && ( $orderby = $query->get( 'orderby' ) ) ) {
      switch( $orderby ) {
        case 'anno_opera':
              $query->set( 'meta_key', 'anno_opera' );
              $query->set( 'orderby', 'meta_value' );
              break;
       case 'codice_electa':
          $query->set( 'meta_key', 'codice_electa' );
          $query->set( 'orderby', 'meta_value' );
          break;
        // case 'column-featured_image':
        //    $query->set( 'meta_key', 'thumbnail_id' );
        //    $query->set( 'compare', '==' );
        //    $query->set( 'value', '' );
        //    $query->set( 'orderby', 'meta_value' );
        //    break;
      }
   }
}


/**
 * Extend WordPress search to include custom fields
 *
 * http://adambalee.com
 */

/**
 * Join posts and postmeta tables
 *
 * http://codex.wordpress.org/Plugin_API/Filter_Reference/posts_join
 */
function cf_search_join( $join ) {
    global $wpdb;
    if ( (is_search() && is_admin()) || is_page_template('searchresults-catalogo.php') ) {
        $join .=' LEFT JOIN '.$wpdb->postmeta. ' p  ON '. $wpdb->posts . '.ID = p.post_id ';
    }
    return $join;
}
add_filter('posts_join', 'cf_search_join' );

/**
 * Modify the search query with posts_where
 * extending search only to 'codice_electa' field
 *
 * http://codex.wordpress.org/Plugin_API/Filter_Reference/posts_where
 */
function cf_search_where( $where ) {
    global $pagenow, $wpdb;
		if ( (is_search() && is_admin()) || is_page_template('searchresults-catalogo.php') || is_page('catalogo-ragionato-options') ) {
        // if ($_GET["exact-term"] === 'on') {
        //   $where = preg_replace(
        //     "/\(\s*".$wpdb->posts.".post_title\s+LIKE\s*(\'[^\']+\')\s*\)/",
        //     "(p.meta_value LIKE $1 AND p.meta_key = 'codice_electa')", $where );
        // } else {
        $where = preg_replace(
            "/\(\s*".$wpdb->posts.".post_title\s+LIKE\s*(\'[^\']+\')\s*\)/",
            "(".$wpdb->posts.".post_title LIKE $1) OR (p.meta_value LIKE $1 AND p.meta_key = 'codice_electa')", $where );
        // }
    }
    return $where;
}
add_filter( 'posts_where', 'cf_search_where' );




add_action('pre_get_posts', 'my_make_search_exact', 10);
function my_make_search_exact($query){
  if(!is_admin() && $query->is_search && $_GET["exact-term"] === 'on') :
    $query->set('exact', true);
  endif;
}


/**
 * Prevent duplicates
 *
 * http://codex.wordpress.org/Plugin_API/Filter_Reference/posts_distinct
 */
function cf_search_distinct( $where ) {
    global $wpdb;
		if ( (is_search() && is_admin()) || is_page_template('searchresults-catalogo.php') ) {
        return "DISTINCT";
    }
    return $where;
}
add_filter( 'posts_distinct', 'cf_search_distinct' );


// adds [codice_electa] before titolo opera in acf relationships
function my_relationship_result( $title, $post, $field, $post_id ) {
	// load a custom field from this $object and show it in the $result
	$codice_electa = get_field('codice_electa', $post->ID);
	// append to title
	$title = '[' . $codice_electa .  '] '.$title;
	// return
	return $title;
}
// filter for every field
add_filter('acf/fields/relationship/result', 'my_relationship_result', 10, 4);




// nome template in pagina:
// get_current_template(true)
add_filter( 'template_include', 'var_template_include', 1000 );
function var_template_include( $t ){
    $GLOBALS['current_theme_template'] = basename($t);
    return $t;
}

function get_current_template( $echo = false ) {
    if( !isset( $GLOBALS['current_theme_template'] ) )
        return false;
    if( $echo )
        echo $GLOBALS['current_theme_template'];
    else
        return $GLOBALS['current_theme_template'];
}




function get_menu_parent( $menu, $post_id = null ) {

    $post_id        = $post_id ? : get_the_ID();
    $menu_items     = wp_get_nav_menu_items( $menu );
    $parent_item_id = wp_filter_object_list( $menu_items, array( 'object_id' => $post_id ), 'and', 'menu_item_parent' );

    if ( ! empty( $parent_item_id ) ) {
        $parent_item_id = array_shift( $parent_item_id );
        $parent_post_id = wp_filter_object_list( $menu_items, array( 'ID' => $parent_item_id ), 'and', 'object_id' );

        if ( ! empty( $parent_post_id ) ) {
            $parent_post_id = array_shift( $parent_post_id );

            return get_post( $parent_post_id );
        }
    }

    return false;
}


// tentativo III:  taxonomy materiali in ordine di inserimento
// https://core.trac.wordpress.org/ticket/9547#comment:7

/**
 * Sort post_tags by term_order
 *
 * @param array $terms array of objects to be replaced with sorted list
 * @param integer $id post id
 * @param string $taxonomy only 'post_tag' is changed.
 * @return array of objects
 */
function plugin_get_the_ordered_terms ( $terms, $id, $taxonomy ) {
	if ( 'materiali' != $taxonomy ) // only ordering tags for now but could add other taxonomies here.
		return $terms;

	$terms = wp_cache_get($id, "{$taxonomy}_relationships_sorted");
	if ( false === $terms ) {
		$terms = wp_get_object_terms( $id, $taxonomy, array( 'orderby' => 'term_order' ) );
		wp_cache_add($id, $terms, $taxonomy . '_relationships_sorted');
	}

	return $terms;
}

add_filter( 'get_the_terms', 'plugin_get_the_ordered_terms' , 10, 4 );

/**
 * Adds sorting by term_order to materiali by doing a partial register replacing
 * the default
 */
function plugin_register_sorted_materiali () {
	//register_taxonomy( 'materiali', 'post', array( 'sort' => true, 'args' => array( 'orderby' => 'term_order' ) ) );

	$labels = array(
		'name' => _x( 'Materiali', 'taxonomy general name' ),
		'singular_name' => _x( 'Materiale', 'taxonomy singular name' ),
		'search_items' =>  __( 'Cerca Materiali' ),
		'all_items' => __( 'Tutti i Materiali' ),
		'edit_item' => __( 'Modifica Materiale' ),
		'update_item' => __( 'Aggiorna Materiale' ),
		'add_new_item' => __( 'Aggiungi Nuovo Materiale' ),
		'new_item_name' => __( 'Nuovo Materiale' ),
		'menu_name' => __( 'Materiali' ),
	);

	register_taxonomy( 'materiali',array('catalogo'), array(
    'hierarchical' => false,
    'labels' => $labels,
    'show_ui' => true,
    'show_admin_column' => true,
    'query_var' => true,
    'rewrite' => array( 'slug' => 'catalogo-materiali' ),
		'sort' => true,
		'args' => array( 'orderby' => 'term_order' )
  ) );
}

add_action( 'init', 'plugin_register_sorted_materiali' );


// orderby taxonomy 'subtipo_opera' term
// http://scribu.net/wordpress/sortable-taxonomy-columns.html
// https://gist.github.com/mikeschinkel/18373486fb1900319f2a
function subtipo_opera_orderby( $orderby, $wp_query ) {
	global $wpdb;

	if ( isset( $wp_query->query['orderby'] ) && 'subtipo_opera anno_opera' == $wp_query->query['orderby'] ) {
		$orderby = "(
			SELECT GROUP_CONCAT(name ORDER BY name ASC)
			FROM $wpdb->term_relationships
			INNER JOIN $wpdb->term_taxonomy USING (term_taxonomy_id)
			INNER JOIN $wpdb->terms USING (term_id)
			WHERE $wpdb->posts.ID = object_id
			AND (taxonomy = 'subtipo_opera' OR taxonomy IS NULL)
			GROUP BY object_id
		) ";

		$orderby .= ( 'ASC' == strtoupper( $wp_query->get('order') ) ) ? 'ASC' : 'DESC';
	}
	return $orderby;
}
//add_filter( 'posts_orderby', 'subtipo_opera_orderby', 10, 2 );



function color_clauses_mike( $clauses, $wp_query ) {
	global $wpdb;

	if ( isset( $wp_query->query['orderby'] ) && 'subtipo_opera anno_opera' == $wp_query->query['orderby'] ) {

		$clauses['join'] .= <<<SQL
LEFT OUTER JOIN {$wpdb->term_relationships} ON {$wpdb->posts}.ID={$wpdb->term_relationships}.object_id
LEFT OUTER JOIN {$wpdb->term_taxonomy} USING (term_taxonomy_id)
LEFT OUTER JOIN {$wpdb->terms} USING (term_id)
SQL;

		$clauses['where'] .= " AND (taxonomy = 'subtipo_opera' OR taxonomy IS NULL) AND (taxonomy = 'tipo_opera')";
		$clauses['groupby'] = "object_id";
		$clauses['orderby']  = "GROUP_CONCAT({$wpdb->terms}.name ORDER BY name ASC) ";
		$clauses['orderby'] .= ( 'ASC' == strtoupper( $wp_query->get('order') ) ) ? 'ASC' : 'DESC';
	}

	return $clauses;
}
//add_filter( 'posts_clauses', 'color_clauses_mike', 10, 2 );


function filter_taxquery( $query ) {
    $query .= ', anno_opera ASC';
    return $query;
}

?>
