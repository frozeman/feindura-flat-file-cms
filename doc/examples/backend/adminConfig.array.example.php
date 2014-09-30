<?php

$adminConfig['url']               = 'http://localhost';
$adminConfig['basePath']          = '/_feindura/'; // url path, relative to the DOCUMENT ROOT
$adminConfig['realBasePath']      = '/_feindura/'; // real file path (mostly matches the above one)
$adminConfig['websitePath']       = '/';
$adminConfig['uploadPath']        = '/_feindura/_upload/';
$adminConfig['websiteFilesPath']  = '/_feindura/_upload/';
$adminConfig['stylesheetPath']    = '';

$adminConfig['permissions']       = 493; // = 0755
$adminConfig['timezone']          = 'Europe/Berlin';
$adminConfig['dateFormat']        = 'MDY';
$adminConfig['speakingUrl']       = false;

$adminConfig['varName']['page']      = 'page';
$adminConfig['varName']['category']  = 'category';
$adminConfig['varName']['modul']     = 'modul';

$adminConfig['cache']['active']      = true;
$adminConfig['cache']['timeout']     = 1.5;

$adminConfig['user']['frontendEditing']   = true;
$adminConfig['user']['fileManager']       = true;
$adminConfig['user']['editWebsiteFiles']  = false;
$adminConfig['user']['editStyleSheets']   = false;
$adminConfig['user']['editSnippets']      = false;
$adminConfig['user']['info']              = '';

$adminConfig['multiLanguageWebsite']['active']       = true;
$adminConfig['multiLanguageWebsite']['languages'][]    = en;
$adminConfig['multiLanguageWebsite']['languages'][]    = nl;
$adminConfig['multiLanguageWebsite']['mainLanguage']   = en;

$adminConfig['pages']['createDelete']     = true;
$adminConfig['pages']['thumbnails']       = true;
$adminConfig['pages']['showTags']         = true;
$adminConfig['pages']['showPageDate']     = true;
$adminConfig['pages']['showSubCategory']  = false;
$adminConfig['pages']['feeds']            = true;
$adminConfig['pages']['plugins']          = 'a:4:{i:0;s:11:"contactForm";i:1;s:12:"imageGallery";i:2;s:10:"pageRating";i:3;s:9:"slideShow";}';

$adminConfig['pages']['sorting']       = 'manually';
$adminConfig['pages']['sortReverse']   = false;

$adminConfig['editor']['htmlLawed']    = true;
$adminConfig['editor']['safeHtml']     = false;
$adminConfig['editor']['enterMode']    = 'p';
$adminConfig['editor']['editorStyles'] = true;
$adminConfig['editor']['snippets']     = false;
$adminConfig['editor']['styleFile']    = 'a:0:{}';
$adminConfig['editor']['styleId']      = '';
$adminConfig['editor']['styleClass']   = '';

$adminConfig['pageThumbnail']['width']   = '100';
$adminConfig['pageThumbnail']['height']  = '100';
$adminConfig['pageThumbnail']['ratio']   = '';
$adminConfig['pageThumbnail']['path']    = 'thumbnails/'; // relative to the ['uploadPath']

return $adminConfig;
?>