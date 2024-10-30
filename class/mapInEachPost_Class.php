<?php 
    if ( ! defined( 'ABSPATH' ) ) exit;

    require_once (dirname(__FILE__).'/mapInEachPost_map_Class.php');
    require_once (dirname(__FILE__).'/mapInEachPost_post_Class.php');
    require_once (dirname(__FILE__).'/mapInEachPost_notice_Class.php');
    require_once (dirname(__FILE__).'/mapInEachPost_configurator_Class.php');
    
    class mapInEachPost_Class {
    
        public $map;
        public $point;
    
        public function __construct() {
            $this->map = new mapInEachPost_map_Class();
            $this->point = new mapInEachPost_post_Class();
            $menu = new mapInEachPost_configurator_Class();
            $notice = new mapInEachPost_notice_Class();

            add_action('template_redirect', [$this, 'check_and_add_shortcode']);
            add_shortcode('mapInEachPostPoint', [$this, 'mapInEachPostPoint_function']);

        }
    
        public function check_and_add_shortcode() {
            if ($this->is_supported_post_type()) {
                add_shortcode('mapInEachPost', [$this, 'mapInEachPost_function']);
            }
        }
    
        public function mapInEachPost_function($atts) {
            return $this->map->render($this->getPoint(), $atts);
        }

        public function mapInEachPostPoint_function($atts) {        
            $atts = shortcode_atts([
                'title' => __('Here', 'map-in-each-post'),
                'lat' => '0',
                'lon' => '0',
                'zoom' => '8',
                'link' => '',
                'desc'=>''
            ], $atts);
        
            $title = sanitize_text_field($atts['title']);

            $locations = [
                'title' => $title,
                'lat'   => floatval($atts['lat']),
                'lon'   => floatval($atts['lon']),
            ];
            if (!empty($atts['link'])) {
                $locations['link'] = esc_url($atts['link']);
            }

            if (!empty($atts['desc'])) {
                $locations['desc'] = sanitize_textarea_field($atts['desc']);
            }

            $locations = apply_filters('modify_map_point', $locations, $atts);

            return $this->map->render([$locations], $atts);
        }
        
        public function getPoint() {
            return $this->point->getlistPoint();
        }
    
        private function is_supported_post_type() {
            if (is_singular()) {
                $post_type = get_post_type();
                $selected_post_types = get_option('mapInEachPost_post_types', []);
                return in_array($post_type, $selected_post_types);
            } 
            return false;
        }
    }
    