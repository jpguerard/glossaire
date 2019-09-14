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
 * along with Foobar.  If not, see <https://www.gnu.org/licenses/>.
 */

require("session.inc.php");

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">

    <!-- Force IE to use the new rendering engine for a better HTML/CSS compatibility -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <link rel="stylesheet" type="text/css" href="./style/default.css">
    <link rel="icon" type="image/png" href="https://wiki.traduc.org/moin_static/icone.png">

    <script>
        function addEngine() {
            if ((typeof window.sidebar == "object") && (typeof window.sidebar.addSearchEngine == "function"))
            {
                window.sidebar.addSearchEngine(
                    "https://glossaire.traduc.org/glossaire.src",  /* engine URL */
                    "https://glossaire.traduc.org/glossaire.png",  /* icon URL */
                    "glossaire.traduc.org",                        /* engine name */
                    "Web" );                                       /* category name */
            }
            else
            {
                alert("Mozilla M15 or later is required to add a search engine.");
            }
        }
    </script>

    <title><?php echo _("French-english glossary");?></title>
</head>

<body onload="document.f.s.focus();">
<div id="body">

