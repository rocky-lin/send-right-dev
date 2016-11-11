<?php 
// $forms = DB::table('forms')->first(); 
// print "db tables content ";
// print_r($forms); 
function change_form_id_to_custom_form_id($jsonData, $new_form_id) {
    $decoded = json_decode($jsonData, true);
    // print "<pre>";
    // print_r($decoded);
    $decoded['form_id'] = $new_form_id;
    // print_r($decoded);
    $encoded = json_encode($decoded);
    // print_r($encoded);
    // print "</pre>";
    return $encoded;
}