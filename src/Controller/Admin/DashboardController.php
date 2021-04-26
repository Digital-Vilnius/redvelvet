<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use App\Entity\GalleryPhoto;
use App\Entity\Product;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\CrudUrlGenerator;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

class DashboardController extends AbstractDashboardController
{
    private $translator;
    private $crudUrlGenerator;

    public function __construct(TranslatorInterface  $translator, CrudUrlGenerator $crudUrlGenerator)
    {
        $this->translator = $translator;
        $this->crudUrlGenerator = $crudUrlGenerator;
    }

    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        $url = $this->crudUrlGenerator
            ->build()
            ->setController(ProductController::class)
            ->setAction(Action::INDEX)
            ->set('menuIndex', 0)
            ->generateUrl();

        return new RedirectResponse($url);
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle($this->translator->trans('titles.admin'));
    }

    public function configureMenuItems(): array
    {
        return [
            MenuItem::linkToCrud('menu.products', 'fas fa-th-list', Product::class)->setDefaultSort(['created' => 'DESC']),
            MenuItem::linkToCrud('menu.categories', 'fas fa-tags', Category::class)->setDefaultSort(['created' => 'DESC']),
            MenuItem::linkToCrud('menu.gallery', 'fas fa-tags', GalleryPhoto::class)->setDefaultSort(['created' => 'DESC'])
        ];
    }
}