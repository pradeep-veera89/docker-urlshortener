<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AppController extends AbstractController
{

    /**
     * @Route("/homepage", name="app_homepage", methods={"GET", "POST"})
     */
    public function index(): Response
    {
        return $this->render('app/index.html.twig',[
            'user'=> $this->getUser()->getUsername()
        ]);
    }

    /**
     * @Route("/homepage123", name="app_homepage123", methods={"GET", "POST"})
     */
    public function redirectTest()
    {
        return $this->redirectToRoute('app_homepage');
        //return $this->render('app/index.html.twig');
    }
}