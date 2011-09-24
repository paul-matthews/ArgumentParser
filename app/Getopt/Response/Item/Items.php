<?php

class Getopt_Response_Item_Items
    extends Getopt_Response_Item
{
    public function __construct()
    {
        parent::__construct(array());
    }

    public function addValue(Getopt_Response_Item $value, $key = null)
    {
        if (empty($key)) {
            $this->value[] = $value;
            return $this;
        }

        if (!isset($this->value[$key])) {
            $this->value[$key] = $value;
            return $this;
        }

        if (!($this->value[$key] instanceof self)) {
            $oldValue = $this->value[$key];
            $this->value[$key] = new self();
            $this->value[$key]->addValue($oldValue);
        }

        $this->value[$key]->addValue($value);
        return $this;
    }

    public function toArray()
    {
        $return = array();
        foreach ($this->getValue() as $key => $value) {
            $return[$key] = $this->getItemValue($value);
        }
        return $return;
    }

    protected function getItemValue(Getopt_Response_Item $item)
    {
        if ($item instanceof self) {
            return $item->toArray();
        }

        return $item->getValue();
    }
}
