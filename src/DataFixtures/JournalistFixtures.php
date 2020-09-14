<?php 
// src/DataFixtures/AppFixtures.php
namespace App\DataFixtures;

use App\Entity\Journaliste;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class JournalistFixtures extends Fixture
{
    private $encoder;
    public function __construct(UserPasswordEncoderInterface $encoder)

    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $journalist = new Journaliste();
        $journalist->setNom('Zeghouani');
        $journalist->setPrenom('Sohaib');
        $journalist->setRoles(['ROLE_JOURNALISTE']);
        $journalist->setEmail('Test@teste.fr');
        $password = $this->encoder->encodePassword($journalist, 'Journaligisme');
        $journalist->setPassword($password);
        $manager->persist($journalist);
        $manager->flush();
    }
}
?>