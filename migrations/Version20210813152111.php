<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210813152111 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE tableaux ADD technique_id INT NOT NULL');
        $this->addSql('ALTER TABLE tableaux ADD CONSTRAINT FK_307CE1D41F8ACB26 FOREIGN KEY (technique_id) REFERENCES technique (id)');
        $this->addSql('CREATE INDEX IDX_307CE1D41F8ACB26 ON tableaux (technique_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE tableaux DROP FOREIGN KEY FK_307CE1D41F8ACB26');
        $this->addSql('DROP INDEX IDX_307CE1D41F8ACB26 ON tableaux');
        $this->addSql('ALTER TABLE tableaux DROP technique_id');
    }
}
