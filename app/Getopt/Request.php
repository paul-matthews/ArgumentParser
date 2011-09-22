<?php

class Getopt_Request
{
    private $filter;
    private $tokenizer;

    public function __construct(
        Getopt_Request_Filter $filter,
        Getopt_Request_Tokenizer $tokenizer
    ) {
        $this->filter = $filter;
        $this->tokenizer = $tokenizer;
    }

    public function getRequest(array $args)
    {
        $tokens = $this->tokenizer->getTokens(
            $this->filter->doFilter($args)
        );

        return new Getopt_Request_Standard($tokens);
    }
}
