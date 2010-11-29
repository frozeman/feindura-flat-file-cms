/*
---
script: mooml.js
version: 1.2.4
description: Mooml is a javasctript templating engine for HTML generation, powered by Mootools.
license: MIT-style
download: http://mootools.net/forge/p/mooml
source: http://github.com/eneko/mooml
htmltags: http://www.w3schools.com/html5/html5_reference.asp

authors:
- Eneko Alonso: (http://enekoalonso.com)

credits:
- Ed Spencer: Mooml is based on Ed Spencer's Jaml (http://edspencer.github.com/jaml)
- Tim Schmidt: contributed with function and number argument types
- Josh Cohen: helped with node stacks for nested templates
- Vasili Sviridov: for the mixin idea

provides:
- Mooml
- Mooml.Template
- Mooml.Templates

requires:
- core/1.2.4:Class
- core/1.2.4:Elements
- core/1.2.4:Array

...
*/

var Mooml = {

	version: '1.2.4',
	templates: {},
	engine: { callstack: [], tags: {} },

	htmlTags: [
		"a", "abbr", "address", "area", "article", "aside", "audio",
		"b", "base", "bdo", "blockquote", "body", "br", "button",
		"canvas", "caption", "cite", "col", "colgroup", "command",
		"datalist", "dd", "del", "details", "dialog", "dfn", "div", "dl", "dt",
		"em", "embed",
		"fieldset", "figure",
		"footer", "form",
		"h1", "h2", "h3", "h4", "h5", "h6", "head", "header", "hgroup", "hr", "html",
		"i", "iframe", "img", "input", "ins",
		"keygen", "kbd",
		"label", "legend", "li", "link",
		"map", "mark", "menu", "meta", "meter",
		"nav", "noscript",
		"object", "ol", "optgroup", "option", "output",
		"p", "param", "pre", "progress",
		"q",
		"rp", "rt", "ruby",
		"samp", "script", "section", "select", "small", "source", "span", "strong", "style", "sub", "sup",
		"table", "tbody", "td", "textarea", "tfoot", "th", "thead", "time", "title", "tr",
		"ul",
		"var", "video",
		// Deprecated in HTML 5
		"acronym", "applet", "basefont", "big", "center", "dir", "font", "frame", "frameset", "noframes", "s", "strike", "tt", "u", "xmp"
		// Not supported tags
		// "code"
	],

	/**
	 * Evaluates a Mooml template supporting nested templates
	 * @param {Mooml.Template} template The template function
	 * @param {Object|Array} data Optional data object or array of objects
	 */
	evaluate: function(template, data) {
		var elements = [];
		this.engine.callstack.push(template);

		if (template.prepared == false) {
			template.code = this.prepare(template.code);
			template.prepared = true;
		}
		
		console.log(data);
		
		Array.from(Array.pick(data, {})).each(function(params, index) {
			template.code(params, index);
			elements.extend(template.nodes.filter(function(node) {
				return node.getParent() === null;
			}));
			template.nodes.empty();
		});

		this.engine.callstack.pop();
		if (this.engine.callstack.length) {
			if (template.elementRefs) {
				$extend(this.engine.callstack.getLast().elementRefs, template.elementRefs);
			}
		}

		return (elements.length > 1) ? elements : elements.shift();
	},

	/**
	 * Initializes the engine generating a javascript function for every html
	 * tag that can be used on the template.
	 * Template tag functions can receive options for the element, child 
	 * elements and html code as parameters.
	 * initialize can be called by the user in case of adding additional tags.
	 */
	initEngine: function() {
		this.htmlTags.each(function(tag) {
			Mooml.engine.tags[tag] = function() {
				var template = Mooml.engine.callstack.getLast();
				var el = new Element(tag);

				for (var i=0, l=arguments.length; i<l; i++) {
					var argument = arguments[i];
					if ($type(argument) === "function") argument = argument();
					switch ($type(argument)) {
						case "array":
						case "element":
						case "collection": {
							el.adopt(argument);
							break;
						}
						case "string": {
							if (template) {
								el.getChildren().each(function(child) {
									template.nodes.erase(child);
								});
							}
							el.set('html', el.get('html') + argument);
							break;
						}
						case "number": {
							el.appendText(argument.toString());
							break;
						}
						case "object": {
							if (i === 0) {
								if (template && template.elementRefs && argument.id) {
									template.elementRefs[argument.id] = el;
								}
								el.set(argument);
							} else if ($type(argument.toElement) == "function") {
								el.adopt(argument.toElement());
							}
							break;
						}
					}
				}

				if (template) template.nodes.push(el);
				return el;
			}
		});

		window.addEvent('domready', function() {
			document.getElements('script[type=text/mooml]').each(function(template) {
				Mooml.register(template.get('name'), new Function(['data', 'index'], template.get('text')));
			});
		});
	},

	/**
	 * Prepares a template function so it can be called directly without using eval
	 * @param {Function} code The template function to prepare
	 */
	prepare: function(code) {
		var codeStr = code.toString();
		var args = codeStr.match(/\(([a-zA-Z0-9,\s]*)\)/)[1].replace(/\s/g, '').split(',');
		var body = codeStr.match(/\{([\s\S]*)\}/m)[1];
		for (var i=this.htmlTags.length; --i >= 0; ) {
			body = body.replace(new RegExp('(^|[^\\w.])(' + this.htmlTags[i] + ')([\\s]*(?=\\())', 'g'), '$1Mooml.engine.tags.$2$3')
		}
		return new Function(args, body);
	}

};

/**
 * Template class for Mooml templates
 */
Mooml.Template = new Class({
	nodes: [],

	initialize: function(name, code, options) {
		if (options && options.elementRefs && typeof(options.elementRefs) === "object") {
			this.elementRefs = options.elementRefs;
		}
		this.name = name;
		this.code = code;
		this.prepared = false;
	},

	render: function(data) {
		return Mooml.evaluate(this, data);
	}
});


/**
 * Mixin for implemenation in Mootools classes: Implements: [Mooml.Templates, Options, ...]
 */
Mooml.Templates = {
	templates: {},

	/**
	 * Registers a new template for later use or returns an existing template with that name
	 * @param {String} name The name of the template
	 * @param {Function} code The code function of the template
	 */
	registerTemplate: function(name, code, options) {
		var template = this.templates[name];
		return (template)? template : this.templates[name] = new Mooml.Template(name, code, options);
	},

	/**
	 * Evaluates a registered template or returns null if template not registered
	 * @param {String} name The name of the template to evaluate
	 * @param {Object|Array} data Optional data object or array of objects
	 */
	renderTemplate: function(name, data) {
		var template = this.templates[name];
		return (template)? template.render(data) : null;
	}

}


/**
 * Implement Mooml.Templates into Mooml and alias for backwards compatibility
 */
Object.append(Mooml, Mooml.Templates);
Mooml.register = Mooml.registerTemplate;
Mooml.render = Mooml.renderTemplate;

Mooml.initEngine();