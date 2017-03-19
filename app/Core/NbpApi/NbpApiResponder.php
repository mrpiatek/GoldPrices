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
        $result = [];
        foreach ($data as $item) {
            $item = json_decode($item, JSON_OBJECT_AS_ARRAY);
            foreach ($item as $goldPrice) {
                $result[$goldPrice['data']] = floatval($goldPrice['cena']);
            }
        }

        return $result;
    }
}