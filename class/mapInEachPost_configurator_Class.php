<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class mapInEachPost_configurator_Class {

    public function __construct() {
        add_action( 'admin_menu', [ $this, 'create_settings_page' ] );
        add_action( 'admin_init', [ $this, 'setup_sections' ] );
        add_action( 'admin_init', [ $this, 'setup_fields' ] );
    }

    public function create_settings_page() {
        $page_title = __('Map in Each Post Settings', 'map-in-each-post');
        $menu_title = __('Map in Each Post', 'map-in-each-post');
        $capability = 'manage_options';
        $slug = 'map-in-each-post_type_settings';
        $callback = [ $this, 'settings_page_content' ];
        $icon = 'dashicons-location-alt';
        $position = 100;

        add_menu_page( $page_title, $menu_title, $capability, $slug, $callback, $icon, $position );

        do_action('map_in_each_post_after_menu');
    }

    public function settings_page_content() {
        if ( ! current_user_can( 'manage_options' ) ) {
            return;
        }

        if ( isset( $_POST['mapInEachPost_nonce_field'] ) ) {
            $nonce = sanitize_text_field( wp_unslash( $_POST['mapInEachPost_nonce_field'] ) );
            if ( ! wp_verify_nonce( $nonce, 'mapInEachPost_nonce_action' ) ) {
                wp_die( 'Nonce verification failed' );
            }
        }

        if ( isset( $_GET['settings-updated'] ) ) {
            add_settings_error( 'post_checkout_messages', 'post_checkout_message', 'Settings Saved', 'updated' );
        }

        settings_errors( 'post_checkout_messages' );

        include plugin_dir_path( __FILE__ ) . '../templates/settings-page.php';
    }

    public function setup_sections() {
        add_settings_section( 'mapInEachPost_checkout_section', __('Select the post types where to see the map', 'map-in-each-post'), null, 'map-in-each-post_type_settings' );
    }

    public function setup_fields() {
        add_settings_field( 'mapineachpost_post_types', __('Post Types', 'map-in-each-post'), [ $this, 'field_callback' ], 'map-in-each-post_type_settings', 'mapInEachPost_checkout_section' );
        register_setting( 'map-in-each-post_type_settings', 'mapineachpost_post_types' );
    }

    public function field_callback( $arguments ) {
        $post_types = get_option( 'mapineachpost_post_types' );
        $all_post_types = get_post_types( [ 'public' => true ], 'objects' );

        foreach ( $all_post_types as $post_type ) {
            echo '<input type="checkbox" name="mapineachpost_post_types[]" value="' . esc_attr( $post_type->name ) . '" ' . checked( in_array( $post_type->name, (array) $post_types ), true, false ) . ' />';
            echo '<label for="mapineachpost_post_types[]">' . esc_html( $post_type->label ) . '</label><br>';
        }
    }
}
?>
