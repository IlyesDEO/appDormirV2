<?php

namespace App\Controller;

use App\Entity\Picture;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class PictureController extends AbstractController
{
    #[Route('/picture', name: 'app_picture')]
    public function index(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/PictureController.php',
        ]);
    }


    #[Route('api/picture', name: 'picture.create', methods:['POST'])]
    public function createPicture(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
       $picture = new Picture();
       $files = $request->files->get('file');

       $picture->setfile($files)
       ->setMimeType($files->getClientMimeType())
       ->setRealName($files->getClientOriginalName())
       ->setPublicPath('/assets/pictures')
       ->setStatus(true)
       ->setUploadDate(new \DateTime());


       $entityManager->persist($picture);
       $entityManager->flush();
       
    }
    
}
