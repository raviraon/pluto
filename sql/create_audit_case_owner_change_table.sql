CREATE TABLE `audit_case_owner_change` (
`id` int(4) NOT NULL auto_increment,
`fusion_id` varchar(255) NOT NULL default '',
`old_case_owner` varchar(65) NOT NULL default '',
`new_case_owner` varchar(65)  NULL default '',
`updated_by` varchar(65)  NULL default '',
`created_at` DATETIME NULL default NOW(),
PRIMARY KEY (`id`)
) ENGINE=MyISAM;