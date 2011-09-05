<?php

class Getopt_Command_Option implements Getopt_Configurable
{
    private $config;

    public function getShortOptions($rawOptions)
    {
        $options = array();
        foreach ($this->getSeparateOptions($rawOptions) as $option) {
            $options[] = new Getopt_Command_Option_Short($option, new Getopt_Command_Argument_None());
        }
        return $options;
    }

    public function getLongOptions($rawOptions)
    {
        $options = array();
        foreach ($rawOptions as $option) {
            $options[] = new Getopt_Command_Option_Long($option, new Getopt_Command_Argument_None());
        }
        return $options;
    }

    public function getSeparateOptions($options)
    {
        $specifier = $this->getConfig()->getArgumentSpecifier();
        preg_match_all(
            sprintf('/\w(%s){0,2}/', $specifier),
            $options,
            $matches
        );

        if ($matches[0]) {
            return $matches[0];
        }

        return array();
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

    protected function getDefaultConfig()
    {
        return Getopt_Config::getInstance();
    }
}
