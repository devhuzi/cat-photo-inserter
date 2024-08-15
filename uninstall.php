<?php
if (!defined('WP_UNINSTALL_PLUGIN')) {
    exit;
}

delete_option('cpi_api_key');
delete_option('cpi_max_photos');
delete_option('cpi_insert_position');

global $wpdb;
$wpdb->query("DELETE FROM {$wpdb->postmeta} WHERE meta_key = '_cpi_processed'");