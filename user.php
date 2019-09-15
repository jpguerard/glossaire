<?php
/*
 * Glossary's user management page.
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
 * along with the Glossary.  If not, see <https://www.gnu.org/licenses/>.
 */

require("./includes/config.inc.php");
require("./includes/mysql.inc.php");

// We'd like to create a new user and we are either an admin or a guest.
if($_POST['action'] == "new" && !$_SESSION['user']) {   

  $sQuery = sprintf("INSERT INTO users (username,password,admin) "
                    ."VALUES (%s,MD5(%s),%s)",
              smart_quote($_POST['username']),
              smart_quote($_POST['password']),
              smart_quote(($_SESSION['admin']?'true':'false')));
  mysqli_query($mysqllink, $sQuery);

  if( mysqli_affected_rows($mysqllink) ) {

    $sMessage = "<p><strong>Nouvel "
                .($_SESSION['admin']?'administrateur':'utilisateur')
                ." ".$_POST['username']." créé.</strong></p>";

  } else {

    $sMessage = "<p><strong>Impossible d'ajouter le nouvel utilisateur, "
                ."il existe peut-être déjà.</strong></p>";

  }

// We'd like to edit an user and we are either an admin or a user.
} elseif ( $_POST['action'] == "edit"
           && ( $_SESSION['admin']
                || $_SESSION['user'] ) ) {

  // We are a user, so we need to provide our old password.
  if($_SESSION['user']) {

    $sQuery = sprintf("UPDATE users SET password=MD5(%s) "
                      ."WHERE username=%s AND password=MD5(%s) LIMIT 1",
                smart_quote($_POST['password']),
                smart_quote($_POST['username']),
                smart_quote($_POST['oldpassword']));

  // Admins can change any passwords.
  } else {

    $sQuery = sprintf("UPDATE users SET password=MD5(%s) "
                       ."WHERE username=%s LIMIT 1",
                smart_quote($_POST['password']),
                smart_quote($_POST['username']));
  }

  mysqli_query($mysqllink, $sQuery);

  if(mysqli_affected_rows($mysqllink)) {

    $sMessage = "<p><strong>Mot de passe de l'utilisateur "
                .$_POST['username']." changé.</strong></p>";

  } else {

    $sMessage = "<p><strong>Impossible de changer le mot de passe de "
                ."l'utilisateur. L'ancien mot de passe ou le nom "
                ."d'utilisateur sont peut-être incorrects.</strong></p>";

  }

// Only admins can delete users.
} elseif ($_POST['action'] == "delete" && $_SESSION['admin']) {

  $sQuery = sprintf("DELETE FROM users WHERE username=%s LIMIT 1",
              smart_quote($_POST['username']));
  mysqli_query($mysqllink, $sQuery);

  if(mysqli_affected_rows($mysqllink)) {
    $sMessage = "<p><strong>Utilisateur ".$_POST['username']." supprimé.</strong></p>";
  } else {
    $sMessage = "<p><strong>Impossible de supprimer l'utilisateur. "
                ."Il n'existe peut-être pas dans la base de "
                ."données.</strong></p>";
  }
}

require("./includes/header.inc.php");

echo $sMessage;

// Admins can do everything.
if($_SESSION['admin']) { ?>

  <h2>Ajouter un administrateur</h2>
  <form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
    <input type="hidden" name="action" value="new">
    <label for="username">Nom d'utilisateur : </label>
    <input id="username" name="username" type="text"><br>
    <label for="password">Mot de passe : </label>
    <input id="password" name="password" type="password"><br>
    <input type="submit" value="ajouter">
  </form>

  <h2>Modifier un mot de passe</h2>
  <form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
    <input type="hidden" name="action" value="edit">
    <label for="username">Nom d'utilisateur : </label>
    <input id="username" name="username" type="text"><br>
    <label for="password">Mot de passe : </label>
    <input id="password" name="password" type="password"><br>
    <input type="submit" value="modifier">
  </form>

  <h2>Supprimer un utilisateur</h2>
  <form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
    <input type="hidden" name="action" value="delete">
    <label for="username">Nom d'utilisateur : </label>
    <input id="username" name="username" type="text"><br>
    <input type="submit" value="supprimer">
  </form>

<?php

// Users can only change their passwords.
} elseif($_SESSION['user']) { ?>

  <h2>Modifier son mot de passe</h2>
  <form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
    <input type="hidden" name="action" value="edit">
    <label for="oldpassword">Ancien mot de passe : </label>
    <input id="oldpassword" name="oldpassword" type="password"><br>
    <label for="password">Mot de passe : </label>
    <input id="password" name="password" type="password"><br>
    <input type="submit" value="modifier">
  </form>

<?php

// Visitors can only subscribe.
} else { ?>

  <h2>S'inscrire</h2>
  <form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
    <input type="hidden" name="action" value="new">
    <label for="username">Nom d'utilisateur : </label>
    <input id="username" name="username" type="text"><br>
    <label for="password">Mot de passe : </label>
    <input id="password" name="password" type="password"><br>
    <input type="submit" value="ajouter">
  </form>

<?php }

require("./includes/footer.inc.php");

