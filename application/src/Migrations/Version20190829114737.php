<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190829114737 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE country_dialing_code (country_id INT NOT NULL, dialing_code_id INT NOT NULL, INDEX IDX_1E07AC1DF92F3E70 (country_id), INDEX IDX_1E07AC1D2922C14C (dialing_code_id), PRIMARY KEY(country_id, dialing_code_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE dialing_code (id INT AUTO_INCREMENT NOT NULL, code VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE country_dialing_code ADD CONSTRAINT FK_1E07AC1DF92F3E70 FOREIGN KEY (country_id) REFERENCES country (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE country_dialing_code ADD CONSTRAINT FK_1E07AC1D2922C14C FOREIGN KEY (dialing_code_id) REFERENCES dialing_code (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE country DROP dialing_code');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE country_dialing_code DROP FOREIGN KEY FK_1E07AC1D2922C14C');
        $this->addSql('DROP TABLE country_dialing_code');
        $this->addSql('DROP TABLE dialing_code');
        $this->addSql('ALTER TABLE country ADD dialing_code VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci');
    }
}
