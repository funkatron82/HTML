<?php
namespace CEC\HTML;

use \CEC\HTML\Sentinel;
use \CEC\HTML\Contracts\ChildNode;

trait ParentNodeBehavior
{
    protected $sentinel;

    public function setSentinel(Sentinel $sentinel)
    {
        $this->sentinel = $sentinel;
        $this->sentinel->parent = $this;
    }

    public function append(ChildNode ...$nodes)
    {
        $this->sentinel->insertBefore(...$nodes);
    }

    public function prepend(ChildNode ...$nodes)
    {
        $this->sentinel->insertAfter(...$nodes);
    }

    public function firstChild()
    {
        return $this->sentinel->nextSibling() ;
    }

    public function lastChild()
    {
        return $this->sentinel->previousSibling() ;
    }

    public function children(callable $where = null)
    {
        $next = $this->firstChild();
        while ($next) {
            if ($where === null || $where($next)) {
                yield $next;
            }
            $next = $next->nextSibling();
        }
    }

    public function child(callable $where)
    {
        foreach ($this->children($where) as $child) {
            return $child;
        }
        return null;
    }

    public function descendents(callable $where = null)
    {
        $next = $this->firstChild();
        while ($next) {
            if ($where === null || $where($next)) {
                yield $next;
            }
            foreach ($next->descendents($where) as $d) {
                yield $d;
            }
            $next = $next->nextSibling();
        }
    }

    public function descendent(callable $where)
    {
        foreach ($this->descendents($where) as $descendent) {
            return $descendent;
        }
        return null;
    }

    public function count()
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
