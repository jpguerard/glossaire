<?php
/*
 * Login page for the Glossary (the login logic is in includes/header.inc.php).
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
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301  USA.
 */

require("./includes/config.inc.php");
if($_SESSION['admin'] || $_SESSION['user'])
    header("Location: index.php");
require("./includes/mysql.inc.php");
require("./includes/header.inc.php");
?>

<h2>Connexion</h2>
<p><strong>Si vous souhaitez obtenir un compte, <a href="user.php">inscrivez-vous</a>.</strong></p>
<form method="post" action="index.php">
  <label for="username">Nom d'utilisateur : </label><input id="username" name="username" type="text" /><br />
  <label for="password">Mot de passe : </label><input id="password" name="password" type="password" /><br />
  <input type="submit" value="se connecter">
</form>

<?php
require("./includes/footer.inc.php");
?>
