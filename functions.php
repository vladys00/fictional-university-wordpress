<?php

if (file_exists(__DIR__ . '/.env')) {
    $lines = file(__DIR__ . '/.env', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos(trim($line), '#') === 0) continue;
        list($name, $value) = explode('=', $line, 2);
        putenv(trim($name) . '=' . trim($value));
    }
}
// Customizing the rest api

function university_custom_rest_api () {
    register_rest_field('post','authorname',array(
        'get_callback' => function () {return get_the_author();} 
    ));
}

add_action('rest_api_init','university_custom_rest_api');

// Custom template tags

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

function university_files() {
    wp_enqueue_script('googleMap', '//maps.googleapis.com/maps/api/js?key='.getenv('GOOGLE_MAPS_API_KEY'), NULL, '1.0', true);
    wp_enqueue_script('main-university-js', get_theme_file_uri('/build/index.js'), array('jquery'), '1.0', true);
    wp_enqueue_style('roboto-font', '//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i');
    wp_enqueue_style('font-awesome','//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
    wp_enqueue_style('university-main-styles', get_theme_file_uri('/build/style-index.css'));
    wp_enqueue_style('university-extra-styles', get_theme_file_uri('/build/index.css'));

    wp_localize_script('main-university-js', 'universityData', array(
        'root_url' => get_site_url()

    ));

}


add_action('wp_enqueue_scripts', 'university_files');


function university_features() {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_image_size('professorLandscape', 400, 260, true);
    add_image_size('professorPortrait', 480, 650, true);
    add_image_size('pageBanner', 1500, 350, true);
}

add_action('after_setup_theme', 'university_features');

function adjust_events_query($query) {

    if(!is_admin() && is_post_type_archive('program') && $query->is_main_query()){
        $query->set('order','ASC');
        $query->set('posts_per_page', -1);
        $query->set('orderby','title');
    }

     if(!is_admin() && is_post_type_archive('campus') && $query->is_main_query()){
        $query->set('posts_per_page', -1); 
    }
    
    if(!is_admin() && is_post_type_archive('event') && $query->is_main_query()){
        $today = date('Ymd');
        $query->set('meta_key','event_date');
        $query->set('orderby','meta_value_num');
        $query->set('order','ASC');
        $query->set('meta_query', array(
            array(
                'key'=>'event_date',
                'compare'=>'>=',
                'value'=>$today,
                'type'=>'numeric'
            )
        ));
    }
}

add_action('pre_get_posts','adjust_events_query');

function universityMapKey($api){
    $api['key'] = getenv('GOOGLE_MAPS_API_KEY');
    return $api;
}

add_filter('acf/fields/google_map/api', 'universityMapKey');
?>



