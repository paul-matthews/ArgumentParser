<?php

class Getopt_Request_Sub
    extends Getopt_Request_Standard
{
    private $origin;
    private $remaining;

    public function __construct(Getopt_Request_Standard $request, $start = 0, $length = -1, $fromRemain = true)
    {
        $d = debug_backtrace();

        $e = array_shift($d);
        //var_dump($e);

        parent::__construct($this->extractSub($request, $start, $length, $fromRemain));

        $this->remaining = $this->extractRemaining($request, $start, $length, $fromRemain);
        $this->origin = $request;
    }

    public function getRemaining()
    {
        return $this->remaining;
    }

    protected function extractRemaining(Getopt_Request_Standard $request, $start, $length, $fromRemain = true)
    {
        $args = $this->extractArgs($request);

        if ($length < 1 || $length > count($args)) {
            return array();
        }

        return array_slice($args, $start + $length);
    }

    protected function extractSub(Getopt_Request_Standard $request, $start, $length, $fromRemain = true)
    {
        $args = $this->extractArgs($request, $fromRemain);

        if (!count($args)) {
            return array();
        }

        return array_slice($args, $start, $length);
    }

    protected function extractArgs(Getopt_Request_Standard $request, $fromRemain = true)
    {
        if ($fromRemain && $request instanceof Getopt_Request_Sub) {
            return $request->getRemaining();
        }

        return $request->getAsArray();
    }
}
