<?php
namespace Demo\Core\Validator;

use Demo\Core\Exception\ValidationFailedException;

interface ValidatorInterface
{
    /**
     * @param array $data
     *
     * @throws ValidationFailedException
     */
    public function validate(array $data);
}
