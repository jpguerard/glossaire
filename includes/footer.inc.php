<?php
/*
 * Glossary's pages footer.
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
?>
<div id="hdr">
  <div id="logo"><a href="http://glossaire.traduc.org/"><img src="http://www.gnomefr.org/img/spacer" alt="" /></a></div>
  <div id="banner"><img src="http://www.gnomefr.org/img/spacer" alt="" /></div>
  <p class="none"></p>
  <div id="hdrNav">
    <a href="http://wiki.traduc.org/Traduc.org">&Agrave; propos de Traduc.org</a> &middot;
    <a href="http://www.traduc.org/mailman/listinfo/glossaire">Contact</a> &middot;
    <a href="doc.php">Documentation</a> &middot;
<?php
if($_SESSION['admin'] || $_SESSION['user'])
    echo "<a href=\"user.php\">".($_SESSION['admin']?$_SESSION['admin']:$_SESSION['user'])."</a> (<a href=\"index.php?logout=1\">déconnexion</a>)";
else 
    echo "<a href=\"login.php\">Connexion</a>";
echo " &middot; <i>~".$_SESSION['total']." entrées dans le <a href=\"index.php\">glossaire</a> (<a href=\"history.php\">historique</a>, <a href=\"export.php\">export</a>).</i>";?>

  </div>
</div>
</div>
<div id="copyright">
Copyright &copy; 2006, Jonathan Ernst<br />
<a href="http://validator.w3.org/check/referer">Optimisé</a> pour les
<a href="http://www.w3.org/">standards</a>.
</div>
</body>
</html>
