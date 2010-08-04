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
feindura is lightweight flat file based content management system written in PHP, ideal for small and medium websites.
It's main target is to provide an easy to integrate CMS for webdesigners who want to focus on their design rather than the backend structure.

### BACKEND
The CMS has an easy to use interface with a simple structure, even though its possible to create large content websites through the category system.

### NECESSARY KNOWLEDGE
You should have some basic knowledge in PHP so that you can impliment the CMS in your website. But by following the given examples it should easy to use feindura.
It's basic requirements for the implimentation in a website is a Apache server with PHP, however for using the CMS backend its recommend to have Javascript activated.

### FEATURES
* no database required
* easy to install
* easy to setup on a server
* easy to use backend-interface through the use of mootools
* multi-language backend interface (currently english and german)
* website statistics
* uses CKEditor
* no templating, just create your design like you want it and say where to put what (menu, content, etc)
* set a thumbnail picture for every page
* upload images and files
* drag'n'drop for moving pages

#### future features
* plugin system (like adding contactforms to a page)
* modul system (like search)
* addon system, build your own application running in the feindura-CMS backend
 
### REQUIREMENTS
* Apache Server (for .htaccess login and if desired: Speaking URLs)
* PHP >= 4.3.0 (SafeMode OFF) (PHP 5 for the FileManager)
* Javascript

### APPROPRIATE USES  
It's not tested yet, but it should work well on websites with up to 100 vistiors per Minute.
The feinduraPages::$storedPages array can have up to 30 000 Pages if the php memory limit is 16MB (means you website can have up to 30 000 pages)
  
### INSTALLATION
To implement feindura in you're website copy the /cms/ folder in your website's folder and add the following lines on the beginning of your index.php,
before the header is sent, which means before any HTML tag:

    #PHP
    <?php

    include('cms/feindura.include.php');
    
    $myCms = new feindura();
    
    ?>
    
After this you can refer to the feindura class an it's methods through the $mycms->... variable.