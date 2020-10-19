<?php
namespace CEC\HTML;

use \CEC\HTML\Sentinel;
use \CEC\HTML\Contracts\ChildNode;

abstract class ChildNodeBehavior
{
    protected $previous;

    protected $next;

    protected $parent;

    public function parent()
    {
        return $this->parent;
    }

    public function previousSibling()
    {
        if (is_null($this->parent)) {
            return null;
        }
        return ($this->previous instanceof Sentinel) ? null : $this->previous;
    }

    public function nextSibling()
    {
        if (is_null($this->parent)) {
            return null;
        }
        return ($this->next instanceof Sentinel) ? null : $this->next;
    }

    public function siblings(callable $where = null): \Generator
    {
        if (is_null($this->parent)) {
            return;
        }

        foreach ($this->parent->children() as $child) {
            if ($child === $this) {
                continue;
            }
            if ($where === null || $where($child)) {
                yield $child;
            }
        }
    }

    public function sibling(callable $where)
    {
        foreach ($this->siblings($where) as $sibling) {
            return $sibling;
        }

        return null;
    }

    public function root()
    {
        $p = $this;
        while ($p->parent) {
            $p = $p->parent;
        }
        return $p;
    }

    public function ancestors(callable $where = null): \Generator
    {
        $p = $this;
        while ($p->parent) {
            $p = $p->parent;
            if ($where === null || $where($p)) {
                yield $p;
            }
        }
    }

    public function ancestor(callable $where)
    {
        foreach ($this->ancestors($where) as $ancestor) {
            return $ancestor;
        }

        return null;
    }

    public function remove()
    {
        if (is_null($this->parent)) {
            return;
        }

        $this->parent = null;
        if ($this->next instanceof ChildNode) {
            $this->next->previous = $this->previous;
            $this->next = null;
        }
        if ($this->previous instanceof ChildNode) {
            $this->previous->next = $this->next;
            $this->previous = null;
        }
    }

    public function insertBefore(ChildNode ...$nodes)
    {
        if (is_null($this->parent)) {
            return;
        }

        while ($node = array_shift($nodes)) {
            $node->remove();
            $node->previous = $this->previous;
            $this->previous = $node;
            $node->next = $this;
            $node->previous->next = $node;
            $node->parent = $this->parent;
        }
    }

    public function insertAfter(ChildNode ...$nodes)
    {
        if (is_null($this->parent)) {
            return null;
        }

        while ($node = array_pop($nodes)) {
            $node->remove();
            $node->next = $this->next;
            $this->next = $node;
            $node->previous = $this;
            $node->next->previous = $node;
            $node->parent = $this->parent;
        }
    }

    public function replaceWith(ChildNode ...$nodes)
    {
        $this->insertAfter(...$nodes);
        $this->remove();
    }
}
