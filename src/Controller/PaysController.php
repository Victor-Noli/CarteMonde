<?php

namespace App\Controller;

use App\Entity\Country;
use App\Entity\Continents;
use App\Entity\Regions;
use App\Form\CountryEx;
use App\Repository\ContinentsRepository;
use App\Repository\CountryRepository;
use App\Repository\RegionsRepository;
use App\Service\SerializerService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class PaysController extends AbstractController
{
    private SerializerService $serializerService;
    private EntityManagerInterface $em;

    public function __construct(serializerService $serializer, EntityManagerInterface $entityManager)
    {
        $this->serializerService = $serializer;
        $this->em = $entityManager;
    }

    /**
     * @Route("/pays", name="pays", methods={"GET"})
     * @param CountryRepository $countryRepository
     * @return Response
     */
    public function index(CountryRepository $countryRepository): Response
    {
        return $this->render('pays/index.html.twig', [
            'controller_name' => 'CountryController',
        ]);
    }

    /**
     * @Route("/pays/new", name="pays_new", methods={"POST"})
     * @param Request $request
     * @param ContinentsRepository $continentsRepository
     * @param EntityManagerInterface $em
     * @param ValidatorInterface $validator
     * @return Response
     */

    public function newPays(Request $request, ContinentsRepository $continentsRepository, EntityManagerInterface $em, ValidatorInterface $validator): Response
    {
        $data = json_decode($request->getContent(), true);

        if ($data) {

            $continents = $continentsRepository->findOneBy(['id']);
            if ($data['nom']) {
                $pays = new Country();

                $form = $this->createForm(CountryEx::class, $pays);

                $form->submit($data);

                $validate = $validator->validate($pays, null, 'RegisterCountry');
                if (count($validate) !== 0) {
                    foreach ($validate as $error) {
                        return new JsonResponse($error->getMessage(), Response::HTTP_BAD_REQUEST);
                    }
                }

                $pays->setContinents($continents);

                $this->em->persist($pays);
                $this->em->flush();

                return new JsonResponse("Pays ajoute", Response::HTTP_CREATED);


            } else {
                return new JsonResponse("Merci de renseigner les champs correctement", RESPONSE::HTTP_NO_CONTENT);
            }
        } else {
            return new JsonResponse("Merci de renseigner les champs correctement", RESPONSE::HTTP_NO_CONTENT);
        }
    }
}
