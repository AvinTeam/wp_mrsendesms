<?php
(defined('ABSPATH')) || exit;

add_action('admin_menu', 'mph_admin_menu');

/**
 * Fires before the administration menu loads in the admin.
 *
 * @param string $context Empty context.
 */
function mph_admin_menu(string $context): void
{

    $setting_suffix = add_menu_page(
        'اطلس',
        'اطلس',
        'manage_options',
        'atlas',
        'setting_panels',
        'dashicons-hammer',
        55
    );

    add_submenu_page(
        'atlas',
        'تنظیمات',
        'تنظیمات',
        'manage_options',
        'atlas',
        'setting_panels',
    );

    function setting_panels()
    {
        $mrsms_option = mrsms_start_working();

        require_once MRSMS_VIEWS . 'menu/setting.php';

    }

    $sms_panels_suffix = add_submenu_page(
        'atlas',
        'تنظیمات پنل پیامک',
        'تنظیمات پنل پیامک',
        'manage_options',
        'sms_panels',
        'mrsms_sms_panels',
    );

    function mrsms_sms_panels()
    {
        $mrsms_option = mrsms_start_working();

        require_once MRSMS_VIEWS . 'setting_sms_panels.php';

    }

    $province_suffix = add_submenu_page(
        'atlas',
        'استان ها',
        'استان ها',
        'manage_options',
        'province',
        'mrsms_menu_callback',
    );

    function mrsms_menu_callback()
    {

        $iran = new Iran_Area();

        require_once MRSMS_VIEWS . 'menu/list.php';

    }

    add_action('load-' . $province_suffix, 'mrsms__province');
    add_action('load-' . $setting_suffix, 'mrsms__submit');
    add_action('load-' . $sms_panels_suffix, 'mrsms__submit');

    function mrsms__province()
    {

        if (isset($_POST[ 'mrsms_act' ]) && $_POST[ 'mrsms_act' ] == 'mrsms__submit') {

            if (wp_verify_nonce($_POST[ '_wpnonce' ], 'mrsms_nonce' . get_current_user_id())) {

                $iran = new Iran_Area();

                $data         = [ 'description' => wp_kses_post(wp_unslash(nl2br($_REQUEST[ 'description' ]))) ];
                $where        = [ 'id' => $_REQUEST[ 'province' ] ];
                $format       = [ '%s' ];
                $where_format = [ '%d' ];

                $res = $iran->update($data, $where, $format, $where_format);

                wp_admin_notice(
                    'تغییر شما با موفقیت ثبت شد',
                    [
                        'id'                 => 'message',
                        'type'               => 'success',
                        'additional_classes' => ['updated'],
                        'dismissible'        => true,
                    ]
                );

            } else {
                wp_admin_notice(
                    'ذخیره سازی به مشکل خورده دوباره تلاش کنید',
                    [
                        'id'                 => 'mrsms_message',
                        'type'               => 'error',
                        'additional_classes' => ['updated'],
                        'dismissible'        => true,
                    ]
                );
            }

        }

        if (isset($_POST[ 'mrsms_act' ]) && $_POST[ 'mrsms_act' ] == 'mrsms_city_submit') {

            if (wp_verify_nonce($_POST[ '_wpnonce' ], 'mrsms_nonce' . get_current_user_id())) {


           
                $iran = new Iran_Area();

                if (isset($_REQUEST[ 'city_id' ]) && absint($_REQUEST[ 'city_id' ])) {

                    $data = [
                        'name'        => sanitize_text_field($_REQUEST[ 'city_name' ]),
                        'city2'       => sanitize_text_field($_REQUEST[ 'city2_name' ]),
                        'description' => wp_kses_post(wp_unslash(nl2br($_REQUEST[ 'description' ]))),
                     ];
                    $where        = [ 'id' => absint($_REQUEST[ 'city_id' ]) ];
                    $format       = [ '%s' ,'%s' ,'%s' ];
                    $where_format = [ '%d' ];

                    $res = $iran->update($data, $where, $format, $where_format);

                    if ($res) {
                        wp_admin_notice(
                            'تغییر شما با موفقیت ثبت شد',
                            [
                                'id'                 => 'mrsms_message',
                                'type'               => 'success',
                                'additional_classes' => ['updated'],
                                'dismissible'        => true,
                            ]
                        );
                    } else {
                        wp_admin_notice(
                            'ذخیره سازی به مشکل خورده دوباره تلاش کنید',
                            [
                                'id'                 => 'mrsms_message',
                                'type'               => 'error',
                                'additional_classes' => ['updated'],
                                'dismissible'        => true,
                            ]
                        );
                    }

                } elseif (isset($_REQUEST[ 'city_id' ]) && ! absint($_REQUEST[ 'city_id' ])) {

                    $data = [
                        'name'        => sanitize_text_field($_REQUEST[ 'city_name' ]),
                        'city2'       => sanitize_text_field($_REQUEST[ 'city2_name' ]),
                        'province_id' => absint($_REQUEST[ 'province' ]),
                        'description' => wp_kses_post(wp_unslash(nl2br($_REQUEST[ 'description' ]))),
                     ];
                    $format = [ '%s', '%s', '%d', '%s' ];

                    $res = $iran->insert($data, $format);

                    if ($res) {
                        wp_admin_notice(
                            'تغییر شما با موفقیت ثبت شد',
                            [
                                'id'                 => 'mrsms_message',
                                'type'               => 'success',
                                'additional_classes' => ['updated'],
                                'dismissible'        => true,
                            ]
                        );
                    } else {
                        wp_admin_notice(
                            'ذخیره سازی به مشکل خورده دوباره تلاش کنید',
                            [
                                'id'                 => 'mrsms_message',
                                'type'               => 'error',
                                'additional_classes' => ['updated'],
                                'dismissible'        => true,
                            ]
                        );
                    }

                } else {
                    wp_admin_notice(
                        'ذخیره سازی به مشکل خورده دوباره تلاش کنید',
                        [
                            'id'                 => 'mrsms_message',
                            'type'               => 'error',
                            'additional_classes' => ['updated'],
                            'dismissible'        => true,
                        ]
                    );
                }

            } else {

                wp_admin_notice(
                    'ذخیره سازی به مشکل خورده دوباره تلاش کنید',
                    [
                        'id'                 => 'mrsms_message',
                        'type'               => 'error',
                        'additional_classes' => ['updated'],
                        'dismissible'        => true,
                    ]
                );
            }

        }

    }

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

                mrsms_update_option($_POST);

                wp_admin_notice(
                    'تغییر شما با موفقیت ثبت شد',
                    [
                        'id'                 => 'message',
                        'type'               => 'success',
                        'additional_classes' => ['updated'],
                        'dismissible'        => true,
                    ]
                );

            } else {
                wp_admin_notice(
                    'ذخیره سازی به مشکل خورده دوباره تلاش کنید',
                    [
                        'id'                 => 'mrsms_message',
                        'type'               => 'error',
                        'additional_classes' => ['updated'],
                        'dismissible'        => true,
                    ]
                );

            }

        }

    }

    add_submenu_page(
        'edit.php?post_type=institute',         // اسلاگ پست تایپ
        'نظرات موسسات',              // عنوان صفحه
        'نظرات موسسات',              // عنوان منو
        'manage_options',                       // سطح دسترسی
        'edit-comments.php?post_type=institute' // لینک صفحه نظرات اختصاصی
    );
}
