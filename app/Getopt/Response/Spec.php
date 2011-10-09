<?php


interface Getopt_Response_Spec
{

    public function parse(array $request);

    public function __toString();
}
