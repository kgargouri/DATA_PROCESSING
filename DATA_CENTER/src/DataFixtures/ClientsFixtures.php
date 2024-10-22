<?php

namespace App\DataFixtures;

use App\Entity\Clients;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ClientsFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $file = fopen('public/csv/clients.csv','r');
        ini_set('auto_detect_line_endings',TRUE);
        $i=1;
        while (($row = fgetcsv($file, null, ";")) !== FALSE){
            $client=new Clients();
            if($row){
                $client->setClient(utf8_encode($row['1']));
                $client->setAdresse(utf8_encode($row[2]));
                $client->setCodePostal(utf8_encode($row[3]));
                $client->setVille(utf8_encode($row[4]));
                $client->setTelephone(utf8_encode($row[5]));
                $client->setCivilite(utf8_encode($row[6]));
                $client->setPrenom(utf8_encode($row[7]));
                $client->setNom(utf8_encode($row[8]));
            }

            $this->addReference('client-'.$i, $client);

            $manager->persist($client);
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
