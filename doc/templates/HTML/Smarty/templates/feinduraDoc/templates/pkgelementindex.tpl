{include file="header.tpl"}
<a name="top" id="top" class="anchor"></a>
<h2>Package: {$package} - element index</h2>
{if count($packageindex) > 1}
	<h4>Package indexes</h4>
	<ul class="packages">
	{section name=p loop=$packageindex}
	{if $packageindex[p].title != $package}
		<li><a href="elementindex_{$packageindex[p].title}.html">{$packageindex[p].title}</a></li>
	{/if}
	{/section}
	</ul>
{/if}
<ul>
  <li class="elementindex"><a href="elementindex.html">All Elements</a></li>
</ul><br>
{include file="basicindex.tpl" indexname=elementindex_$package}
{include file="footer.tpl"}
