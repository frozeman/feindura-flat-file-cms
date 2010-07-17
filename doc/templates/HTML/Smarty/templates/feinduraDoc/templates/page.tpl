{include file="header.tpl" top3=true}

<!-- SIDEBAR RIGHT -->
<div class="sidebarMenu right">
  <div class="quickmenu">
    <div class="top"></div>
    <div class="content">
      <a href="#top" class="upButton"></a><br>
      <span class="folder-title">Quick Menu</span>
      <ul>
    	  <li><a href="#sec-description">Description</a></li>
  		{if $classes}
  			<li><a href="#sec-classes">Classes</a></li>
  			{if $includes || $defines || $globals || $functions}|{/if}
  		{/if}
  		{if $includes}
  			<li><a href="#sec-includes">Includes</a></li>
  			{if $defines || $globals || $functions}|{/if}
  		{/if}
  		{if $defines}
  			<li><a href="#sec-constants">Constants</a></li>
  			{if $globals || $functions}|{/if}
  		{/if}
  		{if $globals}
  			<li><a href="#sec-variables">Variables</a></li>
  			{if $functions}|{/if}
  		{/if}
  		{if $functions}
  			<li><a href="#sec-functions">Functions</a></li>
  		{/if}
    	</ul>
    </div>
  	<div class="bottom"></div>
	</div>
	
	{if $includes}
	<div class="includes">
	  <div class="top"></div>
    <div class="content">
  	  <span class="folder-title">Includes</span>
  		<ul>
  		  {section name=includes loop=$includes}
  		  <li><a href="#{$includes[includes].include_file}">{$includes[includes].include_name}</a></li>
  		  {/section}
  		</ul>
		</div>
  	<div class="bottom"></div>
  </div>
  {/if}
  
  {if $classes}
	<div class="classes">
	 <div class="top"></div>
    <div class="content">
  	  <span class="folder-title">Classes</span>
  		<ul class="classes">
  		  {section name=classes loop=$classes}
  		  <li>{$classes[classes].link}</li>
  		  {/section}
  		</ul>
     </div>
  	<div class="bottom"></div> 
  </div>
  {/if}
  
  {if count($defines) > 0}
	<div class="constants">
	 <div class="top"></div>
    <div class="content">
  	  <span class="folder-title">Constants</span>
  		<ul class="variables">
  		  {section name=def loop=$defines}
  		  <li><a href="#{$globals[glob].global_link}">{$defines[def].global_name}</a></li>
  		  {/section}
  		</ul>
  	</div>
  	<div class="bottom"></div>
  </div>
  {/if}
  
  {if count($globals) > 0}
	<div class="variables">
	 <div class="top"></div>
    <div class="content">
  	  <span class="folder-title">Variables</span>
  		<ul class="variables">
  		  {section name=glob loop=$globals}
  		  <li><a href="#{$globals[glob].include_file}">{$globals[glob].define_name}</a></li>
  		  {/section}
  		</ul>
  	</div>
  	<div class="bottom"></div>
  </div>
  {/if}
  
  {if $functions}
  <div class="functions">
    <div class="top"></div>
    <div class="content">	
  	  <span class="folder-title">Functions</span>
  		<ul class="functions">
  		  {section name=func loop=$functions}
  		  <li><a href="#{$functions[func].function_dest}">{$functions[func].function_name}()</a></li>
  		  {/section}
  		</ul>
  	</div>
  	<div class="bottom"></div>
  </div>
  {/if}
</div>

<h2 class="file-name">{$source_location}</h2>

<a name="sec-description"></a>
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
	<a name="sec-classes"></a>	
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
	<a name="sec-includes"></a>	
	<div class="info-box">
		<div class="info-box-title">Includes</div>
			{include file="include.tpl"}
	</div>
{/if}
	
{if $defines}
	<a name="sec-constants"></a>	
	<div class="info-box">
		<div class="info-box-title">Constants</div>
			{include file="define.tpl"}
	</div>
{/if}
	
{if $globals}
	<a name="sec-variables"></a>	
	<div class="info-box">
		<div class="info-box-title">Variables</div>
			{include file="global.tpl"}
	</div>
{/if}
	
{if $functions}
	<a name="sec-functions"></a>	
	<div class="info-box">
		<div class="info-box-title">Functions</div>
			{include file="function.tpl"}
	</div>
{/if}
	
{include file="footer.tpl" top3=true}