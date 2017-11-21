<?php

namespace App\ProjectBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Elasticsearch\ClientBuilder;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;

class CheckElasticIndexCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('app:check-elastic-index')

            ->addArgument('entity', InputArgument::REQUIRED, 'For what entity you want to check index existance?')

            ->setDescription('Checks existance of elasticsearch index.')

            ->setHelp('This command checks index exists or not.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $entity = $input->getArgument('entity');

        $client = ClientBuilder::create()->build();

        //Get DB name
        $index = $this->getContainer()->getParameter('database_name');

        $indexParams = [
            'index' => $index
        ];

        $response = $client->indices()->exists($indexParams);

        $convertedResponse = ($response) ? 'true' : 'false';

        $output->writeln('Index existance: '.$convertedResponse);
    }
}