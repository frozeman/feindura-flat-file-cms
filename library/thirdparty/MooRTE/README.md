MooRTE
===========

Rich Text Editor Framework for Mootools.

Tiny, flexible, and does not use a IFrame.

[Official Group Page](http://groups.google.com/group/moorte)

![Screenshot](http://siteroller.net/projects/moorte/images/moorte_screenshot.jpg)

#### Important:
Due to a Forge issue, the last version of this project was broken.<br>
Anyone who has previously downloaded MooRTE is requested to please update.

## Dependencies:

The basic buttons (bold, italic, etc) require mootools-core.

Many other buttons buttons rely on 3rd party scripts.
[Eg. the popup in the "hyperlink" button uses StickyWin, the "Upload Button" uses FancyUpload, etc.]  
  
They require some sort of lazy loader to load in third-party scripts as needed.  
The MooRTE download comes with our AssetLoader class; an improved version of Assets.js from MooTools more.  
It also includes a compressed copy of many of the popular plugin scripts, each one copyright of their respective authors.


## How to use

### Basic usage:
	$('myElement').moorte(options);


### Alternative usage:
	// a group of elements
	$$('.myElements').moorte(options);
	// single, group, or to apply to the page.
	var myRTE = new MooRTE(options);
	
## Options
 - buttons: 'div.Toolbar':['bold','italic','underline]
    "buttons" can refer to anything in the MooRTE.Elements object.
	It will accept a JSON Object of any complexity, and is very loose in the definition.
	The Element object can be extended, see on.
 - skin: 'Word03'
    - This is a classname added to the MooRTE Element.
	- To define your own skin, modify the existing styles or add another
	- location: 'elements'
	- 'elements' - aplied above each passed in element.
	- 'inline' - Each of the passed in elements will assume an RTE when focused. The RTE will be removed when the element loses focus.
	- 'pageTop' - One RTE toolbar will be applied to the top of the page and will control all passed in elements.
	- 'PageBottom' - One RTE toolbar will be applied to the bottom of the page and will control all passed in elements.
	- 'none' - No visible toolbar will be applied, but keyboard shortcuts will still work.	
 - floating: false
	- Should the RTE be inserted into the element (affecting page layout) or should it float above it.
 - elements: 'textarea, .rte' - What elements should the RTE extend.
     - Only applicable when called with the new keyword [var mrte = new MooRTE({elements:'textarea'}) ])
	
## Community

Issues? Ideas? Wanna Join? [We need help!]

 - Open threads regarding the color picker on the [MooRTE Google Group](http://groups.google.com/group/moorte).
 - Watch the [GitHUB page](http://github.com/siteroller/moorte) for updates.
 - Leave issues on the [GitHUB Issue Tracker](http://github.com/siteroller/moorte/issues).
 - Check out the [Mootools Forge Page](http://mootools.net/forge/p/moorte).  
    - The Forge [had some issues](http://blog.siteroller.net/mootools-forge-gotchas) that have since [been fixed](http://github.com/Guille/PluginsKit/issues#issue/4).  
	Nonetheless, please do not rely on the forge page for up-to-date info.
 - Or email us:

        var name = "moorte";
        var company = "siteroller.net";
        var email = name + '@' + company;
        // There's gotta be a better way to keep spammers at bay, no?!
		
## Customization:

### Assets.path

This is NOT part of MooRTE, but rather part of the lazy loading class used for third party scripts.  
  
The easiest way to get going with MooRTE is to include AssetLoader.js (from Assets/scripts) which will lazy load third party scripts as needed.  
You must tell AssetLoader where to find these other third party scripts!

By default, it assumes a path of "Assets/scripts", RELATIVE TO THE WEB PAGE calling it.
That means:
	If the user is on a page "/public_html/mysite.com/subfolder/index.php".
	But the folder with all of the MooRTE dependencies is at "/MooRTE/Assets/scripts"
	You must set: Assets.path = "/MooRTE/Assets/scripts";

Either that, or include the path in each file or with each call, as per the directions for the AssetLoader class.

BREAKING CHANGE: Older versions had a MooRTE.Path which has been deprecated.

### MooRTE.Elements

The MooRTE.Elements object can be extended.

To create a button (some random options, all are optional)
	MooRTE.Elements.extend({
		myButton:{
			img:     'path/to/myImg.jpg', 
			onLoad:  function(){alert("button loaded")},
			onClick: function(){alert("Hello World!")}},
			source:  function(){alert("3..2...1...*boom*")}
		})
	});

If you use AssetLoader.js and your function relies on a 3rd party script, it should be included in the onLoad event as follows:  
'scripts' may be a path to one or more scripts, see the AssetLoader page for details.
	MooRTE.Elements.extend({
		myButton:{
			onLoad: function(){
				Assets(
					scripts: 'StickyWinModalUI.js',
					{onComplete: function(){ alert("done") }}
				)
			}
		}
	});
	
	
To define a custom toolbar:

+ If the toolbar must show when a button on the menu is clicked, the button should have an onClick event.
+ If the toolbar should should also show when menu button is loaded, the onLoad should reference the onClick.
+ The toolbar should be passed in as an array where the first item is 'group' and the buttons object is the second.

	var myToolbar = {Toolbar:['bold','underline','italic']};
	MooRTE.Elements.extend({
		myMenuEntry:{
			text:'edit', 
			onLoad: 'onClick',
			onClick:['group',myToolbar]
		}			
	});
	
There are many more options, see the docs on the site.	

