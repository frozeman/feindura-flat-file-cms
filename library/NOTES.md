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

This File contains internal notes, which are helpfull when working on feindura.


### Thirdparty Fixes

***CKEditor***

ADD PLUGINS:

- codemirror
- feinduraSnippets

MODIFIED PLUGINS:

- link (don't overwrite the dialogs/link_source.js, needed when updating)
- image (replaced the Browse ['browse'] buttons: "margin-top:10px;" > "margin-top:30px;")
- flash (replaced the Browse ['info:src'] buttons: "margin-top:10px;" > "margin-top:30px;")


***MooTools***

MooTools more needs the following packages:

- Array.Extras, String.QueryString, Hash, Element.Delegation, Fx.Scroll, Fx.SmoothScroll, Drag, Drag.Move
- Events.Pseudos
- Element.Event.Pseudos, Element.Event.Pseudos.Keys
- Fx.Slide, Fx.SmoothScroll
- Elements.from, Element.Pin, Element.Measure
- Sortables
- Scroller
- Request.JSONP, Request.Queue
- Assets
- Tips