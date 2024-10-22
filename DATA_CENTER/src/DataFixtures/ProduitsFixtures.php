<?php

namespace App\DataFixtures;

use App\Entity\Produits;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ProduitsFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $csv = 'public/csv/produits.csv';
        $file = fopen($csv,'r');
        //ini_set('auto_detect_line_endings',TRUE);
        //mb_convert_encoding($csv, 'UTF-16LE', 'utf8mb4_unicode_ci');
        $i=1;
        while (($row = fgetcsv($file, 1000, ";")) !== FALSE){
            $produit=new Produits();
            if($row){
                $produit->setNom(utf8_encode($row[1]));
                $produit->setCategorie(utf8_encode($row[2]));
                $produit->setSousCategorie(utf8_encode($row[3]));
                $produit->setCoutUnitaire($row[4]);
                $produit->setPrixUnitaire($row[5]);
                //dump($row);
            }

            $this->addReference('produit-'.$i, $produit);

            $manager->persist($produit);
            $i++;
        }
        fclose($file);
        
        $manager->flush();
    }

    public static function getGroups(): array
    {
        return ['group1'];
    }
}
