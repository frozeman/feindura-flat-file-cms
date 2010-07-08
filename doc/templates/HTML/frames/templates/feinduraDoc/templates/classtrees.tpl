{include file="header.tpl" top1=true}

<!-- Start of Class Data -->
<!--<h2>
	{$smarty.capture.title}
</h2>-->
{if $interfaces}
{section name=classtrees loop=$interfaces}
<h2>Root interface {$interfaces[classtrees].class}</h2>
{$interfaces[classtrees].class_tree}
{/section}
{/if}
{if $classtrees}
{section name=classtrees loop=$classtrees}
<h2>Root class {$classtrees[classtrees].class}</h2>
<div class="classes">
{$classtrees[classtrees].class_tree}
</div>
{/section}
{/if}
{include file="footer.tpl"}