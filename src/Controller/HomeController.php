<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    private $productsRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productsRepository = $productRepository;
    }

    /**
     * @Route("/", name="home")
     */
    public function home()
    {
        $products = $this->productsRepository->findAll();

        return $this->render('pages/home.html.twig');
    }
}