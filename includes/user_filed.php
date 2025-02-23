<?php
defined('ABSPATH') || exit;

add_action('edit_user_profile', 'mrsms_user_inputs');
add_action('show_user_profile', 'mrsms_user_inputs');
add_action('user_new_form', 'mrsms_user_inputs');

function mrsms_user_inputs($user)
{
    $mobile = '';
    if (is_a($user, 'WP_User')) {
        $mobile = $user->mobile;
    }

    include MRSMS_VIEWS . 'user-inputs.php';
}

add_action('edit_user_profile_update', 'mrsms_update_user');
add_action('personal_options_update', 'mrsms_update_user');
add_action('user_register', 'mrsms_update_user');

function mrsms_update_user($user_id)
{

    if (! current_user_can('edit_user', $user_id)) {
        return;
    }

    if (isset($_POST[ 'mobile' ])) {
        $mobile = sanitize_phone($_POST[ 'mobile' ]);
        update_user_meta($user_id, 'mobile', $mobile);
    }

}
