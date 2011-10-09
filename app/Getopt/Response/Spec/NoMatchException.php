<?php

class Getopt_Response_Spec_NoMatchException
    extends Exception
{
    protected $request;
    public function __construct(Getopt_Request_Standard $request, $message = "", $code = 0, $previous = null)
    {
        $this->request = $request;
        parent::__construct($message, $code, $previous);
    }
}
