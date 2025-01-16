<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class UserController extends AbstractController
{
    public function profile(): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        return $this->render('user/profile.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }

    public function reservations(): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        return $this->render('user/reservations.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }
}