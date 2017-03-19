<?php

namespace Tests\Feature;

use GoldPrices\Core\NbpApi\NbpApiResponder;
use Tests\TestCase;

class NbpApiResponderTest extends TestCase
{
    /**
     * Test if the service is making a proper call
     *
     * @return void
     */
    public function testNbpResponderParser()
    {
        $rawJsons = [
            '[
                {
                  "data": "2017-03-10",
                  "cena": 158.51
                },
                {
                  "data": "2017-03-13",
                  "cena": 157.62
                },
                {
                  "data": "2017-03-14",
                  "cena": 157.77
                },
                {
                  "data": "2017-03-15",
                  "cena": 157.62
                },
                {
                  "data": "2017-03-16",
                  "cena": 156.65
                },
                {
                  "data": "2017-03-17",
                  "cena": 159.31
                }
            ]',
            '[
                {
                  "data": "2018-03-15",
                  "cena": 157.82
                },
                {
                  "data": "2018-03-16",
                  "cena": 156.88
                },
                {
                  "data": "2018-03-17",
                  "cena": 160.00
                }
            ]',
        ];

        $expectedResult = [
            '2017-03-10' => 158.51,
            '2017-03-13' => 157.62,
            '2017-03-14' => 157.77,
            '2017-03-15' => 157.62,
            '2017-03-16' => 156.65,
            '2017-03-17' => 159.31,
            '2018-03-15' => 157.82,
            '2018-03-16' => 156.88,
            '2018-03-17' => 160.00,
        ];
        $respoder = new NbpApiResponder($rawJsons);

        $this->assertEquals($expectedResult, $respoder->getGoldPrices());
    }
}
