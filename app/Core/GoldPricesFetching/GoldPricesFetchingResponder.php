<?php


namespace GoldPrices\Core\GoldPricesFetching;


class GoldPricesFetchingResponder
{
    protected $goldPrices;

    /**
     * GoldPricesFetchingResponder constructor.
     * @param $goldPrices
     */
    public function __construct($goldPrices)
    {
        $this->goldPrices = $goldPrices;
    }

    /**
     * @return mixed
     */
    public function getGoldPrices()
    {
        return $this->goldPrices;
    }
}