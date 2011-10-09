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

    public function getRequest(Getopt_Request_Standard $request)
    {
        return new Getopt_Request_Sub($request, 0, 1);
    }

    public function parse(Getopt_Request_Standard $request)
    {
        if (!$this->match($request)) {
            throw new Getopt_Response_Spec_NoMatchException(
                $request, 'No match for ' . $this->__toString()
            );
        }

        $response = new Getopt_Response_Item_Items();
        while (count($request)) {
            $matched = false;
            foreach ($this->children as $child) {
                try {
                    $currentRequest = $child->getRequest($request);
                    $response->addValue($child->parse($currentRequest), $child->getName());
                    $request = $currentRequest;

                    $matched = true;
                    break;
                }
                catch (Getopt_Response_Spec_NoMatchException $e) {
                    // Do nothing as no match
                }
            }

            if (!$matched) {
                $request = $this->getRequest($request);
            }
        }

        return $response;
    }

    public function __toString()
    {
        return sprintf('[%s] %s', __CLASS__, $this->name);
    }

    protected function match($request)
    {
        $arg = $request->current();
        if ($arg instanceof Getopt_Request_Token_Value && $arg->getValue() == $this->name)
        {
            return true;
        }
        return false;
    }
}
