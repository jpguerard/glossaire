<?php
/*
 * Glossary entry management page.
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

// If we are not logged in, we don't have access to this page.
if(!$_SESSION['admin'] && !$_SESSION['user'])
    header("Location: index.php");

require("./includes/mysql.inc.php");

// We'd like to create a new entry.
if($_POST['action'] == "new")
{
    $sQuery = sprintf("INSERT INTO glossary (en,fr,comment,source,date,user) VALUES (%s,%s,%s,%s,NOW(),%s)",
                       smart_quote($_POST['en']),
                       smart_quote($_POST['fr']),
                       smart_quote($_POST['comment']),
                       smart_quote(($_SESSION['admin']?$_POST['source']:"mémo de ".$_SESSION['user'])),
                       smart_quote(($_SESSION['admin']?$_SESSION['admin']:$_SESSION['user'])));
    mysql_query($sQuery);
    header("Location: index.php?s=".$_POST['en']);

// We'd like to edit an entry.
} elseif ($_POST['action'] == "edit")
{
    // Admins can update any record.
    if($_SESSION['admin'])
        $sQuery = sprintf("UPDATE glossary SET fr=%s, comment=%s, source=%s, date=NOW(), state='edited', user=%s WHERE id=%s LIMIT 1",
                          smart_quote($_POST['fr']),
                          smart_quote($_POST['comment']),
                          smart_quote($_POST['source']),
                          smart_quote($_SESSION['admin']),
                          smart_quote($_POST['id']));
    // Users can only admin their own records (checked using source).
    else
        $sQuery = sprintf("UPDATE glossary SET fr=%s, comment=%s, date=NOW(), state='edited' WHERE id=%s AND source=%s LIMIT 1",
                          smart_quote($_POST['fr']),
                          smart_quote($_POST['comment']),
                          smart_quote($_POST['id']),
                          smart_quote("mémo de ".$_SESSION['user']));
    mysql_query($sQuery);
    header("Location: index.php?s=".$_POST['en']);
} elseif ($_GET['action'] == "delete")
{ 
    // Admins can delete any record. To be secure we just set them to deleted in order to be able to restore it later.
    if($_SESSION['admin'])
        $sQuery = sprintf("UPDATE glossary SET state='deleted', user=%s, date=NOW() WHERE id=%s LIMIT 1",
                          smart_quote($_SESSION['admin']),
                          smart_quote($_GET['id']));
    // Users can delete only their records. The deletion is permanent.
    else
        $sQuery = sprintf("DELETE FROM glossary WHERE id=%s AND source=%s LIMIT 1",
                          smart_quote($_GET['id']),
                          smart_quote("mémo de ".$_SESSION['user']));
    mysql_query($sQuery);
    header("Location: index.php?s=".$_GET['s']);
// Only admins can undelete entries.
} elseif ($_GET['action'] == "undelete" && $_SESSION['admin'])
{ 
    $sQuery = sprintf("UPDATE glossary SET state='edited', user=%s, date=NOW() WHERE id=%s LIMIT 1",
                      smart_quote($_SESSION['admin']),
                      smart_quote($_POST['id']) ) ;
    mysql_query($sQuery);
    header("Location: history.php");
}
require("./includes/header.inc.php");

$sStartForm = "<form method=\"post\" action=\"".$_SERVER['PHP_SELF']."\">\n";
// We want to add an entry.
if($_GET['s'])
{
    $sSubmitLabel = "ajouter";
    $sStartForm .= "<input type=\"hidden\" name=\"action\" value=\"new\" />";
    $sStartForm .= "<label for=\"en\">Anglais : </label><input id=\"en\" name=\"en\" type=\"text\" value=\"".stripslashes($_GET['s'])."\" /><br />";
// We want to edit an entry.
} elseif($_GET['id'])
{
    $sQuery = sprintf("SELECT * FROM glossary WHERE id=%s LIMIT 1",
                      smart_quote($_GET['id']));
    $hResult = mysql_query($sQuery);
    $oRow = mysql_fetch_object($hResult);
    $sSubmitLabel = "modifier";
    $sStartForm .= "<input type=\"hidden\" name=\"action\" value=\"edit\" />";
    $sStartForm .= "<input type=\"hidden\" name=\"id\" value=\"".$_GET['id']."\" />";
    $sStartForm .= "<label for=\"en\">Anglais : </label><input readonly=\"readonly\" id=\"en\" name=\"en\" type=\"text\" value=\"".$oRow->en."\" /> (lecture seule)<br />";
}
echo "<h2>".ucfirst($sSubmitLabel)." une entrée</h2>\n";
echo $sStartForm;
?>
  <label for="fr">Français : </label><input id="fr" name="fr" type="text" value="<?php echo $oRow->fr;?>" /><br />
  <label for="comment">Commentaires : </label><textarea style="width:18.5em" rows="3" id="comment" name="comment"><?php echo $oRow->comment;?></textarea> (détails, liens vers discussions ou référence)<br />
  <?php
  if($_SESSION['user'])
  {
  ?>
  <label for="source">Source : </label><input readonly="readonly" maxlength="25" id="source" name="source" type="text" value="<?php echo "mémo de ".$_SESSION['user'];?>" /> (lecture seule)<br />
  <?php
  } else 
  {
  ?>
  <label for="source">Source : </label><input maxlength="25" id="source" name="source" type="text" value="<?php echo $oRow->source;?>" /> (par ex. GNOME, Sun, Mozilla)<br />
  <?php
  }
  ?>
  <input type="submit" value="<?php echo $sSubmitLabel;?>">
</form>

<?php
require("./includes/footer.inc.php");
?>
