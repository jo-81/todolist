<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250430155733 extends AbstractMigration
{
    public function getDescription(): string
    {
        return "Création de l'entité Label.";
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE label (id INT AUTO_INCREMENT NOT NULL, project_id INT NOT NULL, name VARCHAR(255) NOT NULL, color VARCHAR(50) NOT NULL, INDEX IDX_EA750E8166D1F9C (project_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE task_label (task_id INT NOT NULL, label_id INT NOT NULL, INDEX IDX_C9034BC88DB60186 (task_id), INDEX IDX_C9034BC833B92F39 (label_id), PRIMARY KEY(task_id, label_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE label ADD CONSTRAINT FK_EA750E8166D1F9C FOREIGN KEY (project_id) REFERENCES project (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE task_label ADD CONSTRAINT FK_C9034BC88DB60186 FOREIGN KEY (task_id) REFERENCES task (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE task_label ADD CONSTRAINT FK_C9034BC833B92F39 FOREIGN KEY (label_id) REFERENCES label (id) ON DELETE CASCADE
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE label DROP FOREIGN KEY FK_EA750E8166D1F9C
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE task_label DROP FOREIGN KEY FK_C9034BC88DB60186
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE task_label DROP FOREIGN KEY FK_C9034BC833B92F39
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE label
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE task_label
        SQL);
    }
}
