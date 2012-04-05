<?php

$adminConfig['url'] =              'http://localhost';
$adminConfig['basePath'] =         '/feinduraCMS/'; // url path, relative to the DOCUMENT ROOT
$adminConfig['realBasePath'] =     '/feinduraCMS/'; // file path
$adminConfig['websitePath'] =      '/';
$adminConfig['uploadPath'] =       '/feinduraCMS/_upload/';
$adminConfig['websiteFilesPath'] = '/someFiles/';
$adminConfig['stylesheetPath'] =   '/css/';

$adminConfig['permissions'] =      493; // = 0755
$adminConfig['timezone'] =         'Europe/Berlin';
$adminConfig['dateFormat'] =       'DMY';
$adminConfig['speakingUrl'] =      false;

$adminConfig['varName']['page'] =     'page';
$adminConfig['varName']['category'] = 'category';
$adminConfig['varName']['modul'] =    'modul';

$adminConfig['user']['frontendEditing'] =  true;
$adminConfig['user']['fileManager'] =      true;
$adminConfig['user']['editWebsiteFiles'] = false;
$adminConfig['user']['editStyleSheets'] =  true;
$adminConfig['user']['info'] =             '';

$adminConfig['setStartPage'] =                          true;
$adminConfig['multiLanguageWebsite']['active'] =        true;
$adminConfig['multiLanguageWebsite']['languages'][] =   de;
$adminConfig['multiLanguageWebsite']['languages'][] =   en;
$adminConfig['multiLanguageWebsite']['mainLanguage'] =  de;

$adminConfig['pages']['createDelete'] = true;
$adminConfig['pages']['thumbnails'] =   true;
$adminConfig['pages']['plugins'] =      'a:4:{i:0;s:11:"contactForm";i:1;s:12:"imageGallery";i:2;s:10:"pageRating";i:3;s:9:"slideShow";}';
$adminConfig['pages']['showTags'] =     true;
$adminConfig['pages']['showPageDate'] = true;
$adminConfig['pages']['feeds'] =        true;

$adminConfig['pages']['sorting'] =      'manually';
$adminConfig['pages']['sortReverse'] =  false;

$adminConfig['editor']['htmlLawed'] =  true;
$adminConfig['editor']['safeHtml'] =   true;
$adminConfig['editor']['enterMode'] =  'p';
$adminConfig['editor']['styleFile'] =  'a:0:{}';
$adminConfig['editor']['styleId'] =    '';
$adminConfig['editor']['styleClass'] = '';

$adminConfig['pageThumbnail']['width'] =  '100';
$adminConfig['pageThumbnail']['height'] = '100';
$adminConfig['pageThumbnail']['ratio'] =  '';
$adminConfig['pageThumbnail']['path'] =   'thumbnails/'; // relative to the ['uploadPath']

return $adminConfig;
?>