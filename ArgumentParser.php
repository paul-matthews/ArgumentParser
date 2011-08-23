<?php

class ArgumentParser
{
    const THREE_OR_MORE_DAHSES = '/-{3,}/';
    const OPTION_VALUE_GROUP = '/-+(\w+)="(\w+)"/';

    public function parse($input)
    {
        $args = array();
        foreach ($input as $item) {
            if (!$this->isValid($item)) {
                throw new InvalidArgumentException('Incorrect argument specified');
            }
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

    protected function isValid($arg)
    {
        if (!strstr($arg, '-') || preg_match(self::THREE_OR_MORE_DAHSES, $arg)) {
            return false;
        }
        return true;
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
        preg_match_all(self::OPTION_VALUE_GROUP, $string, $matches);

        if (count($matches) != 3 || count($matches[1]) != 1 || count($matches[2]) != 1) {
            throw new InvalidArgumentException('Incorrect Parameters Format');
        }

        return array($matches[1][0] => $matches[2][0]);
    }
}
