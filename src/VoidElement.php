<?php
namespace CEC\HTML;

use CEC\HTML\Contracts\Renderable;
use CEC\HTML\Contracts\ChildNode;
use CEC\HTML\Contracts\ParentNode;

class VoidElement extends ChildNodeBehavior implements ChildNode, Renderable
{
    use ElementBehavior;

    public function __construct(string $tagName)
    {
        $this->setTagName($tagName);
    }

    public static function create(string $tagName)
    {
        return new VoidElement($tagName);
    }

    public function render()
    {
        return sprintf("<%s%s />", $this->tagName, $this->renderAttributes());
    }
}
