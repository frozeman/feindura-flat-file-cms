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
	{literal}
  <script language="JavaScript">
  /* <![CDATA[ */    
  
   var givenPackage = self.location.search.substring(1);
  
   function PreselectMyItem(itemToSelect) {
      
      if(itemToSelect == '') {
        itemToSelect = 'li_[Implementation].html';
      }
      
      // Get a reference to the drop-down
      var myDropdownList = document.formPackageSelection.packageSelection;
  
      // Loop through all the items
      for (iLoop = 0; iLoop< myDropdownList.options.length; iLoop++)
      {    
        if (myDropdownList.options[iLoop].value == itemToSelect)
        {
          // Item is found. Set its selected property, and exit the loop
          myDropdownList.options[iLoop].selected = true;
          break;
        }
      }
    }
  /* ]]> */
  </script>
  {/literal}
</head>
<body onload="PreselectMyItem(givenPackage)">

  <a href="blank.html" target="right" id="logo"></a>
					
  <div id="packages">
	{if count($packages) > 1}
	  <form id="formPackageSelection" name="formPackageSelection">
		<select id="packageSelection" name="packageSelection" onchange="window.parent.left_bottom.location=this[selectedIndex].value">
		{section name=p loop=$packages}
			<option value="{$packages[p].link}">{$packages[p].title}</option>
			<!--<a href="{$packages[p].link}" target="left_bottom">{$packages[p].title}</a><br />-->
		{/section}
		</select>
		</form>
	{/if}
	</div>
	
  <div class="menu left">
	<a href="http://feindura.org" target="_top">feindura.org</a> | 
	<a href="http://feindura.org/?site=gettingstarted" target="_top">Getting started</a> | 
	<a href="http://feindura.org/?site=examples" target="_top">Examples</a>
	</div>
	
	<div class="menu right">
	<a href="blank.html" target="right">STARTPAGE</a>
	{if count($ric) >= 1}
	   | 
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
