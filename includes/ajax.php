<?php


add_action('wp_ajax_nopriv_mrsms_sent_sms', 'mrsms_sent_sms');

function mrsms_sent_sms()
{

    if (wp_verify_nonce($_POST[ 'nonce' ], 'ajax-nonce' . mrsms_cookie())) {
        if ($_POST[ 'mobileNumber' ] !== "") {
            $mobile = sanitize_text_field($_POST[ 'mobileNumber' ]);

 


                //$mrsms_send_sms = mrsms_send_sms($mobile, 'otp');

                // if ($mrsms_send_sms[ 'code' ] == 1) {
                //     wp_send_json_success($mrsms_send_sms[ 'massage' ]);
                // }
                // wp_send_json_error($mrsms_send_sms[ 'massage' ], 403);

            
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

                $user_query = new WP_User_Query([
                    'meta_key'   => 'mobile',
                    'meta_value' => $mobile,
                    'number'     => 1,
                 ]);

                if (! empty($user_query->get_results())) {
                    $user = $user_query->get_results()[ 0 ];
                    wp_set_current_user($user->ID);
                    wp_set_auth_cookie($user->ID, true);

                    $massage = 'خوش آمدید، شما وارد شدید!';

                } else {

                    // $args = [
                    //     'post_type'      => 'institute',
                    //     'post_status'    => [ 'pending', 'publish', 'draft' ],
                    //     'meta_query'     => [
                    //         [
                    //             'key'     => '_mrsms_responsible-mobile',
                    //             'value'   => $mobile,
                    //             'compare' => '=',
                    //          ],
                    //      ],
                    //     'fields'         => 'ids',
                    //     'posts_per_page' => -1,
                    //  ];

                    // $query = new WP_Query($args);

                    // $post_count = $query->found_posts;
                    // if ($post_count >= 1 && $query->have_posts()) {

                    //     $post_id = $query->posts[ 0 ];

                    //     $full_name = get_post_meta($post_id, '_mrsms_responsible', true);

                    //     $user_id = wp_create_user($mobile, wp_generate_password(), $mobile . '@example.com');

                    //     if (! is_wp_error($user_id)) {
                    //         update_user_meta($user_id, 'nickname', $full_name);
                    //         update_user_meta($user_id, 'mobile', $mobile);
                    //         update_user_meta($user_id, 'first_name', $full_name);

                    //         $user = new WP_User($user_id);
                    //         $user->set_role('responsible');

                    //         wp_update_user([
                    //             'ID'           => $user_id,
                    //             'display_name' => $full_name,
                    //          ]);

                    //         wp_set_current_user($user_id);
                    //         wp_set_auth_cookie($user_id, true);

                    //         while ($query->have_posts()) {
                    //             $query->the_post();

                    //             $post_data = [
                    //                 'ID'          => get_the_ID(),
                    //                 'post_author' => $user_id,
                    //              ];

                    //             update_post_meta(get_the_ID(), '_mrsms_responsible', $full_name);

                    //             wp_update_post($post_data, true);

                    //         }

                    //         $massage = 'ثبت‌ نام با موفقیت انجام شد و شما وارد شدید!';
                    //     }

                    // }

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

