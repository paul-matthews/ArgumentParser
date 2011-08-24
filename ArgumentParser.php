<?php

class ArgumentParser
{

    public function parse($args)
    {
        $keys = array();

        foreach ($args as $arg) {
            $keys = array_merge($keys, str_split(ltrim($arg, '-')));
        }

        return array_fill_keys($keys, true);
    }
}
