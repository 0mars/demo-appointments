<?php
namespace Demo\Appointment\Entity\Repository;

use DateTime;
use Demo\Appointment\Exception\TimeSlotConflictException;
use Doctrine\Common\Collections\Collection;
use Demo\Appointment\Entity\TimeSlot;
use Demo\Core\Entity\Repository\AbstractDoctrineRepository;

class TimeSlotRepository extends AbstractDoctrineRepository
{
    /**
     * @param Collection $timeSlots
     *
     * @throws TimeSlotConflictException
     */
    public function batchSave(Collection $timeSlots)
    {
        foreach ($timeSlots as $timeSlot)
        {
            /* @var $timeSlot TimeSlot */
            if ($this->findAvailableTimeSlotByTime($timeSlot->getStart())) {
                throw new TimeSlotConflictException(
                    sprintf("TimeSlot(%s) already exists", $timeSlot->getStart()->format('H:i'))
                );
            }
            $this->objectManager->persist($timeSlot);
        }
        $this->objectManager->flush();
    }

    /**
     * @param DateTime $startTime
     * @return mixed:null|TimeSlot
     */
    public function findAvailableTimeSlotByTime(DateTime $startTime)
    {
        $query = $this->objectManager->createQueryBuilder()
            ->select('ts')
            ->from(TimeSlot::class, 'ts')
            ->where('ts.start=:start_time')
            ->setParameter('start_time', $startTime)
            ->getQuery();

        return $query->getOneOrNullResult();
    }
}
