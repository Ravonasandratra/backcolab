<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260905074136 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE sub_category_user (sub_category_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_C9A56BD0F7BFE87C (sub_category_id), INDEX IDX_C9A56BD0A76ED395 (user_id), PRIMARY KEY (sub_category_id, user_id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE sub_category_user ADD CONSTRAINT FK_C9A56BD0F7BFE87C FOREIGN KEY (sub_category_id) REFERENCES sub_category (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE sub_category_user ADD CONSTRAINT FK_C9A56BD0A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE sub_category_user DROP FOREIGN KEY FK_C9A56BD0F7BFE87C');
        $this->addSql('ALTER TABLE sub_category_user DROP FOREIGN KEY FK_C9A56BD0A76ED395');
        $this->addSql('DROP TABLE sub_category_user');
    }
}
