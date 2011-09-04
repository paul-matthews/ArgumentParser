<?php

class Getopt_Request_Array implements Getopt_Request_Interface
{
    private $tokens;
    private $response;

    public function __construct(array $input)
    {
        $this->setTokens($input);
    }

    public function getTokens()
    {
        return $this->tokens;
    }

    public function current()
    {
        return current($this->tokens);
    }

    public function next()
    {
        return next($this->tokens);
    }

    public function rewind()
    {
        return reset($this->tokens);
    }

    public function valid()
    {
        return (boolean) $this->current();
    }

    public function key()
    {
        return key($this->tokens);
    }

    public function peek()
    {
        $value = $this->next();
        prev($this->tokens);
        return $value;
    }

    protected function setTokens($input)
    {
        foreach ($input as $token) {
            if ($token instanceof Getopt_Tokenizer_Token) {
                $this->tokens[] = $token;
            }
        }
        return $this;
    }
}
