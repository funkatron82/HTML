<?php
namespace CEC\HTML;

use CEC\HTML\Contracts\Element;

class ClassList
{
    protected $element;
    protected $tokens = [];
    public function __construct(Element $element)
    {
        $this->element = $element;
        $text = $this->element->getAttribute('class');
        $text = trim($text);
        $tokens = preg_split('/\s+/', $text);
        $tokens = array_filter($tokens);
        $this->add($tokens);
    }

    public function validate(string $token)
    {
        if (!preg_match('/^-?[_a-zA-Z]+[_a-zA-Z0-9-]*/', $token)) {
            throw new \Exception('Invalid class name: ' . $token);
        }
    }

    public function update()
    {
        $text = implode(' ', $this->tokens);
        $this->element->setAttribute('class', $text);
    }

    public function add(string ...$tokens): ClassList
    {
        foreach ($tokens as $token) {
            $this->validate($token);
            $this->tokens[$token] = $token;
        }
        $this->update();
        return $this;
    }

    public function remove(string ...$tokens): ClassList
    {
        foreach ($tokens as $token) {
            $this->validate($token);
            unset($this->tokens[$token]);
        }
        $this->update();
        return $this;
    }

    public function removeAll(): ClassList
    {
        $this->tokens = [];
        $this->update();
        return $this;
    }

    public function contains(string $token): bool
    {
        $this->validate($token);
        return (isset($this->tokens[$token]));
    }

    public function toggle(string $token, bool $force = null):bool
    {
        if ($this->contains($token)) {
            if (!$force) {
                $this->remove($token);
                return false;
            }

            return true;
        }

        if ($force === false) {
            return false;
        }

        $this->add($token);
        return true;
    }

    public function replace(string $oldToken, string $newToken): bool
    {
        if (!$this->contains($oldToken)) {
            return false;
        }
        $this->remove($oldToken);
        $this->add($newToken);
        return true;
    }
}
