<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190913134239 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE position (id INT AUTO_INCREMENT NOT NULL, department_id INT NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) DEFAULT NULL, INDEX IDX_462CE4F5AE80F5DF (department_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (username VARCHAR(180) NOT NULL, department_id INT NOT NULL, position_id INT NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, surname VARCHAR(255) NOT NULL, INDEX IDX_8D93D649AE80F5DF (department_id), INDEX IDX_8D93D649DD842E46 (position_id), PRIMARY KEY(username)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE absence (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE department (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_absence_document_history (id INT AUTO_INCREMENT NOT NULL, user_id VARCHAR(180) NOT NULL, absence_id INT NOT NULL, created_date DATE NOT NULL, date_from DATE NOT NULL, date_to DATE NOT NULL, INDEX IDX_2E3A388DA76ED395 (user_id), INDEX IDX_2E3A388D2DFF238F (absence_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_absence_document (id INT AUTO_INCREMENT NOT NULL, user_id VARCHAR(180) NOT NULL, absence_id INT NOT NULL, actual_date DATE NOT NULL, date_from DATE NOT NULL, date_to DATE NOT NULL, INDEX IDX_46D6459CA76ED395 (user_id), INDEX IDX_46D6459C2DFF238F (absence_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE position ADD CONSTRAINT FK_462CE4F5AE80F5DF FOREIGN KEY (department_id) REFERENCES department (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649AE80F5DF FOREIGN KEY (department_id) REFERENCES department (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649DD842E46 FOREIGN KEY (position_id) REFERENCES position (id)');
        $this->addSql('ALTER TABLE user_absence_document_history ADD CONSTRAINT FK_2E3A388DA76ED395 FOREIGN KEY (user_id) REFERENCES user (username)');
        $this->addSql('ALTER TABLE user_absence_document_history ADD CONSTRAINT FK_2E3A388D2DFF238F FOREIGN KEY (absence_id) REFERENCES absence (id)');
        $this->addSql('ALTER TABLE user_absence_document ADD CONSTRAINT FK_46D6459CA76ED395 FOREIGN KEY (user_id) REFERENCES user (username)');
        $this->addSql('ALTER TABLE user_absence_document ADD CONSTRAINT FK_46D6459C2DFF238F FOREIGN KEY (absence_id) REFERENCES absence (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649DD842E46');
        $this->addSql('ALTER TABLE user_absence_document_history DROP FOREIGN KEY FK_2E3A388DA76ED395');
        $this->addSql('ALTER TABLE user_absence_document DROP FOREIGN KEY FK_46D6459CA76ED395');
        $this->addSql('ALTER TABLE user_absence_document_history DROP FOREIGN KEY FK_2E3A388D2DFF238F');
        $this->addSql('ALTER TABLE user_absence_document DROP FOREIGN KEY FK_46D6459C2DFF238F');
        $this->addSql('ALTER TABLE position DROP FOREIGN KEY FK_462CE4F5AE80F5DF');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649AE80F5DF');
        $this->addSql('DROP TABLE position');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE absence');
        $this->addSql('DROP TABLE department');
        $this->addSql('DROP TABLE user_absence_document_history');
        $this->addSql('DROP TABLE user_absence_document');
    }
}
