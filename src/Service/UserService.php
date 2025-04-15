<?php

namespace App\Service;

use App\Entity\User;
use App\Entity\MoodEntry;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class UserService
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function findUserByUsername(string $username): ?User
    {
        return $this->em->getRepository(User::class)->findOneBy(['username' => $username]);
    }

    public function validateCredentials(string $username, string $password): ?User
    {
        $user = $this->findUserByUsername($username);

        if (!$user || $user->getPassword() !== $password) {
            return null;
        }

        return $user;
    }

    public function formatUserWithMoods(User $user): array
    {
        $moodEntries = $this->em->getRepository(MoodEntry::class)->findBy(['userId' => $user->getId()]);

        return [
            'id' => $user->getId(),
            'username' => $user->getUsername(),
            'moods' => array_map(function ($entry) use ($user) {
                return [
                    'id' => $entry->getId(),
                    'moodType' => $entry->getMoodType(),
                    'note' => $entry->getNote(),
                    'userId' => $user->getId(),
                    'timestamp' => $entry->getTimestamp()->format('Y-m-d H:i:s'),
                ];
            }, $moodEntries),
        ];
    }

    public function handleLogin(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $username = $data['username'] ?? '';
        $password = $data['password'] ?? '';

        $user = $this->validateCredentials($username, $password);

        if (!$user) {
            return new JsonResponse(
                [
                    'error' => 'Invalid credentials',
                    'statusCode' => 401
                ], 
                401
            );
        }

        return new JsonResponse([
            'success' => true,
            'message' => 'Login successful',
            'data' => $this->formatUserWithMoods($user),
        ]);
    }

    public function handleGetUserInfo(string $id): JsonResponse
    {
        $user = $this->em->getRepository(User::class)->find($id);

        if (!$user) {
            return new JsonResponse(
                [
                'error' => 'User not found', 
                'statusCode' => 404
                ],
            404);
        }

        return new JsonResponse([
            'success' => true,
            'message' => 'User info fetched successfully',
            'data' => $this->formatUserWithMoods($user),
        ]);
    }
}