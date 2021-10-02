<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210910084923 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commande ADD tableaux_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67DF217A756 FOREIGN KEY (tableaux_id) REFERENCES tableaux (id)');
        $this->addSql('CREATE INDEX IDX_6EEAA67DF217A756 ON commande (tableaux_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67DF217A756');
        $this->addSql('DROP INDEX IDX_6EEAA67DF217A756 ON commande');
        $this->addSql('ALTER TABLE commande DROP tableaux_id');
    }
}
