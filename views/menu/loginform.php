<?php
    (defined('ABSPATH')) || exit;
    global $title;

?>
<div id="wpbody-content">
    <div class="wrap">
        <h1><?php echo esc_html($title) ?></h1>
        <hr class="wp-header-end">
        <textarea class="w-100 dir-ltr" rows="17">

        <form id="loginForm">
            <input type="hidden" id="created_user" name="created_user" value="true">
            <div id="mobileForm">
                <input type="text" inputmode="numeric" pattern="\d*" class="onlyNumbersInput" id="mobile" maxlength="11" placeholder="شماره موبایل خود را وارد کنید" aria-describedby="sendsms">
                <button id="send-code" type="submit" disabled>ورود</button>
            </div>
            <div id="codeVerification" style="display: none;">
                <input autocomplete="one-time-code" type="text" inputmode="numeric" pattern="\d*" class="onlyNumbersInput" id="verificationCode" placeholder="کد تایید را وارد کنید" aria-describedby="verify">
                <div id="timer">00:00</div>
                <button type="submit" id="verifyCode" disabled>تایید کد</button>
                <button type="button" id="resendCode" disabled>ارسال مجدد کد</button>
                <button type="button" id="editNumber">ویرایش شماره</button>
            </div>
        </form>

        </textarea>
    </div>


    <div class="clear"></div>
</div>