<?php


namespace App\Common\API;

use Symfony\Component\HttpClient\HttpClient;

/**
 * Singleton class that allows access to different external API's via the config below
 * Class ApiManager
 * @package App\Common\API
 */
class ApiManager
{
    const API_COUNTRY = 'country';

    /**
     * @var Api[]
     */
    private $api = [];

    /**
     * @var null|ApiManager
     */
    private static $instance = null;

    /**
     * ApiManager constructor.
     */
    private function __construct()
    {
        // load config
        foreach ($this->getConfig() as $key => $value) {
            $className = $value['class'] ?? '\App\Common\API\Api';
            // TODO CHECK CLASS EXISTS
            $this->api[$key] = new $className($key, $value);
        }
    }

    // The object is created from within the class itself
    // only if the class has no instance.
    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new ApiManager();
        }

        return self::$instance;
    }

    /**
     * @param $key
     * @return Api
     */
    function getApi($key)
    {
        if (!array_key_exists($key, $this->api)) {
            throw new \Exception($key . 'API is not setup');
        }

        return $this->api[$key];
    }

    private function getConfig()
    {
        // FIXME (NOTE) IN REAL CODE WOULD MOVE TO CONFIG FILE TO ALLOW USE OF CODE FOR MULTIPLE API SOURCES
        return [
            self::API_COUNTRY => [
                'url' => 'https://restcountries.eu/rest/v2/',
                'routes' => [
                    'name' => [
                        'route' => 'name',
                        'params' => [
                            'fullText' => 'bool'
                        ],
                    ],
                    'dialingCode' => [
                        'route' => 'callingcode',
                    ],
                    'countryCode' => [
                        'route' => 'alpha',
                        'params' => [
                            'codes' => 'array'
                        ],
                    ],
                    'currency' => [
                        'route' => 'currency',
                    ],
                    'languages' => [
                        'route' => 'lang',
                    ],
                    'capital' => [
                        'route' => 'capital',
                    ],
                    'region' => [
                        'route' => 'region',
                    ],
                    'regionalbloc' => [
                        'route' => 'regionalbloc',
                    ],
                ]
            ]
        ];
    }
}