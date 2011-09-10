<?php

class Getopt_Item_Command_Static
    extends Getopt_Item_Command_Abstract
{
    public function parse(Getopt_Request_Interface $request)
    {
        if (!$this->isMatch($request)) {
            return $request;
        }
        $response = new Getopt_Response_Container($this->getName());

        for (; $request->valid(); $request->next()) {
            foreach ($this->getOptions() as $option) {
                try {
                    $response->addValue($option->parse($request));
                    continue;
                } catch (Getopt_Item_Option_Exception $e) {
                    // @todo something
                }
            }
        }

        return $response;
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
