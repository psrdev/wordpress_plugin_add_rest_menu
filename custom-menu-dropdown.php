<?php
/**
 * Plugin Name: Custom Menu Dropdown
 * Description: Adds custom dropdown functionality to menu items with external API integration
 * Version: 1.0.0
 * Author: Pravin Singh Rana
 * License: GPL v2 or later
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// Include the API class
require_once plugin_dir_path(__FILE__) . 'includes/class-menu-api.php';

class Custom_Menu_Dropdown
{
    public function __construct()
    {
        // Initialize the API
        new Menu_API();

        // Add script and style enqueue
        add_action('wp_enqueue_scripts', array($this, 'enqueue_assets'));
    }

    /**
     * Enqueue CSS and JavaScript
     */
    public function enqueue_assets()
    {
        // Enqueue CSS
        wp_enqueue_style(
            'custom-menu-dropdown',
            plugins_url('css/dropdown.css', __FILE__),
            array(),
            '1.0.0'
        );

        // Enqueue JavaScript
        wp_enqueue_script(
            'custom-menu-dropdown',
            plugins_url('js/dropdown.js', __FILE__),
            array(),
            '1.0.0',
            true
        );
    }
}

// Initialize the plugin
new Custom_Menu_Dropdown();