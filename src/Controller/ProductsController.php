<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use App\Utils\PagingHelper;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductsController extends AbstractController
{
    private $productsRepository;
    private $pagingHelper;

    public function __construct(ProductRepository $productRepository, PagingHelper $pagingHelper)
    {
        $this->productsRepository = $productRepository;
        $this->pagingHelper = $pagingHelper;
    }

    /**
     * @Route("/products/{page}", name="products", requirements={"page"="\d+"})
     * @param Request $request
     * @param int $page
     * @return Response
     */
    public function products(Request $request, int $page = 1): Response
    {
        $paging = $this->pagingHelper->setupPaging($request);

        $products = $this->productsRepository->findProducts($paging);
        $productsCount = $this->productsRepository->count([]);

        return $this->render('pages/products.html.twig', [
            'products' => $products,
            'page' => $page,
            'pagesCount' => ceil($productsCount / $paging->getLimit()),
        ]);
    }
}
