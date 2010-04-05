/**
 * @class noe
 */
window.addEvent('domready', function()
    {
        cfe.spacer = "gfx/spacer.gif";

        var myCfe = new cfe.replace();

        // no fieldset enhancement
        myCfe.unregisterModule("fieldset");

        // add dependencies for checkbox with id 'chb23' by passing input elements
        myCfe.addDependencies($("chb23"),["chb22","chb21"]);

        // set some options for select and file modules
        myCfe.setModuleOptions("select",{
            scrolling: true,
            scollSteps: 5
        });

        myCfe.setModuleOptions("file",{
            fileIcons: true
            , trimFilePath: true
        // hides the select file button, when a file is selected
        //            , onUpdate: function(){
        //                if(this.o.value != ""){
        //                    this.a.addClass("hidden");
        //                }else{
        //                    this.a.removeClass("hidden");
        //                }
        //            }
        });

        // sets options for all checkbox modules
        //myCfe.setModuleOption("checkbox", "onActive", function(){console.log("activate",this)});
        //myCfe.setModuleOption("checkbox", "onInactive", function(){console.log("deactivate",this)});

        // initialize cfe
        myCfe.init({
            //theme: "basic", currently not supported
            scope: $('form')
        });

        // add selectAll/deselectAll functionality to links
        $('selectAll').addEvent("click", function(e){
            new Event(e).stop();
            this.selectAll($$("fieldset.chb1"));
        }.bind(myCfe));

        $('deselectAll').addEvent("click", function(e){
            new Event(e).stop();
            this.deselectAll($$("fieldset.chb1"));
        }.bind(myCfe));

         //mt 1.2 sample to tween label on hover and back onUnhover => use custom events
        $('chb1').retrieve("cfe").addEvent("mouseOver", function(){
            this.l.tween('margin-left', 10);
        });

        $('chb1').retrieve("cfe").addEvent("mouseOut", function(){
            this.l.tween('margin-left', 0);
        });

        // another example; retreive elements and tween the background color of the input replacement
        $$("fieldset.chb2").getElements("input[type=checkbox]")[0].each(function(el){

            el.retrieve("cfe").addEvent("check", function(){
                this.a.getElement("img").tween('background-color', '#477B76');
            });

            el.retrieve("cfe").addEvent("uncheck", function(){
                this.a.getElement("img").tween('background-color', '#fff');
            });
        })

        // sample for triggering disabled/enabled attribute on specific elements
        $("trigger").addEvent("click", function(e){
            e.stop();
            $("chb4").toggleDisabled();
        });

        $("trigger2").addEvent("click", function(e){
            e.stop();
            $("sel-norm3").toggleDisabled();
        });

        $("trigger3").addEvent("click", function(e){
            e.stop();
            $("sel-mult2").toggleDisabled();
        });

        $("triggertxt").addEvent("click", function(e){
            e.stop();
            $("input4").toggleDisabled();
        });

        $("triggerta").addEvent("click", function(e){
            e.stop();
            $("textarea2").toggleDisabled();
        });

        /* standalone elements */
//        var uli = new Element("ul");
//        $('standalone').adopt(uli);
//
//        var chb = new cfe.module.checkbox({
//            instanceID: 100,
//            label: "Standalone Checkbox",
//            name: "checkboxStandalone",
//            value: "standalone checkbox checked",
//            checked: true
//        });
//        var li = new Element("li").adopt(chb.getFull());
//        uli.adopt(li);
//
//        var rb1 = new cfe.module.radio({
//            instanceID: 101,
//            label: "Standalone Radio 1",
//            name: "radioStandalone[]",
//            value: "standalone radio checked",
//            checked: true
//        });
//        li = new Element("li").adopt(rb1.getFull());
//        uli.adopt(li);
//
//        var rb2 = new cfe.module.radio({
//            instanceID: 102,
//            label: "Standalone Radio 2",
//            name: "radioStandalone[]",
//            value: "standalone radio2 checked",
//            checked: true
//        });
//        li = new Element("li").adopt(rb2.getFull());
//        uli.adopt(li);
//
//        var text = new cfe.module.text({
//            instanceID: 103,
//            id: "textStandaloneD",
//            label: "Standalone Textfield",
//            name: "textStandalone",
//            value: "standalone text"
//        });
//        li = new Element("li").adopt(text.getFull());
//        uli.adopt(li);
//
//        var ta = new cfe.module.textarea({
//            instanceID: 104,
//            label: "Standalone Textarea",
//            name: "textareaStandalone",
//            value: "standalone textarea"
//        });
//        li = new Element("li").adopt(ta.getFull());
//        uli.adopt(li);
//
//        var file = new cfe.module.file({
//            instanceID: 105,
//            label: "Standalone Fileselector",
//            name: "fileStandalone",
//            fileIcons: true
//        });
//        li = new Element("li").adopt(file.getFull());
//        uli.adopt(li);

// still a few bugs to fix
//        var sel = new cfe.module.select({
//            instanceID: 106,
//            label: "Standalone Select",
//            name: "selectStandalone",
//            options: {
//                opt1: {
//                    label:"Option A"
//                },
//                opt2: {
//                    label: "Option B",
//                    selected: true
//                },
//                opt3: {
//                    label: "Option C"
//                }
//            }
//        });
//        li = new Element("li").adopt(sel.getFull());
//        uli.adopt(li);
//
//        var selm = new cfe.module.select_multiple({
//            instanceID: 107,
//            label: "Standalone Select Multipl",
//            name: "selectMultipleStandalone",
//            options: {
//                opt1: {
//                    label:"Option A",
//                    selected: true
//                },
//                opt2: {
//                    label: "Option B"
//                },
//                opt3: {
//                    label: "Option C"
//                }
//            }
//        });
//        li = new Element("li").adopt(selm.getFull());
//        uli.adopt(li);

//        var submit = new cfe.module.submit({
//            instanceID: 108,
//            name: "submitStandalone",
//            value: "submit form"
//        });
//        li = new Element("li").adopt(submit.getFull());
//        uli.adopt(li);
        

    });