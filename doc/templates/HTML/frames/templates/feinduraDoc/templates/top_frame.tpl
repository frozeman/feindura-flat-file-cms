<?xml version="1.0" encoding="iso-8859-1"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<!-- template designed by Marco Von Ballmoos -->
	<title>{$title}</title>
	<link rel="stylesheet" href="{$subdir}media/reset.css" />	
	<link rel="stylesheet" href="{$subdir}media/stylesheet.css" />
  <link rel="stylesheet" href="{$subdir}media/header.css" />
	<meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
</head>
<body>
  <a href="blank.html" target="right" id="logo"></a>
					
  <div id="packages">
	{if count($packages) > 1}
	  <form>
		<select onchange="window.parent.left_bottom.location=this[selectedIndex].value">
		{section name=p loop=$packages}
			<option value="{$packages[p].link}">{$packages[p].title}</option>
		{/section}
		</select>
		</form>
	{/if}
	</div>
	
	<div id="readmechangelog">
	{if count($ric) >= 1}
		{assign var="last_ric_name" value=""}
		{section name=ric loop=$ric}
			{if $last_ric_name != ""} | {/if}
			<a href="{$ric[ric].file}" target="right">{$ric[ric].name}</a>
			{assign var="last_ric_name" value=$ric[ric].name}
		{/section}
	{/if}
	</div>
</body>
</html>
