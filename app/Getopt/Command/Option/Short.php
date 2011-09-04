<?php

class Getopt_Command_Option_Short
    extends Getopt_Command_Option_Abstract
    implements Getopt_Command_Option_Interface
{
    public function parse(Getopt_Request_Interface $request)
    {
        if ($request->current() != "-{$this->getName()}") {
            throw new Getopt_Command_Option_Exception('Option not set');
        }

        $response = new Getopt_Response_Option($this->getName());
        $response->setValue($this->getArgument()->parse($request));

        return $response;
    }
}
