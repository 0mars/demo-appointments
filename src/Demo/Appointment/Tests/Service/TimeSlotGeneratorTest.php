<?php
namespace Demo\Appointment\Tests\Service;

use DateTime;
use DateInterval;
use Demo\Appointment\Service\TimeSlotGenerator;

class TimeSlotGeneratorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var TimeSlotGenerator
     */
    private $generator;

    public function setUp()
    {
        $this->generator = new TimeSlotGenerator();
    }

    /**
     * @test
     * @expectedException \InvalidArgumentException
     */
    public function generateInvalidStartEnd()
    {
        $start = new DateTime();
        $end = new DateTime('-1 hour');
        $this->generator->generate($start, $end, 60);
    }

    /**
     * @test
     * @expectedException \InvalidArgumentException
     */
    public function generateInvalidInterval()
    {
        $start = new DateTime();
        $end = new DateTime('1 hour');
        $this->generator->generate($start, $end, 0);
    }

    /**
     * @test
     * @expectedException \InvalidArgumentException
     */
    public function generateInvalidIntervalNotQuarterHour()
    {
        $start = new DateTime();
        $end = new DateTime('1 hour');
        $this->generator->generate($start, $end, 18);
    }

    /**
     * @test
     */
    public function generate()
    {
        $start = new DateTime('@' . mktime(8, 0, 0));
        $end = clone $start;
        $end->add(new DateInterval('PT3H'));
        $timeSlots = $this->generator->generate($start, $end, 60);
        $this->assertCount(3, $timeSlots);
    }

    /**
     * @test
     */
    public function generateNormalization()
    {
        $start = new DateTime('@' . mktime(8, 12, 0));
        $end = clone $start;
        $end->add(new DateInterval('PT3H'));
        $timeSlots = $this->generator->generate($start, $end, 15);
        $this->assertCount(12, $timeSlots);
    }

    /**
     * @test
     */
    public function generateNormalizationEnd()
    {
        $start = new DateTime('@' . mktime(8, 12, 0));
        $end = clone $start;
        $end->add(new DateInterval('PT3H15M'));
        $timeSlots = $this->generator->generate($start, $end, 15);
        $this->assertCount(13, $timeSlots);
    }
}
