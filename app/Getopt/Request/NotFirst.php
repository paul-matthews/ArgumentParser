<?php

class Getopt_Request_NotFirst
    extends Getopt_Request_Abstract
    implements Getopt_Request_Iterator
{
    public function rewind()
    {
        parent::rewind();
        return $this->next();
    }
}
