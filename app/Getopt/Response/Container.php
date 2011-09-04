<?php

class Getopt_Response_Container implements Getopt_Response
{
    private $name;
    private $values;

    public function __construct($name)
    {
        $this->name = $name;
        $this->values = array();
    }

    public function getName()
    {
        return $this->name;
    }

    public function getValue()
    {
        $values = array();
        return array(
            $this->getName() => $this->getValues()
        );
    }

    public function addValue(Getopt_Response $value)
    {
        $this->values[] = $value;
        return $this;
    }

    public function removeValue(Getopt_Response $value)
    {
        foreach ($this->values as $currentKey => $currentValue) {
            if ($value === $currentValue) {
                unset($this->values[$currentKey]);
                return true;
            }
        }

        return false;
    }

    protected function getValues()
    {
        if (count($this->values) == 1) {
            return $this->values[0]->getValue();
        }

        $values = array();
        foreach ($this->values as $value) {
            $currentValue = $value->getValue();

            if ($value instanceof Getopt_Response_Container) {
                $valueName = $value->getName();
                $currentValue = array_pop($currentValue);

                if (isset($values[$valueName])) {
                    if (!is_array($values[$valueName])) {
                        $values[$valueName] = array(
                            $values[$valueName],
                        );
                    }

                    $values[$valueName][] = $currentValue;
                    continue;
                }

                $values[$valueName] = $currentValue;
                continue;
            }

            $values[] = $currentValue;
        }

        return $values;
    }
}
