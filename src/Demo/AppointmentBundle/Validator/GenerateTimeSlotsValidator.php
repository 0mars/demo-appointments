<?php
namespace Demo\AppointmentBundle\Validator;

use Demo\Core\Exception\ValidationFailedException;
use Demo\Core\Validator\ValidatorInterface;
use Valitron\Validator;

class GenerateTimeSlotsValidator implements ValidatorInterface
{
    /**
     * {@inheritdoc}
     */
    public function validate(array $data)
    {
        $validator = new Validator($data);
        $validator->addRule('divisibleBy15', function($field, $value, array $params, array $fields) {
            return $value % 15 == 0;
        }, '{field} must be divisible by 15');
        $validator
            ->rule('required', ['start_time', 'end_time', 'interval'])
            ->rule('dateFormat', ['start_time', 'end_time'], 'H:i')
            ->rule('integer', 'interval')
            ->rule('min', 'interval', 15)
            ->rule('divisibleBy15', 'interval')
        ;
        if (!$validator->validate()) {
            throw new ValidationFailedException(implode(', ', current($validator->errors())));
        }
    }
}
