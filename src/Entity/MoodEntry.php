<?php

namespace App\Entity;

use App\Repository\MoodEntryRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: MoodEntryRepository::class)]
class MoodEntry
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $id;

    #[Assert\Choice(choices: ['angry', 'good', 'happy', 'okay', 'sad'], message: 'Invalid mood type')]
    #[ORM\Column(length: 30)]
    private string $moodType;

    #[Assert\NotNull]
    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private \DateTimeInterface $timestamp;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $note = null;

    #[ORM\Column(type: Types::INTEGER)]
    private int $userId;

    public function setUserId(int $userId): self
    {
        $this->userId = $userId;
        return $this;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getMoodType(): string
    {
        return $this->moodType;
    }

    public function setMoodType(string $moodType): static
    {
        $this->moodType = $moodType;
        return $this;
    }

    public function getTimestamp(): \DateTimeInterface
    {
        return $this->timestamp;
    }

    public function setTimestamp(\DateTimeInterface $timestamp): static
    {
        $this->timestamp = $timestamp;
        return $this;
    }

    public function getNote(): ?string
    {
        return $this->note;
    }

    public function setNote(string $note): static
    {
        $this->note = $note;
        return $this;
    }
}