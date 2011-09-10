<?php

class Getopt_Item_Argument_Abstract
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
        $shortIdent = $this->getConfig()->getShortOptionIndicator();
        $shortIdentLen = strlen($shortIdent);
        $longIdent = $this->getConfig()->getLongOptionIndicator();
        $longIdentLen = strlen($longIdent);

        if (
            !$item
            || substr($item, 0, $shortIdentLen) == $shortIdent
            || substr($item, 0, $longIdentLen) == $longIdent
        ) {
            return false;
        }
        return true;
    }

    private function getDefaultConfig()
    {
        return Getopt_Config::getInstance();
    }
}
