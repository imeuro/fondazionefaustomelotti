<?php

/*

 *  Author: Todd Motto | @toddmotto

 *  URL: html5blank.com | @html5blank

 *  Custom functions, support, custom post types and more.

 */



/*------------------------------------*\

	External Modules/Files

\*------------------------------------*/



// Load any external files you have here



/*------------------------------------*\

	Theme Support

\*------------------------------------*/



if (!isset($content_width))

{

    $content_width = 900;

}

function unused_image_sizes( $sizes) {

	unset( $sizes['medium']);
	unset( $sizes['medium_large']);
	unset( $sizes['large']);

	return $sizes;
}
add_filter('intermediate_image_sizes_advanced', 'unused_image_sizes');


if (function_exists('add_theme_support'))

{

    // Add Menu Support
    add_theme_support('menus');

    // Add Thumbnail Theme Support
    add_theme_support('post-thumbnails');
    //add_image_size('large', 700, '', true); // Large Thumbnail
    //add_image_size('medium', 250, '', true); // Medium Thumbnail
    //add_image_size('small', 120, '', true); // Small Thumbnail
    add_image_size('opera-tb', 400, '', false); // Custom Thumbnail Size call using the_post_thumbnail('custom-size');
    add_image_size('slide', 600, 600, false); // Custom Thumbnail Size call using the_post_thumbnail('custom-size');

    // Localisation Support
    load_theme_textdomain('html5blank', get_template_directory() . '/languages');

}



/*------------------------------------*\

	Functions

\*------------------------------------*/



// HTML5 Blank navigation

function html5blank_nav()

{

	wp_nav_menu(

	array(

		'theme_location'  => 'header-menu',

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

		'items_wrap'      => '<ul>%3$s</ul>',

		'depth'           => 0,

		'walker'          => ''

		)

	);

}



// Load HTML5 Blank scripts (header.php)

function html5blank_header_scripts()

{

  if ($GLOBALS['pagenow'] != 'wp-login.php' && !is_admin()) {



    wp_deregister_script('jquery'); // Deregister WordPress jQuery

    //wp_register_script('jquery', 'https://code.jquery.com/jquery-1.10.2.min.js', array(), '1.10.2', true); // Google CDN jQuery
    wp_register_script('jquery', get_template_directory_uri() . '/js/jquery-1.10.2.min.js', array(), '1.10.2', true); // Google CDN jQuery
    wp_enqueue_script('jquery'); // Enqueue it!



    //wp_register_script('conditionizr', 'http://cdnjs.cloudflare.com/ajax/libs/conditionizr.js/4.0.0/conditionizr.js', array(), '4.0.0'); // Conditionizr

    //wp_enqueue_script('conditionizr'); // Enqueue it!



    //wp_register_script('modernizr', 'http://cdnjs.cloudflare.com/ajax/libs/modernizr/2.6.2/modernizr.min.js', array(), '2.6.2'); // Modernizr
    wp_register_script('modernizr', get_template_directory_uri() . '/js/modernizr.min.js', array(), '2.6.2'); // Modernizr
    wp_enqueue_script('modernizr'); // Enqueue it!



    wp_register_script('responsive-nav', get_template_directory_uri() . '/js/responsive-nav.min.js', array(), '1.0.25', true);

    wp_enqueue_script('responsive-nav'); // Enqueue it!



    wp_register_script('html5blankscripts', get_template_directory_uri() . '/js/scripts.min.js', array(), '1.0.0', true); // Custom scripts

    wp_enqueue_script('html5blankscripts'); // Enqueue it!

  }

}



// Load HTML5 Blank conditional scripts

function html5blank_conditional_scripts()

{

  if (is_page_template('bibliografia.php')) {

    wp_register_script('perfect-scrollbar', get_template_directory_uri() . '/js/perfect-scrollbar-0.4.6.with-mousewheel.min.js', array('jquery'), '0.4.6', true);

    wp_enqueue_script('perfect-scrollbar');



    wp_register_script('bibliografia-script', get_template_directory_uri() . '/js/bibliografia.min.js', array('perfect-scrollbar'), '1.0', true);

    wp_enqueue_script('bibliografia-script');

  }



  if (is_page_template('mostre.php')) {

    wp_register_script('perfect-scrollbar', get_template_directory_uri() . '/js/perfect-scrollbar-0.4.6.with-mousewheel.min.js', array('jquery'), '0.4.6', true);

    wp_enqueue_script('perfect-scrollbar');



    wp_register_script('mostre-script', get_template_directory_uri() . '/js/mostre.min.js', array('perfect-scrollbar'), '1.0', true);

    wp_enqueue_script('mostre-script');

  }



  if (is_page_template('opere.php')) {

    wp_register_script('jqueryui', get_template_directory_uri() . '/js/jquery-ui-1.10.4.custom.min.js', array('jquery'), '1.10.4', true);

    wp_enqueue_script('jqueryui');



    wp_register_script('selectboxit', get_template_directory_uri() . '/js/jquery.selectBoxIt.min.js', array('jqueryui'), '3.8.1', true);

    wp_enqueue_script('selectboxit');



    wp_register_script('isotope', get_template_directory_uri() . '/js/isotope.pkgd.min.js', array('jquery'), '2.0.0-beta.8', true);

    wp_enqueue_script('isotope');



    wp_register_script('imagesloaded', get_template_directory_uri() . '/js/imagesloaded.pkgd.min.js', array('jquery'), '3.1.2', true);

    wp_enqueue_script('imagesloaded');



    wp_register_script('opere-script', get_template_directory_uri() . '/js/opere.min.js', array('selectboxit', 'imagesloaded', 'isotope'), '1.0', true);

    wp_enqueue_script('opere-script');

  }



  if (is_page_template('biografia-approfondita.php')) {

    wp_register_script('biografia-approfondita-script', get_template_directory_uri() . '/js/biografia-approfondita.min.js', array(), '1.0', true);

    wp_enqueue_script('biografia-approfondita-script');

  }



  if (is_post_type_archive('news')) {

    wp_register_script('news-archive-script', get_template_directory_uri() . '/js/news-archive.min.js', array(), '1.0', true);

    wp_enqueue_script('news-archive-script');

  }



  if (is_singular('news')) {

    wp_register_script('flex-slider', get_template_directory_uri() . '/js/jquery.flexslider-min.js', array('jquery'), '1.0');

    wp_enqueue_script('flex-slider');



    wp_register_script('news-single-script', get_template_directory_uri() . '/js/news-single.min.js', array('flex-slider'), '1.0');

    wp_enqueue_script('news-single-script');

  }



}



// Load HTML5 Blank styles

function html5blank_styles()

{

  wp_register_style('brandon', get_template_directory_uri() . '/fonts/BrandonGrotesque_web/MyFontsWebfontsKit.css', array(), '1.0', 'all');

  wp_enqueue_style('brandon'); // Enqueue it!



  wp_register_style('reset', get_template_directory_uri() . '/reset.css', array(), '1.0', 'all');

  wp_enqueue_style('reset'); // Enqueue it!



  wp_register_style('html5blank', get_template_directory_uri() . '/style.css', array('reset'), '1.0', 'all');

  wp_enqueue_style('html5blank'); // Enqueue it!

}



// Load HTML5 editor styles

function html5blank_editor_styles() {

  add_editor_style();

}



// Enable more buttons to editor

function html5blank_enable_more_buttons($buttons) {

  $buttons[] = 'sup';

  return $buttons;

}



// Register HTML5 Blank Navigation

function register_html5_menu()

{

  register_nav_menus(array( // Using array to specify more menus if needed

    'header-menu' => __('Header Menu', 'html5blank'), // Main Navigation

    //'sidebar-menu' => __('Sidebar Menu', 'html5blank'), // Sidebar Navigation

    //'extra-menu' => __('Extra Menu', 'html5blank') // Extra Navigation if needed (duplicate as many as you need!)

  ));

}



// Remove the <div> surrounding the dynamic navigation to cleanup markup

function my_wp_nav_menu_args($args = '')

{

  $args['container'] = false;

  return $args;

}



// Remove Injected classes, ID's and Page ID's from Navigation <li> items

function my_css_attributes_filter($var)

{

  return is_array($var) ? array() : '';

}



// Remove invalid rel attribute values in the categorylist

function remove_category_rel_from_category_list($thelist)

{

  return str_replace('rel="category tag"', 'rel="tag"', $thelist);

}



// Add page slug to body class, love this - Credit: Starkers Wordpress Theme

function add_slug_to_body_class($classes)

{

  global $post;

  if (is_home()) {

    $key = array_search('blog', $classes);

    if ($key > -1) {

      unset($classes[$key]);

    }

  } elseif (is_page()) {

    $classes[] = sanitize_html_class($post->post_name);

  } elseif (is_singular()) {

    $classes[] = sanitize_html_class($post->post_name);

  }



  return $classes;

}



// If Dynamic Sidebar Exists

if (function_exists('register_sidebar'))

{

  // Define Sidebar Widget Area 1

  //register_sidebar(array(

  //  'name' => __('Language Switch', 'html5blank'),

  //  'description' => __('Area for language switcher', 'html5blank'),

  //  'id' => 'languages',

  //  'before_widget' => '<div id="%1$s" class="%2$s">',

  //  'after_widget' => '</div>',

  //  'before_title' => '<h3>',

  //  'after_title' => '</h3>'

  //));

}



// Remove wp_head() injected Recent Comment styles

function my_remove_recent_comments_style()

{

  global $wp_widget_factory;

  remove_action('wp_head', array(

    $wp_widget_factory->widgets['WP_Widget_Recent_Comments'],

      'recent_comments_style'

  ));

}



// Pagination for paged posts, Page 1, Page 2, Page 3, with Next and Previous Links, No plugin

function html5wp_pagination()

{

  global $wp_query;

  $big = 999999999;

  echo paginate_links(array(

    'base' => str_replace($big, '%#%', get_pagenum_link($big)),

    'format' => '?paged=%#%',

    'current' => max(1, get_query_var('paged')),

    'total' => $wp_query->max_num_pages

  ));

}



// Custom Excerpts

function html5wp_index($length) // Create 20 Word Callback for Index page Excerpts, call using html5wp_excerpt('html5wp_index');

{

  return 20;

}



// Create 40 Word Callback for Custom Post Excerpts, call using html5wp_excerpt('html5wp_custom_post');

function html5wp_custom_post($length)

{

  return 40;

}



// Create the Custom Excerpts callback

function html5wp_excerpt($length_callback = '', $more_callback = '')

{

  global $post;

  if (function_exists($length_callback)) {

    add_filter('excerpt_length', $length_callback);

  }

  if (function_exists($more_callback)) {

    add_filter('excerpt_more', $more_callback);

  }

  $output = get_the_excerpt();

  $output = apply_filters('wptexturize', $output);

  $output = apply_filters('convert_chars', $output);

  $output = '<p>' . $output . '</p>';

  echo $output;

}



// Custom View Article link to Post

function html5_blank_view_article($more)

{

  global $post;

  return '... <a class="view-article" href="' . get_permalink($post->ID) . '">' . __('View Article', 'html5blank') . '</a>';

}



// Remove Admin bar

function remove_admin_bar()

{

  return false;

}



// Remove 'text/css' from our enqueued stylesheet

function html5_style_remove($tag)

{

  return preg_replace('~\s+type=["\'][^"\']++["\']~', '', $tag);

}



// Remove thumbnail width and height dimensions that prevent fluid images in the_thumbnail

function remove_thumbnail_dimensions( $html )

{

  $html = preg_replace('/(width|height)=\"\d*\"\s/', "", $html);

  return $html;

}



// Custom Gravatar in Settings > Discussion

function html5blankgravatar ($avatar_defaults)

{

  $myavatar = get_template_directory_uri() . '/img/gravatar.jpg';

  $avatar_defaults[$myavatar] = "Custom Gravatar";

  return $avatar_defaults;

}



// Threaded Comments

function enable_threaded_comments()

{

  if (!is_admin()) {

    if (is_singular() AND comments_open() AND (get_option('thread_comments') == 1)) {

      wp_enqueue_script('comment-reply');

    }

  }

}



// Custom Comments Callback

function html5blankcomments($comment, $args, $depth)

{

	$GLOBALS['comment'] = $comment;

	extract($args, EXTR_SKIP);



	if ( 'div' == $args['style'] ) {

		$tag = 'div';

		$add_below = 'comment';

	} else {

		$tag = 'li';

		$add_below = 'div-comment';

	}

?>

    <!-- heads up: starting < for the html tag (li or div) in the next line: -->

    <<?php echo $tag ?> <?php comment_class(empty( $args['has_children'] ) ? '' : 'parent') ?> id="comment-<?php comment_ID() ?>">

	<?php if ( 'div' != $args['style'] ) : ?>

	<div id="div-comment-<?php comment_ID() ?>" class="comment-body">

	<?php endif; ?>

	<div class="comment-author vcard">

	<?php if ($args['avatar_size'] != 0) echo get_avatar( $comment, $args['180'] ); ?>

	<?php printf(__('<cite class="fn">%s</cite> <span class="says">says:</span>'), get_comment_author_link()) ?>

	</div>

<?php if ($comment->comment_approved == '0') : ?>

	<em class="comment-awaiting-moderation"><?php _e('Your comment is awaiting moderation.') ?></em>

	<br />

<?php endif; ?>



	<div class="comment-meta commentmetadata"><a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>">

		<?php

			printf( __('%1$s at %2$s'), get_comment_date(),  get_comment_time()) ?></a><?php edit_comment_link(__('(Edit)'),'  ','' );

		?>

	</div>



	<?php comment_text() ?>



	<div class="reply">

	<?php comment_reply_link(array_merge( $args, array('add_below' => $add_below, 'depth' => $depth, 'max_depth' => $args['max_depth']))) ?>

	</div>

	<?php if ( 'div' != $args['style'] ) : ?>

	</div>

	<?php endif; ?>

<?php }



// Remove menu item from admin

function remove_menus(){



  remove_menu_page( 'edit.php' );

  remove_menu_page( 'edit-comments.php' );



}



// Filter to replace the [caption] shortcode text with HTML5 compliant code

function html5_caption($val, $attr, $content = null)

{

    extract(shortcode_atts(array(

        'id'    => '',

        'align' => '',

        'width' => '',

        'caption' => ''

    ), $attr));



    if ( 1 > (int) $width || empty($caption) )

        return $val;



    $capid = '';

    if ( $id ) {

        $id = esc_attr($id);

        $capid = 'id="figcaption_'. $id . '" ';

        $id = 'id="' . $id . '" aria-labelledby="figcaption_' . $id . '" ';

    }



    return '<figure ' . $id . 'class="wp-caption ' . esc_attr($align) . '" >'

    . do_shortcode( $content ) . '<figcaption ' . $capid

    . 'class="wp-caption-text">' . $caption . '</figcaption></figure>';

}





// Add current item to menu when viewing a single post

function add_current_nav_class($classes, $item)

{

  // Getting the current post details

  global $post;



  // Getting the post type of the current post

  $current_post_type = get_post_type_object(get_post_type($post->ID));

  $current_post_type_slug = $current_post_type->rewrite['slug'];



  // Getting the URL of the menu item

  $menu_slug = strtolower(trim($item->url));



  // If the menu item URL contains the current post types slug add the current-menu-item class

  if (strpos($menu_slug,$current_post_type_slug) !== false) {

    $classes[] = 'current-menu-item';

  }



  // Return the corrected set of classes to be added to the menu item

  return $classes;

}



/*------------------------------------*\

	Actions + Filters + ShortCodes

\*------------------------------------*/



// Add Actions

add_action('init', 'html5blank_header_scripts'); // Add Custom Scripts to wp_head

//add_action('init', 'html5blank_editor_styles'); // Add editor styles

add_action('wp_print_scripts', 'html5blank_conditional_scripts'); // Add Conditional Page Scripts

add_action('get_header', 'enable_threaded_comments'); // Enable Threaded Comments

add_action('wp_enqueue_scripts', 'html5blank_styles'); // Add Theme Stylesheet

add_action('init', 'register_html5_menu'); // Add HTML5 Blank Menu

add_action('init', 'create_post_type_html5'); // Add our HTML5 Blank Custom Post Type

add_action('widgets_init', 'my_remove_recent_comments_style'); // Remove inline Recent Comment Styles from wp_head()

add_action('init', 'html5wp_pagination'); // Add our HTML5 Pagination

add_action('admin_menu', 'remove_menus'); // Remove menu item from admin

add_action('nav_menu_css_class', 'add_current_nav_class', 10, 2); // Add current item to menu when viewing a single post



// Remove Actions

remove_action('wp_head', 'feed_links_extra', 3); // Display the links to the extra feeds such as category feeds

remove_action('wp_head', 'feed_links', 2); // Display the links to the general feeds: Post and Comment Feed

remove_action('wp_head', 'rsd_link'); // Display the link to the Really Simple Discovery service endpoint, EditURI link

remove_action('wp_head', 'wlwmanifest_link'); // Display the link to the Windows Live Writer manifest file.

remove_action('wp_head', 'index_rel_link'); // Index link

remove_action('wp_head', 'parent_post_rel_link', 10, 0); // Prev link

remove_action('wp_head', 'start_post_rel_link', 10, 0); // Start link

remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0); // Display relational links for the posts adjacent to the current post.

remove_action('wp_head', 'wp_generator'); // Display the XHTML generator that is generated on the wp_head hook, WP version

remove_action('wp_head', 'start_post_rel_link', 10, 0);

remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);

remove_action('wp_head', 'rel_canonical');

remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);



// Add Filters

//add_filter('avatar_defaults', 'html5blankgravatar'); // Custom Gravatar in Settings > Discussion

add_filter('body_class', 'add_slug_to_body_class'); // Add slug to body class (Starkers build)

add_filter('widget_text', 'do_shortcode'); // Allow shortcodes in Dynamic Sidebar

add_filter('widget_text', 'shortcode_unautop'); // Remove <p> tags in Dynamic Sidebars (better!)

add_filter('wp_nav_menu_args', 'my_wp_nav_menu_args'); // Remove surrounding <div> from WP Navigation

// add_filter('nav_menu_css_class', 'my_css_attributes_filter', 100, 1); // Remove Navigation <li> injected classes (Commented out by default)

// add_filter('nav_menu_item_id', 'my_css_attributes_filter', 100, 1); // Remove Navigation <li> injected ID (Commented out by default)

// add_filter('page_css_class', 'my_css_attributes_filter', 100, 1); // Remove Navigation <li> Page ID's (Commented out by default)

add_filter('the_category', 'remove_category_rel_from_category_list'); // Remove invalid rel attribute

add_filter('the_excerpt', 'shortcode_unautop'); // Remove auto <p> tags in Excerpt (Manual Excerpts only)

add_filter('the_excerpt', 'do_shortcode'); // Allows Shortcodes to be executed in Excerpt (Manual Excerpts only)

//add_filter('excerpt_more', 'html5_blank_view_article'); // Add 'View Article' button instead of [...] for Excerpts

add_filter('show_admin_bar', 'remove_admin_bar'); // Remove Admin bar

add_filter('style_loader_tag', 'html5_style_remove'); // Remove 'text/css' from enqueued stylesheet

add_filter('post_thumbnail_html', 'remove_thumbnail_dimensions', 10); // Remove width and height dynamic attributes to thumbnails

add_filter('image_send_to_editor', 'remove_thumbnail_dimensions', 10); // Remove width and height dynamic attributes to post images

//add_filter('mce_buttons_2', 'html5blank_enable_more_buttons'); // Add buttons to editor

add_filter( 'wpseo_metabox_prio', function() { return 'low'; }); // Filter Yoast Meta Priority



add_filter('img_caption_shortcode', 'html5_caption', 10, 3);

add_filter('img_caption_shortcode', 'remove_thumbnail_dimensions');

add_filter('wp_caption', 'remove_thumbnail_dimensions', 10);

add_filter('caption', 'remove_thumbnail_dimensions', 10);



// Remove Filters

remove_filter('the_excerpt', 'wpautop'); // Remove <p> tags from Excerpt altogether

remove_filter('relevanssi_hits_filter', 'relevanssi_wpml_filter');



// Shortcodes

add_shortcode('note', 'html5_shortcode_note'); // Place [note num="n"] in Pages, Posts now.



/*------------------------------------*\

	Custom Post Types

\*------------------------------------*/



// Create 1 Custom Post type for a Demo, called HTML5-Blank

function create_post_type_html5()

{

  /*register_taxonomy_for_object_type('category', 'html5-blank'); // Register Taxonomies for Category

    register_taxonomy_for_object_type('post_tag', 'html5-blank');

    register_post_type('html5-blank', // Register Custom Post Type

        array(

        'labels' => array(

            'name' => __('HTML5 Blank Custom Post', 'html5blank'), // Rename these to suit

            'singular_name' => __('HTML5 Blank Custom Post', 'html5blank'),

            'add_new' => __('Add New', 'html5blank'),

            'add_new_item' => __('Add New HTML5 Blank Custom Post', 'html5blank'),

            'edit' => __('Edit', 'html5blank'),

            'edit_item' => __('Edit HTML5 Blank Custom Post', 'html5blank'),

            'new_item' => __('New HTML5 Blank Custom Post', 'html5blank'),

            'view' => __('View HTML5 Blank Custom Post', 'html5blank'),

            'view_item' => __('View HTML5 Blank Custom Post', 'html5blank'),

            'search_items' => __('Search HTML5 Blank Custom Post', 'html5blank'),

            'not_found' => __('No HTML5 Blank Custom Posts found', 'html5blank'),

            'not_found_in_trash' => __('No HTML5 Blank Custom Posts found in Trash', 'html5blank')

        ),

        'public' => true,

        'hierarchical' => true, // Allows your posts to behave like Hierarchy Pages

        'has_archive' => true,

        'supports' => array(

            'title',

            'editor',

            'excerpt',

            'thumbnail'

        ), // Go to Dashboard Custom HTML5 Blank post for supports

        'can_export' => true, // Allows export in Tools > Export

        'taxonomies' => array(

            'post_tag',

            'category'

        ) // Add Category and Post Tags support

    ));*/



  register_taxonomy('work_type', null, array(

		'hierarchical' => false,

		'labels' => array(

			'name' => __( 'Work Types', 'html5blank' ),

			'singular_name' => __( 'Work Type', 'html5blank' ),

			'search_items' =>  __( 'Search Work Types', 'html5blank' ),

			'all_items' => __( 'All Work Types', 'html5blank' ),

			'edit_item' => __( 'Edit Work Type', 'html5blank' ),

			'update_item' => __( 'Update Work Type', 'html5blank' ),

			'add_new_item' => __( 'Add New Work Type', 'html5blank' ),

			'new_item_name' => __( 'New Work Type Name', 'html5blank' ),

			'menu_name' => __( 'Work Types', 'html5blank' ),

		),

	));


/*
  register_post_type('works', // Register Custom Post Type

    array(

      'labels' => array(

        'name' => __('Works', 'html5blank'), // Rename these to suit

        'singular_name' => __('Work', 'html5blank'),

        'add_new' => __('Add New', 'html5blank'),

        'add_new_item' => __('Add New Work', 'html5blank'),

        'edit' => __('Edit', 'html5blank'),

        'edit_item' => __('Edit Work', 'html5blank'),

        'new_item' => __('New Work', 'html5blank'),

        'view' => __('View Work', 'html5blank'),

        'view_item' => __('View Work', 'html5blank'),

        'search_items' => __('Search Work', 'html5blank'),

        'not_found' => __('No Works found', 'html5blank'),

        'not_found_in_trash' => __('No Works found in Trash', 'html5blank')

      ),

      'public' => true,

      'hierarchical' => false, // Allows your posts to behave like Hierarchy Pages

      'has_archive' => false,

      'supports' => array(

        'title',

        'editor',

        'thumbnail',

        'revisions',

      ), // Go to Dashboard Custom HTML5 Blank post for supports

      'taxonomies' => array(

        'work_type'

      ) // Add Category and Post Tags support

  ));
*/


  register_post_type('home-backgrounds', // Register Custom Post Type

    array(

      'labels' => array(

        'name' => __('Home Backgrounds', 'html5blank'), // Rename these to suit

        'singular_name' => __('Home Background', 'html5blank'),

        'add_new' => __('Add New', 'html5blank'),

        'add_new_item' => __('Add New Home Background', 'html5blank'),

        'edit' => __('Edit', 'html5blank'),

        'edit_item' => __('Edit Home Background', 'html5blank'),

        'new_item' => __('New Home Background', 'html5blank'),

        'view' => __('View Home Background', 'html5blank'),

        'view_item' => __('View Home Background', 'html5blank'),

        'search_items' => __('Search Home Background', 'html5blank'),

        'not_found' => __('No Home Backgrounds found', 'html5blank'),

        'not_found_in_trash' => __('No Home Backgrounds found in Trash', 'html5blank')

      ),

      'public' => true,

      'hierarchical' => false, // Allows your posts to behave like Hierarchy Pages

      'has_archive' => false,

      'supports' => array(

        'title',

        'editor',

        'thumbnail',

        'revisions',

      ) // Go to Dashboard Custom HTML5 Blank post for supports

  ));



  register_taxonomy('news_type', null, array(

		'hierarchical' => false,

		'labels' => array(

			'name' => __( 'News Types', 'html5blank' ),

			'singular_name' => __( 'News Type', 'html5blank' ),

			'search_items' =>  __( 'Search News Types', 'html5blank' ),

			'all_items' => __( 'All News Types', 'html5blank' ),

			'edit_item' => __( 'Edit News Type', 'html5blank' ),

			'update_item' => __( 'Update News Type', 'html5blank' ),

			'add_new_item' => __( 'Add New News Type', 'html5blank' ),

			'new_item_name' => __( 'New News Type Name', 'html5blank' ),

			'menu_name' => __( 'News Types', 'html5blank' ),

		),

	));



  register_post_type('news', // Register Custom Post Type

    array(

      'labels' => array(

        'name' => __('News', 'html5blank'), // Rename these to suit

        'singular_name' => __('News', 'html5blank'),

        'add_new' => __('Add New', 'html5blank'),

        'add_new_item' => __('Add New News', 'html5blank'),

        'edit' => __('Edit', 'html5blank'),

        'edit_item' => __('Edit News', 'html5blank'),

        'new_item' => __('New News', 'html5blank'),

        'view' => __('View News', 'html5blank'),

        'view_item' => __('View News', 'html5blank'),

        'search_items' => __('Search News', 'html5blank'),

        'not_found' => __('No News found', 'html5blank'),

        'not_found_in_trash' => __('No News found in Trash', 'html5blank')

      ),

      'public' => true,

      'hierarchical' => false, // Allows your posts to behave like Hierarchy Pages

      'has_archive' => true,

      'supports' => array(

        'title',

        'editor',

        'thumbnail',

        'revisions',

      ), // Go to Dashboard Custom HTML5 Blank post for supports

      'taxonomies' => array(

        'news_type'

      ) // Add Category and Post Tags support

  ));

}



/*------------------------------------*\

	ShortCode Functions

\*------------------------------------*/



// Shortcode note

function html5_shortcode_note($atts, $content = null)

{

  return '<sup>' . $atts['num'] . '</sup><span class="note"><sup>' . $atts['num'] . '</sup> ' . $content . '</span>';

}









?>
