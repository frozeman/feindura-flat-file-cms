<?php
/*
 * feindura - Flat File Content Management System
 * Copyright (C) Fabian Vogelsteller [frozeman.de]
 *
 * This program is free software;
 * you can redistribute it and/or modify it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY;
 * without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 * See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along with this program;
 * if not,see <http://www.gnu.org/licenses/>.
 */
/**
 * GERMAN (DE) language-file for the feindura CMS (BACKEND)
 * 
 * IMPORTANT:<br>
 * if you want to write html-code in the toolTip texts (mostly they end with ".._tip" or ".._inputTip")
 * use only "[" and "]" instead of "<" and ">" for the HTML-tags and use no " this would end the title="" tag where the toolTip text is in.
 * 
 * 
 * NEEDS a RETURN $langFile; at the END
 */


/* ----------------------------------------------------------------------------------------------
* --- GENERAL
*/

// ---------- thumbnail
$langFile['thumbSize_unit'] = 'Pixel';

$langFile['thumbnail_name'] = 'Seiten-Thumbnail';
$langFile['thumbnail_name_width'] = 'Standard <b>Breite</b>';
$langFile['thumbnail_name_height'] = 'Standard <b>H&ouml;he</b>';

$langFile['thumbnail_tip'] = 'M&ouml;glicherweise ist nach dem Upload noch das vorherige Bild zu sehen, dies ist bedingt durch den Browser-Cache.[br /][br /]Um das aktuelle Bild zu sehen musst du die Seite aktualisieren (F5).';

$langFile['thumbnail_width_tip'] = 'Standardbreite::Die Breite des Thumbnails in Pixeln.[br /][br /]Das Bild wird beim hochladen auf die angegebene Gr&ouml;&szlig;e skaliert.';
$langFile['thumbnail_height_tip'] = 'Standardh&ouml;he::Die H&ouml;he des Thumbnails in Pixeln.[br /][br /]Das Bild wird beim hochladen auf die angegebene Gr&ouml;&szlig;e skaliert.';

$langFile['thumbnail_ratio_name'] = 'Seitenverh&auml;ltnis';
$langFile['thumbnail_ratio_fieldText'] = 'Seitenverh&auml;ltnis beibehalten';
$langFile['thumbnail_ratio_noRatio'] = 'festes Seitenverh&auml;ltnis';
$langFile['thumbnail_ratio_noRatio_tip'] = 'H&ouml;he und Breite ist fest einstellbar.';
$langFile['thumbnail_ratio_x_tip'] = 'Wird an der [b]Breite[/b] ausgerichtet.';
$langFile['thumbnail_ratio_y_tip'] = 'Wird an der [b]H&ouml;he[/b] ausgerichtet.';

// ---------- stylesheet
$langFile['stylesheet_name_styleFile'] = 'Stylesheet-Datei';
$langFile['stylesheet_name_styleId'] = 'Stylesheet-Id';
$langFile['stylesheet_name_styleClass'] = 'Stylesheet-Klasse';

$langFile['stylesheet_styleFile_tip'] = 'Hier kann eine Stylesheet-Datei angegeben werden, die im HTML-Editor verwendet wird um den Inhalt darzustellen.';
$langFile['stylesheet_styleId_tip'] = 'Hier kann eine Stylesheet-Id angegeben werden, die im HTML-Editor verwendet wird um den Inhalt darzustellen.';
$langFile['stylesheet_styleClass_tip'] = 'Hier kann eine Stylesheet-Klasse angegeben werden, die im HTML-Editor verwendet wird um den Inhalt darzustellen.';

$langFile['stylesheet_styleFile_example'] = '<b>Beispiel</b> "/style/layout.css"';

// ---------- paths

$langFile['path_absolutepath'] = 'Absoluter Pfad';
$langFile['path_relativepath'] = 'Relativer Pfad';
$langFile['path_absolutepath_tip'] = 'Absoluter Pfad::Beginnt mit einem "/"';
$langFile['path_relativepath_tip'] = 'Relativer Pfad::Beginnt ohne "/"';

// ---------- STATISTIC

$langFile['home_browser_h1'] = 'Browserverteilung der Besucher';
$langFile['log_spiderCount'] = 'Spider';
$langFile['log_spiderCount_tip'] = 'Spider::Oder auch Webcrawler genannt sind Computer-programme von Suchmaschienen, die Seiten analysieren und indizieren.';

$langFile['log_searchwordtothissite_part1'] = 'hat'; // "wort" hat 20 mal auf diese Seite gef&uuml;hrt
$langFile['log_searchwordtothissite_part2'] = 'mal auf diese Seite gef&uuml;hrt';
$langFile['log_searchwordtothissite_tip'] = 'Anklicken um dieses Suchwort in allen Seiten zu suchen.';

$langFile['log_visitCount'] = 'Besucher';
$langFile['log_visitTime_max'] = 'l&auml;ngste Verweildauer';
$langFile['log_visitTime_min'] = 'k&uuml;rzeste Verweildauer';
$langFile['log_firstVisit'] = 'seit dem';
$langFile['log_lastVisit'] = 'letzter Besuch';
$langFile['log_novisit'] = 'Es hat noch niemand diese Seite besucht.';
$langFile['log_tags_description'] = 'Suchworte die von
<a href="http://www.google.de">Google</a>,
<a href="http://www.yahoo.de">Yahoo</a> oder
<a href="http://www.bing.com">Bing (MSN)</a> auf diese Seite gef&uuml;hrt haben';
$langFile['log_notags'] = 'Es haben noch keine Suchworte auf diese Seite gef&uuml;hrt.';

$langFile['log_hour_single'] = 'Stunde';
$langFile['log_hour_multiple'] = 'Stunden';
$langFile['log_minute_single'] = 'Minute';
$langFile['log_minute_multiple'] = 'Minuten';
$langFile['log_second_single'] = 'Sekunde';
$langFile['log_second_multiple'] = 'Sekunden';

$langFile['log_browser_others'] = 'Sonstige';

/* ----------------------------------------------------------------------------------------------
* ---------- LOG TEXTs
*/

$langFile['log_page_saved'] = 'Seite gespeichert';
$langFile['log_page_new'] = 'Neue Seite erstellt';
$langFile['log_page_delete'] = 'Seite gel&ouml;scht';

$langFile['log_listPages_moved'] = 'Seite in Kategorie verschoben';
$langFile['log_listPages_moved_in'] = 'in'; // Example Page in Category
$langFile['log_listPages_sorted'] = 'Seite neu sortiert';

$langFile['log_pageThumbnail_upload'] = 'Neues Thumbnail hochgeladen';
$langFile['log_pageThumbnail_delete'] = 'Thumbnail gel&ouml;scht';

$langFile['log_userSetup_useradd'] = 'Neuen Benutzer angelegt';

$langFile['log_adminSetup_saved'] = 'Administrator-Einstellungen gespeichert';
$langFile['log_adminSetup_ckstyles'] = '"Stil-Auswahl" des HTML-Editors gespeichert';

$langFile['log_websiteSetup_saved'] = 'Webseiten-Einstellungen gespeichert';

$langFile['log_statisticSetup_saved'] = 'Statistik-Einstellungen gespeichert';
$langFile['log_clearStatistic_websiteStatistic'] = 'Webseiten-Statistik gel&ouml;scht';
$langFile['log_clearStatistic_pagesStatistics'] = 'Seiten-Statistiken gel&ouml;scht';
$langFile['log_clearStatistic_refererLog'] = 'Referrer-URLs Log gel&ouml;scht';
$langFile['log_clearStatistic_taskLog'] = 'letzte T&auml;tigkeiten Log gel&ouml;scht';

$langFile['log_pageSetup_saved'] = 'Seiten-Einstellungen gespeichert';

$langFile['log_pageSetup_saved'] = 'Kategorien gespeichert';
$langFile['log_pageSetup_new'] = 'Neue Kategorie erstellt';
$langFile['log_pageSetup_delete'] = 'Kategorie gel&ouml;scht';
$langFile['log_pageSetup_move'] = 'Kategorie verschoben';

$langFile['log_pluginSetup_saved'] = 'Plugin-Einstellungen gespeichert';

$langFile['log_file_saved'] = 'Datei gespeichert';

$langFile['log_file_deleted'] = 'Datei gel&ouml;scht';

// ---------- deleting (entfernt)
/*
$langFile['delete_question_submit'] = 'Ja, bitte l&ouml;schen!';
$langFile['delete_question_cancel'] = 'Nein, doch nicht';
*/

// ----------- page/category public/nonpuplic

$langFile['status_page_public'] = 'Seite ist &ouml;ffentlich';
$langFile['status_page_nonpublic'] = 'Seite ist versteckt';

$langFile['status_category_public'] = 'Kategorie ist &ouml;ffentlich';
$langFile['status_category_nonpublic'] = 'Kategorie ist versteckt';

// ----------- sidebar.include.php

$langFile['user_nousers'] = 'Es sind keine Benutzer vorhanden';
$langFile['user_currentuser'] = 'Du bist unter diesem Benutzer eingeloggt';

/* ----------------------------------------------------------------------------------------------
* ---------- GENERAL TEXTs
*/

$langFile['txt_logo'] = 'feindura CMS, Version ';
$langFile['txt_loading'] = 'Seite wird geladen..';

/* ----------------------------------------------------------------------------------------------
* ---------- FRONTEND shared TEXTs
*/

$langFile['date_yesterday'] = 'Gestern';
$langFile['date_today'] = 'Heute';
$langFile['date_tomorrow'] = 'Morgen';

/* ----------------------------------------------------------------------------------------------
* --------- BUTTON-TEXT (index.php)
*/

// --- mainMenu
$langFile['btn_home'] = '&Uuml;bersicht';
$langFile['btn_pages'] = 'Kategorien und Seiten';
$langFile['btn_addons'] = 'Addons';
$langFile['btn_settings'] = 'Webseiten Einstellungen';
$langFile['btn_search'] = 'Seiten durchsuchen';

// --- adminMenu
$langFile['title_adminMenu'] = 'Administration';
$langFile['btn_adminSetup'] = 'Administrator Einstellungen';
$langFile['btn_pageSetup'] = 'Seiten Einstellungen';
$langFile['btn_pluginSetup'] = 'Plugins Einstellungen';
$langFile['btn_statisticSetup'] = 'Statistik Einstellungen';
$langFile['btn_userSetup'] = 'Benutzer Verwaltung';

// --- subMenu/footer
$langFile['btn_createPage'] = 'Neue Seite';
$langFile['btn_createPage_title'] = 'Neue Seite erstellen';
$langFile['btn_deletePage'] = 'Seite l&ouml;schen';
$langFile['btn_deletePage_title'] = 'Diese Seite l&ouml;schen';
$langFile['btn_pageThumbnailUpload'] = 'Seiten-Thumbnail hochladen';
$langFile['btn_pageThumbnailUpload_title'] = 'Thumbnail f&uuml;r diese Seite hochladen/&auml;ndern';
$langFile['btn_pageThumbnailDelete'] = 'Seiten-Thumbnail l&ouml;schen';
$langFile['btn_pageThumbnailDelete_title'] = 'Thumbnail von dieser Seite l&ouml;schen';
$langFile['btn_startPage_title'] = 'Diese Seite als Startseite festlegen';
$langFile['btn_startPage_set'] = 'Diese Seite ist die Startseite';

// --- other
$langFile['btn_fastUp'] = 'Nach oben';
$langFile['date_int'] = 'JJJJ-MM-TT';
$langFile['date_eu'] = 'TT.MM.JJJJ';
$langFile['categories_nocategories_name'] = 'Seiten';
$langFile['categories_nocategories_hint'] = 'ohne Kategorie';
$langFile['text_example'] = 'Beispiel';

/* ----------------------------------------------------------------------------------------------
* ---------- ERROR TEXTs
*/

$langFile['error_save_settings'] = '<b>Die Einstellungen konnten nicht gespeichert werden.</b>';
$langFile['error_save_file'] = '<br /><br />Bitte &uuml;berpr&uuml;fe die Schreibrechte der Datei: ';

$langFile['error_read_folder_part1'] = '<br /><br />Bitte &uuml;berpr&uuml;fe die Leserechte des "';
$langFile['error_save_folder_part1'] = '<br /><br />Bitte &uuml;berpr&uuml;fe die Schreibrechte des "';

$langFile['error_folder_end'] = '" Ordners dessen Unterordner und Dateien.';
$langFile['error_folderDatabase_end'] = '" Ordners dessen Unterordner und Dateien oder die Datenbank.';



/* ----------------------------------------------------------------------------------------------
* ---------- WARNINGs
*/

$langFile['warning_startPageWarning_h1'] = 'Die Startseite ist nicht festgelegt!';
$langFile['warning_startPageWarning'] = 'Bitte lege eine Seite als Startseite fest.<br />Gehe zu <a href="?site=pages">'.$langFile['btn_pages'].'</a> und klicke bei der gew&uuml;nschten Seite auf das <span class="startPageIcon"></span> Symbol';


$langFile['warning_fmsConfWarning_h1'] = '<span class="logoname">fein<span>dura</span></span> wurde noch nicht konfiguriert!';
$langFile['warning_fmsConfWarning'] = 'Der <i>Basispfad</i> stimmt nicht mit dem in den Administrator-Einstellungen angegebenen Pfad &uuml;berein.<br />
Bitte gehe in die <a href="?site=adminSetup">Administrator-Einstellungen</a> und konfiguriere dein <span class="logoname">fein<span>dura</span></span> CMS';

$langFile['warning_jsWarning_h1'] = 'Bitte aktiviere Javascript';
// no <p> tag on the start and the end, its already in the home.php
$langFile['warning_jsWarning'] = '<strong>Um <span class="logoname">fein<span>dura</span></span> voll nutzen zu k&ouml;nnen, muss Javascript aktiviert sein!</strong></p>
<h2>im Firefox</h2>
<p>Klicke in der obersten Men&uuml;leiste auf "Extras" > "Einstellungen". Unter Inhalt aktivierst du den Punkt "JavaScript aktivieren" und best&auml;tigst dann mit OK.</p>
<h2>im Internet Explorer</h2>
<p>Klicke in der obersten Men&uuml;leiste auf "Extras" > "Internetoptionen".<br />
Dort klickst du unter Sicherheit entweder auf "Standardstufe", oder w&auml;hle "Stufe anpassen" und aktiviere dann unter Scripting den Punkt "Active Scripting Aktivieren". Best&auml;tige mit OK.</p>
<h2>im Safari</h2>
<p>Klicke in der obersten Men&uuml;leiste auf das Symbol ganz rechts, w&auml;hle "Einstellungen". Unter "Sicherheit" aktivierst du den Punkt "JavaScript aktivieren" und klicke zum best&auml;tigen auf OK.</p>
<h2>im Mozilla</h2>
<p>Klicke in der obersten Men&uuml;leiste auf "Edit" > "Preferences". Unter dem Punkt "Advanced" > "Scripts & Plugins" kreuze "Navigator" an. Best&auml;tige mit OK.</p>
<h2>im Opera</h2>
<p>Klicke in der obersten Men&uuml;leiste auf "Extras" > "Einstellungen". Unter "Erweitert" > "Inhalte" setze ein Haken bei "JavaScript aktivieren" und klicke dann OK.';

$langFile['warning_ieOld_h1'] = '<span class="logoname">fein<span>dura</span></span> ist nicht f&uuml;r &auml;ltere Versionen des Internet Explorers ausgelegt';
$langFile['warning_ieOld'] = 'Um das <span class="logoname">fein<span>dura</span></span> CMS vollst&auml;ndig nutzen zu k&ouml;nnen ist mindestens der Internet Explorer 7 n&ouml;tig.<br /><br />Bitte installiere eine neuere Version des Internet Explorers,<br /> oder installiere das <a href="http://www.google.com/chromeframe" target="_blank">Google Chrome Frame Plugin</a> f&uuml;r den Internet Explorer,<br />oder lade dir den kostenlosen <a href="http://www.mozilla.org/firefox/">Firefox Browser</a> herunter.';

/* ----------------------------------------------------------------------------------------------
* leftSidebar.loader.php
*/

// ---------- QUICKMENU

$langFile['btn_quickmenu_categories'] = 'Kategorien';
$langFile['btn_quickmenu_pages'] = 'Seiten von';

/* ----------------------------------------------------------------------------------------------
* home.php
*/

// ---------- HOME
$langFile['home_userInfo_h1'] = 'Benutzer Information';

$langFile['home_welcome_h1'] = 'Willkommen in <span class="logoname">fein<span>dura</span></span><br />dem Content Management System deiner Webseite.';
$langFile['home_welcome_text'] = '<span class="logoname">fein<span>dura</span></span> ist ein auf <span class="toolTip" title="Flatfiles::sind Dateien auf dem Server, in denen der Inhalt der Webseite gespeichert wird.">Flatfiles</span> basierendes Content Management System.<br />Hier kannst du den Inhalt deiner Webseite verwalten.';

$langFile['home_statistic_h1'] = 'Webseiten-Statistik';

$langFile['home_user_h1'] = 'Benutzer';
$langFile['home_taskLog_h1'] = 'letzte T&auml;tigkeiten';
$langFile['home_taskLog_nolog'] = 'keine';

$langFile['home_h1_article'] = 'die';
$langFile['home_mostVisitedPages_h1'] = 'meist besuchten Seiten';
$langFile['home_lastEditedPages_h1'] = 'zuletzt bearbeitete Seiten';
$langFile['home_longestViewedPages_h1'] = 'am l&auml;ngsten betrachteten Seiten';

$langFile['home_refererLog_h1'] = 'Webseiten von denen die letzten Besucher gekommen sind';
$langFile['home_refererLog_nolog'] = 'Bisher sind noch keine Besucher von anderen Seiten auf diese Seite gekommen.';
$langFile['home_novisitors'] = 'Bisher sind noch keine Besucher auf diese Seite gekommen.';

/* ----------------------------------------------------------------------------------------------
* listPages.php
*/

// ---------- PAGES SORTABLE LIST
$langFile['sortablePageList_h1'] = 'Der Inhalt deiner Webseite';
$langFile['sortablePageList_headText1'] = '';
$langFile['sortablePageList_headText2'] = 'zuletzt bearbeitet';
$langFile['sortablePageList_headText3'] = 'Besucher';
$langFile['sortablePageList_headText4'] = 'Status';
$langFile['sortablePageList_headText5'] = 'Funktionen';

$langFile['sortablePageList_pagedate'] = 'Seiten-Datum';
$langFile['sortablePageList_tags'] = 'Tags';

$langFile['sortablePageList_sortOrder_manuell'] = 'manuell sortiert';
$langFile['sortablePageList_sortOrder_date'] = 'nach Datum sortiert';

$langFile['sortablePageList_functions_editPage'] = 'Seite bearbeiten';
$langFile['sortablePageList_functions_deletePage'] = 'Seite l&ouml;schen';

$langFile['sortablePageList_changeStatus_linkPage'] = 'Hier klicken um den Status f&uuml;r Seite zu &auml;ndern.';
$langFile['sortablePageList_changeStatus_linkCategory'] = 'Hier klicken um den Status f&uuml;r die Kategorie zu &auml;ndern.';

$langFile['file_error_read'] = '<b>Die Seite konnte nicht gelesen werden.</b>'.$langFile['error_read_folder_part1'].$adminConfig['basePath'].$adminConfig['savePath'].$langFile['error_folderDatabase_end'];
$langFile['sortablePageList_setStartPage_error_save'] = '<b>Die Startseite konnte nicht festgelegt werden.</b>'.$langFile['error_save_file'].' "'.$adminConfig['basePath'].'config/website.config.php"';
$langFile['sortablePageList_changeStatusPage_error_save'] = '<b>Der Status der Seite konnte nicht ge&auml;ndert werden.</b>'.$langFile['error_save_folder_part1'].$adminConfig['basePath'].$adminConfig['savePath'].$langFile['error_folderDatabase_end'];
$langFile['sortablePageList_changeStatusCategory_error_save'] = '<b>Der Status der Seite konnte nicht ge&auml;ndert werden.</b>'.$langFile['error_save_folder_part1'].$adminConfig['basePath'].$adminConfig['savePath'].$langFile['error_folderDatabase_end'];

$langFile['sortablePageList_info'] = 'Du kannst die <b>Seiten-Anordnung</b> per <b>Drag and Drop</b> ver&auml;ndern und auch Seiten zwischen den Kategorien verschieben.';
$langFile['sortablePageList_save'] = 'Speichere die neue Anordnung ...';
$langFile['sortablePageList_save_finished'] = 'Neu Anordnung erfolgreich gespeichert!';
$langFile['sortablePageList_error_save'] = '<b>Die Seiten konnten nicht gespeichert werden.</b>'.$langFile['error_save_folder_part1'].$adminConfig['basePath'].$adminConfig['savePath'].$langFile['error_folder_end'];
$langFile['sortablePageList_error_read'] = '<b>Die Seiten konnten nicht gelesen werden.</b>'.$langFile['error_read_folder_part1'].$adminConfig['basePath'].$adminConfig['savePath'].$langFile['error_folder_end'];
$langFile['sortablePageList_error_move'] = '<b>Konnte die Seite nicht in die neue Kategorie verschieben.</b>'.$langFile['error_save_folder_part1'].$adminConfig['basePath'].$adminConfig['savePath'].$langFile['error_folder_end'];
$langFile['sortablePageList_categoryEmpty'] = 'Keine Seiten vorhanden';

// ---------- FORMULAR
$langFile['form_submit'] = 'Speichern';
$langFile['form_cancel'] = 'Alle Eingaben l&ouml;schen';

// ---------- ERRORWINDOW
$langFile['form_errorWindow_h1'] = 'Ein Fehler ist aufgetreten!';


/* ----------------------------------------------------------------------------------------------
* adminSetup.php
*/

// ---------- ADMIN SETUP (on toolTips tooTips.js converts the "[" and "]" tags in the title attribute to "<" ">")
$langFile['adminSetup_version'] = '<span class="logoname">fein<span>dura</span></span> Version';
$langFile['adminSetup_phpVersion'] = 'PHP Version';
$langFile['adminSetup_warning_phpversion'] = 'For full functionality of <span class="logoname">fein<span>dura</span></span> you need at least'; // PHP 4.3.0
$langFile['adminSetup_srvRootPath'] = 'Server-Root-Pfad';

$langFile['adminSetup_error_title'] = 'Es sind Fehler aufgetreten';
$langFile['adminSetup_error_writeAccess_tip'] = 'Bei Dateien und Verzeichnissen m&uuml;ssen die Schreibrechte auf 777 gesetzt werden.';
//$langFile['adminSetup_writeAccess'] = 'Bei folgenden Dateien und Verzeichnissen m&uuml;ssen die Schreibrechte auf <span class="toolTip" title="Schreibrechte::Besitzer[br /][small]Lesen/Schreiben/Ausf&uuml;hren[/small][br /]Gruppen[br /][small]Lesen/Schreiben/Ausf&uuml;hren[/small][br /]&Ouml;ffentlich[br /][small]Lesen/Schreiben/Ausf&uuml;hren[/small]" style="text-decoration: underline;">777</span> gesetzt werden';

$langFile['adminSetup_error_writeAccess'] = 'ist nicht beschreibbar';
$langFile['adminSetup_error_isFolder'] = 'ist kein Verzeichnis';

// ---------- FMS Settings
$langFile['adminSetup_fmsSettings_error_save'] = $langFile['error_save_settings'].$langFile['error_save_file'].$adminConfig['basePath'].'config/admin.config.php';

$langFile['adminSetup_fmsSettings_h1'] = 'Grund-Einstellungen';

$langFile['adminSetup_fmsSettings_savePathShouldBeOutside'] = '[span class=hint]Der Pfad sollte au&szlig;erhalb des feindura Ordners liegen, wenn der feindura Ordner passwortgesch&uuml;zt ist.[/span]';

$langFile['adminSetup_fmsSettings_field1'] = 'Webseiten URL';
$langFile['adminSetup_fmsSettings_field1_tip'] = 'Die URL ihrer Webseite wird automatisch eingef&uuml;gt.';
$langFile['adminSetup_fmsSettings_field1_inputTip'] = 'Der Pfad wird automatisch eingef&uuml;gt';
$langFile['adminSetup_fmsSettings_field1_inputWarningText'] = 'Bitte speichere die Einstellungen!';
$langFile['adminSetup_fmsSettings_field2'] = 'Hauptpfad';
$langFile['adminSetup_fmsSettings_field2_tip'] = 'Der Hauptpfad wird automatisch ermittelt und beim Speichern der Einstellungen &uuml;bernommen.';
$langFile['adminSetup_fmsSettings_field2_inputTip'] = 'Der Pfad wird automatisch eingef&uuml;gt';
$langFile['adminSetup_fmsSettings_field2_inputWarningText'] = 'Bitte speichere die Einstellungen!';
$langFile['adminSetup_fmsSettings_field3'] = 'Speicherpfad';
$langFile['adminSetup_fmsSettings_field3_tip'] = 'Der [b]absolute Pfad[/b], unter dem die Flatfiles mit dem Seiteninhalt gespeichert werden.[br /][br /]'.$langFile['adminSetup_fmsSettings_savePathShouldBeOutside'];
$langFile['adminSetup_fmsSettings_field4'] = 'Daten-Upload Pfad';
$langFile['adminSetup_fmsSettings_field4_tip'] = '[b]Absoluter Pfad[/b][br /]Hier werden Dateien wie Bilder, Flash-Animation oder Dokumente hochgeladen.[br /][br /]Es werden automatisch Unterordner f&uuml;r die Dateitypen erstellt[br /](images, flash, files)[br /][br /][span class=hint]Dateien werden im HTML-Editor unter Link-einf&uuml;gen > Upload hochgeladen.[/span][br /][br /]'.$langFile['adminSetup_fmsSettings_savePathShouldBeOutside'];
$langFile['adminSetup_fmsSettings_field5'] = 'Dateipfad f&uuml;r Webseitendateien';
$langFile['adminSetup_fmsSettings_field5_tip'] = 'Diese Dateien k&ouml;nnen verwendet werden z.B. um eine Webseite mehrsprachig zu gestalten.[br /][br /]Diese Dateien k&ouml;nnen dann weiter unten oder in den Webseiten-Einstellungen bearbeitet werde (sollte dies in den Benutzer-Einstellungen aktiviert sein).[br /][br /]'.$langFile['adminSetup_fmsSettings_savePathShouldBeOutside'];
$langFile['adminSetup_fmsSettings_field6'] = 'Dateipfad f&uuml;r Stylesheetdateien';
$langFile['adminSetup_fmsSettings_field6_tip'] = 'Der [b]absolute Pfad[/b], in dem sich die Stylesheet-Dateien der Webseite befinden.[br /][br /]Die Stylesheet-Dateien kann man dann weiter unten oder in den Webseiten-Einstellungen bearbeiten (sollte dies in den Benutzer-Einstellungen aktiviert sein).';
$langFile['adminSetup_fmsSettings_varName1'] = 'Seiten Variablenname';
$langFile['adminSetup_fmsSettings_varName1_inputTip'] = 'Wenn das Feld leer ist, wird der Standard Name f&uuml;r die GET-Variablen verwendet: "[b]page[/b]"';
$langFile['adminSetup_fmsSettings_varName2'] = 'Kategorie Variablenname';
$langFile['adminSetup_fmsSettings_varName2_inputTip'] = 'Wenn das Feld leer ist, wird der Standard Name f&uuml;r die GET-Variablen verwendet: "[b]category[/b]"';
$langFile['adminSetup_fmsSettings_varName3'] = 'Modul Variablenname';
$langFile['adminSetup_fmsSettings_varName3_inputTip'] = 'Wenn das Feld leer ist, wird der Standard Name f&uuml;r die GET-Variablen verwendet: "[b]modul[/b]"';
$langFile['adminSetup_fmsSettings_varName_tip'] = 'Der Name der [b]$_GET Variable[/b] die f&uuml;r die Seiten Verlinkung verwendet wird.';
$langFile['adminSetup_fmsSettings_field7'] = 'Datumsformat';
$langFile['adminSetup_fmsSettings_field7_tip'] = 'Wird in [span class=logoname]fein[span]dura[/span][/span] und der Webseite verwendet.[br /]Entweder:[br /]DIN 5008 ('.$langFile['date_eu'].') oder[br /]ISO 8601 ('.$langFile['date_int'].')';
$langFile['adminSetup_fmsSettings_speakingUrl'] = 'URL Format';
$langFile['adminSetup_fmsSettings_speakingUrl_true'] = 'Speaking URL';
$langFile['adminSetup_fmsSettings_speakingUrl_true_example'] = '/category/example/example.html';
$langFile['adminSetup_fmsSettings_speakingUrl_false'] = 'URL mit Variablen';
$langFile['adminSetup_fmsSettings_speakingUrl_false_example'] = 'index.php?'.$adminConfig['varName']['category'].'=1&'.$adminConfig['varName']['page'].'=1';
$langFile['adminSetup_fmsSettings_speakingUrl_tip'] = 'Das URL Format, welches f&uuml;r die Seiten-Verlinkung verwendet wird.[br /][br /]Speaking URLs funktionieren nur wenn im [b]Apache[/b] das [b]mod_rewrite[/b] Modul aktiviert ist.';
$langFile['adminSetup_fmsSettings_speakingUrl_warning'] = 'WARNUNG!::[span class=red]Sollten Fehler bei der Vewendung von Speaking URLs auftreten, muss die [b].htaccess Datei[/b] im Dokumenten-Root Pfad des Webservers gel&ouml;scht werden.[/span][br /][br /](In manchen FTP-Programmen muss man erst die versteckten Dateien anzeigen, um die .htaccess Datei sichtbar zu machen)';

// ---------- speaking url ERRORs
$langFile['adminSetup_fmsSettings_speakingUrl_error_save'] = '<b>Speaking URL</b> konnte nicht aktiviert werden'.$langFile['error_save_file'].'/.htaccess';

// ---------- user Settings
$langFile['adminSetup_userSettings_h1'] = 'Benutzer-Einstellungen';
$langFile['adminSetup_userSettings_check1'] = 'Webseitendateien bearbeiten, in den Webseiten-Einstellungen anzeigen';
$langFile['adminSetup_userSettings_check2'] = 'Stylesheetdateien bearbeiten, in den Webseiten-Einstellungen anzeigen';

$langFile['adminSetup_userSettings_textarea1'] = '<strong>Benutzerinformation</strong> auf der <a href="?site=home">Startseite</a>';
$langFile['adminSetup_userSettings_textarea1_tip'] = 'Benutzerinformationen::Diese zus&auml;tzlichen Informationen werden auf der [span class=logoname]fein[span]dura[/span][/span] Startseite angezeigt.';
$langFile['adminSetup_userSettings_textarea1_inputTip'] = 'Lasse das Feld leer, wenn Du keine Informationen f&uuml;r den Benutzer anzeigen m&ouml;chtest';

// ---------- editor Settings
$langFile['adminSetup_editorSettings_h1'] = 'HTML-Editor-Einstellungen';
$langFile['adminSetup_editorSettings_field1'] = 'ENTER-Taste Modus';
$langFile['adminSetup_editorSettings_field1_hint'] = 'SHIFT + ENTER erzeugt immer ein "<br />"';
$langFile['adminSetup_editorSettings_field1_tip'] = 'Legt fest, welcher HTML-Tag beim dr&uuml;cken der ENTER-Taste gesetzt [br]wird.[br /][br /][span class=hint]'.$langFile['adminSetup_editorSettings_field1_hint'].'.[/span]';
$langFile['adminSetup_editorSettings_field3_inputTip'] = 'Wenn das Feld leer ist, wird keine Id verwendet.';
$langFile['adminSetup_editorSettings_field4_inputTip'] = 'Wenn das Feld leer ist, wird keine Klasse verwendet.';

// ---------- thumbnail Settings
$langFile['adminSetup_thumbnailSettings_h1'] = 'Seiten-Thumbnail-Einstellungen';
$langFile['adminSetup_thumbnailSettings_field3'] = 'Speicherpfad'; // Thumbnail-Speicherpfad
$langFile['adminSetup_thumbnailSettings_field3_tip'] = 'Der Pfad oder Verzeichnisname innerhalb des Daten-Upload Pfads';
$langFile['adminSetup_thumbnailSettings_field3_inputTip1'] = 'Der Daten-Upload Pfad';
$langFile['adminSetup_thumbnailSettings_field3_inputTip2'] = 'Relativer Pfad::Relativ zum "[b]'.$adminConfig['uploadPath'].'image/[/b]" Ordner.[br /][br /]Beginnt ohne "/"';
$langFile['adminSetup_thumbnailSettings_field3_inputTip3'] = '<b>'.$langFile['text_example'].'</b> "thumbnails/" ';

// ---------- styleFile Settings
$langFile['adminSetup_styleFileSettings_h1'] = '"Stil-Auswahl" des HTML-Editors bearbeiten';
$langFile['adminSetup_styleFileSettings_error_save'] = '<b>Die Datei "htmlEditorStyles.xml" konnte nicht gespeichert werden.</b>'.$langFile['error_save_file'];

// ---------- editFiles Settings
$langFile['editFilesSettings_error_save'] = '<b>Die Datei konnte nicht gespeichert werden.</b>'.$langFile['error_save_file'];

$langFile['editFilesSettings_h1_style'] = 'Stylesheetdateien bearbeiten';
$langFile['editFilesSettings_h1_websitefiles'] = 'Webseitendateien bearbeiten';
$langFile['editFilesSettings_noDir'] = 'ist kein g&uuml;ltiges Verzeichnis!';
$langFile['editFilesSettings_chooseFile'] = 'Datei ausw&auml;hlen';
$langFile['editFilesSettings_createFile'] = 'Neue Datei anlegen';
$langFile['editFilesSettings_createFile_inputTip'] = 'Wenn hier ein Dateiname eingetragen wird, dann wird eine Neue Datei erstellt,[br /]und [b]die derzeit ausgew&auml;hlte Datei wird nicht gespeichert![/b]';
$langFile['editFilesSettings_noFile'] = 'Es sind noch keine Dateien vorhanden';

$langFile['editFilesSettings_deleteFile'] = 'Datei l&ouml;schen';
$langFile['editFilesSettings_deleteFile_question_part1'] = 'Datei'; // Kategorie "test" l&ouml;schen?
$langFile['editFilesSettings_deleteFile_question_part2'] = 'wirklich l&ouml;schen?';

$langFile['editFilesSettings_deleteFile_question_ok'] = 'Ja bitte l&ouml;schen!';
$langFile['editFilesSettings_deleteFile_question_cancel'] = 'Nicht l&ouml;schen';

$langFile['editFilesSettings_deleteFile_error_delete'] = '<b>Die Datei konnte nicht gel&ouml;scht werden.</b>'.$langFile['error_save_file'];

/* ----------------------------------------------------------------------------------------------
* pageSetup.php
*/

// ---------- CATEGORY SETUP (on toolTips tooTips.js converts the "[" and "]" tags in the title attribute to "<" ">")
$langFile['pageSetup_general_tag_tip'] = 'Tags k&ouml;nnen dazu verwendet werden Seiten untereinander in Beziehung zu setzen (abh&auml;ngig von der Programmierung der Webseite)';

// ---------- page settings
$langFile['pageSetup_pageConfig_h1'] = 'Seiten-Einstellungen';
$langFile['pageSetup_pageConfig_check1'] = 'Startseite ist einstellbar';
$langFile['pageSetup_pageConfig_check1_tip'] = 'Startseite ist vom Benutzer selbst einstellbar.[br /][br /]Die eingestellte Startseite wird angezeigt wenn keine Seiten-Variablen in der Webseite &uuml;bergeben werden bzw. keine Seite aufgerufen wurde.';

$langFile['pageSetup_pageConfig_noncategorypages_h1'] = 'Seiten ohne Kategorie';
$langFile['pageSetup_pageConfig_check2'] = 'Seiten erstellen/l&ouml;schen';
$langFile['pageSetup_pageConfig_check2_tip'] = 'Legt fest, ob der Benutzer, innerhalb der Seiten ohne Kategorie, Seiten erstellen und l&ouml;schen kann.';
$langFile['pageSetup_pageConfig_check3'] = 'Thumbnail hochladen';
$langFile['pageSetup_pageConfig_check3_tip'] = 'Legt fest ob der Benutzer, innerhalb der Seiten ohne Kategorie, Seiten-Thumbnails hochladen kann.';
$langFile['pageSetup_pageConfig_check4'] = 'Tags bearbeiten';
$langFile['pageSetup_pageConfig_check4_tip'] = 'Legt fest ob der Benutzer, innerhalb der Seiten ohne Kategorie, Tags bearbeiten kann.[br /]'.$langFile['pageSetup_general_tag_tip'];
$langFile['pageSetup_pageConfig_check5'] = 'Plugins erlauben';
$langFile['pageSetup_pageConfig_check5_tip'] = 'Legt fest ob der Benutzer, innerhalb der Seiten ohne Kategorie, Plugins einstellen kann.';

// ---------- category settings
$langFile['pageSetup_h1'] = 'Kategorien-Verwaltung';
$langFile['pageSetup_createCategory'] = 'Neue Kategorie erstellen';
$langFile['pageSetup_createCategory_created'] = 'Neue Kategorie erstellt';
$langFile['pageSetup_createCategory_unnamed'] = 'Unbenannte Kategorie';

$langFile['pageSetup_deleteCategory'] = 'Kategorie l&ouml;schen';
$langFile['pageSetup_deleteCategory_warning'] = 'ACHTUNG: Es werden auch alle Seiten innerhalb dieser Kategorie gel&ouml;scht!';
$langFile['pageSetup_deleteCategory_deleted'] = 'Kategorie gel&ouml;scht';

$langFile['pageSetup_moveCategory_moved'] = 'Kategorie verschoben';
$langFile['pageSetup_moveCategory_up_tip'] = 'Kategorie nach oben verschieben';
$langFile['pageSetup_moveCategory_down_tip'] = 'Kategorie nach unten verschieben';

$langFile['pageSetup_error_create'] = '<b>Eine neue Kategorie konnte nicht erstellt werden.</b>'.$langFile['error_save_folder_part1'].$adminConfig['basePath'].'config/'.$langFile['error_folderDatabase_end'];
$langFile['pageSetup_error_createDir'] = '<b>Konnte keine neues Kategorie-Verzeichnis erstellen.</b>'.$langFile['error_save_folder_part1'].$adminConfig['basePath'].$adminConfig['savePath'].'" Ordners.';
$langFile['pageSetup_error_delete'] = '<b>Die Kategorie konnte nicht gel&ouml;scht werden.</b>'.$langFile['error_save_file'].$adminConfig['basePath'].'config/category.config.php';
$langFile['pageSetup_error_deleteDir'] = '<b>Konnte das Kategorie-Verzeichnis nicht l&ouml;schen.</b>'.$langFile['error_save_folder_part1'].$adminConfig['basePath'].$adminConfig['savePath'].$langFile['error_folder_end'];
$langFile['pageSetup_error_save'] = $langFile['error_save_settings'].$langFile['error_save_file'].$adminConfig['basePath'].'config/category.config.php';


$langFile['pageSetup_advancedSettings'] = 'Erweiterte-Einstellungen';
$langFile['pageSetup_advancedSettings_hint'] = 'Wenn diese Einstellungen ausgef&uuml;llt sind &uuml;berschreiben sie die Seiten-Thumbnail-Einstellungen weiter oben und die HTML-Editor-Einstellungen in den <a href="?site=adminSetup">Administrator-Einstellungen</a>';

$langFile['pageSetup_field1'] = 'Name';
$langFile['pageSetup_stylesheet_ifempty'] = 'Wenn das Feld leer ist, dann werden die Standard Stylesheet-Einstellungen aus den HTML-Editor-Einstellungen verwendet.';

$langFile['pageSetup_check1'] = 'Status der Kategorie';
$langFile['pageSetup_check1_tip'] = 'Legt fest, ob die Kategorie auf der Webseite sichtbar ist.';
$langFile['pageSetup_check2'] = 'Seiten erstellen/l&ouml;schen';
$langFile['pageSetup_check2_tip'] = 'Der Benutzer kann in dieser Kategorie Seiten erstellen und l&ouml;schen.';
$langFile['pageSetup_check3'] = 'Thumbnail hochladen';
$langFile['pageSetup_check3_tip'] = 'Der Benutzer hat die M&ouml;glichkeit ein Thumbnail f&uuml;r jede Seite in dieser Kategorie hochzuladen.';

$langFile['pageSetup_check4'] = 'Tags bearbeiten';
$langFile['pageSetup_check4_tip'] = 'Es k&ouml;nnen Tags f&uuml;r die Seiten in dieser Kategorie festgelegt werden.[br /]'.$langFile['pageSetup_general_tag_tip'];

$langFile['pageSetup_check8'] = 'Plugins erlauben';
$langFile['pageSetup_check8_tip'] = 'Plugins f&uuml;r die Seiten in dieser Kategorie erlauben';

$langFile['pageSetup_check5'] = 'Datum einstellbar';
$langFile['pageSetup_check5_tip'] = 'Das Datum kann dazu verwendet werden, Seiten auf der Webseite nach Datum zu sortieren';

$langFile['pageSetup_check6'] = 'nach Datum sortieren';
$langFile['pageSetup_check6_tip'] = 'Die Seiten werden nach dem angegeben Datum sortiert.[br /][br /][span class=hint]Manuelles Sortieren ist nicht mehr m&ouml;glich.[/span]';

$langFile['pageSetup_check7'] = 'Neueste Seite immer unten anzeigen';
$langFile['pageSetup_check7_tip'] = 'Sortiert die Seiten automatisch [b]aufsteigend[/b].[br /][br /][span class=hint]Manuelles Sortieren &uuml;berschreibt diese Einstellung f&uuml;r die jeweilige Seite.[/span]';


// ---------- deleting category
$langFile['pageSetup_deletCategory_question_part1'] = 'Kategorie'; // Kategorie "test" l&ouml;schen?
$langFile['pageSetup_deletCategory_question_part2'] = 'l&ouml;schen?';

$langFile['pageSetup_deletCategory_question_ok'] = 'Ja bitte l&ouml;schen!';
$langFile['pageSetup_deletCategory_question_cancel'] = 'Nicht l&ouml;schen';

/* ----------------------------------------------------------------------------------------------
* websiteSetup.php
*/

// ---------- WEBSITE SETUP (on toolTips tooTips.js converts the "[" and "]" tags in the tittle attribute to "<" ">")
$langFile['websiteSetup_websiteConfig_error_save'] = $langFile['error_save_settings'].$langFile['error_save_file'].$adminConfig['basePath'].'config/website.config.php';

$langFile['websiteSetup_websiteConfig_h1'] = 'Webseiten-Einstellungen';
$langFile['websiteSetup_websiteConfig_field1'] = 'Webseiten-Titel';
$langFile['websiteSetup_websiteConfig_field1_tip'] = 'Der Titel der Webseite wird oben in der Browserleiste angezeigt.';
$langFile['websiteSetup_websiteConfig_field2'] = 'Publisher';
$langFile['websiteSetup_websiteConfig_field2_tip'] = 'Der Name der Organisation/Firma/Person, die diese Seite ver&oumlffentlicht.';
$langFile['websiteSetup_websiteConfig_field3'] = 'Copyright';
$langFile['websiteSetup_websiteConfig_field3_tip'] = 'Der Copyright-Besitzer der Webseite.';

$langFile['websiteSetup_websiteConfig_field4'] = 'Suchmaschinen-Stichworte';
$langFile['websiteSetup_websiteConfig_field4_tip'] = 'Die meisten Suchmaschienen durchsuchen den Seiteninhalt nach Stichworten, jedoch sollte man einige Schl&uuml;sselw&ouml;rter hier auff&uuml;hren.';
$langFile['websiteSetup_websiteConfig_field4_inputTip'] = 'Die Stichworte m&uuml;ssen mit "," getrennt werden.::'.$langFile['text_example'].':[br /]stichwort1,stichwort2,etc';
$langFile['websiteSetup_websiteConfig_field5'] = 'Webseiten-Beschreibung';
$langFile['websiteSetup_websiteConfig_field5_tip'] = 'Ist eine kurze Beschreibung die in den Suchmaschienen ercheint, wenn man nach der Webseiten-Adresse sucht oder keine Stichworte im Webseiten-Text gefunden wurden.';
$langFile['websiteSetup_websiteConfig_field5_inputTip'] = 'Ein kurzer Text mit nicht mehr als 3 Zeilen.';
$langFile['websiteSetup_websiteConfig_field6'] = 'E-Mail Adresse';
$langFile['websiteSetup_websiteConfig_field6_tip'] = 'Diese E-Mail Adresse wird f&uuml;r alle wichtigen Kontaktm&ouml;glichkeiten verwendet[br /](z.B. Kontaktformulare etc.)';
$langFile['websiteSetup_websiteConfig_field6_inputTip'] = $langFile['text_example'].'::name@providor.de';


/* ----------------------------------------------------------------------------------------------
* statisticSetup.php
*/

// ---------- STATISITC SETUP (on toolTips tooTips.js converts the "[" and "]" tags in the tittle attribute to "<" ">")
$langFile['statisticSetup_statisticConfig_error_save'] = $langFile['error_save_settings'].$langFile['error_save_file'].$adminConfig['basePath'].'config/statistic.config.php';

$langFile['statisticSetup_statisticConfig_h1'] = 'Statistik-Einstellungen';
$langFile['statisticSetup_statisticConfig_field1'] = 'Anzahl der sichtbaren <b>meist besuchten</b> Seiten';
$langFile['statisticSetup_statisticConfig_field1_tip'] = 'Gibt an wieviele meist besuchte Seiten auf der &Uuml;bersicht-Seite angezeigt werden.';
$langFile['statisticSetup_statisticConfig_field2'] = 'Anzahl der sichtbaren <b>am l&auml;ngsten betrachteten</b> Seiten';
$langFile['statisticSetup_statisticConfig_field2_tip'] = 'Gibt an wieviele am l&auml;ngsten betrachtete Seiten auf der &Uuml;bersicht-Seite angezeigt werden.';
$langFile['statisticSetup_statisticConfig_field3'] = 'Anzahl der sichtbaren <b>zuletzt bearbeiteten</b> Seiten';
$langFile['statisticSetup_statisticConfig_field3_tip'] = 'Gibt an wieviele zuletzt bearbeitete Seiten auf der &Uuml;bersicht-Seite angezeigt werden.';

$langFile['statisticSetup_statisticConfig_field4'] = 'maximale Anzahl der zu speichernden <b>Referrer-URLs</b>';
$langFile['statisticSetup_statisticConfig_field4_tip'] = 'Gibt an wieviele Referrer-URLs ([i]URLs die auf diese Webseite gef&uuml;hrt haben[/i]) maximal gespeichert werden.';
$langFile['statisticSetup_statisticConfig_field5'] = 'maximale Anzahl der zu speichernden <b>T&auml;tigkeiten-Logs</b>';
$langFile['statisticSetup_statisticConfig_field5_tip'] = 'Gibt an wieviele T&auml;tigkeiten-Logs maximal gespeichert werden.';


$langFile['statisticSetup_clearStatistic_h1'] = 'Statistiken l&ouml;schen';
$langFile['statisticSetup_clearStatistics_websiteStatistic'] = 'Webseiten-Statistik';
$langFile['statisticSetup_clearStatistics_websiteStatistic_tip'] = '[b]Beinhaltet[/b][ul][li]Gesamtanzahl der Besucher[/li][li]Gesamtanzahl der Spider[/li][li]Datum des ersten Besuchs[/li][li]Datum des letzten Besuchs[/li][li]Browserverteilung[/li][/ul]';
$langFile['statisticSetup_clearStatistics_pagesStatistic'] = 'Seiten-Statistiken';
$langFile['statisticSetup_clearStatistics_pagesStatistic_tip'] = '[b]Beinhaltet[/b][ul][li]Anzahl der Seitenbesucher[/li][li]Datum des ersten Seitenbesuchs[/li][li]Datum des letzten Seitenbesuchs[/li][li]k&uuml;rzeste Verweildauer[/li][li]l&auml;ngste Verweildauer[/li][li]Suchmaschienen-Stichworte die auf diese Seite gef&uuml;hrt haben[/li][/ul]';
$langFile['statisticSetup_clearStatistics_refererLog'] = 'Referrer-URLs Log'; // engl.: referer
$langFile['statisticSetup_clearStatistics_refererLog_tip'] = 'Beinhaltet eine Liste mit allen Referrer-URLs die auf diese Webseite gef&uuml;hrt haben.';
$langFile['statisticSetup_clearStatistics_taskLog'] = 'Logs der letzten T&auml;tigkeiten';
$langFile['statisticSetup_clearStatistics_taskLog_tip'] = 'Beinhaltet eine Liste der letzten T&auml;tigkeiten.';

$langFile['statisticSetup_clearStatistics_question_h1'] = 'Willst du diese Statistiken wirklich l&ouml;schen?';
$langFile['statisticSetup_clearStatistics_question_ok'] = 'Ja bitte l&ouml;schen!';
$langFile['statisticSetup_clearStatistics_question_cancel'] = 'Nicht l&ouml;schen';

$langFile['statisticSetup_clearStatistic_pagesStatistics_error_read'] = 'Fehler beim l&ouml;schen der Seiten-Statistiken.'.$langFile['error_save_folder_part1'].$adminConfig['basePath'].$adminConfig['savePath'].$langFile['error_folderDatabase_end'];

/* ----------------------------------------------------------------------------------------------
* pluginSetup.php
*/

// ---------- PLUGIN SETUP (on toolTips tooTips.js converts the "[" and "]" tags in the tittle attribute to "<" ">")
$langFile['pluginSetup_editFiles_h1'] = 'Dateien bearbeiten';
$langFile['pluginSetup_pluginconfig_active'] = 'Plugin aktiviert';
$langFile['pluginSetup_pluginconfig_error_save'] = $langFile['error_save_settings'].$langFile['error_save_file'].$adminConfig['basePath'];


/* ----------------------------------------------------------------------------------------------
* editor.php
*/

// ---------- page data
$langFile['editor_h1_lastsavedate'] = 'zuletzt bearbeitet am';
$langFile['editor_h1_lastsaveauthor'] = 'von';
$langFile['editor_h1_createpage'] = 'Neue Seite erstellen';
$langFile['editor_h1_linktothispage'] = 'Link zu dieser Seite';
$langFile['editor_h1_id'] = 'Seiten ID';
$langFile['editor_h1_id_tip'] = 'Unter der Seiten ID wird die Seite auf dem Server oder in der Datenbank gespeichert.';
$langFile['editor_h1_categoryid'] = 'Kategorie ID';
$langFile['editor_h1_categoryid_noCategory'] = 'keine Kategorie';

// ---------- page settings
$langFile['editor_pageSettings_h1'] = 'Seiten-Einstellungen';
$langFile['editor_pagestatistics_h1'] = 'Seiten-Statistik';

$langFile['editor_pageSettings_title'] = 'Seiten-Titel';
$langFile['editor_pageSettings_title_tip'] = 'Der Titel der Seite';
$langFile['editor_pageSettings_field1'] = 'Seiten-Beschreibung';
$langFile['editor_pageSettings_field1_inputTip'] = 'Wenn das Feld leer ist wird die Webseiten-Beschreibung aus den Webseiten-Einstellungen verwendet.';
$langFile['editor_pageSettings_field1_tip'] = 'Eine kurze Beschreibung der Seite. Diese kommt in die META-Tags der Seite.[br /][br /][span class=hint]'.$langFile['editor_pageSettings_field1_inputTip'].'[/span]';
$langFile['editor_pageSettings_field2'] = 'Tags';
$langFile['editor_pageSettings_field2_tip'] = 'Tags sind Stichworte, die mit dieser Seite verkn&uuml;pft sind.';
$langFile['editor_pageSettings_field2_tip_inputTip'] = 'Die Stichworte sollten mit [b]Leerzeichen[/b] getrennt werden.';
$langFile['editor_pageSettings_field3'] = 'Seitendatum';
$langFile['editor_pageSettings_field3_tip'] = 'Das Datum kann dazu verwendet werden, Seiten nach Aktualit&auml;t zu sortieren. (z.B. bei Veranstaltungen)';
$langFile['editor_pageSettings_pagedate_before_inputTip'] = 'Text vor dem Datum::z.B. vom Tag/Monat bis';
$langFile['editor_pageSettings_pagedate_after_inputTip'] = 'Text nach dem Datum::';
$langFile['editor_pageSettings_pagedate_day_inputTip'] = 'Tag::';
$langFile['editor_pageSettings_pagedate_month_inputTip'] = 'Monat::';
$langFile['editor_pageSettings_pagedate_year_inputTip'] = 'Jahr::[b]Format[/b] JJJJ';
$langFile['editor_pageSettings_field4'] = 'Status der Seite';
$langFile['editor_pageSettings_field4_tip'] = '[b]Nur wenn die Seite &ouml;ffentlich ist, wird diese auf der Webseite angezeigt![/b]';

$langFile['editor_pageSettings_pagedate_error'] = 'Fehlerhaftes Datumsformat';
$langFile['editor_pageSettings_pagedate_error_tip'] = 'Dieser Monat hat eventuell keine 31 Tage,[br /]und das Datum sollte folgendes Format haben:';

// ---------- page advanced settings
$langFile['editor_advancedpageSettings_h1'] = 'erweiterte Seiten-Einstellungen';

$langFile['editor_advancedpageSettings_field1'] = 'Seiten Stylesheet-Datei';
$langFile['editor_advancedpageSettings_field1_tip'] = $langFile['stylesheet_styleFile_tip'].'[br /][br /]Wenn das Feld leer ist dann wird die Standard Stylesheet-Datei aus den HTML-Editor-Einstellungen verwendet.';
$langFile['editor_advancedpageSettings_field1_inputTip2'] = '<b>'.$langFile['text_example'].'</b> "/style/layout.css" ';
$langFile['editor_advancedpageSettings_field3'] = 'Seiten Stylesheet-Id';
$langFile['editor_advancedpageSettings_field3_tip'] = $langFile['stylesheet_styleId_tip'];
$langFile['editor_advancedpageSettings_field3_inputTip'] = 'Wenn das Feld leer ist, dann wird die Standard Stylesheet-Id aus den HTML-Editor-Einstellungen verwendet.';
$langFile['editor_advancedpageSettings_field4'] = 'Seiten Stylesheet-Klasse';
$langFile['editor_advancedpageSettings_field4_tip'] = $langFile['stylesheet_styleClass_tip'];
$langFile['editor_advancedpageSettings_field4_inputTip'] = 'Wenn das Feld leer ist, dann wird die Standard Stylesheet-Klasse aus den HTML-Editor-Einstellungen verwendet.';

$langFile['editor_htmleditor_hotkeys_h1'] = 'Tastenk&uuml;rzel';
$langFile['editor_htmleditor_hotkeys_field1'] = 'Alles markieren';
$langFile['editor_htmleditor_hotkeys_field2'] = 'Kopieren';
$langFile['editor_htmleditor_hotkeys_field3'] = 'Einf&uuml;gen';
$langFile['editor_htmleditor_hotkeys_field4'] = 'Ausschneiden';
$langFile['editor_htmleditor_hotkeys_field5'] = 'R&uuml;ckg&auml;ngig';
$langFile['editor_htmleditor_hotkeys_field6'] = 'Wiederherstellen';
$langFile['editor_htmleditor_hotkeys_field7'] = 'Link setzen';
$langFile['editor_htmleditor_hotkeys_field8'] = 'Fett';
$langFile['editor_htmleditor_hotkeys_field9'] = 'Kursiv';
$langFile['editor_htmleditor_hotkeys_field10'] = 'Unterstrichen';
$langFile['editor_htmleditor_hotkeys_or'] = 'oder';

$langFile['editor_savepage_error_save'] = '<b>Die Seite konnte nicht gespeichert werden.</b>'.$langFile['error_save_folder_part1'].$adminConfig['basePath'].$adminConfig['savePath'].$langFile['error_folderDatabase_end'];

/* ----------------------------------------------------------------------------------------------
* deletePage.php
*/

// ---------- DELETE PAGE
$langFile['deletePage_question_part1'] = 'M&ouml;chtest du die Seite';
$langFile['deletePage_question_part2'] = 'wirklich l&ouml;schen?';

$langFile['deletePage_finishnotexisting_part1'] = 'Die Seite';
$langFile['deletePage_finish_part2'] = 'wurde erfolgreich gel&ouml;scht';
$langFile['deletePage_notexisting_part2'] = 'existiert nicht';

$langFile['deletePage_finish_error'] = 'FEHLER: Die Seite konnte nicht gel&ouml;scht werden!';

/* ----------------------------------------------------------------------------------------------
* pageThumbnailDelete.php
*/

// ---------- PAGE THUMBNAIL DELETE
$langFile['pageThumbnailDelete_question_part1'] = 'M&ouml;chtest du das Thumbnail von der Seite';
$langFile['pageThumbnailDelete_question_part2'] = 'wirklich l&ouml;schen?';

$langFile['pageThumbnailDelete_name'] = 'Der Thumbnail';
$langFile['pageThumbnailDelete_finish_part2'] = 'wurde erfolgreich gel&ouml;scht';
$langFile['pageThumbnailDelete_notexisting_part2'] = 'existiert nicht';

$langFile['pageThumbnailDelete_finish_error'] = 'FEHLER: Das Thumbnail konnte nicht gel&ouml;scht werden!';


/* ----------------------------------------------------------------------------------------------
* pageThumbnailUpload.php
*/

// ---------- PAGE THUMBNAIL UPLOAD
$langFile['pagethumbnail_h1_part1'] = 'Seiten-Thumbnail f&uuml;r';
$langFile['pagethumbnail_h1_part2'] = 'hochladen';
$langFile['pagethumbnail_field1'] = 'Bild ausw&auml;hlen';

$langFile['pagethumbnail_thumbinfo_formats'] = 'Nur folgende Dateiformate sind erlaubt<br /><b>JPG</b>, <b>JPEG</b> oder <b>PNG</b>';
$langFile['pagethumbnail_thumbinfo_filesize'] = 'maximale Dateigr&ouml;&szlig;e';
$langFile['pagethumbnail_thumbinfo_standardthumbsize'] = 'Standardbildgr&ouml;&szlig;e';

$langFile['pagethumbnail_thumbsize_h1'] = 'Bildgr&ouml;&szlig;e selbst festlegen';
$langFile['pagethumbnail_thumbsize_width'] = 'Bildbreite';
$langFile['pagethumbnail_thumbsize_height'] = 'Bildh&ouml;he';

$langFile['pagethumbnail_submit_tip'] = 'Bild hochladen';

$langFile['pagethumbnail_upload_error_nofile'] = 'Du hast keine Datei ausgew&auml;hlt.';
$langFile['pagethumbnail_upload_error_nouploadedfile'] = 'Es wurde keine Datei hochgeladen.';
$langFile['pagethumbnail_upload_error_filesize'] = 'Wahrscheinlich ist die hochgeladene Datei zu gro&szlig;.<br />Die maximal erlaubte Dateigr&ouml;&szlig;e betr&auml;gt';
$langFile['pagethumbnail_upload_error_wrongformat'] = 'Die ausgew&auml;hlte Datei hat ein nicht unterst&uuml;tztes Format';
$langFile['pagethumbnail_upload_error_nodir_part1'] = 'Das Thumbnail-Verzeichnis'; // ..thumbnail-folder..
$langFile['pagethumbnail_upload_error_nodir_part2'] = 'existiert nicht oder konnte nicht erstellt werden.';
$langFile['pagethumbnail_upload_error_couldntmovefile_part1'] = 'Konnte die hochgeladene Datei nicht in das Thumbnail-Verzeichnis'; // ..thumbnail-folder..
$langFile['pagethumbnail_upload_error_couldntmovefile_part2'] = 'verschieben.';
$langFile['pagethumbnail_upload_error_changeimagesize'] = 'Die Bildgr&ouml;&szlig;e konnt nicht ge&auml;ndert werden.';
$langFile['pagethumbnail_upload_error_deleteoldfile'] = 'Das alte Thumbnail-Bild konnte nicht gel&ouml;scht werden.';
$langFile['pagethumbnail_upload_response_fileexists'] = 'Es existiert bereits eine Datei mit diesem Namen.<br />Die Hochgeladene Datei wurde umbenannt nach';
$langFile['pagethumbnail_upload_response_finish'] = 'Das Bild wurde erfolgreich hochgeladen.';

/* ----------------------------------------------------------------------------------------------
* search.php
*/

// ---------- SEARCH
$langFile['search_h1'] = 'Seiten durchsuchen';
$langFile['search_results_h1'] = 'Suchergebnisse f&uuml;r';
$langFile['search_results_text1'] = '&Uuml;bereinstimmungen im Titel';
$langFile['search_results_text2'] = '&Uuml;bereinstimmungen im Datum oder der Kategorie';
$langFile['search_results_text3'] = '&Uuml;bereinstimmende W&ouml;rter:';
$langFile['search_results_text4'] = '&Uuml;bereinstimmenden Satz gefunden';
$langFile['search_results_text5'] = '&Uuml;bereinstimmungen im Datum oder der Kategorie';
$langFile['search_results_text6'] = '&Uuml;bereinstimmenden Satz gefunden';
$langFile['search_results_text7'] = '&Uuml;bereinstimmungen im Text';
$langFile['search_results_text8'] = '&Uuml;bereinstimmung mit der Seiten ID';
$langFile['search_results_count'] = 'Treffer';
$langFile['search_results_time_part1'] = 'in'; // 12 Treffer in 0.32 Sekunden
$langFile['search_results_time_part2'] = 'Sekunden';


// -----------------------------------------------------------------------------------------------
// RETURN ****************************************************************************************
// -----------------------------------------------------------------------------------------------
// returns the $langFile var
return $langFile;

?>