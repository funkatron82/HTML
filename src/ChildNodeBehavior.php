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
        if (!($this->parent instanceof ParentNode)) {
            return null;
        }
        return ($this->previous instanceof Sentinel) ? null : $this->previous;
    }

    public function nextSibling(): ?ChildNode
    {
        if (!($this->parent instanceof ParentNode)) {
            return null;
        }
        return ($this->next instanceof Sentinel) ? null : $this->next;
    }

    public function siblings(callable $where = null): \Generator
    {
        if (!($this->parent instanceof ParentNode)) {
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

    public function sibling(callable $where = null): ?ChildNode
    {
        foreach ($this->siblings($where) as $sibling) {
            return $sibling;
        }

        return null;
    }

    public function root(): ParentNode
    {
        $root = $this;
        while ($root instanceof ChildNode && $root->parent) {
            $root = $root->parent;
        }
        return $root;
    }

    public function ancestors(callable $where = null): \Generator
    {
        $parent = $this->parent;
        while ($parent instanceof ChildNode) {
            if ($where === null || $where($p)) {
                yield $parent;
            }
            $parent = $parent->parent;
        }
    }

    public function ancestor(callable $where = null): ?ParentNode
    {
        foreach ($this->ancestors($where) as $ancestor) {
            return $ancestor;
        }

        return null;
    }

    public function remove()
    {
        if (!($this->parent instanceof ParentNode)) {
            return;
        }

        $this->next->previous = $this->previous;
        $this->previous->next = $this->next;

        $this->parent = null;
        $this->next = null;
        $this->previous = null;
    }

    public function addBefore(ChildNode ...$nodes): ChildNode
    {
        if (!($this->parent instanceof ParentNode)) {
            return $this;
        }

        while ($node = array_shift($nodes)) {
            $node->remove();
            $node->previous = $this->previous;
            $this->previous = $node;
            $node->next = $this;
            $node->previous->next = $node;
            $node->parent = $this->parent;
        }

        return $this;
    }

    public function addAfter(ChildNode ...$nodes): ChildNode
    {
        if (!($this->parent instanceof ParentNode)) {
            return $this;
        }

        while ($node = array_pop($nodes)) {
            $node->remove();
            $node->next = $this->next;
            $this->next = $node;
            $node->previous = $this;
            $node->next->previous = $node;
            $node->parent = $this->parent;
        }

        return $this;
    }

    public function replaceWith(ChildNode ...$nodes)
    {
        $this->addAfter(...$nodes);
        $this->remove();
    }
}
