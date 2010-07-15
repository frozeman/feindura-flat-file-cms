  </div><!-- END OF CONTENT -->
</div><!-- END OF CONTAINER -->

<div id="footer">
  <div id="innerFooter">
  <span class="copyright">
    Documentation generated on {$date} by <a href="{$phpdocwebsite}">phpDocumentor {$phpdocversion}</a>
  </span>
  <hr />
  <span class="copyright">
    <span class="feindura"><em>fein</em>dura</span> - Flat File Content Management System, Copyright &copy; 2009-<?= date('Y'); ?> Fabian Vogelsteller [<a href="http://frozeman.de">frozeman.de</a>]
  </span>
  </div>
</div>

{literal}
<!-- GET SATISFACTION FEEDBACK WIDGET -->
<script type="text/javascript" charset="utf-8">
var is_ssl = ("https:" == document.location.protocol);
var asset_host = is_ssl ? "https://s3.amazonaws.com/getsatisfaction.com/" : "http://s3.amazonaws.com/getsatisfaction.com/";
document.write(unescape("%3Cscript src='" + asset_host + "javascripts/feedback-v2.js' type='text/javascript'%3E%3C/script%3E"));
</script>

<script type="text/javascript" charset="utf-8">
  var feedback_widget_options = {};

  feedback_widget_options.display = "overlay";  
  feedback_widget_options.company = "feindura";
  feedback_widget_options.placement = "right";
  feedback_widget_options.color = "#C8C8C8";
  feedback_widget_options.style = "question";

  var feedback_widget = new GSFN.feedback_widget(feedback_widget_options);
</script>
{/literal}

</body>
</html>