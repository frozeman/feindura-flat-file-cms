<?php

$categoryConfig[1]['id'] =              1;
$categoryConfig[1]['public'] =          true;
$categoryConfig[1]['isSubCategory']       = true;
$categoryConfig[1]['isSubCategoryOf']     = 'a:1:{i:3;s:1:"3";}';
$categoryConfig[1]['createDelete'] =    true;
$categoryConfig[1]['thumbnail'] =       true;
$categoryConfig[1]['plugins'] =         'N;';
$categoryConfig[1]['showTags'] =        true;
$categoryConfig[1]['showPageDate'] =    true;
$categoryConfig[1]['showSubCategory'] = true;
$categoryConfig[1]['feeds'] =           true;

$categoryConfig[1]['sorting'] =         'manually';
$categoryConfig[1]['sortReverse'] =        false;

$categoryConfig[1]['styleFile'] =       '/styles/sheet.css';
$categoryConfig[1]['styleId'] =         'contentId';
$categoryConfig[1]['styleClass'] =      'contentClass';

$categoryConfig[1]['thumbWidth'] =      '100';
$categoryConfig[1]['thumbHeight'] =     '';
$categoryConfig[1]['thumbRatio'] =      'x';

$categoryConfig[1]['localized']['de']['name'] = 'Beispiel Kategorie 1';
$categoryConfig[1]['localized']['en']['name'] = 'Example Category 1';


$categoryConfig[2]['id'] =              2;
$categoryConfig[2]['name'] =            'Example Category 2';
$categoryConfig[2]['public'] =          false;
$categoryConfig[2]['isSubCategory']       = false;
$categoryConfig[2]['isSubCategoryOf']     = 'a:0:{}';
$categoryConfig[2]['createDelete'] =    false;
$categoryConfig[2]['thumbnail'] =       false;
$categoryConfig[2]['plugins'] =         'a:1:{i:0;s:12:"imageGallery";}';
$categoryConfig[2]['showTags'] =        false;
$categoryConfig[2]['showPageDate'] =    false;
$categoryConfig[2]['showSubCategory'] = false;
$categoryConfig[2]['feeds'] =           true;

$categoryConfig[2]['sorting'] =         'manually';
$categoryConfig[2]['sortReverse'] =        false;

$categoryConfig[2]['styleFile'] =       '';
$categoryConfig[2]['styleId'] =         '';
$categoryConfig[2]['styleClass'] =      '';

$categoryConfig[2]['thumbWidth'] =      '150';
$categoryConfig[2]['thumbHeight'] =     '100';
$categoryConfig[2]['thumbRatio'] =      '';

$categoryConfig[2]['localized']['de']['name'] = 'Beispiel Kategorie 2';
$categoryConfig[2]['localized']['en']['name'] = 'Example Category 2';

...

?>