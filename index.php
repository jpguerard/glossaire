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
?>

<h2>Introduction</h2>
<p>L'utilisation du glossaire permet d'avoir une traduction homogène. Faites cependant attention à bien prendre en compte le contexte de la traduction et à ne pas appliquer bêtement les traductions indiquées dans ce document.</p>

<h2>Autres sources et références</h2>
<ul>
 <li><p> Office de la langue française : <a href="http://www.culture.gouv.fr/culture/dglf/">France</a> - <a href="http://www.olf.gouv.qc.ca/">Canada</a> </p></li>
 <li><p> Dictionnaire français-anglais : <a href="http://www.granddictionnaire.com/_fs_global_01.htm">Grand dictionnaire terminologique</a> </p></li>
 <li><p> Français : <a href="http://atilf.atilf.fr/academie9.htm">Dictionnaire de l'Académie</a> - <a href="http://www.softissimo.com/grammaire/">Grammaire</a> - <a href="http://elsap1.unicaen.fr/cherches.html">Synonymes</a> </p></li>
 <li><p> Anglais : <a href="http://www.m-w.com/">Merriam &amp; Webster</a> </p></li>
 <li><p> Glossaires informatique et Internet : <a href="http://www.linux-france.org/prj/jargonf/">Jargon</a> - <a href="http://www-rocq.inria.fr/qui/Philippe.Deschamp/RETIF/">RETIF</a> - <a href="http://www.culture.fr/culture/dglf/cogeter/16-03-99-internet-termetrang.html">Ministère de la culture</a> - <a href="http://wwli.com/translation/netglos/">NetGlos</a>. </p></li>
</ul>

<h2>Glossaire</h2>
<p><strong>Attention: toute modification doit être discutée sur la <a href="http://www.traduc.org/mailman/listinfo/glossaire">liste de diffusion</a></strong></p>
<form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
<div><input name="s" type="text" value="<?php echo stripslashes($_REQUEST['s']);?>" /><input type="submit" value="chercher" /></div>
</form>

<?php
// We did search for something...
if($_REQUEST['s'])
{ 
    $sTableHeaderAdmin = "<table><tr><th>anglais</th><th>français</th><th>commentaires</th><th>source</th><th style=\"width:48px\">action</th></tr>";
    if($_SESSION['admin'])
        $sTableHeader = $sTableHeaderAdmin;
    else
        $sTableHeader = "<table><tr><th>anglais</th><th>français</th><th>commentaires</th><th>source</th></tr>";

    if($_SESSION['user'])
        $sTableHeaderMemo = $sTableHeaderAdmin;
    else $sTableHeaderMemo = $sTableHeader;

    echo "<h3>Correspondances exactes";
    if($_SESSION['admin'] || $_SESSION['user'])
        echo " <a href=\"entry.php?s=".stripslashes($_REQUEST['s'])."\"><img src=\"./images/new.png\" alt=\"[ajouter]\" title=\"ajouter une nouvelle entrée dans le glossaire\" /></a>";
    echo "</h3>";
    $sQuery = sprintf("SELECT * FROM glossary WHERE state!='deleted' AND source NOT LIKE 'mémo de %%' AND en LIKE %s ORDER BY en ASC",
                      smart_quote($_REQUEST['s']));
    $hResult = mysql_query($sQuery);
    if(!mysql_num_rows($hResult))
    {
        echo "Aucune correspondance exacte trouvée.";       
    } else 
    {
        echo $sTableHeader;
        while($oRow = mysql_fetch_object($hResult))
        {
            echo "<tr>\n";
            echo "  <td>".$oRow->en."</td><td>".$oRow->fr."</td><td>".$oRow->comment."</td><td>".$oRow->source."</td>";
            if($_SESSION['admin'])
                echo "<td><a href=\"entry.php?id=".$oRow->id."\"><img src=\"./images/edit.png\" alt=\"[modifier]\" title=\"modifier l'entrée\" /></a>&nbsp;<a href=\"javascript:confirm_delete(".$oRow->id.");\"><img src=\"./images/delete.png\" alt=\"[supprimer]\" title=\"supprimer l'entrée\" /></a></td>";
            echo "</tr>\n";
        }
        echo "</table>";
    }

    echo "<h3>Correspondances approximatives (mots entiers seulement)</h3>";
    $sQuery = sprintf("SELECT * FROM glossary WHERE state!='deleted' AND source NOT LIKE 'mémo de %%' AND (en LIKE %s OR en LIKE %s OR en LIKE %s OR en LIKE %s OR en LIKE %s OR en LIKE %s OR en LIKE %s) ORDER BY en ASC",
                      smart_quote("% ".$_REQUEST['s']),
                      smart_quote($_REQUEST['s']." %"),
                      smart_quote("% ".$_REQUEST['s']." %"),
                      smart_quote("% ".$_REQUEST['s']."-%"),
                      smart_quote($_REQUEST['s']."-%"),
                      smart_quote("%-".$_REQUEST['s']),
                      smart_quote($_REQUEST['s']));
    $hResult = mysql_query($sQuery);
    if(!mysql_num_rows($hResult))
    {
        echo "Aucune correspondance approximative trouvée.";
    } else 
    {
        echo $sTableHeader;
        while($oRow = mysql_fetch_object($hResult))
        {
            echo "<tr>\n";
            echo "  <td>".$oRow->en."</td><td>".$oRow->fr."</td><td>".$oRow->comment."</td><td>".$oRow->source."</td>";
            if($_SESSION['admin'])
                echo "<td><a href=\"entry.php?id=".$oRow->id."\"><img src=\"./images/edit.png\" alt=\"[modifier]\" title=\"modifier l'entrée\" /></a>&nbsp;<a href=\"javascript:confirm_delete(".$oRow->id.");\"><img src=\"./images/delete.png\" alt=\"[supprimer]\" title=\"supprimer l'entrée\" /></a></td>";
            echo "</tr>\n";
        }
        echo "</table>";
    }

    echo "<h3>Correspondances approximatives (mots entiers seulement) dans les glossaires utilisateurs</h3>";
    echo "<p><strong>Attention: ces traductions ne sont pas officielles, à utiliser avec précaution.</strong></p>";
    $sQuery = sprintf("SELECT * FROM glossary WHERE state!='deleted' AND source LIKE 'mémo de %%' AND (en LIKE %s OR en LIKE %s OR en LIKE %s OR en LIKE %s OR en LIKE %s OR en LIKE %s OR en LIKE %s) ORDER BY en ASC",
                      smart_quote("% ".$_REQUEST['s']),
                      smart_quote($_REQUEST['s']." %"),
                      smart_quote("% ".$_REQUEST['s']." %"),
                      smart_quote("% ".$_REQUEST['s']."-%"),
                      smart_quote($_REQUEST['s']."-%"),
                      smart_quote("%-".$_REQUEST['s']),
                      smart_quote($_REQUEST['s']));
    $hResult = mysql_query($sQuery);
    if(!mysql_num_rows($hResult))
    {
        echo "Aucune correspondance approximative trouvée.";
    } else 
    {
        echo $sTableHeaderMemo;
        while($oRow = mysql_fetch_object($hResult))
        {
            echo "<tr>\n";
            echo "  <td>".$oRow->en."</td><td>".$oRow->fr."</td><td>".$oRow->comment."</td><td>".$oRow->source."</td>";
            if($_SESSION['admin'] || ($_SESSION['user'] && $oRow->source == "mémo de ".$_SESSION['user']))
                echo "<td><a href=\"entry.php?id=".$oRow->id."\"><img src=\"./images/edit.png\" alt=\"[modifier]\" title=\"modifier l'entrée\" /></a>&nbsp;<a href=\"javascript:confirm_delete(".$oRow->id.");\"><img src=\"./images/delete.png\" alt=\"[supprimer]\" title=\"supprimer l'entrée\" /></a></td>";
            elseif($_SESSION['user'])
                echo "<td>&nbsp;</td>";
            echo "</tr>\n";
        }
        echo "</table>";
    }

    echo "<h3>Correspondances approximatives (toutes)</h3>";
    $sQuery = sprintf("SELECT * FROM glossary WHERE state!='deleted' AND source NOT LIKE 'mémo de %%' AND en LIKE %s ORDER BY en ASC",
                      smart_quote("%".$_REQUEST['s']."%"));
    $hResult = mysql_query($sQuery);
    if(!mysql_num_rows($hResult))
    {
        echo "Aucune correspondance approximative trouvée dans les glossaires utilisateurs.";
    } else 
    {
        echo $sTableHeader;
        while($oRow = mysql_fetch_object($hResult))
        {
            echo "<tr>\n";
            echo "  <td>".$oRow->en."</td><td>".$oRow->fr."</td><td>".$oRow->comment."</td><td>".$oRow->source."</td>";
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
    if(confirm('Êtes-vous sûr de vouloir supprimer cette entrée ?'))
         location = 'entry.php?action=delete&id='+id+'&s=<?php echo stripslashes($_REQUEST['s']);?>';
}
</script>
<?php
}
require("./includes/footer.inc.php");
?>
