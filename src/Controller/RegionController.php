<?php

namespace App\Controller;

use App\Entity\Regions;
use App\Form\RegionsEx;

use App\Repository\CountryRepository;
use App\Repository\RegionsRepository;

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
     * @param RegionsRepository $regionsRepository
     * @return Response
     */
    public function index(RegionsRepository $regionsRepository): Response
    {
        return $this->render('region/index.html.twig', [
            'controller_name' => 'RegionsController',
        ]);
    }

    /**
     * @Route("/region/new", name="region_new", methods={"POST"})
     * @param CountryRepository $countryRepository
     * @param ValidatorInterface $validator
     * @param Request $request
     * @param EntityManagerInterface $em
     * @return Response
     */
    public function newRegion(CountryRepository $countryRepository, ValidatorInterface $validator, Request $request, EntityManagerInterface $em): Response
    {
        $data = json_decode($request->getContent(), true);

        if ($data) {

            $pays = $countryRepository->findOneBy(['id' => 7]);

            if ($data['nom']) {

                $region = new Regions();

                $form = $this->createForm(RegionsEx::class, $region);

                $form->submit($data);

                $validate = $validator->validate($region, null, 'RegisterRegions');

                if (count($validate) !== 0) {
                    foreach ($validate as $error) {
                        return new JsonResponse($error->getMessage(), Response::HTTP_BAD_REQUEST);
                    }
                }

                $region->setCountry($pays);

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


