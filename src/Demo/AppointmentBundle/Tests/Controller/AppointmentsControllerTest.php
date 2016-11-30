<?php
namespace Demo\AppointmentBundle\Tests\Controller;

use Demo\Appointment\Entity\Repository\AppointmentRepository;
use Demo\Appointment\Entity\Repository\TimeSlotRepository;
use Demo\Appointment\Entity\TimeSlot;
use Demo\AppointmentBundle\Tests\FixtureLoader;
use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Mockery as m;

class AppointmentsControllerTest extends WebTestCase
{
    use FixtureLoader;

    /**
     * @var Client
     */
    private $client;

    public function setUp()
    {
        parent::setUp();
        $this->client = static::createClient();
    }

    /**
     * @test
     */
    public function postAction()
    {
        $timeSlotRepository = m::mock(TimeSlotRepository::class)
            ->shouldReceive('findAvailableTimeSlotByTime')->withAnyArgs()->andReturn(new TimeSlot(new \DateTime(), 15))->getMock();

        $this->client->getContainer()
            ->set('demo.appointment.repository.time_slot', $timeSlotRepository);

        $appointmentRepository = m::mock(AppointmentRepository::class)->shouldReceive('save')->withAnyArgs()
            ->andReturnNull()->getMock();

        $this->client->getContainer()
                     ->set('demo.appointment.repository.appointment', $appointmentRepository);

        $body = $this->loadFixture('book_appointment_request.json');
        $this->client->request('POST', '/api/v1/appointments', [], [], [], $body);
        $expected = $this->loadFixture('book_appointment_response.json');
        $this->assertEquals(json_decode($expected), json_decode($this->client->getResponse()->getContent()));
    }
}
