<?php
namespace CEC\HTML;

use Contracts\ChildNode;
use Contracts\ParentNode;

class Sentinel extends ChildNodeBehavior implements ChildNode
{
    public function __construct()
    {
        $this->previous = $this;
        $this->next = $this;
    }

    public function setParent(ParentNode $parent)
    {
        $this->parent = $parent;
    }
    public function remove()
    {
        return;
    }
}
