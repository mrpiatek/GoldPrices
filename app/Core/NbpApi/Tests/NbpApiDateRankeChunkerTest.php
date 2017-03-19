<?php

namespace Tests\Feature;

use GoldPrices\Core\NbpApi\NbpApiDateRangeChunker;
use Tests\TestCase;

class NbpApiDateRankeChunkerTest extends TestCase
{
    /**
     * Test if the date range chunker is splitting date range properly
     *
     * @return void
     */
    public function testDateIntegrity()
    {
        $chunker = new NbpApiDateRangeChunker();

        $chunks = $chunker->chunk(new \DateTime('2007-03-18'), new \DateTime('2017-03-18'));
        $this->assertCount(10, $chunks);

        $chunks = $chunker->chunk(new \DateTime('2007-03-18'), new \DateTime('2017-03-19'));
        $this->assertCount(11, $chunks);

        for ($i = 0, $chunkCount = count($chunks); $i < $chunkCount; $i++) {
            $this->assertTrue($chunks[$i]['from'] < $chunks[$i]['to']);

            //each date range except last one should be exaclty one year long
            if ($i != $chunkCount - 1) {
                $this->assertEquals(1, $chunks[$i]['from']->diff($chunks[$i]['to'])->y);
            }
        }
    }
}
