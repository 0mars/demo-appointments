<?php
namespace Demo\Appointment\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="appointment")
 * @ORM\Entity
 */
class Appointment
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
     * @ORM\OneToOne(targetEntity="Demo\Appointment\Entity\TimeSlot", mappedBy="appointment")
     * @var TimeSlot
     */
    private $timeSlot;

    /**
     * @param TimeSlot $timeSlot
     */
    public function __construct(TimeSlot $timeSlot)
    {
        $timeSlot->setAppointment($this);
        $this->timeSlot = $timeSlot;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return TimeSlot
     */
    public function getTimeSlot()
    {
        return $this->timeSlot;
    }
}
