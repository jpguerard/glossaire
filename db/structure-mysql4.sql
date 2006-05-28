-- 
-- Structure de la table `glossary`
-- 

CREATE TABLE `glossary` (
  `id` int(11) NOT NULL auto_increment,
  `en` varchar(255) NOT NULL,
  `fr` varchar(255) NOT NULL,
  `comment` text NOT NULL,
  `source` varchar(25) NOT NULL,
  `state` enum('new','edited','deleted') NOT NULL default 'new',
  `user` varchar(15) NOT NULL,
  `date` date NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=24139 ;

-- --------------------------------------------------------

-- 
-- Structure de la table `users`
-- 

CREATE TABLE `users` (
  `username` varchar(15) NOT NULL,
  `password` varchar(32) NOT NULL,
  `admin` enum('true','false') NOT NULL default 'false',
  PRIMARY KEY  (`username`)
) ENGINE=MyISAM COMMENT='users'' table';
