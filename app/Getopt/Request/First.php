<?php

class Getopt_Request_First
    extends Getopt_Request_Abstract
    implements Getopt_Request_Iterator
{
    private $notFirst;
    public function next()
    {
        $this->notFirst = true;
        return null;
    }

    public function current()
    {
        $this->notFirst = false;
        $this->rewind();
        return parent::current();
    }

    public function valid()
    {
        if (!$this->notFirst) {
            return parent::valid();
        }
        return null;
    }
}
