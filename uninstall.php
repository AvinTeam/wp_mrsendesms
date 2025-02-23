<?php

use smsclass\SMSOption;

if (! defined('WP_UNINSTALL_PLUGIN')) {
    exit();
}

// global $wpdb;

// $wpdb->query($wpdb->prepare("DROP TABLE IF EXISTS %i", $wpdb->prefix . 'mr_aparat_row'));

require_once plugin_dir_path(__FILE__) . 'classes/SMSOption.php';

$option = new SMSOption();

$option->delete();
