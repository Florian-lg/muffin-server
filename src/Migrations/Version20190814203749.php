<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190814203749 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE player MODIFY id INT NOT NULL');
        $this->addSql('ALTER TABLE player DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE player CHANGE id id INT NOT NULL, CHANGE discord_id discord_id VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE player ADD PRIMARY KEY (discord_id)');
        $this->addSql('ALTER TABLE role CHANGE card card VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE player MODIFY discord_id VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE player DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE player CHANGE discord_id discord_id INT NOT NULL, CHANGE id id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE player ADD PRIMARY KEY (id)');
        $this->addSql('ALTER TABLE role CHANGE card card VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci');
    }
}
