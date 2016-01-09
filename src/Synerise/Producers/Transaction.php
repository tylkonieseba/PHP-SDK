<?php
namespace Synerise\Producers;

class Transaction extends ProducerAbstract
{

    public function addProduct($params = array()) {
        $data['params'] = $params;
        $data['object'] = 'transaction.product';
        $this->enqueue($data);
    }

    public function charge($params = array()) {
        $data['params'] = $params;
        $data['object'] = 'transaction.charge';
        $this->enqueue($data);
    }

}