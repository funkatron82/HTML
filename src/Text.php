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

    public function splitText(int $offset)
    {
        $split = new static(substr($this->data, $offset));
        $this->deleteData($offset);
        $this->addAfter($split);
        return $split;
    }

    public function wholeText()
    {
        $current = $this;
        $wholeText = '';

        while ($current->previousSibling() instanceof Text) {
            $current = $current->previousSibling();
        }

        while ($current instanceof Text) {
            $wholeText .= $current->data;
            $current = $current->nextSibling();
        }

        return $wholeText;
    }

    public function render(): string
    {
        return $this->data;
    }
}
