<?php
/*
 * Documentation page for the Glossary.
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
Ce glossaire a été créé dans le but de faciliter et d'uniformiser la traduction de logiciels et de documentation informatique.
Cette page sert de documentation pour l'utilisation du système.

<h2>Utilisateurs</h2>
Les utilisateurs du glossaire sont divisés en trois catégories décrites ci-après.
<h3>Visiteurs</h3>
Un utilisateur qui n'est pas connecté est considéré comme un simple visiteur. 
Il peut accéder au glossaire en lecture seule ; c'est à dire effectuer des recherches et exporter des données.
Afin d'accéder à plus de fonctions, il est nécessaire que le visiteur s'enregistre et se connecte au glossaire ou demande son inscription en tant qu'administrateur sur la <a href="http://www.traduc.org/mailman/listinfo/glossaire">liste de diffusion</a>.

<h3>Utilisateurs enregistrés</h3>
Un utilisateur enregistré à les mêmes capacités qu'un visiteur avec en plus la possibilité de maintenir son glossaire personnel. Les éléments ajoutés dans le glossaire personnel sont visibles de tous mais ne font pas partie intégrante du glossaire officiel.

<h3>Administrateurs</h3>
Les administrateurs sont désignés par d'autres administrateurs après une demande motivée sur la <a href="http://www.traduc.org/mailman/listinfo/glossaire">liste de diffusion</a>. Ils ont la capacité de modifier les glossaires officiels et personnels et de supprimer ou modifier les utilisateurs enregistrés et les administrateurs.

<h2>Exportation</h2>
Le glossaire officiel peut être <a href="export.php">exporté</a> dans divers formats dont CSV, XML, etc.

<h2>Importation</h2>
Des glossaires pourront être importés dans le glossaire officiel par les administrateurs. Les formats supportés sont notamment CSV, XML, etc.

<?php
require("./includes/footer.inc.php");
?>
