<?php
if ( !defined( 'WP_UNINSTALL_PLUGIN' ) ) exit();

delete_option('wpseol_google_geocoding_api_key');
delete_option('wpseol_google_static_maps_api_key');
delete_option('wpseol_pin_color');
delete_option('wpseol_map_width');
delete_option('wpseol_map_height');
delete_option('wpseol_map_type');
delete_option('wpseol_map_zoom');
delete_option('wpseol_image_type');
delete_post_meta_by_key('wpseol_streetAddress');
delete_post_meta_by_key('wpseol_addressLocality');
delete_post_meta_by_key('wpseol_addressRegion');
delete_post_meta_by_key('wpseol_postalCode');
delete_post_meta_by_key('wpseol_addressCountry');
delete_post_meta_by_key('wpseol_latitude');
delete_post_meta_by_key('wpseol_longitude');
delete_post_meta_by_key('wpseol_full_text_address');

global $wpdb;
$posts_table = $wpdb->posts;
$query = "DELETE FROM {$posts_table} WHERE post_type = 'locations'";
$wpdb->query($query);

?>