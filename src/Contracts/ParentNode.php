<?php
namespace CEC\HTML\Contracts;

interface ParentNode
{
    public function append(ChildNode ...$nodes);

    public function prepend(ChildNode ...$nodes);

    public function firstChild();

    public function lastChild();

    public function children(callable $where = null): \Generator;

    public function child(callable $where);

    public function descendents(callable $where = null): \Generator;

    public function descendent(callable $where);

    public function count();
}
