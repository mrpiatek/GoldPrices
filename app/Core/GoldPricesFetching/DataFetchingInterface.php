<?php


namespace GoldPrices\Core\GoldPricesFetching;


interface GoldPricesFetchingInterface
{
    /**
     * Gets gold prices between any given dates.
     * @param \DateTimeInterface $startDate
     * @param \DateTimeInterface $endDate
     * @return array
     */
    public function getGoldPrices(\DateTimeInterface $startDate, \DateTimeInterface $endDate);
}