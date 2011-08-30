<?php

interface Option_Interface
{
    public function getName();

    public function parse($arg, Command $cmd);

    public function toArray();
}
