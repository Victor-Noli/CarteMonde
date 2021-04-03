<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class JWTController extends AbstractController
{
    /**
     * @Route("/j/w/t", name="j_w_t")
     */
    public function index(): Response
    {
        return $this->render('jwt/index.html.twig', [
            'controller_name' => 'JWTController',
        ]);
    }
}
