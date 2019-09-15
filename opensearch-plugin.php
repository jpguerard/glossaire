<?php
/*
 * OpenSearch plugin for the Glossary serach engine.
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

header('Content-type: application/opensearchdescription+xml');

?><OpenSearchDescription xmlns="http://a9.com/-/spec/opensearch/1.1/"
                       xmlns:moz="http://www.mozilla.org/2006/browser/search/">
  <ShortName>glo.traduc.org</ShortName>
  <Description>Glossaire de traduc.org</Description>
  <InputEncoding>UTF-8</InputEncoding>
  <Image width="16" height="16" type="image/png">https://glossaire.traduc.org/images/icon.png</Image>
  <Url type="text/html" template="https://glossaire.traduc.org/">
    <Param name="s" value="{searchTerms}"/>
  </Url>
  <Url type="application/x-suggestions+json" template="https://glossaire.traduc.org/"/>
  <moz:SearchForm>https://glossaire.traduc.org/</moz:SearchForm>
</OpenSearchDescription>

