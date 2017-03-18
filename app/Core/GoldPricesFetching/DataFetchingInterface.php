<?php


namespace GoldPrices\Core\GoldPricesFetching;


interface GoldPricesFetchingInterface
{
    /**
     * Gets gold prices between given dates.
     * @param DataFetchingRequestor $requestor
     * @return mixed
     */
    public function getGoldPrices(DataFetchingRequestor $requestor);
}