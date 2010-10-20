{capture name="tutle"}File Source for {$name}{/capture}
{include file="header.tpl" title=$smarty.capture.tutle}
<h2 class="file-name">Source for file {$name}</h2>
<p>Documentation is available at {$docs}</p>
<div class="php"></div>
{$source}
{include file="footer.tpl"}