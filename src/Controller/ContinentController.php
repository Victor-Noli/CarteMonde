<?php

namespace App\Controller;

use App\Entity\Continents;
use App\Form\ContinentEx;
use App\Repository\ContinentsRepository;

use Doctrine\ORM\EntityManagerInterface;
use App\Service\SerializerService;
use PhpParser\Node\Scalar\String_;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;
class ContinentController extends AbstractController
{
    private SerializerService $serializerService;
    private EntityManagerInterface $em;

    public function __construct(serializerService $serializer, EntityManagerInterface $entityManager)
    {
        $this->serializerService = $serializer;
        $this->em = $entityManager;
    }

    /**
     * @Route("/continent", name="continent", methods={"GET"})
     * @param ContinentsRepository $continentsRepository
     * @return  Response
     */
    public function index(ContinentsRepository $continentsRepository): Response
    {
        return $this->render('continent/index.html.twig', [
            'controller_name' => 'ContinentController',
        ]);
    }

    /**
     * @Route("/continent/new", name="continent_new", methods={"POST"})
     * @param Request $request
     * @param ValidatorInterface $validator
     * @param EntityManagerInterface $em
     * @return Response
     */
    public function newContinent(Request $request, ValidatorInterface $validator, EntityManagerInterface $em): Response
    {
        $data = json_decode($request->getContent(), true);
        if ($data) {
            if ($data['nom']) {
                $continent = new Continents();
                $form = $this->createForm(ContinentEx::class, $continent);
                $form->submit($data);
                $validate = $validator->validate($continent, null, 'RegisterContinent');

                if (count($validate) !== 0) {
                    foreach ($validate as $error) {
                        return new JsonResponse($error->getMessage(), Response::HTTP_BAD_REQUEST);
                    }
                }

                $this->em->persist($continent);
                $this->em->flush();
                return new JsonResponse("Continent Ajoute", Response::HTTP_CREATED);
            } else {
                return new JsonResponse("Merci de renseigner des champs corrects", RESPONSE::HTTP_NO_CONTENT);
            }
        } else {
            return new JsonResponse("Merci de renseigner les champs correctement", RESPONSE::HTTP_NO_CONTENT);
        }
    }

    /**
     * @Route("/continent/delete/{id}", name="continent_delete", methods={"DELETE"})
     * @param ContinentsRepository $continentRepository
     * @param int $id
     * @return Response
     */

    public function deleteContinent(ContinentsRepository $continentRepository, $id = 0): Response
    {
        $continent = $continentRepository->find($id);
        if ($continent) {
            $this->em->remove($continent);
            $this->em->flush();
            return new JsonResponse("Continent supprime", Response::HTTP_OK);
        } else {
            return new JsonResponse("Rien a supprimer", Response::HTTP_BAD_REQUEST);
        }
    }
}