<?php
require_once ROOT . DS . 'Vendor' . DS . 'twilio' . DS . 'sdk' . DS . 'Services' . DS . 'Twilio.php';
require_once ROOT . DS . 'Vendor' . DS . 'twilio' . DS . 'sdk' . DS . 'Services' . DS . 'Twilio' . DS . 'Twiml.php';
/**
 * Twilio
 * 
 * @property string|null $__accountSid
 * @property string|null $__authToken
 * @property Services_Twilio|null $__instance 
 * 
 */
class Twilio {


    private $__accountSid = null;
    private $__authToken = null;
    private $__instance = null;
    
/**
 * Twilio object constructor
 * 
 * @param string|null $accountSid account secret id
 * @param string|null $authToken  account auth token
 * 
 */
    public function __construct($accountSid = null, $authToken = null) {
        $this->getInstance($accountSid, $authToken);
    }

/**
 * getInstance method
 * 
 * @param  string|null $accountSid account secret id
 * @param  string|null $authToken  account auth token
 * @return Services_Twilio|null    Twilio API object or null
 * 
 */
    public function getInstance($accountSid = null, $authToken = null) {
        if (!empty($accountSid) && !empty($authToken)) {
            $this->__accountSid = $accountSid;
            $this->__authToken = $authToken;
            $this->__instance = new Services_Twilio($this->__accountSid, $this->__authToken);
        }
        return $this->__instance;
    }

/**
 * getUniqueCode - Generates unique code for sms
 * 
 * @param  integer $len     generated code length
 * @param  string  $symbols allowed symbols string
 * @return string
 * 
 */
    public function getUniqueCode($len = 4, $symbols = "0123456789") {
        $code = '';
        for ($i = 0; $i < $len; $i++) {
            $code .= $symbols[rand(0, strlen($symbols) - 1)];
        }
        return $code;
    }


/**
 * sendSMS - Sends sms
 * 
 * @param  string $from - sms from phone number
 * @param  string $to   - sms ro phone number
 * @param  string $text - sms message text 
 * @return int
 * 
 */
    public function sendSMS($from, $to, $text) {
        $messageId = $this->__instance->account->messages->create(array(
                'From' => $from,
                'To' => $to,
                'Body' => $text
            ));
        return $messageId;
    }

/**
 * generateTwiML - Generates TwiML with passed text and music from url
 * 
 * @param  string $text          - call message text 
 * @param  string|null $musicUrl - music url 
 * @return string                - generated XML
 * 
 */
    public function generateTwiML($text, $musicUrl = null, $musicOptions = array()) {
        $response = new Services_Twilio_Twiml();
        $response->say($text);
        if (!empty($musicUrl)) {
            $response->play($musicUrl, $musicOptions);
        }
        return $response->__toString();
    }

/**
 * call - Maked a call with passed twiML
 * 
 * @param  string $from  - call from phone number
 * @param  string $to    - call to phone number
 * @param  string $twiMl - TwiML url
 * @return integer
 * 
 */
    public function call($from, $to, $twiMl) {
        $callId = null;
        
        if (empty($from) || empty($to) || empty($twiMl)) {
            return null;
        }

        try {
            $callId = $this
                ->__instance
                ->account
                ->calls
                ->create($from, $to, $twiML);
        } catch (Services_Twilio_RestException $e) {

        }
        return $callId;
    }
}