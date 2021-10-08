<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211004164917 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE shorten_url (id INT AUTO_INCREMENT NOT NULL, token_id INT NOT NULL, publicurl_id INT NOT NULL, status_id INT NOT NULL, UNIQUE INDEX UNIQ_5D9D39B741DEE7B9 (token_id), UNIQUE INDEX UNIQ_5D9D39B7FA58897B (publicurl_id), INDEX IDX_5D9D39B76BF700BD (status_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE status (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE token (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, generated_token VARCHAR(50) NOT NULL, description VARCHAR(255) DEFAULT NULL, INDEX IDX_5F37A13BA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE shorten_url ADD CONSTRAINT FK_5D9D39B741DEE7B9 FOREIGN KEY (token_id) REFERENCES token (id)');
        $this->addSql('ALTER TABLE shorten_url ADD CONSTRAINT FK_5D9D39B7FA58897B FOREIGN KEY (publicurl_id) REFERENCES public_url (id)');
        $this->addSql('ALTER TABLE shorten_url ADD CONSTRAINT FK_5D9D39B76BF700BD FOREIGN KEY (status_id) REFERENCES status (id)');
        $this->addSql('ALTER TABLE token ADD CONSTRAINT FK_5F37A13BA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE shorten_url DROP FOREIGN KEY FK_5D9D39B76BF700BD');
        $this->addSql('ALTER TABLE shorten_url DROP FOREIGN KEY FK_5D9D39B741DEE7B9');
        $this->addSql('DROP TABLE shorten_url');
        $this->addSql('DROP TABLE status');
        $this->addSql('DROP TABLE token');
    }
}
