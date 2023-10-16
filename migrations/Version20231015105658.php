<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231015105658 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE address_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE dimensions_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE full_name_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE parcel_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE recipient_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE sender_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE address (id INT NOT NULL, country VARCHAR(255) NOT NULL, city VARCHAR(255) NOT NULL, street VARCHAR(255) NOT NULL, building VARCHAR(255) NOT NULL, apartment VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE dimensions (id INT NOT NULL, weight INT NOT NULL, length INT NOT NULL, height INT NOT NULL, width INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE full_name (id INT NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, middle_name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE parcel (id INT NOT NULL, dimensions_id INT NOT NULL, recipient_id INT NOT NULL, sender_id INT NOT NULL, estimated_cost INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C99B5D604F311658 ON parcel (dimensions_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C99B5D60E92F8F78 ON parcel (recipient_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C99B5D60F624B39D ON parcel (sender_id)');
        $this->addSql('CREATE TABLE recipient (id INT NOT NULL, full_name_id INT NOT NULL, address_id INT NOT NULL, phone VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_6804FB49223EC5BA ON recipient (full_name_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_6804FB49F5B7AF75 ON recipient (address_id)');
        $this->addSql('CREATE TABLE sender (id INT NOT NULL, full_name_id INT NOT NULL, address_id INT NOT NULL, phone VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_5F004ACF223EC5BA ON sender (full_name_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_5F004ACFF5B7AF75 ON sender (address_id)');
        $this->addSql('ALTER TABLE parcel ADD CONSTRAINT FK_C99B5D604F311658 FOREIGN KEY (dimensions_id) REFERENCES dimensions (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE parcel ADD CONSTRAINT FK_C99B5D60E92F8F78 FOREIGN KEY (recipient_id) REFERENCES recipient (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE parcel ADD CONSTRAINT FK_C99B5D60F624B39D FOREIGN KEY (sender_id) REFERENCES sender (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE recipient ADD CONSTRAINT FK_6804FB49223EC5BA FOREIGN KEY (full_name_id) REFERENCES full_name (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE recipient ADD CONSTRAINT FK_6804FB49F5B7AF75 FOREIGN KEY (address_id) REFERENCES address (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE sender ADD CONSTRAINT FK_5F004ACF223EC5BA FOREIGN KEY (full_name_id) REFERENCES full_name (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE sender ADD CONSTRAINT FK_5F004ACFF5B7AF75 FOREIGN KEY (address_id) REFERENCES address (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE address_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE dimensions_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE full_name_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE parcel_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE recipient_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE sender_id_seq CASCADE');
        $this->addSql('ALTER TABLE parcel DROP CONSTRAINT FK_C99B5D604F311658');
        $this->addSql('ALTER TABLE parcel DROP CONSTRAINT FK_C99B5D60E92F8F78');
        $this->addSql('ALTER TABLE parcel DROP CONSTRAINT FK_C99B5D60F624B39D');
        $this->addSql('ALTER TABLE recipient DROP CONSTRAINT FK_6804FB49223EC5BA');
        $this->addSql('ALTER TABLE recipient DROP CONSTRAINT FK_6804FB49F5B7AF75');
        $this->addSql('ALTER TABLE sender DROP CONSTRAINT FK_5F004ACF223EC5BA');
        $this->addSql('ALTER TABLE sender DROP CONSTRAINT FK_5F004ACFF5B7AF75');
        $this->addSql('DROP TABLE address');
        $this->addSql('DROP TABLE dimensions');
        $this->addSql('DROP TABLE full_name');
        $this->addSql('DROP TABLE parcel');
        $this->addSql('DROP TABLE recipient');
        $this->addSql('DROP TABLE sender');
    }
}
