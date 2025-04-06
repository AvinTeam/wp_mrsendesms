<?php
namespace smsclass;

class SendSMS extends SMSOption
{

    /* panel sms  */
    public function notificator($mobile, $massage)
    {

        $data = [
            'to'   => $this->option[ 'notificator_token' ],
            'text' => $mobile . PHP_EOL . $massage,
         ];

        $response = wp_remote_post('https://notificator.ir/api/v1/send', [
            'body' => $data,
         ]);

        $res = json_decode(wp_remote_retrieve_body($response));

        $result = [
            'success' => (isset($res->success) && $res->success) ? true : false,
            'massage' => (isset($res->success) && $res->success) ? 'پیام با موفقیت ارسال شد' : 'پیام به خطا خورده است ',
         ];

        return $result;

    }

    private function tsms($mobile, $massage)
    {

        $msg_array = [ $massage ];

        $data = [
            'method'     => 'sendSms',
            'username'   => $this->option[ 'tsms' ][ 'username' ],
            'password'   => $this->option[ 'tsms' ][ 'password' ],
            'sms_number' => [ $this->option[ 'tsms' ][ 'number' ] ],
            'mobile'     => [ $mobile ],
            'msg'        => $msg_array,
            'mclass'     => [ '' ],
            'messagid'   => rand(),
         ];

        $response = wp_remote_post('https://www.tsms.ir/json/json.php', [
            'body' => http_build_query($data),
         ]);

        $response = json_decode(wp_remote_retrieve_body($response));
        // $result   = [
        //     'success' => ($response->code == 200) ? true : false,
        //     'massage' => ($response->code == 200) ? 'پیام با موفقیت ارسال شد' : 'پیام به خطا خورده است کد: ' . $response->code,
        //  ];
        $result = [
            'success' => true,
            'massage' => 'پیام با موفقیت ارسال شد',
         ];
        return $result;

    }

    private function ghasedaksms($mobile, $massage)
    {

        $data = [
            'message'  => $massage,
            'sender'   => $this->option[ 'ghasedaksms' ][ 'number' ],
            'receptor' => $mobile,
         ];
        $header = [
            'ApiKey' => $this->option[ 'ghasedaksms' ][ 'ApiKey' ],
         ];

        $response = wp_remote_post('http://api.ghasedaksms.com/v2/sms/send/bulk2', [
            'headers' => $header,
            'body'    => http_build_query($data),
         ]);

        $response = json_decode(wp_remote_retrieve_body($response));

        if (isset($response->messageids) && $response->messageids == null) {
            error_log('mobile: ' . $mobile);
            error_log(print_r($response, true));
        }

        // $result = [
        //     'code'    => (isset($response->result) && isset($response->messageids) && $response->result == 'success' && strlen($response->messageids) > 5) ? 1 : $response->messageids,
        //     'massage' => (isset($response->result) && isset($response->messageids) && $response->result == 'success' && strlen($response->messageids) > 5) ? 'پیام با موفقیت ارسال شد' : 'پیام به خطا خورده است',
        //  ];
        $result = [
            'success'    => true,
            'massage' => 'پیام با موفقیت ارسال شد',
         ];
        return $result;

    }

    private function sanitize_mobile($mobile)
    {

        $mobile = trim($mobile);

        $western = [ '0', '1', '2', '3', '4', '5', '6', '7', '8', '9' ];
        $persian = [ '۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹' ];
        $arabic  = [ '٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩' ];

        $mobile = str_replace($persian, $western, $mobile);
        $mobile = str_replace($arabic, $western, $mobile);
        /**
         * Convert all chars to en digits
         */

        //.9158636712   => 09158636712
        if (strpos($mobile, '.') === 0) {
            $mobile = '0' . substr($mobile, 1);
        }

        //00989185223232 => 9185223232
        if (strlen($mobile) == 14 && strpos($mobile, '0098') === 0) {
            $mobile = substr($mobile, 4);
        }
        //0989108210911 => 9108210911
        if (strlen($mobile) == 13 && strpos($mobile, '098') === 0) {
            $mobile = substr($mobile, 3);
        }
        //+989156040160 => 9156040160
        if (strlen($mobile) == 13 && strpos($mobile, '+98') === 0) {
            $mobile = substr($mobile, 3);
        }
        //+98 9156040160 => 9156040160
        if (strlen($mobile) == 14 && strpos($mobile, '+98 ') === 0) {
            $mobile = substr($mobile, 4);
        }
        //989152532120 => 9152532120
        if (strlen($mobile) == 12 && strpos($mobile, '98') === 0) {
            $mobile = substr($mobile, 2);
        }
        //Prepend 0
        if (strpos($mobile, '0') !== 0) {
            $mobile = '0' . $mobile;
        }
        /**
         * check for all character was digit
         */
        if (! ctype_digit($mobile)) {
            return '';
        }

        if (strlen($mobile) != 11) {
            return '';
        }

        // is Mobile
        $pattern = '/^(\+98|0)?9\d{9}$/';
        if (! preg_match($pattern, $mobile)) {
            return '';
        }

        return $mobile;

    }

    private function otp($mobile)
    {

        if (get_transient('otp_' . $mobile)) {
            return [
                'success' => false,
                'massage' => 'لطفا چند دقیقه دیگر تلاش کنید.',
             ];
        } else {

            $otp = '';

            for ($i = 0; $i < $this->option[ 'set_code_count' ]; $i++) {
                $otp .= rand(0, 9);
            }
            set_transient('otp_' . $mobile, $otp, $this->option[ 'set_timer' ] * MINUTE_IN_SECONDS);

            $server_name = isset($_SERVER[ 'HTTP_HOST' ]) ? $_SERVER[ 'HTTP_HOST' ] : $_SERVER[ 'SERVER_NAME' ];

            $finalMessage = str_replace('%otp%', $otp, $this->option[ 'sms_text_otp' ]);

            $message = "$finalMessage\n@$server_name #$otp";

            return [
                'success' => true,
                'massage' => $message,
             ];
        }
    }

    public function send($mobile, $type, $data = [  ])
    {
        $mobile = $this->sanitize_mobile($mobile);

        // بررسی فرمت شماره موبایل
        if (empty($mobile) || empty($this->sanitize_mobile($mobile))) {
            return [
                'success' => false,
                'massage' => 'شماره موبایل معتبر نیست.',
             ];
        }
        if ($type == 'otp') {
            $result = $this->otp($mobile);
            if ($result[ 'success' ]) {

                $sms_type = $this->option[ 'sms_type' ];

                $result = $this->$sms_type($mobile, $result[ 'massage' ]);
                if (! $result[ 'success' ]) {
                    delete_transient('otp_' . $mobile);
                }
            }
        }
        return $result || [ 'success' => false, 'massage' => 'خطا' ];
    }
}