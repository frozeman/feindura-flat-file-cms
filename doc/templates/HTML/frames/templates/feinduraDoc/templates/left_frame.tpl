<?xml version="1.0" encoding="iso-8859-1"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv='Content-Type' content='text/html; charset=UTF-8'/>
  
  <!-- template designed by Marco Von Ballmoos (redesigned by Fabian Vogelsteller [frozeman.de]) -->
	<title>{$title}</title>	
	
	<link rel="stylesheet" href="{$subdir}media/reset.css" />
	<link rel="stylesheet" href="{$subdir}media/stylesheet.css" />
	<link rel="stylesheet" href="{$subdir}media/left_menu.css" />
	
	<!-- thirdparty/MooTools -->
  <script type="text/javascript" src="{$subdir}media/javascript/mootools-1.2.4-core.js"></script>
	
	<script type="text/javascript" src="{$subdir}media/javascript/linksMenu.js"></script>	
	
</head>
<body>		
<h1 class="package-title">{$package}</h1>

		<ul>		
		<li class="elementindex"><a href='{$elementindex}.html' target='right'>Index of elements</a></li>
		<li class="classtrees"><a href='{$classtreepage}.html' target='right'>Class trees</a></li>
			{if $hastodos}
				<li><a href="{$todolink}" target="right">Todo List</a></li>
			{/if}
		</ul>
	
	<dl class="tree">
		{section name=p loop=$info}
					
			{if $info[p].subpackage == ""}
				
				{if $info[p].tutorials}
					<dt class="folder-title">Tutorials/Manuals</dt>
					<dd>
					{if $info[p].tutorials.pkg}
						<dl class="tree">
						<dt class="folder-title">Package-level</dt>
						<dd>
						{section name=ext loop=$info[p].tutorials.pkg}
							{$info[p].tutorials.pkg[ext]}
						{/section}
						</dd>
						</dl>
					{/if}
					
					{if $info[p].tutorials.cls}
						<dl class="tree">
						<dt class="folder-title">Class-level</dt>
						<dd>
						{section name=ext loop=$info[p].tutorials.cls}
							{$info[p].tutorials.cls[ext]}
						{/section}
						</dd>
						</dl>
					{/if}
					
					{if $info[p].tutorials.proc}
						<dl class="tree">
						<dt class="folder-title">Function-level</dt>
						<dd>
						{section name=ext loop=$info[p].tutorials.proc}
							{$info[p].tutorials.proc[ext]}
						{/section}
						</dd>
						</dl>
					{/if}
					</dd>
				{/if}
				{if $info[p].hasinterfaces}
					<dt class="folder-title">Interfaces</dt>
					{section name=class loop=$info[p].classes}
					   {if $info[p].classes[class].is_interface}
						<dd><a href='{$info[p].classes[class].link}' target='right'>{$info[p].classes[class].title}</a></dd>
						{/if}
					{/section}
				{/if}
				{if $info[p].classes}
					<dt class="folder-title">Classes</dt>
					{section name=class loop=$info[p].classes}
					   {if $info[p].classes[class].is_class}
						<dd class="classes"><a href='{$info[p].classes[class].link}' target='right'>{$info[p].classes[class].title}</a></dd>
					   {/if}
					{/section}
				{/if}
				{if $info[p].functions}
					<dt class="folder-title">Functions</dt>
					{section name=f loop=$info[p].functions}
						<dd class="functions"><a href='{$info[p].functions[f].link}' target='right'>{$info[p].functions[f].title}</a></dd>
					{/section}
				{/if}
				{if $info[p].files}
					<dt class="folder-title">Files</dt>
					{section name=nonclass loop=$info[p].files}
						<dd class="files"><a href='{$info[p].files[nonclass].link}' target='right'>{$info[p].files[nonclass].title}</a></dd>
					{/section}
				{/if}
								
			{else}
				{if $info[p].tutorials}			
					<dt class="folder-title">Tutorials/Manuals</dt>
					<dd>
					{if $info[p].tutorials.pkg}
						<dl class="tree">
						<dt class="folder-title">Package-level</dt>
						<dd>
						{section name=ext loop=$info[p].tutorials.pkg}
							{$info[p].tutorials.pkg[ext]}
						{/section}
						</dd>
						</dl>
					{/if}
					
					{if $info[p].tutorials.cls}
						<dl class="tree">
						<dt class="folder-title">Class-level</dt>
						<dd>
						{section name=ext loop=$info[p].tutorials.cls}
							{$info[p].tutorials.cls[ext]}
						{/section}
						</dd>
						</dl>
					{/if}
					
					{if $info[p].tutorials.proc}
						<dl class="tree">
						<dt class="folder-title">Function-level</dt>
						<dd>
						{section name=ext loop=$info[p].tutorials.proc}
							{$info[p].tutorials.proc[ext]}
						{/section}
						</dd>
						</dl>
					{/if}
					</dd>
				{/if}
				
				<dt class="sub-package">{$info[p].subpackage}</dt>
				<dd>
					<dl class="tree">
						{if $info[p].subpackagetutorial}
							<div><a href="{$info.0.subpackagetutorialnoa}" target="right">{$info.0.subpackagetutorialtitle}</a></div>
						{/if}
						{if $info[p].classes}
							<dt class="folder-title">Classes</dt>
							{section name=class loop=$info[p].classes}
								<dd class="classes"><a href='{$info[p].classes[class].link}' target='right'>{$info[p].classes[class].title}</a></dd>
							{/section}
						{/if}
						{if $info[p].functions}
							<dt class="folder-title">Functions</dt>
							{section name=f loop=$info[p].functions}
								<dd class="functions"><a href='{$info[p].functions[f].link}' target='right'>{$info[p].functions[f].title}</a></dd>
							{/section}
						{/if}
						{if $info[p].files}
							<dt class="folder-title">Files</dt>
							{section name=nonclass loop=$info[p].files}
								<dd class="files"><a href='{$info[p].files[nonclass].link}' target='right'>{$info[p].files[nonclass].title}</a></dd>
							{/section}
						{/if}
					</dl>
				</dd>
								
			{/if}
			
		{/section}
	</dl>
</body>
</html>
