<?php

$adminConfig['url'] =              'localhost';
$adminConfig['basePath'] =         '/_feindura10/';
$adminConfig['savePath'] =         '/sportivo-leipzig/pages/';
$adminConfig['uploadPath'] =       '/sportivo-leipzig/upload/';
$adminConfig['websitefilesPath'] = '';
$adminConfig['stylesheetPath'] =   '';
$adminConfig['dateFormat'] =       'eu';
$adminConfig['speakingUrl'] =      false;

$adminConfig['varName']['page'] =     'page';
$adminConfig['varName']['category'] = 'category';
$adminConfig['varName']['modul'] =    'modul';

$adminConfig['user']['fileManager'] =      true;
$adminConfig['user']['editWebsiteFiles'] = true;
$adminConfig['user']['editStylesheets'] =  true;
$adminConfig['user']['info'] =             '';

$adminConfig['setStartPage'] =            true;
$adminConfig['page']['createdelete'] =    true;
$adminConfig['page']['thumbnails'] =      false;
$adminConfig['page']['plugins'] =         true;
$adminConfig['page']['showtags'] =        true;

$adminConfig['editor']['enterMode'] =  'p';
$adminConfig['editor']['styleFile'] =  '/sportivo-leipzig/style/reset.css|/sportivo-leipzig/style/layout.css|/sportivo-leipzig/style/widgets.css|/sportivo-leipzig/style/content.css';
$adminConfig['editor']['styleId'] =    'content';
$adminConfig['editor']['styleClass'] = 'cmsHtmlFix';

$adminConfig['pageThumbnail']['width'] =  '115';
$adminConfig['pageThumbnail']['height'] = '150';
$adminConfig['pageThumbnail']['ratio'] =  'x';
$adminConfig['pageThumbnail']['path'] =   'images/thumbnail/';

return $adminConfig;
?>