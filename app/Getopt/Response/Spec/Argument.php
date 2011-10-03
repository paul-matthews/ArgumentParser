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

    public function parse(Getopt_Request_Standard $request, $key = null)
    {
        if (!$this->isMatch($request, $key)) {
            throw new Getopt_Response_Spec_NoMatchException($request, "No match $this");
        }

        $iterator = new Getopt_Request_Iterator($request, $key);
        return $this->value->parse($request, $iterator->getNextKey());
    }

    public function isMatch(Getopt_Request_Standard $request, $key = null)
    {
        $iterator = new Getopt_Request_Iterator($request, $key);
        foreach ($iterator as $currentKey => $arg)
        {
            if ($this->match($arg)
                && $this->value->isMatch($request, $iterator->getNextKey())
            ) {
                return true;
            }
            return false;
        }
        return false;
    }

    public function getName()
    {
        return $this->name;
    }

    public function __toString()
    {
        return sprintf(self::TOSTRING_FORMAT, $this->getName());
    }

    protected function match(Getopt_Request_Token $arg)
    {
        if ($arg instanceof Getopt_Request_Token_Param) {
            switch ($this->value->hasArgMatch($this, $arg)) {
            case Getopt_Response_Spec_Value::RESPONSE_NO_MATCH:
                return false;
                break;
            case Getopt_Response_Spec_Value::RESPONSE_MATCH:
                return true;
                break;
            case Getopt_Response_Spec_Value::RESPONSE_UNKOWN:
            default:
                if ($arg->getValue() == $this->getName()) {
                    return true;
                }
                break;
            }
        }

        return false;
    }
}
