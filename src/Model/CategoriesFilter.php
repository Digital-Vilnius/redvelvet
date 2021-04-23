<?php

namespace App\Model;

class CategoriesFilter
{
    private $parent;

    public function getParent()
    {
        return $this->parent;
    }

    public function setParent($parent): void
    {
        $this->parent = $parent;
    }
}