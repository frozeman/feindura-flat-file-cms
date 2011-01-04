/*
---
description: Lazy Loader for CSS and JavaScript files.
copyright: December 2010 Sam Goody
license: OSL v3.0 (http://www.opensource.org/licenses/osl-3.0.php)
authors: Sam Goody <siteroller - |at| - gmail>

requires:
- core

provides: [ AssetLoader.javascript
		  , AssetLoader.css
		  , AssetLoader.images
		  , AssetLoader.mixed  
		  ,	AssetLoader.path
		  ]
...
*/

var AssetLoader  = 
	{ options: 
		{ path:     ''
		, script:   { chain: true }
		, defaults: { path: ''
					, chain: false
					, onInit: function(){}
					, onComplete: function(){}
					, onProgress: function(){}
					}
		}
	, properties:
		{ script: { type: 'text/javascript' }
		, link:   { rel: 'stylesheet'
				  , media: 'screen'
				  , type: 'text/css'
				  }
		, img:    {}
		}
	, load: function(files, options, type, obj, index){
        AssetLoader.build();
        if (!files.length) return alert('err: No Files Passed'); //false;
		
        var file = files.shift()
          , path = ([file.path, options.path, AssetLoader.path].pick() || '') + [file.src, file.href, file].pick();
		
        if (type == 'mixed') type = AssetLoader.type(file);
        var opts = Object.merge({}, AssetLoader.options.defaults, AssetLoader.options[type] || {}, options);
        file = Object.merge({events:{}}, file.big ? {} : file, opts);
        file[type == 'link' ? 'href' : 'src'] = path;
        
        // Remove defaults and events so that they are placed as properties of element.
        var event = {}
          , chain = file.chain;  
        ['load','error','abort'].each(function(prop){
           [prop, 'on'+prop, 'on'+prop.capitalize()].some(function(item,i){
              var where = i ? file.events : file;
              if (!where[item]) return false;         
              event[prop] = where[item];
              delete where[item];
           })
        });
        var loaded = event.load || file.onProgress;
        Object.each(AssetLoader.options.defaults, function(v,k){ delete file[k] });

		  var i = ++index[1]
          , exists = AssetLoader.loaded[type][path];

        if (exists){
           loaded.call(exists, ++index[0], i, path);
           files.length
              ? AssetLoader.load(files, options, type, obj, index)
              : opts.onComplete();
           obj[type].push(exists);
           return obj;
        };
        exists = AssetLoader.loading[path];
        if (exists){ 
           exists.push(loaded);
           if (!files.length) exists.push(opts.onComplete);
           return obj;
        };
        AssetLoader.loading[path] = [];

        var asset = new Element(type, Object.merge(AssetLoader.properties[type], file));
        var loadEvent = function(){
           loaded.call(asset, ++index[0], i, path);
           AssetLoader.loading[path].each(function(func){func.call(asset, index[0], i, path)});
           delete AssetLoader.loading[path];
           AssetLoader.loaded[type][path] = this;
           
           if (files.length) AssetLoader.load(files, options, type, obj, index);
           else {
              opts.onComplete();
              opts.onInit();
           }
        };
        obj[type].push(asset);
           type == 'img'
              ? asset.onload = loadEvent
              : asset.addEvent('load', loadEvent).inject(document.head);
           if (type == 'script') asset.addEvent('readystatechange', function(){
           if ('loaded,complete'.contains(this.readyState)) loadEvent();
		     // Do we need to check the this.LoadStatus property?http://www.data-tech.com/help/imactivex/imactx8~imagecontrol~readystatechange_ev.html
		  });
		
        if (!chain && files.length) AssetLoader.load(files, options, type, obj, index);
        return obj;
	  }
	, loaded: {}
	, loading: {}
	, build: function(){
        Object.each({script:'src',link:'href',img:'src'},function(path,tag){
           AssetLoader.loaded[tag] = {};
           $$(tag+'['+path+']').each(function(el){AssetLoader.loaded[tag][el.get(path)] = el});
        });
        return function(){};
     }
	, type: function(file){
        var file = file.src || file;
        if (file.href || /css$/.test(file)) return 'link';
        if (/js$/.test(file)) return 'script';
        if (/(jpg|jpeg|bmp|gif|png)$/.test(file)) return 'img';
        return 'fail';
	  }
	, wait:function(){
          me.setStyles({'background-image':curImg, 'background-position':curPos}); 
	  }
	};

Object.each({javascript:'script', css:'link', image:'img', images:'img', mixed:'mixed'}, function(val, key){
	AssetLoader[key] = function(files, options){
      AssetLoader.load(Array.from(files), options, val, {img:[],link:[],script:[],fail:[]}, [-1,-1]);
	};
});
window.addEvent('domready', function(){ AssetLoader.build = AssetLoader.build()});
var Assets = AssetLoader;
/*/
function log(){
	if (log.off) return;
	Array.clone(arguments).each(function(arg){
		if (console) console.log(arg);
	})
}
/*/
/*/
// Test:
window.addEvent('domready', function(){
AssetLoader.path = 'CMS/library/thirdparty/MooRTE/Source/Assets/';
/*/
/*/
	var mike = new AssetLoader.mixed
		//( [{src: 'scripts/StickyWinModalUI.js'}]
		( 'scripts/StickyWinModalUI.js'
		, { onComplete: function(){ console.log('done first') } }
		); 
/*/
/*/
	var mike2 = function(){
		new AssetLoader.mixed
		( ['scripts/StickyWinModalUI.js']
		, { onload: function(){log('coming along now'); log(arguments); log(this)}
		, onComplete: function(){ console.log('done later'); } }
		);
	}.delay('1000');
/*/
// })
