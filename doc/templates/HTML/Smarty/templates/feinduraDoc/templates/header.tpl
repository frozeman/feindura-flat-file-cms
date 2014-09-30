<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="content-language" content="en">
    <meta name="robots" content="index,follow">

    <title>feindura Docs{if $package != "[not_documented]"} - {$title}{/if}</title>

    <link rel="icon" href="http://feindura.org/favicon.ico" type="image/x-icon">
    <link rel="shortcut icon" href="http://feindura.org/favicon.ico" type="image/x-icon">

    <link rel="stylesheet" href="{$subdir}../css/main.css">
    <link rel="stylesheet" href="{$subdir}media/sideBarMenus.css">
    <link rel="stylesheet" href="{$subdir}media/apiStyle.css">

    <!-- thirdparty/MooTools -->
    <script type="text/javascript" src="{$subdir}media/javascript/mootools-core-1.4.5.js"></script>
    <script type="text/javascript" src="{$subdir}media/javascript/mootools-more-1.4.0.1.js"></script>
    <script type="text/javascript" src="{$subdir}media/javascript/PlaceholderSupport.js"></script>
    <script type="text/javascript" src="{$subdir}media/javascript/contextualSearch-modified.js"></script> <!-- -yui-compressed.js -->

    <!-- own javascripts -->
    <script type="text/javascript" src="{$subdir}media/javascript/scripts.js"></script>

</head>
<body>

    <!-- SIDEBAR LEFT -->
    <div class="sidebarMenu left">
            <div class="packagesList">
                <div class="top"></div>
                <div class="content">
                    {assign var="packagehaselements" value=false}
                    {foreach from=$packageindex item=thispackage}
                        {if in_array($package, $thispackage)}
                            {assign var="packagehaselements" value=true}
                        {/if}
                    {/foreach}

                    <ul>
                        <li class="elementindex"><a href="{$subdir}elementindex.html">All Elements</a></li>
                    </ul>

                    {if $packageindex}
                    <span class="folder-title">Packages</span>
                    <ul class="package">
                        {section name=packagelist loop=$packageindex}
                            <li><a href="{$subdir}{$packageindex[packagelist].link}">{$packageindex[packagelist].title}</a></li>
                        {/section}
                    </ul>
                    {/if}
                </div>
             <div class="bottom"></div>
            </div>

            {if $package && $package != "[not_documented]"}
            <div class="packageContent">
                <div class="top"></div>
                <div class="content">
                    <span class="package-title">{$package}</span>
                    <br><br><br>
                    {if $packagehaselements}
                    <ul>
                         <li class="elementindex"><a href="{$subdir}elementindex_{$package}.html">Package Elements</a></li>
                         {if $package != "[backend]"}
                            <li class="classtrees"><a href="{$subdir}classtrees_{$package}.html">Class Hierarchy</a></li>
                         {/if}
                    </ul>
                    {/if}

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
                        <br>
                        <br>
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
                    {if $package == "[backend]"}
                        <br>
                        <span class="functions"><a href="{$subdir}[backend]/_library---functions---backend.functions.php.html#sec-functions">Functions</a></span>
                        <br><br>
                    {/if}
                    {if $compiledfileindex}
                    <span class="folder-title">Files</span>
                        {eval var=$compiledfileindex}
                    {/if}

                    {/if}
                </div>
                <div class="bottom"></div>
            </div>
            {/if}
    </div>

    <!-- SIDEBAR RIGHT -->
    {if $eltype != "class"}
    <div class="sidebarMenu right">
        <div class="quickmenu">
            <div class="top"></div>
            <div class="content">
                <a href="#top" class="upButton"></a><br>
                <span class="folder-title">Quick Menu</span>
                <ul>
                    <li><a href="#sec-description">Description</a></li>
                {if $classes}
                    <li><a href="#sec-classes">Classes</a></li>
                    {if $includes || $defines || $globals || $functions}|{/if}
                {/if}
                {if $includes}
                    <li><a href="#sec-includes">Includes</a></li>
                    {if $defines || $globals || $functions}|{/if}
                {/if}
                {if $defines}
                    <li><a href="#sec-constants">Constants</a></li>
                    {if $globals || $functions}|{/if}
                {/if}
                {if $globals}
                    <li><a href="#sec-variables">Variables</a></li>
                    {if $functions}|{/if}
                {/if}
                {if $functions}
                    <li><a href="#sec-functions">Functions</a></li>
                {/if}
                </ul>
            </div>
            <div class="bottom"></div>
        </div>

        {if $classes}
        <div class="classes">
         <div class="top"></div>
            <div class="content">
                <a href="#top" class="upButton"></a><br>
                <span class="folder-title">Classes</span>
                <ul class="classes">
                    {section name=classes loop=$classes}
                    <li>{$classes[classes].link}</li>
                    {/section}
                </ul>
             </div>
            <div class="bottom"></div>
        </div>
        {/if}

        {if count($defines) > 0}
        <div class="constants">
         <div class="top"></div>
            <div class="content">
                <a href="#top" class="upButton"></a><br>
                <span class="folder-title">Constants</span>
                <ul class="variables">
                    {section name=def loop=$defines}
                    <li><a href="#{$globals[glob].global_link}">{$defines[def].global_name}</a></li>
                    {/section}
                </ul>
            </div>
            <div class="bottom"></div>
        </div>
        {/if}

        {if count($globals) > 0}
        <div class="variables">
         <div class="top"></div>
            <div class="content">
                <a href="#top" class="upButton"></a><br>
                <span class="folder-title">Variables</span>
                <ul class="variables">
                    {section name=glob loop=$globals}
                    <li><a href="#{$globals[glob].include_file}">{$globals[glob].define_name}</a></li>
                    {/section}
                </ul>
            </div>
            <div class="bottom"></div>
        </div>
        {/if}

        {if $functions}
        <div class="functions">
            <div class="top"></div>
            <div class="content">
                <a href="#top" class="upButton"></a><br>
                <span class="folder-title">Functions</span>
                <ul class="functions">
                    {section name=func loop=$functions}
                    <li><a href="#{$functions[func].function_dest}">{$functions[func].function_name}()</a></li>
                    {/section}
                </ul>
            </div>
            <div class="bottom"></div>
        </div>
        {/if}

        {if $includes}
        <div class="includes">
            <div class="top"></div>
            <div class="content">
                <a href="#top" class="upButton"></a><br>
                <span class="folder-title">Includes</span>
                <ul>
                    {section name=includes loop=$includes}
                    <li><a href="#{$includes[includes].include_file}">{$includes[includes].include_name}</a></li>
                    {/section}
                </ul>
            </div>
            <div class="bottom"></div>
        </div>
        {/if}
    </div>
    {/if}


    <header class="main">
        <a name="top"></a>
        <div class="container">
            <a href="http://feindura.org" class="logo"><h1>feindura - Docs</h1></a>
            <form action="?site=search" method="get" enctype="multipart/form-data" accept-charset="ISO-8859-1, ISO-8859-2, ISO-8859-15, UTF-8" class="searchform">
                    <div role="search">
                            <input type="search" accesskey="S" name="search" class="searchField" placeholder="search.." id="searchInput">
                            <input type="submit" style="display:none;" value="go">
                    </div>
            </form>
            <nav role="main">
                <ul>
                    <li><a href="http://feindura.org"><i class="icon-arrow-left icon-white"></i>Back to feindura.org</a></li>
                    <li><a href="{$subdir}index.html"><i class="icon-home icon-white"></i>Startpage</a></li>
                    <li><a href="{$subdir}[Implementation]/Feindura.html"><i class="icon-book icon-white"></i>Feindura Class</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <div class="subHeader">
        <div class="container">
            <div class="breadCrumbsNavigation">
                <a href="http://feindura.org">Welcome</a>
                <div class="separator"></div>
                <a href="../{$subdir}index.php?page=16">Documentation</a>
            </div>
            <div class="subMenu">
            {if count($ric) >= 1}
                {assign var="last_ric_name" value=""}
                {section name=ric loop=$ric}
                    {if $last_ric_name != ""} | {/if}
                    <a href="{$subdir}{$ric[ric].file}">{$ric[ric].name}</a>
                    {assign var="last_ric_name" value=$ric[ric].name}
                {/section}
            {/if}
            </div>
        </div>
    </div>


    <div class="container mainContent">

    {if !$hasel}{assign var="hasel" value=false}{/if}
    {if $eltype == 'class' && $is_interface}{assign var="eltype" value="interface"}{/if}