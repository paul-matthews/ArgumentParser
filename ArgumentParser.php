<?php

class ArgumentParser
{
    public function parse($input)
    {
        $args = array();
        foreach ($input as $item) {
            $realItem = str_replace('-', '', $item);

            if (strstr($item, '=')) {
                list($option, $value) = $this->getOptionAndValue($item);
                $args[$option] = $value;
                continue;
            }

            $items = array($realItem);
            if (!strstr($item, '--')) {
                $items = str_split($realItem);
            }

            foreach ($items as $subItem) {
                $args[$subItem] = true;
            }
        }

        return $args;
    }

    protected function getOptionAndValue($string)
    {
        preg_match_all('/-+(\w+)="(\w+)"/', $string, $matches);
        return array($matches[1][0], $matches[2][0]);
    }
}
