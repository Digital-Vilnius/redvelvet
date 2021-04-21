<?php

namespace App\Controller;

use App\Entity\Product;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    /**
     * @Route("/product/{id}", name="product", requirements={"id"="\d+"})
     * @Entity("product", expr="repository.find(id)")
     * @param Product $product
     * @return Response
     */
    public function product(Product $product): Response
    {
        return $this->render('pages/product.html.twig', [
            'product' => $product,
        ]);
    }
}