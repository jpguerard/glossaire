<?php
/*
 * Glossary's search engine.
 *
 * Copyright (C) 2006 Jonathan Ernst
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

require("./includes/config.inc.php");
require("./includes/mysql.inc.php");
// We asked a file
switch($_GET['f'])
{
    case "csv":
        header('Content-type: text/x-comma-separated-values');
        header('Content-Disposition: attachment; filename="export.'.$_GET['f'].'"');
        echo '"en","fr","comment","source"'."\n";
        $sQuery ="SELECT en,fr,comment,source FROM glossary WHERE state!='deleted' AND source NOT LIKE 'mémo de %' ORDER BY en ASC";
        $hResult = mysql_query($sQuery);
        while($aRow = mysql_fetch_row($hResult))
        {
            echo '"';
            for($i=0;$i<sizeof($aRow);$i++)
            {
                echo str_replace('"','""',$aRow[$i]);
                if($i+1 < sizeof($aRow))
                    echo '","';
            }
            echo "\"\n";
        }
        exit;
    break;
    case "xml":
        header('Content-type: text/xml');
        header('Content-Disposition: attachment; filename="export.'.$_GET['f'].'"');
        $aTags = array("en","fr","comment","source");
        echo "<glossary>\n";
        $sQuery ="SELECT en,fr,comment,source FROM glossary WHERE state!='deleted' AND source NOT LIKE 'mémo de %' ORDER BY en ASC";
        $hResult = mysql_query($sQuery);
        while($aRow = mysql_fetch_row($hResult))
        {
            echo '<entry>';
            for($i=0;$i<sizeof($aRow);$i++)
            {
                echo "<".$aTags[$i].">";
                echo str_replace('<','&lt;',str_replace('>','&gt;',str_replace('&','&amp;',$aRow[$i])));
                echo "</".$aTags[$i].">";
            }
            echo "</entry>\n";
        }
        echo '</glossary>';
        exit;
    break;
} 
require("./includes/header.inc.php");
?>
<h2>Formats d'exportation disponibles</h2>
<p>Les données du glossaire peuvent être exportées dans un grand nombre de formats. Si votre format préféré n'est pas disponible, faites-en la demande sur la <a href="http://www.traduc.org/mailman/listinfo/glossaire">liste de diffusion</a></p>
<ul>
 <li><p><a href="export.php?f=csv">CSV</a></p></li>
 <li><p><a href="export.php?f=xml">XML</a></p></li>
</ul>
 
<?php
require("./includes/footer.inc.php");
?>
