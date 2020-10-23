<?php
namespace CEC\HTML;

use CEC\HTML\Contracts\Renderable;
use CEC\HTML\Contracts\ChildNode;
use CEC\HTML\Contracts\CharacterData;

/**
 * A renderable object that renders into text
 */
class Text extends ChildNodeBehavior implements Renderable, ChildNode, CharacterData
{
    use CharacterDataBehavior;

    public function __construct($data)
    {
        $this->appendData($data);
    }

    public function render(): string
    {
        return $this->data;
    }
}
