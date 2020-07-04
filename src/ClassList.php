<?php
namespace CEC\HTML;

class ClassList
{
    protected $element;
    public function __construct(Element $element)
    {
        $this->element = $element;
    }

    public function validate($class)
    {
        if (!preg_match('/^-?[_a-zA-Z]+[_a-zA-Z0-9-]*/', $class)) {
            throw new \Exception('Invalid class name');
        }
    }

    public function parse($text)
    {
        $text = trim($text);
        if (!$text) {
            return [];
        }
        $tokens = preg_split('/\s+/', $text);
        foreach ($tokens as $token) {
            $this->validate($token);
        }
        $tokens = array_keys(array_flip($tokens));
        return array_combine($tokens, $tokens);
    }

    public function read()
    {
        $text = $this->element->getAttribute('class');
        return $this->parse($text);
    }

    public function serialize($tokens)
    {
        return implode(' ', $tokens);
    }

    public function write($tokens)
    {
        $text = $this->serialize($tokens);
        $this->element->setAttribute('class', $text);
    }

    public function add(...$classes)
    {
        $tokens = $this->read();

        foreach ($classes as $class) {
            $this->validate($class);
            $tokens[$class] = $class;
        }
        $this->write($tokens);
        return $this;
    }

    public function remove(...$classes)
    {
        $tokens = $this->read();
        foreach ($classes as $class) {
            $this->validate($class);
            unset($tokens[$class]);
        }
        $this->write($tokens);
        return $this;
    }

    public function removeAll()
    {
        $this->write([]);
        return $this;
    }

    public function contains($class)
    {
        $tokens = $this->read();
        $this->validate($class);
        return (isset($tokens[$class]));
    }

    public function toggle($class, $force = null)
    {
        $tokens = $this->read();
        $this->validate($class);
        if (isset($tokens[$class])) {
            if (!force) {
                unset($tokens[$class]);
                $this->write($tokens);
                return false;
            }

            return true;
        }

        if (force === false) {
            return false;
        }

        $tokens[$class] = $class;
        $this->write($tokens);
        return true;
    }

    public function replace($old, $new)
    {
        $this->validate($old);
        $this->validate($new);
        $tokens = $this->read();

        if (!isset($tokens[$old])) {
            return;
        }
        unset($tokens[$old]);
        $tokens[$new] = $new;
        $this->write($tokens);
        return $this;
    }
}
