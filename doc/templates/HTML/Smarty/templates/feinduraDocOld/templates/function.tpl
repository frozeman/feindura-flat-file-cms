{section name=func loop=$functions}
<a name="{$functions[func].function_dest}" id="{$functions[func].function_dest}"><!-- --></a>
<div class="{cycle values="evenrow,oddrow"}">
	
	<div class="method-header">
	  <a href="#sec-description" class="upButton" title="back to the function summary"></a>
	  <span class="lineNumber"><span>File source:</span><br>
    line {if $functions[func].slink}{$functions[func].slink}{else}{$functions[func].line_number}{/if}
    </span>
    <table>
    <tr><td>
		<span class="method-result">{$functions[func].function_return}</span>
		<span class="method-title">
			{if $functions[func].ifunction_call.returnsref}&amp;{/if}{$functions[func].function_name}
		</span>
		<span class="method-braces">(</span>
		</td><td>
		{if count($functions[func].ifunction_call.params)}
			{section name=params loop=$functions[func].ifunction_call.params}{if $smarty.section.params.iteration != 1},<br>{/if}{if $functions[func].ifunction_call.params[params].hasdefault}<span class="method-optional-braces">[</span>{/if}<span class="var-type">{$functions[func].ifunction_call.params[params].type}</span>&nbsp;<span class="var-name">{$functions[func].ifunction_call.params[params].name}</span>{if $functions[func].ifunction_call.params[params].hasdefault} = <span class="var-default">{$functions[func].ifunction_call.params[params].default|escape:"html"}</span><span class="method-optional-braces">]</span>{/if}{/section}<span class="method-braces">)</span>
		{else}
		<span class="method-braces">)</span>
		{/if}
		</td></tr>
		</table>
	</div>
  
  <div class="docBlock">
	
	{if $functions[func].params}
	  <div class="method-parameters">
  	  <h3>Parameters</h3>
  		<table class="parameters">
  		{section name=params loop=$functions[func].params}
  			<tr><td>
  				<span class="var-type">{$functions[func].params[params].datatype}</span>
  				</td><td>
  				<span class="var-name">{$functions[func].params[params].var}</span>
          </td><td>
          {if $functions[func].params[params].data}<span class="var-description">{$functions[func].params[params].data}</span>{/if}<br>
          {if $functions[func].ifunction_call.params[params].hasdefault} Default <span class="var-default">{$functions[func].ifunction_call.params[params].default}</span>{/if}
  			  </td>
        </tr>
  		{/section}
  		</table>
  	</div>
	{/if}
	
		{if $functions[func].function_conflicts.conflict_type}
		<hr class="separator" />
		<div><span class="warning">Conflicts with functions:</span><br> 
			{section name=me loop=$functions[func].function_conflicts.conflicts}
				{$functions[func].function_conflicts.conflicts[me]}<br>
			{/section}
		</div>
	{/if}
	
	</div>

	{include file="docblock.tpl" sdesc=$functions[func].sdesc desc=$functions[func].desc tags=$functions[func].tags params=$functions[func].params function=false}
	
</div>
{/section}
