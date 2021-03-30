<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210330131348 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE search_intent ADD project_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE search_intent ADD CONSTRAINT FK_678E940E166D1F9C FOREIGN KEY (project_id) REFERENCES project (id)');
        $this->addSql('CREATE INDEX IDX_678E940E166D1F9C ON search_intent (project_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE search_intent DROP FOREIGN KEY FK_678E940E166D1F9C');
        $this->addSql('DROP INDEX IDX_678E940E166D1F9C ON search_intent');
        $this->addSql('ALTER TABLE search_intent DROP project_id');
    }
}
