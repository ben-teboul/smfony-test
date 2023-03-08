<?php

namespace App\Controller;

use App\Repository\PicturesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    #[Route('/picture-of-day', name: 'app_picture_of_day')]
    public function index(PicturesRepository $picturesRepository): Response
    {
        $picture = $picturesRepository->findPictureOfTheDay();
        return $this->render('index/index.html.twig', [
            'controller_name' => 'IndexController',
            'picture' => $picture,
        ]);
    }
}
