<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240409134222 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE avis (id_avi INT AUTO_INCREMENT NOT NULL, id_user INT DEFAULT NULL, note INT NOT NULL, message VARCHAR(255) NOT NULL, date DATE NOT NULL, coursId INT DEFAULT NULL, INDEX IDX_8F91ABF06B3CA4B (id_user), INDEX IDX_8F91ABF01347B425 (coursId), PRIMARY KEY(id_avi)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE categorie (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, description VARCHAR(500) DEFAULT NULL, last_updated DATE DEFAULT NULL, image VARCHAR(600) DEFAULT NULL, nbSousCategorie INT DEFAULT 0 NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commentaires (id INT AUTO_INCREMENT NOT NULL, id_pub INT DEFAULT NULL, user_id INT DEFAULT NULL, commentaire VARCHAR(500) NOT NULL, date DATETIME NOT NULL, INDEX IDX_D9BEC0C4C4E0D4DF (id_pub), INDEX IDX_D9BEC0C4A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cours (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(80) NOT NULL, image VARCHAR(255) DEFAULT NULL, description LONGTEXT NOT NULL, tags VARCHAR(60) DEFAULT NULL, isValidated TINYINT(1) NOT NULL, slug VARCHAR(255) DEFAULT NULL, views INT DEFAULT NULL, subCategoryId INT DEFAULT NULL, niveauId INT DEFAULT NULL, enseignantId INT DEFAULT NULL, INDEX IDX_FDCA8C9C8CFBEF02 (subCategoryId), INDEX IDX_FDCA8C9C880019E7 (niveauId), INDEX IDX_FDCA8C9C367072A4 (enseignantId), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE lessons (id INT AUTO_INCREMENT NOT NULL, titre VARCHAR(80) NOT NULL, content LONGTEXT NOT NULL, duree INT DEFAULT NULL, image VARCHAR(255) DEFAULT NULL, video VARCHAR(80) DEFAULT NULL, classement INT NOT NULL, coursId INT DEFAULT NULL, INDEX IDX_3F4218D91347B425 (coursId), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE level (id INT AUTO_INCREMENT NOT NULL, niveau VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE notes (id INT AUTO_INCREMENT NOT NULL, note DOUBLE PRECISION NOT NULL, userId INT DEFAULT NULL, quizId INT DEFAULT NULL, INDEX IDX_11BA68C64B64DCC (userId), INDEX IDX_11BA68C34A2147A (quizId), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE publications (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, titre VARCHAR(255) NOT NULL, contenu VARCHAR(500) NOT NULL, images VARCHAR(600) NOT NULL, date_creation DATETIME NOT NULL, nbClicks INT DEFAULT NULL, INDEX IDX_32783AF4A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE questions (id INT AUTO_INCREMENT NOT NULL, question VARCHAR(255) NOT NULL, image VARCHAR(255) DEFAULT NULL, quizId INT DEFAULT NULL, userId INT DEFAULT NULL, INDEX IDX_8ADC54D534A2147A (quizId), INDEX IDX_8ADC54D564B64DCC (userId), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE quiz (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, duree VARCHAR(255) NOT NULL, userId INT DEFAULT NULL, coursId INT DEFAULT NULL, INDEX IDX_A412FA9264B64DCC (userId), INDEX IDX_A412FA921347B425 (coursId), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reactions (id INT AUTO_INCREMENT NOT NULL, pub_id INT DEFAULT NULL, user_id INT DEFAULT NULL, jaime INT NOT NULL, dislike INT NOT NULL, INDEX IDX_38737FB383FDE077 (pub_id), INDEX IDX_38737FB3A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reclamations (id_reclamation INT AUTO_INCREMENT NOT NULL, id_user INT DEFAULT NULL, type VARCHAR(255) NOT NULL, description VARCHAR(700) NOT NULL, status VARCHAR(255) NOT NULL, date DATE NOT NULL, repondre TINYINT(1) DEFAULT NULL, INDEX IDX_1CAD6B766B3CA4B (id_user), PRIMARY KEY(id_reclamation)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ressources (id INT AUTO_INCREMENT NOT NULL, lien VARCHAR(250) NOT NULL, type VARCHAR(60) NOT NULL, coursId INT DEFAULT NULL, INDEX IDX_6A2CD5C71347B425 (coursId), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE souscategorie (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, description VARCHAR(500) DEFAULT NULL, images VARCHAR(600) DEFAULT NULL, status VARCHAR(255) DEFAULT NULL, dateCreation DATE DEFAULT NULL, categorieId INT DEFAULT NULL, INDEX IDX_6FF3A701FE278E99 (categorieId), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE suggestion (id INT AUTO_INCREMENT NOT NULL, suggestion VARCHAR(255) NOT NULL, status TINYINT(1) NOT NULL, questionId INT DEFAULT NULL, INDEX IDX_DD80F31B4B476EBA (questionId), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, level_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, username VARCHAR(255) NOT NULL, date_de_naissance DATE DEFAULT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, role VARCHAR(255) DEFAULT NULL, status VARCHAR(255) DEFAULT NULL, token VARCHAR(255) DEFAULT NULL, image VARCHAR(255) DEFAULT NULL, INDEX IDX_8D93D6495FB14BA7 (level_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE usercours (id INT AUTO_INCREMENT NOT NULL, isCorrectQuizz TINYINT(1) NOT NULL, stage INT NOT NULL, isCompleted TINYINT(1) NOT NULL, enrollmentDate DATE DEFAULT CURRENT_TIMESTAMP NOT NULL, completedDate DATE DEFAULT NULL, coursId INT DEFAULT NULL, userId INT DEFAULT NULL, INDEX IDX_DA6EB04E1347B425 (coursId), INDEX IDX_DA6EB04E64B64DCC (userId), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE avis ADD CONSTRAINT FK_8F91ABF06B3CA4B FOREIGN KEY (id_user) REFERENCES user (id)');
        $this->addSql('ALTER TABLE avis ADD CONSTRAINT FK_8F91ABF01347B425 FOREIGN KEY (coursId) REFERENCES cours (id)');
        $this->addSql('ALTER TABLE commentaires ADD CONSTRAINT FK_D9BEC0C4C4E0D4DF FOREIGN KEY (id_pub) REFERENCES publications (id)');
        $this->addSql('ALTER TABLE commentaires ADD CONSTRAINT FK_D9BEC0C4A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE cours ADD CONSTRAINT FK_FDCA8C9C8CFBEF02 FOREIGN KEY (subCategoryId) REFERENCES souscategorie (id)');
        $this->addSql('ALTER TABLE cours ADD CONSTRAINT FK_FDCA8C9C880019E7 FOREIGN KEY (niveauId) REFERENCES level (id)');
        $this->addSql('ALTER TABLE cours ADD CONSTRAINT FK_FDCA8C9C367072A4 FOREIGN KEY (enseignantId) REFERENCES user (id)');
        $this->addSql('ALTER TABLE lessons ADD CONSTRAINT FK_3F4218D91347B425 FOREIGN KEY (coursId) REFERENCES cours (id)');
        $this->addSql('ALTER TABLE notes ADD CONSTRAINT FK_11BA68C64B64DCC FOREIGN KEY (userId) REFERENCES user (id)');
        $this->addSql('ALTER TABLE notes ADD CONSTRAINT FK_11BA68C34A2147A FOREIGN KEY (quizId) REFERENCES quiz (id)');
        $this->addSql('ALTER TABLE publications ADD CONSTRAINT FK_32783AF4A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE questions ADD CONSTRAINT FK_8ADC54D534A2147A FOREIGN KEY (quizId) REFERENCES quiz (id)');
        $this->addSql('ALTER TABLE questions ADD CONSTRAINT FK_8ADC54D564B64DCC FOREIGN KEY (userId) REFERENCES user (id)');
        $this->addSql('ALTER TABLE quiz ADD CONSTRAINT FK_A412FA9264B64DCC FOREIGN KEY (userId) REFERENCES user (id)');
        $this->addSql('ALTER TABLE quiz ADD CONSTRAINT FK_A412FA921347B425 FOREIGN KEY (coursId) REFERENCES cours (id)');
        $this->addSql('ALTER TABLE reactions ADD CONSTRAINT FK_38737FB383FDE077 FOREIGN KEY (pub_id) REFERENCES publications (id)');
        $this->addSql('ALTER TABLE reactions ADD CONSTRAINT FK_38737FB3A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE reclamations ADD CONSTRAINT FK_1CAD6B766B3CA4B FOREIGN KEY (id_user) REFERENCES user (id)');
        $this->addSql('ALTER TABLE ressources ADD CONSTRAINT FK_6A2CD5C71347B425 FOREIGN KEY (coursId) REFERENCES cours (id)');
        $this->addSql('ALTER TABLE souscategorie ADD CONSTRAINT FK_6FF3A701FE278E99 FOREIGN KEY (categorieId) REFERENCES categorie (id)');
        $this->addSql('ALTER TABLE suggestion ADD CONSTRAINT FK_DD80F31B4B476EBA FOREIGN KEY (questionId) REFERENCES questions (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6495FB14BA7 FOREIGN KEY (level_id) REFERENCES level (id)');
        $this->addSql('ALTER TABLE usercours ADD CONSTRAINT FK_DA6EB04E1347B425 FOREIGN KEY (coursId) REFERENCES cours (id)');
        $this->addSql('ALTER TABLE usercours ADD CONSTRAINT FK_DA6EB04E64B64DCC FOREIGN KEY (userId) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE avis DROP FOREIGN KEY FK_8F91ABF06B3CA4B');
        $this->addSql('ALTER TABLE avis DROP FOREIGN KEY FK_8F91ABF01347B425');
        $this->addSql('ALTER TABLE commentaires DROP FOREIGN KEY FK_D9BEC0C4C4E0D4DF');
        $this->addSql('ALTER TABLE commentaires DROP FOREIGN KEY FK_D9BEC0C4A76ED395');
        $this->addSql('ALTER TABLE cours DROP FOREIGN KEY FK_FDCA8C9C8CFBEF02');
        $this->addSql('ALTER TABLE cours DROP FOREIGN KEY FK_FDCA8C9C880019E7');
        $this->addSql('ALTER TABLE cours DROP FOREIGN KEY FK_FDCA8C9C367072A4');
        $this->addSql('ALTER TABLE lessons DROP FOREIGN KEY FK_3F4218D91347B425');
        $this->addSql('ALTER TABLE notes DROP FOREIGN KEY FK_11BA68C64B64DCC');
        $this->addSql('ALTER TABLE notes DROP FOREIGN KEY FK_11BA68C34A2147A');
        $this->addSql('ALTER TABLE publications DROP FOREIGN KEY FK_32783AF4A76ED395');
        $this->addSql('ALTER TABLE questions DROP FOREIGN KEY FK_8ADC54D534A2147A');
        $this->addSql('ALTER TABLE questions DROP FOREIGN KEY FK_8ADC54D564B64DCC');
        $this->addSql('ALTER TABLE quiz DROP FOREIGN KEY FK_A412FA9264B64DCC');
        $this->addSql('ALTER TABLE quiz DROP FOREIGN KEY FK_A412FA921347B425');
        $this->addSql('ALTER TABLE reactions DROP FOREIGN KEY FK_38737FB383FDE077');
        $this->addSql('ALTER TABLE reactions DROP FOREIGN KEY FK_38737FB3A76ED395');
        $this->addSql('ALTER TABLE reclamations DROP FOREIGN KEY FK_1CAD6B766B3CA4B');
        $this->addSql('ALTER TABLE ressources DROP FOREIGN KEY FK_6A2CD5C71347B425');
        $this->addSql('ALTER TABLE souscategorie DROP FOREIGN KEY FK_6FF3A701FE278E99');
        $this->addSql('ALTER TABLE suggestion DROP FOREIGN KEY FK_DD80F31B4B476EBA');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6495FB14BA7');
        $this->addSql('ALTER TABLE usercours DROP FOREIGN KEY FK_DA6EB04E1347B425');
        $this->addSql('ALTER TABLE usercours DROP FOREIGN KEY FK_DA6EB04E64B64DCC');
        $this->addSql('DROP TABLE avis');
        $this->addSql('DROP TABLE categorie');
        $this->addSql('DROP TABLE commentaires');
        $this->addSql('DROP TABLE cours');
        $this->addSql('DROP TABLE lessons');
        $this->addSql('DROP TABLE level');
        $this->addSql('DROP TABLE notes');
        $this->addSql('DROP TABLE publications');
        $this->addSql('DROP TABLE questions');
        $this->addSql('DROP TABLE quiz');
        $this->addSql('DROP TABLE reactions');
        $this->addSql('DROP TABLE reclamations');
        $this->addSql('DROP TABLE ressources');
        $this->addSql('DROP TABLE souscategorie');
        $this->addSql('DROP TABLE suggestion');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE usercours');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
