<?php

class Getopt_Request_Tokenizer_PosixParam
    extends Getopt_Request_Tokenizer
{
    const CONTAINER_FORMAT = '/^%s$/';
    const PREFIX_FORMAT = '%1$s([^%1$s%2$s]+)';

    const TOKEN_SHORT = 0;
    const TOKEN_LONG = 1;

    protected $paramIdentifier;
    protected $type;

    public function __construct($paramIdentifier)
    {
        parent::__construct();
        $this->setParamIdentifier($paramIdentifier);
    }

    public function canTokenize($arg)
    {
        if (preg_match($this->getParamRegex(), $arg)) {
            return true;
        }

        return false;
    }

    public function doTokenize($arg)
    {
        $tokens = array();
        preg_match_all($this->getParamRegex(), $arg, $matches);

        if (count($matches) > 1 && count($matches[1]) > 0) {

            foreach ($matches[1] as $match) {
                $tokens = array_merge(
                    $tokens,
                    array($this->createToken($match, $this->type))
                );
            }
        }

        return $tokens;
    }

    protected function createToken($match, $type = self::TOKEN_LONG)
    {
        if ($type === self::TOKEN_SHORT) {
            return new Getopt_Request_Token_Param_Short($match);
        }
        if ($type === self::TOKEN_LONG) {
            return new Getopt_Request_Token_Param_Long($match);
        }

        return parent::createToken($match, $type);
    }

    protected function setParamIdentifier($identifier)
    {
        $this->type = self::TOKEN_SHORT;
        if (strlen($identifier) > 1) {
            $this->type = self::TOKEN_LONG;
        }

        $this->paramIdentifier = $identifier;
    }

    protected function getParamRegex()
    {
        return sprintf(
            self::CONTAINER_FORMAT,
            sprintf(self::PREFIX_FORMAT, preg_quote($this->paramIdentifier), '')
        );
    }
}
