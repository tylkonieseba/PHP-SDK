<?php
namespace Synerise;

use GuzzleHttp\Collection;
use Synerise\Producers\Client;
use Synerise\Producers\Event;
use GuzzleHttp\Pool;
use GuzzleHttp\Ring\Client\MockHandler;
use GuzzleHttp\Subscriber\History;
use Synerise\Consumer\ForkCurlHandler;

class SyneriseCoupon extends SyneriseAbstractHttpClient
{

    /** @var array The required config variables for this type of client */
    private static $required = [
        'apiKey',
        'headers',
    ];

    /**
     * An instance of the SyneriseCoupon class (for singleton use)
     * @var SyneriseTracker
     */
    private static $_instance;

    /**
     * Returns a singleton instance of SyneriseCoupon
     * @param array $config
     * @return SyneriseTracker
     */
    public static function getInstance($config = array()) {
        if(!isset(self::$_instance)) {
            self::$_instance = new SyneriseCoupon($config);
        }
        return self::$_instance;
    }

    /**
     * Instantiates a new SyneriseCoupon instance.
     * @param array $config
     */
    public function __construct($config = array()) {
        parent::__construct($config);
    	$config = Collection::fromConfig($config, static::getDefaultConfig(), static::$required);
		$this->configure($config);
    }


    /**
     * @param $token
     * @return Coupon
     * @throws SyneriseException
     */
    public function getStatusCoupon($token) {
        /**
         * @var GuzzleHttp\Message\Response
         */
        $response = $this->sendSynerise($token, 'get');

        if($response->getStatusCode() == '200') {
            $responseArray = $response->json();
            return new Response\Coupon($responseArray['code'], $responseArray['message']);
        }
        throw new SyneriseException('API Synerise not responsed 200.', 500);
    }


    /**
     * @param $token
     * @return bool
     * @throws SyneriseException
     *         code: 20105 - Coupon.Use.AlreadyUsed
     *         code: -1 - Coupon.UnknownError
     *         code: 500 - HTTP error
     */
    public function useCoupon($token) {

        $response = $this->sendSynerise($token, 'use');

        if($response->getStatusCode() == '200') {
            $responseArray = $response->json();
            switch ( $responseArray['code']) {
                case 1:
                    return true;
                case 20105:
                    throw new SyneriseException('Coupon.Use.AlreadyUsed', 20105);
                case 20101:
                    throw new SyneriseException('Coupon.Use.NotFound', 20101);
                default:
                    throw new SyneriseException('Coupon.UnknownError', -1);
            }
        }
        throw new SyneriseException('API Synerise not responsed 200.', 500);
    }



    /**
     * Flush the queue when we destruct the client with retries
     */
    public function sendSynerise($token, $type) {

        $history = new History();
        $this->getEmitter()->attach($history);

        switch ($type) {
            case 'use':
                $url = sprintf('coupons/active/%s/%s', $token, $type);
                $method = 'POST';
                break;
            default:
                $url = sprintf('coupons/active/%s', $token);
                $method = 'GET';
        }

        $request = $this->createRequest($method, "https://api.synerise.com/".$url);

        try {
            $response =  $this->send($request);
            $this->_log($history);
            return $response;
        } catch(\Exception $e) {

        }
    }

}