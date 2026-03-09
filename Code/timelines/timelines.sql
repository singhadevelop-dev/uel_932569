--
-- Table structure for table `timelines`
--

CREATE TABLE IF NOT EXISTS `timelines` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `time` varchar(100) NOT NULL,
  `icon` varchar(100) NOT NULL,
  `content` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

--
-- Dumping data for table `timelines`
--

INSERT INTO `timelines` (`title`, `image`, `date`, `time`, `icon`, `content`) VALUES
('The Beggining', 'timelines/images/timeline1.jpg', '2012-09-10', '2012-2014', 'icon-graduation', 'Curabitur blandit tempus. Maecenas sed diam eget risus varius blandit sit porta felis euismod semper.'),
('The New Office', 'timelines/images/timeline2.jpg', '2014-09-10', '2014-2016', 'icon-present', 'Curabitur blandit tempus. Maecenas sed diam eget risus varius blandit sit porta felis euismod semper.'),
('The New Building', 'timelines/images/timeline3.jpg', '2016-09-10', '2016-2018', 'icon-globe', 'Curabitur blandit tempus. Maecenas sed diam eget risus varius blandit sit porta felis euismod semper.'),
('The Startup', 'timelines/images/timeline4.jpg', '2018-09-10', '2018-2020', 'icon-briefcase', 'Curabitur blandit tempus. Maecenas sed diam eget risus varius blandit sit porta felis euismod semper.'),
('Company Ideas', 'timelines/images/timeline5.jpg', '2020-09-10', '2020-now', 'icon-fire', 'Curabitur blandit tempus. Maecenas sed diam eget risus varius blandit sit porta felis euismod semper.');