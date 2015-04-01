--
-- Dumping data for table `jos_phd_applicants`
--

INSERT INTO `jos_phd_applicants` (`id`, `firstname`, `lastname`, `gender_id`, `passport`, `birth_date`, `birth_country_id`, `street`, `city`, `postalcode`, `country_id`, `telephone`, `email`, `wheredidu_id`, `other_fellowships`, `other_fellowships_text`, `career_breaks`, `career_breaks_text`, `career_breaks_filename`, `additional_info`, `phd_thesis`, `research_experience`, `ethical_issue`, `ethical_issue_text`, `user_username`, `status_id`, `submit_date`, `modified`) VALUES
(1, 'test1', 'test1', 1, '234234', '1990-04-01', 199, 'Paolo Casali', 'Girona', '34087', 199, '111222333', 'test1@gmail.com', 1, 1, 'To the Second PhD Programme', 1, 'There are no causes', 'causes2.txt', 'additional info 3', 'This is the thesis description', 'This is the research experience', 1, 'These are the ethical issues', 'test1', 1, '2010-05-04 19:30:00', '2010-06-15 17:08:13'),
(9, 'test2', 'test2', 1, '123123123', '1985-04-30', 199, 'Francesc Carral', 'Sant Feliu de Guixols', '08268', 199, '666777888', 'test2@gmail.com', 1, 0, '', 0, '', 'causes.txt', NULL, 'This is the thesis description', 'This is the research description', 1, '- Research involving interventions in humans or research using human materials (primary cells, tissues, DNA, RNA, etc., but NOT established cell lines!)\r\n\r\n- Research on experimental (vertebrate) animals\r\n\r\n- Research involving embryonic stem cells', 'test2', 1, '2010-04-28 16:04:57', '2010-06-15 17:14:46'),
(10, 'test11', 'test11', 1, '1122331122', '1997-06-15', 199, 'Bueno Treserras', 'Barcelona', '08654', 199, '987987987', 'test11@mail.com', 3, 0, '', 0, '', NULL, NULL, '', '', 0, '', 'test11', 1, NULL, '2010-06-15 09:58:33');

--
-- Dumping data for table `jos_phd_applicant_programme`
--

INSERT INTO `jos_phd_applicant_programme` (`id`, `applicant_id`, `programme_id`, `order`) VALUES
(48, 1, 2, 2),
(47, 1, 1, 1),
(44, 2, 3, 2),
(43, 2, 2, 1),
(37, 6, 1, 1),
(38, 6, 2, 2),
(39, 7, 1, 1),
(40, 7, 0, 2),
(50, 9, 5, 2),
(49, 9, 4, 1);

--
-- Dumping data for table `jos_phd_degrees`
--

INSERT INTO `jos_phd_degrees` (`id`, `applicant_id`, `type`, `degree`, `university`, `institution`, `start_date`, `end_date`, `country_id`, `director_name`, `modified`) VALUES
(5, 1, '', 'Lic Informatica', 'Univ. Galicia', '', '2010-04-01', '2010-04-05', NULL, 'directors name', '2010-04-07 09:52:12'),
(6, 2, '', 'degree', 'university', '', '2010-04-01', '2010-04-02', NULL, 'directors name', '2010-04-12 07:10:47'),
(7, 9, '', 'a', 'b', '', '2010-04-13', '2010-04-16', NULL, 'Director', '2010-04-26 06:47:54'),
(30, 1, 'academic', 'Licenciado en Química', 'Universidad de Paris', '', NULL, '1990-06-01', 73, NULL, '2010-06-15 16:58:19'),
(27, 9, 'academic', 'Licenciado en Biología', 'Univ. de Málaga', '', NULL, '2005-06-30', 199, NULL, '2010-06-15 07:26:37'),
(28, 9, 'doctoral', 'Doctor en Biología', 'Univ. de Tokio', 'Tokio Research', '2005-09-01', '2008-09-01', 107, 'Kosio Hurushi', '2010-06-15 07:27:54'),
(29, 9, 'postdoctoral', '', 'Univ de La Habana', 'Centro de investigación Biológica', '2008-10-01', '2009-10-01', 55, NULL, '2010-06-15 07:28:55'),
(33, 1, 'postdoctoral', '', 'Universidad de Colonia ', 'Colonia Science', '2003-06-01', '2009-10-01', 199, NULL, '2010-06-15 17:01:32'),
(32, 1, 'doctoral', 'Doctor en Química Orgánica', 'Universidad del País Vasco', 'Osakidetza', '2000-06-01', '2001-06-01', 199, 'John Muller', '2010-06-15 17:00:35');

--
-- Dumping data for table `jos_phd_docs`
--

INSERT INTO `jos_phd_docs` (`id`, `doc_type_id`, `applicant_id`, `filename`, `description`, `modified`) VALUES
(11, 3, 1, 'academic.txt', 'Academic for test1', '2010-06-15 17:06:11'),
(9, 1, 1, 'cv.txt', 'CV for test1', '2010-06-15 17:05:14'),
(10, 2, 1, 'motivation_letter.txt', 'Motivation letter for test1', '2010-06-15 17:05:46'),
(12, 1, 9, 'cv.txt', 'CV for test2', '2010-06-15 17:11:21'),
(13, 2, 9, 'motivation_letter.txt', 'Motivation letter for test2', '2010-06-15 17:11:46'),
(14, 3, 9, 'academic.txt', 'Academic for test2', '2010-06-15 17:12:04');

--
-- Dumping data for table `jos_phd_referees`
--

INSERT INTO `jos_phd_referees` (`id`, `applicant_id`, `firstname`, `lastname`, `email`, `filename`, `upload_code`, `sent_mail`, `modified`) VALUES
(1, 0, '', '', '', NULL, '872603716', NULL, '2010-04-23 06:39:50'),
(2, 0, '', '', '', NULL, '1511048218', NULL, '2010-04-23 06:40:19'),
(3, 0, '', '', '', NULL, '229882292', NULL, '2010-04-23 06:40:33'),
(4, 0, '', '', '', NULL, '145175704', NULL, '2010-04-23 07:04:22'),
(5, 0, '', '', '', NULL, '81472225', NULL, '2010-04-23 07:14:29'),
(6, 0, '', '', '', NULL, '72563412', NULL, '2010-04-23 07:15:29'),
(7, 0, '', '', '', NULL, '659326815', NULL, '2010-04-23 07:16:23'),
(32, 1, 'John', 'Mayor', 'john.mayor@gmail.com', NULL, '1512228515', NULL, '2010-06-15 17:07:25'),
(34, 9, 'Bruce', 'Williams', 'bruce.williams@gmail.com', NULL, '7627681', NULL, '2010-06-15 17:13:33'),
(33, 9, 'Bryan', 'Getintouch', 'bryan.getintouch@gmail.com', NULL, '444537394', NULL, '2010-06-15 17:13:07'),
(31, 1, 'Sirius', 'Mongomery', 'sirius.mongomery@gmail.com', NULL, '2006879058', NULL, '2010-06-15 17:06:50');

--
-- Dumping data for table `jos_phd_work_experiences`
--

INSERT INTO `jos_phd_work_experiences` (`id`, `applicant_id`, `experience`, `modified`) VALUES
(3, 1, 'mas work expericence', '2010-04-09 19:00:34'),
(5, 9, 'work', '2010-04-26 07:00:39');

