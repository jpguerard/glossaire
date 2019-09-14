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

require("session.inc.php");

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
