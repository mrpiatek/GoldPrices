<?php

namespace GoldPrices\Core\NbpApi;


use GoldPrices\Core\GoldPricesFetching\GoldPricesFetchingInterface;
use GoldPrices\Core\GoldPricesFetching\GoldPricesFetchingRequestor;
use GoldPrices\Core\GoldPricesFetching\GoldPricesFetchingResponder;
use GoldPrices\Core\NbpApi\Exceptions\NbpApiFailureException;
use GoldPrices\Core\NbpApi\Exceptions\TimeSpanOverOneYearException;
use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;

class NbpApiService implements GoldPricesFetchingInterface
{
    const API_URL = 'http://api.nbp.pl/api/cenyzlota/%s/%s';
    /** @var  Client */
    protected $httpClient;

    /**
     * NbpApiService constructor.
     * @param Client $httpClient
     */
    public function __construct(Client $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    /**
     * Gets gold prices for maximum one year time span.
     * @param GoldPricesFetchingRequestor $requestor
     * @return GoldPricesFetchingResponder
     * @throws NbpApiFailureException
     * @throws TimeSpanOverOneYearException
     * @internal param \DateTimeInterface $startDate
     * @internal param \DateTimeInterface $endDate
     */
    public function getGoldPrices(GoldPricesFetchingRequestor $requestor)
    {
        if ($requestor->getStartDate()->diff($requestor->getEndDate())->y > 1) {
            throw new TimeSpanOverOneYearException();
        }
        /** @var ResponseInterface $response */
        $response = $this->httpClient->get(
            sprintf(
                self::API_URL,
                $requestor->getStartDate()->format('Y-m-d'),
                $requestor->getEndDate()->format('Y-m-d')
            ),
            [
                'exceptions' => false,
            ]
        );

        if ($response->getStatusCode() !== 200) {
            throw new NbpApiFailureException();
        }

        return new NbpApiResponder($response->getBody()->getContents());
    }
}