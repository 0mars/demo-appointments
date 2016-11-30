<?php
namespace Demo\ApiBundle\Response;

class GenericResponse implements \JsonSerializable
{
    /**
     * @var int
     */
    private $code;

    /**
     * @var string
     */
    private $message;

    /**
     * @var mixed:array|Serializable
     */
    private $data;

    /**
     * @param mixed:array\Serializable $data
     * @param int $code
     * @param string $message
     */
    public function __construct($data = null, $code = 200, $message = '')
    {
        $this->message = $message;
        $this->code = $code;
        $this->data = $data;
    }

    /**
     * @return int
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param $data
     *
     * @return GenericResponse
     */
    public function setData($data)
    {
        $this->data = $data;
        return $this;
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        return get_object_vars($this);
    }
}
