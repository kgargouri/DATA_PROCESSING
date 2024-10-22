<?php

namespace App\DataFixtures;

use App\Entity\Ventes;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class VentesFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $file = fopen('public/csv/ventes.csv','r');
        ini_set('auto_detect_line_endings',TRUE);
        $i=1;
        while (($row = fgetcsv($file, null, ";")) !== FALSE){
            $vente=new Ventes();
            if($row){
                //dump($row);
                $vente->setNCommande(utf8_encode($row['0']));
                $vente->setDateCommande(\DateTime::createFromFormat('d/m/Y', $row[1]));
                $vente->setDateLivraison(\DateTime::createFromFormat('d/m/Y', $row[2]));
                $vente->setClient($this->getReference('client-'.$row[3]));
                $vente->setCanal(utf8_encode($row[4]));
                $vente->setProduit($this->getReference('produit-'.$row[5]));
                $vente->setQuantite(utf8_encode($row[6]));
            }

            $manager->persist($vente);
            $i++;
        }
        fclose($file);

        $manager->flush();
    }

    public function getDependencies(){
        return [
            ProduitsFixtures::class,
            ClientsFixtures::class
        ];
    }
}
