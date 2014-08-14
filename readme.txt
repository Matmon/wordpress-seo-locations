=== WordPress SEO Locations ===
Contributors: smleimberg
Tags: schema.org, seo, location, address, map, google
License: GPL
License URI: https://www.gnu.org/licenses/gpl.txt

WordPress SEO Locations was built by developers, for developers. This plugin makes it easy to display one or multiple locations with proper Schema.org markup, Google Static Map images, and links to directions in Google Maps.

== Description ==
WordPress SEO Locations was built by developers, for developers. This plugin makes it easy to display one or multiple locations with proper Schema.org markup, Google Static Map images, and links to directions in Google Maps. Our goal is to provide WordPress developers a bare bones SEO location plugin that just works. There are no styles to override, and customizing the HTML output is quick and simple.

== Installation ==
Installation is just like any other WordPress plugin. Just drop the wp-seo-locations folder into your plugins folder and activate it via the Plugins Administration page.

== Frequently Asked Questions ==
Q. Why did you use the geocoding API to retrieve the latitude and longitude for each location?
A. While we could have easily passed the location\'s address into the Static Maps URL, we recognized that our future plans of implementing embeded JavaScript maps would require a latitude & longitude. Since calls to the geocoding service only happen when you \"Post\" or \"Update\" a location, unless you are doing something fishy, it\'s highly unlikely you will exceed usage limits.

== Screenshots ==
1. https://github.com/Matmon/wordpress-seo-locations/raw/master/images/edit_location.png
2. https://github.com/Matmon/wordpress-seo-locations/raw/master/images/settings.png

== Changelog ==
0.0.2
 - schema.org/Place with address, not just schema.org/PostalAddress.
 - Telephone Number
 - Fax Number

Extreme Alpha 0.0.1
 - Locations Post Type
 - Settings Page
 - Schema.org markup
 - Google Static Maps
 - Google Geocoding for latitude & longitude