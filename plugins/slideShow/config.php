<?php
/**
 * @package [Plugins]
 * @subpackage slideShow
 * 
 * If the key contains certain words, it will create different inputs. The check for this keywords in case insensitive (means "path" and "Path" is the same).
 * 
 * key contains (without the ...):<br>
 * - "...Url"                        The value of this setting will be checked by {@link XssFilter::url()}<br>
 * - "...Path"                       The value of this setting will be checked by {@link XssFilter::path()}<br>
 * - "...Number"                     The value of this setting will be checked by {@link XssFilter::number()}<br>
 * - "...Text" or nothing            The value of this setting will be checked by {@link XssFilter::text()}<br>
 * - "...Selection"                  Will create a <select>. value is also the name and should be an array like: array(0 => 'value1', 1 => 'value2')
 * - "...JsFunction"                 Creates a button, which will call a javascript function with this value as name, like <a href="#" onclick="exampleFunction(); return false;">
 * - "...Hidden"                     It will create a hidden text input field, with the setting value as input value
 * - "...Script"                     It will create a <script> tag with the value as content, before the plugin settings <table> tag.
 * - "...Echo"                       It will just display this string after the last plugin setting ..</td></tr> and before the next <tr><td>... This could be used to create custom config settings in the plugin settings table.
 * - if the value is a boolean       It will create a checkbox and will check this value against {@link XssFilter::bool()}<br>
 * 
 *  
 * Example
 * <samp>
 * $pluginConfig['linkPath'] = ''; // would use the path filter
 * </samp>
 * 
 * @see XssFilter::url()
 * @see XssFilter::path()
 * @see XssFilter::number()
 * @see XssFilter::bool()
 * @see XssFilter::text()
 */ 

$pluginConfig['imagesHidden']           = '';
$pluginConfig['selectImagesJsFunction'] = 'slideShowSelectImage';
$pluginConfig['widthNumber']            = 600;
$pluginConfig['heightNumber']           = 350;
$pluginConfig['intervalNumber']         = 3;
// effects
$pluginConfig['effectSelection'][]      = 'fade';
$pluginConfig['effectSelection'][]      = 'fold';
$pluginConfig['effectSelection'][]      = 'random';
// horizontal effects
$pluginConfig['effectSelection'][]      = 'wipeDown';
$pluginConfig['effectSelection'][]      = 'wipeUp';
$pluginConfig['effectSelection'][]      = 'sliceLeftDown';
$pluginConfig['effectSelection'][]      = 'sliceLeftUp';
$pluginConfig['effectSelection'][]      = 'sliceLeftRightDown';
$pluginConfig['effectSelection'][]      = 'sliceLeftRightUp';
$pluginConfig['effectSelection'][]      = 'sliceRightDown';
$pluginConfig['effectSelection'][]      = 'sliceRightUp';
// vertical effects
$pluginConfig['effectSelection'][]      = 'wipeRight';
$pluginConfig['effectSelection'][]      = 'wipeLeft';
$pluginConfig['effectSelection'][]      = 'sliceDownLeft';
$pluginConfig['effectSelection'][]      = 'sliceDownRight';
$pluginConfig['effectSelection'][]      = 'sliceUpDownLeft';
$pluginConfig['effectSelection'][]      = 'sliceUpDownRight';
$pluginConfig['effectSelection'][]      = 'sliceUpLeft';
$pluginConfig['effectSelection'][]      = 'sliceUpRight';
// scripts
$pluginConfig['loadGalleryScript']      = ' /* <![CDATA[ */document.write(unescape(\'<script src="library/thirdparty/MooTools-FileManager/Source/Gallery.js"><\/script>\'))/* ]]> */';
$pluginConfig['selectImagesScript']     = '
 /* <![CDATA[ */
// -> open filemanager when link get clicked
function slideShowSelectImage() {
  fileManagerSlideShow.show();
}

// ->> include filemanager gallery
var hideFileManager = function(){this.hide();}
var fileManagerSlideShow = new FileManager.Gallery({
    url: "library/controllers/filemanager.controller.php",
    assetBasePath: "library/thirdparty/MooTools-FileManager/Assets",
    documentRootPath: "'.DOCUMENTROOT.'",
    language: "'.$_SESSION["feinduraSession"]["backendLanguage"].'",
    propagateData: {"'.session_name().'":"'.session_id().'"},
    filter: "image",
    deliverPathAsLegalURL: true,
    destroy: true,
    upload: true,
    move_or_copy: true,
    rename: true,
    createFolders: true,
    download: true,
    hideOnClick: true,
    hideOverlay: true,
    hideOnDelete: false,
    listPaginationSize: 100,
    onShow: function(mgr) {
        // poulate with the current gallery
        var obj;
        Function.attempt(function(){
          var gallist = $("feinduraPlugin_slideShow_config_imagesHidden").get("value");
          obj = JSON.decode(gallist);
        });
        mgr.populate(obj, false);

        window.location.hash = "#none";
        $("dimContainer").setStyle("opacity",0);
        $("dimContainer").setStyle("display","block");
        $("dimContainer").set("tween", {duration: 350, transition: Fx.Transitions.Pow.easeOut});
        $("dimContainer").fade("in");
        $("dimContainer").addEvent("click",hideFileManager.bind(this));
      },
    onHide: function() {
        $("dimContainer").removeEvent("click",hideFileManager);
        $("dimContainer").set("tween", {duration: 350, transition: Fx.Transitions.Pow.easeOut});
        $("dimContainer").fade("out");
        $("dimContainer").get("tween").chain(function() {
          $("dimContainer").setStyle("display","none");
        });
      },
    onComplete: function(serialized, files, legal_root_dir, mgr) {
        $("feinduraPlugin_slideShow_config_imagesHidden").set("value", decodeURIComponent(JSON.encode(serialized)));
      }
});
fileManagerSlideShow.filemanager.setStyle("width","75%");
fileManagerSlideShow.filemanager.setStyle("height","70%");
/* ]]> */';

return $pluginConfig;
?>