<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20261019163723 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE token_password_reset (id INT AUTO_INCREMENT NOT NULL, user INT NOT NULL, hash_token VARCHAR(255) NOT NULL, expired_at DATETIME NOT NULL, used_at DATETIME DEFAULT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE verification_otp ADD is_change_password TINYINT DEFAULT NULL, DROP new_pwd');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE token_password_reset');
        $this->addSql('ALTER TABLE verification_otp ADD new_pwd VARCHAR(255) DEFAULT NULL, DROP is_change_password');
    }
}
