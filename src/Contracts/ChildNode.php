<?php
namespace CEC\HTML\Contracts;

interface ChildNode
{
    public function previousSibling();

    public function nextSibling();

    public function siblings(callable $where = null);

    public function sibling(callable $where);

    public function root();

    public function ancestors(callable $where = null);

    public function ancestor(callable $where);

    public function remove();

    public function insertBefore(ChildNode ...$nodes);

    public function insertAfter(ChildNode ...$nodes);

    public function replaceWith(ChildNode ...$nodes);
}
