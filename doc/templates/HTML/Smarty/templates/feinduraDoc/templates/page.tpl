{include file="header.tpl" top3=true}


<h2 class="file-name">{$source_location}</h2>

<a name="sec-description" id="sec-description" class="anchor"></a>
<div class="info-box">
	<div class="info-box-title">Description</div>
	<div class="info-box-body">	
		{include file="docblock.tpl" desc=$desc sdesc=$sdesc tags=$tags}
		
		{if $tutorial}
			<hr class="separator" />
			<div class="notes">Tutorial: <span class="tutorial">{$tutorial}</div>
		{/if}
	</div>
</div>
		
{if $classes}
	<a name="sec-classes" id="sec-classes" class="anchor"></a>	
	<div class="info-box">
		<div class="info-box-title">Classes</div>
		<div class="info-box-body"> 
		  <div class="docBlock">
			<table cellpadding="2" cellspacing="0" class="class-table">
				<tr>
					<th class="class-table-header">Class</th>
					<th class="class-table-header">Description</th>
				</tr>
				{section name=classes loop=$classes}
				<tr>
					<td style="padding-right: 2em; vertical-align: top">
						{$classes[classes].link}
					</td>
					<td>
					{if $classes[classes].sdesc}
						{$classes[classes].sdesc}
					{else}
						{$classes[classes].desc}
					{/if}
					</td>
				</tr>
				{/section}
			</table>
			</div>
		</div>
	</div>
{/if}

{if $includes}
	<a name="sec-includes" id="sec-includes" class="anchor"></a>	
	<div class="info-box">
		<div class="info-box-title">Includes</div>
			{include file="include.tpl"}
	</div>
{/if}
	
{if $defines}
	<a name="sec-constants" id="sec-constants" class="anchor"></a>	
	<div class="info-box">
		<div class="info-box-title">Constants</div>
			{include file="define.tpl"}
	</div>
{/if}
	
{if $globals}
	<a name="sec-variables" id="sec-variables" class="anchor"></a>	
	<div class="info-box">
		<div class="info-box-title">Variables</div>
			{include file="global.tpl"}
	</div>
{/if}
	
{if $functions}
	<a name="sec-functions" id="sec-functions" class="anchor"></a>	
	<div class="info-box">
		<div class="info-box-title">Functions</div>
			{include file="function.tpl"}
	</div>
{/if}
	
{include file="footer.tpl" top3=true}