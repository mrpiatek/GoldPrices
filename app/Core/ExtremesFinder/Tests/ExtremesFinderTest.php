<?php

namespace GoldPrices\Core\ExtremesFinder\Tests;

use GoldPrices\Core\ExtremesFinder\ExtremesFinderRequestor;
use GoldPrices\Core\ExtremesFinder\ExtremesFinderResponder;
use GoldPrices\Core\ExtremesFinder\ExtremesFinderService;
use Tests\TestCase;

class ExtremesFinderTest extends TestCase
{
    /**
     * Test if the service is returning proper min and max indices and values
     *
     * @return void
     */
    public function testExtremesFinder()
    {
        $data = [
            'plankton' => -1,
            'dog' => 1,
            'cat' => 9,
            'fish' => 8,
            'bear' => 2,
            'tiger' => 7,
            'hawk' => 3,
            'shark' => 999,
        ];


        $finder = new ExtremesFinderService();

        /** @var ExtremesFinderResponder $responder */
        $responder = $finder->findExtremes(
            new ExtremesFinderRequestor($data)
        );

        $this->assertEquals('shark', $responder->getMaxIndex());
        $this->assertEquals(999, $responder->getMaxValue());

        $this->assertEquals('plankton', $responder->getMinIndex());
        $this->assertEquals(999, $responder->getMaxValue());
    }
}
