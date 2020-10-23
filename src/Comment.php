<?php
namespace CEC\HTML;

use CEC\HTML\Contracts\Renderable;
use CEC\HTML\Contracts\ChildNode;

/**
 * A renderable object that renders into text
 */
class Comment extends ChildNodeBehavior implements Renderable, ChildNode
{
    protected $comment;

    public function __construct(string $comment)
    {
        $this->setComment($comment);
    }

    public function setComment(string $comment)
    {
        $this->comment = htmlspecialchars((string) $comment, ENT_COMPAT | ENT_HTML5);
    }

    /**
     * Returns a string
     * @return  string string representation of object
     */
    public function render(): string
    {
        return sprintf("<!-- %s -->", $this->comment);
    }
}
