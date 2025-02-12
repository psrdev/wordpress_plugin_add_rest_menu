<?php
require_once plugin_dir_path(__FILE__) . 'class-menu-admin.php';
class Menu_API
{
    public function __construct($admin)
    {
        add_action('rest_api_init', array($this, 'register_rest_route'));
        $this->admin = $admin;

    }

    /**
     * Register REST API endpoint
     */
    public function register_rest_route()
    {
        register_rest_route('custom-api/v1', '/menu', array(
            'methods' => 'GET',
            'callback' => array($this, 'get_menu_data'),
            'permission_callback' => '__return_true',
        ));
    }

    /**
     * Get menu data
     */
    public function get_menu_data()
    {
        $url = $this->admin->get_menu_items()['api_url'];
        $key = $this->admin->get_menu_items()['api_key'];
        // Replace this array with your actual data source
        $response = wp_remote_get($url, array(
            'headers' => array(
                'Authorization' => 'Bearer ' . $key,
            ),
        ));

        if (is_wp_error($response)) {
            return new WP_REST_Response(array('error' => 'Failed to fetch menu data'), 500);
        }

        $body = wp_remote_retrieve_body($response);
        $api_data = json_decode($body, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            return new WP_REST_Response(array('error' => 'Invalid JSON response'), 500);
        }

        $menu_data = array_map(function ($item) {
            return array(
                'id' => $item['id'],
                'title' => $item['attributes']['title'],
                'slug' => $item['attributes']['slug'],
                'endpoint_url' => $item['attributes']['endpoint_url'],
            );
        }, $api_data['data'] ?? []);

        return new WP_REST_Response($menu_data, 200);
    }
}