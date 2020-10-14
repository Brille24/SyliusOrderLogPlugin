<?php

declare(strict_types=1);

namespace Brille24\SyliusOrderLogPlugin\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201014101852 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE brille24_order_log_entry (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, object_id INT NOT NULL, date DATETIME NOT NULL, action VARCHAR(255) NOT NULL, data LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', INDEX IDX_42E4AC32A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE brille24_payment_log_entry (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, order_id INT NOT NULL, object_id INT NOT NULL, date DATETIME NOT NULL, action VARCHAR(255) NOT NULL, data LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', INDEX IDX_F8985A6CA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE brille24_shipment_log_entry (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, order_id INT NOT NULL, object_id INT NOT NULL, date DATETIME NOT NULL, action VARCHAR(255) NOT NULL, data LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', INDEX IDX_59247E3A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE brille24_order_log_entry ADD CONSTRAINT FK_42E4AC32A76ED395 FOREIGN KEY (user_id) REFERENCES sylius_admin_user (id)');
        $this->addSql('ALTER TABLE brille24_payment_log_entry ADD CONSTRAINT FK_F8985A6CA76ED395 FOREIGN KEY (user_id) REFERENCES sylius_admin_user (id)');
        $this->addSql('ALTER TABLE brille24_shipment_log_entry ADD CONSTRAINT FK_59247E3A76ED395 FOREIGN KEY (user_id) REFERENCES sylius_admin_user (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE brille24_order_log_entry');
        $this->addSql('DROP TABLE brille24_payment_log_entry');
        $this->addSql('DROP TABLE brille24_shipment_log_entry');
    }
}
