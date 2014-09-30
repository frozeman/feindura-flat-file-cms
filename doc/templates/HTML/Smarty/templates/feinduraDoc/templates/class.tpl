{include file="header.tpl" eltype="class" hasel=true contents=$classcontents}

<!-- SIDEBAR RIGHT -->
<div class="sidebarMenu right">  
  <div class="quickmenu">
    <div class="top"></div>
    <div class="content">
      <a href="#top" class="upButton"></a><br>
      <span class="folder-title">Quick Menu</span>
      <ul>
    	{if $children || $vars || $ivars || $methods || $imethods || $consts || $iconsts}
    		<li><a href="#sec-description">{if $is_interface}Interface{else}Class{/if} Overview</a></li>
    	{/if}
    	{if $children}
    		<li><a href="#sec-descendants">Descendants</a></li>
    	{/if}
    	{if $ivars || $imethods}
    		<li><a href="#sec-inherited">Inherited Elements</a></li>
    	{/if}
    	{if $vars || $ivars}
    		{if $vars}
    			<li><a href="#sec-var-summary">Properties</a> | <a href="#sec-vars">Descriptions</a></li>
    		{else}
    			<li><a href="#sec-vars">Properties</a></li>
    		{/if}
    	{/if}
    	{if $methods || $imethods}
    		{if $methods}
    			<li><a href="#sec-method-summary">Methods</a> | <a href="#sec-methods">Descriptions</a></li>
    		{else}
    			<li><a href="#sec-methods">Methods</a></li>
    		{/if}
    	{/if}
    	{if $consts || $iconsts}
    		{if $consts}
    			<li><a href="#sec-const-summary">Constants</a> | <a href="#sec-consts">Descriptions</a></li>
    		{else}
    			<li><a href="#sec-consts">Constants</a></li>
    		{/if}
    	{/if}
    	</ul>
  	</div>
  	<div class="bottom"></div>
	</div>
	
	{if count($contents.var) > 0}
	<div class="properties">
    <div class="top"></div>
    <div class="content">	
        <a href="#top" class="upButton"></a><br>
        <span class="folder-title">Properties</span>
  		<ul class="variables">
  		  {section name=contents loop=$contents.var}
  		  <li>{$contents.var[contents]}</li>
  		  {/section}
  		</ul>
    </div>
  	<div class="bottom"></div> 
  </div>
  {/if}
  
  {if count($contents.method) > 0}
  <div class="methods">
    <div class="top"></div>
    <div class="content">
        <a href="#top" class="upButton"></a><br>
        <span class="folder-title">Methods</span>
  		<ul class="functions">
  		  {section name=methods loop=$methods}
  		  <li><a href="#{$methods[methods].function_name}">{$methods[methods].function_name}()</a></li>
  		  {/section}
  		</ul>
		</div>
  	<div class="bottom"></div>
  </div>
  {/if}
</div>


<h2 class="class-name">{if $is_interface}Interface{else}Class{/if} {$class_name} <span class="small">File source: <a href="{$page_link}">{$source_location}</a></span></h2>


<a name="sec-description" id="sec-description" class="anchor"></a>
<div class="info-box">

	<div class="info-box-title">
  <a href="#top" class="upButton" title="Up"></a>
  {if $is_interface}Interface{else}Class{/if} Overview
  </div>
	<div class="info-box-body">
    
    <pre class="classTree">{section name=tree loop=$class_tree.classes}{$class_tree.classes[tree]}{$class_tree.distance[tree]}{/section}</pre>

		{if $conflicts.conflict_type}
			<hr class="separator" />
			<div><span class="warning">Conflicts with classes:</span><br>
			{section name=me loop=$conflicts.conflicts}
				{$conflicts.conflicts[me]}<br>
			{/section}
			</div>
		{/if}
    
    {if $implements}
    <p class="implements">
        Implements interfaces:
        <ul>
            {foreach item="int" from=$implements}<li>{$int}</li>{/foreach}
        </ul>
    </p>
    {/if}        
        
		{include file="docblock.tpl" type="class" sdesc=$sdesc desc=$desc}		

		{if $tutorial}
			<hr class="separator" />
			<div class="notes">Tutorial: <span class="tutorial">{$tutorial}</div>
		{/if}
		
		<div class="notes">
			{if $is_interface}Interface{else}Class{/if} located in <a class="field" href="{$page_link}">{$source_location}</a> [<span class="field">in line {if $class_slink}{$class_slink}{else}{$line_number}{/if}</span>]
		</div>
	</div>
</div>

{if $children}
	<a name="sec-descendants" id="sec-descendants" class="anchor"></a>
	<div class="info-box">
		<div class="info-box-title">
    <a href="#top" class="upButton" title="Up"></a>
    Descendants</div>
		<div class="info-box-body">
		  <div class="docBlock">
			<table cellpadding="2" cellspacing="0" class="class-table">
				<tr>
					<th class="class-table-header">Child Class</th>
					<th class="class-table-header">Description</th>
				</tr>
				{section name=kids loop=$children}
				<tr>
					<td style="padding-right: 2em">{$children[kids].link}</td>
					<td>
					{if $children[kids].sdesc}
						{$children[kids].sdesc}
					{else}
						{$children[kids].desc}
					{/if}
					</td>
				</tr>
				{/section}
			</table>
			</div>
		</div>
	</div>
{/if}

{if $consts}
	<a name="sec-const-summary" id="sec-const-summary" class="anchor"></a>
	<div class="info-box">
		<div class="info-box-title">
    <a href="#top" class="upButton" title="Up"></a>
    Constant Summary</div>
		<div class="info-box-body">
		  <div class="docBlock">
  			<div class="const-summary">
  			<table border="0" cellspacing="0" cellpadding="0" class="var-summary">
  			{section name=consts loop=$consts}
  				<div class="var-title">
  					<tr>
  					<td class="var-title"><a href="#{$consts[consts].const_dest}" title="details" class="const-name-summary">{$consts[consts].const_name}</a>&nbsp;&nbsp;</td>
  					<td class="const-summary-description">{$consts[consts].sdesc}</td></tr>
  				</div>
  				{/section}
  				</table>
  			</div>
			</div>
		</div>
	</div>
{/if}

{if $vars}
	<a name="sec-var-summary" id="sec-var-summary" class="anchor"></a>
	<div class="info-box">
		<div class="info-box-title">
    <a href="#top" class="upButton" title="Up"></a>
    Property Summary</div>
		<div class="info-box-body">
		  <div class="docBlock">
  			<div class="var-summary">
  			<table border="0" cellspacing="0" cellpadding="0">
  			{section name=vars loop=$vars}
  			{if $vars[vars].static}
  				<div class="var-title">
  					<tr><td>static <span class="var-type">{$vars[vars].var_type}</span>&nbsp;&nbsp;</td>
  					<td class="var-title"><a href="#{$vars[vars].var_name}" title="details" class="var-name-summary">{$vars[vars].var_name}</a>&nbsp;&nbsp;</td>
  					<td class="var-summary-description">{$vars[vars].sdesc}</td></tr>
  				</div>
  			{/if}
  			{/section}
  			{section name=vars loop=$vars}
  			{if !$vars[vars].static}
  				<div class="var-title">
  					<tr><td><span class="var-type">{$vars[vars].var_type}</span>&nbsp;&nbsp;</td>
  					<td class="var-title"><a href="#{$vars[vars].var_name}" title="details" class="var-name-summary">{$vars[vars].var_name}</a>&nbsp;&nbsp;</td>
  					<td class="var-summary-description">{$vars[vars].sdesc}</td></tr>
  				</div>
  			{/if}
  			{/section}
  				</table>
  			</div>
			</div>
		</div>
	</div>
{/if}

{if $methods}
	<a name="sec-method-summary" id="sec-method-summary" class="anchor"></a>
	<div class="info-box">
		<div class="info-box-title">
    <a href="#top" class="upButton" title="Up"></a>
    Method Summary</div>
		<div class="info-box-body">
			<div class="method-summary">
			  <div class="docBlock">
				<table border="0" cellspacing="0" cellpadding="0">
				{section name=methods loop=$methods}
				{if $methods[methods].static}
				<div class="method-definition">
					<tr><td class="method-definition">static
					{if $methods[methods].function_return}
						<span class="method-result">{$methods[methods].function_return}</span>&nbsp;&nbsp;
					{/if}</td>
					<td class="method-definition"><a href="#{$methods[methods].function_name}" title="details" class="method-name">{if $methods[methods].ifunction_call.returnsref}&amp;{/if}{$methods[methods].function_name}</a>()&nbsp;&nbsp;</td>
					<td class="method-definition">{$methods[methods].desc|truncate:120:""}</td></tr>
				</div>
				{/if}
				{/section}
				{section name=methods loop=$methods}
				{if !$methods[methods].static}
				<div class="method-definition">
					{if $methods[methods].function_return}
						<tr><td class="method-definition"><span class="method-result">{$methods[methods].function_return}</span>&nbsp;&nbsp;</td>
					{/if}
					<td class="method-definition"><a href="#{$methods[methods].function_name}" title="details" class="method-name">{if $methods[methods].ifunction_call.returnsref}&amp;{/if}{$methods[methods].function_name}</a>()&nbsp;&nbsp;</td>
					<td class="method-definition">{$methods[methods].desc|strip_tags|truncate:120:"..."}</td></tr>
				</div>
				{/if}
				{/section}
				</table>
				</div>
			</div>
		</div>
	</div>
{/if}

{if $vars || $ivars}
	<a name="sec-vars" id="sec-vars" class="anchor"></a>
	<div class="info-box">
		<div class="info-box-title">
    <a href="#top" class="upButton" title="Up"></a>
    Properties</div>
			{include file="var.tpl"}
	</div>
{/if}

{if $methods || $imethods}
	<a name="sec-methods" id="sec-methods" class="anchor"></a>
	<div class="info-box">
		<div class="info-box-title">
    <a href="#top" class="upButton" title="Up"></a>
    Methods</div>
			{include file="method.tpl"}
	</div>
{/if}

{if $consts || $consts}
	<a name="sec-consts" id="sec-consts" class="anchor"></a>
	<div class="info-box">
		<div class="info-box-title">
    <a href="#top" class="upButton" title="Up"></a>
    Constants</div>
			{include file="const.tpl"}
	</div>
{/if}

{if $ivars || $imethods || $iconsts}
    <a name="sec-inherited" id="sec-inherited" class="anchor"></a>
    <div class="info-box">
        <div class="info-box-title">
    <a href="#top" class="upButton" title="Up"></a>
    Inherited Properties, Constants, and Methods
    </div>
        <div class="info-box-body">
          <div class="docBlock">
            <table cellpadding="2" cellspacing="0" class="class-table">
                <tr>
                    <th class="class-table-header" width="30%">Inherited Properties</th>
                    <th class="class-table-header" width="40%">Inherited Methods</th>
                    <th class="class-table-header" width="30%">Inherited Constants</th>
                </tr>
                <tr>
                    <td width="30%">
                        {section name=ivars loop=$ivars}
                            <h5>Inherited From <span class="classname">{$ivars[ivars].parent_class}</span></h5>
                            <dl>
                                {section name=ivars2 loop=$ivars[ivars].ivars}
                                    <dt>
                                        <span class="method-definition">{$ivars[ivars].ivars[ivars2].link}</span>
                                    </dt>
                                    <dd>
                                        <span class="method-definition">{$ivars[ivars].ivars[ivars2].ivars_sdesc}</span>
                                    </dd>
                                {/section}
                            </dl>
                        {/section}
                    </td>
                    <td width="40%">
                        {section name=imethods loop=$imethods}
                            <h5>Inherited From <span class="classname">{$imethods[imethods].parent_class}</span></h5>
                            <dl>
                                {section name=im2 loop=$imethods[imethods].imethods}
                                    <dt>
                                        <span class="method-definition">{$imethods[imethods].imethods[im2].link}</span>
                                    </dt>
                                    <dd>
                                        <span class="method-definition">{$imethods[imethods].imethods[im2].sdesc}</span>
                                    </dd>
                                {/section}
                            </dl>
                        {/section}
                    </td>
                    <td width="30%">
                        {section name=iconsts loop=$iconsts}
                            <h5>Inherited From <span class="classname">{$iconsts[iconsts].parent_class}</span></h5>
                            <dl>
                                {section name=iconsts2 loop=$iconsts[iconsts].iconsts}
                                    <dt>
                                        <span class="method-definition">{$iconsts[iconsts].iconsts[iconsts2].link}</span>
                                    </dt>
                                    <dd>
                                        <span class="method-definition">{$iconsts[iconsts].iconsts[iconsts2].iconsts_sdesc}</span>
                                    </dd>
                                {/section}
                            </dl>
                        {/section}
                    </td>
                </tr>
            </table>
            </div>
        </div>
    </div>
{/if}

{include file="footer.tpl"}