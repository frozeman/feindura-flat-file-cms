<?php

$adminConfig['url'] =              'locaflhost';
$adminConfig['basePath'] =         '/_feindura10/';
$adminConfig['savePath'] =         '/_feindura10/_pages/';
$adminConfig['uploadPath'] =       '/_feindura10/_upload/';
$adminConfig['websitefilesPath'] = '';
$adminConfig['stylesheetPath'] =   '/_feindura.org/style/';
$adminConfig['dateFormat'] =       'int';
$adminConfig['speakingUrl'] =      false;

$adminConfig['varName']['page'] =     'page';
$adminConfig['varName']['category'] = 'category';
$adminConfig['varName']['modul'] =    'modul';

$adminConfig['user']['fileManager'] =      true;
$adminConfig['user']['editWebsiteFiles'] = true;
$adminConfig['user']['editStylesheets'] =  true;
$adminConfig['user']['info'] =             'gfdg';

$adminConfig['setStartPage'] =            true;
$adminConfig['page']['createdelete'] =    true;
$adminConfig['page']['thumbnails'] =      true;
$adminConfig['page']['plugins'] =         false;
$adminConfig['page']['showtags'] =        false;

$adminConfig['editor']['enterMode'] =  'p';
$adminConfig['editor']['styleFile'] =  '/_feindura.org/style/reset.css|/_feindura.org/style/layout.css|/_feindura.org/style/widgets.css|/_feindura.org/style/content.css|http://fonts.googleapis.com/css?family=Molengo';
$adminConfig['editor']['styleId'] =    'content';
$adminConfig['editor']['styleClass'] = '';

$adminConfig['pageThumbnail']['width'] =  '100';
$adminConfig['pageThumbnail']['height'] = '150';
$adminConfig['pageThumbnail']['ratio'] =  'x';
$adminConfig['pageThumbnail']['path'] =   'thumbnails/';

return $adminConfig;
?>