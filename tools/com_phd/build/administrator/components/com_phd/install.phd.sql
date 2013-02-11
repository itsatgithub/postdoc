
--
-- Table structure for table `jos_phd_applicants`
--
CREATE TABLE IF NOT EXISTS `jos_phd_applicants` (
  `id` int(11) NOT NULL auto_increment,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `gender_id` int(11) NOT NULL,
  `passport` varchar(20) NOT NULL default '',
  `birth_date` date NOT NULL default '0000-00-00',
  `birth_country_id` int(11) NOT NULL,
  `street` varchar(40) NOT NULL default '',
  `city` varchar(40) NOT NULL default '',
  `postalcode` varchar(10) NOT NULL default '',
  `country_id` int(11) NOT NULL,
  `telephone` varchar(40) NOT NULL default '',
  `email` varchar(100) NOT NULL,
  `wheredidu_id` int(11) NOT NULL default '0',
  `other_fellowships` tinyint(1) default NULL,
  `other_fellowships_text` text NOT NULL,
  `career_breaks` tinyint(1) default NULL,
  `career_breaks_text` text NOT NULL,
  `career_breaks_filename` varchar(255) default NULL,
  `additional_info` text,
  `phd_thesis` text NOT NULL,
  `research_experience` text NOT NULL,
  `ethical_issue` tinyint(1) NOT NULL,
  `user_username` varchar(150) NOT NULL,
  `status_id` int(11) NOT NULL default '0',
  `submit_date` datetime default NULL,
  `modified` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ;

-- --------------------------------------------------------

--
-- Table structure for table `jos_phd_applicant_programme`
--

CREATE TABLE IF NOT EXISTS `jos_phd_applicant_programme` (
  `id` int(11) NOT NULL auto_increment,
  `applicant_id` int(11) default NULL,
  `programme_id` int(11) default NULL,
  `order` tinyint(4) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ;

-- --------------------------------------------------------

--
-- Table structure for table `jos_phd_applicant_ethical_issue`
--

CREATE TABLE IF NOT EXISTS `jos_phd_applicant_ethical_issue` (
  `id` int(11) NOT NULL auto_increment,
  `applicant_id` int(11) NOT NULL,
  `ethical_issue_id` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `jos_phd_applications`
--
CREATE TABLE IF NOT EXISTS `jos_phd_applications` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ;

--
-- Dumping data for table `jos_phd_applications`
--

INSERT INTO `jos_phd_applications` (`id`, `description`) VALUES
(1, 'phd'),
(2, 'postdoc');

-- --------------------------------------------------------

--
-- Table structure for table `jos_phd_ethical_issues`
--

CREATE TABLE IF NOT EXISTS `jos_phd_ethical_issues` (
  `id` int(11) NOT NULL auto_increment,
  `description` text NOT NULL,
  `short_description` varchar(100) NOT NULL,
  `order` tinyint(4) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ;

--
-- Dumping data for table `jos_phd_ethical_issues`
--

INSERT INTO `jos_phd_ethical_issues` (`id`, `description`, `short_description`, `order`) VALUES
(1, 'Research involving interventions in humans or research using human materials (primary cells, tissues, DNA, RNA, etc., but NOT established cell lines!)', 'Research involving humans', 1),
(2, 'Research on experimental (vertebrate) animals', 'Research on animals', 2),
(3, 'Research involving embryonic stem cells', 'Research involving embryonic stem cells', 3),
(4, 'Research involving biological agents including, genetically modified organisms.', 'Research involving biological agents including, genetically modified organisms.', 4),
(5, 'Research involving data protection and privacy', 'Research involving data protection and privacy', 5);

-- --------------------------------------------------------

--
-- Table structure for table `jos_phd_countries`
--
CREATE TABLE IF NOT EXISTS `jos_phd_countries` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `iso` char(2) NOT NULL DEFAULT '',
  `name` varchar(80) NOT NULL DEFAULT '',
  `printable_name` varchar(80) NOT NULL DEFAULT '',
  `iso3` char(3) DEFAULT NULL,
  `numcode` smallint(6) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ;

--
-- Dumping data for table `jos_phd_countries`
--

INSERT INTO `jos_phd_countries` (`id`, `iso`, `name`, `printable_name`, `iso3`, `numcode`) VALUES
(1, 'AF', 'AFGHANISTAN', 'Afghanistan', 'AFG', 4),
(2, 'AL', 'ALBANIA', 'Albania', 'ALB', 8),
(3, 'DZ', 'ALGERIA', 'Algeria', 'DZA', 12),
(4, 'AS', 'AMERICAN SAMOA', 'American Samoa', 'ASM', 16),
(5, 'AD', 'ANDORRA', 'Andorra', 'AND', 20),
(6, 'AO', 'ANGOLA', 'Angola', 'AGO', 24),
(7, 'AI', 'ANGUILLA', 'Anguilla', 'AIA', 660),
(8, 'AQ', 'ANTARCTICA', 'Antarctica', NULL, NULL),
(9, 'AG', 'ANTIGUA AND BARBUDA', 'Antigua and Barbuda', 'ATG', 28),
(10, 'AR', 'ARGENTINA', 'Argentina', 'ARG', 32),
(11, 'AM', 'ARMENIA', 'Armenia', 'ARM', 51),
(12, 'AW', 'ARUBA', 'Aruba', 'ABW', 533),
(13, 'AU', 'AUSTRALIA', 'Australia', 'AUS', 36),
(14, 'AT', 'AUSTRIA', 'Austria', 'AUT', 40),
(15, 'AZ', 'AZERBAIJAN', 'Azerbaijan', 'AZE', 31),
(16, 'BS', 'BAHAMAS', 'Bahamas', 'BHS', 44),
(17, 'BH', 'BAHRAIN', 'Bahrain', 'BHR', 48),
(18, 'BD', 'BANGLADESH', 'Bangladesh', 'BGD', 50),
(19, 'BB', 'BARBADOS', 'Barbados', 'BRB', 52),
(20, 'BY', 'BELARUS', 'Belarus', 'BLR', 112),
(21, 'BE', 'BELGIUM', 'Belgium', 'BEL', 56),
(22, 'BZ', 'BELIZE', 'Belize', 'BLZ', 84),
(23, 'BJ', 'BENIN', 'Benin', 'BEN', 204),
(24, 'BM', 'BERMUDA', 'Bermuda', 'BMU', 60),
(25, 'BT', 'BHUTAN', 'Bhutan', 'BTN', 64),
(26, 'BO', 'BOLIVIA', 'Bolivia', 'BOL', 68),
(27, 'BA', 'BOSNIA AND HERZEGOVINA', 'Bosnia and Herzegovina', 'BIH', 70),
(28, 'BW', 'BOTSWANA', 'Botswana', 'BWA', 72),
(29, 'BV', 'BOUVET ISLAND', 'Bouvet Island', NULL, NULL),
(30, 'BR', 'BRAZIL', 'Brazil', 'BRA', 76),
(31, 'IO', 'BRITISH INDIAN OCEAN TERRITORY', 'British Indian Ocean Territory', NULL, NULL),
(32, 'BN', 'BRUNEI DARUSSALAM', 'Brunei Darussalam', 'BRN', 96),
(33, 'BG', 'BULGARIA', 'Bulgaria', 'BGR', 100),
(34, 'BF', 'BURKINA FASO', 'Burkina Faso', 'BFA', 854),
(35, 'BI', 'BURUNDI', 'Burundi', 'BDI', 108),
(36, 'KH', 'CAMBODIA', 'Cambodia', 'KHM', 116),
(37, 'CM', 'CAMEROON', 'Cameroon', 'CMR', 120),
(38, 'CA', 'CANADA', 'Canada', 'CAN', 124),
(39, 'CV', 'CAPE VERDE', 'Cape Verde', 'CPV', 132),
(40, 'KY', 'CAYMAN ISLANDS', 'Cayman Islands', 'CYM', 136),
(41, 'CF', 'CENTRAL AFRICAN REPUBLIC', 'Central African Republic', 'CAF', 140),
(42, 'TD', 'CHAD', 'Chad', 'TCD', 148),
(43, 'CL', 'CHILE', 'Chile', 'CHL', 152),
(44, 'CN', 'CHINA', 'China', 'CHN', 156),
(45, 'CX', 'CHRISTMAS ISLAND', 'Christmas Island', NULL, NULL),
(46, 'CC', 'COCOS (KEELING) ISLANDS', 'Cocos (Keeling) Islands', NULL, NULL),
(47, 'CO', 'COLOMBIA', 'Colombia', 'COL', 170),
(48, 'KM', 'COMOROS', 'Comoros', 'COM', 174),
(49, 'CG', 'CONGO', 'Congo', 'COG', 178),
(50, 'CD', 'CONGO, THE DEMOCRATIC REPUBLIC OF THE', 'Congo, the Democratic Republic of the', 'COD', 180),
(51, 'CK', 'COOK ISLANDS', 'Cook Islands', 'COK', 184),
(52, 'CR', 'COSTA RICA', 'Costa Rica', 'CRI', 188),
(53, 'CI', 'COTE D''IVOIRE', 'Cote D''Ivoire', 'CIV', 384),
(54, 'HR', 'CROATIA', 'Croatia', 'HRV', 191),
(55, 'CU', 'CUBA', 'Cuba', 'CUB', 192),
(56, 'CY', 'CYPRUS', 'Cyprus', 'CYP', 196),
(57, 'CZ', 'CZECH REPUBLIC', 'Czech Republic', 'CZE', 203),
(58, 'DK', 'DENMARK', 'Denmark', 'DNK', 208),
(59, 'DJ', 'DJIBOUTI', 'Djibouti', 'DJI', 262),
(60, 'DM', 'DOMINICA', 'Dominica', 'DMA', 212),
(61, 'DO', 'DOMINICAN REPUBLIC', 'Dominican Republic', 'DOM', 214),
(62, 'EC', 'ECUADOR', 'Ecuador', 'ECU', 218),
(63, 'EG', 'EGYPT', 'Egypt', 'EGY', 818),
(64, 'SV', 'EL SALVADOR', 'El Salvador', 'SLV', 222),
(65, 'GQ', 'EQUATORIAL GUINEA', 'Equatorial Guinea', 'GNQ', 226),
(66, 'ER', 'ERITREA', 'Eritrea', 'ERI', 232),
(67, 'EE', 'ESTONIA', 'Estonia', 'EST', 233),
(68, 'ET', 'ETHIOPIA', 'Ethiopia', 'ETH', 231),
(69, 'FK', 'FALKLAND ISLANDS (MALVINAS)', 'Falkland Islands (Malvinas)', 'FLK', 238),
(70, 'FO', 'FAROE ISLANDS', 'Faroe Islands', 'FRO', 234),
(71, 'FJ', 'FIJI', 'Fiji', 'FJI', 242),
(72, 'FI', 'FINLAND', 'Finland', 'FIN', 246),
(73, 'FR', 'FRANCE', 'France', 'FRA', 250),
(74, 'GF', 'FRENCH GUIANA', 'French Guiana', 'GUF', 254),
(75, 'PF', 'FRENCH POLYNESIA', 'French Polynesia', 'PYF', 258),
(76, 'TF', 'FRENCH SOUTHERN TERRITORIES', 'French Southern Territories', NULL, NULL),
(77, 'GA', 'GABON', 'Gabon', 'GAB', 266),
(78, 'GM', 'GAMBIA', 'Gambia', 'GMB', 270),
(79, 'GE', 'GEORGIA', 'Georgia', 'GEO', 268),
(80, 'DE', 'GERMANY', 'Germany', 'DEU', 276),
(81, 'GH', 'GHANA', 'Ghana', 'GHA', 288),
(82, 'GI', 'GIBRALTAR', 'Gibraltar', 'GIB', 292),
(83, 'GR', 'GREECE', 'Greece', 'GRC', 300),
(84, 'GL', 'GREENLAND', 'Greenland', 'GRL', 304),
(85, 'GD', 'GRENADA', 'Grenada', 'GRD', 308),
(86, 'GP', 'GUADELOUPE', 'Guadeloupe', 'GLP', 312),
(87, 'GU', 'GUAM', 'Guam', 'GUM', 316),
(88, 'GT', 'GUATEMALA', 'Guatemala', 'GTM', 320),
(89, 'GN', 'GUINEA', 'Guinea', 'GIN', 324),
(90, 'GW', 'GUINEA-BISSAU', 'Guinea-Bissau', 'GNB', 624),
(91, 'GY', 'GUYANA', 'Guyana', 'GUY', 328),
(92, 'HT', 'HAITI', 'Haiti', 'HTI', 332),
(93, 'HM', 'HEARD ISLAND AND MCDONALD ISLANDS', 'Heard Island and Mcdonald Islands', NULL, NULL),
(94, 'VA', 'HOLY SEE (VATICAN CITY STATE)', 'Holy See (Vatican City State)', 'VAT', 336),
(95, 'HN', 'HONDURAS', 'Honduras', 'HND', 340),
(96, 'HK', 'HONG KONG', 'Hong Kong', 'HKG', 344),
(97, 'HU', 'HUNGARY', 'Hungary', 'HUN', 348),
(98, 'IS', 'ICELAND', 'Iceland', 'ISL', 352),
(99, 'IN', 'INDIA', 'India', 'IND', 356),
(100, 'ID', 'INDONESIA', 'Indonesia', 'IDN', 360),
(101, 'IR', 'IRAN, ISLAMIC REPUBLIC OF', 'Iran, Islamic Republic of', 'IRN', 364),
(102, 'IQ', 'IRAQ', 'Iraq', 'IRQ', 368),
(103, 'IE', 'IRELAND', 'Ireland', 'IRL', 372),
(104, 'IL', 'ISRAEL', 'Israel', 'ISR', 376),
(105, 'IT', 'ITALY', 'Italy', 'ITA', 380),
(106, 'JM', 'JAMAICA', 'Jamaica', 'JAM', 388),
(107, 'JP', 'JAPAN', 'Japan', 'JPN', 392),
(108, 'JO', 'JORDAN', 'Jordan', 'JOR', 400),
(109, 'KZ', 'KAZAKHSTAN', 'Kazakhstan', 'KAZ', 398),
(110, 'KE', 'KENYA', 'Kenya', 'KEN', 404),
(111, 'KI', 'KIRIBATI', 'Kiribati', 'KIR', 296),
(112, 'KP', 'KOREA, DEMOCRATIC PEOPLE''S REPUBLIC OF', 'Korea, Democratic People''s Republic of', 'PRK', 408),
(113, 'KR', 'KOREA, REPUBLIC OF', 'Korea, Republic of', 'KOR', 410),
(114, 'KW', 'KUWAIT', 'Kuwait', 'KWT', 414),
(115, 'KG', 'KYRGYZSTAN', 'Kyrgyzstan', 'KGZ', 417),
(116, 'LA', 'LAO PEOPLE''S DEMOCRATIC REPUBLIC', 'Lao People''s Democratic Republic', 'LAO', 418),
(117, 'LV', 'LATVIA', 'Latvia', 'LVA', 428),
(118, 'LB', 'LEBANON', 'Lebanon', 'LBN', 422),
(119, 'LS', 'LESOTHO', 'Lesotho', 'LSO', 426),
(120, 'LR', 'LIBERIA', 'Liberia', 'LBR', 430),
(121, 'LY', 'LIBYAN ARAB JAMAHIRIYA', 'Libyan Arab Jamahiriya', 'LBY', 434),
(122, 'LI', 'LIECHTENSTEIN', 'Liechtenstein', 'LIE', 438),
(123, 'LT', 'LITHUANIA', 'Lithuania', 'LTU', 440),
(124, 'LU', 'LUXEMBOURG', 'Luxembourg', 'LUX', 442),
(125, 'MO', 'MACAO', 'Macao', 'MAC', 446),
(126, 'MK', 'MACEDONIA, THE FORMER YUGOSLAV REPUBLIC OF', 'Macedonia, the Former Yugoslav Republic of', 'MKD', 807),
(127, 'MG', 'MADAGASCAR', 'Madagascar', 'MDG', 450),
(128, 'MW', 'MALAWI', 'Malawi', 'MWI', 454),
(129, 'MY', 'MALAYSIA', 'Malaysia', 'MYS', 458),
(130, 'MV', 'MALDIVES', 'Maldives', 'MDV', 462),
(131, 'ML', 'MALI', 'Mali', 'MLI', 466),
(132, 'MT', 'MALTA', 'Malta', 'MLT', 470),
(133, 'MH', 'MARSHALL ISLANDS', 'Marshall Islands', 'MHL', 584),
(134, 'MQ', 'MARTINIQUE', 'Martinique', 'MTQ', 474),
(135, 'MR', 'MAURITANIA', 'Mauritania', 'MRT', 478),
(136, 'MU', 'MAURITIUS', 'Mauritius', 'MUS', 480),
(137, 'YT', 'MAYOTTE', 'Mayotte', NULL, NULL),
(138, 'MX', 'MEXICO', 'Mexico', 'MEX', 484),
(139, 'FM', 'MICRONESIA, FEDERATED STATES OF', 'Micronesia, Federated States of', 'FSM', 583),
(140, 'MD', 'MOLDOVA, REPUBLIC OF', 'Moldova, Republic of', 'MDA', 498),
(141, 'MC', 'MONACO', 'Monaco', 'MCO', 492),
(142, 'MN', 'MONGOLIA', 'Mongolia', 'MNG', 496),
(143, 'MS', 'MONTSERRAT', 'Montserrat', 'MSR', 500),
(144, 'MA', 'MOROCCO', 'Morocco', 'MAR', 504),
(145, 'MZ', 'MOZAMBIQUE', 'Mozambique', 'MOZ', 508),
(146, 'MM', 'MYANMAR', 'Myanmar', 'MMR', 104),
(147, 'NA', 'NAMIBIA', 'Namibia', 'NAM', 516),
(148, 'NR', 'NAURU', 'Nauru', 'NRU', 520),
(149, 'NP', 'NEPAL', 'Nepal', 'NPL', 524),
(150, 'NL', 'NETHERLANDS', 'Netherlands', 'NLD', 528),
(151, 'AN', 'NETHERLANDS ANTILLES', 'Netherlands Antilles', 'ANT', 530),
(152, 'NC', 'NEW CALEDONIA', 'New Caledonia', 'NCL', 540),
(153, 'NZ', 'NEW ZEALAND', 'New Zealand', 'NZL', 554),
(154, 'NI', 'NICARAGUA', 'Nicaragua', 'NIC', 558),
(155, 'NE', 'NIGER', 'Niger', 'NER', 562),
(156, 'NG', 'NIGERIA', 'Nigeria', 'NGA', 566),
(157, 'NU', 'NIUE', 'Niue', 'NIU', 570),
(158, 'NF', 'NORFOLK ISLAND', 'Norfolk Island', 'NFK', 574),
(159, 'MP', 'NORTHERN MARIANA ISLANDS', 'Northern Mariana Islands', 'MNP', 580),
(160, 'NO', 'NORWAY', 'Norway', 'NOR', 578),
(161, 'OM', 'OMAN', 'Oman', 'OMN', 512),
(162, 'PK', 'PAKISTAN', 'Pakistan', 'PAK', 586),
(163, 'PW', 'PALAU', 'Palau', 'PLW', 585),
(164, 'PS', 'PALESTINIAN TERRITORY, OCCUPIED', 'Palestinian Territory, Occupied', NULL, NULL),
(165, 'PA', 'PANAMA', 'Panama', 'PAN', 591),
(166, 'PG', 'PAPUA NEW GUINEA', 'Papua New Guinea', 'PNG', 598),
(167, 'PY', 'PARAGUAY', 'Paraguay', 'PRY', 600),
(168, 'PE', 'PERU', 'Peru', 'PER', 604),
(169, 'PH', 'PHILIPPINES', 'Philippines', 'PHL', 608),
(170, 'PN', 'PITCAIRN', 'Pitcairn', 'PCN', 612),
(171, 'PL', 'POLAND', 'Poland', 'POL', 616),
(172, 'PT', 'PORTUGAL', 'Portugal', 'PRT', 620),
(173, 'PR', 'PUERTO RICO', 'Puerto Rico', 'PRI', 630),
(174, 'QA', 'QATAR', 'Qatar', 'QAT', 634),
(175, 'RE', 'REUNION', 'Reunion', 'REU', 638),
(176, 'RO', 'ROMANIA', 'Romania', 'ROM', 642),
(177, 'RU', 'RUSSIAN FEDERATION', 'Russian Federation', 'RUS', 643),
(178, 'RW', 'RWANDA', 'Rwanda', 'RWA', 646),
(179, 'SH', 'SAINT HELENA', 'Saint Helena', 'SHN', 654),
(180, 'KN', 'SAINT KITTS AND NEVIS', 'Saint Kitts and Nevis', 'KNA', 659),
(181, 'LC', 'SAINT LUCIA', 'Saint Lucia', 'LCA', 662),
(182, 'PM', 'SAINT PIERRE AND MIQUELON', 'Saint Pierre and Miquelon', 'SPM', 666),
(183, 'VC', 'SAINT VINCENT AND THE GRENADINES', 'Saint Vincent and the Grenadines', 'VCT', 670),
(184, 'WS', 'SAMOA', 'Samoa', 'WSM', 882),
(185, 'SM', 'SAN MARINO', 'San Marino', 'SMR', 674),
(186, 'ST', 'SAO TOME AND PRINCIPE', 'Sao Tome and Principe', 'STP', 678),
(187, 'SA', 'SAUDI ARABIA', 'Saudi Arabia', 'SAU', 682),
(188, 'SN', 'SENEGAL', 'Senegal', 'SEN', 686),
(189, 'CS', 'SERBIA AND MONTENEGRO', 'Serbia and Montenegro', NULL, NULL),
(190, 'SC', 'SEYCHELLES', 'Seychelles', 'SYC', 690),
(191, 'SL', 'SIERRA LEONE', 'Sierra Leone', 'SLE', 694),
(192, 'SG', 'SINGAPORE', 'Singapore', 'SGP', 702),
(193, 'SK', 'SLOVAKIA', 'Slovakia', 'SVK', 703),
(194, 'SI', 'SLOVENIA', 'Slovenia', 'SVN', 705),
(195, 'SB', 'SOLOMON ISLANDS', 'Solomon Islands', 'SLB', 90),
(196, 'SO', 'SOMALIA', 'Somalia', 'SOM', 706),
(197, 'ZA', 'SOUTH AFRICA', 'South Africa', 'ZAF', 710),
(198, 'GS', 'SOUTH GEORGIA AND THE SOUTH SANDWICH ISLANDS', 'South Georgia and the South Sandwich Islands', NULL, NULL),
(199, 'ES', 'SPAIN', 'Spain', 'ESP', 724),
(200, 'LK', 'SRI LANKA', 'Sri Lanka', 'LKA', 144),
(201, 'SD', 'SUDAN', 'Sudan', 'SDN', 736),
(202, 'SR', 'SURINAME', 'Suriname', 'SUR', 740),
(203, 'SJ', 'SVALBARD AND JAN MAYEN', 'Svalbard and Jan Mayen', 'SJM', 744),
(204, 'SZ', 'SWAZILAND', 'Swaziland', 'SWZ', 748),
(205, 'SE', 'SWEDEN', 'Sweden', 'SWE', 752),
(206, 'CH', 'SWITZERLAND', 'Switzerland', 'CHE', 756),
(207, 'SY', 'SYRIAN ARAB REPUBLIC', 'Syrian Arab Republic', 'SYR', 760),
(208, 'TW', 'TAIWAN, PROVINCE OF CHINA', 'Taiwan, Province of China', 'TWN', 158),
(209, 'TJ', 'TAJIKISTAN', 'Tajikistan', 'TJK', 762),
(210, 'TZ', 'TANZANIA, UNITED REPUBLIC OF', 'Tanzania, United Republic of', 'TZA', 834),
(211, 'TH', 'THAILAND', 'Thailand', 'THA', 764),
(212, 'TL', 'TIMOR-LESTE', 'Timor-Leste', NULL, NULL),
(213, 'TG', 'TOGO', 'Togo', 'TGO', 768),
(214, 'TK', 'TOKELAU', 'Tokelau', 'TKL', 772),
(215, 'TO', 'TONGA', 'Tonga', 'TON', 776),
(216, 'TT', 'TRINIDAD AND TOBAGO', 'Trinidad and Tobago', 'TTO', 780),
(217, 'TN', 'TUNISIA', 'Tunisia', 'TUN', 788),
(218, 'TR', 'TURKEY', 'Turkey', 'TUR', 792),
(219, 'TM', 'TURKMENISTAN', 'Turkmenistan', 'TKM', 795),
(220, 'TC', 'TURKS AND CAICOS ISLANDS', 'Turks and Caicos Islands', 'TCA', 796),
(221, 'TV', 'TUVALU', 'Tuvalu', 'TUV', 798),
(222, 'UG', 'UGANDA', 'Uganda', 'UGA', 800),
(223, 'UA', 'UKRAINE', 'Ukraine', 'UKR', 804),
(224, 'AE', 'UNITED ARAB EMIRATES', 'United Arab Emirates', 'ARE', 784),
(225, 'GB', 'UNITED KINGDOM', 'United Kingdom', 'GBR', 826),
(226, 'US', 'UNITED STATES', 'United States', 'USA', 840),
(227, 'UM', 'UNITED STATES MINOR OUTLYING ISLANDS', 'United States Minor Outlying Islands', NULL, NULL),
(228, 'UY', 'URUGUAY', 'Uruguay', 'URY', 858),
(229, 'UZ', 'UZBEKISTAN', 'Uzbekistan', 'UZB', 860),
(230, 'VU', 'VANUATU', 'Vanuatu', 'VUT', 548),
(231, 'VE', 'VENEZUELA', 'Venezuela', 'VEN', 862),
(232, 'VN', 'VIET NAM', 'Viet Nam', 'VNM', 704),
(233, 'VG', 'VIRGIN ISLANDS, BRITISH', 'Virgin Islands, British', 'VGB', 92),
(234, 'VI', 'VIRGIN ISLANDS, U.S.', 'Virgin Islands, U.s.', 'VIR', 850),
(235, 'WF', 'WALLIS AND FUTUNA', 'Wallis and Futuna', 'WLF', 876),
(236, 'EH', 'WESTERN SAHARA', 'Western Sahara', 'ESH', 732),
(237, 'YE', 'YEMEN', 'Yemen', 'YEM', 887),
(238, 'ZM', 'ZAMBIA', 'Zambia', 'ZMB', 894),
(239, 'ZW', 'ZIMBABWE', 'Zimbabwe', 'ZWE', 716);

-- --------------------------------------------------------

--
-- Table structure for table `jos_phd_degrees`
--

CREATE TABLE IF NOT EXISTS `jos_phd_degrees` (
  `id` int(11) NOT NULL auto_increment,
  `applicant_id` int(11) NOT NULL default '0',
  `type` varchar(20) NOT NULL,
  `degree` text NOT NULL,
  `university` text NOT NULL,
  `institution` text NOT NULL,
  `start_date` date default NULL,
  `end_date` date default NULL,
  `country_id` smallint(11) default NULL,
  `director_name` varchar(50) default NULL,
  `modified` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ;

-- --------------------------------------------------------

--
-- Table structure for table `jos_phd_docs`
--

CREATE TABLE IF NOT EXISTS `jos_phd_docs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `doc_type_id` int(11) NOT NULL DEFAULT '0',
  `applicant_id` int(11) NOT NULL DEFAULT '0',
  `filename` varchar(255) NOT NULL DEFAULT '',
  `description` text NOT NULL,
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ;

-- --------------------------------------------------------

--
-- Table structure for table `jos_phd_doc_types`
--

CREATE TABLE IF NOT EXISTS `jos_phd_doc_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(100) NOT NULL,
  `short_description` varchar(30) NOT NULL,
  `order` smallint(6) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ;

--
-- Dumping data for table `jos_phd_doc_types`
--

INSERT INTO `jos_phd_doc_types` (`id`, `description`, `short_description`, `order`) VALUES
(1, 'Curriculum Vitae', 'Curriculum Vitae', 1),
(2, 'Motivation letter', 'Motivation letter', 2),
(3, 'Academic record', 'Academic record', 3),
(4, 'Recommendation letter', 'Recommendation letter', 4),
(5, 'List of publications', 'List of publications', 5),
(6, 'PhD certificate', 'PhD certificate', 6);

-- --------------------------------------------------------

--
-- Table structure for table `jos_phd_genders`
--

CREATE TABLE IF NOT EXISTS `jos_phd_genders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(20) NOT NULL,
  `short_description` varchar(10) NOT NULL,
  `order` smallint(6) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ;

--
-- Dumping data for table `jos_phd_genders`
--

INSERT INTO `jos_phd_genders` (`id`, `description`, `short_description`, `order`) VALUES
(2, 'Female', 'Female', 2),
(1, 'Male', 'Male', 1);

-- --------------------------------------------------------

--
-- Table structure for table `jos_phd_logs`
--

CREATE TABLE IF NOT EXISTS `jos_phd_logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `applicant_id` int(11) NOT NULL DEFAULT '0',
  `text` text NOT NULL,
  `old_status_id` int(11) NOT NULL DEFAULT '0',
  `new_status_id` int(11) NOT NULL DEFAULT '0',
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ;

-- --------------------------------------------------------

--
-- Table structure for table `jos_phd_programmes`
--

CREATE TABLE IF NOT EXISTS `jos_phd_programmes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(100) NOT NULL,
  `short_description` varchar(50) NOT NULL,
  `user_username` varchar(150) NOT NULL,
  `order` smallint(6) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ;

--
-- Dumping data for table `jos_phd_programmes`
--

INSERT INTO `jos_phd_programmes` (`id`, `description`, `short_description`, `user_username`, `order`) VALUES
(1, 'Cell and Developmental Biology', 'Cell and Development', 'cadb', 1),
(2, 'Molecular Medicine', 'Molecular Medicine', 'mmp', 2),
(3, 'Oncology', 'Oncology', 'onco', 3),
(4, 'Chemistry and Molecular Pharmacology', 'Chemistry and Molecular Pharmacology', 'camp', 4),
(5, 'Structural and Computational Biology', 'Structural and Computational Biology', 'sacb', 5);

-- --------------------------------------------------------

--
-- Table structure for table `jos_phd_referees`
--

CREATE TABLE IF NOT EXISTS `jos_phd_referees` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `applicant_id` int(11) NOT NULL DEFAULT '0',
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `filename` varchar(100) DEFAULT NULL,
  `upload_code` varchar(50) DEFAULT NULL,
  `sent_mail` date DEFAULT NULL,
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ;

-- --------------------------------------------------------

--
-- Table structure for table `jos_phd_rights`
--

CREATE TABLE IF NOT EXISTS `jos_phd_rights` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(255) NOT NULL,
  `short_description` varchar(100) NOT NULL,
  `order` smallint(6) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ;

--
-- Dumping data for table `jos_phd_rights`
--

INSERT INTO `jos_phd_rights` (`id`, `description`, `short_description`, `order`) VALUES
(1, 'Read', 'read', 1),
(2, 'Write', 'write', 2);

-- --------------------------------------------------------

--
-- Table structure for table `jos_phd_roles`
--

CREATE TABLE IF NOT EXISTS `jos_phd_roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(255) NOT NULL,
  `short_description` varchar(100) NOT NULL,
  `order` smallint(6) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ;

--
-- Dumping data for table `jos_phd_roles`
--

INSERT INTO `jos_phd_roles` (`id`, `description`, `short_description`, `order`) VALUES
(1, 'Administrator', 'Administrator', 1),
(2, 'Group Leader', 'Group Leader', 2),
(3, 'Committe', 'Committe', 3),
(4, 'Applicant', 'Applicant', 4);

-- --------------------------------------------------------

--
-- Table structure for table `jos_phd_role_tab_right`
--

CREATE TABLE IF NOT EXISTS `jos_phd_role_tab_right` (
  `role_id` int(11) NOT NULL,
  `tab_id` int(11) NOT NULL,
  `right_id` int(11) NOT NULL,
  PRIMARY KEY (`role_id`,`tab_id`,`right_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `jos_phd_role_tab_right`
--

INSERT INTO `jos_phd_role_tab_right` (`role_id`, `tab_id`, `right_id`) VALUES
(1, 1, 2),
(1, 2, 2),
(1, 3, 2),
(1, 4, 2),
(1, 5, 2),
(1, 6, 2),
(1, 7, 2),
(1, 8, 2),
(1, 9, 2),
(1, 10, 2),
(2, 1, 2),
(2, 2, 2),
(2, 3, 2),
(2, 4, 2),
(2, 5, 2),
(2, 6, 2),
(2, 7, 2),
(2, 8, 2),
(2, 9, 2),
(2, 10, 2),
(3, 1, 1),
(3, 2, 1),
(3, 3, 1),
(3, 4, 1),
(3, 5, 1),
(3, 6, 1),
(3, 7, 1),
(3, 8, 1),
(3, 9, 1),
(3, 10, 1),
(4, 1, 2),
(4, 2, 2),
(4, 3, 2),
(4, 4, 2),
(4, 5, 2),
(4, 6, 2),
(4, 7, 2),
(4, 8, 2),
(4, 9, 2),
(4, 10, 2);

-- --------------------------------------------------------

--
-- Table structure for table `jos_phd_status`
--

CREATE TABLE IF NOT EXISTS `jos_phd_status` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(40) NOT NULL,
  `short_description` varchar(40) NOT NULL,
  `mail_subject` varchar(100) NOT NULL,
  `mail_body` text NOT NULL,
  `order` smallint(6) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ;

--
-- Dumping data for table `jos_phd_status`
--

INSERT INTO `jos_phd_status` (`id`, `description`, `short_description`, `mail_subject`, `mail_body`, `order`) VALUES
(1, 'Editing', 'Editing', 'News from IRB Barcelona PhD programme', 'Dear #name#,\r\n\r\nThis email is to inform you that IRB Barcelona has not yet received one of the two letters of recommendation requested for application to IRB Barcelona PhD fellowships. We remind you that these letters must be sent directly to us by your referees (either by e-mail to phd@irbbarcelona.org , by airmail or by fax to our contact address) and that the deadline for receipt is 25 January 2009.\r\n\r\nBest regards,\r\n\r\nIRB Barcelona PhD Programme\r\n\r\nThis is an automatically generated message. Please do not answer.', 1),
(2, 'Submitted', 'Submitted', 'News from IRB Barcelona PhD programme', 'Dear #name#,\r\n\r\nThank you for your interest in IRB Barcelona and for submitting your application for a PhD position at our institute.\r\n\r\nThis e-mail is to confirm that your application has been submitted correctly. You will hear back from us once the call closes and the first part of the evaluation process has been completed, around February 2009.\r\n\r\nBest regards,\r\n\r\nIRB Barcelona PhD Programme\r\n\r\nThis is an automatically generated message. Please do not answer.', 2),
(3, 'Not invited for interviews', 'Not invited for interviews', 'News from IRB Barcelona PhD programme', 'Dear #name#,\r\n\r\nThank you, once again, for applying for a Ph.D. grant at IRB Barcelona. The call closed the 25 January 2009 and the first part of the selection process has now been completed.\r\n\r\nAfter careful evaluation of your considerable merits, I am sorry to inform you that on this occasion you have not been short-listed.\r\n\r\nI thank you once again for your interest in IRB Barcelona and wish you every success in the future.\r\n\r\nBest regards,\r\n\r\nIRB Barcelona PhD Programme\r\n\r\nThis is an automatically generated message. Please do not answer.', 3),
(4, 'Invited for interviews', 'Invited for interviews', 'News from IRB Barcelona PhD programme', 'Dear #name#,\r\n\r\nThank you once again for your recent application for a PhD grant at IRB Barcelona. After careful evaluation of your merits, I am pleased to inform you that you have been short-listed as a potential candidate for one of the grants currently on offer. You will soon receive an official letter with the invitation to visit our Institute on 30 and 31 of March 2009 for interviews.\r\n\r\nBest regards,\r\n\r\nIRB Barcelona PhD Programme\r\n\r\nThis is an automatically generated message. Please do not answer.', 4),
(5, 'Not accepted', 'Not accepted', 'News from IRB Barcelona PhD programme', 'Dear #name#,\r\n\r\nAfter completion of the selection process for PhD fellowships offered by the Institute for Research in Biomedicine (IRB Barcelona), I regret to inform you than on this occasion your application has not been successful. Given the considerable competition for these fellowships and exceptionally high number and quality of applicants, I congratulate you on being short-listed.\r\n\r\nI thank you once again for your interest in  IRB Barcelona and wish you every success in the future.\r\n\r\nYours sincerely,\r\n\r\nIRB Barcelona PhD Programme\r\n\r\nThis is an automatically generated message. Please do not answer.', 5),
(6, 'Accepted', 'Accepted', 'News from IRB Barcelona PhD programme', 'Dear #name#,\r\n\r\nAfter completion of the selection process, it is our pleasure to offer you a PhD fellowship at IRB Barcelona. We congratulate you on this achievement. As you know there was considerable competition for these fellowships and the number and quality of applicants were exceptionally high.\r\n\r\nWe will officially contact you in the near future with more details of our offer.\r\n\r\nBest regards,\r\n\r\nIRB Barcelona PhD Programme\r\n\r\nThis is an automatically generated message. Please do not answer.', 6),
(7, 'Discarded', 'Discarded', 'News from IRB Barcelona PhD Programme', 'Dear #name#,\r\n\r\nThank you for your interest in IRB Barcelona and for submitting your application for a PhD position at our institute.\r\n\r\nWe regret to inform you that we have received no recommendations letters. You have therefore been excluded from the selection process.\r\n\r\nBest regards,\r\n\r\nIRB Barcelona PhD Programme\r\n\r\nThis is an automatically generated message. Please do not answer.', 7),
(8, 'Waiting list', 'Waiting list', '', '', 8);

-- --------------------------------------------------------

--
-- Table structure for table `jos_phd_tabs`
--

CREATE TABLE IF NOT EXISTS `jos_phd_tabs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ;

--
-- Dumping data for table `jos_phd_tabs`
--

INSERT INTO `jos_phd_tabs` (`id`, `description`) VALUES
(1, 'personal_data'),
(2, 'academic_info'),
(3, 'files'),
(4, 'referees'),
(5, 'work_experiences'),
(6, 'summary_of_thesis'),
(7, 'summary_of_research'),
(8, 'programmes'),
(9, 'ethical_issues'),
(10, 'status');

-- --------------------------------------------------------

--
-- Table structure for table `jos_phd_tab_application`
--

CREATE TABLE IF NOT EXISTS `jos_phd_tab_application` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tab_id` int(11) NOT NULL,
  `application_id` int(11) NOT NULL,
  `show` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ;

--
-- Dumping data for table `jos_phd_tab_application`
--

INSERT INTO `jos_phd_tab_application` (`id`, `tab_id`, `application_id`, `show`) VALUES
(1, 1, 1, 1),
(2, 2, 1, 1),
(3, 3, 1, 1),
(4, 4, 1, 1),
(5, 5, 1, 1),
(6, 6, 1, 0),
(7, 7, 1, 0),
(8, 8, 1, 1),
(9, 9, 1, 1),
(10, 10, 1, 1),
(11, 1, 2, 1),
(12, 2, 2, 1),
(13, 3, 2, 1),
(14, 4, 2, 1),
(15, 5, 2, 1),
(16, 6, 2, 1),
(17, 7, 2, 1),
(18, 8, 2, 1),
(19, 9, 2, 1),
(20, 10, 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `jos_phd_users`
--

CREATE TABLE IF NOT EXISTS `jos_phd_users` (
  `id` int(11) NOT NULL,
  `user_username` varchar(150) NOT NULL,
  `role_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_username` (`user_username`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `jos_phd_users`
--

INSERT INTO `jos_phd_users` (`id`, `user_username`, `role_id`) VALUES
(1, 'phdadmin', 1),
(2, 'phdadmin2', 1),
(3, 'cadb', 2),
(4, 'mmp', 2),
(5, 'onco', 2),
(6, 'camp', 2),
(7, 'sacb', 2),
(8, 'com1', 3),
(9, 'com2', 3);

-- --------------------------------------------------------

--
-- Table structure for table `jos_phd_wheredidu`
--

CREATE TABLE IF NOT EXISTS `jos_phd_wheredidu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(40) NOT NULL,
  `short_description` varchar(40) NOT NULL,
  `order` smallint(6) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ;

--
-- Dumping data for table `jos_phd_wheredidu`
--

INSERT INTO `jos_phd_wheredidu` (`id`, `description`, `short_description`, `order`) VALUES
(1, 'IRB Barcelona Website', 'IRB Barcelona Website', 1),
(2, 'Email announcement', 'Email announcement', 2),
(3, 'Through a friend/professor/researcher', 'Through a friend/professor/researcher', 3),
(4, 'Poster', 'Poster', 4);

-- --------------------------------------------------------

--
-- Table structure for table `jos_phd_work_experiences`
--

CREATE TABLE IF NOT EXISTS `jos_phd_work_experiences` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `applicant_id` int(11) NOT NULL DEFAULT '0',
  `experience` text NOT NULL,
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ;
