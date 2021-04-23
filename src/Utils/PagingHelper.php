<?php

namespace App\Utils;

use App\Model\Paging;

class PagingHelper
{
    public function setupPaging(int $page = 1): Paging
    {
        $limit = 20;
        return new Paging($limit, ($page - 1) * $limit);
    }
}