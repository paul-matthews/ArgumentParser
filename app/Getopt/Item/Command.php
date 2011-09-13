<?php

class Getopt_Item_Command
    implements Getopt_Item
{
    const VALUE_NAME = 'value';

    private $name;

    public function __construct($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

    public function parse(Getopt_Request $request)
    {
        if (!$this->isMatch($request)) {
            return null;
        }

        $response = new Getopt_Response($this->getName());
        $requestIterator = new Getopt_Request_NotFirst($request);
        foreach ($requestIterator as $item) {
            $itemResponse = $this->parseItem($requestIterator->getRequest());

            if (!is_null($itemResponse)) {
                $response->add($itemResponse);
            }
        }

        return $response;
    }

    public function isMatch(Getopt_Request $request)
    {
        foreach (new Getopt_Request_First($request) as $item) {
            if (($item instanceof Getopt_Token_Value)
                && $item->getValue() == $this->getName()
            ) {
                return true;
            }
        }
        return false;
    }

    protected function parseItem(Getopt_Request $request)
    {
        foreach ($this->options as $option) {
            $response = $option->parse($request);
            if ($response instanceof Getopt_Response) {
                return $response;
            }
        }

        return Getopt_Response(self::VALUE_NAME, $request->current());
    }
}
