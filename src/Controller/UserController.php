<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\UserRepository;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class UserController extends AbstractController
{
    #[Route('/user/create', name: 'create_user')]
    public function createUser(EntityManagerInterface $entityManager): Response
    {
        $user = new User();
        $user->setName('John');
        $user->setPhone(045776);

        $entityManager->persist($user);
        $entityManager->flush();

        return new Response('Saved new user with id ' . $user->getId());
    }

    #[Route('/user/{id}', name: 'user_show', methods: ['GET'])]
    public function show(User $user)
    {
        return $this->json($user);
    }

    #[Route('/user', name: 'user_index', methods: ['GET'])]
    public function index(UserRepository $userRepository): Response
    {
        $users = $userRepository->findAll();

        if (!$users) {
            return $this->json(['message' => 'No users yet'], Response::HTTP_NOT_FOUND);
        }

        return $this->json($users);
    }
}
