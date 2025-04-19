<?php

use smsclass\SendSMS;

(defined('ABSPATH')) || exit;

function mrsms_panel_js($path)
{
    return MRSMS_JS . $path . '?ver=' . MRSMS_VERSION;
}

function mrsms_panel_css($path)
{
    return MRSMS_CSS . $path . '?ver=' . MRSMS_VERSION;
}

function mrsms_panel_image($path)
{
    return MRSMS_IMAGE . $path . '?ver=' . MRSMS_VERSION;
}

function mrsms_cookie(): string
{

    if (! is_user_logged_in()) {

        if (! isset($_COOKIE[ "setcookie_mrsms_nonce" ])) {

            $is_key_cookie = wp_generate_password(15);
            ob_start();

            setcookie("setcookie_mrsms_nonce", $is_key_cookie, time() + 1800, "/");

            ob_end_flush();

            header("Refresh:0");
            exit;

        } else {
            $is_key_cookie = $_COOKIE[ "setcookie_mrsms_nonce" ];
        }
    } else {

        $is_key_cookie = get_current_user_id();

    }
    return $is_key_cookie;
}

function number_to_enghlish($text)
{
    $text = trim($text);

    $western = [ '0', '1', '2', '3', '4', '5', '6', '7', '8', '9' ];
    $persian = [ '۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹' ];
    $arabic  = [ '٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩' ];
    $text    = str_replace($persian, $western, $text);
    $text    = str_replace($arabic, $western, $text);
    return $text;

}

function sanitize_phone($phone)
{
    /**
     * Convert all chars to en digits
     */

    $phone = number_to_enghlish($phone);

    $pattern = '/^(\+98|0)?9\d{9}$/';
    $isphone = preg_match($pattern, $phone);

    if (! $isphone) {return 0;}

    //.9158636712   => 09158636712
    if (strpos($phone, '.') === 0) {
        $phone = '0' . substr($phone, 1);
    }

    //00989185223232 => 9185223232
    if (strpos($phone, '0098') === 0) {
        $phone = substr($phone, 4);
    }
    //0989108210911 => 9108210911
    if (strlen($phone) == 13 && strpos($phone, '098') === 0) {
        $phone = substr($phone, 3);
    }
    //+989156040160 => 9156040160
    if (strlen($phone) == 13 && strpos($phone, '+98') === 0) {
        $phone = substr($phone, 3);
    }
    //+98 9156040160 => 9156040160
    if (strlen($phone) == 14 && strpos($phone, '+98 ') === 0) {
        $phone = substr($phone, 4);
    }
    //989152532120 => 9152532120
    if (strlen($phone) == 12 && strpos($phone, '98') === 0) {
        $phone = substr($phone, 2);
    }
    //Prepend 0
    if (strpos($phone, '0') !== 0) {
        $phone = '0' . $phone;
    }
    /**
     * check for all character was digit
     */
    if (! ctype_digit($phone)) {
        return '';
    }

    if (strlen($phone) != 11) {
        return '';
    }

    return $phone;

}

function sanitize_array_no_item($item)
{
    $new_item = [  ];

    foreach ($item as $value) {
        if (empty($value)) {continue;}
        $new_item[  ] = sanitize_text_field($value);
    }

    return $new_item;

}

function mrsms_send_sms($mobile, $massage)
{

    $send_sms = new SendSMS();

    return $send_sms->send($mobile, 'massage', $massage);

}

// $payid ="";
// $user_mobile = $mph_db->get('payid', $payid);

// print_r($user_mobile);