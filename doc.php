<?php
/*
 * Documentation page for the Glossary.
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

require("./includes/config.inc.php");
require("./includes/mysql.inc.php");
require("./includes/header.inc.php");
?>

<h2>Introduction</h2>

<p>Ce glossaire a été créé dans le but de faciliter et d'uniformiser
la traduction de logiciels et de documentation informatique.
Cette page sert de documentation pour l'utilisation du système.</p>

<p>L'utilisation du glossaire permet d'avoir une traduction homogène.
Faites cependant attention à bien prendre en compte le contexte de la
traduction et à ne pas appliquer bêtement les traductions indiquées
dans ce document.</p>

<h2>Utilisateurs</h2>

<p>Les utilisateurs du glossaire sont divisés en trois catégories
décrites ci-après.</p>

<h3>Visiteurs</h3>

<p>Un utilisateur qui n'est pas connecté est considéré comme un simple
visiteur. Il peut accéder au glossaire en lecture seule&nbsp;;
c'est-à-dire effectuer des recherches et exporter des données.
Afin d'accéder à plus de fonctions, il est nécessaire que le visiteur
s'enregistre et se connecte au glossaire ou demande son inscription
en tant qu'administrateur sur la
<a href="https://www.traduc.org/mailman/listinfo/glossaire">liste
de diffusion</a>.</p>

<h3>Utilisateurs enregistrés</h3>

<p>Un utilisateur enregistré à les mêmes capacités qu'un visiteur avec
en plus la possibilité de maintenir son glossaire personnel. Les éléments
ajoutés dans le glossaire personnel sont visibles de tous mais ne font
pas partie intégrante du glossaire officiel.</p>

<h3>Administrateurs</h3>

<p>Les administrateurs sont désignés par d'autres administrateurs après
une demande motivée sur la
<a href="https://www.traduc.org/mailman/listinfo/glossaire">liste de
diffusion</a>. Ils ont la capacité de modifier les glossaires officiels
et personnels et de supprimer ou modifier les utilisateurs enregistrés
et les administrateurs.</p>

<h2>Exportation</h2>

<p>Le glossaire officiel peut être <a href="export.php">exporté</a>
dans divers formats dont CSV, XML, etc.</p>

<h2>Importation</h2>

<p>Des glossaires pourront être importés dans le glossaire officiel
par les administrateurs. Les formats supportés sont notamment CSV, XML,
etc.</p>

<h2>Recherche dans Firefox</h2>

<p>Vous pouvez ajouter le glossaire comme moteur de recherche dans
Firefox&nbsp;: <a href="#" onclick="addEngine();">ajouter à
Firefox</a>.</p>

<h2>Organisation</h2>

<p>Le glossaire inter-projet a été créé en commun par l'association
<a href="https://www.traduc.org">Traduc.org</a>,
l'<a href="https://www.openoffice.org/fr/">Équipe francophone
d'OpenOffice.org</a>, le <a href="https://gnomefr.traduc.org/">Groupe de
travail de traduction de GNOME en Français</a> et le projet
<a href="https://fr.l10n.kde.org/">KDE en français</a>.</p>

<p>L'évolution de ce glossaire, ainsi que son contenu sont discutés
sur la liste
<a href="https://www.traduc.org/mailman/listinfo/glossaire">glossaire CHEZ
traduc POINT org</a>.</p>

<h2>Sources</h2>

<p>Les sources du glossaire sont disponibles sur <a
href="https://github.com/fevrier/glossaire">github.com/fevrier/glossaire</a>.
</p>

<?php
require("./includes/footer.inc.php");
?>
