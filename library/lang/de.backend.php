<?php
/*
feindura - Flat File Content Management System
Copyright (C) 2009 Fabian Vogelsteller [frozeman.de]

This program is free software;
you can redistribute it and/or modify it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 3 of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY;
without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this program;
if not,see <http://www.gnu.org/licenses/>.

* DE german languagefile for the feindura CMS (BACKEND)
*
* IMPORTANT:
* if you want to write html-code in the toolTip texts (mostly they end with ".._tip" or ".._inputTip")
* use only "[" and "]" instead of "<" and ">" for the HTML-tags and use no " this would end the title="" tag where the toolTip text is in.
*
*
* NEEDS a RETURN $langFile; at the END*/



// ---------------------------------------------------------------------------------------------------------------------
// --- GENERAL

// ---------- thumbnail
$langFile['thumbSize_unit'] = 'Pixel';

$langFile['thumbnail_name'] = 'Seiten-Thumbnail';
$langFile['thumbnail_name_width'] = 'Standard Thumbnail<b>breite</b>';
$langFile['thumbnail_name_height'] = 'Standard Thumbnail<b>h&ouml;he</b>';

$langFile['thumbnail_tip'] = 'Es ist m&ouml;glich das nach dem Upload noch das alte Bild zu sehen ist, das liegt am Browser-Cache.[br /][br /]Um das aktuelle Bild zu sehen musst du einfach die Seite aktualisieren (F5).';

$langFile['thumbnail_width_tip'] = 'Standardbreite::Die Breite des Thumbnails in Pixeln.[br /][br /]Das Bild wird beim hochladen auf diese Gr&ouml;&szlig;e gerechnet.';
$langFile['thumbnail_height_tip'] = 'Standardh&ouml;he::Die H&ouml;he des Thumbnails in Pixeln.[br /][br /]Das Bild wird beim hochladen auf diese Gr&ouml;&szlig;e gerechnet.';

// ---------- stylesheet
$langFile['stylesheet_name_styleFile'] = 'Stylesheet-Datei';
$langFile['stylesheet_name_styleId'] = 'Stylesheet-Id';
$langFile['stylesheet_name_styleClass'] = 'Stylesheet-Klasse';

$langFile['stylesheet_styleFile_tip'] = 'Hier kann eine bestimmte Stylesheet-Datei angegeben werden die der HTML-Editor verwenden soll.';
$langFile['stylesheet_styleId_tip'] = 'Hier kann eine bestimmte Stylesheet-Id angegeben werden die der HTML-Editor verwenden soll.';
$langFile['stylesheet_styleClass_tip'] = 'Hier kann eine bestimmte Stylesheet-Klasse angegeben werden die der HTML-Editor verwenden soll.';

$langFile['stylesheet_styleFile_example'] = '<b>Beispiel</b> &quot;/style/layout.css&quot;';

// ---------- paths

$langFile['path_absolutepath'] = 'Absoluter Pfad';
$langFile['path_relativepath'] = 'Relativer Pfad';
$langFile['path_absolutepath_tip'] = 'Absoluter Pfad::Beginnt mit einem &quot;/&quot;';
$langFile['path_relativepath_tip'] = 'Relativer Pfad::Beginnt ohne &quot;/&quot;';

// ---------- statistic

$langFile['log_searchwordtothissite_part1'] = 'hat'; // "wort" hat 20 mal auf diese Seite geführt
$langFile['log_searchwordtothissite_part2'] = 'mal auf diese Seite gef&uuml;hrt';

$langFile['log_visitCount'] = 'Besucher';
$langFile['log_visitTime_max'] = 'l&auml;ngste Verweildauer';
$langFile['log_visitTime_min'] = 'k&uuml;rzeste Verweildauer';
$langFile['log_firstVisit'] = 'erster Besuch';
$langFile['log_lastVisit'] = 'letzter Besuch';
$langFile['log_novisit'] = 'Es hat noch niemand diese Seite besucht.';
$langFile['log_tags_description'] = 'Suchworte die von
<a href="http://www.google.de">Google</a>,
<a href="http://www.yahoo.de">Yahoo</a> oder
<a href="http://www.bing.com">Bing (MSN)</a> auf diese Seite gef&uuml;hrt haben';
$langFile['log_tags_description_tip'] = 'Die Zahl in Klammern zeigt an, wie oft dieses Suchwort auf diese Seite zu gef&uuml;hrt hat.';
$langFile['log_notags'] = 'Es haben noch keine Suchworte auf diese Seite gef&uuml;hrt.';

$langFile['log_hour_single'] = 'Stunde';
$langFile['log_hour_multiple'] = 'Stunden';
$langFile['log_minute_single'] = 'Minute';
$langFile['log_minute_multiple'] = 'Minuten';
$langFile['log_second_single'] = 'Sekunde';
$langFile['log_second_multiple'] = 'Sekunden';

// ---------- deleting

$langFile['delete_question_submit'] = 'Ja bitte l&ouml;schen!';
$langFile['delete_question_cancel'] = 'Nein doch nicht';

// ----------- page/category public/nonpuplic

$langFile['status_page_public'] = 'Seite ist &ouml;ffentlich';
$langFile['status_page_nonpublic'] = 'Seite ist versteckt';

$langFile['status_category_public'] = 'Kategorie ist &ouml;ffentlich';
$langFile['status_category_nonpublic'] = 'Kategorie ist versteckt';

// ---------------------------------------------------------------------------------------------------------------------
// index.php
//
// --------- BUTTON-TEXT
// --- mainMenu
$langFile['btn_home'] = '&Uuml;bersicht';
$langFile['btn_pages'] = 'Kategorien und Seiten';
$langFile['btn_addons'] = 'Addons';
$langFile['btn_settings'] = 'Webseiten Einstellungen';
$langFile['btn_search'] = 'Seiten durchsuchen';

// --- adminMenu
$langFile['title_adminMenu'] = 'Administration';
$langFile['btn_adminSetup'] = 'Administrator Einstellungen';
$langFile['btn_categorySetup'] = 'Kategorien Verwaltung';
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

// ---------- FEINDURA

$langFile['txt_logo'] = 'feindura CMS, Version ';
$langFile['txt_loading'] = 'Seite wird geladen..';


// ---------------------------------------------------------------------------------------------------------------------
// sidebar.loader.php
//
// ---------- QUICKMENU

$langFile['btn_quickmenu_categories'] = 'Kategorien';
$langFile['btn_quickmenu_pages'] = 'Seiten von';

// ---------------------------------------------------------------------------------------------------------------------
// ---------- ERROR TEXTs

$langFile['error_save_settings'] = '<b>Die Einstellungen konnten nicht gespeichert werden.</b>';
$langFile['error_save_file'] = '<br /><br />Bitte &uuml;berpr&uuml;fe die Schreibrechte der Datei: ';

$langFile['error_read_folder_part1'] = '<br /><br />Bitte &uuml;berpr&uuml;fe die Leserechte des &quot;';
$langFile['error_save_folder_part1'] = '<br /><br />Bitte &uuml;berpr&uuml;fe die Schreibrechte des &quot;';

$langFile['error_folder_end'] = '&quot; Ordners dessen Unterordner und Dateien.';
$langFile['error_folderDatabase_end'] = '&quot; Ordners dessen Unterordner und Dateien oder die Datenbank.';


// ---------------------------------------------------------------------------------------------------------------------
//
// ---------- WARNINGs

$langFile['warning_startPageWarning_h1'] = 'Die Startseite ist nicht festgelegt!';
$langFile['warning_startPageWarning'] = 'Bitte lege eine Seite als Startseite fest.<br />Gehe zu <a href="?site=pages">'.$langFile['btn_pages'].'</a> und klicke bei der gew&uuml;nschten Seite auf das <span class="startPageIcon"></span> Symbol';


$langFile['warning_fmsConfWarning_h1'] = '<span class="logoname">fein<span>dura</span></span> wurde noch nicht konfiguriert!';
$langFile['warning_fmsConfWarning'] = 'Der <i>Basispfad</i> stimmt nicht mit dem in den Administrator Einstellungen angegebenen Pfad &uuml;berein.<br />
Bitte gehe in die <a href="?site=adminSetup">Administrator Einstellungen</a> und konfiguriere dein <span class="logoname">fein<span>dura</span></span> CMS';

$langFile['warning_jsWarning_h1'] = 'Bitte aktiviere Javascript';
// no <p> tag on the start and the end, its already in the home.php
$langFile['warning_jsWarning'] = '<strong>Um <span class="logoname">fein<span>dura</span></span> voll nutzen zu k&ouml;nnen muss Javascript aktiviert sein!</strong></p>
<h2>im Firefox</h2>
<p>Klicke in der obersten Men&uuml;leiste auf &quot;Extras&quot; &gt; &quot;Einstellungen&quot;. Unter Inhalt aktivierst du den Punkt &quot;JavaScript aktivieren&quot; und best&auml;tigst dann mit OK.</p>
<h2>im Internet Explorer</h2>
<p>Klicke in der obersten Men&uuml;leiste auf &quot;Extras&quot; &gt; &quot;Internetoptionen&quot;.<br />
Dort klickst du unter Sicherheit entweder auf &quot;Standardstufe&quot;, oder w&auml;hle &quot;Stufe anpassen&quot; und aktivieren dann unter Scripting den Punkt &quot;Active Scripting Aktivieren&quot;. Best&auml;tige mit OK.</p>
<h2>im Safari</h2>
<p>Klicke in der obersten Men&uuml;leiste auf das Symbol ganz rechts, w&auml;hle &quot;Einstellungen&quot;. Unter &quot;Sicherheit&quot; aktivierst du den Punkt &quot;JavaScript aktivieren&quot; und klicke zum best&auml;tigen auf OK.</p>
<h2>im Mozilla</h2>
<p>Klicke in der obersten Men&uuml;leiste auf &quot;Edit&quot; &gt; &quot;Preferences&quot;. Unter dem Punkt &quot;Advanced&quot; &gt; &quot;Scripts &amp; Plugins&quot; kreuze &quot;Navigator&quot; an. Best&auml;tige mit OK.</p>
<h2>im Opera</h2>
<p>Klicke in der obersten Men&uuml;leiste auf &quot;Extras&quot; &gt; &quot;Einstellungen&quot;. Unter &quot;Erweitert&quot; &gt; &quot;Inhalte&quot; setze ein Haken bei &quot;JavaScript aktivieren&quot; und klicke dann OK.';

// ---------------------------------------------------------------------------------------------------------------------
// home.php
//
// ---------- HOME

$langFile['txt_home_userInfo_h1'] = 'Benutzer Information';

$langFile['txt_home_welcome_h1'] = 'Willkommen in <span class="logoname">fein<span>dura</span></span>, dem Content Management System deiner Webseite.';
$langFile['txt_home_welcome'] = '<span class="logoname">fein<span>dura</span></span> ist ein auf <span title="Flatfiles::sind Dateien auf dem Server, in denen der Inhalt der Webseite gespeichert wird." class="toolTip mark" >Flatfiles</span> basierendes Content Management System.<br />Hier kannst du den Inhalt deiner Webseite verwalten.';


// ---------------------------------------------------------------------------------------------------------------------
// pages.php
//
// ---------- PAGES SORTABLE LIST

$langFile['sortablePageList_h1'] = 'Der Inhalt deiner Webseite';
$langFile['sortablePageList_headText1'] = '';
$langFile['sortablePageList_headText2'] = 'zuletzt bearbeitet';
$langFile['sortablePageList_headText3'] = 'Besucher';
$langFile['sortablePageList_headText4'] = 'Status';
$langFile['sortablePageList_headText5'] = 'Funktionen';

$langFile['sortablePageList_sortDate'] = 'Seiten-Datum';
$langFile['sortablePageList_tags'] = 'Tags';

$langFile['sortablePageList_sortOrder_manuell'] = 'manuelle Sortierung';
$langFile['sortablePageList_sortOrder_date'] = 'sortiert nach Datum';

$langFile['sortablePageList_functions_editPage'] = 'Seite bearbeiten';
$langFile['sortablePageList_functions_deletePage'] = 'Seite l&ouml;schen';

$langFile['sortablePageList_changeStatus_linkPage'] = 'Hier klicken um den Status f&uuml;r Seite zu &auml;ndern.';
$langFile['sortablePageList_changeStatus_linkCategory'] = 'Hier klicken um den Status f&uuml;r die Kategorie zu &auml;ndern.';

$langFile['file_error_read'] = '<b>Die Seite konnte nicht gelesen werden.</b>'.$langFile['error_read_folder_part1'].$adminConfig['basePath'].$adminConfig['savePath'].$langFile['error_folderDatabase_end'];
$langFile['sortablePageList_setStartPage_error_save'] = '<b>Die Startseite konnte nicht festgelegt werden.</b>'.$langFile['error_save_file'].' &quot;'.$adminConfig['basePath'].'config/websiteConfig.php&quot;';
$langFile['sortablePageList_changeStatusPage_error_save'] = '<b>Der Status der Seite konnte nicht ge&auml;ndert werden.</b>'.$langFile['error_save_folder_part1'].$adminConfig['basePath'].$adminConfig['savePath'].$langFile['error_folderDatabase_end'];
$langFile['sortablePageList_changeStatusCategory_error_save'] = '<b>Der Status der Seite konnte nicht ge&auml;ndert werden.</b>'.$langFile['error_save_folder_part1'].$adminConfig['basePath'].$adminConfig['savePath'].$langFile['error_folderDatabase_end'];

$langFile['sortablePageList_info'] = 'Du kannst per <b>Drag and Drop</b> die <b>Seiten Anordnung</b> ver&auml;ndern und auch Seiten zwischen den Kategorien verschieben.';
$langFile['sortablePageList_save'] = 'Speichere die neue Anordnung ...';
$langFile['sortablePageList_save_finished'] = '<span style=\'font-weight:bold;font-size:18px;\'>Neu Anordnung erfolgreich gespeichert!</span>';
$langFile['sortablePageList_error_save'] = '<b>Die Seiten konnten nicht gespeichert werden.</b>'.$langFile['error_save_folder_part1'].$adminConfig['basePath'].$adminConfig['savePath'].$langFile['error_folder_end'];
$langFile['sortablePageList_error_read'] = '<b>Die Seiten konnten nicht gelesen werden.</b>'.$langFile['error_read_folder_part1'].$adminConfig['basePath'].$adminConfig['savePath'].$langFile['error_folder_end'];
$langFile['sortablePageList_error_move'] = '<b>Konnte die Seite nicht in die neue Kategorie verschieben.</b>'.$langFile['error_save_folder_part1'].$adminConfig['basePath'].$adminConfig['savePath'].$langFile['error_folder_end'];
$langFile['sortablePageList_categoryEmpty'] = 'Keine Seiten vorhanden';

// ---------- FORMULAR
$langFile['form_submit'] = 'Speichern';
$langFile['form_cancel'] = 'Alle Eingaben l&ouml;schen';

// ---------- ERRORWINDOW
$langFile['form_errorWindow_h1'] = 'Ein Fehler ist aufgetreten!';


// ---------------------------------------------------------------------------------------------------------------------
// adminSetup.php
//
// ---------- ADMIN SETUP (on toolTips tooTips.js converts the "[" and "]" tags in the title attribute to "<" ">")

$langFile['adminSetup_version'] = '<span class="logoname">fein<span>dura</span></span> Version';
$langFile['adminSetup_phpVersion'] = 'PHP Version';
$langFile['adminSetup_srvRootPath'] = 'Server-Root-Pfad';
$langFile['adminSetup_writeAccess'] = 'Bei folgenden Dateien und Verzeichnissen m&uuml;ssen die Schreibrechte auf <span class="toolTip" title="Schreibrechte::Besitzer[br /][small]Lesen/Schreiben/Ausf&uuml;hren[/small][br /]Gruppen[br /][small]Lesen/Ausf&uuml;hren[/small][br /]&Ouml;ffentlich[br /][small]Lesen/Ausf&uuml;hren[/small]" style="text-decoration: underline;">755</span> gesetzt werden';

$langFile['txt_adminSetup_writeAccess_error'] = 'ist nicht beschreibbar';

// ---------- FMS Settings
$langFile['adminSetup_fmsSettings_error_save'] = $langFile['websiteSetup_websiteConfig_error_save'] = $langFile['error_save_settings'].$langFile['error_save_file'].$adminConfig['basePath'].'config/adminConfig.php';

$langFile['adminSetup_fmsSettings_h1'] = 'Grund Einstellungen';
$langFile['adminSetup_fmsSettings_feld1'] = 'Webseiten URL';
$langFile['adminSetup_fmsSettings_feld1_tip'] = 'Die URL ihrer Webseite wird automatisch eingef&uuml;gt.';
$langFile['adminSetup_fmsSettings_feld1_inputTip'] = 'Der Pfad wird automatisch eingef&uuml;gt';
$langFile['adminSetup_fmsSettings_feld1_inputWarningText'] = 'Bitte speichere die Einstellungen!';
$langFile['adminSetup_fmsSettings_feld2'] = 'Hauptpfad';
$langFile['adminSetup_fmsSettings_feld2_tip'] = 'Der Hauptpfad wird automatisch ermittelt und beim Speichern der Einstellungen &uuml;bernommen.';
$langFile['adminSetup_fmsSettings_feld2_inputTip'] = 'Der Pfad wird automatisch eingef&uuml;gt';
$langFile['adminSetup_fmsSettings_feld2_inputWarningText'] = 'Bitte speichere die Einstellungen!';
$langFile['adminSetup_fmsSettings_feld3'] = 'Speicherpfad';
$langFile['adminSetup_fmsSettings_feld3_tip'] = 'Der [b]relative Pfad[/b] wo die Flatfiles mit dem Seiteninhalt gespeichert werden.';
$langFile['adminSetup_fmsSettings_feld3_inputTip'] = 'Relativer Pfad::Relativ zum [b]'.$adminConfig['basePath'].'[/b] Ordner.[br /][br /]Beginnt ohne &quot;/&quot;';
$langFile['adminSetup_fmsSettings_feld4'] = 'Daten Upload Pfad';
$langFile['adminSetup_fmsSettings_feld4_tip'] = '[b]Absoluter Pfad[/b]. Hier werden die Dateien wie Bilder, Flash-Animation oder Dokumente hochgeladen.[br /][br /]Es werden automatisch Unterordner f&uuml;r die Dateitypen erstellt[br /](images, flash, files)[br /][br /][span class=hint]Dateien werden im HTML-Editor unter Link-einf&uuml;gen &gt; Upload hochgeladen.[/span]';
$langFile['adminSetup_fmsSettings_feld5'] = 'Sprachdateien Pfad';
$langFile['adminSetup_fmsSettings_feld5_tip'] = 'Der [b]absolute Pfad[/b] in dem die Sprachdateien f&uuml;r die Webseite gespeichert werden, damit man diese aus dem FMS heraus bearbeiten kann (siehe weiter unten).';
$langFile['adminSetup_fmsSettings_feld6'] = 'Stylesheetdateien Pfad';
$langFile['adminSetup_fmsSettings_feld6_tip'] = 'Der [b]absolute Pfad[/b] wo sich die Stylesheet-Dateien der Webseite befinden, damit man diese aus dem FMS heraus bearbeiten kann (siehe weiter unten).';
$langFile['adminSetup_fmsSettings_varName1'] = 'Seiten Variablenname';
$langFile['adminSetup_fmsSettings_varName1_inputTip'] = 'Wenn das Feld leer ist, wird der Standard Name f&uuml;r die GET-Variablen verwendet: &quot;[b]page[/b]&quot;';
$langFile['adminSetup_fmsSettings_varName2'] = 'Kategorie Variablenname';
$langFile['adminSetup_fmsSettings_varName2_inputTip'] = 'Wenn das Feld leer ist, wird der Standard Name f&uuml;r die GET-Variablen verwendet: &quot;[b]category[/b]&quot;';
$langFile['adminSetup_fmsSettings_varName3'] = 'Modul Variablenname';
$langFile['adminSetup_fmsSettings_varName3_inputTip'] = 'Wenn das Feld leer ist, wird der Standard Name f&uuml;r die GET-Variablen verwendet: &quot;[b]modul[/b]&quot;';
$langFile['adminSetup_fmsSettings_varName_tip'] = 'Der Name der [b]$_GET Variable[/b] die in der feindura Klasse verwendet wird.';
$langFile['adminSetup_fmsSettings_feld7'] = 'Datumsformat';
$langFile['adminSetup_fmsSettings_feld7_tip'] = 'Das verwendete Datumsformat.[br /]Entweder:[br /]DIN 5008 ('.$langFile['date_eu'].') oder[br /]ISO 8601 ('.$langFile['date_int'].')';

// ---------- user Settings

$langFile['adminSetup_userSettings_h1'] = 'Benutzer Einstellungen';
$langFile['adminSetup_userSettings_check1'] = 'Sprachdateien bearbeiten, in den Webseiten Einstellungen anzeigen';
$langFile['adminSetup_userSettings_check2'] = 'Stylesheetdateien bearbeiten, in den Webseiten Einstellungen anzeigen';

$langFile['adminSetup_userSettings_textarea1'] = '<strong>Benutzerinformation</strong> auf der <a href="?site=home">Startseite</a> anzeigen';
$langFile['adminSetup_userSettings_textarea1_tip'] = 'Benutzerinformationen::Diese zus&auml;tzlichen Informationen werden auf der Startseite angezeigt.';
$langFile['adminSetup_userSettings_textarea1_inputTip'] = 'Lasse das Feld leer wenn Du keine Informationen f&uuml;r den Benutzer anzeigen m&ouml;chtest';

// ---------- pageSettings

$langFile['adminSetup_pageSettings_h1'] = 'Seiten Einstellungen';
$langFile['adminSetup_pageSettings_check1'] = 'Startseite ist einstellbar';
$langFile['adminSetup_pageSettings_check1_tip'] = 'Legt fest ob der Benutzer die Startseite selbst festlegen kann.';
$langFile['adminSetup_pageSettings_check2'] = 'Seiten erstellen/l&ouml;schen anzeigen';
$langFile['adminSetup_pageSettings_check2_tip'] = 'Legt fest ob der Benutzer, au&szlig;erhalb der Kategorien, Seiten erstellen und l&ouml;schen kann.';
$langFile['adminSetup_pageSettings_check3'] = 'Thumbnail hochladen anzeigen';
$langFile['adminSetup_pageSettings_check3_tip'] = 'Legt fest ob der Benutzer, au&szlig;erhalb der Kategorien, Seiten-Thumbnails hochladen kann.';

// ---------- editor Settings

$langFile['adminSetup_editorSettings_h1'] = 'HTML-Editor Einstellungen';
$langFile['adminSetup_editorSettings_feld1'] = 'ENTER-Taste Modus';
$langFile['adminSetup_editorSettings_feld1_tip'] = 'Legt fest welcher HTML-Tag beim dr&uuml;cken der ENTER-Taste gesetzt [br]werden soll.[br /][br /][span class=hint]Mit SHIFT + ENTER wird standard m&auml;&szlig;ig ein &lt;br&gt; gesetzt.[/span]';
$langFile['adminSetup_editorSettings_feld1_inputTip'] = '&quot;p&quot;, &quot;br&quot;';
$langFile['adminSetup_editorSettings_feld3_inputTip'] = 'Wenn das Feld leer ist wird keine Id verwendet.';
$langFile['adminSetup_editorSettings_feld4_inputTip'] = 'Wenn das Feld leer ist wird keine Klasse verwendet.';

// ---------- thumbnail Settings

$langFile['adminSetup_thumbnailSettings_h1'] = 'Seiten-Thumbnail Einstellungen';
$langFile['adminSetup_thumbnailSettings_feld3'] = 'Speicherpfad'; // Thumbnail-Speicherpfad
$langFile['adminSetup_thumbnailSettings_feld3_tip'] = 'Der Pfad oder Verzeichnisname innerhalb des Daten Upload Pfad';
$langFile['adminSetup_thumbnailSettings_feld3_inputTip1'] = 'Der Daten Upload Pfad';
$langFile['adminSetup_thumbnailSettings_feld3_inputTip2'] = 'Relativer Pfad::Relativ zum &quot;[b]'.$adminConfig['uploadPath'].'image/[/b]&quot; Ordner.[br /][br /]Beginnt ohne &quot;/&quot;';
$langFile['adminSetup_thumbnailSettings_feld3_inputTip3'] = '<b>Beispiel</b> &quot;thumbnails/&quot; ';

// ---------- styleFile Settings

$langFile['adminSetup_styleFileSettings_h1'] = 'HTML-Editor &quot;Stil-Auswahl&quot; bearbeiten (htmlEditorStyles.xml)';
$langFile['adminSetup_styleFileSettings_error_save'] = '<b>Die Datei &quot;htmlEditorStyles.xml&quot; konnte nicht gespeichert werden.</b>'.$langFile['error_save_file'];

// ---------- editFiles Settings

$langFile['editFilesSettings_error_save'] = '<b>Die Datei konnte nicht gespeichert werden.</b>'.$langFile['error_save_file'];

$langFile['editFilesSettings_h1_style'] = 'Stylesheetdateien bearbeiten';
$langFile['editFilesSettings_h1_lang'] = 'Sprachdateien bearbeiten';
$langFile['editFilesSettings_noDir'] = 'ist kein g&uuml;ltiges Verzeichnis!';
$langFile['editFilesSettings_chooseFile'] = 'Datei ausw&auml;hlen';
$langFile['editFilesSettings_createFile'] = 'Neue Datei anlegen';
$langFile['editFilesSettings_createFile_inputTip'] = 'Wenn hier ein Dateiname eingetragen wird, dann wird eine Neue Datei erstellt,[br /]und [b]die derzeit ausgew&auml;hlte Datei wird nicht gespeichert![/b]';
$langFile['editFilesSettings_noFile'] = 'Es sind noch keine Dateien vorhanden';

// ---------------------------------------------------------------------------------------------------------------------
// categorySetup.php
//
// ---------- CATEGORY SETUP (on toolTips tooTips.js converts the "[" and "]" tags in the title attribute to "<" ">")

$langFile['categorySetup_h1'] = 'Kategorien Verwaltung';
$langFile['categorySetup_createCategory'] = 'Neue Kategorie erstellen';
$langFile['categorySetup_createCategory_created'] = 'Neue Kategorie erstellt';

$langFile['categorySetup_deleteCategory'] = 'Kategorie l&ouml;schen';
$langFile['categorySetup_deleteCategory_warning'] = 'ACHTUNG: Es werden auch alle Seiten innerhalb dieser Kategorie gel&ouml;scht!';
$langFile['categorySetup_deleteCategory_deleted'] = 'Kategorie gel&ouml;scht';

$langFile['categorySetup_moveCategory_moved'] = 'Kategorie verschoben';
$langFile['categorySetup_moveCategory_up_tip'] = 'Kategorie nach oben verschieben';
$langFile['categorySetup_moveCategory_down_tip'] = 'Kategorie nach unten verschieben';

$langFile['categorySetup_error_create'] = '<b>Eine neue Kategorie konnte nicht erstellt werden.</b>'.$langFile['error_save_folder_part1'].$adminConfig['basePath'].'config/'.$langFile['error_folderDatabase_end'];
$langFile['categorySetup_error_createDir'] = '<b>Konnte keine neues Kategorie-Verzeichnis erstellen.</b>'.$langFile['error_save_folder_part1'].$adminConfig['basePath'].$adminConfig['savePath'].'&quot; Ordners.';
$langFile['categorySetup_error_delete'] = '<b>Die Kategorie konnte nicht gel&ouml;scht werden.</b>'.$langFile['error_save_file'].$adminConfig['basePath'].'config/categoryConfig.php';
$langFile['categorySetup_error_deleteDir'] = '<b>Konnte das Kategorie-Verzeichnis nicht l&ouml;schen.</b>'.$langFile['error_save_folder_part1'].$adminConfig['basePath'].$adminConfig['savePath'].$langFile['error_folder_end'];
$langFile['categorySetup_error_save'] = $langFile['error_save_settings'].$langFile['error_save_file'].$adminConfig['basePath'].'config/categoryConfig.php';


$langFile['categorySetup_advancedSettings'] = 'Erweiterte Einstellungen';
$langFile['categorySetup_advancedSettings_hint'] = 'Diese Einstellungen, wenn ausgef&uuml;llt, &uuml;berschreiben die Editor und Thumbnail Einstellungen weiter oben';

$langFile['categorySetup_feld1'] = 'Name';
$langFile['categorySetup_stylesheet_ifempty'] = 'Wenn das Feld leer ist dann werden die Standard Stylesheet-Einstellungen aus den HTML-Editor Einstellungen verwendet.';

$langFile['categorySetup_check1'] = 'Status der Kategorie';
$langFile['categorySetup_check1_tip'] = 'Legt fest ob die Kategorie auf der Webseite angezigt wird oder nicht,[br /]das kann vorallem sinnvoll bei News oder anderen kurzweiligen Informationen sein.';
$langFile['categorySetup_check2'] = 'Seiten erstellen/l&ouml;schen';
$langFile['categorySetup_check2_tip'] = 'Der Benutzer kann in dieser Kategorie Seiten erstellen und l&ouml;schen.';
$langFile['categorySetup_check3'] = 'Thumbnail hochladen';
$langFile['categorySetup_check3_tip'] = 'Der Benutzer hat die M&ouml;glichkeit ein Thumbnail f&uuml;r jede Seite in dieser Kategorie hochzuladen.';
$langFile['categorySetup_check4'] = 'Datum f&uuml;r die Seiten festlegen';
$langFile['categorySetup_check4_tip'] = 'Das G&uuml;ltigkeitsdatum kann dazu verwendet werden Seiten auf der Webseite nach Datum zu sortieren';

$langFile['categorySetup_check5'] = 'Seiten nach Datum sortieren';
$langFile['categorySetup_check5_tip'] = 'Die Seiten werden nach einem angegeben Datum sortiert.[br /][br /][span class=hint]Manuelles Sortieren ist nicht mehr m&ouml;glich.[/span]';

$langFile['categorySetup_check6'] = 'Neuste Seite immer bis unten anzeigen';
$langFile['categorySetup_check6_tip'] = 'Sortiert die Seiten automatisch [b]aufsteigend[/b].[br /][br /][span class=hint]Manuelles Sortieren &uuml;berschreibt diese Einstellung f&uuml;r die jeweilige Seite.[/span]';


// ---------- deleting category

$langFile['categorySetup_question_part1'] = 'Kategorie'; // Kategorie "test" löschen?
$langFile['categorySetup_question_part2'] = 'l&ouml;schen?';

$langFile['categorySetup_question_ok'] = 'Ja bitte l&ouml;schen!';
$langFile['categorySetup_question_cancel'] = 'Nicht l&ouml;schen';

// ---------------------------------------------------------------------------------------------------------------------
// websiteSetup.php
//
// ---------- WEBSITE SETUP (on toolTips tooTips.js converts the "[" and "]" tags in the tittle attribute to "<" ">")

$langFile['websiteSetup_websiteConfig_error_save'] = $langFile['error_save_settings'].$langFile['error_save_file'].$adminConfig['basePath'].'config/websiteConfig.php';

$langFile['websiteSetup_websiteConfig_h1'] = 'Webseiten Einstellungen';
$langFile['websiteSetup_websiteConfig_feld1'] = 'Webseiten Titel';
$langFile['websiteSetup_websiteConfig_feld1_tip'] = 'Der Titel der Webseite wird oben in der Browserleiste angezeigt.';
$langFile['websiteSetup_websiteConfig_feld2'] = 'Ver&ouml;ffentlicher';
$langFile['websiteSetup_websiteConfig_feld2_tip'] = 'Der Name der Organisation/Firma/Person die diese Seite ver&oumlffentlicht.';
$langFile['websiteSetup_websiteConfig_feld3'] = 'Copyright';
$langFile['websiteSetup_websiteConfig_feld3_tip'] = 'Der copyright Besitzer der Webseite.';

$langFile['websiteSetup_websiteConfig_feld4'] = 'Suchmaschinen Stichworte';
$langFile['websiteSetup_websiteConfig_feld4_tip'] = 'Die meisten Suchmaschienen durchsuchen den Seiteninhalt nach Stichworten, jedoch sollte man einige Schl&uuml;sselw&ouml;rter hier auff&uuml;hren.';
$langFile['websiteSetup_websiteConfig_feld4_inputTip'] = 'Die Stichworte m&uuml;ssen mit &quot;,&quot; getrennt werden.::Beispiel:[br /]stichwort1,stichwort2,etc';
$langFile['websiteSetup_websiteConfig_feld5'] = 'Webseiten Beschreibung';
$langFile['websiteSetup_websiteConfig_feld5_tip'] = 'Ist eine kurze Beschreibung die in den Suchmaschienen auftaucht wenn man nach der Webseiten-Adresse sucht oder keine Stichworte im Text gefunden wurden.';
$langFile['websiteSetup_websiteConfig_feld5_inputTip'] = 'Ein kurzer Text mit nicht mehr als 3 Zeilen.';
$langFile['websiteSetup_websiteConfig_feld6'] = 'E-Mail Adresse';
$langFile['websiteSetup_websiteConfig_feld6_tip'] = 'Diese E-Mail Adresse wird f&uuml;r alle wichtigen Kontaktm&ouml;glichkeiten verwendet[br /](z.B. Kontaktformulare etc.)';
$langFile['websiteSetup_websiteConfig_feld6_inputTip'] = 'Beispiel::name@providor.de';

// ---------------------------------------------------------------------------------------------------------------------
// editor.php
//
// ---------- EDITOR

$langFile['editor_h1_savedate'] = 'zuletzt bearbeitet am';
$langFile['editor_h1_createpage'] = 'Neue Seite erstellen';
$langFile['editor_h1_linktothispage'] = 'Link zu dieser Seite';
$langFile['editor_h1_id'] = 'Seiten ID';
$langFile['editor_h1_id_tip'] = 'Unter der Seiten ID wird die Seite auf dem Server oder in der Datenbank gespeichert.';
$langFile['editor_h1_categoryid'] = 'Kategorie ID';
$langFile['editor_h1_categoryid_noCategory'] = 'keine Kategorie';

$langFile['editor_pageSettings_h1'] = 'Seiten Einstellungen';
$langFile['editor_pagestatistics_h1'] = 'Seiten Statistik';

$langFile['editor_pageSettings_feld1'] = 'Seitentitel';
$langFile['editor_pageSettings_feld1_tip'] = 'Der Titel der Seite';
$langFile['editor_pageSettings_feld2'] = 'Tags';
$langFile['editor_pageSettings_feld2_tip'] = 'Tags sind Stichworte die mit der Seite verkn&uuml;pft sind.[br /][br /]Wof&uuml;r diese verwendet werden entscheidet der Webdesigner.';
$langFile['editor_pageSettings_feld2_tip_inputTip'] = 'Die Stichworte sollten mit [b]Leerzeichen[/b] getrennt werden.';
$langFile['editor_pageSettings_feld3'] = 'Seitendatum';
$langFile['editor_pageSettings_feld3_tip'] = 'Das Datum kann dazu verwendet werden Seiten nach Aktualit&auml;t zu sortieren. (z.B. bei Veranstaltungen)';
$langFile['editor_pageSettings_feld3_inpuTip_part1'] = 'Text vor dem Datum::z.B. vom Tag/Monat';
$langFile['editor_pageSettings_feld3_inpuTip_part2'] = '[b]Format[/b]';
$langFile['editor_pageSettings_feld3_inpuTip_part3'] = 'Text nach dem Datum::';
$langFile['editor_pageSettings_feld4'] = 'Status der Seite';
$langFile['editor_pageSettings_feld4_tip'] = '[b]Nur wenn die Seite &ouml;ffentlich ist wird diese auf der Webseite angezeigt![/b]';

$langFile['editor_pageSettings_sortDate_error'] = 'Fehlerhaftes Datumsformat';
$langFile['editor_pageSettings_sortDate_error_tip'] = 'Das Datum muss folgendes Format haben:';

$langFile['editor_advancedpageSettings_h1'] = 'Erweiterte Seiten Einstellungen';

$langFile['editor_advancedpageSettings_feld1'] = 'Seiten Stylesheet-Datei';
$langFile['editor_advancedpageSettings_feld1_tip'] = 'Hier kann eine bestimmte Stylesheet-Datei angegeben werden die diese Seite in dem HTML-Editor verwenden soll.[br /][br /]Wenn das Feld leer ist dann wird die Standard Stylesheet-Datei aus den HTML-Editor Einstellungen verwendet.';
$langFile['editor_advancedpageSettings_feld1_inputTip2'] = '<b>Beispiel</b> &quot;/style/layout.css&quot; ';
$langFile['editor_advancedpageSettings_feld3'] = 'Seiten Stylesheet-Id';
$langFile['editor_advancedpageSettings_feld3_tip'] = 'Hier kann eine bestimmte Stylesheet-Id angegeben werden die diese Seite in dem HTML-Editor verwenden soll.';
$langFile['editor_advancedpageSettings_feld3_inputTip'] = 'Wenn das Feld leer ist dann wird die Standard Stylesheet-Id aus den HTML-Editor Einstellungen verwendet.';
$langFile['editor_advancedpageSettings_feld4'] = 'Seiten Stylesheet-Klasse';
$langFile['editor_advancedpageSettings_feld4_tip'] = 'Hier kann eine bestimmte Stylesheet-Klasse angegeben werden die diese Seite in dem HTML-Editor verwenden soll.';
$langFile['editor_advancedpageSettings_feld4_inputTip'] = 'Wenn das Feld leer ist dann wird die Standard Stylesheet-Klasse aus den HTML-Editor Einstellungen verwendet.';

$langFile['editor_htmleditor_hotkeys_h1'] = 'Tastenk&uuml;rzel';
$langFile['editor_htmleditor_hotkeys_feld1'] = 'Alles markieren';
$langFile['editor_htmleditor_hotkeys_feld2'] = 'Kopieren';
$langFile['editor_htmleditor_hotkeys_feld3'] = 'Einf&uuml;gen';
$langFile['editor_htmleditor_hotkeys_feld4'] = 'Ausschneiden';
$langFile['editor_htmleditor_hotkeys_feld5'] = 'R&uuml;ckg&auml;ngig';
$langFile['editor_htmleditor_hotkeys_feld6'] = 'Wiederherstellen';
$langFile['editor_htmleditor_hotkeys_feld7'] = 'Link setzen';
$langFile['editor_htmleditor_hotkeys_feld8'] = 'Fett';
$langFile['editor_htmleditor_hotkeys_feld9'] = 'Kursiv';
$langFile['editor_htmleditor_hotkeys_feld10'] = 'Unterstrichen';
$langFile['editor_htmleditor_hotkeys_or'] = 'oder';

$langFile['editor_savepage_error_save'] = '<b>Die Seite konnte nicht gespeichert werden.</b>'.$langFile['error_save_folder_part1'].$adminConfig['basePath'].$adminConfig['savePath'].$langFile['error_folderDatabase_end'];

// ---------------------------------------------------------------------------------------------------------------------
// deletePage.php
//
// ---------- DELETE PAGE

$langFile['deletePage_question_part1'] = 'M&ouml;chtest du die Seite';
$langFile['deletePage_question_part2'] = 'wirklich l&ouml;schen?';

$langFile['deletePage_finishnotexisting_part1'] = 'Die Seite';
$langFile['deletePage_finish_part2'] = 'wurde erfolgreich gel&ouml;scht';
$langFile['deletePage_notexisting_part2'] = 'existiert nicht';

$langFile['deletePage_finish_error'] = 'FEHLER: Die Seite konnte nicht gel&ouml;scht werden!';

// ---------------------------------------------------------------------------------------------------------------------
// pageThumbnailDelete.php
//
// ---------- PAGE THUMBNAIL DELETE

$langFile['pageThumbnailDelete_question_part1'] = 'M&ouml;chtest du das Thumbnail von der Seite';
$langFile['pageThumbnailDelete_question_part2'] = 'wirklich l&ouml;schen?';

$langFile['pageThumbnailDelete_finishnotexisting_part1'] = 'Der Thumbnail';
$langFile['pageThumbnailDelete_finish_part2'] = 'wurde erfolgreich gel&ouml;scht';
$langFile['pageThumbnailDelete_notexisting_part2'] = 'existiert nicht';

$langFile['pageThumbnailDelete_finish_error'] = 'FEHLER: Das Thumbnail konnte nicht gel&ouml;scht werden!';


// ---------------------------------------------------------------------------------------------------------------------
// pageThumbnailUpload.php
//
// ---------- PAGE THUMBNAIL UPLOAD

$langFile['pagethumbnail_h1_part1'] = 'Seiten-Thumbnail f&uuml;r';
$langFile['pagethumbnail_h1_part2'] = 'hochladen';
$langFile['pagethumbnail_feld1'] = 'Bild ausw&auml;hlen';

$langFile['pagethumbnail_thumbinfo_formats'] = 'Nur folgende Dateiformate sind erlaubt<br /><b>JPG</b>, <b>JPEG</b> oder <b>PNG</b>';
$langFile['pagethumbnail_thumbinfo_filesize'] = 'Die Datei darf nicht gr&ouml;&szlig;er sein als';
$langFile['pagethumbnail_thumbinfo_standardthumbsize'] = 'Standardbildgr&ouml;&szlig;e';

$langFile['pagethumbnail_thumbsize_h1'] = 'Bildgr&ouml;&szlig;e selbst festlegen';
$langFile['pagethumbnail_thumbsize_width'] = 'Bildbreite';
$langFile['pagethumbnail_thumbsize_height'] = 'Bildh&ouml;he';

$langFile['pagethumbnail_submit_tip'] = 'Bild hochladen';

$langFile['pagethumbnail_upload_error_nofile'] = 'Du hast keine Datei ausgew&auml;hlt';
$langFile['pagethumbnail_upload_error_wrongformat'] = 'Die ausgew&auml;hlte Datei hat ein nicht unterst&uuml;tztes Format';
$langFile['pagethumbnail_upload_error_nodir_part1'] = 'Das Thumbnail-Verzeichnis'; // ..thumbnail-folder..
$langFile['pagethumbnail_upload_error_nodir_part2'] = 'existiert nicht oder konnte nicht erstellt werden.';
$langFile['pagethumbnail_upload_error_couldntmovefile_part1'] = 'Konnte die hochgeladene Datei nicht in das Thumbnail-Verzeichnis'; // ..thumbnail-folder..
$langFile['pagethumbnail_upload_error_couldntmovefile_part2'] = 'verschieben.';
$langFile['pagethumbnail_upload_error_changeimagesize'] = 'Die Bildgr&ouml;&szlig;e konnt nicht ge&auml;ndert werden.';
$langFile['pagethumbnail_upload_error_deleteoldfile'] = 'Das alte Thumbnail-Bild konnte nicht gel&ouml;scht werden.';
$langFile['pagethumbnail_upload_response_fileexists'] = 'Es existiert bereits eine Datei mit diesem Namen.<br />Die Hochgeladene Datei wurde umbenannt nach';
$langFile['pagethumbnail_upload_response_finish'] = 'Das Bild wurde erfolgreich hochgeladen.';

// ---------------------------------------------------------------------------------------------------------------------
// search.php
//
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
$langFile['search_results_count'] = 'Treffer';
$langFile['search_results_time_part1'] = 'in'; // 12 Treffer in 0.32 Sekunden
$langFile['search_results_time_part2'] = 'Sekunden';


// ---------------------------------------------------------------------------------------------------------------------
// *********************************************************************************************************************
// ---------------------------------------------------------------------------------------------------------------------
// returns the $langFile var, if its included in an if
return $langFile;

?>