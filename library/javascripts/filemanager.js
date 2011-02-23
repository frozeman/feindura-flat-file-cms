/*
    feindura - Flat File Content Management System
    Copyright (C) Fabian Vogelsteller [frozeman.de]

    This program is free software;
    you can redistribute it and/or modify it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 3 of the License, or (at your option) any later version.

    This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY;
    without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
    See the GNU General Public License for more details.

    You should have received a copy of the GNU General Public License along with this program;
    if not,see <http://www.gnu.org/licenses/>.
*
* java/filemanager.js version 0.1 (requires mootools-core and mootools-more and MooTools-FileManager)
*/

window.addEvent('domready', function () {
    // ->> include filemanager
    var fileManager = new FileManager({
        url: 'library/processes/filemanager.process.php',
        assetBasePath: 'library/thirdparty/MooTools-FileManager/Assets',
        language: '<?= $_SESSION["language"]; ?>',
        destroy: true,
        upload: true,
        rename: true,
        createFolders: true,
        download: true,
        hideOnClick: true,
        hideOverlay: true,
        onShow: function() {
            console.log('show');
            $('dimmContainer').setStyle('opacity',0);
            $('dimmContainer').setStyle('display','block');
            $('dimmContainer').set('tween', {duration: 100, transition: Fx.Transitions.Pow.easeOut});
            $('dimmContainer').tween('opacity',0.5);
            $('dimmContainer').addEvent('click',(function(){this.hide();}).bind(this));
          },
        onHide: function() {
            console.log('hide');
            $('dimmContainer').removeEvents('click');
            $('dimmContainer').set('tween', {duration: 100, transition: Fx.Transitions.Pow.easeOut});
            $('dimmContainer').tween('opacity',0);
            $('dimmContainer').get('tween').chain(function(){
              $('dimmContainer').setStyle('display','none');
            });
          }
    });
    fileManager.filemanager.setStyle('width','75%');
    fileManager.filemanager.setStyle('height','70%');

    // -> open filemanager when button get clicked
    $$('a.fileManager').each(function(fileManagerButton){
      fileManagerButton.addEvent('click',function(e){
        e.stop();
        fileManager.show();
      });
    });
});