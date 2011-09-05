<?php

class Getopt_Tokenizer implements Getopt_Configurable
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

        foreach ($this->getCombinedTokens($input) as $token) {
            $tokens[] = new Getopt_Tokenizer_Token($token);
        }

        return $tokens;
    }

    private function getCombinedTokens($input)
    {
        $config = $this->getConfig();
        $indicator = $config->getOptionIndicator();
        $separators = $config->getOptionValueSeparator();

        $pre = $indicator;
        $not = implode(array_merge(array($indicator), $separators));
        $indicatorLen = strlen($indicator);

        preg_match_all(
            sprintf("/^%s([^%s]{%d,})/", $pre, $not, $indicatorLen),
            $input,
            $matches
        );

        $input = array($input);
        if (count($matches[1]) && count($matches[1][0]) > 0) {
            $input = array();
            foreach (str_split($matches[1][0]) as $match) {
                $input[] = "{$indicator}{$match}";
            }
        }

        return $input;
    }

    public function setConfig(Getopt_Config $config)
    {
        $this->config = $config;
    }

    public function getConfig()
    {
        if (is_null($this->config)) {
            $this->setConfig($this->getDefaultConfig());
        }

        return $this->config;
    }

    private function getDefaultConfig()
    {
        return Getopt_Config::getInstance();
    }
}
