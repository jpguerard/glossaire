<?php
/*
 * Glossary's pages header and login logic.
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
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston,
 * MA  02110-1301  USA.
 *
 */

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

    define_syslog_variables();
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

header("Content-Type: text/html; charset=utf-8");
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">

<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link rel="stylesheet" type="text/css" href="./style/default.css" />
<link rel="icon" type="image/png"
      href="https://wiki.traduc.org/moin_static/icone.png" />

<script>
function addEngine() {
  if ((typeof window.sidebar == "object") && (typeof window.sidebar.addSearchEngine == "function"))
  {
    window.sidebar.addSearchEngine(
      "https://glossaire.traduc.org/glossaire.src",  /* engine URL */
      "https://glossaire.traduc.org/glossaire.png",  /* icon URL */
      "glossaire.traduc.org",                       /* engine name */
      "Web" );                                      /* category name */
  }
  else
  {
    alert("Mozilla M15 or later is required to add a search engine.");
  }
}
</script>
<title><?php echo _("French-english glossary");?></title>
</head>

<body onload="document.f.s.focus();" >
<div id="body">
