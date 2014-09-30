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

### AUTHOR
Fabian Vogelsteller <http://frozeman.de>

### STAY IN TOUCH
<http://feindura.org>
<http://twitter.com/feindura>
<http://facebook.com/feindura.cms>


### DESCRIPTION
feindura is lightweight flat file based content management system for webdesigners, written in PHP and ideal for small and medium websites. And it's just beautiful.

### BACKEND
The CMS has an easy to use interface with a simple structure, which can be fast understood by the users, even with less technical understanding.

### NECESSARY KNOWLEDGE FOR THE IMPLEMENTATION
HTML/CSS and a little bit of PHP

### FEATURES
for a full list see: <http://feindura.org/page/features/>
* no database required
* easy to use backend-interface through the use of mootools
* multi-language backend interface (currently english, german, french, italian and russian)
* website statistics
* uses CKEditor
* no templating, just create your design like you want it and say where to put what (menu, content, etc)
* upload images and files
* backup system
* plugin system (adds additional functionality to pages like contact form and image gallery)
* add-on system
* HTML5 ready

#### FUTURE FEATURES
* modul system (like search)

### REQUIREMENTS
* PHP >= 5.1 (PHP as FastCGI)
* apache with mod_rewrite modul if you want to have Pretty URLs like: "domain.com/page/welcome"

### APPROPRIATE USES
It's not tested yet, but it should work well on websites with up to 100 vistiors per Minute.
Your pages should not exceed more than 2000 pages, because then the flat file system becomes slow.

### INSTALLATION
Just copy the feindura folder on your webserver in a folder, like e.g. "/cms/".
Impelement the feindura class in your websites index.php and use the feindura class methods to get your websites content from feindura.

### IMPLEMENTATION
To implement feindura in you're website copy the /cms/ folder in your website's folder and add the following lines on the beginning of your index.php,
before the header is sent, which means before any HTML tag:

    #PHP
    <?php
    
    include('cms/feindura.include.php');
    
    $feindura = new Feindura();
    
    ?>

After this you can refer to the feindura class an it's methods through the $feindura->... instance.

Read <http://feindura.org/page/getting-started/>.
For details and more methods, see the feindura class - documentation <http://feindura.org/docs/[Implementation]/Feindura.html>.

### NOTE

#### Javascript Frameworks
All javascript frameworks, except Prototype, should work with the frontend editing mode.
If Prototype is detected the frontend editing will be automatically blocked .

##### MooTools
If you want to use the MooTools framework in your website and you have activated the fronend editing mode,
you should include the script at the end of your page (before the closing </body> tag) as follow.

    <script>window.MooTools || document.write(unescape('<script src="//ajax.googleapis.com/ajax/libs/mootools/1.4.5/mootools-yui-compressed.js"><\/script>'))</script>