<?php

class Command implements Iterator
{
    private $params;
    private $options;
    private $preFilters;

    public function __construct($params, $preFilters = array())
    {
        $this->preFilters = $preFilters;
        $this->options = array();

        $this->setParams($params);
    }

    private function setParams($params)
    {
        if (!is_array($params)) {
            $params = array();
        }

        foreach ($this->preFilters as $preFilter) {
            $params = $preFilter->filter($params);
        }

        $this->params = $params;
    }

    public function addOption(Option_Interface $option)
    {
        $this->options[] = $option;
        return $this;
    }

    public function peek()
    {
        $next = $this->next();
        prev($this->params);
        return $next;
    }

    public function rewind()
    {
        return reset($this->params);
    }

    public function current()
    {
        return current($this->params);
    }

    public function key()
    {
        return key($this->params);
    }

    public function next()
    {
        return next($this->params);
    }

    public function valid()
    {
        if ($this->current() !== false) {
            return true;
        }

        return false;
    }

    public function getResults()
    {
        $results = array();
        foreach ($this->options as $option) {
            $results = array_merge($results, $option->toArray());
        }

        return $results;
    }
}
