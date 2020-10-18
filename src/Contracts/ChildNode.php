<?php
namespace CEC\HTML\Contracts;

interface ChildNode
{
    public function previousSibling();

    public function nextSibling();

    public function remove();

    public function insertBefore(ChildNode ...$nodes);

    public function insertAfter(ChildNode ...$nodes);

    public function replaceWith(ChildNode ...$nodes);
}
