<?php

namespace Tests\Unit;

use App\Services\NpiRegistryService;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ServerException;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

class NpiRegistryServiceTest extends TestCase
{
    private $fixtureData;

    protected function setup(): void
    {
        $this->fixtureData = [
            "created_epoch" => "1546364681000",
            "enumeration_type" => "NPI-1",
            "last_updated_epoch" => "1546364681000",
            "number" => "1821560897",
            "addresses" => [
                [
                    "country_code" => "US",
                    "country_name" => "United States",
                    "address_purpose" => "MAILING",
                    "address_type" => "DOM",
                    "address_1" => "13947 S NEWBURG DR",
                    "city" => "HERRIMAN",
                    "state" => "UT",
                    "postal_code" => "840966787",
                ]
            ],
            "practiceLocations" => [],
            "basic" => [
                "first_name" => "MCKAYLA",
                "last_name" => "MONSON"
            ],
            "taxonomies" => [],
            "identifiers" => [],
            "endpoints" => [],
            "other_names" => [],
        ];
    }

    private function setupMockResponse($expectedResponse)
    {
        $mockHandler = new MockHandler();
        $handler = HandlerStack::create($mockHandler);
        $client = new Client(['handler' => $handler]);
        $mockHandler->append($expectedResponse);
        return ['cli' => $client, 'mock' => $mockHandler];
    }

    // simple test to catch regressions
    public function test_simple_query()
    {
        $mock = $this->setupMockResponse(
            new Response(200, [], json_encode($this->fixtureData))
        );

        $service = new NpiRegistryService($mock['cli']);

        $result = $service->query([
            'first_name' => 'first',
            'last_name' => 'last',
            'number' => '12345'
        ]);
        $this->assertEquals($result, $this->fixtureData);
        $query = $mock['mock']->getLastRequest()->getUri()->getQuery();
        $this->assertEquals(
            $actual=$query,
            $expected='version=2.1&first_name=first&last_name=last&number=12345'
        );

    }

    public function test_query_api_exception() {
        $mock = $this->setupMockResponse(
            new Response(500, [], json_encode($this->fixtureData))
        );

        $service = new NpiRegistryService($mock['cli']);
        $this->expectException(ServerException::class);

        $service->query(['last_name'=> 'testlast']);
    }
}
