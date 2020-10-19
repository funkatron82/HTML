<?php
namespace CEC\HTML;

trait ElementBehavior
{
    protected $attributes = [];
    protected $tagName;

    public function getAttribute(string $name)
    {
        $name = $this->validateAttributeName($name);

        return $this->attributes[$name] ?? null;
    }

    public function setAttribute(string $name, $value)
    {
        $name = $this->validateAttributeName($name);
        if (is_bool($value) || null === $value) {
            $this->attributes[$name] = (bool) $value;
        } else {
            $this->attributes[$name] = htmlspecialchars(strval($value), ENT_QUOTES | ENT_SUBSTITUTE | ENT_DISALLOWED | ENT_HTML5, 'UTF-8');
        }

        return $this;
    }

    public function removeAttribute(string $name)
    {
        $name = $this->validateAttributeName($name);
        unset($this->attributes[$name]);
        return $this;
    }

    public function setAttributes(array $attributes)
    {
        array_walk($attributes, function ($value, $key) {
            $this->setAttribute($key, $value);
        });

        return $this;
    }

    public function hasAttribute(string $name)
    {
        $name = $this->validateAttributeName($name);
        return isset($this->attributes[$name]);
    }

    public function validateAttributeName(string $name)
    {
        if (preg_match('/([\t\n\f \/>\"\'=]+)/', $name)) {
            throw new \Exception("Invalid character in attribute name");
        }

        if (strlen($name) < 1) {
            throw new \Exception("Attribute name too short");
        }

        return strtolower($name);
    }

    public function renderAttribute(string $name)
    {
        $name = $this->validateAttributeName($name);
        $value = $this->attributes[$name];
        if (is_bool($value) && true === $value) {
            return sprintf(" %s", $name);
        } elseif (is_string($value) && !empty($value)) {
            return sprintf(" %s='%s'", $name, $value);
        }

        return '';
    }
    public function renderAttributes()
    {
        return array_reduce(array_keys($this->attributes), function ($renderString, $key) {
            return $renderString . $this->renderAttribute($key);
        });
    }

    public function classList()
    {
        return new ClassList($this);
    }

    public function setTagName($tagName)
    {
        $tagName = strtolower($tagName);
        if (preg_match("/[^a-z0-9]/", $tagName)) {
            throw new Exception("Invalid character in tag name.");
        }
        $this->tagName = $tagName;
    }
}
