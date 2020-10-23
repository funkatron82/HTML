<?php
namespace CEC\HTML;

use \CEC\HTML\Sentinel;
use \CEC\HTML\Contracts\ChildNode;
use \CEC\HTML\Contracts\ParentNode;

abstract class ChildNodeBehavior
{
    protected $previous;

    protected $next;

    protected $parent;

    public function parent(): ?ParentNode
    {
        return $this->parent;
    }

    public function previousSibling(): ?ChildNode
    {
        if (is_null($this->parent)) {
            return null;
        }
        return ($this->previous instanceof Sentinel) ? null : $this->previous;
    }

    public function nextSibling(): ?ChildNode
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

    public function sibling(callable $where): ?ChildNode
    {
        foreach ($this->siblings($where) as $sibling) {
            return $sibling;
        }

        return null;
    }

    public function root(): ParentNode
    {
        $root = $this;
        while ($root->parent) {
            $root = $root->parent;
        }
        return $root;
    }

    public function ancestors(callable $where = null): \Generator
    {
        $parent = $this;
        while ($parent->parent) {
            $parent = $parent->parent;
            if ($where === null || $where($p)) {
                yield $parent;
            }
        }
    }

    public function ancestor(callable $where): ?ParentNode
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

    public function addBefore(ChildNode ...$nodes)
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

    public function addAfter(ChildNode ...$nodes)
    {
        if (is_null($this->parent)) {
            return;
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
        $this->addAfter(...$nodes);
        $this->remove();
    }
}
