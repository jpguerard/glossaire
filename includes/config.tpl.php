<?php
/*
 * Glossary's database configuration.
 *
 * Copyright (C) 2006 Jonathan Ernst
 * Copyright (C) 2006-2019 Jean-Philippe Guérard
 * Copyright (C) 2019 Stéphane Aulery
 * 
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or any later version.

 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.

 * You should have received a copy of the GNU General Public License
 * along with the Glossary.  If not, see <https://www.gnu.org/licenses/>.
 */

// Database configuration
$config['db_host'] = "localhost";
$config['db_username'] = "dbuser";
$config['db_password'] = "dbpass";
$config['db_database'] = "glossary";

// Language configuration

  // source language in the locale chosen for the interface
  $config['lng_source'] = "anglais";

  // target language in the locale chosen for the interface
  $config['lng_target'] = "français";

  // Locale for the interface
  // Must be valid locale on your system (see: locale -a)
  $config['lng_interface'] = "fr_FR";

// Automatic translators configuration

  // "" to deactivate, otherwise, put in the value of the langpair
  // form field of Google translation suitable for your project
  $config['at_google'] = "en|fr";

  // "" to deactivate, otherwise, put in the value of the dst form
  // field of BabelFish translation suitable for your project
  $config['at_babelfish_src'] = "auto";
  $config['at_babelfish_dst'] = "fr";

// Don't touch anything under here.

require("includes/locales.inc.php");
require("includes/functions.inc.php");

