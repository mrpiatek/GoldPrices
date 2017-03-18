<?php

namespace Gold\Services;


use Gold\Exceptions\NbpApiFailureException;
use Gold\Exceptions\TimeSpanOverOneYearException;

class NbpApiService
{
    /** @var  Client */
    protected $httpClient;

    protected const API_URL = 'http://api.nbp.pl/api/cenyzlota';

    /**
     * Gets gold prices for each day between any given dates.
     * @param \DateTimeInterface $startDate
     * @param \DateTimeInterface $endDate
     * @return array
     */
    public function getGoldData(\DateTimeInterface $startDate, \DateTimeInterface $endDate)
    {
        $data = [];
        /** @var \DateTimeInterface $diff */
        $diff = $endDate->diff($startDate);
        for ($i = 0; $i < $diff->y; $i++) {
            $data[] = $this->getDataForOneYear($startDate, $endDate->addYears(1));
        }
        return $data;
    }

    /**
     * Gets gold prices for maximum one year time span.
     * @param \DateTimeInterface $startDate
     * @param \DateTimeInterface $endDate
     * @return array
     * @throws NbpApiFailureException
     * @throws TimeSpanOverOneYearException
     */
    private function getDataForOneYear(\DateTimeInterface $startDate, \DateTimeInterface $endDate)
    {
        if($startDate->diff($endDate)->y > 1){
            throw new TimeSpanOverOneYearException();
        }
        // todo format
        $data = $this->httpClient->get(self::API_URL . '/' . $startDate->format('Y-m-d') . '/' . $endDate->format('Y-m-d'));
        if(!$data->statusCodeOk){
            throw new NbpApiFailureException();
        }
        return $data;
    }
}