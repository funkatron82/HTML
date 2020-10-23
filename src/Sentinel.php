<?php
namespace CEC\HTML;

use \CEC\HTML\Contracts\ChildNode;
use \CEC\HTML\Contracts\ParentNode;

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
