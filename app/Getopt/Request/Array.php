<?php

class Getopt_Request_Array implements Getopt_Request_Interface
{
    private $tokens;

    public function __construct(array $input)
    {
        $this->setTokens($input);
    }

    public function getTokens()
    {
        return $this->tokens;
    }

    protected function setTokens($input)
    {
        foreach ($input as $token) {
            if ($token instanceof Getopt_Tokenizer_Token) {
                $this->tokens[] = $token;
            }
        }
    }
}
