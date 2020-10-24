<?php
namespace CEC\HTML\Contracts;

interface ParentNode
{
    public function firstChild(): ?ChildNode;

    public function lastChild(): ?ChildNode;

    public function children(callable $where = null): \Generator;

    public function child(callable $where = null): ?ChildNode;

    public function descendents(callable $where = null): \Generator;

    public function descendent(callable $where = null): ?ChildNode;

    public function count(): int;

    public function append(ChildNode ...$nodes);

    public function prepend(ChildNode ...$nodes);
}
