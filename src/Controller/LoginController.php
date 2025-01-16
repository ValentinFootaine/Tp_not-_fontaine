<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;  
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class LoginController extends AbstractController
{
    private $jwtManager;
    private $passwordHasher;
    private $entityManager;

    public function __construct(JWTTokenManagerInterface $jwtManager, UserPasswordHasherInterface $passwordHasher, EntityManagerInterface $entityManager)
    {
        $this->jwtManager = $jwtManager;
        $this->passwordHasher = $passwordHasher;
        $this->entityManager = $entityManager;
    }

    #[Route('/login', name:'login', methods:['POST'])]
    public function login(Request $request): Response
    {
        $data = json_decode($request->getContent(), true);

        if (!isset($data['username']) || !isset($data['password'])) {
            return $this->json(['error' => 'Username and password are required'], Response::HTTP_BAD_REQUEST);
        }

        $username = $data['username'];
        $password = $data['password'];

        $user = $this->entityManager->getRepository(User::class)->findOneBy(['username' => $username]);

        if (!$user || !$this->passwordHasher->isPasswordValid($user, $password)) {
            throw new BadCredentialsException('Invalid credentials.');
        }

        $token = $this->jwtManager->create($user);

        return $this->json([
            'token' => $token,
        ]);
    }

    #[Route('/logout', name:'logout', methods:['POST'])]
    public function logout(): void
    {
        throw new \Exception('Logout not handled in this controller');
    }
}
