<?php

class ArgumentParser
{

    public function parse($args)
    {
        $arguments = array();

        foreach ($args as $arg) {
            $arguments = array_merge($arguments, $this->parseItem($arg));
        }

        return $arguments;
    }

    protected function parseItem($arg)
    {
        if (strpos($arg, '=')) {
            return $this->parseValue($arg);
        }

        return $this->parseBoolean($arg);
    }

    protected function parseBoolean($arg)
    {
            $keys = array(ltrim($arg, '-'));

            if (substr($arg, 0, 2) != '--') {
                $keys = str_split(array_pop($keys));
            }

            return array_fill_keys($keys, true);
    }

    protected function parseValue($arg)
    {
        preg_match('/^--([^=]+)="([^"]+)"/', $arg, $matches);

        return array($matches[1] => $matches[2]);
    }
}
