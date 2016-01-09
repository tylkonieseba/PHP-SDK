<?php
namespace Synerise;

use InvalidArgumentException;
use GuzzleHttp\Client;
use GuzzleHttp\Event\ErrorEvent;
use GuzzleHttp\Ring\Client\MockHandler;


abstract class SyneriseAbstractHttpClient extends Client
{
    /** @var string */
    const DEFAULT_CONTENT_TYPE = 'application/x-www-form-urlencoded';

    /** @var string */
    const DEFAULT_ACCEPT_HEADER = 'application/json';

    /** @var string */
    const USER_AGENT = 'synerise-php-sdk/2.1';
    
    /** @var string */
    const DEFAULT_API_VERSION = '2.1';

    /** @var string */
    const BASE_URL = 'https://api.synerise.com';


    /**
     * Configures the client by setting the appropriate headers, service description and error handling
     *
     * @param Collection $config
     */
    protected function configure($config)
    {
        $this->setDefaultOption('headers', $this->margeHeaders($config));
        $this->setErrorHandler();
    }

    /**
     * Marge headers default and custom
     *
     * @return array
     */
    private function margeHeaders($config)
    {
        $default = $this->getDefaultConfig();
        
        $apiVersion = $config->get('apiVersion');
        $configHeaders = $config->get('headers');
        $defaultHeaders = $default['headers'];

        $headers = $configHeaders + $defaultHeaders;
        $headers['Api-Key'] = $config->get('apiKey');
        $headers['Api-Version'] = empty($apiVersion) ? self::DEFAULT_API_VERSION : $config->get('apiVersion');

        return $headers;
    }

    /**
     * Overrides the error handling in Guzzle so that when errors are encountered we throw
     * Synersie errors, not Guzzle ones.
     *
     */
    private function setErrorHandler()
    {
        $this->getEmitter()->on('error', function (ErrorEvent $e) {
            //@TODO ErrorHendler
            //if ($e->getResponse()->getStatusCode() >= 400 && $e->getResponse()->getStatusCode() < 600) {
            //}
        });
    }

    
    /**
     * Gets the default configuration options for the client
     *
     * @return array
     */
    public static function getDefaultConfig()
    {
        return [
            'base_url' => self::BASE_URL,
            'headers' => [
                'Content-Type' => self::DEFAULT_CONTENT_TYPE,
                'Accept' => self::DEFAULT_ACCEPT_HEADER,
                'User-Agent' => self::USER_AGENT,
            ]
        ];
    }

}