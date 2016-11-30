<?php
namespace Demo\AppointmentBundle\Converter;

use Demo\Appointment\DomainCommand\TimeSlot\GenerateTimeSlotsCommand;
use Demo\Core\Exception\ValidationFailedException;
use Demo\Core\Validator\ValidatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Symfony\Component\HttpFoundation\Request;

class GenerateTimeSlotsConverter implements ParamConverterInterface
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
     * Stores the object in the request.
     *
     * @param Request $request The request
     * @param ParamConverter $configuration Contains the name, class and options of the object
     *
     * @return bool True if the object has been successfully set, else false
     *
     * @throws ValidationFailedException
     */
    public function apply(Request $request, ParamConverter $configuration)
    {
        $body = json_decode($request->getContent(), true) ?: [];

        $this->validator->validate($body);

        $object = new GenerateTimeSlotsCommand(
            new \DateTime($body['start_time']),
            new \DateTime($body['end_time']),
            $body['interval']
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
        return $configuration->getClass() === GenerateTimeSlotsCommand::class;
    }
}
