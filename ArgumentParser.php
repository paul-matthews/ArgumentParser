<?php

class ArgumentParser
{
    public function parse($input)
    {
        $args = array();
        foreach ($input as $item) {
            $realItem = str_replace('-', '', $item);

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
}
