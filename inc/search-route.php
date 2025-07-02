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
            'image'=> get_the_post_thumbnail_url(0, 'professorLandscape'),
        ));
        }
         if (get_post_type() == 'program') {
            $relatedCampuses = get_field('related_campus');
            if($relatedCampuses){
               foreach($relatedCampuses as $campus){
                array_push($results['campuses'], array(
                    'title' => get_the_title($campus),
                    'permalink' => get_permalink($campus),
                ));
               }
            }
            array_push($results['programs'], array(
            'title' => get_the_title(),
            'permalink' => get_permalink(),
            'id'=> get_the_ID()
        ));
        }
         if (get_post_type() == 'event') {
            $eventDate = new DateTime(get_field('event_date'));
            $description = null;
            if (has_excerpt()){
                $description = get_the_excerpt();
            } 
            else { 
                $description = wp_trim_words(get_the_content(), 13);
            }

            array_push($results['events'], array(
            'title' => get_the_title(),
            'permalink' => get_permalink(),
            'month' =>  $eventDate->format('M'),
            'day' => $eventDate->format('d'),
            'description' => $description,
        ));
        }
         if (get_post_type() == 'campus') {
            array_push($results['campuses'], array(
            'title' => get_the_title(),
            'permalink' => get_permalink(),
        ));
        }
        

    };
    if ($results['programs']){
    $programsMetaQuery = array('relation' => 'OR');

    foreach ($results['programs'] as $item) {
        array_push($programsMetaQuery,array(
                'key' => 'related_programs',
                'compare' => 'LIKE',
                'value' => '"' . $item['id']. '"',
        ));
    };

    $programRelationshipQuery = new WP_Query(array(
        'post_type' => array('professor', 'event'),
        'meta_query' => $programsMetaQuery
    ));

    while ($programRelationshipQuery->have_posts()) {
        $programRelationshipQuery -> the_post();

         if (get_post_type() == 'professor' ) {
            array_push($results['professors'], array(
            'title' => get_the_title(),
            'permalink' => get_permalink(),
            'image'=> get_the_post_thumbnail_url(0, 'professorLandscape'),
        ));
        }
        
        if (get_post_type() == 'event') {
            $eventDate = new DateTime(get_field('event_date'));
            $description = null;
            if (has_excerpt()){
                $description = get_the_excerpt();
            } 
            else { 
                $description = wp_trim_words(get_the_content(), 13);
            }

            array_push($results['events'], array(
            'title' => get_the_title(),
            'permalink' => get_permalink(),
            'month' =>  $eventDate->format('M'),
            'day' => $eventDate->format('d'),
            'description' => $description,
        ));
        }
};

    $results['professors'] = array_values(array_unique($results['professors'], SORT_REGULAR));
    $results['events'] = array_values(array_unique($results['events'], SORT_REGULAR));
    };


    return $results;
};

?>