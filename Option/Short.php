<?php

class Option_Short extends Option_Abstract implements Option_Interface
{
    public function parse($arg, Command $cmd)
    {
        if (substr($arg, 0, 2) != '-' . $this->getName()) {
            return $cmd;
        }

        $option = clone $this;

        if (!$option->getArgument()->parse($arg, $cmd)) {
            return $cmd;
        }

        return $cmd->addOption($option);
    }
}
