<?php
/*
 * MySql connection include.
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

mysql_connect($config['db_host'], $config['db_username'], $config['db_password']);
mysql_select_db($config['db_database']);


// Quote variable to make it safe.
function smart_quote($sValue)
{
   // No php/html tags allowed in database.
   $sValue = strip_tags($sValue);

   // Stripslashes.
   if (get_magic_quotes_gpc())
   {
       $sValue = stripslashes($sValue);
   }
   // Quote if not a number or a numeric string.
   if (!is_numeric($sValue))
   {
       $sValue = "'" . mysql_real_escape_string($sValue) . "'";
   }
   return $sValue;
}
?>
