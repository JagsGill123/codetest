<?php


namespace App\Common\API;


use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use function Symfony\Component\VarDumper\Dumper\esc;

/**
 * Class Api
 * represents a single external api and can be overridden for each api for extra customisation
 * E.G. CountryAPI extends API, WorldsAPI extends API
 * @package App\Common\API
 */
class Api
{
    private $key = '';
    private $url = '';
    private $routesConfig = [];
    private $paramsConfig = [];

    /**
     * Api constructor.
     * @param $key
     * @param $config
     */
    public function __construct($key, $config)
    {
        // SET KEY
        $this->key = $key;
        // SET URL
        $this->url = $config['url'] ?? '';
        // SET ROUTES
        $this->routesConfig = $config['routes'] ?? [];
        $this->paramsConfig = $config['params'] ?? [];
    }

    /**
     * @param array $params
     * @return string
     */
    private function parseParams($params = [])
    {
        $paramStrings = [];
        foreach ($params as $key => $value) {
            if (array_key_exists($key, array_keys($this->paramsConfig))) {
                $paramConfig = $this->paramsConfig[$key];

                if ($value) {
                    if ($paramConfig == 'array') {
                        $paramStrings[''] = join(';', $value) . ';';
                    } else {
                        $paramStrings[] = $value;
                    }
                }
            }
        }

        return $paramStrings ? '?' . join('&', $paramStrings) : '';
    }

    /**
     * @param $route
     * @param $filter
     * @param array $queryParams
     * @return array
     * @throws ClientExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    function fetchData($route, $filter, $queryParams = [])
    {
        $url = $this->url . $route . '/' . $filter . $this->parseParams($queryParams);
        $httpClient = HttpClient::create();
        $response = $httpClient->request('GET', $url);
            return $response->toArray();
    }
}