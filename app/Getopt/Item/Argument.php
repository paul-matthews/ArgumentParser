<?php

class Getopt_Item_Argument
{
    const VALIDATOR         = 'StrEnd';

    const TYPE_NONE         = 0;
    const TYPE_MANDATORY    = 1;
    const TYPE_OPTIONAL     = 2;

    const MANDATORY_LENGTH  = 1;
    const OPTIONAL_LENGTH   = 2;

    private $config;

    public function getArgument($rawOption)
    {
        $argument = null;
        switch ($this->getType($rawOption)) {
            case self::TYPE_OPTIONAL:
                $argument =  new Getopt_Item_Argument_Optional();
                break;
            case self::TYPE_MANDATORY:
                $argument =  new Getopt_Item_Argument_Mandatory();
                break;
            case self::TYPE_NONE:
            default:
                $argument = new Getopt_Item_Argument_None();
                break;
        }
        return $argument;
    }

    public function setConfig(Getopt_Config $config)
    {
        $this->config = $config;
    }

    public function getConfig()
    {
        if (is_null($this->config)) {
            $this->setConfig($this->getDefaultConfig());
        }
        return $this->config;
    }

    private function getDefaultConfig()
    {
        return Getopt_Config::getInstance();
    }

    protected function getType($rawOption)
    {
        foreach ($this->getValidators() as $type => $validator) {
            if ($validator->isValid($rawOption)) {
                return $type;
            }
        }

        return self::TYPE_NONE;
    }

    protected function getValidators()
    {
        $validators = array();
        $specifiers = array(
            self::TYPE_OPTIONAL => $this->getArgumentSpecifier(
                self::OPTIONAL_LENGTH
            ),
            self::TYPE_MANDATORY => $this->getArgumentSpecifier(
                self::MANDATORY_LENGTH
            ),
        );

        foreach ($specifiers as $type => $end) {
            $validators[$type] = $this->getValidator(
                self::VALIDATOR,
                array('end' => $end)
            );
        }

        return $validators;
    }

    protected function getValidator($validator, $properties)
    {
        return Getopt_Validator::getValidator($validator, $properties);
    }

    protected function getArgumentSpecifier($length)
    {
        return implode(array_fill(
            0, $length, $this->getConfig()->getArgumentSpecifier()
        ));
    }
}
