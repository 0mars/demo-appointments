<?php
namespace Demo\AppointmentBundle\Tests\Controller;

use Demo\Appointment\Entity\Repository\TimeSlotRepository;
use Demo\AppointmentBundle\Tests\FixtureLoader;
use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Mockery as m;

class TimeSlotsControllerTest extends WebTestCase
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
    public function patchGenerate()
    {
        $this->client->getContainer()->set('demo.appointment.repository.time_slot', $this->getRepositoryMock());

        $body = $this->loadFixture('generate_request.json');
        $this->client->request('PATCH', '/api/v1/time-slots/generate', [], [], [], $body);
        $this->assertEquals(
            json_decode($this->loadFixture('generate_response.json')),
            json_decode($this->client->getResponse()->getContent())
        );
    }

    /**
     * @test
     */
    public function patchGenerateMissingParameter()
    {
        $body = '{}';
        $this->client->request('PATCH', '/api/v1/time-slots/generate', [], [], [], $body);
        $this->assertEquals(400, json_decode($this->client->getResponse()->getContent())->code);
    }

    private function getRepositoryMock()
    {
        return m::mock(TimeSlotRepository::class)->shouldReceive('batchSave')->withAnyArgs()->andReturnNull()->getMock();
    }
}
