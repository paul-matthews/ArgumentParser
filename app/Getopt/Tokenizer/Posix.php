<?php

class Getopt_Tokenizer_Posix implements Getopt_Tokenizer
{
    const TRIM = '-';
    const TRIM_QUOTE = '"';

    const LONG_OPTION_REGEX = '/^--[^-]/';
    CONST SHORT_OPTION_REGEX = '/^-[^-]/';
    CONST OPTION_VALUE_REGEX = '/^-[^=]+="([^"]+)"$/';

    public function tokenize(array $input)
    {
        $tokens = array();
        foreach ($input as $item) {
            $tokens = array_merge($tokens, $this->getToken($item));
        }
        return $tokens;
    }

    public function getToken($item)
    {
        if (preg_match(self::OPTION_VALUE_REGEX, $item)) {
            return $this->getSubTokens($item);
        }

        if (preg_match(self::LONG_OPTION_REGEX, $item)) {
            return array(
                new Getopt_Token_Long(ltrim($item, self::TRIM))
            );
        }

        if (preg_match(self::SHORT_OPTION_REGEX, $item)) {
            return array(
                new Getopt_Token_Short(ltrim($item, self::TRIM))
            );
        }

        return array(new Getopt_Token_Value($item));
    }

    protected function getSubTokens($item)
    {
        $tokens = array();
        foreach (explode('=', $item) as $subItem) {
            $tokens = array_merge(
                $tokens,
                $this->getToken(
                    trim($subItem, self::TRIM_QUOTE)
                )
            );
        }
        return $tokens;
    }
}
