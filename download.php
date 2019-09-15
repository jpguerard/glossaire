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

error_reporting(E_ALL);
ini_set("display_errors", 1);

require("./includes/constants.inc.php");
require("./includes/config.inc.php");

$format = array_key_exists("f", $_GET) ? $_GET["f"] : "";
$format = strtolower($format);

if (!in_array($format, explode(",", GLO_EXPORT_FORMATS))) {
    echo _('Error: a GET parameter of name "f" must be defined to specifiy the output format. The available formats are:');
    echo " " . GLO_EXPORT_FORMATS . "\n";
    exit(1);
}

require("./includes/mysql.inc.php");

$sQuery = "
    SELECT
        lng_source,
        lng_target,
        source,
        comment
    FROM glossary
    WHERE
        state != 'deleted'
        AND source NOT LIKE '*%*'
        ORDER BY lng_source ASC
    ";

$hResult = mysqli_query($mysqllink, $sQuery);

$colNames = array(
    $config['lng_source'],
    $config['lng_target'],
    _("comment"),
    _("source"),
);

header('Content-Disposition: attachment; filename="export.'.$format.'"');

// We asked a file
switch($format) {
    case "csv":
        // cf. https://tools.ietf.org/html/rfc4180
        header('Content-type: text/csv');

        $qt  = '"';
        $sep = ",";
        $eol = "\r\n";

        for ($i = 0; $i < count($colNames); $i++) {
            echo $qt.$colNames[$i].$qt;
            if ($i + 1 < count($colNames)) {
                echo $sep;
            }
        }
        echo $eol;

        while($aRow = mysqli_fetch_row($hResult)) {
            for($i = 0; $i < count($aRow); $i++) {
                echo $qt . str_replace($qt, $qt.$qt, $aRow[$i]) . $qt;
                if($i + 1 < count($aRow)) echo $sep;
            }
            echo $eol;
        }
    break;

    case "xml":
        header('Content-type: text/xml');

        $gloXML = new SimpleXMLElement("<glossary></glossary>");

        while($aRow = mysqli_fetch_row($hResult)) {
            $entryXML = $gloXML->addChild('entry');

            for($i = 0; $i < count($colNames); $i++) {
                $entryXML->addChild($colNames[$i], $aRow[$i]);
            }
        }

        echo $gloXML->asXML();
        $gloXML = NULL;
    break;

    default:
        header('Content-type: text/plain');
        echo _("Error: unknown format: " . $format . ". This point is not reachable in normal case...");
        exit(1);
    break;
} 

