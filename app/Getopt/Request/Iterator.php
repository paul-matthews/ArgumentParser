<?php

interface Getopt_Request_Iterator
    extends Iterator
{
    public function __construct(Getopt_Request $request);

    public function peek();

    public function getRequest();
}
