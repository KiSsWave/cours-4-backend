<?php

namespace App\Command;

use App\Entity\Person;
use App\Entity\Building;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'app:add-data',
    description: 'Ajout de données de test dans la base de données',
)]
class AddDataCommand extends Command
{
    protected static $defaultName = 'app:add-data';
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct();
        $this->entityManager = $entityManager;
    }

    protected function configure(): void
    {
        $this
            ->setDescription('Add sample data to the database');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        // Créer un bâtiment
        $building = new Building();
        $building->setNom('Building A');
        $building->setAdresse('123 Main Street');
        $this->entityManager->persist($building);


        $person1 = new Person();
        $person1->setPrenom('Clément');
        $person1->setNom('Jeandidier');
        $person1->setEmail('clement.jeandidier@example.com');
        $person1->setBuilding($building);
        $this->entityManager->persist($person1);


        $person2 = new Person();
        $person2->setPrenom('Thomas');
        $person2->setNom('Dekersabiec');
        $person2->setEmail('thomas.dekersabiec@example.com');
        $person2->setBuilding($building);
        $this->entityManager->persist($person2);


        $this->entityManager->flush();

        $output->writeln('Sample data has been added successfully.');

        return Command::SUCCESS;
    }
}
