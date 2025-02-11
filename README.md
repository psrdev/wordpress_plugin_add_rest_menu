# Custom Menu Dropdown

## Description

The **Custom Menu Dropdown** plugin adds custom dropdown functionality to menu items with external API integration. This plugin fetches menu data from a custom REST API endpoint and displays it in a dropdown menu.

## Features

- Fetches menu data from a custom REST API endpoint.
- Displays menu items in a dropdown menu.
- Customizable dropdown menu styles.

## Installation

1. Download the plugin and extract it to your WordPress plugins directory (`/wp-content/plugins/`).
2. Activate the plugin through the 'Plugins' menu in WordPress.

## Usage

1. Ensure the plugin is activated.
2. The plugin will automatically add dropdown functionality to menu items with IDs `menu-item-431` and `menu-item-490`.

## Files

- [`custom-menu-dropdown.php`](custom-menu-dropdown.php): Main plugin file that initializes the plugin and enqueues assets.
- [`includes/class-menu-api.php`](includes/class-menu-api.php): Contains the `Menu_API` class that registers the REST API endpoint and provides menu data.
- [`js/dropdown.js`](js/dropdown.js): JavaScript file that handles the dropdown functionality and fetches data from the REST API.
- [`css/dropdown.css`](css/dropdown.css): CSS file that styles the dropdown menu.

## REST API Endpoint

The plugin registers a custom REST API endpoint to fetch menu data.

- **Endpoint**: `/wp-json/custom-api/v1/menu`
- **Method**: `GET`
- **Response**: An array of menu items with `endpoint_url` and `title`.

## Customization

You can customize the dropdown menu styles by modifying the [`css/dropdown.css`](css/dropdown.css) file.

## Author

Pravin Singh Rana

## License

This plugin is licensed under the GPL v2 or later.

## Changelog

### 1.0.0

- Initial release

## Support

For support, please contact the plugin author.
