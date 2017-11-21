<?php

namespace App\ProjectBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Elasticsearch\ClientBuilder;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;

class DeleteElasticIndexCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('app:delete-elastic-index')

            ->addArgument('entity', InputArgument::REQUIRED, 'For what entity you want to delete index?')

            ->setDescription('Deletes a new elasticsearch index.')

            ->setHelp('This command allows you to delete a elasticsearch index.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $entity = $input->getArgument('entity');

        $client = ClientBuilder::create()->build();

        //Get DB name
        $index = $this->getContainer()->getParameter('database_name');

        $deleteParams = [
            'index' => $index
        ];

        $client->indices()->delete($deleteParams);

        $output->writeln('Index deleted successfully!');
    }
}