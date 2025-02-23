<?php
namespace smsclass;

class ReceiveSMS extends SMSOption
{

    public function ghasedak_receive_sms()
    {

        $data = [
            'linenumber' => $this->option[ 'receive_sms_number' ],
            'fromdate'   => strtotime($this->option[ 'receive_sms_date' ]),
            'todate'     => time(),
            'limit'      => 1,
            'offset'     => 0,
         ];
        $header = [
            'ApiKey' => $this->option[ 'ghasedaksms' ][ 'ApiKey' ],
         ];

        $response = wp_remote_post('http://api.iransmsservice.com/v2/sms/receive/paging', [
            'headers' => $header,
            'body'    => http_build_query($data),
         ]);

        return json_decode(wp_remote_retrieve_body($response));
    }

}
