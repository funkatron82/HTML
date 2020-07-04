<?php
namespace CEC\HTML;

use CEC\HTML\Contracts\Renderable;
use CEC\HTML\Contracts\ChildNode;
use CEC\HTML\Contracts\ParentNode;

class Element extends Node implements ChildNode, ParentNode, Renderable
{
    use ParentNodeBehavior;
    use Attributes;
    protected $tagName;
    protected $classList;

    public function __construct($tagName)
    {
        $this->setTagName($tagName);
        $this->sentinel = new Sentinel($this);
        $this->classList = new ClassList($this);
    }

    public function classList()
    {
        return $this->classList;
    }

    protected function setTagName($tagName)
    {
        $tagName = strtolower($tagName);
        if (preg_match("/[^a-z0-9]/", $tagName)) {
            throw new Exception("Invalid character in tag name.");
        }
        $this->tagName = $tagName;
    }

    public function renderOpenTag()
    {
        return sprintf("<%s%s>", $this->tagName, $this->renderAttributes());
    }

    public function renderCloseTag()
    {
        return sprintf("</%s>", $this->tagName);
    }

    public function renderChildren()
    {
        $output = '';
        foreach ($this->children() as $child) {
            $output .= $child->render();
        }

        return $output;
    }

    public function render()
    {
        $template = in_array($this->tagName, ['input', 'img', 'hr', 'br', 'meta', 'link', 'area', 'base', 'col', 'embed', 'param', 'source', 'track', 'wbr']) ? '%s' : '%s%s%s';

        return sprintf($template, $this->renderOpenTag(), $this->renderChildren(), $this->renderCloseTag());
    }
}
