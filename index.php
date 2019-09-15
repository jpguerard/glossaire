<?php
/*
 * Glossary's search engine.
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
 * along with Foobar.  If not, see <https://www.gnu.org/licenses/>.
 */

require("./includes/config.inc.php");
require("./includes/mysql.inc.php");
require("./includes/header.inc.php");

echo "<h1>"._("Glossary")."</h1>\n"
     ."<form name=\"f\" method=\"post\" action=\"".$_SERVER['PHP_SELF']."\">"
     ."<div>"
       ."<input name=\"s\" type=\"text\" "
                ."value=\"".stripslashes($_REQUEST['s'])."\">"
       ."<input type=\"submit\" value=\""._("search")."\">"
     ."</div>\n"
     ."</form>";

// We did search for something...
if($_REQUEST['s']) { 

  $sTableHeaderAdmin = "<table><tr><th>".$config['lng_source']."</th><th>"
                       .$config['lng_target']."</th><th>"._("comments")
                       ."</th><th>"._("source")."</th>"
                       ."<th style=\"width:48px\">"._("action")."</th></tr>";

  if($_SESSION['admin']) {
    $sTableHeader = $sTableHeaderAdmin;
  } else {
    $sTableHeader = "<table><tr><th>".$config['lng_source']."</th><th>"
                    .$config['lng_target']."</th><th>"._("comments")
                    ."</th><th>"._("source")."</th></tr>";
  }

  if($_SESSION['user']) {
    $sTableHeaderMemo = $sTableHeaderAdmin;
  } else {
    $sTableHeaderMemo = $sTableHeader;
  }

  echo "<h3>"._("Perfect matches");

  if($_SESSION['admin'] || $_SESSION['user']) {

    echo " <a href=\"entry.php?s=".stripslashes($_REQUEST['s'])."\">"
         ."<img src=\"./images/new.png\" alt=\"["._("add")."]\" "
         ."title=\""._("add a new entry into the glossary")."\"></a>";

  }

  echo "</h3>";

  $sQuery = sprintf("SELECT * FROM glossary WHERE state!='deleted' "
            ."AND source NOT LIKE '*%%*' AND lng_source LIKE %s "
            ."ORDER BY lng_source ASC",
            smart_quote($_REQUEST['s']) );
  $hResult = mysqli_query($mysqllink, $sQuery);

  if(!mysqli_num_rows($hResult)) {

    echo _("No perfect match found.");
    $bAuto = true;

  } else {

    echo $sTableHeader;
    while($oRow = mysqli_fetch_object($hResult)) {

      echo "<tr>\n";
      echo "  <td>".$oRow->lng_source."</td><td>".$oRow->lng_target."</td>"
           ."<td>".$oRow->comment."</td><td>".$oRow->source."</td>";

      if($_SESSION['admin']) {
        echo "<td><a href=\"entry.php?id=".$oRow->id."\">"
             ."<img src=\"./images/edit.png\" alt=\"[modifier]\" "
             ."title=\"modifier l'entrée\"></a>&nbsp;"
             ."<a href=\"javascript:confirm_delete(".$oRow->id.");\">"
             ."<img src=\"./images/delete.png\" alt=\"[supprimer]\" "
             ."title=\"supprimer l'entrée\"></a></td>";
      }
      echo "</tr>\n";
    }
    echo "</table>";
  }

  $sQuery = sprintf("SELECT * FROM glossary WHERE state!='deleted' "
            ."AND source NOT LIKE '*%%*' "
            ."AND (lng_source LIKE %s OR lng_source LIKE %s "
                 ."OR lng_source LIKE %s OR lng_source LIKE %s "
                 ."OR lng_source LIKE %s OR lng_source LIKE %s "
                 ."OR lng_source LIKE %s) "
            ."ORDER BY lng_source ASC",
              smart_quote("% ".$_REQUEST['s']),
              smart_quote($_REQUEST['s']." %"),
              smart_quote("% ".$_REQUEST['s']." %"),
              smart_quote("% ".$_REQUEST['s']."-%"),
              smart_quote($_REQUEST['s']."-%"),
              smart_quote("%-".$_REQUEST['s']),
              smart_quote($_REQUEST['s']));
  $hResult = mysqli_query($mysqllink, $sQuery);

  if(mysqli_num_rows($hResult)) {

    echo "<h3>"._("Fuzzy matches (full words only)")."</h3>";
    echo $sTableHeader;

    while($oRow = mysqli_fetch_object($hResult)) {

      echo "<tr>\n";
      echo "  <td>".$oRow->lng_source."</td><td>".$oRow->lng_target."</td>"
           ."<td>".$oRow->comment."</td><td>".$oRow->source."</td>";

      if($_SESSION['admin']) {
        echo "<td><a href=\"entry.php?id=".$oRow->id."\">"
             ."<img src=\"./images/edit.png\" alt=\"[modifier]\" "
                    ."title=\"modifier l'entrée\">"
             ."</a>&nbsp;"
             ."<a href=\"javascript:confirm_delete(".$oRow->id.");\">"
               ."<img src=\"./images/delete.png\" alt=\"[supprimer]\" "
                      ."title=\"supprimer l'entrée\">"
             ."</a></td>";
      }
      echo "</tr>\n";
    }
    echo "</table>";
  }

  $sQuery = sprintf("SELECT * FROM glossary WHERE state!='deleted' "
            ."AND source LIKE '*%%*' "
            ."AND (lng_source LIKE %s OR lng_source LIKE %s "
                   ."OR lng_source LIKE %s OR lng_source LIKE %s "
                   ."OR lng_source LIKE %s OR lng_source LIKE %s "
                   ."OR lng_source LIKE %s) "
            ."ORDER BY lng_source ASC",
              smart_quote("% ".$_REQUEST['s']),
              smart_quote($_REQUEST['s']." %"),
              smart_quote("% ".$_REQUEST['s']." %"),
              smart_quote("% ".$_REQUEST['s']."-%"),
              smart_quote($_REQUEST['s']."-%"),
              smart_quote("%-".$_REQUEST['s']),
              smart_quote($_REQUEST['s']));
  $hResult = mysqli_query($mysqllink, $sQuery);

  if(mysqli_num_rows($hResult)) {

    echo "<h3>"._("Fuzzy matches (full words only) in the user's personnal "
                  ."glossaries")."</h3>";
    echo "<p><strong>"._("Warning: these translations are unofficial; use "
         ."with care.")."</strong></p>";
    echo $sTableHeaderMemo;

    while($oRow = mysqli_fetch_object($hResult)) {

      echo "<tr>\n";
      echo "  <td>".$oRow->lng_source."</td><td>".$oRow->lng_target."</td>"
           ."<td>".$oRow->comment."</td>"
           ."<td>".prepare_source($oRow->source)."</td>";
      if( $_SESSION['admin']
          || ( $_SESSION['user']
               && $oRow->source == "*".$_SESSION['user']."*") ) {

        echo "<td><a href=\"entry.php?id=".$oRow->id."\">"
             ."<img src=\"./images/edit.png\" alt=\"[modifier]\" "
                    ."title=\"modifier l'entrée\">"
             ."</a>&nbsp;"
             ."<a href=\"javascript:confirm_delete(".$oRow->id.");\">"
             ."<img src=\"./images/delete.png\" alt=\"[supprimer]\" "
                    ."title=\"supprimer l'entrée\"></a></td>";

      } elseif($_SESSION['user']) {

        echo "<td>&nbsp;</td>";

      }
      echo "</tr>\n";
    }
    echo "</table>";
  }

  $sQuery = sprintf("SELECT * FROM glossary WHERE state!='deleted' "
            ."AND source NOT LIKE '*%%*' AND lng_source LIKE %s "
            ."ORDER BY lng_source ASC",
              smart_quote("%".$_REQUEST['s']."%"));
  $hResult = mysqli_query($mysqllink, $sQuery);

  if(mysqli_num_rows($hResult)) {

    echo "<h3>"._("Fuzzy matches (all)")."</h3>";
    echo $sTableHeader;
    while($oRow = mysqli_fetch_object($hResult)) {

      echo "<tr>\n";
      echo "  <td>".$oRow->lng_source."</td><td>".$oRow->lng_target."</td>"
           ."<td>".$oRow->comment."</td><td>".$oRow->source."</td>";

      if ($_SESSION['admin']) {

        echo "<td><a href=\"entry.php?id=".$oRow->id."\">"
             ."<img src=\"./images/edit.png\" alt=\"[modifier]\" "
                    ."title=\"modifier l'entrée\">"
             ."</a>&nbsp;"
             ."<a href=\"javascript:confirm_delete(".$oRow->id.");\">"
             ."<img src=\"./images/delete.png\" alt=\"[supprimer]\" "
                    ."title=\"supprimer l'entrée\"></a></td>";
      }
      echo "</tr>\n";
    }
    echo "</table>";
  }
}

if($_SESSION['admin'] || $_SESSION['user']) { ?>

<script type="text/javascript">
function confirm_delete(id) {
  if(confirm('<?php
    echo _("Are you sure you want to delete this entry?");
  ?>')) location = 'entry.php?action=delete&id='+id+'&s=<?php
                     echo stripslashes($_REQUEST['s']);
                   ?>';
}
</script>

<?php }

// Let's do automatic translation if no exact match was found...
if($bAuto) {

  flush();
  get_automatic_translation($_REQUEST['s']);

}

echo "<h2>"._("Other sources and references")."</h2>";
echo "<ul>";

echo _("<!-- Some locale related links -->
<li><p> Office de la langue française :
    <a href=\"http://www.culture.gouv.fr/culture/dglf/\">France</a>
  - <a href=\"http://www.languefrancaise.cfwb.be/\">Belgique</a>
  - <a href=\"http://bdl.oqlf.gouv.qc.ca/bdl/\">Québec</a>
  - <a href=\"https://www.unine.ch/islc/en/home/recherche/dialectologie-et-etude-du-franca/dictionnaire-suisse-romand.html\">Suisse</a>
</p></li>
<li><p> Dictionnaire français-anglais :
    <a href=\"http://gdt.oqlf.gouv.qc.ca/\">Grand dictionnaire terminologique</a>
</p></li>
<li><p> Français :
    <a href=\"https://academie.atilf.fr/9/\">Dictionnaire de l'Académie</a>
    - <a href=\"http://grammaire.reverso.net/\">Grammaire</a>
    - <a href=\"https://crisco2.unicaen.fr/des/\">Synonymes</a>
    - <a href=\"https://www.cnrtl.fr/\">CNRTL</a>
</p></li>
<li><p> Anglais
    <a href=\"https://www.merriam-webster.com/\">Merriam &amp; Webster</a>
</p></li>
<li><p>Glossaires informatique et Internet :
    <a href=\"http://www.linux-france.org/prj/jargonf/\">Jargon</a>
    - <a href=\"http://deschamp.free.fr/exinria/RETIF/\">RETIF</a>
    - <a href=\"http://www.culture.fr/culture/dglf/cogeter/16-03-99-internet-termetrang.html\">Ministère de la culture</a>.
</p></li>");

echo "</ul>";

require("./includes/footer.inc.php");

