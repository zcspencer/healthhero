<?php

namespace App\Services;

use App\Exceptions\NpiApiException;
use GuzzleHttp\ClientInterface;
use Psr\Http\Message\ResponseInterface;

class NpiRegistryService implements RegistryService
{
    private $client;
    private $default_query = ['version' => '2.1'];

    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    public function query($lookup)
    {
        // TODO validation and error catching
        $response = $this->client->request('GET', 'https://npiregistry.cms.hhs.gov/api/', [
            'query' => array_merge($this->default_query, $lookup),
        ]);

        return $this->response($response);
    }

    private function response(ResponseInterface $response) {

        switch ($response->getStatusCode()) {
            case \Illuminate\Http\Response::HTTP_OK:
                return json_decode($response->getBody()->getContents(), true);
            default:
                throw new NpiApiException("unexpected api response");
        }
    }
}
