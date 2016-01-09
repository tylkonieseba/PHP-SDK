<?php
namespace Synerise;

use GuzzleHttp\Collection;
use Synerise\Producers\Client;
use Synerise\Producers\Event;
use GuzzleHttp\Pool;
use GuzzleHttp\Ring\Client\MockHandler;
use Synerise\Consumer\ForkCurlHandler;

class SyneriseTracker extends SyneriseAbstractHttpClient
{

    /** @var array The required config variables for this type of client */
    private static $required = [
        'apiKey',
        'headers',
    ];

    /**
     * An instance of the SyneriseTracker class (for singleton use)
     * @var SyneriseTracker
     */
    private static $_instance;

    /**
     * An instance of the Client class (used to create/update client profiles)
     * @var Producers\Client
     */
    public $client;

    /**
     * An instance of the Event class (used for tracking custom event)
     * @var Producer\Event
     */
    public $event;

    /**
     * An instance of the Transaction class (used for tracking purchase event)
     * @var Producer\Transaction
     */
    public $transaction;

    /**
     * Returns a singleton instance of SyneriseTracker
     * @param array $config
     * @return SyneriseTracker
     */
    public static function getInstance($config = array()) {
        if(!isset(self::$_instance)) {
            self::$_instance = new SyneriseTracker($config);
        }
        return self::$_instance;
    }

    /**
     * Instantiates a new SyneriseTracker instance.
     * @param array $config
     */
    public function __construct($config = array()) {

    	if(isset($config['allowFork']) && $config['allowFork'] == true){
			$config['handler'] = new ForkCurlHandler([]);
    	}

        parent::__construct($config);

		$this->client = Producers\Client::getInstance();
		$this->event = Event::getInstance();
		$this->transaction = Producers\Transaction::getInstance();

    	$config = Collection::fromConfig($config, static::getDefaultConfig(), static::$required);
		$this->configure($config);

    }

    /**
     * Flush the queue when we destruct the client with retries
     */
    public function __destruct() {
    	$data['json'] = array_merge($this->event->getRequestQueue(), 
    		$this->transaction->getRequestQueue(), 
    		$this->client->getRequestQueue());
        
        $options = $this->getDefaultOption();
        $apiKey = isset($options['headers']['Api-Key']) ? $options['headers']['Api-Key'] : '';

        $request = $this->createRequest('POST', "https://tck.synerise.com/sdk-proxy/".$apiKey, $data);
        $request->setHeader('Content-Type','application/json');

		$this->send($request);

	}

}