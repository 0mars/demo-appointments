<?php
namespace Demo\Appointment\Entity\Repository;

use Demo\Appointment\Entity\Appointment;
use Demo\Core\Entity\Repository\AbstractDoctrineRepository;

class AppointmentRepository extends AbstractDoctrineRepository
{
    /**
     * @param Appointment $appointment
     */
    public function save(Appointment $appointment)
    {
        $this->objectManager->persist($appointment);
        $this->objectManager->flush();
    }
}
