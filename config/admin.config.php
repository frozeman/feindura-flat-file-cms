<?php

$adminConfig['url'] =              'localhost';
$adminConfig['basePath'] =         '/_feindura10/';
$adminConfig['savePath'] =         '/_feindura10/_page/';
$adminConfig['uploadPath'] =       '/_feindura10/_upload/';
$adminConfig['websitefilesPath'] = '/_feindura10/addons/';
$adminConfig['stylesheetPath'] =   '/_feindura10/library/style/';
$adminConfig['dateFormat'] =       'eu';
$adminConfig['speakingUrl'] =      true;

$adminConfig['varName']['page'] =     'page';
$adminConfig['varName']['category'] = 'category';
$adminConfig['varName']['modul'] =    'modul';

$adminConfig['user']['editWebsiteFiles'] = true;
$adminConfig['user']['editStylesheets'] =  true;
$adminConfig['user']['info'] =             '';

$adminConfig['setStartPage'] =            true;
$adminConfig['page']['createPages'] =     false;
$adminConfig['page']['thumbnailUpload'] = false;
$adminConfig['page']['plugins'] =         true;
$adminConfig['page']['showtags'] =        true;

$adminConfig['editor']['enterMode'] =  'p';
$adminConfig['editor']['styleFile'] =  '/_feindura10/library/style/layout.css';
$adminConfig['editor']['styleId'] =    '';
$adminConfig['editor']['styleClass'] = '';

$adminConfig['pageThumbnail']['width'] =  '115';
$adminConfig['pageThumbnail']['height'] = '150';
$adminConfig['pageThumbnail']['ratio'] =  'x';
$adminConfig['pageThumbnail']['path'] =   'images/thumbnail/';

return $adminConfig;
?>