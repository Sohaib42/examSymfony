<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class JournalisteController extends AbstractController
{
    /**
     * @Route("/journaliste", name="journaliste")
     */
    public function index()
    {
        return $this->render('journaliste/index.html.twig', [
            'controller_name' => 'JournalisteController',
        ]);
    }
}
