<?php

$adminConfig['url'] =              'localhost';
$adminConfig['basePath'] =         '/_feindura10/';
$adminConfig['savePath'] =         '/_feindura.org/pages/';
$adminConfig['uploadPath'] =       '/_feindura.org/upload/';
$adminConfig['websitefilesPath'] = '/_feindura.org/language/';
$adminConfig['stylesheetPath'] =   '/_feindura10/library/style/';
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
$adminConfig['editor']['styleFile'] =  '/_feindura.org/style/reset.css|/_feindura.org/style/layout.css|/_feindura.org/style/widgets.css|/_feindura.org/style/content.css';
$adminConfig['editor']['styleId'] =    'content';
$adminConfig['editor']['styleClass'] = '';

$adminConfig['pageThumbnail']['width'] =  '115';
$adminConfig['pageThumbnail']['height'] = '150';
$adminConfig['pageThumbnail']['ratio'] =  'x';
$adminConfig['pageThumbnail']['path'] =   'images/thumbnail/';

return $adminConfig;
?>