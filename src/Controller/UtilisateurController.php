<?php

namespace App\Controller;

use App\Entity\UTILISATEURS;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

class UtilisateurController extends AbstractController
{
    #[Route('/api/v1/register', name: 'api_register', methods: ['POST'])]
    public function register(
        Request $request,
        EntityManagerInterface $em,
        UserPasswordHasherInterface $passwordHasher,
        JWTTokenManagerInterface $jwtManager
    ): Response {
        $data = json_decode($request->getContent(), true);
        $email = $data['email'] ?? null;
        $plainPassword = $data['mot_de_passe'] ?? null;

        if (!$email || !$plainPassword) {
            return new JsonResponse(['error' => 'Email et mot de passe requis'], Response::HTTP_BAD_REQUEST);
        }

        // Vérifier si l'utilisateur existe déjà
        $existing = $em->getRepository(UTILISATEURS::class)->findOneBy(['email' => $email]);
        if ($existing) {
            return new JsonResponse(['error' => 'Cet email existe déjà'], Response::HTTP_CONFLICT);
        }

        $user = new UTILISATEURS();
        $user->setEmail($email);
        $user->setMotDePasse($passwordHasher->hashPassword($user, $plainPassword));
        $user->setDateCreation(new \DateTime());
        $user->setDateModification(new \DateTime());
        $user->setToken(null);


        $em->persist($user);
        $em->flush();

        $token = $jwtManager->create($user);

        return new JsonResponse([
            'api_version' => 'v1',
            'user' => [
                'id' => $user->getId(),
                'email' => $user->getEmail(),
            ],
            'token' => $token
        ], Response::HTTP_CREATED);
    }

    #[Route('/api/v1/login', name: 'api_login', methods: ['POST'])]
    public function login(
        Request $request,
        EntityManagerInterface $em,
        UserPasswordHasherInterface $passwordHasher,
        JWTTokenManagerInterface $jwtManager
    ): Response {
        $data = json_decode($request->getContent(), true);
        $email = $data['email'] ?? null;
        $plainPassword = $data['mot_de_passe'] ?? null;

        if (!$email || !$plainPassword) {
            return new JsonResponse(['error' => 'Email et mot de passe requis'], Response::HTTP_BAD_REQUEST);
        }

        $user = $em->getRepository(UTILISATEURS::class)->findOneBy(['email' => $email]);
        if (!$user || !$passwordHasher->isPasswordValid($user, $plainPassword)) {
            return new JsonResponse(['error' => 'Identifiants invalides'], Response::HTTP_UNAUTHORIZED);
        }

        $token = $jwtManager->create($user);

        return new JsonResponse([
            'api_version' => 'v1',
            'user' => [
                'id' => $user->getId(),
                'email' => $user->getEmail(),
            ],
            'token' => $token
        ], Response::HTTP_OK);
    }
} 