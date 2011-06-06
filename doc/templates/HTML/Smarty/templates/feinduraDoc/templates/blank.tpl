<!--<h1>{$maintitle}</h1>-->
<h1>Welcome to the feindura API reference!</h1>

<div class="large">
<p>
To impelement <span class="feindura"><em>fein</em>dura</span> in your website you need to create an instance of the <a href="{$subdir}[Implementation]/feindura.html">feindura class</a> 
before the header of your HTML page is sent, which means before any HTML tag.<br>
Take a look in the <a href="{$subdir}[Implementation]/feindura.html#sec-method-summary">methods</a> of this class to see what you can do with <span class="feindura"><em>fein</em>dura</span>.</p>

<p><i>Note: The <a href="{$subdir}[Implementation]/feinduraBase.html">feinduraBase class</a> is the basis class for the <a href="{$subdir}[Implementation]/feindura.html">feindura class</a> and should not be called directly.</i></p>

<p>You need this reference offline? You can download the whole API reference <a href="{$subdir}download/feindura_api-reference.zip">here</a>.</p>
</div>

<hr>

<p>
For more advanced usage of <span class="feindura"><em>fein</em>dura</span> you can take a look in the <a href="{$subdir}li_[Implementation]-[backend].html">[Implementation]-[backend]</a> package.<br>
If you want to improve feindura, the <a href="{$subdir}li_[backend].html">[backend]</a> and <a href="{$subdir}li_[Implementation]-[backend].html">[Implementation]-[backend]</a> package 
should be interesting for you.</p>


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