<?php
App::import('Twilio.Lib', 'Twilio');
class TwilioComponent extends Component {

    protected $_controller = null;
    protected $_twilioClient = null;


    public function __construct(ComponentCollection $collection, $settings = array()) {
        $this->_twilioClient = new Twilio($settings['accountSid'], $settings['authToken']);
        parent::__construct($collection, $settings);
    }

    public function sendSMS($from, $to, $message) {
        return $this->_twilioClient->sendSMS($from, $to, $message);
    }
}