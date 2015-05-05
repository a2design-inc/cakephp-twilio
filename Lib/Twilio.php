<?php
require_once ROOT . DS . 'Vendor' . DS . 'twilio' . DS . 'sdk' . DS . 'Services' . DS . 'Twilio.php';
class Twilio {


    private $__accountSid = null;
    private $__authToken = null;
    private $__instance = null;
    

    public function __construct($accountSid = null, $authToken = null) {
        $this->getInstance($accountSid, $authToken);
    }

    public function getInstance($accountSid = null, $authToken = null) {
        if (!empty($accountSid) && !empty($authToken)) {
            $this->__accountSid = $accountSid;
            $this->__authToken = $authToken;
            $this->__instance = new Services_Twilio($this->__accountSid, $this->__authToken);
        }
        return $this->__instance;
    }

    public function getUniqueCode($len = 4, $symbols = "0123456789") {
        $code = '';
        for ($i = 0; $i < $len; $i++) {
            $code .= $symbols[rand(0, strlen($symbols) - 1)];
        }
        return $code;
    }


    public function sendSMS($from, $to, $text) {
        $messageId = $this->__instance->account->messages->create(array(
                'From' => $from,
                'To' => $to,
                'Body' => $text
            ));
        return $messageId;
    }

    public function call($from, $to) {

    }
}