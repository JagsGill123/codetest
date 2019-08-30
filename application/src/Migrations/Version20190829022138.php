<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190829022138 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE country_country_code (country_id INT NOT NULL, country_code_id INT NOT NULL, INDEX IDX_FC85376EF92F3E70 (country_id), INDEX IDX_FC85376EEE96A67A (country_code_id), PRIMARY KEY(country_id, country_code_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE country_time_zone (country_id INT NOT NULL, time_zone_id INT NOT NULL, INDEX IDX_B8B5CC4AF92F3E70 (country_id), INDEX IDX_B8B5CC4ACBAB9ECD (time_zone_id), PRIMARY KEY(country_id, time_zone_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE country_currency (country_id INT NOT NULL, currency_id INT NOT NULL, INDEX IDX_5A9CD982F92F3E70 (country_id), INDEX IDX_5A9CD98238248176 (currency_id), PRIMARY KEY(country_id, currency_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE country_code (id INT AUTO_INCREMENT NOT NULL, code VARCHAR(3) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE country_country_code ADD CONSTRAINT FK_FC85376EF92F3E70 FOREIGN KEY (country_id) REFERENCES country (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE country_country_code ADD CONSTRAINT FK_FC85376EEE96A67A FOREIGN KEY (country_code_id) REFERENCES country_code (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE country_time_zone ADD CONSTRAINT FK_B8B5CC4AF92F3E70 FOREIGN KEY (country_id) REFERENCES country (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE country_time_zone ADD CONSTRAINT FK_B8B5CC4ACBAB9ECD FOREIGN KEY (time_zone_id) REFERENCES time_zone (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE country_currency ADD CONSTRAINT FK_5A9CD982F92F3E70 FOREIGN KEY (country_id) REFERENCES country (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE country_currency ADD CONSTRAINT FK_5A9CD98238248176 FOREIGN KEY (currency_id) REFERENCES currency (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE country_country_code DROP FOREIGN KEY FK_FC85376EEE96A67A');
        $this->addSql('DROP TABLE country_country_code');
        $this->addSql('DROP TABLE country_time_zone');
        $this->addSql('DROP TABLE country_currency');
        $this->addSql('DROP TABLE country_code');
    }
}
