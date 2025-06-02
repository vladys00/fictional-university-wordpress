<?php

    while(have_posts()){
        the_post(); ?>
    <h2> <a href="<?php the_permalink() ?>" >  <?php the_title() ;?> </a></h2>
     <!-- insert the content of the post down here  -->
     <p><?php the_content() ;?></p>
     <hr>

        <?php }

?>