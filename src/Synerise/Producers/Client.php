<?php
namespace Synerise\Producers;

class Client extends ProducerAbstract
{
    private $_customIdentify;

    public function customIdentify($customIdentify, $data = array()) {
        $this->_customIdentify = $customIdentify;
        if(!empty($data)){
            $this->setData($data);
        }
    }

    public function getCustomIdetify() {
        return $this->_customIdentify;    
    }

    public function setData($params = array()) {
        $data['params'] = $params;
        $data['object']= 'client.data'; 
        $this->enqueue($data);
    }

}