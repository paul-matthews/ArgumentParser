<?php

interface Getopt_Request_Interface extends Iterator
{
    public function getTokens();

    public function peek();
}
