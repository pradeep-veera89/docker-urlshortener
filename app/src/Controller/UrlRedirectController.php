<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UrlRedirectController extends AbstractController
{
    /**
     * @Route("/url/redirect", name="url_redirect")
     */
    public function index(): Response
    {
        return $this->render('url_redirect/index.html.twig', [
            'controller_name' => 'UrlRedirectController',
        ]);
    }
}
