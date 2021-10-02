<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210926144554 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE tableaux DROP FOREIGN KEY FK_307CE1D44D79775F');
        $this->addSql('DROP INDEX IDX_307CE1D44D79775F ON tableaux');
        $this->addSql('ALTER TABLE tableaux ADD tva DOUBLE PRECISION NOT NULL, DROP tva_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE tableaux ADD tva_id INT DEFAULT NULL, DROP tva');
        $this->addSql('ALTER TABLE tableaux ADD CONSTRAINT FK_307CE1D44D79775F FOREIGN KEY (tva_id) REFERENCES tva (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_307CE1D44D79775F ON tableaux (tva_id)');
    }
}
