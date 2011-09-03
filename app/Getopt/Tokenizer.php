<?php

class Getopt_Tokenizer
{
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

        foreach ($this->getCombinedTokens($input) as $token) {
            $tokens[] = new Getopt_Tokenizer_Token($token);
        }

        return $tokens;
    }

    private function getCombinedTokens($input)
    {
        preg_match_all('/^-([^-=]{2,})/', $input, $matches);

        $input = array($input);
        if (count($matches[1]) && count($matches[1][0]) > 0) {
            $input = array();
            foreach (str_split($matches[1][0]) as $match) {
                $input[] = "-$match";
            }
        }

        return $input;
    }
}
