<?php

declare(strict_types=1);

namespace Brille24\SyliusOrderLogPlugin\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200824080653 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE brille24_shipment_log_entry (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, order_id INT NOT NULL, object_id INT NOT NULL, date DATETIME NOT NULL, action VARCHAR(255) NOT NULL, data JSON NOT NULL, INDEX IDX_59247E3A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE brille24_payment_log_entry (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, order_id INT NOT NULL, object_id INT NOT NULL, date DATETIME NOT NULL, action VARCHAR(255) NOT NULL, data JSON NOT NULL, INDEX IDX_F8985A6CA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE brille24_order_log_entry (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, object_id INT NOT NULL, date DATETIME NOT NULL, action VARCHAR(255) NOT NULL, data JSON NOT NULL, INDEX IDX_42E4AC32A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE brille24_shipment_log_entry ADD CONSTRAINT FK_59247E3A76ED395 FOREIGN KEY (user_id) REFERENCES sylius_admin_user (id)');
        $this->addSql('ALTER TABLE brille24_payment_log_entry ADD CONSTRAINT FK_F8985A6CA76ED395 FOREIGN KEY (user_id) REFERENCES sylius_admin_user (id)');
        $this->addSql('ALTER TABLE brille24_order_log_entry ADD CONSTRAINT FK_42E4AC32A76ED395 FOREIGN KEY (user_id) REFERENCES sylius_admin_user (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE brille24_shipment_log_entry');
        $this->addSql('DROP TABLE brille24_payment_log_entry');
        $this->addSql('DROP TABLE brille24_order_log_entry');
    }
}
