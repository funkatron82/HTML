<?php
namespace CEC\HTML;

use \CEC\HTML\Contracts\ChildNode;

class Sentinel extends ChildNodeBehavior implements ChildNode
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
