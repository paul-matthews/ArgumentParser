<?php
require_once(__DIR__ . '/ArgumentAlias.php');

class ArgumentParser
{
    const MANDATORY = ':';
    const ALL = '*';

    const THREE_OR_MORE_DAHSES = '/-{3,}/';
    const OPTION_VALUE_GROUP = '/-+(\w+)="(\w+)"/';

    protected $_aliases = array();
    protected $_options = array();

    public function parse($input)
    {
        $args = array();
        foreach ($input as $item) {
            $curretArgs = array();
            try {
                $curretArgs = $this->parseParam($item);
            } catch (InvalidArgumentException $e) {
                // Do nothing as no loggin available.
            }

            $args = array_merge($args, $this->convertAliases($curretArgs));
        }

        return $args;
    }

    public function addAlias($alias, $toKey = null)
    {
        if (!($alias instanceof ArgumentAlias)) {
            $alias = new ArgumentAlias($alias, $toKey);
        }

        $this->_aliases[] = $alias;
    }

    public function getAlias($key)
    {
        foreach ($this->_aliases as $alias)
        {
            if ($alias->matches($key)) {
                return $alias->convert($key);
            }
        }

        return $key;
    }

    public function setOptions($options)
    {
        preg_match_all('/\w:*/i', $options, $matches);

        foreach ($matches[0] as $match) {
            if (strstr($match, self::MANDATORY)) {
                $match = str_replace(self::MANDATORY, '', $match);
                if (!isset($this->_options[self::MANDATORY])) {
                    $this->_options[self::MANDATORY] = array();
                }

                $this->_options[self::MANDATORY][] = $match;
            }
        }
    }

    public function getOptions($type = self::ALL)
    {
        $options = array();
        switch ($type) {
            case self::MANDATORY:
                if (isset($this->_options[self::MANDATORY])) {
                    $options = $this->_options[self::MANDATORY];
                }
                break;
            case self::ALL:
            default:
                foreach ($this->_options as $option) {
                    $options = array_merge($options, $option);
                }
                break;
        }

        return $options;
    }

    public function getAliases()
    {
        return $this->_aliases;
    }

    protected function parseParam($item)
    {
        if (!$this->isValid($item)) {
            throw new InvalidArgumentException('Incorrect argument specified');
        }

        $realItem = str_replace('-', '', $item);

        if (strstr($item, '=')) {
            return $this->getOptionAndValue($item);
        }

        if (!strstr($item, '--')) {
            return $this->parseShortBooleanOption($realItem);
        }

        return $this->parseLongBooleanOption($realItem);
    }

    protected function convertAliases($params)
    {
        $finalParams = array();
        foreach ($params as $key => $value) {
            $finalParams[$this->getAlias($key)] = $value;
        }

        return $finalParams;
    }

    protected function isValid($arg)
    {
        if (!strstr($arg, '-') || preg_match(self::THREE_OR_MORE_DAHSES, $arg)) {
            return false;
        }
        return true;
    }

    protected function parseShortBooleanOption($string)
    {
        return array_fill_keys(str_split($string), true);
    }

    protected function parseLongBooleanOption($string)
    {
        return array_fill_keys(explode(' ', $string), true);
    }

    protected function getOptionAndValue($string)
    {
        preg_match_all(self::OPTION_VALUE_GROUP, $string, $matches);

        if (count($matches) != 3 || count($matches[1]) != 1 || count($matches[2]) != 1) {
            throw new InvalidArgumentException('Incorrect Parameters Format');
        }

        return array($matches[1][0] => $matches[2][0]);
    }
}
