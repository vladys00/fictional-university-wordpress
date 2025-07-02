<?php

function pageBanner($args = NULL) {
    // Title
    if (!isset($args['title'])) {
        $args['title'] = get_the_title();
    }
    
    // Subtitle
    if (!isset($args['subtitle'])) {
        $args['subtitle'] = get_field('page_banner_subtitle');
    }
    // Optional: Handle empty subtitles
    if (empty($args['subtitle'])) {
        $args['subtitle'] = '<!-- No subtitle -->'; 
    }
    
    // Background Image
    if (!isset($args['background_image']) && !is_archive() && !is_home()) {
        if (get_field('page_banner_background_image')) {
            $args['background_image'] = get_field('page_banner_background_image')['sizes']['pageBanner'];
        } else {
            $args['background_image'] = get_theme_file_uri('/images/ocean.jpg');
        }
    }
    // Fallback for all pages (e.g., archives/home)
    if (!isset($args['background_image'])) {
        $args['background_image'] = get_theme_file_uri('/images/ocean.jpg');
    }
    ?>
    <div class="page-banner">
        <div class="page-banner__bg-image" style="background-image: url(<?php echo $args['background_image']; ?>)"></div>
        <div class="page-banner__content container container--narrow">
            <h1 class="page-banner__title"><?php echo $args['title']; ?></h1>
            <div class="page-banner__intro">
                <p><?php echo $args['subtitle']; ?></p>
            </div>
        </div>
    </div>
<?php }

?>