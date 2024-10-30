<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class mapInEachPost_post_Class {
    public function __construct() {
        add_action('add_meta_boxes', [$this, 'add_mapineachpost_points_metabox']);
        add_action('save_post', [$this, 'save_mapineachpost_points']);
        add_action('admin_enqueue_scripts', [$this, 'enqueue_admin_scripts']);
    }

    public function enqueue_admin_scripts() {
        $plugin_url = plugin_dir_url(dirname(__FILE__));
        $component_url = $plugin_url . 'component/';

        wp_enqueue_script('map-in-each-post-admin', $component_url . 'js/map-in-each-post-admin.js', ['jquery'], null, true);
        wp_enqueue_style('map-in-each-post-admin-style', $component_url . 'css/map-in-each-post-admin.css');

        wp_localize_script('map-in-each-post-admin', 'mapInEachPostLabels', [
            'point' => esc_html__('Point', 'map-in-each-post'),
            'title' => esc_html__('Title', 'map-in-each-post'),
            'description' => esc_html__('Description', 'map-in-each-post'),
            'latitude' => esc_html__('Latitude', 'map-in-each-post'),
            'longitude' => esc_html__('Longitude', 'map-in-each-post'),
            'link' => esc_html__('Link', 'map-in-each-post'),
            'removePoint' => esc_html__('Remove point', 'map-in-each-post'),
        ]);
    }

    public function add_mapineachpost_points_metabox() {
        $selected_post_types = get_option('mapInEachPost_post_types', []);

        foreach ($selected_post_types as $post_type) {
            add_meta_box(
                'points_metabox',
                __('Points', 'map-in-each-post'),
                [$this, 'render_mapineachpost_points_metabox'],
                $post_type,
                'normal',
                'high'
            );
        }
    }

    public function render_mapineachpost_points_metabox($post) {
        $points = get_post_meta($post->ID, '_mapineachpost_points', true);
        $points = !empty($points) ? json_decode($points, true) : [];
        $enable_mapineachpost_points = get_post_meta($post->ID, '_enable_mapineachpost_points', true);
        
        $points = get_post_meta($post->ID, '_mapineachpost_points', true);
        $points = !empty($points) ? json_decode($points, true) : [];
        
        $fields = apply_filters('mapineachpost_point_fields', [
            'title' => array(
                'label' => __('Title', 'map-in-each-post'),
                'type'=>'text'
            ),
            'desc' => array(
                'label' => __('Description', 'map-in-each-post'),
                'type'=>'text'
            ),
            'lat' => array(
                'label' => __('Latitude', 'map-in-each-post'),
                'type'=>'text'
            ),
            'lon' => array(
                'label' => __('Longitude', 'map-in-each-post'),
                'type'=>'text'
            ),
            'link' => array(
                'label' => __('Link', 'map-in-each-post'),
                'type'=>'text'
            )
        ]);

        include plugin_dir_path(__FILE__) . '../templates/post-point-metabox.php';
    }

    public function save_mapineachpost_points($post_id) {
        if (!isset($_POST['mapInEachPost_nonce_field']) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['mapInEachPost_nonce_field'])), 'save_mapineachpost_points')) {
            return;
        }

        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }

        if (!current_user_can('edit_post', $post_id)) {
            return;
        }

        if (isset($_POST['_enable_mapineachpost_points'])) {
            update_post_meta($post_id, '_enable_mapineachpost_points', '1');
        } else {
            delete_post_meta($post_id, '_enable_mapineachpost_points');
        }

        if (isset($_POST['points'])) {
            $points = wp_unslash($_POST['points']);
            $sanitized_mapineachpost_points = [];

            foreach (array_values($points) as $index => $point) {
                $sanitized_point = [];
                foreach ($point as $key => $value) {
                    $sanitized_point[$key] = $this->sanitize_field($key, $value);
                }
                if (!empty($sanitized_point)) {
                    $sanitized_mapineachpost_points[$index] = $sanitized_point;
                }
            }
            
            if (!empty($sanitized_mapineachpost_points)) {
                update_post_meta($post_id, '_mapineachpost_points', wp_json_encode($sanitized_mapineachpost_points));
            } else {
                delete_post_meta($post_id, '_mapineachpost_points');
            }
        } else {
            delete_post_meta($post_id, '_mapineachpost_points');
        }
    }

    public function getlistPoint() {
        if (is_singular()) {
            $post_type = get_post_type();
            $selected_post_types = get_option('mapInEachPost_post_types', []);

            if ($selected_post_types && in_array($post_type, $selected_post_types)) {
                $enable_mapineachpost_points = get_post_meta(get_the_ID(), '_enable_mapineachpost_points', true);
                if ($enable_mapineachpost_points) {
                    $points = get_post_meta(get_the_ID(), '_mapineachpost_points', true);
                    $points = wp_json_decode($points, true);

                    if (json_last_error() !== JSON_ERROR_NONE) {
                        return [];
                    }

                    return $points;
                }
            }
        }

        return [];
    }

    private function sanitize_field($key, $value) {
        switch ($key) {
            case 'title':
            case 'desc':
                return htmlentities(sanitize_text_field($value), ENT_QUOTES, 'UTF-8');
            case 'lat':
            case 'lon':
                return sanitize_text_field($value);
            case 'link':
                return esc_url_raw($value);
            default:
                return sanitize_text_field($value);
        }
    }
}
