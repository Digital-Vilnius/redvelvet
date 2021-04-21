<?php

namespace App\Utils;

use App\Model\Paging;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class PagingHelper
{
    private $validator;

    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    public function setupPaging(Request  $request)
    {
        $limit = $request->query->get('limit');
        $offset = $request->query->get('offset');

        if ($limit && $offset) {
            $paging = new Paging($limit, $offset);
            $errors = $this->validator->validate($paging);
            if (count($errors) === 0) return $paging;
        }

        $page = $request->attributes->get('page');
        if (!$page) $page = 1;

        $limit = 20;
        $paging = new Paging($limit, ($page - 1) * $limit);
        $errors = $this->validator->validate($paging);
        if (count($errors) === 0) return $paging;
    }
}