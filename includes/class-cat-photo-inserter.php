<?php
class Cat_Photo_Inserter {
    private $admin;
    private $public;

    public function __construct() {
        $this->load_dependencies();
        $this->set_locale();
        $this->define_admin_hooks();
        $this->define_public_hooks();
    }

    private function load_dependencies() {
        require_once CPI_PLUGIN_DIR . 'includes/class-cat-photo-inserter-admin.php';
        require_once CPI_PLUGIN_DIR . 'includes/class-cat-photo-inserter-public.php';
        $this->admin = new Cat_Photo_Inserter_Admin();
        $this->public = new Cat_Photo_Inserter_Public();
    }

    private function set_locale() {
        add_action('plugins_loaded', array($this, 'load_plugin_textdomain'));
    }

    public function load_plugin_textdomain() {
        load_plugin_textdomain('cat-photo-inserter', false, dirname(dirname(plugin_basename(__FILE__))) . '/languages/');
    }

    private function define_admin_hooks() {
        add_action('admin_menu', array($this->admin, 'add_menu_page'));
        add_action('admin_init', array($this->admin, 'register_settings'));
    }

    private function define_public_hooks() {
        add_action('save_post', array($this->public, 'insert_cat_photo'), 10, 3);
    }

    public function run() {
        // This method can be used to run any initialization code
    }
}