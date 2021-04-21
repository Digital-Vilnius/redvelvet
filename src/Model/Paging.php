<?php

namespace App\Model;

use Symfony\Component\Validator\Constraints as Assert;

class Paging
{
    /**
     * @Assert\GreaterThan(value = 0)
     * @Assert\LessThan(value = 21)
     * @Assert\Regex(pattern="/^[0-9]\d*$/")
     */
    private $limit;

    /**
     * @Assert\Regex(pattern="/^[0-9]\d*$/")
     */
    private $offset;

    public function __construct($limit, $offset)
    {
        $this->limit = $limit;
        $this->offset = $offset;
    }

    public function getLimit()
    {
        return $this->limit;
    }

    public function setLimit($limit)
    {
        $this->limit = $limit;
    }

    public function getOffset()
    {
        return $this->offset;
    }

    public function setOffset($offset)
    {
        $this->offset = $offset;
    }
}