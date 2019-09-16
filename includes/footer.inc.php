<?php
/*
 * Glossary's pages footer.
 *
 * Copyright (C) 2006 Jonathan Ernst
 * Copyright (C) 2006-2011 Jean-Philippe Guérard
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

?>

<div id="hdr">
  <div id="logo">
    <a href="https://traduc.org/">
      <img src="./images/spacer" alt="">
    </a>
  </div>

  <div id="banner">
    <img src="./images/spacer" alt="">
  </div>
  <p class="none">
  </p>
  <div id="hdrNav">
    <strong>
      <a href="/"><?php echo _("Glossary:");?></a>
    </strong>
    <a href="doc.php"><?php echo _("Documentation");?></a> &middot;
    <a href="https://www.traduc.org/mailman/listinfo/glossaire"><?php
      echo _("Contact");
    ?></a> &middot;
    <?php

    if( $_SESSION['admin'] || $_SESSION['user'] ) {
        echo "<strong><a href=\"user.php\">"
         .($_SESSION['admin']?$_SESSION['admin']:$_SESSION['user'])."</a>"
         ." (<a href=\"index.php?logout=1\">"._("logout")."</a>)</strong>";
    } else {
        echo "<strong><a href=\"login.php\">"._("Login")."</a></strong>";
    }

    ?> &middot;
    <a href="history.php"><?php echo _("History");?></a> &middot;
    <a href="export.php"><?php echo _("Export");?></a>
    </div>
  </div>
</div>
<div id="copyright">
    Copyright &copy; 2006, Jonathan Ernst<br>
    <a href="https://validator.w3.org/check/referer"><?php echo _("Designed");?></a>
    <?php echo _("for");?> 
    <a href="https://www.w3.org/"><?php echo _("standards");?></a>.
</div>
</body>
</html>

