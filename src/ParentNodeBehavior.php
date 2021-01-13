<?php
namespace CEC\HTML;

use CEC\HTML\Contracts\ChildNode;
use CEC\HTML\Contracts\ParentNode;

trait ParentNodeBehavior
{
    protected $sentinel;

    public function setSentinel(Sentinel $sentinel)
    {
        $this->sentinel = $sentinel;
        $this->sentinel->setParent($this);
    }

    public function append(ChildNode ...$nodes): ParentNode
    {
        $this->sentinel->addBefore(...$nodes);
        return $this;
    }

    public function prepend(ChildNode ...$nodes): ParentNode
    {
        $this->sentinel->addAfter(...$nodes);
        return $this;
    }

    public function firstChild(): ?ChildNode
    {
        return $this->sentinel->nextSibling();
    }

    public function lastChild(): ?ChildNode
    {
        return $this->sentinel->previousSibling();
    }

    public function children(callable $where = null): \Generator
    {
        $next = $this->firstChild();
        while ($next) {
            if ($where === null || $where($next)) {
                yield $next;
            }
            $next = $next->nextSibling();
        }
    }

    public function child(callable $where = null): ?ChildNode
    {
        foreach ($this->children($where) as $child) {
            return $child;
        }
        return null;
    }

    public function descendents(callable $where = null): \Generator
    {
        $next = $this->firstChild();
        while ($next) {
            if ($where === null || $where($next)) {
                yield $next;
            }

            if ($next instanceof ParentNode) {
                foreach ($next->descendents($where) as $descendent) {
                    yield $descendent;
                }
            }

            $next = $next->nextSibling();
        }
    }

    public function descendent(callable $where = null): ?ChildNode
    {
        foreach ($this->descendents($where) as $descendent) {
            return $descendent;
        }
        return null;
    }

    public function count(): int
    {
        $count = 0;
        $next = $this->firstChild();
        while ($next) {
            $count++;
            $next = $next->nextSibling();
        }

        return $count;
    }
}
