<?php

class Getopt
{
    private $requestFactory;
    private $tokenFactory;

    public function getRequest($input)
    {
        return $this->getRequestFactory()
            ->getRequest($this->getTokenFactory()->getTokens($input));
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
