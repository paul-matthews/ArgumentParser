<?php

class Getopt_Response
{
    private $commands;

    public function __construct()
    {
        $this->commands = array();
    }

    public function addCommand(Getopt_Response_Command $command)
    {
        $this->commands[] = $command;
        return $this;
    }

    public function toArray()
    {
        $return = array();

        foreach ($this->commands as $command) {
            $return[] = $command->toArray();
        }

        return $return;
    }
}
