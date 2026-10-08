<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20261008071206 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE evenement (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, date DATETIME NOT NULL, lieu VARCHAR(255) NOT NULL, createur_id INT NOT NULL, INDEX IDX_B26681E73A201E5 (createur_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE evenement ADD CONSTRAINT FK_B26681E73A201E5 FOREIGN KEY (createur_id) REFERENCES user (id)');
        $this->addSql('DROP TABLE nom');
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY `FK_67F068BC8F3EC46`');
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY `FK_67F068BC9D86650F`');
        $this->addSql('DROP INDEX IDX_67F068BC9D86650F ON commentaire');
        $this->addSql('DROP INDEX IDX_67F068BC8F3EC46 ON commentaire');
        $this->addSql('ALTER TABLE commentaire ADD article_id_id INT DEFAULT NULL, ADD user_id_id INT DEFAULT NULL, DROP article_id, DROP user_id');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BC8F3EC46 FOREIGN KEY (article_id_id) REFERENCES article (id)');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BC9D86650F FOREIGN KEY (user_id_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_67F068BC9D86650F ON commentaire (user_id_id)');
        $this->addSql('CREATE INDEX IDX_67F068BC8F3EC46 ON commentaire (article_id_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE nom (id INT AUTO_INCREMENT NOT NULL, prenom VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, date_naissance DATETIME NOT NULL, date_inscription DATETIME NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE evenement DROP FOREIGN KEY FK_B26681E73A201E5');
        $this->addSql('DROP TABLE evenement');
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY FK_67F068BC8F3EC46');
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY FK_67F068BC9D86650F');
        $this->addSql('DROP INDEX IDX_67F068BC8F3EC46 ON commentaire');
        $this->addSql('DROP INDEX IDX_67F068BC9D86650F ON commentaire');
        $this->addSql('ALTER TABLE commentaire ADD article_id INT DEFAULT NULL, ADD user_id INT DEFAULT NULL, DROP article_id_id, DROP user_id_id');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT `FK_67F068BC8F3EC46` FOREIGN KEY (article_id) REFERENCES article (id)');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT `FK_67F068BC9D86650F` FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_67F068BC8F3EC46 ON commentaire (article_id)');
        $this->addSql('CREATE INDEX IDX_67F068BC9D86650F ON commentaire (user_id)');
    }
}
