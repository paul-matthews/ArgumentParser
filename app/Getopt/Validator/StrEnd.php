<?php

class Getopt_Validator_StrEnd
    extends Getopt_Validator_Abstract
    implements Getopt_Validator_Interface
{
    private $end;

    public function __construct($options)
    {
        $this->setOptions($options);
    }

    public function isValid($value)
    {
        if (substr($value, 0 - $this->length) == $this->end) {
            return true;
        }
        return false;
    }

    public function getendString($end)
    {
        return $this->end;
    }

    protected function setOptions($options)
    {
        if (!isset($options['end'])) {
            throw new Exception('Insufficient Parameters');
        }

        $this->end = $options['end'];
        $this->length = strlen($this->end);
    }
}
