<?php

class Getopt_Validator_StrStart
    extends Getopt_Validator_Abstract
    implements Getopt_Validator_Interface
{
    private $start;

    public function __construct($options)
    {
        $this->setOptions($options);
    }

    public function isValid($value)
    {
        if (substr($value, 0, $this->length) == $this->start) {
            return true;
        }
        return false;
    }

    public function getStartString($start)
    {
        return $this->start;
    }

    protected function setOptions($options)
    {
        if (!isset($options['start'])) {
            throw new Exception('Insufficient Parameters');
        }

        $this->start = $options['start'];
        $this->length = strlen($this->start);
    }
}
