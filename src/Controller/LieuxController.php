<?php

namespace App\Controller;

use App\Entity\Lieux;
use App\Repository\LieuxRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class LieuxController extends AbstractController
{
    #[Route('/lieux', name: 'app_lieux')]
    public function index(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/LieuxController.php',
        ]);
    }
    /**
     * Route qui renvoit tout les cours 
     *
     * @param LieuxRepository $respository
     * @param SerializerInterface $serializer
     * @return JsonResponse
     */
    #[Route('/api/lieux', name: 'lieux.getAll')]
    public function getAllLieux(LieuxRepository $respository, SerializerInterface $serializer): JsonResponse
    {

        $lieux = $respository->findAll();
        $jsonLieux = $serializer->serialize($lieux, 'json', ["groups" => "getAllLieux"]);
        return new JsonResponse($jsonLieux, Response::HTTP_OK, [], true);
    }

    /*
/**
 * Route qui renvoi tout les cours 
 *
 * @param LieuxRepository $respository
 * @param SerializerInterface $serializer
 * @return JsonResponse


    #[Route('/api/lieux/{id}', name: 'lieux.get', methods : ['GET'])]
    public function getLieux(int $id,LieuxRepository $respository,SerializerInterface $serializer): JsonResponse
    {
        
         $lieux = $respository->find($id);
         $jsonLieux = $serializer->serialize($lieux,'json');
         return $lieux?
         new JsonResponse($jsonLieux, Response::HTTP_OK, [], true):
         new JsonResponse(null,Response::HTTP_NOT_FOUND);
            
        
    }
*/

    /**
     * Route qui renvoit un lieu 
     *
     * @param LieuxRepository $respository
     * @param SerializerInterface $serializer
     * @return JsonResponse
     */
    #[Route('/api/lieux/{idLieu}', name: 'lieux.get', methods: ['GET'])]
    #[ParamConverter('lieux', options: ['id' => 'idLieu'])]
    public function getLieux(Lieux $lieux, LieuxRepository $respository, SerializerInterface $serializer): JsonResponse
    {

        $jsonLieux = $serializer->serialize($lieux, 'json');
        return new JsonResponse($jsonLieux, Response::HTTP_OK, ['accept'], true);
    }

    #[Route('/api/lieux/{idLieu}', name: 'lieux.delete', methods: ['DELETE'])]
    #[ParamConverter('lieux', options: ['id' => 'idLieu'])]
    public function deleteLieu(Lieux $lieux, EntityManagerInterface $entityManager) : JsonResponse
    {
        $entityManager->remove($lieux);
        $entityManager->flush();
        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }
}
