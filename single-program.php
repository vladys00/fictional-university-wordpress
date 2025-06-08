<?php

     get_header();?>
     <div class="page-banner">
        <div class="page-banner__bg-image" style="background-image: url(<?php echo get_theme_file_uri('/images/ocean.jpg') ?>)"></div>
        <div class="page-banner__content container container--narrow">
            <h1 class="page-banner__title"><?php the_title(); ?></h1>
            <div class="page-banner__intro">
                <p>DONT FORGET TO REPLACE ME LATER</p>
            </div>
        </div>
    </div>
    <?php while(have_posts()){
        the_post(); ?>
        <div class="container container--narrow page-section">
             <div class="metabox metabox--position-up metabox--with-home-link">
                <p>
                    <a class="metabox__blog-home-link" href="<?php echo get_post_type_archive_link('program'); ?>">
                        <i class="fa fa-home" aria-hidden="true"></i> 
                        All programs
                    </a> 
                    <span class="metabox__main"><?php the_title() ?></span>
                </p>
            </div>
            <p><?php the_content() ;?></p>


            <?php 
            

            $relatedProfessors = new WP_Query(array(
              'posts_per_page'=>-1,
              'post_type'=>'professor',
              'order_by'=>'title',
              'order'=>'DESC',
              'meta_query'=>array(
                array(
                    'key'=>'related_programs',
                    'compare'=>'LIKE',
                    'value'=> '"'. get_the_ID(). '"',
                )
              )
            ));
            if ($relatedProfessors->have_posts()){
                  echo '<hr class="section-break">';
            echo '<h2 class="headline headline--medium">'. get_the_title() .' Professors</h2>';
            echo '<ul class="professor-cards">';
            while ($relatedProfessors->have_posts()){
              $relatedProfessors->the_post(); ?>
            <li class="professor-card__list-item">
              <a class="professor-card" href="<?php the_permalink();  ?>">
                <img class="professor-card__image" src="<?php the_post_thumbnail(); ?>" alt="">
                <span class="professor-card__name"><?php the_title(); ?></span>
                
              </a>
            </li>
          <?php }
          echo '</ul>';

            }

            wp_reset_postdata();

            $today = date('Ymd');
            $homePageEvents = new WP_Query(array(
              'posts_per_page'=>2,
              'post_type'=>'event',
              'meta_key'=>'event_date',
              'order_by'=>'meta_value_num',
              'order'=>'DESC',
              'meta_query'=>array(
                array(
                  'key'=>'event_date',
                  'compare'=>'>=',
                  'value'=>$today,
                  'type'=>'numeric'
                ),
                array(
                    'key'=>'related_programs',
                    'compare'=>'LIKE',
                    'value'=> '"'. get_the_ID(). '"',
                )
              )
            ));
            if ($homePageEvents->have_posts()){
                  echo '<hr class="section-break">';
            echo '<h2 class="headline headline--medium"> Upcoming '. get_the_title() .' Events</h2>';

            while ($homePageEvents->have_posts()){
              $homePageEvents->the_post(); ?>
                  <div class="event-summary">
            <a class="event-summary__date t-center" href="<?php echo get_permalink() ?>">
              <span class="event-summary__month"><?php 
              $eventDate = new DateTime(get_field('event_date'));
              echo $eventDate->format('M'); 
              ?></span>
              <span class="event-summary__day"><?php 
              echo $eventDate->format('d'); 
              ?></span>
            </a>
            <div class="event-summary__content">
              <h5 class="event-summary__title headline headline--tiny"><a href="<?php echo get_permalink() ?>"><?php the_title(); ?></a></h5>
              <p><?php  if (has_excerpt()){
                echo get_the_excerpt();  // Display the post's excerpt if it exists.
              } else { echo wp_trim_words(get_the_content(), 13);
              }
               ?><a href="<?php echo get_permalink() ?>" class="nu gray">Learn more</a></p>
            </div>
          </div>
          <?php }

            }
          
          ?>
        </div>

            
        <?php }
    
     get_footer();

?>
