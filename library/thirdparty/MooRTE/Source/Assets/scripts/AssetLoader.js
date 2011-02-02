// Lazy Loader for CSS, image and JS files. Replaces More-Asset.
var AssetLoader={options:{script:{chain:true},defaults:{chain:false,onInit:function(){},onComplete:function(){},onProgress:function(){},path:""},path:""},properties:{script:{type:"text/javascript"},link:{rel:"stylesheet",media:"screen",type:"text/css"},img:{}},load:function(a,f,b,h,k){function m(d){j.removeEvent("load");e[d].call(j,++k[0],n,g);AssetLoader.loading[g][d].each(function(i){i.call(j,k[0],n,g)});delete AssetLoader.loading[g];AssetLoader.loaded[b][g]=this;if(a.length)AssetLoader.load(a, f,b,h,k);else{e.onInit();e.onComplete()}}AssetLoader.build();if(!a.length)return alert("err: No Files Passed");var c=a.shift(),q=c.chain,g=([c.path,f.path,AssetLoader.path].pick()||"")+[c.src,c.href,c].pick();if(b=="mixed")b=AssetLoader.type(c);var e=Object.merge({events:{}},AssetLoader.options.defaults,AssetLoader.options[b]||{},f);c=Object.merge(c.big?{}:c,e);c[b=="link"?"href":"src"]=g;var p=["load","error","abort"];p.each(function(d){[d,"on"+d,"on"+d.capitalize()].some(function(i,r){var o=r?c.events: c;if(!o[i])return false;e[d]=o[i];delete o[i]})});if(!e.load)e.load=c.onProgress;Object.each(AssetLoader.options.defaults,function(d,i){delete c[i]});var l,n=++k[1];if(l=AssetLoader.loaded[b][g]){e.load.call(l,++k[0],n,g);a.length?AssetLoader.load(a,f,b,h,k):e.onComplete();h[b].push(l);return h}if(l=AssetLoader.loading[g]){Object.map(l,function(d,i){return d.push(e[i])});a.length||l.load.push(e.onComplete);return h}AssetLoader.loading[g]={load:[],abort:[],error:[]};var j=new Element(b);p.each(function(d){e[d]&& j.addEvent(d,m.pass(d))});b=="script"&&Browser.ie&&!Browser.ie9&&j.addEvent("readystatechange",function(){"loaded,complete".contains(this.readyState)&&m("load")});j.set(Object.merge(AssetLoader.properties[b],c));if(b!="img")j.inject(document.head);else Browser.ie&&j.complete&&m("load");!q&&a.length&&AssetLoader.load(a,f,b,h,k);return h},loaded:{},loading:{},build:function(){Object.each({script:"src",link:"href",img:"src"},function(a,f){AssetLoader.loaded[f]={};$$(f+"["+a+"]").each(function(b){AssetLoader.loaded[f][b.get(a)]= b})});return function(){}},type:function(a){a=a.src||a;if(a.href||/css$/i.test(a))return"link";if(/js$/i.test(a))return"script";if(/(jpg|jpeg|bmp|gif|png)$/i.test(a))return"img";return"fail"},wait:function(){me.setStyles({"background-image":curImg,"background-position":curPos})}};Object.each({javascript:"script",css:"link",image:"img",images:"img",mixed:"mixed"},function(a,f){AssetLoader[f]=function(b,h){AssetLoader.load(Array.from(b),h,a,{img:[],link:[],script:[],fail:[]},[-1,-1])}}); 
window.addEvent("domready",function(){AssetLoader.build=AssetLoader.build()});
var Asset=AssetLoader;

// window.addEvent('domready', function(){
// AssetLoader.path = 'CMS/library/thirdparty/MooRTE/Source/Assets/';
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