<?php

class Getopt_Item_Option
{
    const VALIDATOR     = 'StrStart';

    const TYPE_SHORT    = 0;
    const TYPE_LONG     = 1;

    private $config;

    public function getShortOptions($rawOptions)
    {
        return $this->getOptions(
            Getopt_Filter::filter($rawOptions, 'SeparateShortOptsSpec'),
            self::TYPE_SHORT
        );
    }

    public function getLongOptions($rawOptions)
    {
        return $this->getOptions($rawOptions, self::TYPE_LONG);
    }

    protected function getOptions($rawOptions, $type)
    {
        $options = array();
        foreach ($rawOptions as $option) {
            $options[] = new Getopt_Item_Option_Standard(
                $option, $this->getValidator($type)
            );
        }
        return $options;
    }

    public function getValidator($type)
    {
        $indicator = $this->getConfig()->getLongOptionIndicator();
        if ($type == self::TYPE_SHORT) {
            $indicator = $this->getConfig()->getShortOptionIndicator();
        }

        return Getopt_Validator::getValidator(
            self::VALIDATOR,
            array('start' => $indicator)
        );
    }

    protected function getOptionIndicator($length)
    {
        return implode(array_fill(
            0, $length, $this->getConfig()->getOptionIndicator()
        ));
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
