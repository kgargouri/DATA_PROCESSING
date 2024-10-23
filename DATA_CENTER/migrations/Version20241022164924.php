<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241022164924 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE clients (id INT AUTO_INCREMENT NOT NULL, client VARCHAR(255) NOT NULL, adresse LONGTEXT NOT NULL, code_postal INT NOT NULL, ville VARCHAR(255) NOT NULL, telephone VARCHAR(255) NOT NULL, civilite VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE produits (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, categorie VARCHAR(255) NOT NULL, sous_categorie VARCHAR(255) NOT NULL, cout_unitaire VARCHAR(255) NOT NULL, prix_unitaire VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_IDENTIFIER_USERNAME (username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ventes (id INT AUTO_INCREMENT NOT NULL, client_id INT NOT NULL, produit_id INT NOT NULL, n_commande VARCHAR(255) NOT NULL, date_commande DATE NOT NULL, canal VARCHAR(255) NOT NULL, quantite INT NOT NULL, date_livraison DATE NOT NULL, INDEX IDX_64EC489A19EB6921 (client_id), INDEX IDX_64EC489AF347EFB (produit_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE ventes ADD CONSTRAINT FK_64EC489A19EB6921 FOREIGN KEY (client_id) REFERENCES clients (id)');
        $this->addSql('ALTER TABLE ventes ADD CONSTRAINT FK_64EC489AF347EFB FOREIGN KEY (produit_id) REFERENCES produits (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ventes DROP FOREIGN KEY FK_64EC489A19EB6921');
        $this->addSql('ALTER TABLE ventes DROP FOREIGN KEY FK_64EC489AF347EFB');
        $this->addSql('DROP TABLE clients');
        $this->addSql('DROP TABLE produits');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE ventes');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
