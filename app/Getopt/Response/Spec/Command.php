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

    public function parse(array $request)
    {
        if (!$this->match($request)) {
            throw new Getopt_Response_Spec_NoMatchException(
                $request, 'No match for ' . $this->__toString()
            );
        }

        $response = new Getopt_Response_Item_Items();

        while (count($remainingRequest)) {
            $matched = false;
            foreach ($this->children as $child) {
                $subReq = $child->getRequest($remainingRequest);
                $subRemain = $child->getRemainingRequest($remainingRequest);

                try {
                    $response->addValue($child->parse($subReq, $subRemain), $child->getName());
                    $remainingRequest = $subRemain;
                    $matched = true;
                    break;
                }
                catch (Getopt_Response_Spec_NoMatchException $e) {
                    // Do nothing as no match
                }
            }

            if (!$matched) {
                $remainingRequest = array_slice($remainingRequest, 1);
            }
        }

        return $response;
    }

    public function getRequest($request)
    {
        return array_slice($request, 0, 1);
        return array_slice($request, 1);
    }

    public function __toString()
    {
        return sprintf('[%s] %s', __CLASS__, $this->name);
    }

    protected function match(array $tokens)
    {
        $arg = array_shift($tokens);
        if ($arg instanceof Getopt_Request_Token_Value && $arg->getValue() == $this->name)
        {
            return true;
        }
        return false;
    }
}
