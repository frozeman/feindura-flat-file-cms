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

### WEBSITE
<http://feindura.org>

### DESCRIPTION
feindura is lightweight flat file based content management system for webdesigners, written in PHP and ideal for small and medium websites.
It's main target is to provide an easy to integrate CMS for web designers, to easily fill their web designs with a content structure.

### BACKEND
The CMS has an easy to use interface with a simple structure, which can be fast understood by the users, even with less technical understanding.

### NECESSARY KNOWLEDGE
You should have some basic knowledge in PHP so that you can implement the CMS in your website. By following the given examples it should be easy to integrate feindura in your websites.
It's basic requirements is a web server with PHP running, however for using the CMS backend its necessary to have Javascript activated.

### FEATURES
* no database required
* easy to install
* easy to setup on a server
* easy to use backend-interface through the use of mootools
* multi-language backend interface (currently english, german and french)
* website statistics
* uses CKEditor
* no templating, just create your design like you want it and say where to put what (menu, content, etc)
* set a thumbnail picture for every page
* upload images and files
* drag'n'drop for moving pages
* backup system
* plugin system (adds additional functionality to pages like contact form and image gallery)
* UTF-8 compatible

#### FUTURE FEATURES
* modul system (like search)
* addon system, build your own application running in the feindura-CMS backend
 
### REQUIREMENTS
* PHP >= 5.1 (Safe Mode OFF, when PHP user is different than the FTP user)
* apache with mod_rewrite modul if you want to have speaking URLs like: "domain.com/pages/welcome.html"

### APPROPRIATE USES  
It's not tested yet, but it should work well on websites with up to 100 vistiors per Minute.
The feinduraPages::$storedPages array can have up to 30 000 Pages if the php memory limit is 16MB (means you website can have up to 30 000 pages)
  
### INSTALLATION
Just copy the feindura folder on your webserver in a folder, like e.g. "/cms/".
Iimplement the feindura class in your websites index.php and use the feindura class methods to get your websites content from feindura.

### IMPLEMENTATION
To implement feindura in you're website copy the /cms/ folder in your website's folder and add the following lines on the beginning of your index.php,
before the header is sent, which means before any HTML tag:

    #PHP
    <?php

    include('cms/feindura.include.php');
    
    $myCms = new Feindura();
    
    ?>
    
After this you can refer to the feindura class an it's methods through the $mycms->... instance.

Read first: <http://feindura.org/?site=gettingstarted>.
Take a look at the examples here: <http://feindura.org/?site=examples>.
For details and more methods, see the feindura class - API reference <http://feindura.org/api/%5BImplementation%5D/feindura.html>.

### NOTE

#### FRONTEND EDITING
In order to enable frontend editing and be able to use Atom/RSS 2.0 feeds, you have to call the createMetaTags() method as first inside <head> tags of your website!
It will create all basic and necessary meta tags, like charset, page title, keywords, description, etc.
See http://feindura.org/api/%5BImplementation%5D/feindura.html#createMetaTags for more information.
You also have to enable frontend editing inside the admin setup > user permissions.

#### Javascript Frameworks and the Frontend Editing mode
All javascript frameworks, except Prototype, should work with the frontend editing mode.
If Prototype is detected the frontend editing will be automatically blocked .

##### MooTools
If you want to use the MooTools framework in your website and you have activated the fronend editing mode,
you should include the script at the end of your page (before the closing </body> tag) as follow.

     <script>!window.MooTools && document.write(unescape('%3Cscript src="your/path/mootools-core-1.3.1.js"%3E%3C/script%3E'))</script>
     
Otherwise you will have problems with the frontend editing.
If don't care about that, you can deactivate the frontendediting mode inside the admin setup > user permissions.