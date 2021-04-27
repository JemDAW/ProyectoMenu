<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210427151812 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE pedido_realizado MODIFY id INT NOT NULL');
        $this->addSql('ALTER TABLE pedido_realizado DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE pedido_realizado ADD pedido_id INT NOT NULL, ADD item_id INT NOT NULL, DROP id');
        $this->addSql('ALTER TABLE pedido_realizado ADD CONSTRAINT FK_EF94D0A94854653A FOREIGN KEY (pedido_id) REFERENCES pedido (id)');
        $this->addSql('ALTER TABLE pedido_realizado ADD CONSTRAINT FK_EF94D0A9126F525E FOREIGN KEY (item_id) REFERENCES item (id)');
        $this->addSql('CREATE INDEX IDX_EF94D0A94854653A ON pedido_realizado (pedido_id)');
        $this->addSql('CREATE INDEX IDX_EF94D0A9126F525E ON pedido_realizado (item_id)');
        $this->addSql('ALTER TABLE pedido_realizado ADD PRIMARY KEY (pedido_id, item_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE pedido_realizado DROP FOREIGN KEY FK_EF94D0A94854653A');
        $this->addSql('ALTER TABLE pedido_realizado DROP FOREIGN KEY FK_EF94D0A9126F525E');
        $this->addSql('DROP INDEX IDX_EF94D0A94854653A ON pedido_realizado');
        $this->addSql('DROP INDEX IDX_EF94D0A9126F525E ON pedido_realizado');
        $this->addSql('ALTER TABLE pedido_realizado ADD id INT AUTO_INCREMENT NOT NULL, DROP pedido_id, DROP item_id, DROP PRIMARY KEY, ADD PRIMARY KEY (id)');
    }
}
