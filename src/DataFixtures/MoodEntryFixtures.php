<?php

namespace App\DataFixtures;

use App\Entity\MoodEntry;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class MoodEntryFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user->setUsername('user_' . uniqid());  
        $user->setPassword('password');  

        $manager->persist($user);
        $manager->flush();  

        $moodEntry = new MoodEntry();
        $moodEntry->setMoodType('happy');
        $moodEntry->setTimestamp(new \DateTime());
        $moodEntry->setNote('Feeling good');
        $moodEntry->setUserId($user->getId());  

        $manager->persist($moodEntry);
        
        $manager->flush();
    }
}