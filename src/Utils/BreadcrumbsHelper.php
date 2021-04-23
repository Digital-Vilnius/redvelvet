<?php

namespace App\Utils;

use App\Entity\Category;
use App\Entity\Product;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

class BreadcrumbsHelper
{
    private $translator;
    private $router;

    public function __construct(TranslatorInterface $translator, RouterInterface $router)
    {
        $this->router = $router;
        $this->translator = $translator;
    }

    public function getProductBreadcrumbs(Product $product): array
    {
        $breadcrumbs = [[
            'link' => $this->router->generate('products'),
            'title' => $this->translator->trans('breadcrumbs.products')
        ]];

        foreach ($product->getCategory()->getAscendants() as $ascendant) {
            $breadcrumbs[] = [
                'link' => $this->router->generate('category products', ['slug' => $ascendant->getSlug()]),
                'title' => $ascendant
            ];
        }

        $breadcrumbs[] = [
            'link' => $this->router->generate('category products', ['slug' => $product->getCategory()->getSlug()]),
            'title' => $product->getCategory()
        ];

        $breadcrumbs[] = [
            'title' => $product
        ];

        return $breadcrumbs;
    }

    public function getProductsBreadcrumbs(Category $category = null): array
    {
        $breadcrumbs = [];

        if ($category) {
            $breadcrumbs[] = [
                'link' => $this->router->generate('products'),
                'title' => $this->translator->trans('breadcrumbs.products')
            ];

            foreach ($category->getAscendants() as $ascendant) {
                $breadcrumbs[] = [
                    'link' => $this->router->generate('category products', ['slug' => $ascendant->getSlug()]),
                    'title' => $ascendant
                ];
            }

            $breadcrumbs[] = ['title' => $category];
            return $breadcrumbs;
        }

        $breadcrumbs[] = ['title' => $this->translator->trans('breadcrumbs.products')];
        return $breadcrumbs;
    }
}