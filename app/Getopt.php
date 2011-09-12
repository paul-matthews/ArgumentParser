<?php

class Getopt
{
    private $tokenizer;
    private $commands;

    public function __construct()
    {
        $this->commands = array();
    }

    public function tokenize($input)
    {
        return $this->getTokenizer()->tokenize($input);
    }

    public function parse()
    {
        $output = array();
        foreach ($this->commands as $command) {
            if ($currentOutput = $command->parse($command)) {
                $output[$command->getName()] = $currentOutput;
            }
        }
        return $output;
    }

    public function addCommand(Getopt_Command_Item $item)
    {
        $this->commands[] = $item;
    }

    public function setTokenizer(Getopt_Tokenizer $tokenizer)
    {
        $this->tokenizer = $tokenizer;
        return $this;
    }

    public function getTokenizer()
    {
        if (is_null($this->tokenizer)) {
            $this->tokenizer = $this->getDefaultTokenizer();
        }
        return $this->tokenizer;
    }

    protected function getDefaultTokenizer()
    {
        return new Getopt_Tokenizer_Posix();
    }
}
