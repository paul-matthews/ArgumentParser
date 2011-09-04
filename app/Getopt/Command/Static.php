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
        $responseCommand = new Getopt_Response_Command($this->getName());

        for (; $request->valid(); $request->next()) {
            foreach ($this->getOptions() as $option) {
                try {
                    $responseCommand->addOption($option->parse($request));
                    continue;
                } catch (Getopt_Command_Option_Exception $e) {
                    // @todo something
                }
            }
        }

        return $request->setResponse(
            $request->getResponse()->addCommand($responseCommand)
        );
    }

    protected function isMatch($request)
    {
        $request->rewind();

        if ((string) $request->current() == $this->getName()) {
            $request->next();
            return true;
        }
        return false;
    }
}
