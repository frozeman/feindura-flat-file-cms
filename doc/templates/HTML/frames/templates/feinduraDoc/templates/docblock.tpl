<!-- ========== DocBlock ========= -->
{if $sdesc || $desc}
<div class="method-description">
<b>Description</b><br>
{/if}
{if $sdesc}
<p class="short-description">{$sdesc}</p>
{/if}
{if $desc}
<p class="description">{$desc}</p>
{/if}
{if $sdesc || $desc}
</div>
{/if}
{if $tags}
	<div class="method-tags">
	{section name=tags loop=$tags}{if $tags[tags].keyword == 'uses'}{assign var="hasUses" value="true"}{/if}{/section}
	{if $hasUses == 'true'}
		<b>Used Properties</b><br>
		<ul class="tags">
{section name=tags loop=$tags}{if $tags[tags].keyword == 'uses'}
<li><span class="field">{$tags[tags].keyword}:</span> {$tags[tags].data}</li>		
{/if}{/section}
		</ul>
	{/if}
	{section name=tags loop=$tags}{if $tags[tags].keyword == 'return'}{assign var="hasReturn" value="true"}{/if}{/section}
	{if $hasReturn == 'true'}
		<b>Return Value</b><br>
		<ul class="tags">
{section name=tags loop=$tags}{if $tags[tags].keyword == 'return'}
<li><span class="field">{$tags[tags].keyword}:</span> {$tags[tags].data}</li>		
{/if}{/section}
		</ul>
	{/if}
	{section name=tags loop=$tags}{if $tags[tags].keyword != 'version' && $tags[tags].keyword != 'return' && $tags[tags].keyword != 'uses'}{assign var="hasTags" value="true"}{/if}{/section}
	{if $hasTags == 'true'}
		<b>Additional</b><br>
		<ul class="tags">
{section name=tags loop=$tags}{if $tags[tags].keyword != 'version' && $tags[tags].keyword != 'return' && $tags[tags].keyword != 'uses'}
<li><span class="field">{$tags[tags].keyword}:</span> {$tags[tags].data}</li>
{/if}{/section}
		</ul>
	{/if}
	</div>
	
	{section name=tags loop=$tags}{if $tags[tags].keyword == 'version'}{assign var="hasVersion" value="true"}{/if}{/section}
	{if $hasVersion == 'true'}
	<div class="method-version">
	<b>Version</b><br>
		<ul class="tags">
{section name=tags loop=$tags}{if $tags[tags].keyword == 'version'}
<li>{$tags[tags].data}</li>
{/if}{/section}
		</ul>
	</div>
	{/if}
{/if}
