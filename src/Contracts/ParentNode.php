<?php
namespace CEC\HTML\Contracts;

interface ParentNode
{
    public function append(ChildNode ...$nodes);

    public function prepend(ChildNode ...$nodes);

    public function firstChild(): ?ChildNode;

    public function lastChild(): ?ChildNode;

    public function children(callable $where = null): \Generator;

    public function child(callable $where): ?ChildNode;

    public function descendents(callable $where = null): \Generator;

    public function descendent(callable $where): ?ChildNode;

    public function count(): int;
}
