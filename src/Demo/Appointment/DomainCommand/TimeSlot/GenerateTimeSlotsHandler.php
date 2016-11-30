<?php
namespace Demo\Appointment\DomainCommand\TimeSlot;

use Demo\Appointment\Entity\Repository\TimeSlotRepository;
use Demo\Appointment\Service\TimeSlotGenerator;

class GenerateTimeSlotsHandler
{
    /**
     * @var TimeSlotRepository
     */
    private $timeSlotRepository;

    /**
     * @var TimeSlotGenerator
     */
    private $timeSlotGenerator;

    /**
     * @param TimeSlotRepository $timeSlotRepository
     * @param TimeSlotGenerator $timeSlotGenerator
     */
    public function __construct(TimeSlotRepository $timeSlotRepository, TimeSlotGenerator $timeSlotGenerator)
    {
        $this->timeSlotRepository = $timeSlotRepository;
        $this->timeSlotGenerator = $timeSlotGenerator;
    }

    /**
     * @param GenerateTimeSlotsCommand $command
     */
    public function handle(GenerateTimeSlotsCommand $command)
    {
        $timeSlots = $this->timeSlotGenerator->generate($command->getStart(), $command->getEnd(), $command->getInterval());
        $this->timeSlotRepository->batchSave($timeSlots);
    }
}
