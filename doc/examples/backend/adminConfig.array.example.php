<?php

$adminConfig['url'] =              'http://localhost';
$adminConfig['basePath'] =         '/feinduraCMS/';
$adminConfig['realBasePath'] =     '/var/server/feinduraCMS/';
$adminConfig['websitePath'] =      '/'; // it's also possible: "/index.php"
$adminConfig['uploadPath'] =       '/feinduraCMS/upload/';
$adminConfig['websiteFilesPath'] = '';
$adminConfig['stylesheetPath'] =   '/styles/';
$adminConfig['dateFormat'] =       'YMD'; // can be "YMD", "MDY" or "DMY"
$adminConfig['speakingUrl'] =      false;

$adminConfig['varName']['page'] =     'page';
$adminConfig['varName']['category'] = 'category';
$adminConfig['varName']['modul'] =    'modul';

$adminConfig['user']['editWebsiteFiles'] = false;
$adminConfig['user']['editStyleSheets'] =  false;
$adminConfig['user']['info'] =             '';

$adminConfig['setStartPage'] =            true;
$adminConfig['pages']['createDelete'] =     true;
$adminConfig['pages']['thumbnails'] = true;
$adminConfig['pages']['plugins'] =         false;
$adminConfig['pages']['showTags'] =        false;

$adminConfig['editor']['enterMode'] =  'p';
$adminConfig['editor']['styleFile'] =  '/styles/sheet.css';
$adminConfig['editor']['styleId'] =    'contentId';
$adminConfig['editor']['styleClass'] = '';

$adminConfig['pageThumbnail']['width'] =  '115';
$adminConfig['pageThumbnail']['height'] = '';
$adminConfig['pageThumbnail']['ratio'] =  'x';
$adminConfig['pageThumbnail']['path'] =   'thumbnails/'; // relativer to the ['uploadPath']

?>