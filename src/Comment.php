<?php
namespace CEC\HTML;

use Contracts\Renderable;
use Contracts\ChildNode;
use Contracts\CharacterData;

/**
 * A renderable object that renders into text
 */
class Comment extends ChildNodeBehavior implements Renderable, ChildNode, CharacterData
{
    use CharacterDataBehavior;

    public function __construct($data)
    {
        $this->appendData($data);
    }

    public function render(): string
    {
        return sprintf("<!-- %s -->", $this->data);
    }
}
