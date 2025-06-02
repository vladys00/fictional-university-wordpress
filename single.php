<?php

    while(have_posts()){
        the_post(); ?>
    <h2> <?php the_title() ;?> </h2>
     <!-- insert the content of the post down here  -->
     <p><?php the_content() ;?></p>
     

        <?php }

?>
