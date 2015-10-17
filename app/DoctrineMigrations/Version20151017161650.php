<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20151017161650 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE search DROP INDEX UNIQ_B4F0DBA7AA334807, ADD INDEX IDX_B4F0DBA7AA334807 (answer_id)');
        $this->addSql('ALTER TABLE search DROP INDEX UNIQ_B4F0DBA7A76ED395, ADD INDEX IDX_B4F0DBA7A76ED395 (user_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE search DROP INDEX IDX_B4F0DBA7AA334807, ADD UNIQUE INDEX UNIQ_B4F0DBA7AA334807 (answer_id)');
        $this->addSql('ALTER TABLE search DROP INDEX IDX_B4F0DBA7A76ED395, ADD UNIQUE INDEX UNIQ_B4F0DBA7A76ED395 (user_id)');
    }
}
