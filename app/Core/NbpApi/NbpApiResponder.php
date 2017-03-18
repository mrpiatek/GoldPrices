<?php


namespace GoldPrices\Core\NbpApi;


use GoldPrices\Core\GoldPricesFetching\GoldPricesFetchingResponder;

class NbpApiResponder extends GoldPricesFetchingResponder
{
    /**
     * NbpApiResponder constructor.
     * @param $goldPrices
     */
    public function __construct($goldPrices)
    {
        parent::__construct($this->formatData($goldPrices));
    }


    /**
     * Formats NBP API raw json response to application specific format
     * @param $data
     * @return array
     */
    private function formatData($data)
    {
        $data = json_decode($data, JSON_OBJECT_AS_ARRAY);
        $result = [];
        foreach ($data as $item) {
            $result[$item['data']] = floatval($item['cena']);
        }

        return $result;
    }
}