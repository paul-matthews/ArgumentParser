<?php


interface Getopt_Response_Spec
{
    public function parse(Getopt_Request_Standard $request, $key = null);

    public function isMatch(Getopt_Request_Standard $request, $key = null);

    public function __toString();
}
