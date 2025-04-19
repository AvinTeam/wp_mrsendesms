<?php
    (defined('ABSPATH')) || exit;
    global $title;

?>

<div id="wpbody-content">
    <div class="wrap">
        <h1><?php echo esc_html($title) ?></h1>


        <hr class="wp-header-end">

        <form method="post" action="" novalidate="novalidate" class="ag_form">
            <?php wp_nonce_field('mrsms_nonce' . get_current_user_id()); ?>
            <table class="form-table" role="presentation">
                <tbody>

                    <tr>
                        <th scope="row">کوکی فعال شود؟</th>
                        <td>
                            <fieldset>
                                <label><input type="radio" name="setcookie"
                                        <?php checked($mrsms_option[ 'setcookie' ], 1)?> value="1">
                                    <span class="date-time-text">بله</span></label>
                                <label><input type="radio" name="setcookie"
                                        <?php checked($mrsms_option[ 'setcookie' ], 0)?> value="0"> <span
                                        class="date-time-text">خیر</span></label>
                            </fieldset>
                        </td>
                    </tr>

                    <tr>
                        <th scope="row"><label for="set_timer">رمان اعتبار کد های ارسالی</label></th>
                        <td><input name="set_timer" type="number" id="set_timer"
                                value="<?php echo $mrsms_option[ 'set_timer' ]?>" min="1"
                                class="regular-text dir-ltr onlyNumbersInput" inputmode="numeric" pattern="\d*"> دقیقه
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="set_code_count">تعداد کارکتر های پیامک</label></th>
                        <td><input name="set_code_count" type="number" id="set_code_count"
                                value="<?php echo $mrsms_option[ 'set_code_count' ]?>" min="1"
                                class="regular-text dir-ltr onlyNumbersInput" inputmode="numeric" pattern="\d*">
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="sms_text_otp">متن پیامک کد تایید</label></th>
                        <td>
                            <textarea rows="4" name="sms_text_otp" type="number" id="sms_text_otp"
                                class="regular-text"><?php echo $mrsms_option[ 'sms_text_otp' ]?></textarea>
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