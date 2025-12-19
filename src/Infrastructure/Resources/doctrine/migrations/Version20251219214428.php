<?php

declare(strict_types=1);

namespace Blabster\Infrastructure\Resources\doctrine\migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251219214428 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE messenger_accounts (login VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, host VARCHAR(255) NOT NULL, uuid BLOB NOT NULL, PRIMARY KEY (uuid))');
        $this->addSql('CREATE TABLE refresh_tokens (value VARCHAR(255) NOT NULL, expires_at DATE NOT NULL, uuid BLOB NOT NULL, user_uuid BLOB NOT NULL, PRIMARY KEY (uuid), CONSTRAINT FK_9BACE7E1ABFE1C6F FOREIGN KEY (user_uuid) REFERENCES users (uuid) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_9BACE7E1ABFE1C6F ON refresh_tokens (user_uuid)');
        $this->addSql('CREATE INDEX idx__refresh_tokens__value ON refresh_tokens (value)');
        $this->addSql('CREATE TABLE users (email VARCHAR(255) NOT NULL, created_at DATE NOT NULL, uuid BLOB NOT NULL, messenger_account_uuid BLOB DEFAULT NULL, PRIMARY KEY (uuid), CONSTRAINT FK_1483A5E9CAF8033F FOREIGN KEY (messenger_account_uuid) REFERENCES messenger_accounts (uuid) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1483A5E9E7927C74 ON users (email)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1483A5E9CAF8033F ON users (messenger_account_uuid)');
        $this->addSql('CREATE INDEX idx__users__email ON users (email)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE messenger_accounts');
        $this->addSql('DROP TABLE refresh_tokens');
        $this->addSql('DROP TABLE users');
    }
}
