=== Map in Each Post ===
Contributors: matteoenna
Tags: map, shortcode, post, custom map, maps
Donate link: https://www.paypal.me/matteoedev/2.55
License URI: http://www.gnu.org/licenses/gpl.html
Requires at least: 5.0
Tested up to: 6.6
Stable tag: 3.1
License: GPLv2 or later

A simple plugin to insert customizable maps in posts using shortcodes. Supports unique maps per post and custom post types.

== Description ==

Map in Each Post allows you to easily add a map to your WordPress posts using shortcodes and a built-in form. You can customize each map with different points for each post. This plugin is ideal for travel blogs, location-based content, and any website that needs custom maps per post. Additionally, you can select which post types will have the map functionality enabled.

**Try it on a free mock site: [click here](https://tastewp.org/plugins/map-in-each-post/)**

= Features =

* Add a custom map to each post using a simple shortcode.
* Customize each map with different points via a form in the post editor.
* Select the post types where the map functionality should be enabled.
* Easy to use and configure.
* Compatible with the latest version of WordPress.

= Usage =

To use this plugin, simply add the following shortcode to your post to display a map with multiple points:

`[mapInEachPost]`

Or by specifying the center point and zoom:

`[mapInEachPost zoom="3" lat="45.4399961" lon="10.9719328"]`

Then, use the form that appears in the post editor to input the latitude and longitude coordinates for the points you want to add to the map.

This will generate a map with points in New York City and Los Angeles.

---

To display a single point on the map, use the following shortcode:

`[mapInEachPostPoint lat="39.8736" lon="8.7479" zoom="12" title="Point in Sardinia"]`

- `lat`: Latitude of the point (required)
- `lon`: Longitude of the point (required)
- `zoom`: Zoom level for the map (optional, default: 8)
- `title`: Title of the point (optional, default: empty)
- `link`: A URL to associate with the point (optional)
- `desc`: A description for the point (optional)

For example, to display a point with additional information:

`[mapInEachPostPoint lat="39.8736" lon="8.7479" zoom="12" title="Point in Sardinia" link="https://example.com" desc="Description of the Point in Sardinia"]`

This will generate a map centered on the given latitude and longitude, with the point titled "Point in Sardinia" and a link to "https://example.com".

== Installation ==

1. Upload the plugin files to the `/wp-content/plugins/map-in-each-post` directory, or install the plugin through the WordPress plugins screen directly.
2. Activate the plugin through the 'Plugins' screen in WordPress.
3. Use the shortcode `[map_in_post]` in your posts to display a map and input points via the form in the post editor.
4. Go to the plugin settings page to select the post types where the map functionality should be enabled.

== Frequently Asked Questions ==

= How do I add a map to my post? =

Simply use the shortcode `[mapInEachPost]` in the post where you want the map to appear, and input the points using the form that appears in the post editor.

= Can I customize the points on the map for each post? =

Yes, you can customize the points for each map by entering the latitude and longitude coordinates in the form provided in the post editor.

= How do I select the post types where the map functionality should be enabled? =

Go to the plugin settings page and select the post types where you want the map functionality to be enabled.

= What map service does this plugin use? =

The plugin uses Leaflet, an open-source JavaScript library for mobile-friendly interactive maps, to display the maps.

== Third Party Services ==

This plugin relies on the Leaflet service to display maps. Leaflet is an open-source JavaScript library for mobile-friendly interactive maps. By using this plugin, you agree to the terms of use and privacy policies of Leaflet.

- Service: [Leaflet](https://leafletjs.com/)
- License: [BSD-2-Clause license](https://github.com/Leaflet/Leaflet?tab=BSD-2-Clause-1-ov-file#readme)

You can find the source code and contribute to the project on GitHub:[Map in Each Post on GitHub](https://github.com/Ellusu/map-in-each-post)
