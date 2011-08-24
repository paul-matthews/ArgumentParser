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
        if (strpos($arg, '=') > 0) {
            return $this->parseValue($arg);
        }

        if (strpos($arg, '-') === 0) {
            return $this->parseBoolean($arg);
        }

        return array();
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
        preg_match('/^-{1,2}([^=]+)="([^"]+)"/', $arg, $matches);

        if (count($matches) == 3) {
            return array($matches[1] => $matches[2]);
        }
        return array();
    }
}
