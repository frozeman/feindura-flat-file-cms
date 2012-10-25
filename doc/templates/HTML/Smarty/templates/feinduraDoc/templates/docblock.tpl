<!-- ========== DocBlock ========= -->
<div class="docBlock">
{if $sdesc || $desc}
<div class="method-description">
{/if}
{if $sdesc}
<h3>Description</h3>
<p class="short-description">{$sdesc}</p>
{/if}
{if $desc}
<p class="description">{$desc}</p>
{/if}
{if $sdesc || $desc}
</div>
{/if}

{if $tags}
<hr>
	{section name=tags loop=$tags}{if $tags[tags].keyword == 'return'}{assign var="hasReturn" value="true"}{/if}{/section}
	{if $hasReturn == 'true'}
	<div class="insideDocBlock method-return">
	<h5>Return Value</h5>
		<ul class="tags">
{section name=tags loop=$tags}{if $tags[tags].keyword == 'return'}
<li><var>{$methods[methods].function_return}</var> - {$tags[tags].data}</li>
{/if}{/section}
		</ul>
        </div>
	{/if}
	{section name=tags loop=$tags}{if $tags[tags].keyword != 'version' && $tags[tags].keyword != 'return' && $tags[tags].keyword != 'uses' && $tags[tags].keyword != 'usedby'}{assign var="hasTags" value="true"}{/if}{/section}
	{if $hasTags == 'true'}
	<div class="insideDocBlock method-tags">
	<h5>Additional</h5>
		<ul class="tags">
{section name=tags loop=$tags}{if $tags[tags].keyword != 'version' && $tags[tags].keyword != 'return' && $tags[tags].keyword != 'uses' && $tags[tags].keyword != 'usedby'}
<li><span class="field">{$tags[tags].keyword}:</span> {$tags[tags].data}</li>
{/if}{/section}
		</ul>
        </div>
	{/if}
	{section name=tags loop=$tags}{if $tags[tags].keyword == 'usedby'}{assign var="hasUsedBy" value="true"}{/if}{/section}
	{if $hasUsedBy == 'true'}
	<div class="insideDocBlock method-usedby">
	<h5>Used By</h5>
		<ul>
{section name=tags loop=$tags}{if $tags[tags].keyword == 'usedby'}
<li>{$tags[tags].data}</li>
{/if}{/section}
		</ul>
        </div>
	{/if}
	{section name=tags loop=$tags}{if $tags[tags].keyword == 'uses'}{assign var="hasUses" value="true"}{/if}{/section}
	{if $hasUses == 'true'}
	<div class="insideDocBlock method-uses">
	<h5>Uses</h5>
		<ul>
{section name=tags loop=$tags}{if $tags[tags].keyword == 'uses'}
<li>{$tags[tags].data}</li>
{/if}{/section}
		</ul>
        </div>
	{/if}
	{section name=tags loop=$tags}{if $tags[tags].keyword == 'version'}{assign var="hasVersion" value="true"}{/if}{/section}
	{if $hasVersion == 'true'}
	<div class="insideDocBlock method-version">
	<h5>Version</h5>
		<ul class="tags">
{section name=tags loop=$tags}{if $tags[tags].keyword == 'version'}
<li>{$tags[tags].data}</li>
{/if}{/section}
		</ul>
	</div>
	{/if}
{/if}
</div>

<hr>

<div class="spacer"></div>