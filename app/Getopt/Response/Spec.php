<?php


interface Getopt_Response_Spec
{

    public function parse(array $request, array $remainingRequest);

    public function __toString();
}
