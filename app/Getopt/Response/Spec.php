<?php


interface Getopt_Response_Spec
{

    public function getRequest(Getopt_Request_Standard $request);

    public function parse(Getopt_Request_Standard $requst);

    public function __toString();
}
