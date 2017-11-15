<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20171113174722 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->addSql('ALTER TABLE `Comment`
DROP FOREIGN KEY `Comment_ibfk_7`,
ADD FOREIGN KEY (`user_id`) REFERENCES `fos_user_user` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->addSql('ALTER TABLE `Comment`
DROP FOREIGN KEY `Comment_ibfk_8`,
ADD FOREIGN KEY (`user_id`) REFERENCES `fos_user` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT');
    }
}
