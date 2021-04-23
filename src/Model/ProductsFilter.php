<?php

namespace App\Model;

class ProductsFilter
{
    private $category;

    public function getCategory()
    {
        return $this->category;
    }

    public function setCategory($category): void
    {
        $this->category = $category;
    }
}