<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241020132620 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE ventes (id INT AUTO_INCREMENT NOT NULL, client_id INT NOT NULL, produit_id INT NOT NULL, n_commande VARCHAR(255) NOT NULL, date_commande DATE NOT NULL, canal VARCHAR(255) NOT NULL, quantite INT NOT NULL, INDEX IDX_64EC489A19EB6921 (client_id), INDEX IDX_64EC489AF347EFB (produit_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE ventes ADD CONSTRAINT FK_64EC489A19EB6921 FOREIGN KEY (client_id) REFERENCES clients (id)');
        $this->addSql('ALTER TABLE ventes ADD CONSTRAINT FK_64EC489AF347EFB FOREIGN KEY (produit_id) REFERENCES produits (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ventes DROP FOREIGN KEY FK_64EC489A19EB6921');
        $this->addSql('ALTER TABLE ventes DROP FOREIGN KEY FK_64EC489AF347EFB');
        $this->addSql('DROP TABLE ventes');
    }
}
