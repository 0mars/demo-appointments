<?php
namespace Demo\Appointment\DomainCommand\Appointment;

use Demo\Appointment\DomainEvent\AppointmentBooked;
use Demo\Appointment\Entity\Appointment;
use Demo\Appointment\Entity\Repository\AppointmentRepository;
use Demo\Appointment\Entity\Repository\TimeSlotRepository;
use Demo\Appointment\Exception\NoTimeSlotAvailableException;
use SimpleBus\Message\Bus\Middleware\MessageBusSupportingMiddleware;

class BookAppointmentHandler
{
    /**
     * @var TimeSlotRepository
     */
    private $timeSlotRepository;

    /**
     * @var AppointmentRepository
     */
    private $appointmentRepository;

    /**
     * @var MessageBusSupportingMiddleware
     */
    private $eventBus;

    /**
     * @param TimeSlotRepository $timeSlotRepository
     * @param AppointmentRepository $appointmentRepository
     * @param MessageBusSupportingMiddleware $eventBus
     */
    public function __construct(
        TimeSlotRepository $timeSlotRepository,
        AppointmentRepository $appointmentRepository,
        MessageBusSupportingMiddleware $eventBus
    ) {
        $this->timeSlotRepository = $timeSlotRepository;
        $this->appointmentRepository = $appointmentRepository;
        $this->eventBus = $eventBus;
    }

    /**
     * @param BookAppointmentCommand $command
     *
     * @throws NoTimeSlotAvailableException
     */
    public function handle(BookAppointmentCommand $command)
    {
        $timeSlot = $this->timeSlotRepository->findAvailableTimeSlotByTime($command->getStartTime());

        if (!$timeSlot || $timeSlot->getAppointment()) {
            throw new NoTimeSlotAvailableException("Time slot not available");
        }

        $appointment = new Appointment($timeSlot);
        $this->appointmentRepository->save($appointment);
        $event = new AppointmentBooked($appointment);
        $this->eventBus->handle($event);
    }
}
