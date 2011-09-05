<?php

class Getopt_Config
{
    const DEFAULT_OPTION_INDICATOR = '-';
    const DEFAULT_ARGUMENT_SPECIFIER = ':';
    const DEFAULT_SEPARATOR_1  = '=';
    const DEFAULT_SEPARATOR_2  = ' ';

    public static $instance;

    private $optionIndicator;
    private $argumentSpecifier;

    public function __construct()
    {
        $this->setOptionIndicator(self::DEFAULT_OPTION_INDICATOR);
        $this->setArgumentSpecifier(self::DEFAULT_ARGUMENT_SPECIFIER);
        $this->setOptionValueSeparators(
            array(
                self::DEFAULT_SEPARATOR_1,
                self::DEFAULT_SEPARATOR_2,
            )
        );
    }

    public function setOptionIndicator($indicator)
    {
        $this->optionIndicator = $indicator;
    }

    public function getOptionIndicator()
    {
        return $this->optionIndicator;
    }

    public function setArgumentSpecifier($specifier)
    {
        $this->argumentSpecifier = $specifier;
    }

    public function getArgumentSpecifier()
    {
        return $this->argumentSpecifier;
    }

    public function setOptionValueSeparators(array $optValSeparators)
    {
        $this->optValSeparator = $optValSeparators;
    }

    public function getOptionValueSeparator()
    {
        return $this->optValSeparator;
    }

    public static function setInstance(Getopt_Config $config)
    {
        self::$instance = $config;
    }

    public static function resetInstance()
    {
        self::setInstance(new self());
    }

    public static function getInstance()
    {
        if (is_null(self::$instance)) {
            self::resetInstance();
        }
        return self::$instance;
    }
}
