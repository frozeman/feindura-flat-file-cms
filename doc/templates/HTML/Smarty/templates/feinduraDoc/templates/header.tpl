<?xml version="1.0" encoding="UTF-8"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
     "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="content-type" content="application/xhtml+xml; charset=UTF-8" />
  <meta http-equiv="content-language" content="en" />

	<title>feindura API - {$title}</title>
		
	<link rel="shortcut icon" href="../favicon.ico" />	
	
	<link rel="stylesheet" href="{$subdir}media/reset.css" />
	<link rel="stylesheet" href="{$subdir}media/layout.css" />
	<link rel="stylesheet" href="{$subdir}media/content.css" />
	<link rel="stylesheet" href="{$subdir}media/header.css" />
	<link rel="stylesheet" href="{$subdir}media/apiStyle.css" />
	<!--[if IE 6]><link rel="stylesheet" href="{$subdir}media/ie.css" /><![endif]-->
  
  <!-- thirdparty/MooTools -->
  <script type="text/javascript" src="{$subdir}media/javascript/mootools-1.2.4-core.js"></script>
  <script type="text/javascript" src="{$subdir}media/javascript/mootools-1.2.4.4-more.js"></script>
  
  <!-- own javascripts -->
  <script type="text/javascript" src="{$subdir}media/javascript/header.js"></script>
  <script type="text/javascript" src="{$subdir}media/javascript/pageLinks.js"></script>
  <script type="text/javascript" src="{$subdir}media/javascript/menuLinks.js"></script>  
	
</head>
<body>

<div id="bgFade">
</div>

<div id="container">
 <div id="header">
    <a name="top"></a>
    <form action="../?site=search" method="post" enctype="multipart/form-data" accept-charset="ISO-8859-1, ISO-8859-2, ISO-8859-15, UTF-8" name="search" class="searchform">
      <input type="text" accesskey="S" name="searchWord" id="searchfield" title="Search..." />
      <input type="submit" style="display:none;" value="go" />
    </form>
    <a href="http://feindura.org" class="logo"></a>
    <ul id="headerMenu">
      <li><a href="../?site=overview" title="Overview" class="overview">
      <span>Overview</span>
      </a></li>
      <li><a href="../?site=download" title="Download" class="download">
      <span>Download</span>
      </a></li>      
      <li><a href="../?site=docs" title="Documentation" class="documentation active">
      <span>Documentation</span>
      </a></li>
      <li><a href="../?site=community" title="Community" class="community">
      <span>Community</span>
      </a></li>
    </ul>     
    
    <div id="navigationInfo"><a href="../?site=docs">Documentation</a> &rArr; API reference</div>
    
    <div id="subMenu">
     <a href="{$subdir}index.html">STARTPAGE</a> | 
     {if count($ric) >= 1}
    		{assign var="last_ric_name" value=""}
    		{section name=ric loop=$ric}
    			{if $last_ric_name != ""} | {/if}
    			<a href="{$ric[ric].file}">{$ric[ric].name}</a>
    			{assign var="last_ric_name" value=$ric[ric].name}
    		{/section}
    	{/if}
    </div>
  </div>
  
  <div id="content">    
    
    <div class="sidebarMenu left">
      <div class="packagesList">      
        {assign var="packagehaselements" value=false}
        {foreach from=$packageindex item=thispackage}
          {if in_array($package, $thispackage)}
            {assign var="packagehaselements" value=true}
          {/if}
        {/foreach}
        
        <span class="folder-title">Packages</span>
        
        <ul class="package">
          {section name=packagelist loop=$packageindex}
            <li><a href="{$subdir}{$packageindex[packagelist].link}">{$packageindex[packagelist].title}</a></li>
          {/section}
        </ul>
      </div>
      
      <div class="packageContent">
        <span class="package-title">Package {$package}</span>
        <br /><br /><br />
        <ul>
          <li class="elementindex"><a href="{$subdir}elementindex.html">All Elements</a></li>
          {if $packagehaselements}
           <li class="elementindex"><a href="{$subdir}elementindex_{$package}.html">Package Elements</a></li>
      		 <li class="classtrees"><a href="{$subdir}classtrees_{$package}.html">Class Hierarchy</a></li>  		   
          {/if}      
        </ul>
    		
        {if $hastodos}
          <span class="folder-title">Todo List</span>
          <ul>
          	<li class="todolist"><a href="{$subdir}{$todolink}">Todo List</a></li>
          </ul>
        {/if}
        
        {if $tutorials}
        	<span class="folder-title">Tutorials/Manuals</span>
        		{if $tutorials.pkg}
        			<strong>Package-level:</strong>
        			{section name=ext loop=$tutorials.pkg}
        				{$tutorials.pkg[ext]}
        			{/section}
        		{/if}
        		{if $tutorials.cls}
        			<strong>Class-level:</strong>
        			{section name=ext loop=$tutorials.cls}
        				{$tutorials.cls[ext]}
        			{/section}
        		{/if}
        		{if $tutorials.proc}
        			<strong>Procedural-level:</strong>
        			{section name=ext loop=$tutorials.proc}
        			 {$tutorials.proc[ext]}
        			{/section}
        		{/if}
        	<br />
          <br />    	
        {/if}
          
        {if !$noleftindex}{assign var="noleftindex" value=false}{/if}
        {if !$noleftindex}        
        
        {if $compiledinterfaceindex}
        <span class="folder-title">Interfaces</span>
            {eval var=$compiledinterfaceindex}
        {/if}
        {if $compiledclassindex}
        <span class="folder-title">Classes</span>
            {eval var=$compiledclassindex}
        {/if}
        {if $compiledfileindex}        
          {eval var=$compiledfileindex}
        {/if}
        
        {if $package == "[backend]"}
          <span class="folder-title"><a href="_library---functions---backend.functions.php.html#sec-functions">Functions</a></span>
        {/if}
                                       
        {/if}
      </div>
    </div>

{if !$hasel}{assign var="hasel" value=false}{/if}
{if $eltype == 'class' && $is_interface}{assign var="eltype" value="interface"}{/if}