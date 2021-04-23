<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    private $productsRepository;
    private $categoryRepository;

    public function __construct(ProductRepository $productRepository, CategoryRepository  $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
        $this->productsRepository = $productRepository;
    }

    /**
     * @Route("/", name="home")
     */
    public function home(): Response
    {
        $rootCategories = $this->categoryRepository->listRootCategories();
        $newestProducts = $this->productsRepository->listNewestProducts();

        return $this->render('pages/home.html.twig', [
            'rootCategories' => $rootCategories,
            'newestProducts' => $newestProducts
        ]);
    }
}