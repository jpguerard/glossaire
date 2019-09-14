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

// We asked a file
switch($_GET['f']) {

  case "csv":
    header('Content-type: text/x-comma-separated-values');
    header('Content-Disposition: attachment; filename="export.'
           .$_GET['f'].'"');
    echo '"'.$config['lng_source'].'","'.$config['lng_target'].'","'
         ._("comment").'","'._("source").'"'."\n";
    $sQuery ="SELECT lng_source,lng_target,comment,source FROM "
             ."glossary WHERE state!='deleted' AND source NOT LIKE '*%*' "
             ."ORDER BY lng_source ASC";
    $hResult = mysqli_query($mysqllink, $sQuery);
    while($aRow = mysqli_fetch_row($hResult)) {

      echo '"';
      for($i=0;$i<sizeof($aRow);$i++) {
        echo str_replace('"','""',$aRow[$i]);
        if($i+1 < sizeof($aRow)) echo '","';
      }
      echo "\"\n";

    }
    exit;
    break;

  case "xml":
    header('Content-type: text/xml');
    header('Content-Disposition: attachment; filename="export.'
           .$_GET['f'].'"');
    $aTags = array($config['lng_source'],$config['lng_target']
                   ,_("comment"),_("source"));
    echo "<glossary>\n";
    $sQuery ="SELECT lng_source,lng_target,comment,source "
             ."FROM glossary WHERE state!='deleted' "
             ."AND source NOT LIKE '*%*' ORDER BY lng_source ASC";
    $hResult = mysqli_query($mysqllink, $sQuery);
    while($aRow = mysqli_fetch_row($hResult)) {

      echo '<entry>';
      for($i=0;$i<sizeof($aRow);$i++) {
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

