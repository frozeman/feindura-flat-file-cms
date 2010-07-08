{if !$index}
  <hr />
	<div class="footer" id="credit">
		Documentation generated on {$date} by <a href="{$phpdocwebsite}" target="_blank">phpDocumentor {$phpdocversion}</a>
	</div>
{/if}
	{if $top3}</div>{/if}

{literal}
<script language="JavaScript">
/* <![CDATA[ */
  // umleiten if no frames
  var targetFile = "../index.html?"+self.location;
  var togo = 'to'+'p.lo'+'cation.';
  if(!top.framesetLoaded) {
    if(document.images)
      eval(togo + 'replac'+'e(targetFile)');
    else
      eval(togo + 'hre'+'f = targetFile');
  }
/* ]]> */
</script> 
</body>
</html>
{/literal}