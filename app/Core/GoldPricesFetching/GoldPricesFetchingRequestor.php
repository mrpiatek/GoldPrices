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
     * @param \DateTime $startDate
     * @param \DateTime $endDate
     */
    public function __construct(\DateTime $startDate, \DateTime $endDate)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    /**
     * @return \DateTime
     */
    public function getStartDate(): \DateTime
    {
        return $this->startDate;
    }

    /**
     * @return \DateTime
     */
    public function getEndDate(): \DateTime
    {
        return $this->endDate;
    }
}