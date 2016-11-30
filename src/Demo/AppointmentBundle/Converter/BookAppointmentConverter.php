<?php
namespace Demo\AppointmentBundle\Converter;

use Demo\ApiBundle\Request\Exception\MandatoryParameterMissingException;
use Demo\Appointment\DomainCommand\Appointment\BookAppointmentCommand;
use Demo\Core\Exception\ValidationFailedException;
use Demo\Core\Validator\ValidatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Symfony\Component\HttpFoundation\Request;

class BookAppointmentConverter implements ParamConverterInterface
{
    /**
     * @var ValidatorInterface
     */
    private $validator;

    /**
     * @param ValidatorInterface $validator
     */
    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    /**
     * @param Request $request
     * @param ParamConverter $configuration
     *
     * @return bool
     *
     * @throws ValidationFailedException
     */
    public function apply(Request $request, ParamConverter $configuration)
    {
        $body = json_decode($request->getContent(), true) ?: [];

        $this->validator->validate($body);

        $object = new BookAppointmentCommand(
            new \DateTime($body['start_time'])
        );
        $request->attributes->set($configuration->getName(), $object);
        return true;
    }

    /**
     * Checks if the object is supported.
     *
     * @param ParamConverter $configuration Should be an instance of ParamConverter
     *
     * @return bool True if the object is supported, else false
     */
    public function supports(ParamConverter $configuration)
    {
        return $configuration->getClass() === BookAppointmentCommand::class;
    }
}
