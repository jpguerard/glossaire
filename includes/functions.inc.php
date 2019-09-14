<?php
/*
 * Common functions.
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

/**
 * Quote variable to make it safe.
 */
function smart_quote($sValue)
{

  global $mysqllink;

  // No php/html tags allowed in database.
  $sValue = strip_tags($sValue);

  // Quote if not a number or a numeric string.
  if (!is_numeric($sValue)) {

    $sValue = "'" . mysqli_real_escape_string($mysqllink, $sValue) . "'";

  }
  return $sValue;
}

/**
 Returns an array containing each of the sub-strings from text that
 are between openingMarker and closingMarker. The text from
 openingMarker and closingMarker are not included in the result.
 This function does not support nesting of markers.
*/

function return_substring($text, $openingMarker, $closingMarker) {

  $openingMarkerLength = strlen($openingMarker);
  $closingMarkerLength = strlen($closingMarker);

  $result = array();
  $position = 0;
  while (($position = strpos($text, $openingMarker, $position)) !== false) {

    $position += $openingMarkerLength;

    if ( ($closingMarkerPosition = strpos($text, $closingMarker, $position)) 
         !== false ) {
       $result[] = substr($text, $position, $closingMarkerPosition - $position);
       $position = $closingMarkerPosition + $closingMarkerLength;
    }
  }
  return $result;
}
 

/**
 * Gets an automatic translation from automatic translators.
 */
function get_automatic_translation($sSource) {

  global $config;
  $sTableHeader = "<table><tr><th>".$config['lng_source']."</th>"
                  ."<th>".$config['lng_target']."</th>"
                  ."<th>"._("source")."</th></tr>";
  $sSource = stripslashes(trim($sSource));

  // Google translation
  if($config['at_google']) {

    $hFile = fopen("https://translate.google.com/translate_t?langpair="
                   .$config['at_google']."&text=".urlencode($sSource), "r");

    while ( ! feof($hFile) ) $sContents .= fread($hFile, 8192);

    fclose($hFile);

    $aRegs = return_substring(
                $sContents,
                '<textarea name="q" rows="5" cols="45" wrap="PHYSICAL" dir="ltr>',
                "</textarea>");

    $sGoogle = trim($aRegs[0])!=$sSource?trim(mb_convert_encoding($aRegs[0],
                                              "UTF-8" ,"ISO-8859-1")):"";
    if($sGoogle) {

      $sOutput .= "<tr><td>".$sSource."</td><td>".$sGoogle."</td>"
          ."<td>"
          .'<a href="https://translate.google.com/translate_t">Google</a>'
          ."</td></tr>";

    }
    $sContents=$aRegs="";
  }

  // Altavista babelfish 
  if($config['at_babelfish_dst']) {
      $hFile = fopen(
          "https://www.babelfish.fr/dict"
            ."?src=".$config['at_babelfish_src']
            ."&dst=".$config['at_babelfish_dst']
            ."&query=".urlencode($sSource),
          "r");
    while ( !feof($hFile) ) $sContents .= fread($hFile, 8192);

    fclose($hFile);

    $aRegs = return_substring($sContents,"<input type=hidden "
                              ."name=\"q\" value=\"","\">");
    
    $sResults = trim($aRegs[0])!=$sSource?trim($aRegs[0]):"";
    if($sResults) {
        $sOutput .= "<tr>"
            ."<td>".$sSource."</td>"
            ."<td>".$sResults."</td>"
            .'<td><a href="https://www.babelfish.fr/dict">BabelFish</a></td>'
            ."</tr>";
    }

    $sContents=$aRegs="";
  }

  if($sOutput) {

    echo "<h3>"._("Automatic translation")."</h3>";
    echo "<p><strong>"._("Warning: automatic translations have to be "
         ."taken as a mere indication.")."</strong></p>";
    echo $sTableHeader;
    echo $sOutput;
    echo "</table>";
  }

}

function prepare_source($sSource)
{
    return strstr($sSource,"*")?str_replace("%s",str_replace("*","",$sSource),_("personnal memo of %s")):$sSource;
}
?>
