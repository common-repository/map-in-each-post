<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class mapInEachPost_map_Class {

    public function __construct() {
        add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts'));
    }

    public function enqueue_scripts() {
        $plugin_url = plugin_dir_url(dirname(__FILE__));
        $component_url = $plugin_url . 'component/';
    
        if (!is_admin() && $this->has_plugin_shortcode() ) {
            wp_enqueue_style('leaflet-css', $component_url . 'css/leaflet.css', array(), '1.0.3');
            wp_enqueue_script('leaflet-js', $component_url . 'js/leaflet.js', array(), '1.0.3', true);
    
            wp_enqueue_style('markercluster-css', $component_url . 'css/MarkerCluster.css', array(), '1.0.0');
            wp_enqueue_style('markercluster-default-css', $component_url . 'css/MarkerCluster.Default.css', array(), '1.0.0');
            wp_enqueue_script('markercluster-js', $component_url . 'js/leaflet.markercluster-src.js', array('leaflet-js'), '1.0.0', true);
        } 
    }
    
    public function has_plugin_shortcode() {
        global $post;
        if (isset($post->post_content)) {
            $has_shortcode = has_shortcode($post->post_content, 'mapInEachPost') || has_shortcode($post->post_content, 'mapInEachPostPoint');
    
            $has_shortcode = apply_filters('mapineachpost_shortcode_check', $has_shortcode, $post->post_content);
            return $has_shortcode;
        }
        return false;
    }
    
   
    public function render($locations, $atts = []) {
        $atts = $this->attsChecker($atts);
 
        $localized_data = apply_filters('map_in_each_post_localized_data', array(
            'lat' => $atts['lat'],
            'lon' => $atts['lon'],
            'zoom' => $atts['zoom'],
            'locations' => $locations,
            'view' => __('view', 'map-in-each-post')
        ),$atts);
        
        wp_register_script('map-initialization', plugins_url('../component/js/map-initialization.js', __FILE__), [], '1.0.0', true);
        wp_enqueue_script('map-initialization');
        
        wp_add_inline_script('map-initialization', 'var mapInEachPost = ' . wp_json_encode($localized_data) . ';', 'before');
    
        ob_start();
        include plugin_dir_path(__FILE__) . '../templates/map.php';
        return ob_get_clean();
    }
    
    public function attsChecker($atts = false) {
        $defaults = [
            'zoom' => 5,
            'lat'  => 39.216667,
            'lon'  => 9.11667
        ];
    
        if (!is_array($atts)) {
            return $defaults;
        }
    
        // Unisci i parametri predefiniti con quelli passati
        $parameters = array_merge($defaults, $atts);
        
        return $parameters;
    }
    
}
