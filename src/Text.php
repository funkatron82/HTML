<?php
namespace CEC\HTML;

use CEC\HTML\Contracts\Renderable;
use CEC\HTML\Contracts\ChildNode;

/**
 * A renderable object that renders into text
 */
class Text extends ChildNodeBehavior implements Renderable, ChildNode
{
    protected $content;

    public function __construct(string $content)
    {
        $this->setContent($content);
    }

    public static function create($content)
    {
        return new Text($content);
    }

    public function setContent(string $content)
    {
        $this->content = htmlspecialchars((string) $content, ENT_COMPAT | ENT_HTML5);
    }

    /**
     * Returns a string
     * @return  string string representation of object
     */
    public function render()
    {
        return $this->content;
    }
}
