<?php

class Getopt
    implements Getopt_Items
{
    private $requestFactory;
    private $tokenFactory;
    private $children;
    private $name;

    public function __construct($name = 'getopt')
    {
        $this->name = $name;
    }

    public function isMatch(Getopt_Request_Interface $request)
    {
        foreach ($this->children as $child) {
            if ($child->isMatch($request)) {
                return true;
            }
        }
        return false;
    }

    public function parse(Getopt_Request_Interface $request)
    {
        $response = new Getopt_Response_Container($this->getName());

        foreach ($this->children as $child) {
            if ($child->isMatch($request)) {
                $response->addValue($child->parse($request));
            }
        }

        return $request;
    }

    public function getRequest($input)
    {
        return $this->getRequestFactory()
            ->getRequest($this->getTokenFactory()->getTokens($input));
    }

    public function getName()
    {
        return $this->name;
    }

    public function addChild(Getopt_Item $child)
    {
        $this->children[] = $child;
    }

    public function getTokenFactory()
    {
        if (is_null($this->tokenFactory)) {
            $this->tokenFactory = new Getopt_Tokenizer();
        }
        return $this->tokenFactory;
    }

    public function getRequestFactory()
    {
        if (is_null($this->requestFactory)) {
            $this->requestFactory = new Getopt_Request();
        }
        return $this->requestFactory;
    }
}
