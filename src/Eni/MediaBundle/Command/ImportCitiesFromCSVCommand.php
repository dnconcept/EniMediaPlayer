<?php

namespace Eni\MediaBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Description of ImportCitiesFromCSVCommand
 *
 * @author Administrateur
 */
class ImportCitiesFromCSVCommand extends Command
{

    protected function configure()
    {
        $this->setName("import-cities")
            ->setDescription("Import cities from csv file")
            ->addArgument(
                'filename', InputArgument::REQUIRED, 'Which file to import from ?'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $filename = $input->getArgument('filename');
        if (!file_exists($filename)) {
            $output->write("The file '$filename' doesn't exists !");
        } else {

            /** @var AppKernel $kernel */
            $kernel = $this->getApplication()->getKernel();

            $doctrine = $kernel->getContainer()->get("doctrine");
            $em = $doctrine->getManager();

            $handle = fopen($filename, 'r');
            if ($handle) {
                $size = filesize($filename);
                while (($data = fgetcsv($handle, $size, ",")) !== FALSE) {
                    $id = $data[0];
                    $name = $data[4];
                    $codePostal = $data[10];
                    $ville = new \Eni\MediaBundle\Entity\Ville();
                    $ville->setId($id)
                        ->setCodepostal($codePostal)
                        ->setNom($name);
                    $em->persist($ville);
                }
                fclose($handle);
                $em->flush();
            }
            echo "La commande est executee ! fichier = $filename" . PHP_EOL;
        }
    }

}
