<?php

namespace App\Controller;

use App\Model\ProductsFilter;
use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use App\Utils\BreadcrumbsHelper;
use App\Utils\PagingHelper;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductsController extends AbstractController
{
    private $productsRepository;
    private $categoryRepository;
    private $pagingHelper;
    private $breadcrumbsHelper;

    public function __construct
    (
        ProductRepository $productRepository,
        CategoryRepository  $categoryRepository,
        PagingHelper $pagingHelper,
        BreadcrumbsHelper $breadcrumbsHelper
    )
    {
        $this->categoryRepository = $categoryRepository;
        $this->productsRepository = $productRepository;
        $this->pagingHelper = $pagingHelper;
        $this->breadcrumbsHelper = $breadcrumbsHelper;
    }

    /**
     * @Route("/products/{page}", name="products", requirements={"page"="\d+"})
     * @Route("/products/{slug}/{page}", name="category products", requirements={"page"="\d+"})
     * @param int $page
     * @param string|null $slug
     * @return Response
     */
    public function products(string $slug = null, int $page = 1): Response
    {
        $filter = $this->setupFilter($slug);
        $paging = $this->pagingHelper->setupPaging($page);

        $products = $this->productsRepository->listProducts($filter, $paging);
        $productsCount = $this->productsRepository->countProducts($filter);

        return $this->render('pages/products.html.twig', [
            'products' => $products,
            'page' => $page,
            'category' => $filter->getCategory(),
            'pagesCount' => ceil($productsCount / $paging->getLimit()),
            'breadcrumbs' => $this->breadcrumbsHelper->getProductsBreadcrumbs($filter->getCategory())
        ]);
    }

    private function setupFilter(string $slug = null): ProductsFilter
    {
        $productsFilter = new ProductsFilter();

        if ($slug) {
            $category = $this->categoryRepository->getCategoryBySlug($slug);
            $productsFilter->setCategory($category);
        }

        return $productsFilter;
    }
}
