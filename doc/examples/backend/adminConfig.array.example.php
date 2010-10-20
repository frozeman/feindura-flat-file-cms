<?php

$adminConfig['url'] =              'http://localhost';
$adminConfig['basePath'] =         '/feinduraCMS/';
$adminConfig['savePath'] =         '/feinduraCMS/page/';
$adminConfig['uploadPath'] =       '/feinduraCMS/upload/';
$adminConfig['websitefilesPath'] = '';
$adminConfig['stylesheetPath'] =   '/styles/';
$adminConfig['dateFormat'] =       'int'; // can be "int" or "eu"
$adminConfig['speakingUrl'] =      false;

$adminConfig['varName']['page'] =     'page';
$adminConfig['varName']['category'] = 'category';
$adminConfig['varName']['modul'] =    'modul';

$adminConfig['user']['editWebsiteFiles'] = false;
$adminConfig['user']['editStylesheets'] =  false;
$adminConfig['user']['info'] =             '';

$adminConfig['setStartPage'] =            true;
$adminConfig['pages']['createdelete'] =     true;
$adminConfig['pages']['thumbnails'] = true;
$adminConfig['pages']['plugins'] =         false;
$adminConfig['pages']['showtags'] =        false;

$adminConfig['editor']['enterMode'] =  'p';
$adminConfig['editor']['styleFile'] =  '/styles/sheet.css';
$adminConfig['editor']['styleId'] =    'contentId';
$adminConfig['editor']['styleClass'] = '';

$adminConfig['pageThumbnail']['width'] =  '115';
$adminConfig['pageThumbnail']['height'] = '';
$adminConfig['pageThumbnail']['ratio'] =  'x';
$adminConfig['pageThumbnail']['path'] =   'thumbnails/'; // relativer to the ['uploadPath']

?>