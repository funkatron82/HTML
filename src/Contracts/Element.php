<?php
namespace CEC\HTML\Contracts;

use CEC\HTML\ClassList;

interface Element
{
    public function getAttribute(string $name): string;

    public function setAttribute(string $name, $value): self;

    public function removeAttribute(string $name): self;

    public function setAttributes(array $attributes): self;

    public function hasAttribute(string $name): bool;

    public function validateAttributeName(string $name): string;

    public function renderAttribute(string $name): string;

    public function renderAttributes(): string;

    public function classList(): ClassList;

    public function setTagName(string $tagName);
}
