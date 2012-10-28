<A NAME='method_detail'></A>
{section name=methods loop=$methods}
{if $methods[methods].static}
<a name="method{$methods[methods].function_name}" id="{$methods[methods].function_name}" class="anchor"><!-- --></a>
<div class="{cycle values="evenrow,oddrow"}">

  
  <div class="method-header">
    <a href="#sec-method-summary" class="upButton" title="back to the methods summary"></a>
    <span class="lineNumber"><span>File source:</span><br>
    line {if $methods[methods].slink}{$methods[methods].slink}{else}{$methods[methods].line_number}{/if}
    </span>
  	<table>
  	  <tr><td>static <span class="method-result">{$methods[methods].function_return}</span>
  		<span class="method-title">
  			{if $methods[methods].ifunction_call.returnsref}&amp;{/if}{if $methods[methods].ifunction_call.constructor}Constructor {elseif $methods[methods].ifunction_call.destructor}Destructor {/if}{$methods[methods].function_name}
  		</span>
      <span class="method-braces">(</span>
      </td><td>
  		{if count($methods[methods].ifunction_call.params)}
  			{section name=params loop=$methods[methods].ifunction_call.params}{if $smarty.section.params.iteration != 1},<br>{/if}{if $methods[methods].ifunction_call.params[params].hasdefault}<span class="method-optional-braces">[</span>{/if}<span class="var-type">{$methods[methods].ifunction_call.params[params].type}</span>&nbsp;<span class="var-name">{$methods[methods].ifunction_call.params[params].name}</span>{if $methods[methods].ifunction_call.params[params].hasdefault} = <span class="var-default">{$methods[methods].ifunction_call.params[params].default}</span><span class="method-optional-braces">]</span>{/if}{/section}<span class="method-braces">)</span>
  		{else}
  		<span class="method-braces">)</span>
  		{/if}
  		</td></tr>
  	</table>
	</div>

	<div class="docBlock">
	
	{if $methods[methods].params}
		<div class="method-parameters">
			<h3>Parameters</h3>
			<table class="parameters">
			{section name=params loop=$methods[methods].params}
				<tr><td>
					<span class="var-type">{$methods[methods].params[params].datatype}</span>
					</td><td>
					<span class="var-name">{$methods[methods].params[params].var}</span>
          </td><td>
          {if $methods[methods].params[params].data}<span class="var-description">{$methods[methods].params[params].data}</span>{/if}
          <br>
          {if $methods[methods].ifunction_call.params[params].hasdefault} Default <span class="var-default">{$methods[methods].ifunction_call.params[params].default}</span>{/if}
				</td></tr>
			{/section}
			</table>
		</div>
	{/if}
	
	{if $methods[methods].method_overrides}
		<hr class="separator" />
		<div class="notes">Redefinition of:</div>
		<dl>
			<dt>{$methods[methods].method_overrides.link}</dt>
			{if $methods[methods].method_overrides.sdesc}
			<dd>{$methods[methods].method_overrides.sdesc}</dd>
			{/if}
		</dl>
	{/if}
	{if $methods[methods].method_implements}
		<hr class="separator" />
		<div class="notes">Implementation of:</div>
	{section name=imp loop=$methods[methods].method_implements}
		<dl>
			<dt>{$methods[methods].method_implements[imp].link}</dt>
			{if $methods[methods].method_implements[imp].sdesc}
			<dd>{$methods[methods].method_implements[imp].sdesc}</dd>
			{/if}
		</dl>
	{/section}
	{/if}
	
	{if $methods[methods].descmethod}
		<hr class="separator" />
		<div class="notes">Redefined in descendants as:</div>
		<ul class="redefinitions">
		{section name=dm loop=$methods[methods].descmethod}
			<li>
				{$methods[methods].descmethod[dm].link}
				{if $methods[methods].descmethod[dm].sdesc}
				: {$methods[methods].descmethod[dm].sdesc}
				{/if}
			</li>
		{/section}
		</ul>
	{/if}
	</div>
	
	{include file="docblock.tpl" sdesc=$methods[methods].sdesc desc=$methods[methods].desc tags=$methods[methods].tags params=$methods[methods].params function=false}
	
</div>
{/if}
{/section}
{section name=methods loop=$methods}
{if !$methods[methods].static}
<a name="method{$methods[methods].function_name}" id="{$methods[methods].function_name}" class="anchor"><!-- --></a>
<div class="{cycle values="evenrow,oddrow"}">
	
	<div class="method-header">
	  <a href="#sec-method-summary" class="upButton" title="back to the methods summary"></a>
	  <span class="lineNumber"><span>File source:</span><br>
    line {if $methods[methods].slink}{$methods[methods].slink}{else}{$methods[methods].line_number}{/if}
    </span>
  	<table>
  	  <tr><td>
  		<span class="method-result">
        {$methods[methods].function_return}</span>
  		<span class="method-title">
  			{if $methods[methods].ifunction_call.returnsref}&amp;{/if}{if $methods[methods].ifunction_call.constructor}Constructor {elseif $methods[methods].ifunction_call.destructor}Destructor {/if}{$methods[methods].function_name}
  		</span>
  		<span class="method-braces">(</span>
      </td><td>
  		{if count($methods[methods].ifunction_call.params)}
  			{section name=params loop=$methods[methods].ifunction_call.params}{if $smarty.section.params.iteration != 1},<br>{/if}{if $methods[methods].ifunction_call.params[params].hasdefault}<span class="method-optional-braces">[</span>{/if}<span class="var-type">{$methods[methods].ifunction_call.params[params].type}</span>&nbsp;<span class="var-name">{$methods[methods].ifunction_call.params[params].name}</span>{if $methods[methods].ifunction_call.params[params].hasdefault} = <span class="var-default">{$methods[methods].ifunction_call.params[params].default}</span><span class="method-optional-braces">]</span>{/if}{/section}<span class="method-braces">)</span>
  		{else}
  		<span class="method-braces">)</span>
  		{/if}
  		</td></tr>
  	</table>
	</div>
		
	<div class="docBlock">
	
	{if $methods[methods].params}
		<div class="method-parameters">
			<h3>Parameters</h3>
			<table class="parameters">
			{section name=params loop=$methods[methods].params}
				<tr><td>
					<span class="var-type">{$methods[methods].params[params].datatype}</span>
					</td><td>
					<span class="var-name">{$methods[methods].params[params].var}</span>
          </td><td>
          {if $methods[methods].params[params].data}<span class="var-description">{$methods[methods].params[params].data}</span>{/if}<br>
          {if $methods[methods].ifunction_call.params[params].hasdefault} Default <span class="var-default">{$methods[methods].ifunction_call.params[params].default}</span>{/if}
				</td></tr>
			{/section}
			</table>
		</div>
	{/if}
	
	{if $methods[methods].method_overrides}
		<hr class="separator" />
		<div class="notes">Redefinition of:</div>
		<dl>
			<dt>{$methods[methods].method_overrides.link}</dt>
			{if $methods[methods].method_overrides.sdesc}
			<dd>{$methods[methods].method_overrides.sdesc}</dd>
			{/if}
		</dl>
	{/if}
	{if $methods[methods].method_implements}
		<hr class="separator" />
		<div class="notes">Implementation of:</div>
	{section name=imp loop=$methods[methods].method_implements}
		<dl>
			<dt>{$methods[methods].method_implements[imp].link}</dt>
			{if $methods[methods].method_implements[imp].sdesc}
			<dd>{$methods[methods].method_implements[imp].sdesc}</dd>
			{/if}
		</dl>
	{/section}
	{/if}
	
	{if $methods[methods].descmethod}
		<hr class="separator" />
		<div class="notes">Redefined in descendants as:</div>
		<ul class="redefinitions">
		{section name=dm loop=$methods[methods].descmethod}
			<li>
				{$methods[methods].descmethod[dm].link}
				{if $methods[methods].descmethod[dm].sdesc}
				: {$methods[methods].descmethod[dm].sdesc}
				{/if}
			</li>
		{/section}
		</ul>
	{/if}
	</div>
	
	{include file="docblock.tpl" sdesc=$methods[methods].sdesc desc=$methods[methods].desc tags=$methods[methods].tags params=$methods[methods].params function=false}
	
</div>
{/if}
{/section}
