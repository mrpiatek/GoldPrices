<?php


namespace GoldPrices\Core\ExtremesFinder;


class ExtremesFinderResponder
{
    protected $minValue;
    protected $minIndex;
    protected $maxValue;
    protected $maxIndex;

    /**
     * ExtremesFinderResponder constructor.
     * @param $minValue
     * @param $minIndex
     * @param $maxValue
     * @param $maxIndex
     */
    public function __construct($minValue, $minIndex, $maxValue, $maxIndex)
    {
        $this->minValue = $minValue;
        $this->minIndex = $minIndex;
        $this->maxValue = $maxValue;
        $this->maxIndex = $maxIndex;
    }

    /**
     * @return mixed
     */
    public function getMinValue()
    {
        return $this->minValue;
    }

    /**
     * @return mixed
     */
    public function getMinIndex()
    {
        return $this->minIndex;
    }

    /**
     * @return mixed
     */
    public function getMaxValue()
    {
        return $this->maxValue;
    }

    /**
     * @return mixed
     */
    public function getMaxIndex()
    {
        return $this->maxIndex;
    }
}