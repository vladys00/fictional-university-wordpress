<?php

function universityRegisterSearch (){
    register_rest_route('university/v1', '/search', array(
        'methods' => WP_REST_SERVER::READABLE,
        'callback' => 'universitySearchResults',
    ));
}

add_action('rest_api_init','universityRegisterSearch');

function universitySearchResults ($data) {
    $professors = new WP_Query(array(
        'post_type' => array('professor', 'post' , 'page', 'program', 'event', 'campus'),
        's' => sanitize_text_field($data['term']),
    ));
    $results = array(
        'generalInfo'=>array(),
        'professors'=>array(),
        'programs'=>array(),
        'events'=>array(),
        'campuses'=>array()   
     );

    while ($professors->have_posts()) {
        $professors-> the_post();
        if (get_post_type() == 'page' OR get_post_type() == 'post') {
            array_push($results['generalInfo'], array(
            'title' => get_the_title(),
            'permalink' => get_permalink(),
            'postType' => get_post_type(),
            'authorName' => get_the_author(),
        ));
        }
         if (get_post_type() == 'professor' ) {
            array_push($results['professors'], array(
            'title' => get_the_title(),
            'permalink' => get_permalink(),
        ));
        }
         if (get_post_type() == 'program') {
            array_push($results['programs'], array(
            'title' => get_the_title(),
            'permalink' => get_permalink(),
        ));
        }
         if (get_post_type() == 'event') {
            array_push($results['events'], array(
            'title' => get_the_title(),
            'permalink' => get_permalink(),
        ));
        }
         if (get_post_type() == 'campus') {
            array_push($results['campuses'], array(
            'title' => get_the_title(),
            'permalink' => get_permalink(),
        ));
        }
        

    };

    return $results;
};

?>