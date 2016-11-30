<?php
namespace Demo\Appointment\Tests\DomainCommand;

use Doctrine\Common\Collections\ArrayCollection;
use Demo\Appointment\DomainCommand\TimeSlot\GenerateTimeSlotsCommand;
use Demo\Appointment\DomainCommand\TimeSlot\GenerateTimeSlotsHandler;
use Demo\Appointment\Entity\Repository\TimeSlotRepository;
use Demo\Appointment\Entity\TimeSlot;
use Demo\Appointment\Service\TimeSlotGenerator;
use Mockery as m;

class GenerateTimeSlotsHandlerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function handle()
    {
        $timeSlots = new ArrayCollection();
        $command = new GenerateTimeSlotsCommand(new \DateTime(), new \DateTime('3 hours'), 30);
        $timeSlots->add(new TimeSlot($command->getStart(), $command->getInterval()));
        $timeSlotsGenerator = m::mock(TimeSlotGenerator::class)->shouldReceive('generate')->with(
            $command->getStart(),
            $command->getEnd(),
            $command->getInterval()
        )->andReturn($timeSlots)->getMock();

        $timeSlotRepo = m::mock(TimeSlotRepository::class)->shouldReceive('batchSave')->with($timeSlots)
            ->andReturn(null)
            ->getMock();

        $handler = new GenerateTimeSlotsHandler($timeSlotRepo, $timeSlotsGenerator);

        $handler->handle($command);
    }
}
