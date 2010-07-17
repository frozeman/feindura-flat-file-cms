{include file="header.tpl" top1=true}

<!-- Start of Class Data -->
<!--<h2>
	{$smarty.capture.title}
</h2>-->
{if $interfaces}
{section name=classtrees loop=$interfaces}
<h1>Interface Hierarchy</h1>
{$interfaces[classtrees].class_tree}
{/section}
{/if}
{if $classtrees}
{section name=classtrees loop=$classtrees}
<h1>Class Hierarchy</h1>
<div class="classes">
{$classtrees[classtrees].class_tree}
</div>
{/section}
{/if}
{include file="footer.tpl"}