/*********************************************************************************************************/
/**
 * CKEditor CodeMirror plugin v0.1
 * (c) AntonGorodezkiy, http://www.nadvoe.org.ua
 * Released: On 16.06.2011
 * Download: http://code.google.com/p/lajox
 * 
 * modified by Fabian Vogelsteller.
 * works now with mootools  
 */
/*********************************************************************************************************/

CKEDITOR.plugins.add('codemirror',   
{
    init:function(editor)
	{
		var codemirror;
		
		// при смене режима
		editor.on( 'mode', function( event )
		{
			class_editor = event.editor.id;
			mode = event.editor.mode;

			// если мы сменили режим и он стал source
			// то скормить содержимое cke_source -> codemirror
			if (mode == 'source')
			{
				// приходится получать ноду, к которой будует прилеплен codemirror
				var node = $$("."+class_editor+" textarea.cke_source");
				node = node[0];
				var hlLine = false;
				
				codemirror = CodeMirror.fromTextArea(node, {
					mode: "htmlmixed",
					lineNumbers: false,
					theme: 'feindura',
					onCursorActivity: function() {
            if(hlLine)
              codemirror.setLineClass(hlLine, null);
            hlLine = codemirror.setLineClass(codemirror.getCursor().line, "CodeMirrorActiveline");
            codemirror.save();
          }
				});
			}
		});
	
	// перед сменой режима
  editor.on( 'beforeModeUnload', function( event )
  {
    class_editor = event.editor.id;
    mode = event.editor.mode;
    
    // если текущий режим source
    // то перенести содержимое source в textarea
    if (mode == 'source')
    {
      var node = $$("."+class_editor+" textarea.cke_source");
      node = node[0];
      
      codemirror.toTextArea();
    }
  });
	}
});
