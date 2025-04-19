<?php

use smsclass\SMSOption;

(defined('ABSPATH')) || exit;

add_action('admin_menu', 'mrsms_admin_menu');

/**
 * Fires before the administration menu loads in the admin.
 *
 * @param string $context Empty context.
 */
function mrsms_admin_menu(string $context): void
{

    $setting_suffix = add_menu_page(
        'پنل پیامک',
        'پنل پیامک',
        'manage_options',
        'mrsms',
        'mrsms_setting_panels',
        'dashicons-hammer',
        0
    );

    add_submenu_page(
        'mrsms',
        'تنظیمات',
        'تنظیمات',
        'manage_options',
        'mrsms',
        'mrsms_setting_panels',
    );

    function mrsms_setting_panels()
    {

        $option       = new SMSOption();
        $mrsms_option = $option->get();

        require_once MRSMS_VIEWS . 'menu/setting.php';

    }

    $sms_panels_suffix = add_submenu_page(
        'mrsms',
        'تنظیمات پنل پیامک',
        'تنظیمات پنل پیامک',
        'manage_options',
        'sms_panels',
        'mrsms_sms_panels',
    );

    function mrsms_sms_panels()
    {
        $option       = new SMSOption();
        $mrsms_option = $option->get();

        require_once MRSMS_VIEWS . 'menu/setting_sms_panels.php';

    }

    $setting_login_suffix = add_submenu_page(
        'mrsms',
        'تنظیمات برای ورود',
        'تنظیمات برای ورود',
        'manage_options',
        'setting_login',
        'mrsms_sms_logon',
    );

    function mrsms_sms_logon()
    {
        $option       = new SMSOption();
        $mrsms_option = $option->get();

        require_once MRSMS_VIEWS . 'menu/setting_login.php';

    }

    $mrsms_login_form_suffix = add_submenu_page(
        'mrsms',
        'فرم',
        'فرم',
        'manage_options',
        'sms_form',
        'mrsms_login_form',
    );

    function mrsms_login_form()
    {
        $option       = new SMSOption();
        $mrsms_option = $option->get();

        require_once MRSMS_VIEWS . 'menu/loginform.php';

    }


    add_action('load-' . $setting_suffix, 'mrsms__submit');
    add_action('load-' . $sms_panels_suffix, 'mrsms__submit');
    add_action('load-' . $setting_login_suffix, 'mrsms__submit');

    function mrsms__submit()
    {

        if (isset($_POST[ 'mrsms_act' ]) && $_POST[ 'mrsms_act' ] == 'mrsms__submit') {

            if (wp_verify_nonce($_POST[ '_wpnonce' ], 'mrsms_nonce' . get_current_user_id())) {
                if (isset($_POST[ 'tsms' ])) {
                    $_POST[ 'tsms' ] = array_map('sanitize_text_field', $_POST[ 'tsms' ]);
                }
                if (isset($_POST[ 'ghasedaksms' ])) {
                    $_POST[ 'ghasedaksms' ] = array_map('sanitize_text_field', $_POST[ 'ghasedaksms' ]);
                }

                $option = new SMSOption();
                $option->set($_POST);

                wp_admin_notice(
                    'تغییر شما با موفقیت ثبت شد',
                    [
                        'id'                 => 'message',
                        'type'               => 'success',
                        'additional_classes' => [ 'updated' ],
                        'dismissible'        => true,
                     ]
                );

            } else {
                wp_admin_notice(
                    'ذخیره سازی به مشکل خورده دوباره تلاش کنید',
                    [
                        'id'                 => 'mrsms_message',
                        'type'               => 'error',
                        'additional_classes' => [ 'updated' ],
                        'dismissible'        => true,
                     ]
                );

            }

        }

    }

}