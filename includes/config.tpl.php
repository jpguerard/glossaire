<?php
/*
 * Glossary's database configuration.
 *
 * Copyright (C) 2006 Jonathan Ernst
 * Copyright (C) 2006-2011 Jean-Philippe Guérard
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
 * along with this program; if not, write to the Free Software 
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301  USA.
 */

// Database configuration.
$config['db_host'] = "localhost";
$config['db_username'] = "dbuser";
$config['db_password'] = "dbpass";
$config['db_database'] = "glossary";

// Language configuration.
$config['lng_source'] = "anglais"; // source language in the locale chosen for the interface
$config['lng_target'] = "français"; // target language in the locale chosen for the interface
$config['lng_interface'] = "fr_FR"; // locale for the interface; must be valid locale on your system (see: locale -a)

// Automatic translators configuration.
$config['at_google'] = "en|fr";  // "" to deactivate, otherwise, put in the value of the langpair form field of Google translation suitable for your project
$config['at_altavista'] = "en_fr"; // "" to deactivate, otherwise, put in the value of the lp form field of Altavista translation suitable for your project
$config['at_amikai'] = "EN,FR"; // "" to deactivate, otherwise, put in the value of the langpair form field of Amikai translation suitable for your project

// Don't touch anything under here.
putenv("LANG=".$config['lng_interface']);
setlocale(LC_ALL, $config['lng_interface']);
bindtextdomain("messages", "./locale");
bind_textdomain_codeset("messages","UTF-8");
textdomain("messages");
session_start();
require("includes/functions.inc.php");
?>
