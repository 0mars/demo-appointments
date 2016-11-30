<?php
namespace Demo\Appointment\Tests\DomainCommand;

use Demo\Appointment\DomainCommand\Appointment\BookAppointmentCommand;
use Demo\Appointment\DomainCommand\Appointment\BookAppointmentHandler;
use Demo\Appointment\Entity\Repository\AppointmentRepository;
use Demo\Appointment\Entity\Repository\TimeSlotRepository;
use Demo\Appointment\Entity\TimeSlot;
use Mockery as m;
use SimpleBus\Message\Bus\Middleware\MessageBusSupportingMiddleware;

class BookAppointmentHandlerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function handle()
    {
        $timeSlot = m::mock(TimeSlot::class)->makePartial();
        $command = new BookAppointmentCommand(new \DateTime());

        $timeSlotRepository = m::mock(TimeSlotRepository::class)->shouldReceive('findAvailableTimeSlotByTime')->with($command->getStartTime())
                         ->andReturn($timeSlot)
                         ->getMock()
        ;
        $appointmentRepository = m::mock(AppointmentRepository::class)->shouldReceive('save')->withAnyArgs()
                         ->andReturnNull()
                         ->getMock()
        ;

        $eventBus = m::mock(MessageBusSupportingMiddleware::class)->shouldReceive('handle')->withAnyArgs()->getMock();

        $handler = new BookAppointmentHandler($timeSlotRepository, $appointmentRepository, $eventBus);
        $handler->handle($command);
    }

    /**
     * @test
     * @expectedException Demo\Appointment\Exception\NoTimeSlotAvailableException
     */
    public function handleNoTimeSlotFound()
    {
        $command = new BookAppointmentCommand(new \DateTime());

        $timeSlotRepository = m::mock(TimeSlotRepository::class)->shouldReceive('findAvailableTimeSlotByTime')->with($command->getStartTime())
                               ->andReturnNull()
                               ->getMock()
        ;
        $appointmentRepository = m::mock(AppointmentRepository::class)->makePartial();
        $eventBus = m::mock(MessageBusSupportingMiddleware::class)->makePartial();

        $handler = new BookAppointmentHandler($timeSlotRepository, $appointmentRepository, $eventBus);
        $handler->handle($command);
    }
}
