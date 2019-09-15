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
 * along with Foobar.  If not, see <https://www.gnu.org/licenses/>.
 */

require("./includes/constants.inc.php");
require("./includes/config.inc.php");
require("./includes/mysql.inc.php");
require("./includes/header.inc.php");

?>
<h2>Formats d'exportation disponibles</h2>

<p>Les données du glossaire peuvent être exportées dans un grand nombre
de formats. Si votre format préféré n'est pas disponible, faites-en la
demande sur la
<a href="https://www.traduc.org/mailman/listinfo/glossaire">liste de diffusion</a></p>

<ul>
<?php

foreach (explode(",", GLO_EXPORT_FORMATS) as $format) {
    ?><li><a href="download.php?f=<?php echo strtolower($format); ?>"><?php echo strtoupper($format); ?></a></li><?php
}

?>
</ul>
<?php

require("./includes/footer.inc.php");

