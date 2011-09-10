<?php

class Getopt_Command_Argument
{
    private $config;

    public function getArgument($rawOption)
    {
        $optional = $this->getOptional();
        $mandatory = $this->getMandatory();

        if (substr($rawOption, 0 - strlen($optional)) == $optional) {
            return new Getopt_Command_Argument_Optional();
        }

        if (substr($rawOption, 0 - strlen($mandatory)) == $mandatory) {
            return new Getopt_Command_Argument_Mandatory();
        }

        return new Getopt_Command_Argument_None();
    }

    public function getOptional()
    {
        return str_pad('', 2, $this->getConfig()->getArgumentSpecifier());
    }

    public function getMandatory()
    {
        return $this->getConfig()->getArgumentSpecifier();
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
}
