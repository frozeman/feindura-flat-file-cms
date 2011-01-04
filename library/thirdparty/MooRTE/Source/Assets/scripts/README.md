#AssetLoader
Assets lazy loader.  

###Background
MooTools More includes a class call Assets.
Assets is wonderful if you need to lazy load one file.  

But it misses many essentials:

 - Multiple assets (eg. 2+ javascript files).
 - Multiple asset types (2 js, 2 css)
 - sequential or simultaneous downloads (wait till one loads before continuing).
 - per file properties and options
 - Handling for when a file is re-attached

So we decided to fill the gap with AssetLoader: the *better* Assets class.  
Syntax is the same, and it's 100% backwards compatible with Assets.  
In fact, uncomment the last line and it will replace any calls to Asset you may already have.

	var Assets = AssetLoader;

AssetLoader does NOT require Assets.js.

##Methods:
 - AssetLoader.**javascript**( files [, options] );
 - AssetLoader.**css**( files [, options] );
 - AssetLoader.**images**( files [, options] );
 - AssetLoader.**mixed**( files [, options] );


##HowTo:
Usage is the same for all methods (see [Exceptions](#Exceptions)). 
Examples and documentation mostly use .css() 
   
###Returns:
[object] Reference to downloaded files, sorted by type. eg {images: [...]}
 
###Usage:
    AssetLoader.css(files [, options]); 

**files** [mixed] - One file or an array of many files:

Each file can be either: 
 
 - [string] Path to the file, relative to the html page.
 - [object] "Properties object". As if using new Element('link', properties).
   - Along with properties, object can include Options plus a custom [onInit](#onInit) function.

**Options** [object] - Properties that should be applied to all files.

 - chain [boolean]: Wait till this file is loaded before loading the next file[true], or begin loading the next file immediately [false].
 - onComplete [function] : Function to run once all files are loaded.
 - Path [string]: Prepended to the file's path. AssetLoader.css('style.css',{path:'Assets/'}) loads 'Assets/style.css'	

			
###Examples:
1: *styleOne.css & styleTwo.css will be downloaded and attached.*

	AssetLoader.css('styleOne.css');
	AssetLoader.css({href:'styleTwo.css'});
	// or
	AssetLoader.css(['styleOne.css', {href:'styleTwo.css'}]);  
2: *The stylesheets will be loaded and given the class 'newStyles'.
When both have loaded, the page will alert 'Done!'.*
	
	AssetLoader.css(
	   ['styleOne.css', 'styleTwo.css'],
	   {'class':newStyles', onComplete: function(){ alert('Done!') }}
	);
	
3: *All but styleTwo.css will have a class 'lazy'.* 
*The paths of all files will begin with 'Assets/', eg. 'Assets/styleOne.js'* 
*myImage.jpg will not load until styleTwo.css has loaded, as styleTwo has chain:true.*

	var files = [ 
		'myScript.js',
		'styleOne.css',
		{href:'styleTwo.css', chain:true, 'class':''},
		'myImage.jpg'
	];
	var options = {
		'class':'lazy',
		path: 'Assets/'
		chain:false
	}
	AssetLoader.mixed(files, options);
	

###Custom Option: onInit
If a file is attached multiple times, it will only be included in the page once, but the onLoad will run each time.  
onInit was created to allow a function that should only be run once.

 - onLoad and onComplete will run each time a file or group of files is attached.  
 - onInit will only run the first time the page is attached.  

###Cases where the methods differ:
 - .mixed() dynamically determines the file type. 
	.css(), .javascript(), and .images() will assume the filetype as declared.
 - chain defaults to true for scripts, false for the others.
 - scripts and styles are included in the page. Images are not.

###Notes:
 - This class can replace the Asset Class that is part of MoTools More, and is 100% backwards compatible.  
   Comment out the last line: Asset = AssetLoader.  Methods can then be called as Assets.css() instead of AssetLoader.css();  
 - DO NOT add events using addEvent(), instead pass events in using the onLoad, etc.
 - If a file is passed into 'mixed' that it does not recognise, it will returned as type "failed".
 - More-Assets has an onProgress option. This is functionaly the same as using onLoad in the options. Either syntax should work.
   More-Assets has a method Assets.image() that accepts only one image. This is treaded by AssetLoader the same as AssetLoader.images(); 
 - Once the page has loaded, the array of loaded files [AssetLoader.loaded] is referenced without checking the page for changes.  
   if you attach files using another method, take care to update the object.
		eg { src:'myfile.js'
		   , onInit: function(){alert('File being included for the first time.')}
		   , onLoad: function(){alert('File included. Again!')}
		   }
		   
## Community

Issues? Ideas? Wanna Join? [We need help!]

 - The AssetLoader was created as part of [MooRTE](https://github.com/siteroller/moorte).  
 Open threads regarding the AssetLoader on the [MooRTE Google Group](http://groups.google.com/group/moorte).
 - Or email us:

        var name = "siteroller";
        var company = "gmail.com";
        var email = name + '@' + company;
        // There's gotta be a better way to keep spammers at bay, no?!