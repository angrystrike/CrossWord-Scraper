DROP TABLE IF EXISTS `answers`;
CREATE TABLE `answers` (
    `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
    `link` varchar(255) DEFAULT NULL,
    `length` int(11) DEFAULT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `answers`
    ADD INDEX `link` (`link` ASC);

DROP TABLE IF EXISTS `questions`;
CREATE TABLE `questions` (
    `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
    `link` varchar(255) DEFAULT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `questions`
    ADD INDEX `link` (`link` ASC);

DROP TABLE IF EXISTS `questions_answers`;
CREATE TABLE `questions_answers` (
    `question_id` int(10) unsigned NOT NULL,
    `answer_id` int(10) unsigned NOT NULL,
    PRIMARY KEY (`question_id`,`answer_id`),
    FOREIGN KEY (question_id) REFERENCES questions (id) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (answer_id) REFERENCES answers (id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

