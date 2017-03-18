<?php


namespace GoldPrices\Core\GoldPricesFetching;


class GoldPricesFetchingRequestor
{
    /** @var  \DateTimeInterface */
    protected $startDate;
    /** @var  \DateTimeInterface */
    protected $endDate;

    /**
     * DataFetchingRequestor constructor.
     * @param \DateTimeInterface $startDate
     * @param \DateTimeInterface $endDate
     */
    public function __construct(\DateTimeInterface $startDate, \DateTimeInterface $endDate)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    /**
     * @return \DateTimeInterface
     */
    public function getStartDate(): \DateTimeInterface
    {
        return $this->startDate;
    }

    /**
     * @return \DateTimeInterface
     */
    public function getEndDate(): \DateTimeInterface
    {
        return $this->endDate;
    }
}