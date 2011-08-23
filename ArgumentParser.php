<?php

class ArgumentParser
{
    public function parse($input)
    {
        $args = array();
        foreach ($input as $item) {
            $item = str_replace('-', '', $item);
            $args[$item] = true;
        }

        return $args;
    }
}
