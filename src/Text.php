<?php
namespace CEC\HTML;

use CEC\HTML\Contracts\Renderable;

/**
 * A renderable object that renders into text
 */
class Text extends Node implements Renderable
{
    protected $content;

    public function __construct($content)
    {
        $this->setContent($content);
    }

    public function setContent($content)
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
