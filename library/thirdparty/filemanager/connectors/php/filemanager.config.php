<?php

/**
 *	Filemanager PHP connector configuration
 *
 *	filemanager.config.php
 *	config for the filemanager.php connector
 *
 *	@license	MIT License
 *	@author		Riaan Los <mail (at) riaanlos (dot) nl>
 *	@copyright	Authors
 */


/**
 *	Check if user is authorized
 *
 *	@return boolean true is access granted, false if no access
 */
function auth() {
	// You can insert your own code over here to check if the user is authorized.
	// If you use a session variable, you've got to start the session first (session_start())
	return true;
}

/**
 *	PHP date format
 *	see http://www.php.net/date for explanation
 */
date_default_timezone_set('America/New_York'); // required on OS X
$config['date'] = 'd M Y H:i';

/**
 *	Icons settings
 */
$config['icons']['path'] = 'images/fileicons/';
$config['icons']['directory'] = '_Open.png';
$config['icons']['default'] = 'default.png';

/**
 *	Upload settings
 */
$config['upload']['overwrite'] = false; // true or false; Check if filename exists. If false, index will be added
$config['upload']['size'] = false; // integer or false; maximum file size in Mb; please note that every server has got a maximum file upload size as well.
$config['upload']['imagesonly'] = false; // true or false; Only allow images (jpg, gif & png) upload?

/**
 *	Images array
 *	used to display image thumbnails
 */
$config['images'] = array('jpg','gif','png');

/**
 *	Add the server host (http://www.domain.com) as prefix to files
 */
$config['add_host'] = false;







/**
 *	not supported yet
 */
//$config['upload']['suffix'] = '_'; // string; if overwrite is false, the suffix will be added after the filename (before .ext)

?>
