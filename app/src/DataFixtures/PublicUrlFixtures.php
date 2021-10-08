<?php

namespace App\DataFixtures;

use App\Entity\PublicUrl;
use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class PublicUrlFixtures extends Fixture
{
    private string $userEMail;
    private UserRepository $userRepo;

    public function __construct(UserRepository $userRepository)
    {
        $this->userEMail = 'ruvenyp@mailinator.com';
        $this->userRepo = $userRepository;
    }

    public function load(ObjectManager $manager): void
    {
        $user = $this->userRepo->findByEmail($this->userEMail);
        for($i=0; $i <= 10; $i++) {
            $publicUrl = new PublicUrl();

            $publicUrl->setName(sprintf('PublicUrl-%d', $i));
            $publicUrl->setUrl(sprintf('https://public-url-%d', $i));
            $publicUrl->setUserId($user);
            $manager->persist($publicUrl);
        }

        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();
    }

}
