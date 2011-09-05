<?php

class Getopt_Command_Argument_Abstract
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

    protected function isValue($item)
    {
        $identifier = $this->getConfig()->getOptionIndicator();

        if ($item && substr($item, 0, strlen($identifier)) != $identifier) {
            return true;
        }
        return false;
    }

    private function getDefaultConfig()
    {
        return Getopt_Config::getInstance();
    }
}
