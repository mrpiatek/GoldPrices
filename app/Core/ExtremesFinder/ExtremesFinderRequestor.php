<?php


namespace GoldPrices\Core\ExtremesFinder;


class ExtremesFinderRequestor
{
    protected $data;

    /**
     * ExtremesFinderRequestor constructor.
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * @return mixed
     */
    public function getData(): array
    {
        return $this->data;
    }
}