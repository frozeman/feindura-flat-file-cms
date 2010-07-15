<!--<h1>{$maintitle}</h1>-->
<h1>Welcome to the feindura API reference!</h1>
<p>
This reference was generated out of the comments in the feindura code.
It should provide a sufficient description of all necessary methods and functions used by feindura.</p>
<p>
To implement feindura take a look in the <a href="li_[Implementation].html">[Implementation]</a> package, 
in there you find <b>the <i>feindura class</i> which should provide every necessary method to implement feindura in your website.</b></p>
<p>
For more advanced usage see also the <a href="li_[Implementation]-[backend].html">[Implementation]-[backend]</a> package.</p>
<p>
If you want to improve feindura, the <a href="li_[backend].html">[backend]</a> and <a href="li_[Implementation]-[backend].html">[Implementation]-[backend]</a> package 
should be interesting for you.</p>

<p>Your selected package is: <b>{$package}</b></p>
{if $compiledclassindex}
<span class="folder-title">Classes</span>
    {eval var=$compiledclassindex}
{/if}
{if $compiledfileindex}
  {eval var=$compiledfileindex}
{/if} 