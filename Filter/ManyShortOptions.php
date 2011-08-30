<?php

class Filter_ManyShortOptions implements Filter_Interface
{
    const REGEX = '/^-[^-]{2,}/';

    public function filter($params)
    {
        $filtered = array();
        foreach ($params as $param) {
            if (preg_match(self::REGEX, $param) < 1) {
                $filtered[] = $param;
                continue;
            }

            foreach (str_split(ltrim($param, '-')) as $char) {
                $filtered[] = '-' . $char;
            }
        }

        return $filtered;
    }
}
