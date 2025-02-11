<?php
class Menu_API
{
    public function __construct()
    {
        add_action('rest_api_init', array($this, 'register_rest_route'));
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
            // Add more items as needed
        );

        return new WP_REST_Response($menu_data, 200);
    }
}