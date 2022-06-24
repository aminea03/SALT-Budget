<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220624202054 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE categories (id INT AUTO_INCREMENT NOT NULL, comptabilite_id INT NOT NULL, nom_categorie VARCHAR(50) NOT NULL, INDEX IDX_3AF346684E455E4 (comptabilite_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE comptabilite (id INT AUTO_INCREMENT NOT NULL, comptabilite_type VARCHAR(50) NOT NULL, coefficient_multiplicateur SMALLINT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE paiements (id INT AUTO_INCREMENT NOT NULL, moyen_paiement VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE transactions (id INT AUTO_INCREMENT NOT NULL, categorie_id INT NOT NULL, user_id INT NOT NULL, paiement_id INT NOT NULL, montant_transaction INT NOT NULL, date_transaction DATE NOT NULL, INDEX IDX_EAA81A4CBCF5E72D (categorie_id), INDEX IDX_EAA81A4CA76ED395 (user_id), INDEX IDX_EAA81A4C2A4C4478 (paiement_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE categories ADD CONSTRAINT FK_3AF346684E455E4 FOREIGN KEY (comptabilite_id) REFERENCES comptabilite (id)');
        $this->addSql('ALTER TABLE transactions ADD CONSTRAINT FK_EAA81A4CBCF5E72D FOREIGN KEY (categorie_id) REFERENCES categories (id)');
        $this->addSql('ALTER TABLE transactions ADD CONSTRAINT FK_EAA81A4CA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE transactions ADD CONSTRAINT FK_EAA81A4C2A4C4478 FOREIGN KEY (paiement_id) REFERENCES paiements (id)');
        $this->addSql('ALTER TABLE user ADD nom_utilisateur VARCHAR(50) NOT NULL, ADD prenom_utilisateur VARCHAR(50) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE transactions DROP FOREIGN KEY FK_EAA81A4CBCF5E72D');
        $this->addSql('ALTER TABLE categories DROP FOREIGN KEY FK_3AF346684E455E4');
        $this->addSql('ALTER TABLE transactions DROP FOREIGN KEY FK_EAA81A4C2A4C4478');
        $this->addSql('DROP TABLE categories');
        $this->addSql('DROP TABLE comptabilite');
        $this->addSql('DROP TABLE paiements');
        $this->addSql('DROP TABLE transactions');
        $this->addSql('ALTER TABLE user DROP nom_utilisateur, DROP prenom_utilisateur');
    }
}
