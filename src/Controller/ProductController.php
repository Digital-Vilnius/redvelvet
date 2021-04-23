<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use App\Utils\BreadcrumbsHelper;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    private $breadcrumbsHelper;
    private $productRepository;

    public function __construct(BreadcrumbsHelper $breadcrumbsHelper, ProductRepository  $productRepository)
    {
        $this->breadcrumbsHelper = $breadcrumbsHelper;
        $this->productRepository = $productRepository;
    }

    /**
     * @Route("/product/{slug}", name="product")
     * @Entity("product", expr="repository.getProductBySlug(slug)")
     * @param Product $product
     * @return Response
     */
    public function product(Product $product): Response
    {
        return $this->render('pages/product.html.twig', [
            'product' => $product,
            'relatedProducts' => $this->productRepository->getRelatedProducts($product),
            'breadcrumbs' => $this->breadcrumbsHelper->getProductBreadcrumbs($product)
        ]);
    }
}