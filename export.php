<?php
/*
 * Glossary's search engine.
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
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston,
 * MA  02110-1301  USA.
 *
 */

require("./includes/config.inc.php");
require("./includes/mysql.inc.php");
require("./includes/header.inc.php"); ?>

<h2>Formats d'exportation disponibles</h2>

<p>Les données du glossaire peuvent être exportées dans un grand nombre
de formats. Si votre format préféré n'est pas disponible, faites-en la
demande sur la
<a href="http://www.traduc.org/mailman/listinfo/glossaire">liste de diffusion</a></p>

<ul>
  <li><p><a href="download.php?f=csv">CSV</a></p></li>
  <li><p><a href="download.php?f=xml">XML</a></p></li>
</ul>
 
<?php require("./includes/footer.inc.php"); ?>
