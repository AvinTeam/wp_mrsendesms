<?php
    (defined('ABSPATH')) || exit;
    global $title;

?>

<div id="wpbody-content">
    <div class="wrap">
        <h1><?php echo esc_html($title) ?></h1>


        <hr class="wp-header-end">

        <?php if ($error = get_transient('error_mat')) {?>
        <div class="notice notice-error settings-error is-dismissible">
            <p><?php echo esc_html($error); ?></p>
        </div>
        <?php set_transient('error_mat', '');}?>

        <?php if ($success = get_transient('success_mat')) {?>
        <div class="notice notice-success settings-error is-dismissible">
            <p><?php echo esc_html($success); ?></p>
        </div>
        <?php set_transient('success_mat', '');}?>

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

                    <tr>
                        <th scope="row">نوع پنل پیامک</th>
                        <td>
                            <fieldset>
                                <legend class="screen-reader-text"><span>
                                        نوع پنل پیامک </span></legend>
                                <label><input type="radio" name="sms_type"
                                        <?php checked($mrsms_option[ 'sms_type' ], 'notificator')?> value="notificator">
                                    <span class="date-time-text">notificator</span></label>
                                <label><input type="radio" name="sms_type"
                                        <?php checked($mrsms_option[ 'sms_type' ], 'tsms')?> value="tsms"> <span
                                        class="date-time-text">tsms</span></label>
                                <label><input type="radio" name="sms_type"
                                        <?php checked($mrsms_option[ 'sms_type' ], 'ghasedaksms')?> value="ghasedaksms">
                                    <span class="date-time-text">ghasedaksms</span></label>
                            </fieldset>
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