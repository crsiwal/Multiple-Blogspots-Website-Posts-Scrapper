/* CREATE DATABASE blogs DEFAULT CHARSET = utf8mb4 DEFAULT COLLATE = utf8mb4_unicode_ci; */
USE blogs;

CREATE TABLE `blogs` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `gbid` varchar(32) DEFAULT NULL COMMENT 'Google blogger unique id',
  `title` varchar(128) DEFAULT NULL,
  `url` varchar(512) DEFAULT NULL,
  `posts` int(11) DEFAULT NULL COMMENT 'total number of posts',
  `schedulecount` int(11) DEFAULT NULL COMMENT 'how much posts scheduled to post',
  `postcount` int(11) DEFAULT NULL COMMENT 'how much posted to own website',
  `createtime` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `posts` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `blogid` int(11) NOT NULL COMMENT 'blog id from blogs table',
  `postgid` varchar(128) NOT NULL COMMENT 'post unique id in google blogger',
  `title` varchar(512) DEFAULT NULL COMMENT 'post title',
  `slug` varchar(512) DEFAULT NULL COMMENT 'post slug in english',
  `summery` varchar(512) DEFAULT NULL COMMENT 'post search summery',
  `content` text DEFAULT NULL COMMENT 'post html content',
  `tags` varchar(512) DEFAULT NULL COMMENT 'category comma seperated',
  `status` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1:pending,2:readytopost,3:posted',
  `posttime` datetime DEFAULT NULL COMMENT 'Post schedule time to post on blogspot',
  `createtime` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
