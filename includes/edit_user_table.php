<?php
(defined('ABSPATH')) || exit;

add_filter('manage_users_columns', 'add_mrsms_posts_column');
function add_mrsms_posts_column($columns)
{
    $columns[ 'mobile' ] = 'شماره موبایل';
    return $columns;
}

add_action('manage_users_custom_column', 'show_mrsms_posts_count', 10, 3);
function show_mrsms_posts_count($output, $column_name, $user_id)
{

    if ($column_name === 'mobile') {

        $output = get_user_meta($user_id, 'mobile', true);
        return (! empty($output)) ? $output : '-';

    }

}
