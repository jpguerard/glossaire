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


/**
 Returns an array containing each of the sub-strings from text that
 are between openingMarker and closingMarker. The text from
 openingMarker and closingMarker are not included in the result.
 This function does not support nesting of markers.
*/
function return_substring($text, $openingMarker, $closingMarker)
{
    $openingMarkerLength = strlen($openingMarker);
    $closingMarkerLength = strlen($closingMarker);

    $result = array();
    $position = 0;
    while (($position = strpos($text, $openingMarker, $position)) !== false)
    {
        $position += $openingMarkerLength;
        if (($closingMarkerPosition = strpos($text, $closingMarker, $position)) !== false)
        {
            $result[] = substr($text, $position, $closingMarkerPosition - $position);
            $position = $closingMarkerPosition + $closingMarkerLength;
        }
    }
    return $result;
}
 

/**
 * Gets an automatic translation from automatic translators.
 */
function get_automatic_translation($sSource)
{
    $sTableHeader = "<table><tr><th>anglais</th><th>français</th><th>source</th></tr>";
    $sSource = stripslashes(trim($sSource));
    // Google translation
    $hFile = fopen("http://translate.google.com/translate_t?langpair=en|fr&text=".urlencode($sSource), "r");
    while (!feof($hFile)) $sContents .= fread($hFile, 8192);
    fclose($hFile);
    $aRegs = return_substring($sContents,"<textarea name=q rows=5 cols=45 wrap=PHYSICAL dir=ltr>","</textarea>");
    $sGoogle = trim(mb_convert_encoding($aRegs[0],"UTF-8" ,"ISO-8859-1"));
    if($sGoogle && ($sGoogle != $sSource))
        $sOutput .= "<tr><td>".$sSource."</td><td>".$sGoogle."</td><td><a href=\"http://translate.google.com/translate_t\">Google</a></td></tr>";
    $sContents=$aRegs="";

    // Altavista babelfish 
    $hFile = fopen("http://babelfish.altavista.com/tr?ienc=utf8&lp=en_fr&trtext=".urlencode($sSource), "r");
    while (!feof($hFile)) $sContents .= fread($hFile, 8192);
    fclose($hFile);
    $aRegs = return_substring($sContents,"<input type=hidden name=\"q\" value=\"","\">");
    $sAltavista = trim(mb_convert_encoding($aRegs[0],"UTF-8" ,"ISO-8859-1"));
    if($sAltavista && ($sAltavista != $sSource))
        $sOutput .= "<tr><td>".$sSource."</td><td>".$sAltavista."</td><td><a href=\"http://babelfish.altavista.com/tr\">Altavista</a></td></tr>";
    $sContents=$aRegs="";

    // Amikai
    $hFile = fopen("http://standard.beta.amikai.com/amitext/indexUTF8.jsp?langpair=EN,FR&translate=T&sourceText=".urlencode($sSource), "r");
    while (!feof($hFile)) $sContents .= fread($hFile, 8192);
    fclose($hFile);
    $aRegs = return_substring($sContents,"<textarea name=\"translatedText\" rows=\"2\" cols=\"54\" wrap=\"virtual\" style=\"background: #D8E6FC; color: #000;\">","</textarea>");
    $sAmikai = trim($aRegs[0]);
    if($sAmikai && ($sAmikai != $sSource))
        $sOutput .= "<tr><td>".$sSource."</td><td>".$sAmikai."</td><td><a href=\"http://amikai.com/demo.jsp\">Amikai</a></td></tr>";

    if($sOutput)
    {
        echo "<h3>Traduction automatique</h3>";
        echo "<p><strong>Attention: les traductions automatiques ne doivent être prises que comme une simple indication.</strong></p>";
        echo $sTableHeader;
        echo $sOutput;
        echo "</table>";
    }

}
?>

<h2>Introduction</h2>
<p>L'utilisation du glossaire permet d'avoir une traduction homogène. Faites cependant attention à bien prendre en compte le contexte de la traduction et à ne pas appliquer bêtement les traductions indiquées dans ce document.</p>

<h2>Autres sources et références</h2>
<ul>
 <li><p> Office de la langue française : <a href="http://www.culture.gouv.fr/culture/dglf/">France</a> - <a href="http://www.cfwb.be/franca/">Belgique</a> - <a href="http://www.olf.gouv.qc.ca/">Canada</a> - <a href="http://www.ciip.ch/ciip/DLF/">Suisse</a></p></li>
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
        //get_automatic_translation($_REQUEST['s']);
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

    $sQuery = sprintf("SELECT * FROM glossary WHERE state!='deleted' AND source NOT LIKE 'mémo de %%' AND (en LIKE %s OR en LIKE %s OR en LIKE %s OR en LIKE %s OR en LIKE %s OR en LIKE %s OR en LIKE %s) ORDER BY en ASC",
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
        echo "<h3>Correspondances approximatives (mots entiers seulement)</h3>";
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

    $sQuery = sprintf("SELECT * FROM glossary WHERE state!='deleted' AND source LIKE 'mémo de %%' AND (en LIKE %s OR en LIKE %s OR en LIKE %s OR en LIKE %s OR en LIKE %s OR en LIKE %s OR en LIKE %s) ORDER BY en ASC",
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
        echo "<h3>Correspondances approximatives (mots entiers seulement) dans les glossaires utilisateurs</h3>";
        echo "<p><strong>Attention: ces traductions ne sont pas officielles, à utiliser avec précaution.</strong></p>";
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

    $sQuery = sprintf("SELECT * FROM glossary WHERE state!='deleted' AND source NOT LIKE 'mémo de %%' AND en LIKE %s ORDER BY en ASC",
                      smart_quote("%".$_REQUEST['s']."%"));
    $hResult = mysql_query($sQuery);
    if(mysql_num_rows($hResult))
    {
        echo "<h3>Correspondances approximatives (toutes)</h3>";
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
