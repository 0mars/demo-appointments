<?php
namespace Demo\AppointmentBundle\Controller;

use FOS\RestBundle\Util\Codes;
use Demo\ApiBundle\Controller\AbstractRestController;
use Demo\ApiBundle\Response\GenericResponse;
use Demo\Appointment\DomainCommand\TimeSlot\GenerateTimeSlotsCommand;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class TimeSlotsController extends AbstractRestController
{
    /**
     * @ParamConverter("command", converter="generate_time_slots_converter")
     *
     * @param GenerateTimeSlotsCommand $command
     *
     * @return GenericResponse
     */
    public function generateAction(GenerateTimeSlotsCommand $command)
    {
        $this->execCommand($command);
        return new GenericResponse(null, Codes::HTTP_OK, "OK");
    }
}
