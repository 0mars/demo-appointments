<?php
namespace Demo\AppointmentBundle\Validator;

use DateTime;
use Demo\Core\Exception\ValidationFailedException;
use Demo\Core\Validator\ValidatorInterface;
use Valitron\Validator;

class BookAppointmentValidator implements ValidatorInterface
{
    /**
     * {@inheritdoc}
     */
    public function validate(array $data)
    {
        $validator = new Validator($data);

        $validator->addRule('dateTimeInTheFuture', function($field, $value, array $params, array $fields) {
            return new DateTime($value) > new DateTime();
        }, 'must be after now');

        $validator
            ->rule('required', 'start_time')
            ->rule('dateFormat', 'start_time', DateTime::ISO8601)
            ->rule('dateTimeInTheFuture', 'start_time')
        ;
        if (!$validator->validate()) {
            throw new ValidationFailedException(implode(', ', current($validator->errors())));
        }
    }
}
