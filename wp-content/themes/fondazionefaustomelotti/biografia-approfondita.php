<?php /* Template Name: Biografia Approfondita */ get_header(); ?>
	
	<section role="main">

    <?php if (have_posts()): while (have_posts()) : the_post(); ?>
	
		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		  
      <div class="col1">
        <div class="sticky">
        
          <header>
            <h2><?php _e( 'Index', 'html5blank' ); ?></h2>
          </header>

          <ul id="pages-index">
            <?php
            $pagine = get_field('pagine');
            $count = 0;
            foreach ($pagine as $pagina) :
            ?>
            <li data-id="<?php echo $count; ?>"<?php if($pagina['spazio_sopra'] == '1') : ?> class="top-margin"<?php endif; ?>><span><?php echo $pagina['nome']; ?></span></li>
            <?php
              $count++;
            endforeach;
            ?>
          </ul>

          <?php if (get_field('pdf')) : ?>
          <p class="top-margin"><a class="pdf" href="<?php the_field('pdf'); ?>" title="<?php _e( 'Download the PDF of the byography', 'html5blank' ); ?>" target="_blank"><?php _e( 'Download the PDF of the byography', 'html5blank' ); ?></a></p>
          <?php endif; ?>

        </div>
      </div>

      <div class="col2">

        <header>
          <h2><?php the_title(); ?></h2>
        </header>

        <?php
        $count = 0;
        foreach ($pagine as $pagina) :
        ?>
        <div id="page-<?php echo $count; ?>" class="page-block">
          <h3><?php echo $pagina['nome']; ?></h3>
          <?php echo $pagina['testo']; ?>
        </div>
        <?php
          $count++;
        endforeach;
        ?>
      
      </div>
			
		</article>
		
	  <?php endwhile; ?>
	
	  <?php else: ?>
	
		<article>
			
      <div class="content">
			  <p><?php _e( 'Sorry, nothing to display.', 'html5blank' ); ?></p>
			</div>

		</article>
	
	  <?php endif; ?>
	
	</section>

<?php get_footer(); ?>