<?php

abstract class Getopt_Filter_Abstract
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

    private function getDefaultConfig()
    {
        return Getopt_Config::getInstance();
    }
}
