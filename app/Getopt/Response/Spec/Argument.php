<?php

class Getopt_Response_Spec_Argument
    implements Getopt_Response_Spec
{
    const TOSTRING_FORMAT = '[Argument: %s]';

    private $name;

    public function __construct($name, Getopt_Response_Spec_Value $value = null)
    {
        if (empty($value)) {
            $value = new Getopt_Response_Spec_Value_Null();
        }
        $this->value = $value;
        $this->name = $name;
    }

    public function getRequest(Getopt_Request_Standard $request)
    {
        return new Getopt_Request_Sub($request, 0, 1);
    }

    public function parse(Getopt_Request_Standard $request)
    {
        if (!$this->match($request)) {
            throw new Getopt_Response_Spec_NoMatchException(
                $request, 'No match for ' . $this->__toString()
            );
        }

        return $this->value->parse($this->value->getRequest($request));
    }

    public function getName()
    {
        return $this->name;
    }

    public function __toString()
    {
        return sprintf(self::TOSTRING_FORMAT, $this->getName());
    }

    protected function match(Getopt_Request_Standard $request)
    {
        $arg = $request->current();

        if ($arg instanceof Getopt_Request_Token_Param
            && $this->value->filterArg($arg)->getValue() == $this->getName()
        ) {
            return true;
        }

        return false;
    }
}
