<?php

namespace App\DataFixtures;

use App\Entity\Socio;
use App\Factory\AutorFactory;
use App\Factory\EditorialFactory;
use App\Factory\LibroFactory;
use App\Factory\SocioFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

class AppFixtures extends Fixture
{

    private UserPasswordHasherInterface $passwordHasher;
    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }


    public function load(ObjectManager $manager): void
    {
        /*
        AutorFactory::createMany(200);
        EditorialFactory::createMany(100);
        SocioFactory::createMany(50);
        LibroFactory::createMany(50, function () {
            return [
                "autores" => AutorFactory::randomRange(1, 3),
                "socio" => SocioFactory::faker()->boolean(25) ? SocioFactory::random() : null,
                "editorial" => EditorialFactory::random()
            ];
        });
        */

        SocioFactory::createOne([
            'email' => 'admin@biblio.local',
            'password' => $this->passwordHasher->hashPassword(
                new Socio(),
                'admin'
            ),
            'esAdministrador' => true,
            'esDocente' => false,
            'esEstudiante' => false
        ]);

        SocioFactory::createOne([
            'email' => 'docente@biblio.local',
            'password' => $this->passwordHasher->hashPassword(
                new Socio(),
                'docente'
            ),
            'esAdministrador' => false,
            'esDocente' => true,
            'esEstudiante' => false
        ]);

        SocioFactory::createOne([
            'email' => 'estudiante@biblio.local',
            'password' => $this->passwordHasher->hashPassword(
                new Socio(),
                'estudiante'
            ),
            'esAdministrador' => false,
            'esDocente' => false,
            'esEstudiante' => true
        ]);

        SocioFactory::createMany(20, function () {

            $docente = SocioFactory::faker()->boolean(10);


            return [
                'password' => $this->passwordHasher->hashPassword(
                    new Socio(),
                    'prueba'
                ),
                'esAdministrador' => false,
                'esDocente' => $docente,
                'esEstudiante' => !$docente

            ];
        });

        $manager->flush();
    }
}
