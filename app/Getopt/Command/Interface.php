<?php

interface Getopt_Command_Interface
{
    public function getName();

    public function parse(Getopt_Request_Interface $request);
}
