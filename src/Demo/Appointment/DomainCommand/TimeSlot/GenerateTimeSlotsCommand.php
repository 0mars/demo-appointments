<?php
namespace Demo\Appointment\DomainCommand\TimeSlot;

use DateTime;

class GenerateTimeSlotsCommand
{
    /**
     * @var DateTime
     */
    private $start;

    /**
     * @var DateTime
     */
    private $end;

    /**
     * @var int
     */
    private $interval;

    /**
     * @param DateTime $start
     * @param DateTime $end
     * @param int $interval
     */
    public function __construct(DateTime $start, DateTime $end, $interval)
    {
        $this->start = $start;
        $this->end = $end;
        $this->interval = $interval;
    }

    /**
     * @return DateTime
     */
    public function getStart()
    {
        return $this->start;
    }

    /**
     * @return DateTime
     */
    public function getEnd()
    {
        return $this->end;
    }

    /**
     * @return int
     */
    public function getInterval()
    {
        return $this->interval;
    }
}
