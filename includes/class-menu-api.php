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
        $menu_data = array(
            array(
                'endpoint_url' => 'https://example.com/destination1',
                'title' => 'Destination 1',
            ),
            array(
                'endpoint_url' => 'https://example.com/maldives',
                'title' => 'Maldives',
            ),
            array(
                'endpoint_url' => $url,
                'title' => $key,
            ),
            // Add more items as needed
        );

        return new WP_REST_Response($menu_data, 200);
    }
}