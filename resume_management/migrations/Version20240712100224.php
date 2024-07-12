<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240712100224 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE company (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, website VARCHAR(255) NOT NULL, address VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE resume (id INT AUTO_INCREMENT NOT NULL, position VARCHAR(255) NOT NULL, content LONGTEXT DEFAULT NULL, file_path VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, csrf_token VARCHAR(255) NOT NULL UNIQUE, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE resume_feedback (id INT AUTO_INCREMENT NOT NULL, resume_id INT NOT NULL, company_id INT NOT NULL, feedback_type VARCHAR(255) DEFAULT NULL, sent_at DATETIME NOT NULL, INDEX IDX_7CCE6EADD262AF09 (resume_id), INDEX IDX_7CCE6EAD979B1AD6 (company_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE resume_feedback ADD CONSTRAINT FK_7CCE6EADD262AF09 FOREIGN KEY (resume_id) REFERENCES resume (id)');
        $this->addSql('ALTER TABLE resume_feedback ADD CONSTRAINT FK_7CCE6EAD979B1AD6 FOREIGN KEY (company_id) REFERENCES company (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE resume_feedback DROP FOREIGN KEY FK_7CCE6EADD262AF09');
        $this->addSql('ALTER TABLE resume_feedback DROP FOREIGN KEY FK_7CCE6EAD979B1AD6');
        $this->addSql('DROP TABLE company');
        $this->addSql('DROP TABLE resume');
        $this->addSql('DROP TABLE resume_feedback');
    }
}
