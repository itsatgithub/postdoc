--
-- Table structure for table `jos_irbtools_users`
--

CREATE TABLE IF NOT EXISTS `jos_irbtools_users` (
  `username` VARCHAR( 20 ) NOT NULL,
  PRIMARY KEY ( `username` )
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

--
-- Table structure for table `jos_irbtools_apps`
--

CREATE TABLE IF NOT EXISTS `jos_irbtools_apps` (
  `appname` VARCHAR( 20 ) NOT NULL,
  PRIMARY KEY ( `appname` )
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

--
-- Table structure for table `jos_irbtools_user_app`
--

CREATE TABLE IF NOT EXISTS `jos_irbtools_user_app` (
  `username` varchar(20) NOT NULL,
  `appname` varchar(20) NOT NULL,
  PRIMARY KEY  (`username`,`appname`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Table structure for table `jos_irbtools_exceptions`
--

CREATE TABLE IF NOT EXISTS `jos_irbtools_exceptions` (
  `id` int(11) NOT NULL auto_increment,
  `command` varchar(3) NOT NULL,
  `irbpeople_user_id` varchar(10) NOT NULL,
  `name` varchar(255) NOT NULL,
  `surname` varchar(255) NOT NULL,
  `gender` varchar(255) NOT NULL,
  `department` varchar(255) NOT NULL,
  `unit` varchar(255) NOT NULL,
  `research_group` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `position` varchar(255) NOT NULL,
  `location` varchar(255) NOT NULL,
  `second_affiliation` varchar(255) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `jos_irbtools_exceptions`
--

INSERT INTO `jos_irbtools_exceptions` (`id`, `command`, `irbpeople_user_id`, `name`, `surname`, `department`, `unit`, `research_group`, `email`, `phone`, `position`, `location`, `second_affiliation`, `modified`) VALUES
(1, 'add', '691', 'Santiago', 'Esteban ', 'Research Programmes', 'Structural & Computational Biology', 'Modesto Orozco: Molecular modelling and bioinformatics', 'santiago.esteban@irbbarcelona.org', '+34 93 40 20460', 'Postdoctoral Fellow', 'EMPBC31', '', '0000-00-00 00:00:00'),
(2, 'add', '731', 'Francesc', 'Miro', 'Research Programmes', 'Molecular Medicine', 'Antonio Celada:Gene expression', 'francesc.miro@irbbarcelona.org', '+34 93 40 34867', 'Postdoctoral Fellow', 'EMPBC53 ', '', '0000-00-00 00:00:00'),
(3, 'add', '781', 'Maria Florencia', 'Tevy', 'Research Programmes', 'Cell & Developmental Biology', 'Marco Milan: Development and Growth Control Laboratory', 'florencia.tevy@irbbarcelona.org', '+34 93 40 37163', 'Postdoctoral Fellow', 'EMPBB21', '', '0000-00-00 00:00:00'),
(4, 'add', '717', 'Neus', 'Teixidó', 'Research Programmes', 'Molecular Medicine', 'Carme Caelles: Cell signalling', 'neus.teixido@irbbarcelona.org', '+34 93 40 20201', 'Postdoctoral Fellow', 'EMPBA21', '', '0000-00-00 00:00:00'),
(5, 'add', '680', 'Chiara Lara', 'Castellazzi', 'Research Programmes', 'Structural & Computational Biology', 'Modesto Orozco: Molecular modelling and bioinformatics', 'chiara.castellazzi@irbbarcelona.org', '+34 93 40 20228', 'Research Assistant', 'EMS1B13', '', '0000-00-00 00:00:00'),
(6, 'add', '700', 'Kathryn', 'Collinet', 'Research Programmes', 'Structural & Computational Biology', 'Montse Soler: Experimental Bioinformatics Laboratory', 'kathryn.collinet@irbbarcelona.org', '+34 93 40 20228', 'Postdoctoral Fellow', 'EMS1B13', '', '0000-00-00 00:00:00'),
(7, 'add', '670', 'Ozgen', 'Deniz', 'Research Programmes', 'Structural & Computational Biology', 'Montse Soler: Experimental Bioinformatics Laboratory', 'ozgen.deniz@irbbarcelona.org', '+34 93 40 20228', 'PhD Student', 'EMPBC33', '', '0000-00-00 00:00:00'),
(8, 'add', '693', 'Elisa', 'Durán', 'Research Programmes', 'Structural & Computational Biology', 'Modesto Orozco: Molecular modelling and bioinformatics', 'elisa.duran@irbbarcelona.org', '+34 93 40 20228', 'PhD Student', 'EMS1B13', '', '0000-00-00 00:00:00'),
(9, 'add', '690', 'Guillermo', 'Suñé', 'Research Programmes', 'Structural & Computational Biology', 'Montse Soler: Experimental Bioinformatics Laboratory', 'guillermo.sune@irbbarcelona.org', '+34 93 40 20228', 'Postdoctoral Fellow', 'EMS1B13', '', '0000-00-00 00:00:00'),
(10, 'add', '695', 'Rodrigo', 'Arroyo', 'Research Programmes', 'Structural & Computational Biology', 'Patrick Aloy: Structural Bioinformatics and Network Biology', 'rodrigo.arroyo@irbbarcelona.org', '+34 93 40 20228', 'PhD Student', 'EMS1B13', '', '0000-00-00 00:00:00'),
(11, 'add', '17', 'Joan J.', 'Guinovart', 'Research Programmes', 'Molecular Medicine', 'Joan J. Guinovart: Metabolic engineering and diabetes', 'guinovart@irbbarcelona.org', '+34 93 40 37110', 'Group Leader', 'EMPBB13', '', '0000-00-00 00:00:00'),
(12, 'del', '704', '', '', '', '', '', '', '', '', '', '', '0000-00-00 00:00:00'),
(13, 'del', '728', '', '', '', '', '', '', '', '', '', '', '0000-00-00 00:00:00'),
(14, 'del', '754', '', '', '', '', '', '', '', '', '', '', '0000-00-00 00:00:00'),
(15, 'del', '793', '', '', '', '', '', '', '', '', '', '', '0000-00-00 00:00:00'),
(16, 'del', '709', '', '', '', '', '', '', '', '', '', '', '0000-00-00 00:00:00'),
(17, 'del', '116', '', '', '', '', '', '', '', '', '', '', '0000-00-00 00:00:00'),
(18, 'del', '272', '', '', '', '', '', '', '', '', '', '', '0000-00-00 00:00:00'),
(19, 'del', '673', '', '', '', '', '', '', '', '', '', '', '0000-00-00 00:00:00'),
(20, 'del', '906', '', '', '', '', '', '', '', '', '', '', '0000-00-00 00:00:00'),
(21, 'del', '908', '', '', '', '', '', '', '', '', '', '', '0000-00-00 00:00:00'),
(22, 'mod', '836', 'Angel ', 'R. Nebreda', 'Research Programmes', 'Oncology', 'Angel R. Nebreda: Signalling and cell cycle', 'angel.nebreda@irbbarcelona.org', '+34 93 40 31379', 'Group Leader', 'EM01B53', '', '0000-00-00 00:00:00'),
(23, 'mod', '808', 'Manuel', 'Rueda', 'Research Programmes', 'Structural & Computational Biology', 'Modesto Orozco: Molecular modelling and bioinformatics', 'manuel.rueda@irbbarcelona.org', '', 'Research Associate', 'EMPBC33', '', '0000-00-00 00:00:00'),
(24, 'mod', '834', 'Anna Maria', 'Vilches', 'Administration', 'Human Resources', '', '', '', 'Work Safety and Environment Technician', 'TR04A8', '', '0000-00-00 00:00:00'),
(25, 'ins', '99902', 'Cristina', 'Nadal', 'Research Programmes', 'Oncology', 'MetLab: Growth control and cancer metastasis', '', '+34 93 40 39961', '', 'EMPBB51', '', '0000-00-00 00:00:00');

--
-- Table structure for table `jos_irbtools_commands`
--

CREATE TABLE IF NOT EXISTS `jos_irbtools_commands` (
  `id` int(11) NOT NULL auto_increment,
  `description` varchar(50) NOT NULL,
  `short_description` varchar(50) NOT NULL,
  `order` smallint(6) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `jos_irbtools_commands`
--

INSERT INTO `jos_irbtools_commands` (`id`, `description`, `short_description`, `order`) VALUES
(1, 'add', 'add', 1),
(2, 'mod', 'mod', 2),
(3, 'del', 'del', 3),
(4, 'ins', 'ins', 4);

--
-- Table structure for table `jos_irbtools_email_log`
--

CREATE TABLE IF NOT EXISTS `jos_irbtools_email_log` (
  `id` int(11) NOT NULL auto_increment,
  `timestamp` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `text` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ;

