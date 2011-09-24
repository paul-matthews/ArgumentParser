<?php

class Getopt_Request_Tokenizer_PosixParamValue
    extends Getopt_Request_Tokenizer_PosixParam
{
    const VALUE_FORMAT = '%1$s%2$s%3$s([^%3$s]+)%3$s';
    const VALUE_FORMAT_NO_QUOTE = '%1$s%2$s([^%2$s]+)';
    const TOKEN_VALUE = 2;

    protected $valueSeparator;
    protected $quote;

    public function __construct($paramIdentifier, $valueSeparator = '=', $quote = '"')
    {
        $this->valueSeparator = $valueSeparator;
        $this->quote = $quote;
        parent::__construct($paramIdentifier);
    }

    public function doTokenize($arg)
    {
        $tokens = array();
        preg_match_all($this->getParamRegex(), $arg, $matches);

        if (count($matches) > 1 && count($matches[1]) > 0) {

            $matchesLength = count($matches[1]);
            for($i = 0; $i < $matchesLength; $i++) {
                $currentTokens = array();

                $currentTokens[] = $this->createToken($matches[1][$i], $this->type);
                if (isset($matches[2]) && isset($matches[2][$i])) {
                    $currentTokens[] = $this->createToken($matches[2][$i], self::TOKEN_VALUE);

                }
                $tokens = array_merge($tokens, $currentTokens);
            }
        }

        return $tokens;
    }

    protected function createToken($match, $type = self::TOKEN_LONG)
    {
        if ($type === self::TOKEN_VALUE) {
            return new Getopt_Request_Token_Value($match);
        }
        return parent::createToken($match, $type);
    }

    public function getParamRegex()
    {
        $valueFormat = self::VALUE_FORMAT;
        if (empty($this->quote)) {
            $valueFormat = self::VALUE_FORMAT_NO_QUOTE;
        }

        return sprintf(
            parent::CONTAINER_FORMAT,
            sprintf(
                $valueFormat,
                sprintf(
                    parent::PREFIX_FORMAT,
                    preg_quote($this->paramIdentifier),
                    preg_quote($this->valueSeparator)
                ),
                preg_quote($this->valueSeparator),
                preg_quote($this->quote)
            )
        );
    }
}
