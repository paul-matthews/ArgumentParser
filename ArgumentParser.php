<?php

class ArgumentParser
{
    public function parse($input)
    {
        $args = array();
        foreach ($input as $item) {
            $realItem = str_replace('-', '', $item);

            if (strstr($item, '=')) {
                $args = array_merge($args, $this->getOptionAndValue($item));
                continue;
            }

            if (!strstr($item, '--')) {
                $args = array_merge($args, $this->parseShortBooleanOption($realItem));
                continue;
            }
            $args = array_merge($args, $this->parseLongBooleanOption($realItem));
        }

        return $args;
    }

    protected function parseShortBooleanOption($string)
    {
        return array_fill_keys(str_split($string), true);
    }

    protected function parseLongBooleanOption($string)
    {
        return array_fill_keys(explode(' ', $string), true);
    }

    protected function getOptionAndValue($string)
    {
        preg_match_all('/-+(\w+)="(\w+)"/', $string, $matches);
        return array($matches[1][0] => $matches[2][0]);
    }
}
