<?php

interface Getopt_Item_Option_Interface
    extends Getopt_Items
{
    public function __construct(
        $name, Getopt_Validator_Interface $validator,
        Getopt_Item_Argument_Interface $argument = null
    );

    public function getName();
}
