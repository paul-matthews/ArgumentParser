<?php

class Getopt_Tokenizer_Posix implements Getopt_Tokenizer
{
    const TRIM = '-';
    const LONG_OPTION_REGEX = '/^--[^-]/';
    CONST SHORT_OPTION_REGEX = '/^-[^-]/';

    public function tokenize(array $input)
    {
        $tokens = array();
        foreach ($input as $item) {
            $tokens[] = $this->getToken($item);
        }
        return $tokens;
    }

    public function getToken($item)
    {
        if (preg_match(self::LONG_OPTION_REGEX, $item)) {
            return new Getopt_Token_Long(ltrim($item, self::TRIM));
        }

        if (preg_match(self::SHORT_OPTION_REGEX, $item)) {
            return new Getopt_Token_Short(ltrim($item, self::TRIM));
        }

        return new Getopt_Token_Value($item);
    }
}
