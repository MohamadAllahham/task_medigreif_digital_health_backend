<?php

namespace App\Service;

use App\Entity\MoodEntry;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class MoodEntryService
{
    private EntityManagerInterface $em;
    private ValidatorInterface $validator;

    public function __construct(EntityManagerInterface $em, ValidatorInterface $validator)
    {
        $this->em = $em;
        $this->validator = $validator;
    }

    public function getMoodEntryById(int $id): JsonResponse
    {
        $moodEntry = $this->em->getRepository(MoodEntry::class)->find($id);

        if (!$moodEntry) {
            return new JsonResponse([
                'error' => 'Mood entry not found',
                'statusCode' => 404
            ], 404);
        }

        return new JsonResponse([
            'success' => true,
            'message' => 'Mood entry fetched successfully',
            'data' => $this->formatMood($moodEntry)
        ]);
    }

public function createMood(Request $request): JsonResponse
{
    $data = json_decode($request->getContent(), true);
    $userId = $data['userId'];
    
    if (!$userId) {
        return new JsonResponse(['error' => 'User ID is required'], 400);
    }

    $moodEntry = new MoodEntry();
    $moodEntry->setUserId($userId);
    $moodEntry->setMoodType($data['moodType'] ?? '');
    $moodEntry->setTimestamp(new \DateTime());
    $moodEntry->setNote($data['note'] ?? '');

    $errors = $this->validator->validate($moodEntry);
    if (count($errors) > 0) {
        return new JsonResponse([
            'error' => $errors[0]->getMessage(),
            'statusCode' => 400
        ], 400);
    }

    $this->em->persist($moodEntry);
    $this->em->flush();

    return new JsonResponse([
        'success' => true,
        'message' => 'Mood created successfully',
        'data' => $this->formatMood($moodEntry)
    ]);
}

private function formatMood(MoodEntry $entry): array
{
    return [
        'moodId' => $entry->getId(),
        'moodType' => $entry->getMoodType(),
        'note' => $entry->getNote(),
        'timestamp' => $entry->getTimestamp()->format('Y-m-d H:i:s'),
        'userId' => $entry->getUserId(),
    ];
}
}