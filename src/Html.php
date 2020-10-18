<?php
namespace CEC\HTML;

class Html
{
    public static function createElement(string $tagName)
    {
        if (in_array(strtolower($tagName), ['input', 'img', 'hr', 'br', 'meta', 'link', 'area', 'base', 'col', 'embed', 'param', 'source', 'track', 'wbr'])) {
            return VoidElement::create($tagName);
        }

        return Element::create($tagName);
    }

    public static function createText(string $content)
    {
        return Text::create($content);
    }
}
