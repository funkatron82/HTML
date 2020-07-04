<?php
namespace CEC\HTML;

class Sentinel extends Node
{
    public function __construct($parent = null)
    {
        $this->parent = $parent;
        $this->previous = $this;
        $this->next = $this;
    }
    public function remove()
    {
        return;
    }
}
