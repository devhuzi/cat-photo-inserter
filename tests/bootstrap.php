<?php

require_once dirname(__DIR__) . '/vendor/autoload.php';

// Define ABSPATH
define('ABSPATH', dirname(__DIR__) . '/');

// Mock WordPress functions
function add_action() {}
function add_filter() {}
function get_option($option, $default = false) { return $default; }
function plugin_dir_path($file) { return dirname($file) . '/'; }
function plugin_dir_url($file) { return 'http://example.com/wp-content/plugins/' . basename(dirname($file)) . '/'; }

// Load plugin files
require_once dirname(__DIR__) . '/cat-photo-inserter.php';
require_once dirname(__DIR__) . '/includes/class-cat-photo-inserter.php';
require_once dirname(__DIR__) . '/includes/class-cat-photo-inserter-admin.php';
require_once dirname(__DIR__) . '/includes/class-cat-photo-inserter-public.php';