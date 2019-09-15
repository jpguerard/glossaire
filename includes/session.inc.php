<?php
/*
 * Glossary's session logic.
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

session_start();

// We tried to log in.
if ( !$_SESSION['admin']
     && $_POST['username']
     && $_POST['password']
     && !$_POST['action'] ) {

  $sQuery = sprintf("SELECT username,admin FROM users WHERE username=%s "
                    ."AND password=MD5(%s) LIMIT 1",
                      smart_quote($_POST['username']),
                      smart_quote($_POST['password']));
  $hResult = mysqli_query($mysqllink, $sQuery);
  $oRow = mysqli_fetch_object($hResult);

  if($oRow->username && $oRow->admin=="true") {

    $_SESSION['admin'] = $_POST['username'];

  } elseif($oRow->username) {

    $_SESSION['user'] = $_POST['username'];

  } else {

    syslog(LOG_NOTICE, "Echec de connexion de "
                       .$_POST['username']." au glossaire");

  }
} elseif($_GET['logout']) {

    $_SESSION['admin'] = "";   
    $_SESSION['user'] = ""; 

}

// $_SESSION['total'] is used to show the total number of records in
// the database.
// Let's compute it only if it hasn't been computed in this session.
if(!$_SESSION['total']) {

    $sQuery = "SELECT count(1) as total FROM glossary";
    $hResult = mysqli_query($mysqllink, $sQuery);
    $oRow = mysqli_fetch_object($hResult);
    $_SESSION['total'] = $oRow->total;

}

