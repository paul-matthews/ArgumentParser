<?php

class Getopt_Request_Tokenizer
{
    protected $tokenizers;
    public function __construct()
    {
        $this->tokenizers = array();
    }

    public function addTokenizer(Getopt_Request_Tokenizer $tokenizer)
    {
        $this->tokenizers[] = $tokenizer;
    }

    public function getTokens(array $args)
    {
        $tokens = array();

        foreach ($args as $arg) {
            $tokens = array_merge($tokens, $this->tokenize($arg));
        }

        return $tokens;
    }

    public function tokenize($arg)
    {
        if ($this->canTokenize($arg)) {
            return $this->doTokenize($arg);
        }

        foreach ($this->tokenizers as $tokenizer) {
            $tokens = $tokenizer->tokenize($arg);

            if (count($tokens)) {
                return $tokens;
            }
        }

        return array();
    }

    public function canTokenize($arg)
    {
        return false;
    }

    protected function doTokenize($arg)
    {
        return $arg;
    }

    protected function createToken($token, $type = null)
    {
        return new Getopt_Request_Token($token);
    }
}
