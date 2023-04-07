<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230404205226 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE company (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, deleted_at DATETIME DEFAULT NULL, updated_by INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE expense (id INT AUTO_INCREMENT NOT NULL, type_id INT NOT NULL, company_id INT NOT NULL, expense_date DATETIME NOT NULL, amount DOUBLE PRECISION NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, deleted_at DATETIME DEFAULT NULL, updated_by INT NOT NULL, INDEX IDX_2D3A8DA6C54C8C93 (type_id), INDEX IDX_2D3A8DA6979B1AD6 (company_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE expense_type (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, deleted_at DATETIME DEFAULT NULL, updated_by INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, identification_token VARCHAR(255) DEFAULT NULL, username VARCHAR(180) NOT NULL, email VARCHAR(50) NOT NULL, first_name VARCHAR(255) DEFAULT NULL, last_name VARCHAR(255) DEFAULT NULL, birth_date DATE DEFAULT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, deleted_at DATETIME DEFAULT NULL, updated_by INT NOT NULL, UNIQUE INDEX UNIQ_8D93D649F85E0677 (username), UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE expense ADD CONSTRAINT FK_2D3A8DA6C54C8C93 FOREIGN KEY (type_id) REFERENCES expense_type (id)');
        $this->addSql('ALTER TABLE expense ADD CONSTRAINT FK_2D3A8DA6979B1AD6 FOREIGN KEY (company_id) REFERENCES company (id)');

        // Initial data
        $this->addSql("INSERT IGNORE INTO `company` (`id`, `name`, `created_at`, `updated_at`, `deleted_at`, `updated_by`) VALUES
        (1, 'KIssTheBride', now(), now(), NULL, 1),
        (2, 'Giant Consulting', now(), now(), NULL, 1)");

        $this->addSql("INSERT IGNORE INTO `expense_type` (`id`, `name`, `created_at`, `updated_at`, `deleted_at`, `updated_by`) VALUES
        (1, 'General', now(), now(), NULL, 1),
        (2, 'Transport', now(), now(), NULL, 1)");

        $this->addSql("INSERT IGNORE INTO `user` (`id`, `identification_token`, `username`, `first_name`, `last_name`, `birth_date`, `roles`, `password`, `created_at`, `updated_at`, `deleted_at`, `updated_by`, `email`) VALUES
        (1, '69cd0b2596a0c382787e9b8f4ddc28244eb0aad4cefef6b8b6b1ed7b3ec34b67db5badb600a7fe691005ba9c10bf8538477ab43fbf27993af93968c52a9c9e32', 'admin', 'Alain', 'Dubois', '1990-07-14', '{ \"roles\": \"ROLE_ADMIN\"}', 'ChangeThisToEncodedOneOfYourChoosedPassword', now(), now(), NULL, 1, 'alain.d@inexistantdomainename.com')");

        $this->addSql("INSERT IGNORE INTO `expense` (`id`, `type_id`, `company_id`, `expense_date`, `amount`, `created_at`, `updated_at`, `deleted_at`, `updated_by`) VALUES
        (1, 1, 1, '2023-02-16 00:00:00', 112.5, now(), now(), NULL, 1),
        (2, 1, 2, '2023-02-17 00:00:00', 74.58, now(), now(), NULL, 1)");
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE expense DROP FOREIGN KEY FK_2D3A8DA6C54C8C93');
        $this->addSql('ALTER TABLE expense DROP FOREIGN KEY FK_2D3A8DA6979B1AD6');
        $this->addSql('DROP TABLE company');
        $this->addSql('DROP TABLE expense');
        $this->addSql('DROP TABLE expense_type');
        $this->addSql('DROP TABLE user');
    }
}
