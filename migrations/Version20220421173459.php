<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220421173459 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\SqlitePlatform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\SqlitePlatform'."
        );

        $this->addSql('CREATE TABLE pairs (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, date DATE DEFAULT NULL --(DC2Type:date_immutable)
        , base VARCHAR(3) NOT NULL COLLATE BINARY, rate NUMERIC(10, 8) NOT NULL, currency VARCHAR(3) NOT NULL COLLATE BINARY)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_2F694CE9AA9E377AC0B4FE616956883F ON pairs (date, base, currency)');
        $this->addSql('CREATE INDEX IDX_2F694CE96956883F ON pairs (currency)');
        $this->addSql('CREATE INDEX IDX_2F694CE9C0B4FE61 ON pairs (base)');
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\SqlitePlatform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\SqlitePlatform'."
        );

        $this->addSql('CREATE TABLE rates (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, date DATE NOT NULL --(DC2Type:date_immutable)
        , base VARCHAR(3) NOT NULL COLLATE BINARY, rate NUMERIC(10, 8) NOT NULL, currency VARCHAR(3) NOT NULL COLLATE BINARY)');
        $this->addSql('CREATE INDEX IDX_44D4AB3CC0B4FE61 ON rates (base)');
        $this->addSql('CREATE INDEX IDX_44D4AB3C6956883F ON rates (currency)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_44D4AB3CAA9E377AC0B4FE616956883F ON rates (date, base, currency)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\SqlitePlatform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\SqlitePlatform'."
        );

        $this->addSql('DROP TABLE pairs');
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\SqlitePlatform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\SqlitePlatform'."
        );

        $this->addSql('DROP TABLE rates');
    }
}
