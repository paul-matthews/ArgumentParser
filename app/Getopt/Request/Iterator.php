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
        $this->rewind();
    }

    public function rewind()
    {
        $this->advanceToKey($this->key);

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

    public function prev()
    {
        return $this->request->prev();
    }


    public function getNextKey()
    {
        $request = clone $this->request;
        $request->next();
        $response = $request->key();
        unset($request);

        return $response;
    }

    protected function advanceToKey($key = null)
    {
        $this->request->rewind();

        if (!is_null($key)) {
            while (
                $this->key() !== $key && $this->valid()
            ) {
                $this->next();
            }
        }
    }
}
