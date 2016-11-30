<?php
namespace Demo\AppointmentBundle\Controller;

use FOS\RestBundle\Util\Codes;
use Demo\ApiBundle\Controller\AbstractRestController;
use Demo\ApiBundle\Response\GenericResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Demo\Appointment\DomainCommand\Appointment\BookAppointmentCommand;
use Symfony\Component\HttpFoundation\JsonResponse;

class AppointmentsController extends AbstractRestController
{
    /**
     * @ParamConverter("command", converter="book_appointment_converter")
     *
     * @param BookAppointmentCommand $command
     *
     * @return GenericResponse
     */
    public function postAction(BookAppointmentCommand $command)
    {
        $this->execCommand($command);
        return new JsonResponse(new GenericResponse(null, Codes::HTTP_CREATED, "Created"), Codes::HTTP_CREATED);
    }
}
