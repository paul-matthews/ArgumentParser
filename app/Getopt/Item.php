<?php

interface Getopt_Item
{
    public function isMatch(Getopt_Request_Interface $request);

    public function parse(Getopt_Request_Interface $request);
}
