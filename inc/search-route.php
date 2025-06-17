<?php

function universityRegisterSearch (){
    register_rest_route('university/v1', '/search', array(
        'methods' => 'GET',
        'callback' => 'universitySearchResults',
    ));
}

add_action('rest_api_init','universityRegisterSearch');

function universitySearchResults () {
    return 'Congratualations, you greated a new rote ! ';
};

?>