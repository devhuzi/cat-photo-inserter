<?php
/**
 * Plugin Name: Cat Photo Inserter
 * Description: Automatically inserts cat photos into posts when specific cat breeds are mentioned.
 * Version: 1.2
 * Author: Huzaifa Umer
 * Text Domain: cat-photo-inserter
 * Domain Path: /languages
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

define('CPI_VERSION', '1.2');
define('CPI_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('CPI_PLUGIN_URL', plugin_dir_url(__FILE__));

require_once CPI_PLUGIN_DIR . 'includes/class-cat-photo-inserter.php';

function run_cat_photo_inserter() {
    $plugin = new Cat_Photo_Inserter();
    $plugin->run();
}
add_action('plugins_loaded', 'run_cat_photo_inserter');