<?php
namespace Demo\Appointment\Service;

use DateTime;
use DateInterval;
use InvalidArgumentException;
use Doctrine\Common\Collections\ArrayCollection;
use Demo\Appointment\Entity\TimeSlot;

class TimeSlotGenerator
{
    /**
     * @param DateTime $startTime
     * @param DateTime $endTime
     * @param int $interval
     *
     * @return TimeSlot[]
     *
     * @throws InvalidArgumentException
     */
    public function generate(DateTime $startTime, DateTime $endTime, $interval)
    {
        $current = clone $startTime;
        $end = clone $endTime;

        $this->validate($current, $end, $interval);

        $current->setTime($current->format('H'), $this->getNormalizedMinutes($current), 0);
        $end->setTime($end->format('H'), $this->getNormalizedMinutes($end), 0);

        $timeSlots = new ArrayCollection();
        $dateInterval = new DateInterval(sprintf('PT%dM', $interval));
        while ($current < $end) {
            $timeSlot = new TimeSlot(clone $current, $interval);
            $timeSlots->add($timeSlot);
            $current->add($dateInterval);
        }
        return $timeSlots;
    }

    /**
     * @param DateTime $time
     *
     * @return int
     */
    private function getNormalizedMinutes(DateTime $time)
    {
        $minutes = (int)$time->format('i');
        return round($minutes/15, 0, PHP_ROUND_HALF_UP) * 15;
    }

    /**
     * @param DateTime $start
     * @param DateTime $end
     * @param int $interval
     *
     * @throws InvalidArgumentException
     */
    private function validate(DateTime $start, DateTime $end, $interval)
    {
        if ($start >= $end) {
            throw new InvalidArgumentException("start time should be less than end time");
        }

        if ($interval < 1) {
            throw new InvalidArgumentException("interval cannot be 0");
        }

        if ($interval % 15 != 0) {
            throw new InvalidArgumentException("interval must be at least 15 minutes or multiples of it");
        }
    }
}
