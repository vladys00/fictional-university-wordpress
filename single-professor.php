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
            
            <!-- insert the content of the post down here  -->
            <p><?php the_content() ;?></p>

            
            <?php
                $relatedPrograms = get_field('related_programs');
                if ($relatedPrograms){
                    echo '<hr class="section-break">';
                    echo '<h2 class="headline headline--medium">Subject(s) taught</h2>';
                    echo '<ul class="link-list min-list">';
                    foreach($relatedPrograms as $program){?>
                    <li>
                        <a href="<?php echo get_the_permalink($program) ?>"> 
                            <?php echo get_the_title($program) ?>
                        </a>
                    </li>
                    <?php }
                    echo '</ul>';
                }
               
            ?>
        </div>
        <?php }
    
     get_footer();

?>
