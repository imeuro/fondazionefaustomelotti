<?php /* Template Name: Mostre */ get_header(); ?>
	
	<section role="main">

    <?php if (have_posts()): while (have_posts()) : the_post(); ?>
	
		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		  
      <div class="col1">

        <header>
          <h2><?php _e( 'Years', 'html5blank' ); ?></h2>
        </header>

        <ul id="years-index">
          <?php
          $mostre = array_reverse(get_field('exhibitions'));
          $count = 0;
          foreach ($mostre as $mostra) :
          ?>
          <li data-id="<?php echo $count; ?>"><span><?php echo $mostra['period']; ?></span></li>
          <?php
            $count++;
          endforeach;
          ?>
        </ul>
      
      </div>

      <div class="col2">

        <header>
          <h2><?php _e( 'Solo exhibitions', 'html5blank' ); ?></h2>
        </header>

        <div class="scrollable-content" id="scrollbar1">
          <?php
          $count = 0;
          foreach ($mostre as $mostra) :
          ?>
          <div id="solo-<?php echo $count; ?>" class="exhibition-block">
            <h3><?php echo $mostra['period']; ?></h3>
            <?php echo $mostra['personal']; ?>
          </div>
          <?php
            $count++;
          endforeach;
          ?>
        </div>
      
      </div>

      <div class="col3">
      
        <header>
          <h2><?php _e( 'Group exhibitions', 'html5blank' ); ?></h2>
        </header>

        <div class="scrollable-content" id="scrollbar2">
          <?php
          $count = 0;
          foreach ($mostre as $mostra) :
          ?>
          <div id="group-<?php echo $count; ?>" class="exhibition-block">
            <h3><?php echo $mostra['period']; ?></h3>
            <?php echo $mostra['collective']; ?>
          </div>
          <?php
            $count++;
          endforeach;
          ?>
        </div>

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