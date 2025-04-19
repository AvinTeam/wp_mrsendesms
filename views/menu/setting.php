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