<?php
namespace Demo\Appointment\DomainEvent;

use Demo\Appointment\Entity\Appointment;

class AppointmentBooked
{
    /**
     * @var Appointment
     */
    private $appointment;

    /**
     * @param Appointment $appointment
     */
    public function __construct(Appointment $appointment)
    {
        $this->appointment = $appointment;
    }

    /**
     * @return Appointment
     */
    public function getAppointment()
    {
        return $this->appointment;
    }
}
