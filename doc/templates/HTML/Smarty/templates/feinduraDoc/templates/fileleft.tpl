{assign var="dontWantThis" value=true}
{if $dontWantThis == true}
{foreach key=subpackage item=files from=$fileleftindex}
  <span class="folder-title">Files</span>
  <ul class="files">
	{if $subpackage != ""}<strong>{$subpackage}</strong><br>{/if}
	{section name=files loop=$files}
	  <li>{if $files[files].link != ''}<a href="{$files[files].link}">{/if}{$files[files].title}{if $files[files].link != ''}</a>{/if}</li>
  {/section}
  </ul>
{/foreach}
{/if}
