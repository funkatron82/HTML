<?php
namespace CEC\HTML;

trait Attributes
{
    protected $attributes = [];

    public function getAttribute($name)
    {
        $name = $this->validateAttributeName($name);

        return $this->attributes[$name] ?? null;
    }

    public function setAttribute($name, $value)
    {
        $name = $this->validateAttributeName($name);
        if (is_bool($value) || null === $value) {
            $this->attributes[$name] = (bool) $value;
        } else {
            $this->attributes[$name] = htmlspecialchars(strval($value), ENT_QUOTES | ENT_SUBSTITUTE | ENT_DISALLOWED | ENT_HTML5, 'UTF-8');
        }

        return $this;
    }

    public function removeAttribute($name)
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

    public function hasAttribute($name)
    {
        $name = $this->validateAttributeName($name);
        return isset($this->attributes[$name]);
    }

    public function validateAttributeName($name)
    {
        if (preg_match('/([\t\n\f \/>\"\'=]+)/', $name)) {
            throw new \Exception("Invalid character in attribute name");
        }

        if (strlen($name) < 1) {
            throw new \Exception("Attribute name too short");
        }

        return strtolower($name);
    }

    public function renderAttribute($name)
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
}
