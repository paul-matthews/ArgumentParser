<?php

class Getopt_Response
    implements Iterator
{
    private $name;
    private $value;
    private $attributes;
    private $children;

    public function __construct($name, $value = null)
    {
        $this->name = $name;
        $this->value = $value;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function add($response)
    {
        if ($response instanceof Getopt_Response_Attribute)
        {
            $this->addAttribute($response);
        }
        if ($response instanceof Getopt_Response) {
            $this->addChild($response);
        }
        throw new InvalidArgumentException('Unkown response type');
    }

    public function addAttribute(Getopt_Response_Attribute $attribute)
    {
        $name = $attribute->getName();
        if (isset($this->attrbutes[$name])) {
            $this->attrbutes[$name] = array (
                $this->attrbutes[$name],
                $attribute,
            );
            return $this;
        }

        $this->attrbutes[$name] = $attribute;
        return $this;
    }

    public function getAttribute($name)
    {
        if (isset($this->attrbutes[$name])) {
            return $this->attrbutes[$name];
        }
        return null;
    }

    public function addChild(Getopt_Response $response)
    {
        $this->children[] = $response;
    }

    public function getChildren()
    {
        return $this->children;
    }

    public function rewind()
    {
        return reset($this->children);
    }

    public function next()
    {
        return next($this->children);
    }

    public function current()
    {
        return current($this->children);
    }

    public function key()
    {
        return key($this->children);
    }

    public function valid()
    {
        if ($this->current() !== false) {
            return true;
        }
        return false;
    }
}
