<?php

$adminConfig['url'] =              'localhost';
$adminConfig['basePath'] =         '/feinduraCMS/';
$adminConfig['savePath'] =         '/feinduraCMS/page/';
$adminConfig['uploadPath'] =       '/feinduraCMS/upload/';
$adminConfig['websitefilesPath'] = '';
$adminConfig['stylesheetPath'] =   '/style/';
$adminConfig['dateFormat'] =       'int'; // can be "int" or "eu"
$adminConfig['speakingUrl'] =      false;

$adminConfig['varName']['page'] =     'page';
$adminConfig['varName']['category'] = 'category';
$adminConfig['varName']['modul'] =    'modul';

$adminConfig['user']['editWebsiteFiles'] = false;
$adminConfig['user']['editStylesheets'] =  false;
$adminConfig['user']['info'] =             '';

$adminConfig['setStartPage'] =            true;
$adminConfig['page']['createdelete'] =     true;
$adminConfig['page']['thumbnails'] = true;
$adminConfig['page']['plugins'] =         false;
$adminConfig['page']['showtags'] =        false;

$adminConfig['editor']['enterMode'] =  'p';
$adminConfig['editor']['styleFile'] =  '/style/sheet.css';
$adminConfig['editor']['styleId'] =    'contentId';
$adminConfig['editor']['styleClass'] = '';

$adminConfig['pageThumbnail']['width'] =  '115';
$adminConfig['pageThumbnail']['height'] = '';
$adminConfig['pageThumbnail']['ratio'] =  'x';
$adminConfig['pageThumbnail']['path'] =   'images/thumbnail/'; // relativer to the ['uploadPath']

?>