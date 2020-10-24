<?php
namespace CEC\HTML\Contracts;

interface ChildNode
{
    public function parent(): ?ParentNode;

    public function previousSibling(): ?ChildNode;

    public function nextSibling(): ?ChildNode;

    public function siblings(callable $where = null): \Generator;

    public function sibling(callable $where = null): ?ChildNode;

    public function ancestors(callable $where = null): \Generator;

    public function ancestor(callable $where = null): ?ParentNode;

    public function root(): ParentNode;

    public function remove();

    public function addBefore(ChildNode ...$nodes);

    public function addAfter(ChildNode ...$nodes);

    public function replaceWith(ChildNode ...$nodes);
}
