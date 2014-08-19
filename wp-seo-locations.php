<?php
/**
 * Plugin Name: WordPress SEO Locations
 * Plugin URI:  https://github.com/Matmon/wordpress-seo-locations
 * Description: WordPress SEO Locations displays one or multiple locations with proper Schema.org markup, Google Static Map images, and links to directions in Google Maps.
 * Version:     0.1.1
 * Author:      Matmon
 * Author URI:  www.matmon.com
 *
 ****************************************************************************
 *
 * Copyright 2014  Matmon  (email : devteam@matmon.com)
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License, version 2, as 
 * published by the Free Software Foundation.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See gpl.txt
 * for more details.
 *
 *****************************************************************************
 */


defined('ABSPATH') or die("No script kiddies please!");
define('WPSEOL_URL', WP_PLUGIN_URL.'/'.str_replace(basename( __FILE__),"",plugin_basename(__FILE__) ) );
define('WPSEOL_SETTINGS', get_bloginfo('wpurl').'/wp-admin/options-general.php?page=wp-seo-locations/options.php' );
include ( dirname( __FILE__ ) .'/options.php' );


  /*******************************************/
 /**** SET DEFAULT OPTIONS ON ACTIVATION ****/
/*******************************************/
function activate_wpseol() {
	if( !get_option( 'wpseol_pin_color' ) )
		update_option( 'wpseol_pin_color', '#FB7064' );
	if( !get_option( 'wpseol_map_width' ) )
		update_option( 'wpseol_map_width', '320' );
	if( !get_option( 'wpseol_map_height' ) )
		update_option( 'wpseol_map_height', '320' );
	if( !get_option( 'wpseol_map_type' ) )
		update_option( 'wpseol_map_type', 'roadmap' );
	if( !get_option( 'wpseol_map_zoom' ) )
		update_option( 'wpseol_map_zoom', '15' );
	if( !get_option( 'wpseol_image_type' ) )
		update_option( 'wpseol_image_type', 'png8' );
}
register_activation_hook( __FILE__, 'activate_wpseol' );


  /*****************************************************************/
 /**** ADD THE SETTINGS LINK TO THE PLUGIN ADMINISTRATION PAGE ****/
/*****************************************************************/
function add_settings_link($links, $file) {
	static $this_plugin;
	if (!$this_plugin) $this_plugin = plugin_basename(__FILE__);
	if ($file == $this_plugin){
		$settings_link = '<a href="'.WPSEOL_SETTINGS.'">'.__("Settings", "wp_seo_locations").'</a>';
		array_unshift($links, $settings_link);
	}
	return $links;
}
add_filter('plugin_action_links', 'add_settings_link', 10, 2 );


  /***************************************/
 /**** GLOBAL ARRAY OF CUSTOM FIELDS ****/
/***************************************/
function location_custom_fields(){
	return array(
		'wpseol_streetAddress'=>array(
			'type'=>'text',
			'label'=>'Street Address',
			'description'=>'Example: 303 West Capitol Ave.'
		),
		'wpseol_addressLocality'=>array(
			'type'=>'text',
			'label'=>'Locality / City',
			'description'=>'Example: Little Rock'
		),
		'wpseol_addressRegion'=>array(
			'type'=>'text',
			'label'=>'Region / State',
			'description'=>'Example: AR'
		),
		'wpseol_postalCode'=>array(
			'type'=>'text',
			'label'=>'Postal Code',
			'description'=>'Example: 72201'
		),
		'wpseol_addressCountry'=>array(
			'type'=>'text',
			'label'=>'Country',
			'description'=>'Example: USA. You can also provide the two-letter <a href="http://en.wikipedia.org/wiki/ISO_3166-1" >ISO 3166-1 alpha-2 country code</a>.'
		),
		'wpseol_telephoneNumber'=>array(
			'type'=>'number',
			'label'=>'Telephone Number',
			'description'=>'Example: 5013754999'
		),
		'wpseol_faxNumber'=>array(
			'type'=>'number',
			'label'=>'Fax Number',
			'description'=>'Example: 5016870192'
		)
	);
}


  /**************************************/
 /**** REGISTER locations POST TYPE ****/
/**************************************/
function wp_seo_locations_post_type() {

	$labels = array(
		'name'                => 'Locations',
		'singular_name'       => 'Location',
		'menu_name'           => 'Locations',
		'parent_item_colon'   => 'Parent Location:',
		'all_items'           => 'All Locations',
		'view_item'           => 'View Location',
		'add_new_item'        => 'Add A New Location ',
		'add_new'             => 'Add New',
		'edit_item'           => 'Edit Location',
		'update_item'         => 'Update Location',
		'search_items'        => 'Search Locations',
		'not_found'           => 'Not found',
		'not_found_in_trash'  => 'Not found in Trash',
	);
	$args = array(
		'label'               => 'locations',
		'description'         => 'SEO Friendly Locations using Schema.org and Google Maps',
		'labels'              => $labels,
		'supports'            => array('title'),
		'hierarchical'        => false,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_nav_menus'   => false,
		'show_in_admin_bar'   => false,
		'menu_position'       => 25,
		'can_export'          => true,
		'has_archive'         => true,
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'capability_type'     => 'page',
	);
	register_post_type( 'locations', $args );
}
add_action( 'init', 'wp_seo_locations_post_type', 0 );


  /*****************************************/
 /**** DISPLAY LOCATIONS CUSTOM FIELDS ****/
/*****************************************/
function location_custom_fields_add() { //Add the Location Information custom fields group to the locations custom post type
  add_meta_box( 'location-meta', 'Location Information', 'location_meta_form', 'locations', 'normal', 'high' );
}
function location_meta_form($post) {
	wp_nonce_field( 'location_nonce', 'location_nonce' );
	$values = get_post_custom($post->ID);
	$fields = location_custom_fields(); ?>
	<table class="form-table" style="width:100%;"><?php
	foreach ($fields as $key => $value) {
		$text = isset($values[$key])? esc_attr( $values[$key][0] ) : ''; ?>
    <tr valign="top">
    	<th scope="row" style="text-align:right;"><label for="<?php echo $key; ?>"><?php echo $value['label']; ?>:</label></th>
  		<td><input type="<?php echo $value['type']; ?>" name="<?php echo $key; ?>" id="<?php echo $key; ?>" value="<?php echo $text; ?>" style="width:100%;"/><p><?php echo $value['description']; ?></p></td>
  	</tr>
    <?php
	} ?>
	</table>
	<p style="text-align:right;"><a href="<?php echo WPSEOL_SETTINGS; ?>" title="">Manage WordPress SEO Locations Settings</a></p>
	<?php
}
add_action( 'add_meta_boxes', 'location_custom_fields_add' );


  /**************************************/
 /**** SAVE LOCATIONS CUSTOM FIELDS ****/
/**************************************/
class wpseolgeocoder{
  static private $url = '//maps.google.com/maps/api/geocode/json?sensor=false';
  static public function getLocation($address,$key){
    $url = self::$url.'&address='.urlencode($address);
    if($key){
    	$url = 'https:'.$url.'&key='.urlencode($key);
    }else{
    	$url = 'http:'.$url;
    }
    $resp_json = self::curl_file_get_contents($url);
    $resp = json_decode($resp_json, true);
    if($resp['status']='OK'){
        return $resp['results'][0]['geometry']['location'];
    }else{
        return false;
    }
  }
  static private function curl_file_get_contents($URL){
    $c = curl_init();
    curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($c, CURLOPT_URL, $URL);
    $contents = curl_exec($c);
    curl_close($c);
    if ($contents) return $contents;
    else return FALSE;
  }
}

function save_location_data($id) {
  if( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) return;
  if( !isset( $_POST['location_nonce'] ) || !wp_verify_nonce( $_POST['location_nonce'], 'location_nonce' ) ) return;
  if( !current_user_can( 'edit_post', $id ) ) return;
  $allowed = array( 
      'a' => array( // only allow anchor tags in meta field (for wp_kses function)
          'href' => array(), // those anchords can only have href attribute
          'title' => array() // 
      )
  );
  $fields = location_custom_fields();
  $address = '';
  foreach ($fields as $key => $value) { //update the DB meta data
  	if(isset($_POST[$key])){
  		update_post_meta( $id, $key, wp_kses($_POST[$key], $allowed) );
  		if($key != 'wpseol_telephoneNumber' && $key != 'wpseol_faxNumber'){
  			$address .= $_POST[$key].' ';
  		}
  	}
  }
  update_post_meta( $id, 'wpseol_full_text_address', $address);
  $geocoding_api_key = get_option('wpseol_google_geocoding_api_key');
  $geocoding_api_key = (!empty($geocoding_api_key))? $geocoding_api_key:false;
  $geocode = wpseolgeocoder::getLocation(trim($address),$geocoding_api_key);
	if($geocode){
		update_post_meta( $id, 'wpseol_latitude', $geocode['lat']);
		update_post_meta( $id, 'wpseol_longitude', $geocode['lng']);
	}else{
		error_log('Unable To Retrieve Geolocation Data For "'.$address.'"');
	}
}
add_action( 'save_post', 'save_location_data' );


  /****************************/
 /**** GET LOCATIONS DATA ****/
/****************************/
function get_wpseo_locations($ids){
	$locations = array();
	$pin_color = str_replace('#','',get_option('wpseol_pin_color'));
	$map_width = get_option('wpseol_map_width');
	$map_height = get_option('wpseol_map_height');
	$map_zoom = get_option('wpseol_map_zoom');
	$map_type = get_option('wpseol_map_type');
	$image_type = get_option('wpseol_image_type');
	$google_static_maps_api_key = get_option('wpseol_google_static_maps_api_key');
	$google_static_maps_api_key = !empty($google_static_maps_api_key)? '&key='.$google_static_maps_api_key : '';
	if(empty($ids) || $ids==null || $ids==''){ //get meta of all locations if no $ids are provided
		$wp_locations = get_posts(array('post_type'=>'locations','orderby'=>'post_date','order'=>'DESC'));
	}else{
		if(!is_array($ids)) $ids = explode(',',$ids);
		$wp_locations = get_posts(array('post_type'=>'locations','orderby'=>'post_date','order'=>'DESC','post__in'=>$ids));
	}
	$fields = location_custom_fields();
	$wp_locations_count = count($wp_locations);
	for($i=0;$i<$wp_locations_count;$i++){

		$values = get_post_custom($wp_locations[$i]->ID);
		foreach ($fields as $key => $value){
			$wp_locations[$i]->$key = !empty($values[$key])? $values[$key][0] : false;
		}

		$latitude = get_post_meta($wp_locations[$i]->ID,'wpseol_latitude',true);
		$wp_locations[$i]->latitude = !empty($latitude)? $latitude : false;

		$longitude = get_post_meta($wp_locations[$i]->ID,'wpseol_longitude',true);
		$wp_locations[$i]->longitude = !empty($longitude)? $longitude : false;

		$full_text_address = get_post_meta($wp_locations[$i]->ID,'wpseol_full_text_address',true);
		$wp_locations[$i]->full_text_address = !empty($full_text_address)? $full_text_address : false;



		$wp_locations[$i]->google_map_image_url = 'https://maps.googleapis.com/maps/api/staticmap?zoom='.$map_zoom.$google_static_maps_api_key.'&size='.$map_width.'x'.$map_height.'&maptype='.$map_type.'&format='.$image_type.'&markers=color:0x'.$pin_color.'|'.$latitude.','.$longitude;
		$wp_locations[$i]->google_map_url = 'https://www.google.com/maps/dir/'.$full_text_address;
	}
	return $wp_locations;
}

function format_phone_number($phone_number){
	if(  preg_match( "/^(\d{3})(\d{3})(\d{4})$/", $phone_number,  $matches ) )
	{
	    $result = $matches[1] . '-' .$matches[2] . '-' . $matches[3];
	    return $result;
	}
}

  /*****************************/
 /**** PRINT LOCATION HTML ****/
/*****************************/
add_shortcode( 'wpseol', 'print_wpseo_locations' );
function print_wpseo_locations($atts=null, $content = null){
	$attributes = shortcode_atts( array(
      'ids' => null,
      'titles' => false,
      'maps'=> false,
      'phones'=> false,
      'faxes'=> false,
      'classes' => ''
  ), $atts );
	$locations = get_wpseo_locations($attributes['ids']);
	$locations_count = count($locations);
	ob_start();
	for($i=0;$i<$locations_count;$i++){ ?>
	  <div id="location_<?php echo $locations[$i]->ID; ?>" class="location <?php echo $attributes['classes']; ?>" itemscope itemtype="http://schema.org/Place"><?php
	  	echo ( ($attributes['titles']===true || $attributes['titles']==='true') && !empty($locations[$i]->post_title) )? '<span itemprop="name" class="name">'.$locations[$i]->post_title.'</span> ' : ''; ?>
			<a class="address" itemprop="address" itemscope itemtype="http://schema.org/PostalAddress" href="<?php echo $locations[$i]->google_map_url; ?>"><?php
				echo ( ($attributes['maps']===true || $attributes['maps']==='true') && $locations[$i]->google_map_image_url )? '<img itemprop="image" class="map" src="'.$locations[$i]->google_map_image_url.'" title="Google Map" alt="Google Map">' : '';
			  echo $locations[$i]->wpseol_streetAddress? '<span itemprop="streetAddress" class="streetAddress">'.$locations[$i]->wpseol_streetAddress.'</span> ' : '';
			  echo $locations[$i]->wpseol_addressLocality? '<span itemprop="addressLocality" class="addressLocality">'.$locations[$i]->wpseol_addressLocality.'</span>' : '';
			  echo ($locations[$i]->wpseol_addressLocality && $locations[$i]->wpseol_addressRegion)? ', ': '';
			  echo $locations[$i]->wpseol_addressRegion? '<span itemprop="addressRegion" class="addressRegion">'.$locations[$i]->wpseol_addressRegion.'</span> ' : '';
			  echo $locations[$i]->wpseol_postalCode? '<span itemprop="postalCode" class="postalCode">'.$locations[$i]->wpseol_postalCode.'</span> ' : '';
			  echo $locations[$i]->wpseol_addressCountry? '<span itemprop="addressCountry" class="addressCountry">'.$locations[$i]->wpseol_addressCountry.'</span>' : '';
			  ?>
			</a><?php
			echo ( ($attributes['phones']===true || $attributes['phones']==='true') && $locations[$i]->wpseol_telephoneNumber )? '<a href="tel:'.$locations[$i]->wpseol_telephoneNumber.'" class="telephone" title="'.$locations[$i]->wpseol_telephoneNumber.'" itemprop="telephone">'.format_phone_number($locations[$i]->wpseol_telephoneNumber).'</a>':'';
			echo ( ($attributes['faxes']===true || $attributes['faxes']==='true') && $locations[$i]->wpseol_faxNumber )? '<a href="tel:'.$locations[$i]->wpseol_faxNumber.'" class="faxNumber" title="'.$locations[$i]->wpseol_faxNumber.'" itemprop="faxNumber">'.format_phone_number($locations[$i]->wpseol_faxNumber).'</a>':''; ?>
		</div>
		<?php
	}
	echo ob_get_clean();
}