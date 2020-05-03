<!doctype html>

<html <?php language_attributes(); ?> class="no-js">

	<head>

		<meta charset="<?php bloginfo('charset'); ?>">

		<title><?php wp_title(''); ?></title>



		<link href="//www.google-analytics.com" rel="dns-prefetch">

    <link href="<?php echo get_template_directory_uri(); ?>/img/icons/favicon.ico" rel="shortcut icon">



		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

		<meta name="viewport" content="width=device-width,initial-scale=1.0">



		<?php wp_head(); ?>



	</head>

	<body <?php body_class(); ?>>



    <div id="hederWrapper">



      <header id="header" role="banner">



        <div id="logo">

          <a href="<?php echo pll_home_url(); ?>">

            <img src="<?php echo get_template_directory_uri(); ?>/img/fondazione-fausto-melotti.png" alt="Fondazione Fausto Melotti" width="194" height="52">

          </a>

        </div>



        <div id="menu">

          <nav id="main-menu" role="navigation" class="nav-collapse">

					  <?php html5blank_nav(); ?>

				  </nav>

          

          <div id="side-menu">

            <nav id="utilities">

              <ul>

                <li class="search"><a href="#" title="<?php echo __( 'Search', 'html5blank' ); ?>"><?php echo __( 'Search', 'html5blank' ); ?></a></li>

              </ul>

            </nav>



            <nav id="languages" role="navigation">

              <ul>

                <?php pll_the_languages(array('hide_if_empty' => 1));?>

              </ul>

            </nav>

          </div>

        </div>



        <div id="search">

          <?php get_template_part('searchform'); ?>

          <a class="close" href="#" title="<?php echo __( 'Close', 'html5blank' ); ?>"><?php echo __( 'Close', 'html5blank' ); ?></a>

        </div>



			</header>



    </div>



		<div id="wrapper">

