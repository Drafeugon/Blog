<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20261008074611 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE evenement ADD lieux_id INT NOT NULL');
        $this->addSql('ALTER TABLE evenement ADD CONSTRAINT FK_B26681EA2C806AC FOREIGN KEY (lieux_id) REFERENCES lieu (id)');
        $this->addSql('CREATE INDEX IDX_B26681EA2C806AC ON evenement (lieux_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE evenement DROP FOREIGN KEY FK_B26681EA2C806AC');
        $this->addSql('DROP INDEX IDX_B26681EA2C806AC ON evenement');
        $this->addSql('ALTER TABLE evenement DROP lieux_id');
    }
}
