<?php

class Getopt_Response_Spec_Command
    implements Getopt_Response_Spec
{
    protected $name;
    protected $children;

    public function __construct($name)
    {
        $this->children = array();
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

    public function addChild(Getopt_Response_Spec $child)
    {
        $this->children[] = $child;
    }

    public function parse(Getopt_Request_Standard $request, $key = null)
    {
        if (!$this->isMatch($request, $key)) {
            throw new Getopt_Response_Spec_NoMatchException(
                $request, 'No match for ' . $this->__toString()
            );
        }

        $response = new Getopt_Response_Item_Items();

        if (empty($key)) {
            $key = 1;
        }

        foreach (new Getopt_Request_Iterator($request, $key) as $currentKey => $arg)
        {
            foreach ($this->children as $child) {
                $childName = $child->getName();

                if ($child->isMatch($request, $currentKey)) {
                    $response->addValue($child->parse($request, $currentKey), $child->getName());
                }
            }
        }
        return $response;
    }

    public function isMatch(Getopt_Request_Standard $request, $key = null)
    {
        foreach (new Getopt_Request_Iterator($request, $key) as $arg) {
            return $this->match($arg);
        }

        return false;
    }

    public function __toString()
    {
        return sprintf('[%s] %s', __CLASS__, $this->name);
    }

    protected function match(Getopt_Request_Token $arg)
    {
        if ($arg instanceof Getopt_Request_Token_Value && $arg->getValue() == $this->name)
        {
            return true;
        }
        return false;
    }
}
