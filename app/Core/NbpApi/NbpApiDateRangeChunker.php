<?php


namespace GoldPrices\Core\NbpApi;

/**
 * Allows to chunk big date ranges into smaller date ranges, each with max one year time span
 * @package GoldPrices\Core\NbpApi
 */
class NbpApiDateRangeChunker
{
    /**
     * @param \DateTime $startDate
     * @param \DateTime $endDate
     * @return array
     */
    public function chunk(\DateTime $startDate, \DateTime $endDate)
    {
        $chunks = [];
        $currentDate = clone $startDate;
        $yearsDiff = $startDate->diff($endDate)->y;

        // fix an edge case with date range that is exactly one year time span
        if ($startDate->format('m-d') == $endDate->format('m-d')) {
            $yearsDiff--;
        }

        for ($i = 0; $i <= $yearsDiff; $i++) {
            $chunks[] = [
                'from' => clone $currentDate,
                'to' => min(clone $currentDate->modify('+1 year'), $endDate),
            ];
        }

        return $chunks;
    }
}