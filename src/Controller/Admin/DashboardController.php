<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use App\Entity\GalleryPhoto;
use App\Entity\Product;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

class DashboardController extends AbstractDashboardController
{
    private $translator;

    public function __construct(TranslatorInterface  $translator)
    {
        $this->translator = $translator;
    }

    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        return parent::index();
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle($this->translator->trans('titles.admin'));
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToCrud('menu.products', 'fas fa-th-list', Product::class)->setDefaultSort(['created' => 'DESC']);
        yield MenuItem::linkToCrud('menu.categories', 'fas fa-tags', Category::class)->setDefaultSort(['created' => 'DESC']);
        yield MenuItem::linkToCrud('menu.gallery', 'fas fa-tags', GalleryPhoto::class)->setDefaultSort(['created' => 'DESC']);
    }
}