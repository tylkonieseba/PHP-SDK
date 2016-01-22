<?php
namespace Synerise\Response;

class Coupon
{

    private $_status = null;
    private $_message = null;

    public function __construct($status, $message) {
        $this->_status = $status;
        $this->_message = $message;
    }


    /**
     * Coupon can be used
     * @return bool
     */
    public function canUse() {
        return $this->_status == 1;
    }

    /**
     * Coupon is active
     * @return bool
     */
    public function isActive() {
        return $this->_status == 1111; //@todo docelowo kupon jest aktywny ale nie spełnia warunków koszyka
    }


    public function getMessage() { //@todo jeśli kupon jest aktwyny ale brakuje innych warunków aby go wykrozystać (pamiętać o różnych warunkach i o wersjach językowych, walutach).
        if($this->isActive()) {
            return array(
                'code' => 881,
                'message' => '20',
                'description' => 'Kup coś za 20zł aby móc urzyć kuponu'
            );
        }

        return;
    }
}