<?php

namespace App\Controller;

use App\Entity\Lieux;
use App\Entity\Notes;
use App\Entity\User;
use Doctrine\ORM\EntityManager;
use App\Repository\LieuxRepository;
use App\Repository\NotesRepository;
use App\Repository\VilleRepository;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use JMS\Serializer\SerializerInterface;
use JMS\Serializer\Serializer;
use JMS\Serializer\SerializationContext;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Contracts\Cache\ItemInterface;
use Symfony\Contracts\Cache\TagAwareCacheInterface;

class NotesController extends AbstractController
{
    /**
     * Route qui crée une note pour le user connecté sur un lieu
     */
    #[Route('/api/noteLieu', name: 'noteLieu.create', methods: ['POST'])]
    public function createNote(Request $request,NotesRepository $noteRepository,LieuxRepository $lieuxRepository, EntityManagerInterface $entityManager, SerializerInterface $serializer, UrlGeneratorInterface $urlGenerator, ValidatorInterface $validator) : JsonResponse
    {

        $note = $serializer->deserialize(
            $request->getContent(),
            Lieux::class,
            'json'
        );

        $content = $request->toArray();
        $lieu = $lieuxRepository->find($content['idLieux'] ?? -1);
        $user = $noteRepository->find($content['idUser'] ?? -1);
        $note->setLieux($lieu);
        $note->setUser($user);

        $errors = $validator->validate($note);
        
        if($errors->count() > 0){
            return new JsonResponse($serializer->serialize($errors, 'json'), JsonResponse::HTTP_BAD_REQUEST, [], true);
        }

        $entityManager->persist($note);
        $entityManager->flush();

        $context = SerializationContext::create();
        $jsonNote = $serializer->serialize($note, 'json',$context);

        $location = $urlGenerator->generate('lieux.get', ['idLieux' => $lieu->getId()]);
        return new JsonResponse($jsonNote, Response::HTTP_CREATED, ['location' => $location], "json", true); 
    }
}