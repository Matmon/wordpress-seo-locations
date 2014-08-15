=== WordPress SEO Locations ===
Contributors: smleimberg
Tags: schema.org, seo, location, address, map, google
<<<<<<< HEAD
Stable tag: 0.0.7
=======
Stable tag: 0.1.0
>>>>>>> use the google api keys
Tested up to: 3.9.1
License: GPL
License URI: https://www.gnu.org/licenses/gpl.txt

This plugin makes it easy to display locations with proper Schema.org markup, Google Static Map images, and links to directions in Google Maps.

== Description ==
WordPress SEO Locations was built by developers, for developers. Over at [Matmon Internet Inc.](http://www.matmon.com), we live and breathe WordPress. To help speed up our development process, we needed a simple overrideable plugin that would make it easy to display one or multiple locations with proper Schema.org markup, Google Static Map images, and links to directions in Google Maps. WordPress SEO Locations is that plugin. Our goal is to provide WordPress developers a bare bones SEO location plugin that just works. There are no styles to override, and customizing the HTML output for your specific needs is quick and simple. For usage information and and pull requests, head over to [GitHub](https://github.com/Matmon/wordpress-seo-locations).

== Installation ==
	
= Manual =
1. Download wp-seo-locations
2. Copy the wp-seo-locations folder into your plugins folder
3. Activate via the Plugins Administration page
4. Add your preferences via Settings->Locations in the WP Admin

= Automatic =
1. Search for "wp-seo-locations" in the "Add New" plugins page.
2. Find "WordPress SEO Locations" and click the "Install Now" link.
3. Activate via the Plugins Administration page
4. Add your preferences via Settings->Locations in the WP Admin

== Frequently Asked Questions ==
**Q** Why did you use the geocoding API to retrieve the latitude and longitude for each location?

>While we could have easily passed the location\'s address into the Static Maps URL, we recognized that our future plans of implementing embeded JavaScript maps would require a latitude & longitude. Since calls to the geocoding service only happen when you \"Post\" or \"Update\" a location, unless you are doing something fishy, it\'s highly unlikely you will exceed usage limits.

== Screenshots ==
<<<<<<< HEAD

1. edit_location.png
2. settings.png
=======
1. Each location has it's own Street Address, City, State, Zip, Telephone and Fax fields.
2. Set up Google Api Keys, Map Type, Image Type, Pin Color, Map Width, Map Height, and Map Zoom in settings.
>>>>>>> use the google api keys

== Upgrade Notice ==

Version 0.0.2 uses schema.org/Place with an address attribute, instead of just using schema.org/PostalAddress. We have also added a telephone and fax number field for each location with proper schema.org markup for each schema.org/Place.

== Changelog ==

= 0.1.0 =
Use Google API Keys if provided

= 0.0.3 to 0.0.8 =
Working on the Deployment process and adding screenshots to wordpress.org

= 0.0.2 =
- schema.org/Place with address, not just schema.org/PostalAddress.
- Telephone Number
- Fax Number

= 0.0.1 (Extreme Alpha) =
- Locations Post Type
- Settings Page
- Schema.org markup
- Google Static Maps
- Google Geocoding for latitude & longitude