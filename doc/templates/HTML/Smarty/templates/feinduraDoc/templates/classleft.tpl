{foreach key=subpackage item=files from=$classleftindex}
  <ul class="classes">
	{if $subpackage != ""}{$subpackage}<br />{/if}
	{section name=files loop=$files}
	   <li>
    {if $subpackage != ""}<span style="padding-left: 1em;">{/if}
		{if $files[files].link != ''}<a href="{$files[files].link}">{/if}{$files[files].title}{if $files[files].link != ''}</a>{/if}
    {if $subpackage != ""}</span>{/if}
	   </li>
	{/section}
  </ul>
{/foreach}
