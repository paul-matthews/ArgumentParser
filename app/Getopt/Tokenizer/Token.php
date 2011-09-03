<?php

class Getopt_Tokenizer_Token
{
    private $token;

    public function __construct($token)
    {
        $this->token = $token;
    }

    public function __toString()
    {
        return $this->token;
    }
}
