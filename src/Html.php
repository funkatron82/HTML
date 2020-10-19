<?php
namespace CEC\HTML;

use CEC\HTML\Contracts\Renderable;
use CEC\HTML\Contracts\ChildNode;
use CEC\HTML\Contracts\ParentNode;
use CEC\HTML\Contracts\Element;

class Html
{
    public static function createElement(string $tagName)
    {
        if (in_array(strtolower($tagName), ['input', 'img', 'hr', 'br', 'meta', 'link', 'area', 'base', 'col', 'embed', 'param', 'source', 'track', 'wbr'])) {
            return new class($tagName) extends ChildNodeBehavior implements Element, ChildNode, Renderable {
                use ElementBehavior;

                public function __construct(string $tagName)
                {
                    $this->setTagName($tagName);
                }

                public function render()
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

            public static function create(string $tagName)
            {
                return new Element($tagName, new Sentinel());
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
                    if ($child instanceof Renderable) {
                        $output .= $child->render();
                    }
                }

                return $output;
            }

            public function render()
            {
                return sprintf('%s%s%s', $this->renderOpenTag(), $this->renderChildren(), $this->renderCloseTag());
            }
        };
    }

    public static function createText(string $content)
    {
        return Text::create($content);
    }
}
