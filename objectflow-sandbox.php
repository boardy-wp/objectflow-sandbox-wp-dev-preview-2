<?php
/**
 * Plugin Name: ObjectFlow Sandbox
 * Description: Experimental ObjectFlow sandbox plugin for demo and discovery purposes.
 * Version: 0.2.0
 * Author: ObjectFlow
 * Text Domain: objectflow-sandbox
 * Domain Path: /languages
 */

if (!defined('ABSPATH')) {
    exit;
}


if (!defined('OBJECTFLOW_SANDBOX_REVISION')) {
    define('OBJECTFLOW_SANDBOX_REVISION', 6);
}

require_once plugin_dir_path(__FILE__) . 'includes/class-objectflow-todo-list-page.php';
require_once plugin_dir_path(__FILE__) . 'includes/class-objectflow-setup-page.php';

final class ObjectFlow_Sandbox {
    private ObjectFlow_Setup_Page $setup_page;

    public function __construct() {
        $this->setup_page = new ObjectFlow_Setup_Page();
        add_action('plugins_loaded', [$this, 'load_textdomain']);
        add_action('admin_menu', [$this, 'register_admin_menu']);
    }

    public function load_textdomain(): void {
        load_plugin_textdomain('objectflow-sandbox', false, dirname(plugin_basename(__FILE__)) . '/languages');
    }

    public function register_admin_menu(): void {
        $this->setup_page->register_admin_menu();
    }
}

new ObjectFlow_Sandbox();
