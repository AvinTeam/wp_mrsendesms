<?php
(defined('ABSPATH')) || exit;
global $title;

?>

<div id="wpbody-content">
    <div class="wrap">
        <h1><?php echo esc_html($title) ?></h1>
        <hr class="wp-header-end">
        <form method="post" action="" novalidate="novalidate" class="ag_form">
            <?php wp_nonce_field('mrsms_nonce' . get_current_user_id());?>
            <h2 class="title">نوتیویکیتور ( <a href="https://notificator.ir">لینک</a> )</h2>
            <table class="form-table" role="presentation">
                <tbody>
                    <tr>
                        <th scope="row"><label for="notificator_token">توکن نوتیو</label></th>
                        <td>
                            <input name="notificator_token" type="text" id="notificator_token"
                                value="<?=$mrsms_option[ 'notificator_token' ]?>" class="regular-text dir-ltr">
                        </td>
                    </tr>
                </tbody>
            </table>

            <h2 class="title">تی اس ام اس ( <a href="https://www.tsms.ir/">لینک</a> )</h2>
            <table class="form-table" role="presentation">
                <tbody>
                    <tr>
                        <th scope="row"><label for="tsms_username">نام کاربری</label></th>
                        <td>
                            <input name="tsms[username]" type="text" id="tsms_username"
                                value="<?=$mrsms_option['tsms'][ 'username' ]?>" class="regular-text dir-ltr">
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="tsms_password">رمز عبور پنل پیامک</label></th>
                        <td>
                            <input name="tsms[password]" type="text" id="tsms_password"
                                value="<?=$mrsms_option['tsms'][ 'password' ]?>" class="regular-text dir-ltr">
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="tsms_number">شماره ارسال پیامک</label></th>
                        <td>
                            <input name="tsms[number]" type="text" id="tsms_number"
                                value="<?=$mrsms_option['tsms'][ 'number' ]?>" class="regular-text dir-ltr onlyNumbersInput" inputmode="numeric" pattern="\d*">
                        </td>
                    </tr>
                </tbody>
            </table>
            <h2 class="title">قاصدک ( <a href="https://panel.ghasedaksms.com/">لینک</a> )</h2>
            <table class="form-table" role="presentation">
                <tbody>

                    <tr>
                        <th scope="row"><label for="ghasedaksms_ApiKey">ApiKey</label></th>
                        <td>
                            <input name="ghasedaksms[ApiKey]" type="text" id="ghasedaksms_ApiKey"
                                value="<?=$mrsms_option['ghasedaksms'][ 'ApiKey' ]?>" class="regular-text dir-ltr">
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="ghasedaksms_number">شماره ارسال پیامک</label></th>
                        <td>
                            <input name="ghasedaksms[number]" type="text" id="ghasedaksms_number"
                                value="<?=$mrsms_option['ghasedaksms'][ 'number' ]?>" class="regular-text dir-ltr onlyNumbersInput" inputmode="numeric" pattern="\d*">
                        </td>
                    </tr>
                </tbody>
            </table>







            <p class="submit">
                <button type="submit" name="mrsms_act" value="mrsms__submit" id="submit"
                    class="button button-primary">ذخیرهٔ
                    تغییرات</button>
            </p>
        </form>

    </div>


    <div class="clear"></div>
</div>