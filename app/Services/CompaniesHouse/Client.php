<?php
/**
 * Created by PhpStorm.
 * User: florin
 */

namespace App\Services\CompaniesHouse;


class Client
{
    /**
     * @var $httpClient
     */
    protected $httpClient;
    protected $baseApiUrl;

    public function __construct()
    {
        $this->httpClient = new \GuzzleHttp\Client();
        $this->baseApiUrl = env('COMPANIESHOUSE_API');
    }

    /**
     * Handles http requests to the CompaniesHouse API
     *
     * @param $verb
     * @param $endpoint
     * @param null $payload
     *
     * @return object
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    protected function sendRequest($verb, $endpoint, $payload = null){
        try {
            $response = $this->httpClient->request($verb, $this->baseApiUrl . $endpoint,  $this->setData($payload));
            if($response->getStatusCode() === 200){
                $code = $response->getStatusCode();
                $message = json_decode($response->getBody()->getContents());
            }
        } catch (\GuzzleHttp\Exception\ClientException $e){
            $code = $e->getCode();
            $message = json_decode($e->getResponse()->getBody()->getContents());
        } catch (\GuzzleHttp\Exception\ServerException $e){
            $code = $e->getCode();
            $message = json_decode($e->getResponse()->getBody()->getContents());
        } catch (\GuzzleHttp\Exception\RequestException $e){
            $code = $e->getCode();
            $message = 'An unexpected network error occurred';
            var_dump($verb, $endpoint, $this->setData($payload));
        }
        $return = [
            'code' => $code,
            'message' => $message,
        ];

        return (object)$return;
    }

    public function setData($payload)
    {
        $data = [];
        if(is_array($payload) && count($payload)) {
            $data = [
                'json' => $payload,
            ];
        }

        $data['headers']['Content-Type'] = ['application/json'];
        $data['auth'] = [
            env("COMPANIESHOUSE_API_KEY"),
            ''
        ];

        return $data;
    }

    public function getCompany($companyId){
        $endpoint = 'company/' . $companyId;

        return $this->sendRequest('GET', $endpoint);
    }

    public function getCompanyOfficers($companyId){
        $endpoint = 'company/' . $companyId . '/officers';

        return $this->sendRequest('GET', $endpoint);
    }

    public function getCompanyInsolvency($companyId){
        $endpoint = 'company/' . $companyId . '/insolvency';

        return $this->sendRequest('GET', $endpoint);
    }
}