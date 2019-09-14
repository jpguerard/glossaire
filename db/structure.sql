-- 
-- Structure de la table `glossary`
-- 

CREATE TABLE `glossary` (
  `id` int(11) NOT NULL auto_increment,
  `lng_source` varchar(255) collate utf8_unicode_ci NOT NULL,
  `lng_target` varchar(255) collate utf8_unicode_ci NOT NULL,
  `comment` text collate utf8_unicode_ci NOT NULL,
  `source` varchar(25) collate utf8_unicode_ci NOT NULL,
  `state` enum('new','edited','deleted') collate utf8_unicode_ci NOT NULL default 'new',
  `user` varchar(15) collate utf8_unicode_ci NOT NULL,
  `date` date NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ;

-- --------------------------------------------------------

-- 
-- Structure de la table `users`
-- 

CREATE TABLE `users` (
  `username` varchar(15) NOT NULL,
  `password` varchar(32) NOT NULL,
  `admin` enum('true','false') NOT NULL default 'false',
  PRIMARY KEY  (`username`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='users'' table';
