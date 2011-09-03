<?php

class Getopt_Command_Static
    extends Getopt_Command_Abstract
    implements Getopt_Command_Interface
{
    public function parse(Getopt_Request_Interface $request)
    {
        if (!$this->isMatch($request)) {
            return $request;
        }

        return $request->setResponse(
            $request->getResponse()->addCommand(
                new Getopt_Response_Command($this->getName())
            )
        );
    }

    protected function isMatch($request)
    {
        $request->rewind();

        if ((string) $request->current() == $this->getName()) {
            return true;
        }
        return false;
    }
}
