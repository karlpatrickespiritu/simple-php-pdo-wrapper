/**
* This is a sample database for test purposes.
* First, create a database. Then run this sql file.
**/

-- ----------------------------
-- Table structure for `users`
-- ----------------------------
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `address` varchar(100) NOT NULL,
  `email` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


-- ----------------------------
-- Table structure for `projects`
-- ----------------------------
CREATE TABLE IF NOT EXISTS `projects` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `project_name` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


-- ----------------------------
-- Test data for users
-- ----------------------------
INSERT INTO `users` (`name`, `email`, `address`) VALUES ('John Doe', 'Sesame St., Florida', 'john@somesite.com');
INSERT INTO `users` (`name`, `email`, `address`) VALUES ('Peter Pan', 'Lakers St., Los Angeles', 'peter@somesite.com');
INSERT INTO `users` (`name`, `email`, `address`) VALUES ('Justin Beiber', 'Ipsum St., Los Angeles', 'justin@somesite.com');

-- ----------------------------
-- Test data for projects
-- ----------------------------
INSERT IGNORE INTO `projects` (`user_id`, `project_name`) VALUES (1, 'Facebook');
INSERT IGNORE INTO `projects` (`user_id`, `project_name`) VALUES (1, 'Twitter');

INSERT IGNORE INTO `projects` (`user_id`, `project_name`) VALUES (2, 'LinkedIn');
INSERT IGNORE INTO `projects` (`user_id`, `project_name`) VALUES (2, 'Instagram');

INSERT IGNORE INTO `projects` (`user_id`, `project_name`) VALUES (3, 'Google');
INSERT IGNORE INTO `projects` (`user_id`, `project_name`) VALUES (3, 'Dropbox');