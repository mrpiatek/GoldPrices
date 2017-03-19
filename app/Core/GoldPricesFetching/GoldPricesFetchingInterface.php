<?php


namespace GoldPrices\Core\GoldPricesFetching;


interface GoldPricesFetchingInterface
{
    /**
     * Gets gold prices between given dates.
     * @param GoldPricesFetchingRequestor $requestor
     * @return mixed
     */
    public function getGoldPrices(GoldPricesFetchingRequestor $requestor);
}