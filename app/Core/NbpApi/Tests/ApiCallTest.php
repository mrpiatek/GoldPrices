<?php

namespace Tests\Feature;

use GoldPrices\Core\GoldPricesFetching\GoldPricesFetchingRequestor;
use GoldPrices\Core\NbpApi\Exceptions\NbpApiFailureException;
use GoldPrices\Core\NbpApi\Exceptions\TimeSpanOverOneYearException;
use GoldPrices\Core\NbpApi\NbpApiService;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Tests\TestCase;

class ApiCallTest extends TestCase
{
    /**
     * Test if the service is making a proper call
     *
     * @return void
     */
    public function testBasicCall()
    {
        $httpCallHistory = [];
        $client = $this->prepareMockClient(
            $httpCallHistory,
            [
                new Response(200, [], '[{"data":"2017-03-17","cena":159.31}]'),
            ]
        );

        $nbpApi = new NbpApiService($client);

        $startDate = (new \DateTime())->modify('-1 year');
        $endDate = new \DateTime();

        $nbpApi->getGoldPrices(
            new GoldPricesFetchingRequestor(
                $startDate,
                $endDate
            )
        );

        // test that the service did a call to NBP API
        $this->assertArrayHasKey(0, $httpCallHistory);
        $this->assertArrayHasKey('request', $httpCallHistory[0]);

        /** @var Request $request */
        $request = $httpCallHistory[0]['request'];

        // test that the call was to proper URI
        $this->assertEquals('http', $request->getUri()->getScheme());
        $this->assertEquals('api.nbp.pl', $request->getUri()->getHost());
        $this->assertEquals(
            sprintf(
                '/api/cenyzlota/%s/%s',
                $startDate->format('Y-m-d'),
                $endDate->format('Y-m-d')
            ),
            $request->getUri()->getPath()
        );
    }

    private function prepareMockClient(&$httpCallHistory, $mockedResponses = []): Client
    {
        $mock = new MockHandler($mockedResponses);

        $handler = HandlerStack::create($mock);

        $httpCallHistory = [];
        $history = Middleware::history($httpCallHistory);

        $handler->push($history);

        return new Client(['handler' => $handler]);
    }

    /**
     * Test if service will fail if requested with time range exceeding one year
     *
     * @expectedException TimeSpanOverOneYearException
     * @return void
     */
    public function testCallWithTimeSpanOverOneYear()
    {
        $httpCallHistory = [];
        $client = $this->prepareMockClient(
            $httpCallHistory,
            [
                new Response(200, [], '[{"data":"2017-03-17","cena":159.31}]'),
            ]
        );

        $nbpApi = new NbpApiService($client);

        $startDate = (new \DateTime())->modify('-10 year');
        $endDate = new \DateTime();

        $this->expectException(TimeSpanOverOneYearException::class);

        $nbpApi->getGoldPrices(
            new GoldPricesFetchingRequestor(
                $startDate,
                $endDate
            )
        );
    }

    /**
     * Test if service will fail if there is an internal error with the NBP API
     *
     * @expectedException NbpApiFailureException
     * @return void
     */
    public function testCallWithServerError()
    {
        $httpCallHistory = [];
        $client = $this->prepareMockClient(
            $httpCallHistory,
            [
                new Response(500),
            ]
        );

        $nbpApi = new NbpApiService($client);

        $this->expectException(NbpApiFailureException::class);

        $nbpApi->getGoldPrices(
            new GoldPricesFetchingRequestor(
                new \DateTime(),
                new \DateTime()
            )
        );
    }
}
