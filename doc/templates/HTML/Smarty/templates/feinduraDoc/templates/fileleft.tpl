{foreach key=subpackage item=files from=$fileleftindex}
  <ul class="files">
	{if $subpackage != ""}<br>Subpackage: <b>{$subpackage}</b><br>{/if}
	{section name=files loop=$files}
	  <li>{if $files[files].link != ''}<a href="{$files[files].link}">{/if}{$files[files].title}{if $files[files].link != ''}</a>{/if}</li>
  {/section}
  </ul>
{/foreach}
