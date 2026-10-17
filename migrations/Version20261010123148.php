<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20261010123148 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE verification_otp (id INT AUTO_INCREMENT NOT NULL, secret VARCHAR(255) NOT NULL, expired_at DATETIME NOT NULL, verified_at DATETIME NOT NULL, attempts INT NOT NULL, profil_id INT DEFAULT NULL, INDEX IDX_2C8B3A87275ED078 (profil_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE verification_otp ADD CONSTRAINT FK_2C8B3A87275ED078 FOREIGN KEY (profil_id) REFERENCES profil (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE verification_otp DROP FOREIGN KEY FK_2C8B3A87275ED078');
        $this->addSql('DROP TABLE verification_otp');
    }
}
