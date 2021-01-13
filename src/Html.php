<?php
namespace CEC\HTML;

use CEC\HTML\Contracts\Renderable;
use CEC\HTML\Contracts\ChildNode;
use CEC\HTML\Contracts\ParentNode;
use CEC\HTML\Contracts\Element;
use CEC\HTML\Contracts\CharacterData;

class Html
{
    public static function createElement(string $tagName): Element
    {
        if (in_array(strtolower($tagName), ['input', 'img', 'hr', 'br', 'meta', 'link', 'area', 'base', 'col', 'embed', 'param', 'source', 'track', 'wbr'])) {
            return new class($tagName) extends ChildNodeBehavior implements Element, ChildNode, Renderable {
                use ElementBehavior;

                public function __construct(string $tagName)
                {
                    $this->setTagName($tagName);
                }

                public function render(): string
                {
                    return sprintf("<%s%s />", $this->tagName, $this->renderAttributes());
                }
            };
        }

        return new class($tagName, new Sentinel()) extends ChildNodeBehavior implements Element, ChildNode, ParentNode, Renderable {
            use ParentNodeBehavior;
            use ElementBehavior;

            public function __construct(string $tagName, Sentinel $sentinel)
            {
                $this->setTagName($tagName);
                $this->setSentinel($sentinel);
            }

            public function render(): string
            {
                $renderedChildren = '';
                foreach ($this->children() as $child) {
                    if ($child instanceof Renderable) {
                        $renderedChildren .= $child->render();
                    }
                }
                return sprintf('<%s%s>%s</%s>', $this->tagName, $this->renderAttributes(), $renderedChildren, $this->tagName);
            }
        };
    }

    public static function createText(string $data): Text
    {
        return new Text($data);
    }

    public static function createComment(string $data): Comment
    {
        return new Comment($data);
    }
}
