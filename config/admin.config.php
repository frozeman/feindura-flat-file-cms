<?php

$adminConfig['url'] =              'http://localhost';
$adminConfig['basePath'] =         '/_feindura10/';
$adminConfig['savePath'] =         '/_feindura10/_pages/';
$adminConfig['uploadPath'] =       '/_feindura10/_upload/';
$adminConfig['websitefilesPath'] = '/_feindura10/addonss/';
$adminConfig['stylesheetPath'] =   '/_feindura.org/style/';
$adminConfig['dateFormat'] =       'eu';
$adminConfig['speakingUrl'] =      false;

$adminConfig['varName']['page'] =     'page';
$adminConfig['varName']['category'] = 'category';
$adminConfig['varName']['modul'] =    'modul';

$adminConfig['user']['fileManager'] =      true;
$adminConfig['user']['editWebsiteFiles'] = true;
$adminConfig['user']['editStylesheets'] =  true;
$adminConfig['user']['info'] =             '';

$adminConfig['setStartPage'] =          true;
$adminConfig['pages']['createdelete'] = true;
$adminConfig['pages']['thumbnails'] =   true;
$adminConfig['pages']['plugins'] =      true;
$adminConfig['pages']['showtags'] =     false;

$adminConfig['editor']['enterMode'] =  'p';
$adminConfig['editor']['styleFile'] =  'a:2:{i:0;s:31:"/_feindura.org/style/layout.css";i:1;s:32:"/_feindura.org/style/content.css";}';
$adminConfig['editor']['styleId'] =    'content';
$adminConfig['editor']['styleClass'] = '';

$adminConfig['pageThumbnail']['width'] =  '100';
$adminConfig['pageThumbnail']['height'] = '150';
$adminConfig['pageThumbnail']['ratio'] =  'x';
$adminConfig['pageThumbnail']['path'] =   'thumbnails/';

return $adminConfig;
?>