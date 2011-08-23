<?php

class ArgumentParser
{
    public function parse($input)
    {
        $args = array();
        foreach ($input as $item) {
            foreach (str_split(str_replace('-', '', $item)) as $subItem) {
                $args[$subItem] = true;
            }
        }

        return $args;
    }
}
