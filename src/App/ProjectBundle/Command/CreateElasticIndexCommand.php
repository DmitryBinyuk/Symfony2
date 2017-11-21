<?php

namespace App\ProjectBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Elasticsearch\ClientBuilder;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use App\ProjectBundle\Entity\Product;

class CreateElasticIndexCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('app:create-elastic-index')

            ->addArgument('entity', InputArgument::REQUIRED, 'For what entity you want to generate index?')

            ->setDescription('Creates a new elasticsearch index.')

            ->setHelp('--entity argument needed to define entity for index (its mandatory)')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $entity = $input->getArgument('entity');

        $client = ClientBuilder::create()->build();

        //Get DB name
        $index = $this->getContainer()->getParameter('database_name');

        //Prepare data for index from DB
        $em = $this->getContainer()->get('doctrine.orm.entity_manager');

        $repository = $em->getRepository(Product::class);

        $products = $repository->findAll();

        //CHEATSHEET:
        // Array result with query builder
        //$query = $repository->createQueryBuilder('p')
        //  ->select('p.id', 'p.name', 'p.description')
        //  ->getQuery();
        //
        //$result = $query->getArrayResult();

        $values = [];

        foreach($products as $key=>$product){
            $values[$key]['id'] = $product->getId();
            $values[$key]['name'] = $product->getName();
            $values[$key]['description'] = $product->getDescription();

            $productMedia = $product->getMedia();
            if(isset($productMedia)){
                $mediaProvider = $this->getContainer()->get('sonata.media.provider.image');
                $format = $mediaProvider->getFormatName($productMedia, 'small');
                $values[$key]['image'] = $mediaProvider->generatePublicUrl($productMedia, $format);
            } else{
                $values[$key]['image'] = '';
            }
        }

        //CREATE INDEX
        $params = [
            'index' => $index,
            'type' => 'Product',//Table name
            'body' => [],
        ];

        $indexes = $client->index($params);

        foreach($values as $key=>$item) {
            $params['body'][] = [
                'index' => [
                    '_index' => $index,
                    '_type' => 'Product',
                ]
            ];

            $params['body'][] = [
                'id' => $item['id'],
                'name' => $item['name'],
                'description' => $item['description'],
                'image' => $item['image']
            ];
        }

        $response = $client->bulk($params);

        $output->writeln('Index created successfully!');
    }
}