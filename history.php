<?php
/*
 * Modification history page for the Glossary.
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

require("./includes/config.inc.php");
require("./includes/mysql.inc.php");
require("./includes/header.inc.php");
?>

<h2>Historique</h2>
<p>Voici la liste des 100 dernières modifications du glossaire</p>

<?php

$sQuery ="SELECT *, DAYOFMONTH(date) as day, MONTH(date) as month, "
         ." YEAR(date) as year FROM glossary ORDER BY date DESC LIMIT 100";
$hResult = mysqli_query($mysqllink, $sQuery);

if($hResult) {

  if($_SESSION['admin']) {

    $sTableHeader = "<table><tr><th>".$config['lng_source']."</th><th>"
                    .$config['lng_target']."</th><th>"._("comments")
                    ."</th><th>"._("source")."</th><th>modifié le</th>"
                    ."<th>modifié par</th><th>modification</th>"
                    ."<th style=\"width:48px\">"._("action")."</th></tr>";

  } else {

   $sTableHeader = "<table><tr><th>".$config['lng_source']."</th><th>"
                   .$config['lng_target']."</th><th>"._("comments")
                   ."</th><th>"._("source")."</th><th>modifié le</th>"
                   ."<th>modifié par</th><th>modification</th></tr>";

  }

  echo $sTableHeader;

  while($oRow = mysqli_fetch_object($hResult)) {

    echo "<tr>\n";
    echo "  <td>".$oRow->lng_source."</td><td>".$oRow->lng_target
         ."</td><td>".$oRow->comment."</td><td>"
         .prepare_source($oRow->source)."</td><td>"
         .$oRow->day."/".$oRow->month."/".$oRow->year."</td><td>"
         .$oRow->user."</td><td>".$oRow->state."</td>";
    if($_SESSION['admin']) {
      if($oRow->state != 'deleted') {
        echo "<td><a href=\"entry.php?id=".$oRow->id."\">"
             ."<img src=\"./images/edit.png\" alt=\"[modifier]\" "
             ."title=\"modifier l'entrée\"></a>&nbsp;"
             ."<a href=\"javascript:confirm_delete(".$oRow->id.");\">"
             ."<img src=\"./images/delete.png\" alt=\"[supprimer]\" "
             ."title=\"supprimer l'entrée\"></a></td>";
      } else {
        echo "<td><a href=\"entry.php?action=undelete&id=".$oRow->id."\">"
             ."<img src=\"./images/undelete.png\" alt=\"[restaurer]\" "
             ."title=\"restaure l'entrée supprimée\"></a></td>";
      }
    }
    echo "</tr>\n";
  }

  echo "</table>";

} else {

  echo "<h2>Échec de la requête&nbsp;!</h2>" ;

}

if($_SESSION['admin']) { ?>

<script type="text/javascript">
function confirm_delete(id) {
  if(confirm('Êtes-vous sûr de vouloir supprimer cette entrée ?'))
    location = 'entry.php?action=delete&id='+id+'&s=<?php
      echo stripslashes($_REQUEST['s']);
    ?>';
}
</script>

<?php }

require("./includes/footer.inc.php"); ?>
