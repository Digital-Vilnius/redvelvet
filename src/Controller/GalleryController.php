<?php

namespace App\Controller;

use App\Repository\PhotoRepository;
use App\Utils\PagingHelper;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

class GalleryController extends AbstractController
{
    private $galleryRepository;
    private $translator;
    private $pagingHelper;

    public function __construct(TranslatorInterface $translator, PhotoRepository $galleryRepository, PagingHelper $pagingHelper)
    {
        $this->galleryRepository = $galleryRepository;
        $this->translator = $translator;
        $this->pagingHelper = $pagingHelper;
    }

    /**
     * @Route("/gallery/{page}", name="gallery", requirements={"page"="\d+"})
     * @param int $page
     * @return Response
     */
    public function gallery(int $page = 1): Response
    {
        $paging = $this->pagingHelper->setupPaging($page);

        $photos = $this->galleryRepository->listPhotos($paging);
        $photosCount = $this->galleryRepository->countPhotos();

        return $this->render('pages/gallery.html.twig', [
            'photos' => $photos,
            'page' => $page,
            'pagesCount' => ceil($photosCount / $paging->getLimit()),
            'breadcrumbs' => [
                ['link' => $this->generateUrl('home'), 'title' => $this->translator->trans('titles.home')],
                ['title' => $this->translator->trans('titles.gallery')]
            ]
        ]);
    }
}