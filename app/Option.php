<?php

class Option
{
    const MANDATORY = ':';
    const OPTIONAL = '::';
    const QUOTE = '"';

    public function __construct($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return rtrim($this->name, self::MANDATORY);
    }

    public function isMandatory()
    {
        return (boolean) (
            substr($this->name, -1) == self::MANDATORY
            && !$this->isOptional()
        );
    }

    public function isOptional()
    {
        return (boolean) (substr($this->name, -2) == self::OPTIONAL);
    }

    public function getValue($cmp)
    {
        $pieces = explode('=', $cmp);

        if (!$this->getName() == $pieces[0]) {
            return false;
        }
        if (!$this->isMandatory()) {
            if (!$this->isOptional()) {
                return true;
            }
            $value = $this->getCleanValue($pieces);

            return ($value) ? $value : true;
        }
        return (boolean) $this->getCleanValue($pieces);
    }

    public function __toString()
    {
        return $this->getName();
    }

    protected function getCleanValue($pieces)
    {
        if (count($pieces) != 2) {
            return false;
        }

        return trim($pieces[1], self::QUOTE);
    }
}
