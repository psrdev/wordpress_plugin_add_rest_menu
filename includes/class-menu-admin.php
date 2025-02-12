<?php
class Menu_Admin
{
    private $option_name = 'custom_menu_dropdown_settings';
    private $settings_registered = false;

    public function __construct()
    {
        add_action('admin_menu', array($this, 'add_settings_page'));
        add_action('admin_init', array($this, 'register_settings'));
    }

    public function add_settings_page()
    {
        add_options_page(
            'Menu Dropdown Settings',
            'Menu Dropdown',
            'manage_options',
            'menu-dropdown-settings',
            array($this, 'render_settings_page')
        );
    }

    public function register_settings()
    {
        if ($this->settings_registered) {
            return;
        }

        register_setting($this->option_name, $this->option_name);

        add_settings_section(
            'menu_items_section',
            'Menu Item IDs',
            array($this, 'section_callback'),
            'menu-dropdown-settings'
        );

        add_settings_field(
            'menu_items',
            'Menu Item IDs',
            array($this, 'menu_items_callback'),
            'menu-dropdown-settings',
            'menu_items_section'
        );
        add_settings_field(
            'api_key',
            'API Key',
            array($this, 'api_key_callback'),
            'menu-dropdown-settings',
            'menu_items_section'
        );
        add_settings_field(
            'api_url',
            'API URL',
            array($this, 'api_url_callback'),
            'menu-dropdown-settings',
            'menu_items_section'
        );

        $this->settings_registered = true;
    }

    public function section_callback()
    {
        echo '<p>Enter the menu item IDs where you want to show the dropdown. You can find the menu item ID by enabling Screen Options > CSS Classes in the WordPress menu editor and looking for menu-item-[ID] in the classes.</p>';
    }

    public function menu_items_callback()
    {
        $options = get_option($this->option_name, array('menu_items' => 'menu-item-431,menu-item-490'));
        $menu_items = isset($options['menu_items']) ? $options['menu_items'] : '';
        ?>
        <input type="text" name="<?php echo $this->option_name; ?>[menu_items]" value="<?php echo esc_attr($menu_items); ?>"
            class="regular-text" placeholder="e.g., menu-item-431,menu-item-490" />
        <p class="description">Enter menu item IDs separated by commas (e.g., menu-item-431,menu-item-490).</p>
        <?php
    }

    public function api_key_callback()
    {
        $options = get_option($this->option_name, array('api_key' => ''));
        $api_key = isset($options['api_key']) ? $options['api_key'] : '';
        ?>
        <input type="text" name="<?php echo $this->option_name; ?>[api_key]" value="<?php echo esc_attr($api_key); ?>"
            class="regular-text" placeholder="Enter your API key here" />
        <p class="description">This API key will be used for API requests.</p>
        <?php
    }

    public function api_url_callback()
    {
        $options = get_option($this->option_name, array('api_url' => ''));
        $api_url = isset($options['api_url']) ? $options['api_url'] : '';
        ?>
        <input type="text" name="<?php echo $this->option_name; ?>[api_url]" value="<?php echo esc_attr($api_url); ?>"
            class="regular-text" placeholder="Enter your API URL here" />
        <p class="description">This API URL will be used for API requests.</p>
        <?php
    }

    public function render_settings_page()
    {
        if (!current_user_can('manage_options')) {
            return;
        }
        ?>
        <div class="wrap">
            <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
            <form action="options.php" method="post">
                <?php
                settings_fields($this->option_name);
                do_settings_sections('menu-dropdown-settings');
                submit_button();
                ?>
            </form>
        </div>
        <?php
    }

    public function get_menu_items()
    {
        $options = get_option($this->option_name, array('menu_items' => 'menu-item-431,menu-item-490'));
        $menu_items = isset($options['menu_items']) ? $options['menu_items'] : '';
        $api_key = isset($options['api_key']) ? $options['api_key'] : '';
        $api_url = isset($options['api_url']) ? $options['api_url'] : '';
        return [
            'menu_items' => strpos($menu_items, ',') !== false ? array_map('trim', explode(',', $menu_items)) : array($menu_items),
            'api_key' => $api_key,
            'api_url' => $api_url,
        ];
    }
}