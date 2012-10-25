<!--<h1>{$maintitle}</h1>-->
<h1>Welcome to the <span class="feinduraInline">fein<em>dura</em></span> Documentation!</h1>

<div class="large">
<p>
To add <span class="feinduraInline">fein<em>dura</em></span> to your website take a look at the methods of the <a href="{$subdir}[Implementation]/Feindura.html">Feindura class</a>.

<div class="alert">Note: The <a href="{$subdir}[Implementation]/FeinduraBase.html">FeinduraBase class</a> is the basis class for the Feindura class and should not be called directly.</div>

<div class="spacer"></div>

<a href="{$subdir}download/feindura_docs.zip" class="btn"><i class="icon-arrow-down"></i> Download the Documentation</a>
</div>

<hr>

<p>
For more advanced usage of <span class="feinduraInline">fein<em>dura</em></span> you can take a look in the <a href="{$subdir}li_[Implementation]-[Backend].html">[Implementation]-[Backend]</a> package.<br>
If you want to improve feindura, you should look at the <a href="{$subdir}li_[Backend].html">[Backend]</a> and <a href="{$subdir}li_[Implementation]-[Backend].html">[Implementation]-[Backend]</a> packages.</p>

<hr>

<div class="spacer"></div>

<div id="contentPackagList" class="info-box-body" style="padding: 25px 20px; padding-top: 10px;">

{if $package == "[not_documented]"}
  {if $packageindex}
  <h5>Available Packages</h5>
  <ul class="package">
    {section name=packagelist loop=$packageindex}
      <li><a href="{$subdir}{$packageindex[packagelist].link}">{$packageindex[packagelist].title}</a></li>
    {/section}
  </ul>
  {/if}
{/if}

{if $package != "[not_documented]"}

  <br>
  <span class="package-title">Package: {$package}</span><br>
  <br>
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