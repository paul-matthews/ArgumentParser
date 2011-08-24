<?php

class ArgumentParser
{

    public function parse($args)
    {
        $keys = array();

        foreach ($args as $arg) {
            $currentArgs = array(ltrim($arg, '-'));

            if (substr($arg, 0, 2) != '--') {
                $currentArgs = str_split(array_pop($currentArgs));
            }

            $keys = array_merge($keys, $currentArgs);
        }

        return array_fill_keys($keys, true);
    }
}
