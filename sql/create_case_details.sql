CREATE TABLE `case_details` (
id int(4) NOT NULL auto_increment,
user_id int(4) NOT NULL,
customer_name VARCHAR(255) NOT NULL default '',
fusion_id VARCHAR(255) NOT NULL default '',
open_date DATE  NULL,
status VARCHAR(255) NULL,
close_date DATE  NULL,
PRIMARY KEY (`id`),
UNIQUE (fusion_id),
FOREIGN KEY (user_id) REFERENCES Users(id)
) ENGINE=MyISAM;