<?php

class Getopt_Tokenizer
{
    public function getTokens($input)
    {
        $input = $this->preTokenization($input);

        $tokens = $this->tokenize($input);

        return $this->postTokenization($tokens);
    }

    protected function preTokenization($input)
    {
        if (!is_array($input)) {
            $input = array($input);
        }

        $tokens = array();
        foreach ($input as $item) {
            foreach (Getopt_Filter::filter($item, 'SeparateShortOpts') as $token) {
                $tokens[] = $token;
            }
        }

        return $tokens;
    }

    protected function tokenize($input)
    {
        foreach ($input as $item) {
            $tokens[] = $this->getToken($item);
        }
        return $tokens;
    }

    protected function postTokenization($input)
    {
        return $input;
    }

    protected function getToken($input)
    {
        return new Getopt_Tokenizer_Token($input);
    }
}
