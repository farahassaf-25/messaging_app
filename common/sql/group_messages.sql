DROP TABLE IF EXISTS `convoconnect`.`group_messages`;
CREATE TABLE `convoconnect`.`group_messages`(
    `id` INT(11) PRIMARY KEY AUTO_INCREMENT,
    `user_id` INT(11) NOT NULL,
    `group_id` INT(11) NOT NULL,
    `content` VARCHAR(255) NOT NULL,
    `file` blob,
    `createdAt` DATETIME NOT NULL,
  	FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
  	FOREIGN KEY (group_id) REFERENCES groups(id) ON DELETE CASCADE
) ENGINE = InnoDB;
