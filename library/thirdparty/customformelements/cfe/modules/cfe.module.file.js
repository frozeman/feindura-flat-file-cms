/**
 * @module file
 */

/**
 * replaces file upload fields
 *
 * bug:
 * update event onMouseOut triggers even if nothing changed
 * ff 3.0.7     - no pointer
 * opera        - no pointer; no focus on label if ori focussed, click event triggers twice
 * ie 8         - no focus on label if ori focussed
 * ie 7         - no focus on label if ori focussed
 *
 * @class file
 * @namespace cfe.modules
 *
 * @requires generic
 * @extends cfe.generic
 */
cfe.module.file = new Class({
    
	Extends: cfe.generic,

    /**
     * Describes the type of this element
     * @property type
     * @type string
     */
    type: "File",

    /**
     * CSS Selector to fetch "original" HTMLElements for replacement with this module
     * @property selector
     * @type string
     */
    selector: "input[type=file]",
	
    options: {
        /**
         * enables the use of fileicons through a bit of markup and css
         * @config fileIcons
         * @type boolean
         * @default true
         */
        fileIcons: true,
        /**
         * show only the filename, not the whole path
         * @config trimFilePath
         * @type boolean
         * @default true
         */
        trimFilePath: true
    },

    /**
     * retreive the filepath
     *
     * @method getFilePath
     * @return {HTMLElement}
     */
    getFilePath: function()
    {
        return this.v;
    },

    /**
     * retreive the label, the alias and the filepath
     *
     * @method getFull
     * @return {HTMLElement[label, alias, filePath]}
     */
    getFull: function()
    {
        return [this.l, this.a, this.v];
    },

    initializeAdv: function()
    {
        // fixes safari double click bug
        if(!this.o.implicitLabel && !Browser.Engine.webkit)
        {
            this.a.addEvent("click", this.clicked.bindWithEvent(this));
        }

        if(this.isDisabled()) this.a.fireEvent("disable");
    },

    build: function()
    {
        this.a.addEvent("mousemove", this.follow.bindWithEvent(this)).setStyle("overflow","hidden");
        this.o.inject(this.a);

        this.initO();

        // add filepath
        this.v = new Element("div",{
            "class": "js"+this.type+"Path"
        }).inject(this.a, 'after').addClass("hidden");
		
        if(this.options.fileIcons){
            this.fileIcon = new Element("img",{
                "src": this.options.spacer,
                "class": "fileIcon"
            }).inject(this.v);
        }
		
        this.path = new Element("span",{
            "class":"filePath"
        }).inject(this.v);
        
        this.cross = new cfe.generic().addEvent("click", this.deleteCurrentFile.bind(this)).getAlias().addClass("delete").inject(this.v);

        this.update();
    },

    /**
     * Method to programmatically create an "original" HTMLElement
     *
     * @method createOriginal
     * @return {HTMLElement} an input field of type "file"
     */
    createOriginal: function()
    {
        return new Element("input",{
            type: "file"
        });
    },

    initO: function()
    {
        this.o.addEvent("mouseout", this.update.bind(this));
        this.o.addEvent("change", this.update.bind(this));

        this.o.setStyles({
            cursor: "pointer",
            opacity: "0",
            visibility: "visible",
            height: "100%",
            width: "auto",
            position: "relative"
        });
    },
	
    follow: function(e)
    {
        var ev = new Event(e);
        this.o.setStyle("left",(ev.client.x-this.a.getLeft()-(this.o.getWidth()-30)));
		
        /* special treatment for internet explorer as the fileinput will not be cut off by overflow:hidden */
        if(Browser.Engine.trident){
            if(ev.client.x < this.a.getLeft() || ev.client.x > this.a.getLeft()+this.a.getWidth())
                this.o.setStyle("left", -999);
        }
    },
	
    update: function()
    {
        if( this.o.value != "" )
        {
            this.oldValue = this.o.getProperty("value");
            this.oldValue = this.options.trimFilePath?this.trimFilePath(this.oldValue):this.oldValue;
            this.path.set("html", this.oldValue);
			
            if(this.options.fileIcons)
            {
                var ind = this.oldValue.lastIndexOf(".");
                this.fileIcon.setProperty("class","fileIcon "+this.oldValue.substring(++ind).toLowerCase());
            }
            this.v.removeClass("hidden");
        }
        else
        {
            this.path.set("html", "");
            this.v.addClass("hidden");
        }

        this.parent();
    },
	
    deleteCurrentFile: function()
    {
        // maybe better: this.setupOriginal()
        var newFileinput = this.createOriginal();

        newFileinput.addClass(this.o.getProperty("class")).setProperties({
            name: this.o.name,
            id: this.o.id
        });
        
        newFileinput.replaces(this.o);
        this.o = newFileinput;
		
        this.initO();
		
        this.update();
    },
	
    trimFilePath: function(path)
    {
        var ind = false;
        if(!(ind = path.lastIndexOf("\\")))
            if(!(ind = path.lastIndexOf("\/")))
                ind = 0;
	
        return path.substring(++ind);
    }
});