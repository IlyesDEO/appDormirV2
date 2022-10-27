<?php

namespace App\Controller;

use App\Entity\Lieux;
use Doctrine\ORM\EntityManager;
use App\Repository\LieuxRepository;
use App\Repository\VilleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

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
    #[Route('/api/lieux', name: 'lieux.getAll', methods: ['GET'])]
    public function getAllLieux(Request $request, LieuxRepository $repository, SerializerInterface $serializer): JsonResponse
    {
        $page = $request->get('page', 1);
        $limit = $request->get('limit', 2);
        $limit = $limit > 20 ? 20 : $limit;
        $page = $page < 0 ? 1 : $page;
        $lieux = $repository->findWithPagination($page, $limit);
        //$lieux = $repository->findAll();
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
    public function getLieux(Lieux $lieux, SerializerInterface $serializer): JsonResponse
    {

        $jsonLieux = $serializer->serialize($lieux, 'json');
        return new JsonResponse($jsonLieux, Response::HTTP_OK, ['accept'], true);
    }

    /**
     * Route qui delete un lieu
     */
    #[Route('/api/lieux/{idLieu}', name: 'lieux.delete', methods: ['DELETE'])]
    #[ParamConverter('lieux', options: ['id' => 'idLieu'])]
    public function deleteLieu(Lieux $lieux, EntityManagerInterface $entityManager) : JsonResponse
    {
        $entityManager->remove($lieux);
        $entityManager->flush();
        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }

    /**
     * Route qui met le status a false
     */
    #[Route('/api/lieux/{idLieu}', name: 'lieux.turnOff', methods: ['DELETE'])]
    #[ParamConverter('lieux', options: ['id' => 'idLieu'])]
    public function statusLieu(Lieux $lieux, EntityManagerInterface $entityManager) : JsonResponse
    {
        $lieux->setStatus(false);
        $entityManager->flush();

        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }
    
    /**
     * Route qui crée un lieu
     *
     * @param Request $request
     * @param VilleRepository $villeRepository
     * @param EntityManagerInterface $entityManager
     * @param SerializerInterface $serializer
     * @param UrlGeneratorInterface $urlGenerator
     * @param ValidatorInterface $validator
     * @return JsonResponse
     */
    #[Route('/api/lieux', name: 'lieux.create', methods: ['POST'])]
    #[IsGranted('ADMIN', message: "NO access")]
    public function createLieu(Request $request,VilleRepository $villeRepository, EntityManagerInterface $entityManager, SerializerInterface $serializer, UrlGeneratorInterface $urlGenerator, ValidatorInterface $validator) : JsonResponse
    {

        $lieu = $serializer->deserialize(
            $request->getContent(),
            Lieux::class,
            'json'
        );
        $lieu->setStatus(true);

        $content = $request->toArray();
        $ville = $villeRepository->find($content['idVille'] ?? -1);
        $lieu->setVille($ville);

        $errors = $validator->validate($lieu);
        
        if($errors->count() > 0){
            return new JsonResponse($serializer->serialize($errors, 'json'), JsonResponse::HTTP_BAD_REQUEST, [], true);
        }

        $entityManager->persist($lieu);
        $entityManager->flush();

        $jsonLieux = $serializer->serialize($lieu, 'json', ['groups' => 'getLieux']);

        $location = $urlGenerator->generate('lieux.get', ['idLieux' => $lieu->getId()]);
        return new JsonResponse($jsonLieux, Response::HTTP_CREATED, ['location' => $location], "json", true); 
    }

    /**
     * Route qui update un lieu
     *
     * @param Lieux $lieux
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @param SerializerInterface $serializer
     * @param UrlGeneratorInterface $urlGenerator
     * @return JsonResponse
     */
    #[Route('/api/lieux', name: 'lieux.update', methods: ['PUT'])]
    #[ParamConverter('lieux', options: ['id' => 'idLieu'])]
    public function updateLieu(Lieux $lieux, Request $request, EntityManagerInterface $entityManager, SerializerInterface $serializer, UrlGeneratorInterface $urlGenerator) : JsonResponse
    {

        $updateLieu = $serializer->deserialize(
            $request->getContent(),
            Lieux::class,
            'json',
            [AbstractNormalizer::OBJECT_TO_POPULATE => $lieux]
        );
        $updateLieu->setStatus(true);
        
        $lieu = new Lieux();
        $lieu->setStatus(true);
        $entityManager->persist($lieu);
        $entityManager->flush();
        
        
        $jsonLieux = $serializer->serialize($lieu, 'json', ['groups' => 'getLieux']);

        $location = $urlGenerator->generate('lieux.get', ['idLieux' => $lieux->getId()]);
        return new JsonResponse($jsonLieux, Response::HTTP_CREATED, ['location' => $location], "json", true);
    }

    #[Route('/api/noteLieu', name: 'noteLieu.update', methods: ['PUT'])]
    #[ParamConverter('lieux', options: ['id' => 'idLieu'])]
    public function updateNoteLieu(Lieux $lieux, Request $request, EntityManagerInterface $entityManager, SerializerInterface $serializer, UrlGeneratorInterface $urlGenerator) : JsonResponse
    {

        $updateLieu = $serializer->deserialize(
            $request->getContent(),
            Lieux::class,
            'json',
            [AbstractNormalizer::OBJECT_TO_POPULATE => $lieux]
        );
        $updateLieu->setStatus(true);
        
        $lieu = new Lieux();
        $lieu->setStatus(true);
        $entityManager->persist($lieu);
        $entityManager->flush();
        
        
        $jsonLieux = $serializer->serialize($lieu, 'json', ['groups' => 'getLieux']);

        $location = $urlGenerator->generate('lieux.get', ['idLieux' => $lieux->getId()]);
        return new JsonResponse($jsonLieux, Response::HTTP_CREATED, ['location' => $location], "json", true);
    }
}
