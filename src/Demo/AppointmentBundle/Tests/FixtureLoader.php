<?php
namespace Demo\AppointmentBundle\Tests;

trait FixtureLoader
{
    /**
     * @param string $filename
     * @return string
     */
    public function loadFixture($filename)
    {
        $fullFilename = realpath(__DIR__) . '/fixtures/' . $filename;
        return file_get_contents($fullFilename);
    }
}
