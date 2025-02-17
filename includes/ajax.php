<?php

use smsclass\SendSMS;
use smsclass\SMSOption;

add_action('wp_ajax_nopriv_mrsms_sent_sms', 'mrsms_sent_sms');

function mrsms_sent_sms()
{

    if (wp_verify_nonce($_POST[ 'nonce' ], 'ajax-nonce' . mrsms_cookie())) {
        if ($_POST[ 'mobileNumber' ] !== "") {
            $mobile = sanitize_text_field($_POST[ 'mobileNumber' ]);

            $send_sms = new SendSMS();

            $res = $send_sms->send($mobile, 'otp');

            wp_send_json_success($res);

            delete_transient('otp_' . $mobile);

            wp_send_json_error('شما مجاز به وارد شوید', 403);

        }
        wp_send_json_error('شماره شما به درستی وارد نشده است', 403);

    } else {
        wp_send_json_error('لطفا یکبار صفحه را بروزرسانی کنید', 403);

    }

}

add_action('wp_ajax_nopriv_mrsms_sent_verify', 'mrsms_sent_verify');

function mrsms_sent_verify()
{
    if (wp_verify_nonce($_POST[ 'nonce' ], 'ajax-nonce' . mrsms_cookie())) {

        if ($_POST[ 'mobileNumber' ] !== "" && $_POST[ 'otpNumber' ] !== "") {

            $mobile = sanitize_text_field($_POST[ 'mobileNumber' ]);
            $otp    = sanitize_text_field($_POST[ 'otpNumber' ]);

            // دریافت کد ذخیره‌شده
            $saved_otp = get_transient('otp_' . $mobile);

            if (! $saved_otp || $saved_otp !== $otp) {
                wp_send_json_error('کد تأیید اشتباه یا منقضی شده است. ', 403);
            } else {
                $option = new SMSOption();

                $user_query = new WP_User_Query([
                    'meta_key'   => 'mobile',
                    'meta_value' => $mobile,
                    'number'     => 1,
                 ]);

                if (! empty($user_query->get_results())) {
                    $user = $user_query->get_results()[ 0 ];

                    wp_set_current_user($user->ID);
                    wp_set_auth_cookie($user->ID, $option->get('setcookie'));

                    $massage = 'خوش آمدید، شما وارد شدید!';

                } else {

                    $username = apply_filters('mrsms_username', $mobile);

                    $full_name = apply_filters('mrsms_fullname', '');

                    $user_id = wp_create_user($username, wp_generate_password(), $username . '@example.com');

                    if (! is_wp_error($user_id)) {
                        update_user_meta($user_id, 'nickname', $full_name);
                        update_user_meta($user_id, 'mobile', $mobile);
                        update_user_meta($user_id, 'first_name', $full_name);

                        if ($user_role = apply_filters('mrsms_user_role', '')) {

                            $user = new WP_User($user_id);

                            $user->set_role($user_role);
                        }
                        wp_set_current_user($user_id);
                        wp_set_auth_cookie($user_id, $option->get('setcookie'));

                        $massage = 'ثبت‌ نام با موفقیت انجام شد و شما وارد شدید!';
                    }

                }

                delete_transient('otp_' . $mobile);

                wp_send_json_success($massage);

            }
        }
    } else {
        wp_send_json_error('لطفا یکبار صفحه را بروزرسانی کنید', 403);

    }
    wp_send_json_error('لطفا دوباره تلاش کنید', 403);

}
