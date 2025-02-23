<?php
namespace smsclass;

class SMSOption
{

    protected $option;
    private $option_name = 'mrsms_option';

    public function __construct()
    {

        $this->option = get_option($this->option_name);

        if (! isset($this->option[ 'version' ]) || version_compare(MRSMS_VERSION, $this->option[ 'version' ], '>')) {

            $this->option = [
                'version'            => MRSMS_VERSION,
                'tsms'               => (isset($this->option[ 'tsms' ])) ? $this->option[ 'tsms' ] : [ 'username' => '', 'password' => '', 'number' => '' ],
                'ghasedaksms'        => (isset($this->option[ 'ghasedaksms' ])) ? $this->option[ 'ghasedaksms' ] : [ 'ApiKey' => '', 'number' => '' ],
                'sms_text_otp'       => (isset($this->option[ 'sms_text_otp' ])) ? $this->option[ 'sms_text_otp' ] : 'کد تأیید شما: %otp%',
                'set_timer'          => (isset($this->option[ 'set_timer' ])) ? $this->option[ 'set_timer' ] : 1,
                'set_code_count'     => (isset($this->option[ 'set_code_count' ])) ? $this->option[ 'set_code_count' ] : 4,
                'sms_type'           => (isset($this->option[ 'sms_type' ])) ? $this->option[ 'sms_type' ] : 'tsms',
                'setcookie'          => (isset($this->option[ 'setcookie' ])) ? $this->option[ 'setcookie' ] : 0,
                'notificator_token'  => (isset($this->option[ 'notificator_token' ])) ? $this->option[ 'notificator_token' ] : '',

                'receive_sms_type'   => (isset($this->option[ 'receive_sms_type' ])) ? $this->option[ 'receive_sms_type' ] : 'g',
                'receive_sms_date'   => (isset($this->option[ 'receive_sms_date' ])) ? $this->option[ 'receive_sms_date' ] : date('Y-m-d'),
                'receive_sms_number' => (isset($this->option[ 'receive_sms_number' ])) ? $this->option[ 'receive_sms_number' ] : '',
                'receive_sms_text'   => (isset($this->option[ 'receive_sms_text' ])) ? $this->option[ 'receive_sms_text' ] : '',

             ];

            $this->update($this->option);

        }

    }

    public function update($option)
    {

        update_option($this->option_name, $option);

    }

    public function get($select = '')
    {
        $option = $this->option;

        return (empty($select) || ! isset($option[ $select ])) ? $option : $option[ $select ];

    }

    public function set($data)
    {

        $this->option = $this->option;
        foreach ($data as $key => $value) {

            if ($key === "set_timer") {
                $value = absint($value);
            } elseif ($key === "set_code_count") {
                $value = absint($value);
            } elseif ($key === "sms_text_otp") {
                $value = sanitize_textarea_field($value);
            } elseif ($key === "sms_type") {
                $value = sanitize_text_field($value);
            } elseif ($key === "notificator_token") {
                $value = sanitize_text_field($value);
            } elseif ($key === "receive_sms_date") {
                if (! empty($data[ 'receive_sms_date' ])) {
                    $value = $data[ 'receive_sms_date' ];
                } else {
                    continue;
                }
            }

            $this->option[ $key ] = $value;

        }

        $this->update($this->option);

        $this->option = $this->option;

        return $this;
    }

    public function delete()
    {

        if (get_option($this->option_name) !== false) {
            delete_option($this->option_name);
        }
    }

}
