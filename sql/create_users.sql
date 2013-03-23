CREATE TABLE `users` (
`id` int(4) NOT NULL auto_increment,
`username` varchar(65) NOT NULL default '',
`password` varchar(65) NOT NULL default '',
`region` varchar(65)  NULL default '',
PRIMARY KEY (`id`)
) ENGINE=MyISAM