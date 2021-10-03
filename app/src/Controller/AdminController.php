<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{

    /**
     * @Route("/admin/dashboard", name="admin_dashboard", methods={"GET", "POST"})
     */
    public function dashboard()
    {
        return $this->render('admin/dashboard.html.twig');
    }
}