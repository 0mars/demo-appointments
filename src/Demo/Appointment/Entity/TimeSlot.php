<?php
namespace Demo\Appointment\Entity;

use Doctrine\ORM\Mapping as ORM;
use DateTime;

/**
 * @ORM\Table(name="time_slot", uniqueConstraints={@ORM\UniqueConstraint(name="timeslot_start_idx", columns={"start"})})
 * @ORM\Entity
 */
class TimeSlot
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var DateTime
     *
     * @ORM\Column(name="start", type="datetime", nullable=false)
     */
    private $start;

    /**
     * @var int
     */
    private $duration;

    /**
     * @var Appointment
     *
     * @ORM\OneToOne(targetEntity="Demo\Appointment\Entity\Appointment", inversedBy="timeSlot")
     */
    private $appointment;

    public function __construct(DateTime $start, $duration, $appointment = null)
    {
        $this->start = $start;
        $this->duration = $duration;
        $this->appointment = $appointment;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return DateTime
     */
    public function getStart()
    {
        return $this->start;
    }

    /**
     * @return int
     */
    public function getDuration()
    {
        return $this->duration;
    }

    /**
     * @return bool
     */
    public function hasAppointment()
    {
        return $this->appointment !== null;
    }

    /**
     * @return Appointment
     */
    public function getAppointment()
    {
        return $this->appointment;
    }

    /**
     * @param Appointment $appointment
     */
    public function setAppointment(Appointment $appointment)
    {
        $this->appointment = $appointment;
    }
}
