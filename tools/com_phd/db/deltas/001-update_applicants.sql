--//

CREATE TABLE IF NOT EXISTS `jos_phd_applicant_user_committee` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `applicant_id` int(11) NOT NULL,
  `user_committee_username` varchar(150) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `applicant_id` (`applicant_id`,`user_committee_username`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

ALTER TABLE `jos_phd_applicants` DROP `committee_username`;

--//@UNDO

DROP TABLE IF EXISTS `jos_phd_applicant_user_committee`;

ALTER TABLE `jos_phd_applicants` ADD `committee_username` VARCHAR(150);

--//
