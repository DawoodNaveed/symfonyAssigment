<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201021064836 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE order_book (id INT AUTO_INCREMENT NOT NULL, book_id_id INT NOT NULL, user_email_id INT NOT NULL, processing TINYINT(1) NOT NULL, INDEX IDX_8614992671868B2E (book_id_id), INDEX IDX_8614992648BF25C9 (user_email_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE order_book ADD CONSTRAINT FK_8614992671868B2E FOREIGN KEY (book_id_id) REFERENCES books (id)');
        $this->addSql('ALTER TABLE order_book ADD CONSTRAINT FK_8614992648BF25C9 FOREIGN KEY (user_email_id) REFERENCES user (id)');
        $this->addSql('DROP TABLE `order`');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE `order` (id INT AUTO_INCREMENT NOT NULL, book_id_id INT NOT NULL, user_email_id INT NOT NULL, INDEX IDX_F529939848BF25C9 (user_email_id), INDEX IDX_F529939871868B2E (book_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F529939848BF25C9 FOREIGN KEY (user_email_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F529939871868B2E FOREIGN KEY (book_id_id) REFERENCES books (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('DROP TABLE order_book');
    }
}
