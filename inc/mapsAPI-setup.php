<?php
function universityMapKey($api){
    $api['key'] = getenv('GOOGLE_MAPS_API_KEY');
    return $api;
}

add_filter('acf/fields/google_map/api', 'universityMapKey');
?>