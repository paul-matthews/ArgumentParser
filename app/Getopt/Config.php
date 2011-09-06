<?php

class Getopt_Config
{
    const INDICATOR_HYPHEN  = '-';
    const INDICATOR_SLASH   = '/';

    const SPECIFIER_COLON = ':';

    const SEPARATOR_EQUALS  = '=';
    const SEPARATOR_SPACE  = ' ';

    public static $instance;

    private $shortOptionIndicator;
    private $longOptionIndicator;
    private $argumentSpecifier;

    public function __construct()
    {
        $this->setShortOptionIndicator(self::INDICATOR_HYPHEN);
        $this->setLongOptionIndicator(str_pad('', 2, self::INDICATOR_HYPHEN));
        $this->setArgumentSpecifier(self::SPECIFIER_COLON);
        $this->setOptionValueSeparators(
            array(
                self::SEPARATOR_EQUALS,
                self::SEPARATOR_SPACE,
            )
        );
    }

    public function setShortOptionIndicator($indicator)
    {
        $this->shortOptionIndicator = $indicator;
    }

    public function getShortOptionIndicator()
    {
        return $this->shortOptionIndicator;
    }

    public function setLongOptionIndicator($indicator)
    {
        $this->longOptionIndicator = $indicator;
    }

    public function getLongOptionIndicator()
    {
        return $this->longOptionIndicator;
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
