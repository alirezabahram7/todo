<?php

namespace Exceptions;

use Exception;
use Http\Resources\BasicResource;
use function response;

class CustomException extends Exception
{
    private $_options;
    private $_next;

    public function __construct(
        $message,
        $code = 0,
        Exception $previous = null,
        $options = array('params'),
        $next = null
    ) {
        parent::__construct($message, $code, $previous);

        $this->_options = $options;
        $this->_next = $next;
    }

    public function getOptions()
    {
        return $this->_options;
    }

    public function getNext()
    {
        return $this->_next;
    }

    public function render($request)
    {
        return response(
            new BasicResource(
                [
                    'error_message' => $this->getMessage(),
                    'errors' => $this->getOptions(),
                    'next' => $this->getNext()
                ]
            ),
            $this->getCode()
        );
    }

}
