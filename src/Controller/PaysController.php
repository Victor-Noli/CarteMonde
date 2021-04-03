<?php

namespace App\Controller;

use App\Entity\Pays;
use App\Entity\Continent;
use App\Entity\Region;
use App\Form\CountryEx;
use App\Repository\ContinentRepository;
use App\Repository\PaysRepository;
use App\Repository\RegionRepository;
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
     * @param PaysRepository $paysRepository
     * @return Response
     */
    public function index(PaysRepository $paysRepository): Response
    {
        return JsonResponse::fromJsonString($this->serializerService->RelationSerializer($paysRepository->findAll(), 'json'));
    }

    /**
     * @Route("/pays/new", name="pays_new", methods={"POST"})
     * @param Request $request
     * @param ContinentRepository $continentRepository
     * @param EntityManagerInterface $em
     * @param ValidatorInterface $validator
     * @return Response
     */

    public function newPays(Request $request, ContinentRepository $continentRepository, EntityManagerInterface $em, ValidatorInterface $validator): Response
    {
        $data = json_decode($request->getContent(), true);

        if ($data) {

            $continents = $continentRepository->findOneBy(['id']);
            if ($data['country']) {
                $pays = new Pays();

                $form = $this->createForm(CountryEx::class, $pays);

                $form->submit($data);

                $validate = $validator->validate($pays, null, 'RegisterPays');
                if (count($validate) !== 0) {
                    foreach ($validate as $error) {
                        return new JsonResponse($error->getMessage(), Response::HTTP_BAD_REQUEST);
                    }
                }

                $pays->setContinent($continents);

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
