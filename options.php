<?php

function wpseol_settings_page() { ?>
  <div class="wrap">
    <h2><img src="<?php echo WPSEOL_URL.'/images/matmon_logo.png'; ?>" style="vertical-align:bottom;"> WordPress SEO Locations Settings</h2>
    <hr/>
    <form method="post" action="options.php"><?php 
      settings_fields( 'wpseol-settings' );
      do_settings_sections( 'wpseol-settings' ); ?>
      <table class="form-table">
        <tr valign="top">
          <th scope="row">Google Geocoding API Key</th>
          <td>
            <input type="text" name="wpseol_google_geocoding_api_key" id="wpseol_google_geocoding_api_key" value="<?php echo esc_attr( get_option('wpseol_google_geocoding_api_key') ); ?>" />
            <p>Please read <a href="https://developers.google.com/maps/documentation/geocoding/" title="The Google Geocoding API">The Google Geocoding API Documentation</a>
            regarding <a href="https://developers.google.com/maps/documentation/geocoding/#api_key">API key requirements</a>, and
            <a href="https://developers.google.com/maps/documentation/geocoding/#Limits">usage limits</a>.</p>
          </td>
        </tr>
         
        <tr valign="top">
          <th scope="row">Google Static Maps API Key</th>
          <td>
            <input type="text" name="wpseol_google_static_maps_api_key" id="wpseol_google_static_maps_api_key" value="<?php echo esc_attr( get_option('wpseol_google_static_maps_api_key') ); ?>" />
            <p>Please read <a href="https://developers.google.com/maps/documentation/staticmaps/" title="The Static Maps API API">The Static Maps API Documentation</a>
            regarding <a href="https://developers.google.com/maps/documentation/staticmaps/#api_key">API key requirements</a>, and
            <a href="https://developers.google.com/maps/documentation/staticmaps/#Limits">usage limits</a>.</p>
          </td>
        </tr>
        
        <tr valign="top">
          <th scope="row">Map Type</th>
          <td>
            <select name="wpseol_map_type" id="wpseol_map_type">
              <?php $map_type = esc_attr( get_option('wpseol_map_type') ); ?>
              <option value="roadmap" <?php if($map_type=='roadmap'){ echo 'selected="selected"';} ?> >roadmap</option>
              <option value="satellite" <?php if($map_type=='satellite'){ echo 'selected="selected"';} ?> >satellite</option>
              <option value="terrain" <?php if($map_type=='terrain'){ echo 'selected="selected"';} ?> >terrain</option>
              <option value="hybrid" <?php if($map_type=='hybrid'){ echo 'selected="selected"';} ?> >hybrid</option>
            </select>
          </td>
        </tr>

        <tr valign="top">
          <th scope="row">Image Type</th>
          <td>
            <select name="wpseol_image_type" id="wpseol_image_type">
              <?php $image_type = esc_attr( get_option('wpseol_image_type') ); ?>
              <option value="png32" <?php if($image_type=='png32'){ echo 'selected="selected"';} ?> >png32 (Highest Quality)</option>
              <option value="gif" <?php if($image_type=='gif'){ echo 'selected="selected"';} ?> >gif (High Quality)</option>
              <option value="png8" <?php if($image_type=='png8'){ echo 'selected="selected"';} ?> >png8 (Medium Quality)</option>
              <option value="jpg" <?php if($image_type=='jpg'){ echo 'selected="selected"';} ?> >jpg (Low Quality)</option>
              <option value="jpg-baseline" <?php if($image_type=='jpg-baseline'){ echo 'selected="selected"';} ?> >jpg-baseline (Lowest Quality)</option>
            </select>
          </td>
        </tr>

        <tr valign="top">
          <th scope="row">Pin Color</th>
          <td>
            <input type="text" name="wpseol_pin_color" id="wpseol_pin_color" value="<?php echo esc_attr( get_option('wpseol_pin_color') ); ?>" /> Examples: #FFFFFF, #2099da
          </td>
        </tr>

        <tr valign="top">
          <th scope="row">Map Width</th>
          <td>
            <input type="number" name="wpseol_map_width" id="wpseol_map_width" min="1" max="640" value="<?php echo esc_attr( get_option('wpseol_map_width') ); ?>" />px. min=1, max=640
          </td>
        </tr>

        <tr valign="top">
          <th scope="row">Map Height</th>
          <td>
            <input type="number" name="wpseol_map_height" id="wpseol_map_height" min="1" max="640" value="<?php echo esc_attr( get_option('wpseol_map_height') ); ?>" />px. min=1, max=640
          </td>
        </tr>

        <tr valign="top">
          <th scope="row">Map Zoom</th>
          <td>
            <select name="wpseol_map_zoom" id="wpseol_map_zoom">
              <?php $map_zoom = esc_attr( get_option('wpseol_map_zoom') ); 
              for($i=0;$i<22;$i++){
                if($map_zoom==$i){
                  echo '<option value="'.$i.'" selected="selected">'.$i.'</option>';
                }else{
                  echo '<option value="'.$i.'">'.$i.'</option>';
                }
              } ?>
            </select>
          </td>
        </tr>

      </table><?php
      submit_button(); ?>
    </form>
    <p>By <a href="http://smleimberg.com" title="smleimberg.com">Steven Leimberg</a>, a developer at <a href="http://www.matmon.com" title="matmon.com">Matmon Internet Inc.</a>.</p>
  </div><?php 
}

function register_wpseol_settings() {
  register_setting( 'wpseol-settings', 'wpseol_google_geocoding_api_key' );
  register_setting( 'wpseol-settings', 'wpseol_google_static_maps_api_key' );
  register_setting( 'wpseol-settings', 'wpseol_map_type' );
  register_setting( 'wpseol-settings', 'wpseol_pin_color' );
  register_setting( 'wpseol-settings', 'wpseol_map_width' );
  register_setting( 'wpseol-settings', 'wpseol_map_height' );
  register_setting( 'wpseol-settings', 'wpseol_map_zoom' );
  register_setting( 'wpseol-settings', 'wpseol_image_type' );
}

function wpseol_create_menu() {
  add_options_page('WP SEO Locations Settings', 'Locations', 'administrator', __FILE__, 'wpseol_settings_page','');
  add_action( 'admin_init', 'register_wpseol_settings' );
}

add_action('admin_menu', 'wpseol_create_menu');

?>