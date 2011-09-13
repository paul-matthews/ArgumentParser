<?php

class Getopt
{
    const RESPONSE_NAME = __CLASS__;
    private $tokenizer;
    private $commands;

    public function __construct()
    {
        $this->commands = array();
    }

    public function getRequest(array $input)
    {
        return new Getopt_Request($this->tokenize($input));
    }

    public function parse()
    {
        $response = new Getopt_Response(self::RESPONSE_NAME);

        foreach ($this->commands as $command) {
            $currentOutput = $command->parse($command);
            if ($currentOutput instanceof Getopt_Response) {
                $response->addChild($currentOutput);
            }
        }
        return $response;
    }

    public function addCommand(Getopt_Item_Command $item)
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

    protected function tokenize($input)
    {
        return $this->getTokenizer()->tokenize($input);
    }

    protected function getDefaultTokenizer()
    {
        return new Getopt_Tokenizer_Posix();
    }
}
