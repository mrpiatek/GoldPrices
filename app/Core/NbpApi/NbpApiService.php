<?php

namespace GoldPrices\Core\NbpApi;


use GoldPrices\Core\GoldPricesFetching\GoldPricesFetchingInterface;
use GoldPrices\Core\GoldPricesFetching\GoldPricesFetchingRequestor;
use GoldPrices\Core\GoldPricesFetching\GoldPricesFetchingResponder;
use GoldPrices\Core\NbpApi\Exceptions\NbpApiFailureException;
use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;

class NbpApiService implements GoldPricesFetchingInterface
{
    const API_URL = 'http://api.nbp.pl/api/cenyzlota/%s/%s';
    /** @var  Client */
    protected $httpClient;

    /** @var  NbpApiDateRangeChunker */
    protected $chunker;

    /**
     * NbpApiService constructor.
     * @param Client $httpClient
     * @param NbpApiDateRangeChunker $chunker
     */
    public function __construct(Client $httpClient, NbpApiDateRangeChunker $chunker)
    {
        $this->httpClient = $httpClient;
        $this->chunker = $chunker;
    }


    /**
     * Gets gold prices for maximum one year time span.
     * @param GoldPricesFetchingRequestor $requestor
     * @return GoldPricesFetchingResponder
     * @throws NbpApiFailureException
     * @internal param \DateTimeInterface $startDate
     * @internal param \DateTimeInterface $endDate
     */
    public function getGoldPrices(GoldPricesFetchingRequestor $requestor): GoldPricesFetchingResponder
    {
        $chunks = $this->chunker->chunk(
            $requestor->getStartDate(),
            $requestor->getEndDate()
        );

        $results = [];
        foreach ($chunks as $dateRange) {
            /** @var ResponseInterface $response */
            $response = $this->httpClient->get(
                sprintf(
                    self::API_URL,
                    $dateRange['from']->format('Y-m-d'),
                    $dateRange['to']->format('Y-m-d')
                ),
                [
                    'exceptions' => false,
                ]
            );

            if ($response->getStatusCode() == 404) {
                // 404 means there is no data for given period
                continue;
            }

            if ($response->getStatusCode() !== 200) {
                throw new NbpApiFailureException();
            }

            $results[] = $response->getBody()->getContents();
        }

        return new NbpApiResponder($results);
    }
}