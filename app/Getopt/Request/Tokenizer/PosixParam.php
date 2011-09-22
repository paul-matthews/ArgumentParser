<?php

class Getopt_Request_Tokenizer_PosixParam
    extends Getopt_Request_Tokenizer
{
    const PREFIX_SHORT_FORMAT = '/^%1$s([^%1$s]{1})$/';
    const PREFIX_LONG_FORMAT = '/^%1$s%1$s([^%1$s]+)$/';

    private $paramRegexes;

    public function __construct(array $paramRegexes)
    {
        $this->paramRegexes = $paramRegexes;
    }

    public function canTokenize($arg)
    {
        foreach ($this->paramRegexes as $regex) {
            if (preg_match($regex, $arg)) {
                return true;
            }
        }
        return false;
    }

    public function tokenize($arg)
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
            }
        }

        return $tokens;
    }

    private function createToken($match, $class)
    {
        return new $class($match);
    }

    public static function createShortRegex($shortSpecifier)
    {
        return sprintf(self::PREFIX_SHORT_FORMAT, $shortSpecifier);
    }

    public static function createLongRegex($shortSpecifier)
    {
        return sprintf(self::PREFIX_LONG_FORMAT, $shortSpecifier);
    }
}
