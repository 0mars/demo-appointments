<?php
namespace Demo\Appointment\DomainCommand\Appointment;

use DateTime;

class BookAppointmentCommand
{
    /**
     * @var DateTime
     */
    private $startTime;

    /**
     * @param DateTime $startTime
     */
    public function __construct(DateTime $startTime)
    {
        $this->startTime = $startTime;
    }

    /**
     * @return DateTime
     */
    public function getStartTime()
    {
        return $this->startTime;
    }
}
