<?php

     get_header();
     pageBanner();?>
     
    <?php while(have_posts()){
        the_post(); ?>
        <div class="container container--narrow page-section">
             <div class="metabox metabox--position-up metabox--with-home-link">
                <p>
                    <a class="metabox__blog-home-link" href="<?php echo get_post_type_archive_link('campus'); ?>">
                        <i class="fa fa-home" aria-hidden="true"></i> 
                        All campuses
                    </a> 
                    <span class="metabox__main"><?php the_title() ?></span>
                </p>
            </div>
       
            <div class="generic-content"><?php the_content() ;?></div>
             <div class="acf-map">
            <?php
                $mapLocation = get_field('map_location')?>
                <div class="marker" data-lat="<?php echo $mapLocation['lat'] ?>"
                    data-lng="<?php echo $mapLocation['lng'] ?>">
                    <h3><?php the_title(); ?></h3>
                    <p>
                        <?php echo $mapLocation['address']; ?>
                    </p>
                </div>
            <?php  ?> 
        </div>




            <?php 
            $relatedPrograms = new WP_Query(array(
              'posts_per_page'=>-1,
              'post_type'=>'program',
              'order_by'=>'title',
              'order'=>'DESC',
              'meta_query'=>array(
                array(
                    'key'=>'related_campus',
                    'compare'=>'LIKE',
                    'value'=> '"'. get_the_ID(). '"',
                )
              )
            ));
            if ($relatedPrograms->have_posts()){
                  echo '<hr class="section-break">';
            echo '<h2 class="headline headline--medium">Programs available at this campus</h2>';
            echo '<ul class="min-list link-list">';
            while ($relatedPrograms->have_posts()){
              $relatedPrograms->the_post(); ?>
            <li >
              <a href="<?php the_permalink();  ?>"><?php the_title(); ?></a>
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
              $homePageEvents->the_post();
              get_template_part('template-parts/content-event');
             }

            }
          
          ?>
        </div>

        

            
        <?php }
    
     get_footer();

?>
