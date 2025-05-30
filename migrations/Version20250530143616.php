<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250530143616 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE recommandationsia ADD utilisateur_id INT DEFAULT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE recommandationsia ADD CONSTRAINT FK_2097AC82FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateurs (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_2097AC82FB88E14F ON recommandationsia (utilisateur_id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE utilisateurs DROP CONSTRAINT fk_497b315e73742c46
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX idx_497b315e73742c46
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE utilisateurs DROP recommandations_id
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE utilisateurs DROP suggestion
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE SCHEMA public
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE utilisateurs ADD recommandations_id INT DEFAULT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE utilisateurs ADD suggestion VARCHAR(255) NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE utilisateurs ADD CONSTRAINT fk_497b315e73742c46 FOREIGN KEY (recommandations_id) REFERENCES recommandationsia (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX idx_497b315e73742c46 ON utilisateurs (recommandations_id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE recommandationsia DROP CONSTRAINT FK_2097AC82FB88E14F
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_2097AC82FB88E14F
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE recommandationsia DROP utilisateur_id
        SQL);
    }
}
