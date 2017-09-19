DROP TABLE IF EXISTS `blog_comments`;
CREATE TABLE IF NOT EXISTS `blog_comments` (
  `comment_id` int(11) NOT NULL auto_increment,
  `post_id` int(11) NOT NULL default '0',
  `body` text NOT NULL,
  `created` int(11) default NULL,
  PRIMARY KEY  (`comment_id`)
);

DROP TABLE IF EXISTS `blog_posts`;
CREATE TABLE IF NOT EXISTS `blog_posts` (
  `post_id` int(11) NOT NULL auto_increment,
  `title` varchar(255) NOT NULL default '',
  `body` text NOT NULL,
  `created` int(11) default '0',
  `updated` int(11) default '0',
  `comments_count` int(11) default '0',
  PRIMARY KEY  (`post_id`)
);

DROP TABLE IF EXISTS `blog_posts_tags`;
CREATE TABLE IF NOT EXISTS `blog_posts_tags` (
  `post_id` int(11) NOT NULL default '0',
  `tag_id` int(11) NOT NULL default '0',
  PRIMARY KEY  (`post_id`,`tag_id`)
);

DROP TABLE IF EXISTS `blog_tags`;
CREATE TABLE IF NOT EXISTS `blog_tags` (
  `tag_id` int(11) NOT NULL auto_increment,
  `label` varchar(64) NOT NULL default '',
  PRIMARY KEY  (`tag_id`)
);

DROP TABLE IF EXISTS `roles`;
CREATE TABLE IF NOT EXISTS `roles` (
  `role_id` int(11) NOT NULL auto_increment,
  `rolename` varchar(32) NOT NULL,
  `created` int(11) default NULL,
  `updated` int(11) default NULL,
  PRIMARY KEY  (`role_id`),
  UNIQUE KEY `rolename` (`rolename`)
);

DROP TABLE IF EXISTS `roles_users`;
CREATE TABLE IF NOT EXISTS `roles_users` (
  `user_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  PRIMARY KEY  (`user_id`,`role_id`)
);

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(11) NOT NULL auto_increment,
  `username` varchar(32) NOT NULL,
  `password` varchar(64) NOT NULL,
  `email` varchar(128) NOT NULL,
  `created` int(11) default NULL,
  `updated` int(11) default NULL,
  PRIMARY KEY  (`user_id`),
  UNIQUE KEY `username` (`username`)
);

DROP TABLE IF EXISTS `product_classes`;
CREATE TABLE IF NOT EXISTS `product_classes` (
  `class_id` int(11) NOT NULL auto_increment,
  `parent_id` int(11) NOT NULL,
  `name` varchar(64) NOT NULL,
  `left_value` int(11) NOT NULL,
  `right_value` int(11) NOT NULL,
  `created` int(11) NOT NULL,
  `updated` int(11) NOT NULL,
  PRIMARY KEY  (`class_id`),
  KEY `left_value` (`left_value`),
  KEY `right_value` (`right_value`),
  KEY `parent_id` (`parent_id`)
) AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `product_photos`;
CREATE TABLE IF NOT EXISTS `product_photos` (
  `photo_id` int(11) NOT NULL auto_increment,
  `product_id` int(11) NOT NULL default '0',
  `photo_filename` varchar(255) NOT NULL,
  `created` int(11) NOT NULL,
  PRIMARY KEY  (`photo_id`),
  KEY `product_id` (`product_id`)
) AUTO_INCREMENT=8 ;

DROP TABLE IF EXISTS `products`;
CREATE TABLE IF NOT EXISTS `products` (
  `product_id` int(11) NOT NULL auto_increment,
  `name` varchar(128) NOT NULL,
  `price` float NOT NULL default '0',
  `created` int(11) NOT NULL,
  `updated` int(11) NOT NULL,
  `overview` mediumtext NOT NULL,
  `thumb_filename` varchar(255) default NULL,
  PRIMARY KEY  (`product_id`)
) AUTO_INCREMENT=3 ;

DROP TABLE IF EXISTS `products_to_classes`;
CREATE TABLE IF NOT EXISTS `products_to_classes` (
  `product_id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  PRIMARY KEY  (`product_id`,`class_id`)
);

DROP TABLE IF EXISTS `sysroles`;
CREATE TABLE IF NOT EXISTS `sysroles` (
  `role_id` int(11) NOT NULL auto_increment,
  `rolename` varchar(64) NOT NULL,
  `created` int(11) NOT NULL,
  `updated` int(11) NOT NULL,
  PRIMARY KEY  (`role_id`)
) AUTO_INCREMENT=2 ;

INSERT INTO `sysroles` (`role_id`, `rolename`, `created`, `updated`) VALUES (1, 'SYSTEM_ADMIN', 1160384341, 1160384341);

DROP TABLE IF EXISTS `sysusers`;
CREATE TABLE IF NOT EXISTS `sysusers` (
  `user_id` int(11) NOT NULL auto_increment,
  `username` varchar(32) NOT NULL default '',
  `password` varchar(64) NOT NULL default '',
  `email` varchar(128) NOT NULL default '',
  `created` int(11) NOT NULL,
  `updated` int(11) NOT NULL,
  PRIMARY KEY  (`user_id`)
) AUTO_INCREMENT=2 ;

INSERT INTO `sysusers` (`user_id`, `username`, `password`, `email`, `created`, `updated`) VALUES (1, 'admin', '$1$.y3.ta3.$Jk5.iyx3OT9IZlhJ8CKQy/', 'admin@fleaphp.org', 1147346244, 1149173702);

DROP TABLE IF EXISTS `sysusers_sysroles`;
CREATE TABLE IF NOT EXISTS `sysusers_sysroles` (
  `user_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  PRIMARY KEY  (`user_id`,`role_id`)
);

INSERT INTO `sysusers_sysroles` (`user_id`, `role_id`) VALUES (1, 1);

DROP TABLE IF EXISTS `mvc_posts`;
CREATE TABLE `mvc_posts` (
  `id` int(11) NOT NULL auto_increment,
  `title` varchar(255) NOT NULL,
  `body` text NOT NULL,
  `created` DATETIME default NULL,
  `updated` DATETIME default NULL,
  PRIMARY KEY  (`id`)
);

INSERT INTO `mvc_posts` (`title`, `body`, `created`, `updated`) VALUES ('标题1', '内容1', NOW(), NOW());
INSERT INTO `mvc_posts` (`title`, `body`, `created`, `updated`) VALUES ('标题2', '内容2', NOW(), NOW());
INSERT INTO `mvc_posts` (`title`, `body`, `created`, `updated`) VALUES ('标题3', '内容3', NOW(), NOW());
