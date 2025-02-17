<?php

use smsclass\SMSOption;

(defined('ABSPATH')) || exit;

add_action('admin_enqueue_scripts', 'mrsms_admin_script');

function mrsms_admin_script()
{

    wp_enqueue_style(
        'mrsms_admin',
        MRSMS_CSS . 'admin.css',
        [  ],
        MRSMS_VERSION
    );

    wp_enqueue_media();

    wp_enqueue_script(
        'mrsms_admin',
        MRSMS_JS . 'admin.js',
        [ 'jquery' ],
        MRSMS_VERSION,
        true
    );

    $option = new SMSOption();

    wp_localize_script(
        'mrsms_admin',
        'mrsms_js',
        [
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce'    => wp_create_nonce('ajax-nonce'),
            'option'   => $option->get(),

         ]
    );

}

add_action('wp_enqueue_scripts', 'mrsms_style');

function mrsms_style()
{

    wp_enqueue_style(
        'mrsms_style',
        MRSMS_CSS . 'public.css',
        [  ],
        MRSMS_VERSION
    );

    wp_enqueue_script(
        'mrsms_js',
        MRSMS_JS . 'public.js',
        [ 'jquery' ],
        MRSMS_VERSION,
        true
    );
    $option = new SMSOption();

    wp_localize_script(
        'mrsms_js',
        'mrsms_js',
        [
            'ajaxurl' => admin_url('admin-ajax.php'),
            'nonce'   => wp_create_nonce('ajax-nonce' . mrsms_cookie()),
            'option'  => $option->get(),

         ]
    );

}
