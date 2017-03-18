<?php


namespace GoldPrices\Core\ExtremesFinder;


class ExtremesFinderService
{
    /**
     * Finds minimum and maximum value in a given data set and returns those values along with their indices
     * @param ExtremesFinderRequestor $requestor
     * @return ExtremesFinderResponder
     */
    public function findExtremes(ExtremesFinderRequestor $requestor)
    {
        // find both values on one scan
        $minValue = null;
        $minIndex = null;

        $maxValue = null;
        $maxIndex = null;

        foreach ($requestor->getData() as $index => $value) {
            if ($minValue === null || $value < $minValue) {
                $minValue = $value;
                $minIndex = $index;
            }

            if ($maxValue === null || $value > $maxValue) {
                $maxValue = $value;
                $maxIndex = $index;
            }
        }

        return new ExtremesFinderResponder($minValue, $minIndex, $maxValue, $maxIndex);
    }
}