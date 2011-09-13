<?php

class Getopt_Request_Positional
    extends Getopt_Request_Abstract
    implements Getopt_Request_Iterator
{
    private $startKey;

    public function __construct(Getopt_Request $request)
    {
        parent::__construct($request);
        $this->startKey = $request->key();
        $this->rewind();
    }

    public function rewind()
    {
        parent::rewind();
        foreach ($this->request as $key => $value) {
            if ($key == $this->startKey) {
                return $value;
            }
        }
        return null;
    }
}
