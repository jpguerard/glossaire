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
require("./includes/header.inc.php");

echo "
<h2>"._("Introduction")."</h2>
<p>"._("Using the glossary allows for an homogenuous translation. Please be careful to take the context into account and to don't apply translations automatically.")."</p>

<h2>"._("Other sources and references")."</h2>
<ul>
"._("<!-- Some locale related links -->
 <li><p> Office de la langue française : <a href=\"http://www.culture.gouv.fr/culture/dglf/\">France</a> - <a href=\"http://www.cfwb.be/franca/\">Belgique</a> - <a href=\"http://www.olf.gouv.qc.ca/\">Québec</a> - <a href=\"http://www.ciip.ch/ciip/DLF/\">Suisse</a></p></li>
 <li><p> Dictionnaire français-anglais : <a href=\"http://www.granddictionnaire.com/_fs_global_01.htm\">Grand dictionnaire terminologique</a> </p></li>
 <li><p> Français : <a href=\"http://atilf.atilf.fr/academie9.htm\">Dictionnaire de l'Académie</a> - <a href=\"http://www.softissimo.com/grammaire/\">Grammaire</a> - <a href=\"http://elsap1.unicaen.fr/cherches.html\">Synonymes</a></p></li>
 <li><p> Anglais : <a href=\"http://www.m-w.com/\">Merriam &amp; Webster</a> </p></li>
 <li><p> Glossaires informatique et Internet : <a href=\"http://www.linux-france.org/prj/jargonf/\">Jargon</a> - <a href=\"http://www-rocq.inria.fr/qui/Philippe.Deschamp/RETIF/\">RETIF</a> - <a href=\"http://www.culture.fr/culture/dglf/cogeter/16-03-99-internet-termetrang.html\">Ministère de la culture</a> - <a href=\"http://wwli.com/translation/netglos/\">NetGlos</a>.</p></li>")."
</ul>

<h2>"._("Glossary")."</h2>
<p><strong>"._("Attention: toute modification doit être discutée sur la <a href=\"http://www.traduc.org/mailman/listinfo/glossaire\">liste de diffusion</a>")."</strong></p>
<form method=\"post\" action=\"".$_SERVER['PHP_SELF']."\">
<div><input name=\"s\" type=\"text\" value=\"".stripslashes($_REQUEST['s'])."\" /><input type=\"submit\" value=\""._("search")."\" /></div>
</form>";

// We did search for something...
if($_REQUEST['s'])
{ 
    $sTableHeaderAdmin = "<table><tr><th>".$config['lng_source']."</th><th>".$config['lng_target']."</th><th>"._("comments")."</th><th>"._("source")."</th><th style=\"width:48px\">"._("action")."</th></tr>";
    if($_SESSION['admin'])
        $sTableHeader = $sTableHeaderAdmin;
    else
        $sTableHeader = "<table><tr><th>".$config['lng_source']."</th><th>".$config['lng_target']."</th><th>"._("comments")."</th><th>"._("source")."</th></tr>";

    if($_SESSION['user'])
        $sTableHeaderMemo = $sTableHeaderAdmin;
    else $sTableHeaderMemo = $sTableHeader;

    echo "<h3>"._("Perfect matches");
    if($_SESSION['admin'] || $_SESSION['user'])
        echo " <a href=\"entry.php?s=".stripslashes($_REQUEST['s'])."\"><img src=\"./images/new.png\" alt=\"["._("add")."]\" title=\""._("add a new entry into the glossary")."\" /></a>";
    echo "</h3>";
    $sQuery = sprintf("SELECT * FROM glossary WHERE state!='deleted' AND source NOT LIKE '*%%*' AND lng_source LIKE %s ORDER BY lng_source ASC",
                      smart_quote($_REQUEST['s']));
    $hResult = mysql_query($sQuery);
    if(!mysql_num_rows($hResult))
    {
        echo _("No perfect match found.");
        $bAuto = true;
    } else 
    {
        echo $sTableHeader;
        while($oRow = mysql_fetch_object($hResult))
        {
            echo "<tr>\n";
            echo "  <td>".$oRow->lng_source."</td><td>".$oRow->lng_target."</td><td>".$oRow->comment."</td><td>".$oRow->source."</td>";
            if($_SESSION['admin'])
                echo "<td><a href=\"entry.php?id=".$oRow->id."\"><img src=\"./images/edit.png\" alt=\"[modifier]\" title=\"modifier l'entrée\" /></a>&nbsp;<a href=\"javascript:confirm_delete(".$oRow->id.");\"><img src=\"./images/delete.png\" alt=\"[supprimer]\" title=\"supprimer l'entrée\" /></a></td>";
            echo "</tr>\n";
        }
        echo "</table>";
    }

    $sQuery = sprintf("SELECT * FROM glossary WHERE state!='deleted' AND source NOT LIKE '*%%*' AND (lng_source LIKE %s OR lng_source LIKE %s OR lng_source LIKE %s OR lng_source LIKE %s OR lng_source LIKE %s OR lng_source LIKE %s OR lng_source LIKE %s) ORDER BY lng_source ASC",
                      smart_quote("% ".$_REQUEST['s']),
                      smart_quote($_REQUEST['s']." %"),
                      smart_quote("% ".$_REQUEST['s']." %"),
                      smart_quote("% ".$_REQUEST['s']."-%"),
                      smart_quote($_REQUEST['s']."-%"),
                      smart_quote("%-".$_REQUEST['s']),
                      smart_quote($_REQUEST['s']));
    $hResult = mysql_query($sQuery);
    if(mysql_num_rows($hResult))
    {
        echo "<h3>"._("Fuzzy matches (full words only)")."</h3>";
        echo $sTableHeader;
        while($oRow = mysql_fetch_object($hResult))
        {
            echo "<tr>\n";
            echo "  <td>".$oRow->lng_source."</td><td>".$oRow->lng_target."</td><td>".$oRow->comment."</td><td>".$oRow->source."</td>";
            if($_SESSION['admin'])
                echo "<td><a href=\"entry.php?id=".$oRow->id."\"><img src=\"./images/edit.png\" alt=\"[modifier]\" title=\"modifier l'entrée\" /></a>&nbsp;<a href=\"javascript:confirm_delete(".$oRow->id.");\"><img src=\"./images/delete.png\" alt=\"[supprimer]\" title=\"supprimer l'entrée\" /></a></td>";
            echo "</tr>\n";
        }
        echo "</table>";
    }

    $sQuery = sprintf("SELECT * FROM glossary WHERE state!='deleted' AND source LIKE '*%%*' AND (lng_source LIKE %s OR lng_source LIKE %s OR lng_source LIKE %s OR lng_source LIKE %s OR lng_source LIKE %s OR lng_source LIKE %s OR lng_source LIKE %s) ORDER BY lng_source ASC",
                      smart_quote("% ".$_REQUEST['s']),
                      smart_quote($_REQUEST['s']." %"),
                      smart_quote("% ".$_REQUEST['s']." %"),
                      smart_quote("% ".$_REQUEST['s']."-%"),
                      smart_quote($_REQUEST['s']."-%"),
                      smart_quote("%-".$_REQUEST['s']),
                      smart_quote($_REQUEST['s']));
    $hResult = mysql_query($sQuery);
    if(mysql_num_rows($hResult))
    {
        echo "<h3>"._("Fuzzy matches (full words only) in the user's personnal glossaries")."</h3>";
        echo "<p><strong>"._("Warning: these translations are unofficial; use with care.")."</strong></p>";
        echo $sTableHeaderMemo;
        while($oRow = mysql_fetch_object($hResult))
        {
            echo "<tr>\n";
            echo "  <td>".$oRow->lng_source."</td><td>".$oRow->lng_target."</td><td>".$oRow->comment."</td><td>".prepare_source($oRow->source)."</td>";
            if($_SESSION['admin'] || ($_SESSION['user'] && $oRow->source == "*".$_SESSION['user']."*"))
                echo "<td><a href=\"entry.php?id=".$oRow->id."\"><img src=\"./images/edit.png\" alt=\"[modifier]\" title=\"modifier l'entrée\" /></a>&nbsp;<a href=\"javascript:confirm_delete(".$oRow->id.");\"><img src=\"./images/delete.png\" alt=\"[supprimer]\" title=\"supprimer l'entrée\" /></a></td>";
            elseif($_SESSION['user'])
                echo "<td>&nbsp;</td>";
            echo "</tr>\n";
        }
        echo "</table>";
    }

    $sQuery = sprintf("SELECT * FROM glossary WHERE state!='deleted' AND source NOT LIKE '*%%*' AND lng_source LIKE %s ORDER BY lng_source ASC",
                      smart_quote("%".$_REQUEST['s']."%"));
    $hResult = mysql_query($sQuery);
    if(mysql_num_rows($hResult))
    {
        echo "<h3>"._("Fuzzy matches (all)")."</h3>";
        echo $sTableHeader;
        while($oRow = mysql_fetch_object($hResult))
        {
            echo "<tr>\n";
            echo "  <td>".$oRow->lng_source."</td><td>".$oRow->lng_target."</td><td>".$oRow->comment."</td><td>".$oRow->source."</td>";
            if($_SESSION['admin'])
                echo "<td><a href=\"entry.php?id=".$oRow->id."\"><img src=\"./images/edit.png\" alt=\"[modifier]\" title=\"modifier l'entrée\" /></a>&nbsp;<a href=\"javascript:confirm_delete(".$oRow->id.");\"><img src=\"./images/delete.png\" alt=\"[supprimer]\" title=\"supprimer l'entrée\" /></a></td>";
            echo "</tr>\n";
        }
        echo "</table>";
    }
}

if($_SESSION['admin'] || $_SESSION['user'])
{
?>
<script type="text/javascript">
function confirm_delete(id)
{
    if(confirm('<?php echo _("Are you sure you want to delete this entry?");?>'))
         location = 'entry.php?action=delete&id='+id+'&s=<?php echo stripslashes($_REQUEST['s']);?>';
}
</script>
<?php
}

// Let's do automatic translation if no exact match was found...
if($bAuto)
{
    flush();
    get_automatic_translation($_REQUEST['s']);
}
require("./includes/footer.inc.php");
?>
