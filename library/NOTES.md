feindura - Flat File Content Management System
==============================================
Copyright (C) Fabian Vogelsteller [frozeman.de]
published under the GNU General Public License version 3

This program is free software;
you can redistribute it and/or modify it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 3 of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY;
without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this program;
if not,see <http://www.gnu.org/licenses/>.
_____________________________________________

This File contains internal notes, which are helpfull when editing on feindura.


### Temporary

- deactivated the frontend editing feature. (In GeneralFunctions::hasPermissions() and userPermissions.php)


### When adding a language

If you add a language you must add the flag to the header sidebar.
Add also the localization to the backend.include.php and the editor.php page scripts (for the datepicker)


### Thirdparty Fixes


***CKEditor***

ADD PLUGINS:

- codemirror
- feinduraSnippets
- mediaembed

MODIFIED PLUGINS:

- link (don't overwrite the dialogs/link_source.js, needed when updating)
- image (replaced the Browse ['browse'] buttons: "margin-top:10px;" > "margin-top:24px;")
- flash (replaced the Browse ['info:src'] buttons: "margin-top:10px;" > "margin-top:24px;")
- magicline (replaced the '(a.rtl?"right":"left")+":17px;' -> '(a.rtl?"left":"right")+":17px;' and add this 'color:transparent;' [in the ckeditor.js])


***MooTools***

MooTools more has the following packages:

- Events.Pseudos
- Array.Extras
- Date
- String.QueryString
- Hash
- Elements.from, Element.Pin, Element.Measure, Element.Event.Pseudos, Element.Event.Pseudos.Keys
- Fx.Reveal, Fx.Scroll, Fx.Slide, Fx.SmoothScroll, Drag, Drag.Move
- Sortables
- Request.JSONP, Request.Queue
- Assets
- Scroller
- Tips
- Locale, Locale.en-US.Date, Locale.de-DE.Date, Locale.en-GB.Date, Locale.fr-FR.Date, Locale.it-IT.Date, Locale.ru-RU-unicode.Date