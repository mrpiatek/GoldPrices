<?php


namespace GoldPrices\Core\ExtremesFinder;


class ExtremesFinderRequestor
{
    protected $data;

    /**
     * ExtremesFinderRequestor constructor.
     * @param $data
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }
}