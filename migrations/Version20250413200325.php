<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250413200325 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TEMPORARY TABLE __temp__mood_entry AS SELECT id, user_id, mood_type, timestamp, note FROM mood_entry
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE mood_entry
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE mood_entry (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, user_id INTEGER NOT NULL, mood_type VARCHAR(30) NOT NULL, timestamp DATETIME NOT NULL, note CLOB NOT NULL, CONSTRAINT FK_22A0A36DA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE)
        SQL);
        $this->addSql(<<<'SQL'
            INSERT INTO mood_entry (id, user_id, mood_type, timestamp, note) SELECT id, user_id, mood_type, timestamp, note FROM __temp__mood_entry
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE __temp__mood_entry
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_22A0A36DA76ED395 ON mood_entry (user_id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TEMPORARY TABLE __temp__mood_entry AS SELECT id, user_id, mood_type, timestamp, note FROM mood_entry
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE mood_entry
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE mood_entry (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, user_id INTEGER NOT NULL, mood_type VARCHAR(30) NOT NULL, timestamp DATETIME NOT NULL, note CLOB NOT NULL, CONSTRAINT FK_22A0A36DA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)
        SQL);
        $this->addSql(<<<'SQL'
            INSERT INTO mood_entry (id, user_id, mood_type, timestamp, note) SELECT id, user_id, mood_type, timestamp, note FROM __temp__mood_entry
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE __temp__mood_entry
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_22A0A36DA76ED395 ON mood_entry (user_id)
        SQL);
    }
}
