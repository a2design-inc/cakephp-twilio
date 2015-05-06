# cakephp-twilio

Twilio Plugin For CakePHP

## Examples

### Sms sending

``` php
<?php
    
    class ExampleController extends AppController {

        public $components = array('Twilio.Twilio');

        // some code
        // 
        
        public function sms() {
            // some code            
            $this->Twilio->sendSMS("YYY-YYY-YYYY", "XXX-XXX-XXXX", "Test message!");
        }
    }

```
