<?php

namespace App\Controller;

use App\Service\MoodEntryService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class MoodEntryController extends AbstractController
{
    private MoodEntryService $moodEntryService;

    public function __construct(MoodEntryService $moodEntryService)
    {
        $this->moodEntryService = $moodEntryService;
    }

    #[Route('/api/mood/{id}', name: 'get_mood_entry', methods: ['GET'])]
    public function getMoodEntry(int $id): JsonResponse
    {
        return $this->moodEntryService->getMoodEntryById($id);
    }

    #[Route('/api/mood/create', name: 'create_mood', methods: ['POST'])]
    public function create(Request $request): JsonResponse
    {
        return $this->moodEntryService->createMood($request);
    }
}


