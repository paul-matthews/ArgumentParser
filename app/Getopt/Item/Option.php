<?php

class Getopt_Item_Option
    implements Getopt_Item
{
    private $name;

    public function __construct($name) {
        $this->name = $name;
    }

    public function parse(Getopt_Request $request)
    {
    }
}
