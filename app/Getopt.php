<?php

class Getopt
{
    public function __construct(Getopt_Request $requestFactory, Getopt_Response $responseFactory)
    {
        $this->requestFactory = $responseFactory;
        $this->responseFactory = $responseFactory;
    }

    public function getRequest($args)
    {
        if (!is_array($args)) {
            $args = array($args);
        }

        return $this->requestFactory->getRequest($args);
    }

    public function getResponse(Getopt_Request_Instance $request)
    {
        return $this->responseFactory->getResponse($request);
    }
}
