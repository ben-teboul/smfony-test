<?php

namespace App\Command;

use App\Entity\Pictures;
use App\Repository\PicturesRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Contracts\HttpClient\HttpClientInterface;

#[AsCommand(
    name: 'app:get:picture-of-day',
    description: 'Run this command every day at 00:01am to get the picture of the day'
)]
class GetPictureOfDayCommand extends Command
{
    public function __construct(
        private readonly HttpClientInterface    $httpClient,
        private readonly PicturesRepository     $picturesRepository,
        private readonly EntityManagerInterface $entityManager,
        string                                  $name = null
    )
    {
        parent::__construct($name);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln([
            '==================',
            'Picture of the day',
            '==================',
            '',
        ]);

        $response = $this->httpClient->request('GET', 'https://api.nasa.gov/planetary/apod?api_key=DEMO_KEY');
        $data = json_decode($response->getContent(false), true);
        $output->writeln('Picture of day => ' . $data['title']);
        $date = new DateTime($data['date']);
        $pictureCheck = $this->picturesRepository->findOneBy(['date' => $date]);
        if ($pictureCheck) {
            $output->writeln('Picture already exists');
        } else {
            $picture = (new Pictures())
                ->setTitle($data['title'])
                ->setUrl($data['url'])
                ->setExplanation($data['explanation'])
                ->setDate($date);
            $this->entityManager->persist($picture);
            $this->entityManager->flush();
            $output->writeln('Picture added');
        }

        return Command::SUCCESS;
    }
}
