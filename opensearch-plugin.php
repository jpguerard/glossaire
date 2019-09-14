<?php header('Content-type: application/opensearchdescription+xml'); ?>
<OpenSearchDescription xmlns="http://a9.com/-/spec/opensearch/1.1/"
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

