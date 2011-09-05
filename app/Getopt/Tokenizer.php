<?php

class Getopt_Tokenizer
{
    private $config;

    public function getTokens($input)
    {
        if (!is_array($input)) {
            return $this->getToken($input);
        }

        $tokens = array();
        foreach ($input as $item) {
            $tokens = array_merge(
                $tokens,
                $this->getTokens($item)
            );
        }
        return $tokens;
    }

    private function getToken($input)
    {
        $tokens = array();

        foreach (Getopt_Filter::filter($input, 'SeparateShortOpts') as $token) {
            $tokens[] = new Getopt_Tokenizer_Token($token);
        }

        return $tokens;
    }
}
