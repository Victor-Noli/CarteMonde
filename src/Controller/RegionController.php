<?php

namespace App\Controller;

use App\Entity\Region;
use App\Form\RegionsEx;

use App\Repository\PaysRepository;
use App\Repository\RegionRepository;

use Doctrine\ORM\EntityManagerInterface;
use App\Service\SerializerService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class RegionController extends AbstractController
{
    private SerializerService $serializerService;
    private EntityManagerInterface $em;

    public function __construct(serializerService $serializer, EntityManagerInterface $entityManager)
    {
        $this->serializerService = $serializer;
        $this->em = $entityManager;
    }

    /**
     * @Route("/region", name="region", methods={"GET"})
     * @param RegionRepository $regionRepository
     * @return Response
     */
    public function index(RegionRepository $regionRepository): Response
    {
        return JsonResponse::fromJsonString($this->serializerService->RelationSerializer($regionRepository->findAll(), 'json'));
    }

    /**
     * @Route("/region/new", name="region_new", methods={"POST"})
     * @param PaysRepository $paysRepository
     * @param ValidatorInterface $validator
     * @param Request $request
     * @param EntityManagerInterface $em
     * @return Response
     */
    public function newRegion(PaysRepository $paysRepository, ValidatorInterface $validator, Request $request, EntityManagerInterface $em): Response
    {
        $data = json_decode($request->getContent(), true);

        if ($data) {

            $pays = $paysRepository->findOneBy(['id' => 7]);

            if ($data['nom']) {

                $region = new Region();

                $form = $this->createForm(RegionsEx::class, $region);

                $form->submit($data);

                $validate = $validator->validate($region, null, 'RegisterRegion');

                if (count($validate) !== 0) {
                    foreach ($validate as $error) {
                        return new JsonResponse($error->getMessage(), Response::HTTP_BAD_REQUEST);
                    }
                }

                $region->setPays($pays);

                $this->em->persist($region);

                $this->em->flush();

                return new JsonResponse("Region ajoutee", Response::HTTP_CREATED);

            } else {
                return new JsonResponse("Merci de renseigner les champs correctement", RESPONSE::HTTP_NO_CONTENT);
            }
        } else {
            return new JsonResponse("Merci de renseigner des informations valide", RESPONSE::HTTP_NO_CONTENT);
        }
    }
}


