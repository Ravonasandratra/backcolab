<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20261102165549 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE information ADD coordonne POINT DEFAULT NULL, DROP adress');
        $this->addSql('ALTER TABLE user DROP INDEX phone, ADD UNIQUE INDEX UNIQ_8D93D649444F97DD (phone)');
        $this->addSql('ALTER TABLE user CHANGE phone phone VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE user RENAME INDEX coordonne TO IDX_8D93D6493A208812');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE information ADD adress VARCHAR(255) NOT NULL, DROP coordonne');
        $this->addSql('ALTER TABLE `user` DROP INDEX UNIQ_8D93D649444F97DD, ADD INDEX phone (phone)');
        $this->addSql('ALTER TABLE `user` CHANGE phone phone VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE `user` RENAME INDEX idx_8d93d6493a208812 TO coordonne');
    }
}
