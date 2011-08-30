<?php

class Option_Long extends Option_Abstract implements Option_Interface
{
    public function parse($arg, Command $cmd)
    {
        $nameLen = strlen($this->getName());

        if (substr($arg, 0, 2 + $nameLen) != '--' . $this->getName()) {
            return $cmd;
        }

        $option = clone $this;

        if (!$option->getArgument()->parse($arg, $cmd)) {
            return $cmd;
        }

        return $cmd->addOption($option);
    }
}
