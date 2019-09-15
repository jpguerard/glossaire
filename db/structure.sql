--
-- Glossary's db init script for MySQL
--
-- Copyright (C) 2006 Jonathan Ernst
-- Copyright (C) 2006-2019 Jean-Philippe Guérard
-- Copyright (C) 2019 Stéphane Aulery
-- 
-- This program is free software; you can redistribute it and/or
-- modify it under the terms of the GNU General Public License
-- as published by the Free Software Foundation; either version 2
-- of the License, or any later version.
--
-- This program is distributed in the hope that it will be useful,
-- but WITHOUT ANY WARRANTY; without even the implied warranty of
-- MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
-- GNU General Public License for more details.
--
-- You should have received a copy of the GNU General Public License
-- along with Foobar.  If not, see <https://www.gnu.org/licenses/>.
--

SET NAMES utf8mb4;

-- --------------------------------------------------------

-- 
-- Structure de la table `glossary`
-- 

CREATE TABLE `glossary` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lng_source` varchar(1020) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `lng_target` varchar(1020) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `comment` text COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `source` varchar(100) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `state` enum('new','edited','deleted') COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT 'new',
  `user` varchar(60) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `date` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

-- --------------------------------------------------------

-- 
-- Structure de la table `users`
-- 

CREATE TABLE `users` (
  `username` varchar(60) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `password` varchar(128) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `admin` enum('true','false') COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT 'false',
  PRIMARY KEY (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci COMMENT='users'' table';

