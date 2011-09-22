<?php

class Getopt_Request_Tokenizer_PosixParamValue
    extends Getopt_Request_Tokenizer_PosixParam
{
    const VALUE_FORMAT = '%1$s%2$s%3$s?([^%3$s]*)%3$s?';

    public function doTokenize($arg)
    {
        $tokens = array();
        foreach ($this->paramRegexes as $class => $regex) {
            preg_match_all($regex, $arg, $matches);

            if (count($matches) > 1 && count($matches[1]) > 0) {

                foreach ($matches[1] as $match) {
                    $tokens = array_merge(
                        $tokens,
                        array($this->createToken($match, $class))
                    );
                }

                if (count($matches) > 2 && count($matches[2] > 0)) {
                    foreach ($matches[2] as $match) {
                        $tokens = array_merge(
                            $tokens,
                            array(new Getopt_Request_Token_Value($match))
                        );
                    }
                }
            }
        }

        return $tokens;
    }

    private function createToken($match, $class)
    {
        return new $class($match);
    }

    public static function createShortRegex($shortSpecifier, $separator = '=', $quote = '"')
    {
        return sprintf(
            parent::CONTAINER_FORMAT,
            sprintf(
                self::VALUE_FORMAT,
                sprintf(parent::PREFIX_SHORT_FORMAT, $shortSpecifier),
                $separator,
                $quote
            )
        );
    }

    public static function createLongRegex($shortSpecifier, $separator = '=', $quote = '"')
    {
        return sprintf(
            parent::CONTAINER_FORMAT,
            sprintf(
                self::VALUE_FORMAT,
                sprintf(parent::PREFIX_LONG_FORMAT, $shortSpecifier, $separator),
                $separator,
                $quote
            )
        );
    }
}
