<?php

if (!defined('WP_UNINSTALL_PLUGIN')) {
    exit();
}

// global $wpdb;

// $wpdb->query($wpdb->prepare("DROP TABLE IF EXISTS %i", $wpdb->prefix . 'mr_aparat_row'));





if (get_option('mat_option') !== false) {
    delete_option('mat_option');
}


