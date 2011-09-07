<?php

abstract class Getopt_Validator_Abstract
    implements Getopt_Configurable
{
    private $config;

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

    protected function getDefaultConfig()
    {
        return Getopt_Config::getInstance();
    }
}
