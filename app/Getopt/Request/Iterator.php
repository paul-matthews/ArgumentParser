<?php

class Getopt_Request_Iterator
    implements Iterator
{
    protected $request;
    protected $key;

    public function __construct(Getopt_Request_Standard $request, $key = null)
    {
        $this->key = $key;
        $this->request = clone $request;
    }

    public function rewind()
    {
        $this->request->rewind();
        if (!empty($this->key)) {
            while (
                $this->key() !== $this->key && $this->valid()
            ) {
                $this->next();
            }
        }
        return $this->current();
    }

    public function current()
    {
        return $this->request->current();
    }

    public function key()
    {
        return $this->request->key();
    }

    public function next()
    {
        return $this->request->next();
    }

    public function valid()
    {
        return $this->request->valid();
    }
}
