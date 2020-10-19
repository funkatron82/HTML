<?php
namespace CEC\HTML\Contracts;

interface Element
{
    public function getAttribute(string $name);

    public function setAttribute(string $name, $value);

    public function removeAttribute(string $name);

    public function setAttributes(array $attributes);

    public function hasAttribute(string $name);

    public function validateAttributeName(string $name);

    public function renderAttribute(string $name);

    public function renderAttributes();

    public function classList();

    public function setTagName(string $tagName);
}
