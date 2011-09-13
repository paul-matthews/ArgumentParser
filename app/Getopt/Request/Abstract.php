<?php

class Getopt_Request_Abstract
    implements Getopt_Request_Iterator
{
    protected $request;
    public function __construct(Getopt_Request $request)
    {
        $this->request = $request;
    }

    public function peek()
    {
        return $this->request->peek();
    }

    public function rewind()
    {
        return $this->request->rewind();
    }

    public function next()
    {
        return $this->request->next();
    }

    public function current()
    {
        return $this->request->current();
    }

    public function key()
    {
        return $this->request->key();
    }

    public function valid()
    {
        return $this->request->valid();
    }

    public function getRequest()
    {
        return $this->request;
    }
}
