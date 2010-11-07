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

// -> LOGIN <-

$langFile['LOGIN_INPUT_USERNAME'] = 'Benutzername';
$langFile['LOGIN_INPUT_PASSWORD'] = 'Passwort';
$langFile['LOGIN_BUTTON_LOGIN'] = 'LOGIN';
$langFile['LOGIN_TEXT_COOKIESNEEDED'] = 'Cookies m&uuml;ssen aktivert sein';

$langFile['LOGIN_LINK_FORGOTPASSWORD'] = 'Passwort vergessen?';
$langFile['LOGIN_LINK_BACKTOLOGIN'] = 'zur&uuml;ck zum Login';
$langFile['LOGIN_BUTTON_SENDNEWPASSWORD'] = 'SENDEN';
$langFile['LOGIN_TEXT_NEWPASSWORDEMAIL_SUBJECT'] = 'feindura CMS Passwort angefordert von';
$langFile['LOGIN_TEXT_NEWPASSWORDEMAIL_MESSAGE'] = 'Du hast ein neues Passwort f&uuml;r das feindura - Flat File CMS angefordert.
Dein Benutzername und dein neues Passwort lauten:';

$langFile['LOGIN_ERROR_FORGOTPASSWORD_NOEMAIL'] = 'Der Benutzer hat keine E-Mail Adressse angegeben.';
$langFile['LOGIN_ERROR_FORGOTPASSWORD_NOTSEND'] = 'FEHLER<br />beim senden des neuen Passworts an die vom Benutzer angegebene E-Mail Adresse.';
$langFile['LOGIN_ERROR_FORGOTPASSWORD_NOTSAVED'] = 'FEHLER<br />Konnte das neu erzeugte Passwort nicht speichern.';
$langFile['LOGIN_ERROR_FORGOTPASSWORD_SUCCESS'] = 'Es wurde ein neues Passwort and folgende E-Mail Adresse verschickt';

$langFile['LOGIN_ERROR_WRONGUSER'] = 'Benutzer nicht vorhanden';
$langFile['LOGIN_ERROR_WRONGPASSWORD'] = 'falsches Passwort';

$langFile['LOGIN_TEXT_LOGOUT_PART1'] = 'Erfolgreich ausgeloggt';
$langFile['LOGIN_TEXT_LOGOUT_PART2'] = 'weiter zur Webseite';


// -> GENERAL <-

$langFile['DATE_INT'] = 'JJJJ-MM-TT';
$langFile['DATE_EU'] = 'TT.MM.JJJJ';
$langFile['CATEGORIES_TEXT_NONCATEGORY'] = 'Seiten';
$langFile['CATEGORIES_TOOLTIP_NONCATEGORY'] = 'Seiten ohne Kategorie';
$langFile['TEXT_EXAMPLE'] = 'Beispiel';

$langFile['HEADER_BUTTON_GOTOWEBSITE'] = 'Frontend-Bearbeitung::Klick hier um die Seiten direkt auf deiner Webseite zu bearbeiten.';

// THUMBNAILS
$langFile['THUMBNAIL_TEXT_UNIT'] = 'Pixel';

$langFile['THUMBNAIL_TEXT_NAME'] = 'Seiten-Thumbnail';
$langFile['THUMBNAIL_TEXT_WIDTH'] = 'Standard <b>Breite</b>';
$langFile['THUMBNAIL_TEXT_HEIGHT'] = 'Standard <b>H&ouml;he</b>';

$langFile['THUMBNAIL_TOOLTIP_PREVIEW'] = 'M&ouml;glicherweise ist nach dem Upload noch das vorherige Bild zu sehen, dies ist bedingt durch den Browser-Cache.[br /][br /]Um das aktuelle Bild zu sehen musst du die Seite aktualisieren (F5).';

$langFile['THUMBNAIL_TOOLTIP_WIDTH'] = 'Standardbreite::Die Breite des Thumbnails in Pixeln.[br /][br /]Das Bild wird beim hochladen auf die angegebene Gr&ouml;&szlig;e skaliert.';
$langFile['THUMBNAIL_TOOLTIP_HEIGHT'] = 'Standardh&ouml;he::Die H&ouml;he des Thumbnails in Pixeln.[br /][br /]Das Bild wird beim hochladen auf die angegebene Gr&ouml;&szlig;e skaliert.';

$langFile['THUMBNAIL_TEXT_RATIO'] = 'Seitenverh&auml;ltnis';
$langFile['THUMBNAIL_TEXT_KEEPRATIO'] = 'Seitenverh&auml;ltnis beibehalten';
$langFile['THUMBNAIL_TEXT_FIXEDRATIO'] = 'festes Seitenverh&auml;ltnis';
$langFile['THUMBNAIL_TOOLTIP_FIXEDRATIO'] = 'H&ouml;he und Breite ist fest einstellbar.';
$langFile['THUMBNAIL_TOOLTIP_KEEPRATIO_X'] = 'Wird an der [b]Breite[/b] ausgerichtet.';
$langFile['THUMBNAIL_TOOLTIP_KEEPRATIO_Y'] = 'Wird an der [b]H&ouml;he[/b] ausgerichtet.';

// STYLESHEETS
$langFile['STYLESHEETS_TEXT_STYLEFILE'] = 'Stylesheet-Dateien';
$langFile['STYLESHEETS_TEXT_ID'] = 'Stylesheet-Id';
$langFile['STYLESHEETS_TEXT_CLASS'] = 'Stylesheet-Klasse';

$langFile['STYLESHEETS_TOOLTIP_STYLEFILE'] = 'Hier k&ouml;nnen Stylesheet-Dateien angegeben werden, die im HTML-Editor verwendet werden um den Inhalt zu formatieren.';
$langFile['STYLESHEETS_TOOLTIP_ID'] = 'Hier kann eine Id-Attribut angegeben werden, das dem HTML-Editor &lt;body&gt; Tag zugewiesen wird.';
$langFile['STYLESHEETS_TOOLTIP_CLASS'] = 'Hier kann eine Class-Attribut angegeben werden, das dem HTML-Editor &lt;body&gt; Tag zugewiesen wird.';

$langFile['STYLESHEETS_TOOLTIP_ADDSTYLEFILE'] = 'Stylesheet Datei hinzuf&uuml;gen';
$langFile['STYLESHEETS_EXAMPLE_STYLEFILE'] = '<b>Beispiel</b> "/style/layout.css"';

// PATHS
$langFile['PATHS_TEXT_ABSOLUTE'] = 'Absoluter Pfad';
$langFile['PATHS_TEXT_RELATIVE'] = 'Relativer Pfad';
$langFile['PATHS_TOOLTIP_ABSOLUTE'] = 'Absoluter Pfad';
$langFile['PATHS_TOOLTIP_RELATIVE'] = 'Relativer Pfad';

// STATISTICS
$langFile['STATISTICS_TITLE_BROWSERCHART'] = 'Browserspektrum der Besucher';
$langFile['STATISTICS_TEXT_SPIDERCOUNT'] = 'Web-Spiders';
$langFile['STATISTICS_TOOLTIP_SPIDERCOUNT'] = 'Web-Spiders::Oder auch Webcrawler genannt sind Programmscripte von Suchmaschienen, die Seiten analysieren und indizieren.';

$langFile['STATISTICS_TEXT_SEARCHWORD_PART1'] = 'hat'; // "exampleword" led 20 times to this website
$langFile['STATISTICS_TEXT_SEARCHWORD_PART2'] = 'mal auf diese Seite gef&uuml;hrt';
$langFile['STATISTICS_TOOLTIP_SEARCHWORD'] = 'Anklicken um nach diesem Suchwort in allen Seiten zu suchen.';

$langFile['STATISTICS_TEXT_VISITORCOUNT'] = 'Besucher';
$langFile['STATISTICS_TEXT_CURRENTVISITORS'] = 'aktuelle Besucher';
$langFile['STATISTICS_TEXT_LASTACTIVITY'] = 'letzte Aktivit&auml;t';

$langFile['STATISTICS_TITLE_PAGESTATISTICS'] = 'Seiten Statistiken';

$langFile['STATISTICS_TEXT_VISITTIME_MAX'] = 'l&auml;ngste Verweildauer';
$langFile['STATISTICS_TEXT_VISITTIME_MIN'] = 'k&uuml;rzeste Verweildauer';
$langFile['STATISTICS_TEXT_FIRSTVISIT'] = 'erster Besuch';
$langFile['STATISTICS_TEXT_LASTVISIT'] = 'letzter Besuch';
$langFile['STATISTICS_TEXT_NOVISIT'] = 'Es hat noch niemand diese Seite besucht.';
$langFile['STATISTICS_TEXT_SEARCHWORD_DESCRIPTION'] = 'Suchworte die von
<a href="http://www.google.de">Google</a>,
<a href="http://www.yahoo.de">Yahoo</a> oder
<a href="http://www.bing.com">Bing (MSN)</a> auf diese Seite gef&uuml;hrt haben';
$langFile['STATISTICS_TEXT_NOSEARCHWORDS'] = 'Es haben noch keine Suchworte auf diese Seite gef&uuml;hrt.';

$langFile['STATISTICS_TEXT_HOUR_SINGULAR'] = 'Stunde';
$langFile['STATISTICS_TEXT_HOUR_PLURAL'] = 'Stunden';
$langFile['STATISTICS_TEXT_MINUTE_SINGULAR'] = 'Minute';
$langFile['STATISTICS_TEXT_MINUTE_PLURAL'] = 'Minuten';
$langFile['STATISTICS_TEXT_SECOND_SINGULAR'] = 'Sekunde';
$langFile['STATISTICS_TEXT_SECOND_PLURAL'] = 'Sekunden';

$langFile['STATISTICS_TEXT_BROWSERCHART_OTHERS'] = 'Sonstige';

// LOG TEXTS
$langFile['LOG_PAGE_SAVED'] = 'Seite gespeichert';
$langFile['LOG_PAGE_NEW'] = 'Neue Seite erstellt';
$langFile['LOG_PAGE_DELETE'] = 'Seite gel&ouml;scht';

$langFile['LOG_PAGE_MOVEDINCATEGORY'] = 'Seite in Kategorie verschoben';
$langFile['LOG_PAGE_MOVEDINCATEGORY_CATEGORY'] = 'in Kategorie'; // Example Page in Category
$langFile['LOG_PAGE_SORTED'] = 'Seite neu sortiert';

$langFile['LOG_THUMBNAIL_UPLOAD'] = 'Neues Thumbnail hochgeladen';
$langFile['LOG_THUMBNAIL_DELETE'] = 'Thumbnail gel&ouml;scht';

$langFile['LOG_USER_ADD'] = 'Neuen Benutzer angelegt';
$langFile['LOG_USER_DELETED'] = 'Benutzer gel&ouml;scht';
$langFile['LOG_USER_PASSWORD_CHANGED'] = 'Benutzerpasswort ge&auml;ndert';
$langFile['LOG_USER_SAVED'] = 'Benutzer gespeichert';

$langFile['LOG_ADMINSETUP_SAVED'] = 'Administrator-Einstellungen gespeichert';
$langFile['LOG_ADMINSETUP_CKSTYLES'] = '"Stil-Auswahl" des HTML-Editors gespeichert';

$langFile['LOG_WEBSITESETUP_SAVED'] = 'Webseiten-Einstellungen gespeichert';

$langFile['LOG_STATISTICSETUP_SAVED'] = 'Statistik-Einstellungen gespeichert';
$langFile['LOG_CLEARSTATISTICS_WEBSITESTATISTIC'] = 'Webseiten-Statistik gel&ouml;scht';
$langFile['LOG_CLEARSTATISTICS_PAGESTATISTICS'] = 'Seiten-Statistiken gel&ouml;scht';
$langFile['LOG_CLEARSTATISTICS_PAGESTAYLENGTH'] = 'Seiten-Verweildauer-Statistiken gel&ouml;scht';
$langFile['LOG_CLEARSTATISTICS_REFERERLOG'] = 'Referrer-Log gel&ouml;scht';
$langFile['LOG_CLEARSTATISTICS_ACTIVITYLOG'] = 'letzte T&auml;tigkeiten-Log gel&ouml;scht';

$langFile['LOG_PAGESETUP_SAVED'] = 'Seiten-Einstellungen gespeichert';
$langFile['LOG_PAGESETUP_CATEGORIES_SAVED'] = 'Kategorien gespeichert';

$langFile['LOG_PAGESETUP_CATEGORIES_NEW'] = 'Neue Kategorie erstellt';
$langFile['LOG_PAGESETUP_CATEGORIES_DELETED'] = 'Kategorie gel&ouml;scht';
$langFile['LOG_PAGESETUP_CATEGORIES_MOVED'] = 'Kategorie verschoben';

$langFile['LOG_PLUGINSETUP_SAVED'] = 'Plugin-Einstellungen gespeichert von';

$langFile['LOG_FILE_SAVED'] = 'Datei gespeichert';
$langFile['LOG_FILE_DELETED'] = 'Datei gel&ouml;scht';

// PAGE/CATEGORY STATUS
$langFile['STATUS_PAGE_PUBLIC'] = 'Seite ist &ouml;ffentlich';
$langFile['STATUS_PAGE_NONPUBLIC'] = 'Seite ist versteckt';

$langFile['STATUS_CATEGORY_PUBLIC'] = 'Kategorie ist &ouml;ffentlich';
$langFile['STATUS_CATEGORY_NONPUBLIC'] = 'Kategorie ist versteckt';

// USER LIST
$langFile['USER_TEXT_NOUSER'] = 'Es sind keine Benutzer vorhanden';
$langFile['USER_TEXT_CURRENTUSER'] = 'Du bist unter diesem Benutzernamen eingeloggt';
$langFile['USER_TEXT_USERSONLINE'] = 'Dieser Benutzer ist ebenfalls eingeloggt::Letzte Aktivit&auml;t';

$langFile['LOGO_TEXT'] = 'Version';
$langFile['LOADING_TEXT_LOAD'] = 'Seite wird geladen..';


// -> BUTTON TEXTS

// MAIN MENU
$langFile['BUTTON_HOME'] = '&Uuml;bersicht';
$langFile['BUTTON_PAGES'] = 'Seiten';
$langFile['BUTTON_ADDONS'] = 'Addons';
$langFile['BUTTON_WEBSITESETTINGS'] = 'Webseiten Einstellungen';
$langFile['BUTTON_SEARCH'] = 'Seiten durchsuchen';

// ADMIN MENU
$langFile['HEADER_TITLE_ADMINMENU'] = 'Administration';
$langFile['BUTTON_ADMINSETUP'] = 'Administrator Einstellungen';
$langFile['BUTTON_PAGESETUP'] = 'Seiten Einstellungen';
$langFile['BUTTON_PLUGINSETUP'] = 'Plugins Einstellungen';
$langFile['BUTTON_STATISTICSETUP'] = 'Statistik Einstellungen';
$langFile['BUTTON_USERSETUP'] = 'Benutzer Verwaltung';
$langFile['BUTTON_BACKUP'] = 'Backup Wiederherst.';

// SUB MENU/FOOTER
$langFile['BUTTON_FILEMANAGER'] = 'Dateimanager';
$langFile['BUTTON_TOOLTIP_FILEMANAGER'] = 'Dateien und Bilder verwalten';
$langFile['BUTTON_CREATEPAGE'] = 'Neue Seite';
$langFile['BUTTON_TOOLTIP_CREATEPAGE'] = 'Neue Seite erstellen';
$langFile['BUTTON_DELETEPAGE'] = 'Seite l&ouml;schen';
$langFile['BUTTON_TOOLTIP_DELETEPAGE'] = 'Diese Seite l&ouml;schen';
$langFile['BUTTON_THUMBNAIL_UPLOAD'] = 'Seiten-Thumbnail hochladen';
$langFile['BUTTON_TOOLTIP_THUMBNAIL_UPLOAD'] = 'Thumbnail f&uuml;r diese Seite hochladen';
$langFile['BUTTON_THUMBNAIL_DELETE'] = 'Seiten-Thumbnail l&ouml;schen';
$langFile['BUTTON_TOOLTIP_THUMBNAIL_DELETE'] = 'Thumbnail von dieser Seite l&ouml;schen';

// OTHER BUTTONS
$langFile['BUTTON_UP'] = 'Nach oben';


// -> GENERAL ERROR TEXTS
$langFile['ERROR_SAVE_SETTINGS'] = '<b>Die Einstellungen konnten nicht gespeichert werden.</b>';
$langFile['ERROR_SAVE_FILE'] = '<br /><br />Bitte &uuml;berpr&uuml;fe die Schreibrechte der Datei: ';

$langFile['ERROR_READ_FOLDER_PART1'] = '<br /><br />Bitte &uuml;berpr&uuml;fe die Leserechte des "';
$langFile['ERROR_SAVE_FOLDER_PART1'] = '<br /><br />Bitte &uuml;berpr&uuml;fe die Schreibrechte des "';

$langFile['ERROR_FOLDER_PART2'] = '" Ordners dessen Unterordner und Dateien.';


/*
* ---------- WARNINGs
*/

$langFile['warning_startPageWarning_h1'] = 'Die Startseite ist nicht festgelegt!';
$langFile['warning_startPageWarning'] = 'Bitte lege eine Seite als Startseite fest.<br />Gehe zu <a href="?site=pages">'.$langFile['BUTTON_PAGES'].'</a> und klicke bei der gew&uuml;nschten Seite auf das <span class="startPageIcon"></span> Symbol';


$langFile['warning_fmsConfWarning_h1'] = '<span class="logoname">fein<span>dura</span></span> wurde noch nicht konfiguriert!';
$langFile['warning_fmsConfWarning'] = 'Der <i>Basispfad</i> stimmt nicht mit dem in den Administrator-Einstellungen angegebenen Pfad &uuml;berein.<br />
Bitte gehe in die <a href="?site=adminSetup">Administrator-Einstellungen</a> und konfiguriere dein <span class="logoname">fein<span>dura</span></span> CMS';

$langFile['warning_jsWarning_h1'] = 'Bitte aktiviere Javascript';
// no <p> tag on the start and the end, its already in the home.php
$langFile['warning_jsWarning'] = '<strong>Um <span class="logoname">fein<span>dura</span></span> voll nutzen zu k&ouml;nnen, muss Javascript aktiviert sein!</strong></p>
<h2>im Firefox</h2>
<p>Klicke in der obersten Men&uuml;leiste auf "Bearbeiten" > "Einstellungen". Unter Inhalt aktivierst du den Punkt "JavaScript aktivieren" und best&auml;tigst dann mit OK.</p>
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

/*
* leftSidebar.loader.php
*/

// ---------- QUICKMENU

$langFile['btn_quickmenu_categories'] = 'Kategorien';
$langFile['btn_quickmenu_pages'] = 'Seiten von';

/*
* home.php
*/

// ---------- HOME
$langFile['home_userInfo_h1'] = 'Benutzer Information';

$langFile['home_welcome_h1'] = 'Willkommen in <span class="logoname">fein<span>dura</span></span>,<br />dem Content Management System deiner Webseite';
$langFile['home_welcome_text'] = '<span class="logoname">fein<span>dura</span></span> ist ein auf <span class="toolTip" title="Flat-Files::Das sind Dateien auf dem Server, in denen der Inhalt der Webseite gespeichert wird.">Flat-Files</span> basierendes Content Management System.<br />Hier kannst du den Inhalt deiner Webseite verwalten.';

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

/*
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
$langFile['sortablePageList_sortOrder_date'] = 'nach Seitendatum sortiert';

$langFile['sortablePageList_functions_editPage'] = 'Seite bearbeiten';

$langFile['sortablePageList_changeStatus_linkPage'] = 'Hier klicken um den Status f&uuml;r Seite zu &auml;ndern.';
$langFile['sortablePageList_changeStatus_linkCategory'] = 'Hier klicken um den Status f&uuml;r die Kategorie zu &auml;ndern.';

$langFile['file_error_read'] = '<b>Die Seite konnte nicht gelesen werden.</b>'.$langFile['ERROR_READ_FOLDER_PART1'].$adminConfig['savePath'].$langFile['ERROR_FOLDER_PART2'];
$langFile['sortablePageList_changeStatusPage_error_save'] = '<b>Der Status der Seite konnte nicht ge&auml;ndert werden.</b>'.$langFile['ERROR_SAVE_FOLDER_PART1'].$adminConfig['savePath'].$langFile['ERROR_FOLDER_PART2'];
$langFile['sortablePageList_setStartPage_error_save'] .= $langFile['ERROR_SAVE_FILE'].' "'.$adminConfig['basePath'].'config/website.config.php"'; // also in de.shared.php
$langFile['sortablePageList_changeStatusCategory_error_save'] = '<b>Der Status der Kategorie konnte nicht ge&auml;ndert werden.</b>'.$langFile['ERROR_SAVE_FOLDER_PART1'].$adminConfig['savePath'].$langFile['ERROR_FOLDER_PART2'];

$langFile['sortablePageList_info'] = 'Du kannst die <b>Seiten-Anordnung</b> per <b>Drag and Drop</b> ver&auml;ndern und auch Seiten zwischen den Kategorien verschieben.';
$langFile['sortablePageList_save'] = 'Speichere die neue Anordnung ...';
$langFile['sortablePageList_save_finished'] = 'Neu Anordnung erfolgreich gespeichert!';
$langFile['sortablePageList_error_save'] = '<b>Die Seiten konnten nicht gespeichert werden.</b>'.$langFile['ERROR_SAVE_FOLDER_PART1'].$adminConfig['savePath'].$langFile['ERROR_FOLDER_PART2'];
$langFile['sortablePageList_error_read'] = '<b>Die Seiten konnten nicht gelesen werden.</b>'.$langFile['ERROR_READ_FOLDER_PART1'].$adminConfig['savePath'].$langFile['ERROR_FOLDER_PART2'];
$langFile['sortablePageList_error_move'] = '<b>Konnte die Seite nicht in die neue Kategorie verschieben.</b>'.$langFile['ERROR_SAVE_FOLDER_PART1'].$adminConfig['savePath'].$langFile['ERROR_FOLDER_PART2'];
$langFile['sortablePageList_categoryEmpty'] = 'Keine Seiten vorhanden';

// ---------- FORMULAR
$langFile['form_submit'] = 'Speichern';
$langFile['form_cancel'] = 'Alle Eingaben zur&uuml;cksetzen';

/*
* adminSetup.php
*/

// ---------- ADMIN SETUP (on toolTips tooTips.js converts the "[" and "]" tags in the title attribute to "<" ">")
$langFile['adminSetup_version'] = '<span class="logoname">fein<span>dura</span></span> Version';
$langFile['adminSetup_phpVersion'] = 'PHP Version';
$langFile['adminSetup_warning_phpversion'] = 'F&uuml;r volle Funktionalit&auml;t ben&ouml;tigst du mindestens'; // PHP 4.3.0
$langFile['adminSetup_srvRootPath'] = 'Server-Root-Pfad';

$langFile['adminSetup_error_title'] = 'Es sind Fehler aufgetreten';
$langFile['adminSetup_error_writeAccess_tip'] = 'Bei Dateien und Verzeichnissen m&uuml;ssen die Schreibrechte auf '.decoct(PERMISSIONS).' gesetzt werden.';

$langFile['adminSetup_error_writeAccess'] = 'ist nicht beschreibbar';
$langFile['adminSetup_error_isFolder'] = 'ist kein Verzeichnis';

// ---------- FMS Settings
$langFile['adminSetup_fmsSettings_error_save'] = $langFile['ERROR_SAVE_SETTINGS'].$langFile['ERROR_SAVE_FILE'].$adminConfig['basePath'].'config/admin.config.php';

$langFile['adminSetup_fmsSettings_h1'] = 'Grund-Einstellungen';

$langFile['adminSetup_fmsSettings_field1'] = 'Webseiten-URL';
$langFile['adminSetup_fmsSettings_field1_tip'] = 'Die URL ihrer Webseite wird automatisch eingef&uuml;gt.';
$langFile['adminSetup_fmsSettings_field1_inputTip'] = 'Die URL wird automatisch eingef&uuml;gt';
$langFile['adminSetup_fmsSettings_field1_inputWarningText'] = 'Bitte speichere die Einstellungen!';
$langFile['adminSetup_fmsSettings_field2'] = 'feindura-Pfad';
$langFile['adminSetup_fmsSettings_field2_tip'] = 'Der Hauptpfad wird automatisch ermittelt und beim speichern der Einstellungen &uuml;bernommen.';
$langFile['adminSetup_fmsSettings_field2_inputTip'] = 'Der Pfad wird automatisch eingef&uuml;gt';
$langFile['adminSetup_fmsSettings_field2_inputWarningText'] = 'Bitte speichere die Einstellungen!';
$langFile['adminSetup_fmsSettings_field8'] = 'Webseitenpfad';
$langFile['adminSetup_fmsSettings_field8_tip'] = 'Der [b]absolute Pfad[/b], unter dem sich die Webseite befindet.';
$langFile['adminSetup_fmsSettings_field3'] = 'Seitenpfad';
$langFile['adminSetup_fmsSettings_field3_tip'] = 'Der [b]absolute Pfad[/b], unter dem die Flat-Files mit dem Seiteninhalt gespeichert werden.';
$langFile['adminSetup_fmsSettings_field4'] = 'Daten-Uploadpfad';
$langFile['adminSetup_fmsSettings_field4_tip'] = 'Hier werden Dateien wie Bilder, Flash-Animation oder Dokumente hochgeladen.[br /][br /][span class=hint]Dateien werden im HTML-Editor unter Link-einf&uuml;gen > Upload hochgeladen oder im Dateimanager.[/span]';
$langFile['adminSetup_fmsSettings_editfiles_additonal'] = '[br /][br /]Diese Dateien k&ouml;nnen dann weiter unten oder in den Webseiten-Einstellungen bearbeitet werden (sollte dies in den Benutzer-Einstellungen aktiviert sein).[br /][br /]';
$langFile['adminSetup_fmsSettings_field5'] = 'Dateipfad f&uuml;r Webseitendateien';
$langFile['adminSetup_fmsSettings_field5_tip'] = 'Ein Verzeichnis mit Dateien. Diese Dateien k&ouml;nnen z.B. verwendet werden um eine Webseite mehrsprachig zu gestalten.'.$langFile['adminSetup_fmsSettings_editfiles_additonal'];
$langFile['adminSetup_fmsSettings_field6'] = 'Dateipfad f&uuml;r Stylesheetdateien';
$langFile['adminSetup_fmsSettings_field6_tip'] = 'Ein [b]absoluter Pfad[/b] in dem sich Stylesheet-Dateien befinden, die z.B. vom Benutzer bearbeitet werden k&ouml;nnen.'.$langFile['adminSetup_fmsSettings_editfiles_additonal'];
$langFile['adminSetup_fmsSettings_varName_ifempty'] = 'Wenn das Feld leer ist, wird der Standard Name f&uuml;r die GET-Variablen verwendet: ';
$langFile['adminSetup_fmsSettings_varName1'] = 'Seiten Variablenname';
$langFile['adminSetup_fmsSettings_varName1_inputTip'] = $langFile['adminSetup_fmsSettings_varName_ifempty'].'"[b]page[/b]"';
$langFile['adminSetup_fmsSettings_varName2'] = 'Kategorie Variablenname';
$langFile['adminSetup_fmsSettings_varName2_inputTip'] = $langFile['adminSetup_fmsSettings_varName_ifempty'].'"[b]category[/b]"';
$langFile['adminSetup_fmsSettings_varName3'] = 'Modul Variablenname';
$langFile['adminSetup_fmsSettings_varName3_inputTip'] = $langFile['adminSetup_fmsSettings_varName_ifempty'].'"[b]modul[/b]"';
$langFile['adminSetup_fmsSettings_varName_tip'] = 'Der Name der [b]$_GET Variable[/b] die f&uuml;r die Seiten Verlinkung verwendet wird.';
$langFile['adminSetup_fmsSettings_field7'] = 'Datumsformat';
$langFile['adminSetup_fmsSettings_field7_tip'] = 'Wird in [span class=logoname]fein[span]dura[/span][/span] und der Webseite verwendet.[br /]Entweder:[br /]DIN 5008 ('.$langFile['DATE_EU'].') oder[br /]ISO 8601 ('.$langFile['DATE_INT'].')';
$langFile['adminSetup_fmsSettings_speakingUrl'] = 'URL Format';
$langFile['adminSetup_fmsSettings_speakingUrl_true'] = 'Speaking URLs';
$langFile['adminSetup_fmsSettings_speakingUrl_true_example'] = '/category/beispiel_category/beispiel.html';
$langFile['adminSetup_fmsSettings_speakingUrl_false'] = 'URLs mit Variablen';
$langFile['adminSetup_fmsSettings_speakingUrl_false_example'] = 'index.php?'.$adminConfig['varName']['category'].'=1&'.$adminConfig['varName']['page'].'=1';
$langFile['adminSetup_fmsSettings_speakingUrl_tip'] = 'Das URL Format, welches f&uuml;r die Seiten-Verlinkung verwendet wird.[br /][br /]Speaking URLs funktionieren nur wenn im [b]Apache[/b] das [b]mod_rewrite[/b] Modul verf&uuml;gbar ist.';
$langFile['adminSetup_fmsSettings_speakingUrl_warning'] = 'WARNUNG!::[span class=red]Sollten Fehler bei der Vewendung von Speaking URLs auftreten, muss die [b].htaccess Datei[/b] im Dokumenten-Root Pfad des Webservers gel&ouml;scht werden.[/span][br /][br /](In manchen FTP-Programmen muss man erst die versteckten Dateien anzeigen, um die .htaccess Datei sichtbar zu machen)';

// ---------- speaking url ERRORs
$langFile['adminSetup_fmsSettings_speakingUrl_error_save'] = '<b>Speaking URLs</b> konnte nicht aktiviert werden'.$langFile['ERROR_SAVE_FILE'].'/.htaccess';
$langFile['adminSetup_fmsSettings_speakingUrl_error_modul'] = '<b>Speaking URLs</b> konnte nicht aktiviert werden da das Apache modul: MOD_REWRITE nicht gefunden wurde';


// ---------- user Settings
$langFile['adminSetup_userSettings_h1'] = 'Benutzer-Einstellungen';
$langFile['adminSetup_userSettings_check1'] = 'Webseitendateien in den Webseiten-Einstellungen bearbeiten';
$langFile['adminSetup_userSettings_check2'] = 'Stylesheetdateien in den Webseiten-Einstellungen bearbeiten';
$langFile['adminSetup_userSettings_check3'] = 'Dateimanager aktivieren';

$langFile['adminSetup_userSettings_textarea1'] = '<strong>Benutzerinformation</strong> in der <a href="?site=home">'.$langFile['BUTTON_HOME'].'</a>';
$langFile['adminSetup_userSettings_textarea1_tip'] = 'Benutzerinformationen::Dieser Text wird auf der [span class=logoname]fein[span]dura[/span][/span] '.$langFile['BUTTON_HOME'].' angezeigt.';
$langFile['adminSetup_userSettings_textarea1_inputTip'] = 'Wenn Du keine Informationen f&uuml;r den Benutzer anzeigen m&ouml;chtest lasse das Feld leer';

// ---------- editor Settings
$langFile['adminSetup_editorSettings_h1'] = 'HTML-Editor-Einstellungen';
$langFile['adminSetup_editorSettings_field1'] = 'ENTER-Taste Modus';
$langFile['adminSetup_editorSettings_field1_hint'] = 'SHIFT + ENTER erzeugt immer ein &quot;&lt;br /&gt;&quot;';
$langFile['adminSetup_editorSettings_field1_tip'] = 'Legt fest welcher HTML-Tag beim dr&uuml;cken der ENTER-Taste gesetzt wird.[br /][br /][span class=hint]'.$langFile['adminSetup_editorSettings_field1_hint'].'.[/span]';
$langFile['adminSetup_editorSettings_field3_inputTip'] = 'Wenn das Feld leer ist, wird keine Id verwendet.';
$langFile['adminSetup_editorSettings_field4_inputTip'] = 'Wenn das Feld leer ist, wird keine Klasse verwendet.';

// THUMBNAILS Settings
$langFile['adminSetup_thumbnailSettings_h1'] = 'Seiten-Thumbnail-Einstellungen';
$langFile['adminSetup_thumbnailSettings_field3'] = 'Speicherpfad'; // Thumbnail-Speicherpfad
$langFile['adminSetup_thumbnailSettings_field3_tip'] = 'Der Pfad innerhalb des Daten-Upload Pfads, in dem die Thumbnails gespeichert werden.';
$langFile['adminSetup_thumbnailSettings_field3_inputTip1'] = 'Der Daten-Upload Pfad';
$langFile['adminSetup_thumbnailSettings_field3_inputTip2'] = 'Relativer Pfad::Relativ zum &quot;[b]'.$adminConfig['uploadPath'].'[/b]&quot; Pfad.[br /][br /]Beginnt ohne &quot;/&quot;';
$langFile['adminSetup_thumbnailSettings_field3_inputTip3'] = '<b>'.$langFile['TEXT_EXAMPLE'].'</b> "thumbnails/" ';

// ---------- styleFile Settings
$langFile['adminSetup_styleFileSettings_h1'] = '"Stil-Auswahl" des HTML-Editors bearbeiten';
$langFile['adminSetup_styleFileSettings_error_save'] = '<b>Die Datei "htmlEditorStyles.xml" konnte nicht gespeichert werden.</b>'.$langFile['ERROR_SAVE_FILE'];

// ---------- editFiles Settings
$langFile['editFilesSettings_error_save'] = '<b>Die Datei konnte nicht gespeichert werden.</b>'.$langFile['ERROR_SAVE_FILE'];

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

$langFile['editFilesSettings_deleteFile_error_delete'] = '<b>Die Datei konnte nicht gel&ouml;scht werden.</b>'.$langFile['ERROR_SAVE_FILE'];

/*
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
$langFile['pageSetup_pageConfig_check2_tip'] = 'Legt fest ob der Benutzer Seiten ohne Kategorie erstellen und l&ouml;schen kann.';
$langFile['pageSetup_pageConfig_check3'] = 'Thumbnails hochladen';
$langFile['pageSetup_pageConfig_check3_tip'] = 'Legt fest ob der Benutzer, innerhalb der Seiten ohne Kategorie, Seiten-Thumbnails hochladen kann.';
$langFile['pageSetup_pageConfig_check4'] = 'Tags bearbeiten';
$langFile['pageSetup_pageConfig_check4_tip'] = 'Legt fest ob der Benutzer, innerhalb der Seiten ohne Kategorie, Tags bearbeiten kann.[br /]'.$langFile['pageSetup_general_tag_tip'];
$langFile['pageSetup_pageConfig_check5'] = 'Plugins aktivieren';
$langFile['pageSetup_pageConfig_check5_tip'] = 'Legt fest ob der Benutzer, innerhalb der Seiten ohne Kategorie, Plugins verwenden kann.';

// ---------- category settings
$langFile['pageSetup_h1'] = 'Kategorien-Verwaltung';
$langFile['pageSetup_field1'] = 'Name';

$langFile['pageSetup_createCategory'] = 'Neue Kategorie erstellen';
$langFile['pageSetup_createCategory_created'] = 'Neue Kategorie erstellt';
$langFile['pageSetup_createCategory_unnamed'] = 'Unbenannte Kategorie';

$langFile['pageSetup_deleteCategory'] = 'Kategorie l&ouml;schen';
$langFile['pageSetup_deleteCategory_warning'] = 'WARNUNG: Es werden auch alle Seiten innerhalb dieser Kategorie gel&ouml;scht!';
$langFile['pageSetup_deleteCategory_deleted'] = 'Kategorie gel&ouml;scht';

$langFile['pageSetup_moveCategory_moved'] = 'Kategorie verschoben';
$langFile['pageSetup_moveCategory_up_tip'] = 'Kategorie nach oben verschieben';
$langFile['pageSetup_moveCategory_down_tip'] = 'Kategorie nach unten verschieben';

$langFile['pageSetup_error_create'] = '<b>Eine neue Kategorie konnte nicht erstellt werden.</b>'.$langFile['ERROR_SAVE_FOLDER_PART1'].$adminConfig['basePath'].'config/'.$langFile['ERROR_FOLDER_PART2'];
$langFile['pageSetup_error_createDir'] = '<b>Konnte keine neues Kategorie-Verzeichnis erstellen.</b>'.$langFile['ERROR_SAVE_FOLDER_PART1'].$adminConfig['savePath'].'" Ordners.';
$langFile['pageSetup_error_delete'] = '<b>Die Kategorie konnte nicht gel&ouml;scht werden.</b>'.$langFile['ERROR_SAVE_FILE'].$adminConfig['basePath'].'config/category.config.php';
$langFile['pageSetup_error_deleteDir'] = '<b>Konnte das Kategorie-Verzeichnis nicht l&ouml;schen.</b>'.$langFile['ERROR_SAVE_FOLDER_PART1'].$adminConfig['savePath'].$langFile['ERROR_FOLDER_PART2'];
$langFile['pageSetup_error_save'] = $langFile['ERROR_SAVE_SETTINGS'].$langFile['ERROR_SAVE_FILE'].$adminConfig['basePath'].'config/category.config.php';


$langFile['pageSetup_advancedSettings'] = 'Erweiterte-Einstellungen';
$langFile['pageSetup_advancedSettings_hint'] = 'Wenn diese Einstellungen ausgef&uuml;llt sind &uuml;berschreiben sie die Seiten-Thumbnail-Einstellungen weiter oben und die '.$langFile['adminSetup_editorSettings_h1'].' in den <a href="?site=adminSetup">Administrator-Einstellungen</a>.';

$langFile['pageSetup_stylesheet_ifempty'] = 'Wenn alle Felder leer sind, dann werden die Stylesheet-Einstellungen aus den '.$langFile['adminSetup_editorSettings_h1'].' verwendet.';

$langFile['pageSetup_check1'] = 'Status der Kategorie';
$langFile['pageSetup_check1_tip'] = 'Legt fest ob die Kategorie auf der Webseite sichtbar ist.';
$langFile['pageSetup_check2'] = 'Seiten erstellen/l&ouml;schen';
$langFile['pageSetup_check2_tip'] = 'Legt fest ob der Benutzer kann in dieser Kategorie Seiten erstellen und l&ouml;schen kann.';
$langFile['pageSetup_check3'] = 'Thumbnails hochladen';
$langFile['pageSetup_check3_tip'] = 'Legt fest ob der Benutzer Thumbnails f&uuml;r jede Seite in dieser Kategorie hochzuladen kann.';
$langFile['pageSetup_check4'] = 'Tags bearbeiten';
$langFile['pageSetup_check4_tip'] = 'Es k&ouml;nnen Tags f&uuml;r die Seiten in dieser Kategorie festgelegt werden.[br /]'.$langFile['pageSetup_general_tag_tip'];
$langFile['pageSetup_check8'] = 'Plugins aktivieren';
$langFile['pageSetup_check8_tip'] = 'Plugins f&uuml;r die Seiten in dieser Kategorie aktivieren';

$langFile['pageSetup_check5'] = 'Seitendatum bearbeiten';
$langFile['pageSetup_check5_tip'] = 'Das Seitendatum kann dazu verwendet werden, Seiten auf der Webseite nach Datum zu sortieren';

$langFile['pageSetup_check6'] = 'Nach Seitendatum sortieren';
$langFile['pageSetup_check6_tip'] = 'Die Seiten werden nach dem Seitendatum sortiert.[br /][br /][span class=hint]Manuelles Sortieren ist nicht mehr m&ouml;glich.[/span]';

$langFile['pageSetup_check7'] = 'Neueste Seite immer unten';
$langFile['pageSetup_check7_tip'] = 'Sortiert die Seiten [b]aufsteigend[/b].[br /][br /][span class=hint]Manuelles Sortieren &uuml;berschreibt diese Einstellung f&uuml;r die jeweilige Seite.[/span]';


// ---------- deleting category
$langFile['pageSetup_deletCategory_question_part1'] = 'Kategorie'; // Kategorie "test" l&ouml;schen?
$langFile['pageSetup_deletCategory_question_part2'] = 'l&ouml;schen?';

/*
* websiteSetup.php
*/

// ---------- WEBSITE SETUP (on toolTips tooTips.js converts the "[" and "]" tags in the tittle attribute to "<" ">")
$langFile['websiteSetup_websiteConfig_error_save'] = $langFile['ERROR_SAVE_SETTINGS'].$langFile['ERROR_SAVE_FILE'].$adminConfig['basePath'].'config/website.config.php';

$langFile['websiteSetup_websiteConfig_h1'] = 'Webseiten-Einstellungen';
$langFile['websiteSetup_websiteConfig_field1'] = 'Webseitentitel';
$langFile['websiteSetup_websiteConfig_field1_tip'] = 'Der Titel der Webseite wird oben in der Browserleiste angezeigt.';
$langFile['websiteSetup_websiteConfig_field2'] = 'Publisher';
$langFile['websiteSetup_websiteConfig_field2_tip'] = 'Der Name der Organisation/Firma/Person, die diese Seite ver&oumlffentlicht.';
$langFile['websiteSetup_websiteConfig_field3'] = 'Copyright';
$langFile['websiteSetup_websiteConfig_field3_tip'] = 'Der Copyright-Besitzer der Webseite.';

$langFile['websiteSetup_websiteConfig_field4'] = 'Suchmaschinen-Stichworte';
$langFile['websiteSetup_websiteConfig_field4_tip'] = 'Die meisten Suchmaschienen durchsuchen den Seiteninhalt nach Stichworten, jedoch sollte man hier einige Schl&uuml;sselw&ouml;rter angeben, welche in den <meta> Tags der webseite verwendet werden.';
$langFile['websiteSetup_websiteConfig_field4_inputTip'] = 'Die Stichworte m&uuml;ssen mit "," getrennt werden::'.$langFile['TEXT_EXAMPLE'].':[br /]stichwort1,stichwort2,etc';
$langFile['websiteSetup_websiteConfig_field5'] = 'Webseitenbeschreibung';
$langFile['websiteSetup_websiteConfig_field5_tip'] = 'Eine kurze Beschreibung die von den Suchmaschienen verwendet wird wenn Stichworte in der Webseiten-URL gefunden wurden aber nicht im inhalt.';
$langFile['websiteSetup_websiteConfig_field5_inputTip'] = 'Ein kurzer Text mit nicht mehr als 3 Zeilen.';

/*
* statisticSetup.php
*/

// ---------- STATISITC SETUP (on toolTips tooTips.js converts the "[" and "]" tags in the tittle attribute to "<" ">")
$langFile['statisticSetup_statisticConfig_error_save'] = $langFile['ERROR_SAVE_SETTINGS'].$langFile['ERROR_SAVE_FILE'].$adminConfig['basePath'].'config/statistic.config.php';

$langFile['statisticSetup_statisticConfig_h1'] = 'Statistik-Einstellungen';
$langFile['statisticSetup_statisticConfig_field1'] = 'Anzahl der sichtbaren <b>meist besuchten</b> Seiten';
$langFile['statisticSetup_statisticConfig_field1_tip'] = 'Gibt an wieviele meist besuchte Seiten auf der &Uuml;bersicht-Seite angezeigt werden.';
$langFile['statisticSetup_statisticConfig_field2'] = 'Anzahl der sichtbaren <b>am l&auml;ngsten betrachteten</b> Seiten';
$langFile['statisticSetup_statisticConfig_field2_tip'] = 'Gibt an wieviele am l&auml;ngsten betrachtete Seiten auf der &Uuml;bersicht-Seite angezeigt werden.';
$langFile['statisticSetup_statisticConfig_field3'] = 'Anzahl der sichtbaren <b>zuletzt bearbeiteten</b> Seiten';
$langFile['statisticSetup_statisticConfig_field3_tip'] = 'Gibt an wieviele zuletzt bearbeitete Seiten auf der &Uuml;bersicht-Seite angezeigt werden.';

$langFile['statisticSetup_statisticConfig_field4'] = 'maximale Anzahl der <b>Referrer-URLs</b>';
$langFile['statisticSetup_statisticConfig_field4_tip'] = 'Gibt an wieviele Referrer-URLs ([i]URLs die auf diese Webseite gef&uuml;hrt haben[/i]) maximal gespeichert werden.';
$langFile['statisticSetup_statisticConfig_field5'] = 'maximale Anzahl der <b>T&auml;tigkeiten-Logs</b>';
$langFile['statisticSetup_statisticConfig_field5_tip'] = 'Gibt an wieviele T&auml;tigkeiten-Logs maximal gespeichert werden.';


$langFile['statisticSetup_clearStatistic_h1'] = 'Statistiken l&ouml;schen';
$langFile['statisticSetup_clearStatistics_websiteStatistic'] = 'Webseiten-Statistik';
$langFile['statisticSetup_clearStatistics_websiteStatistic_tip'] = '[b]Beinhaltet[/b][ul][li]Gesamtanzahl der Besucher[/li][li]Gesamtanzahl der Web-Spider[/li][li]Datum des ersten Besuchs[/li][li]Datum des letzten Besuchs[/li][li]Browserspektrum[/li][/ul]';
$langFile['statisticSetup_clearStatistics_pagesStatistic'] = 'Seiten-Statistiken';
$langFile['statisticSetup_clearStatistics_pagesStatistic_tip'] = '[b]Beinhaltet[/b][ul][li]Anzahl der Seitenbesucher[/li][li]Datum des ersten Seitenbesuchs[/li][li]Datum des letzten Seitenbesuchs[/li][li]k&uuml;rzeste Verweildauer[/li][li]l&auml;ngste Verweildauer[/li][li]Suchmaschienen-Stichworte welche auf diese Seite gef&uuml;hrt haben[/li][/ul]';
$langFile['statisticSetup_clearStatistics_pagesStaylengthStatistics'] = 'nur die Seiten-Verweildauer-Statistiken';
$langFile['statisticSetup_clearStatistics_pagesStaylengthStatistics_tip'] = '';
$langFile['statisticSetup_clearStatistics_refererLog'] = 'Referrer-URLs Log'; // engl.: referer
$langFile['statisticSetup_clearStatistics_refererLog_tip'] = 'Eine Liste mit allen URLs welche auf diese Webseite gef&uuml;hrt haben.';
$langFile['statisticSetup_clearStatistics_taskLog'] = 'Logs der letzten T&auml;tigkeiten';
$langFile['statisticSetup_clearStatistics_taskLog_tip'] = 'Beinhaltet eine Liste der letzten T&auml;tigkeiten.';

$langFile['statisticSetup_clearStatistics_question_h1'] = 'Willst du diese Statistiken wirklich l&ouml;schen?';

$langFile['statisticSetup_clearStatistic_pagesStatistics_error_read'] = 'Fehler beim l&ouml;schen der Seiten-Statistiken.'.$langFile['ERROR_SAVE_FOLDER_PART1'].$adminConfig['savePath'].$langFile['ERROR_FOLDER_PART2'];

/*
* userSetup.php
*/

$langFile['userSetup_h1'] = 'Benutzer-Verwaltung';
$langFile['userSetup_userSelection'] = 'Benutzer';

$langFile['userSetup_createUser'] = 'Neuen Benutzer anlegen';
$langFile['userSetup_createUser_created'] = 'Neuen Benutzer angelegt';
$langFile['userSetup_createUser_unnamed'] = 'Unbenannter Benutzer';

$langFile['userSetup_deleteUser'] = 'Benutzer l&ouml;schen';
$langFile['userSetup_deleteUser_deleted'] = 'Benutzer gel&ouml;scht';

$langFile['userSetup_username'] = 'Benutzername';
$langFile['userSetup_username_missing'] = 'Es wurde noch keine Benutzername f&uuml;r diesen Benutzer festgelegt.';
$langFile['userSetup_password'] = 'Passwort';
$langFile['userSetup_password_change'] = 'Passwort &auml;ndern';
$langFile['userSetup_password_confirm'] = 'Passwort wiederholen';
$langFile['userSetup_password_confirm_wrong'] = 'Die beiden Passw&ouml;rter stimmen nicht &uuml;berein.';
$langFile['userSetup_password_missing'] = 'Es wurde noch keine Passwort f&uuml;r diesen Benutzer festgelegt.';
$langFile['userSetup_password_success'] = 'Passwort erfolgreich ge&auml;ndert!';
$langFile['userSetup_email'] = 'E-Mail';
$langFile['userSetup_email_tip'] = 'Wenn der Benutzer sein Passwort vergessen hat, wird an diese E-Mail ein neues Passwort gesendet.';

$langFile['userSetup_admin'] = 'Administrator';
$langFile['userSetup_admin_tip'] = 'Legt fest ob der Benutzer Administratorrechte besitzt.';

$langFile['userSetup_error_create'] = '<b>Ein neuer Benutzer konnte nicht angelegt werden.</b>'.$langFile['ERROR_SAVE_FILE'].$adminConfig['basePath'].'config/user.config.php';
$langFile['userSetup_error_save'] = $langFile['ERROR_SAVE_SETTINGS'].$langFile['ERROR_SAVE_FILE'].$adminConfig['basePath'].'config/user.config.php';

/*
* pluginSetup.php
*/

// ---------- PLUGIN SETUP (on toolTips tooTips.js converts the "[" and "]" tags in the tittle attribute to "<" ">")

$langFile['pluginSetup_h1'] = 'Plugins-Einstellungen';
$langFile['pluginSetup_description'] = 'Plugins bieten erweiterte Funktionen f&uuml;r die Seiten der Webseite. Jeder Seite k&ouml;nnen die unten aktivierten Plugins hinzugef&uuml;gt werden, sofern Plugins in den <a href="?site=pageSetup">'.$langFile['pageSetup_pageConfig_h1'].'</a>, bei der jeweiligen Kategorie, aktiviert sind.<br /><br /><i>Auf der Webseite werden die Plugins mittels der <a href="http://feindura.org/api/%5BImplementation%5D/feindura.html#showPlugins">ShowPlugins()</a> Methode eingebunden.</i>';

$langFile['pluginSetup_editFiles_h1'] = 'Dateien bearbeiten';
$langFile['pluginSetup_pluginconfig_active'] = 'Plugin aktiviert';
$langFile['pluginSetup_pluginconfig_error_save'] = $langFile['ERROR_SAVE_SETTINGS'].$langFile['ERROR_SAVE_FILE'].$adminConfig['basePath'];


/*
* editor.php
*/

// ---------- page info
$langFile['editor_h1_createpage'] = 'Neue Seite erstellen';
$langFile['editor_pageinfo_lastsavedate'] = 'zuletzt bearbeitet';
$langFile['editor_pageinfo_lastsaveauthor'] = 'von';
$langFile['editor_pageinfo_linktothispage'] = 'Link zu dieser Seite';
$langFile['editor_pageinfo_id'] = 'Seiten ID';
$langFile['editor_pageinfo_id_tip'] = 'Unter dieser ID wird die Seite auf dem Server gespeichert.';
$langFile['editor_pageinfo_category'] = 'Kategorie';
$langFile['editor_pageinfo_category_noCategory'] = 'keine Kategorie (ID 0)';

$langFile['editor_block_edited'] = 'wurden bearbeitet';
$langFile['editor_pageNotSaved'] = 'noch nicht gespeichert';

// ---------- page settings
$langFile['editor_pageSettings_h1'] = 'Einstellungen';
$langFile['editor_pagestatistics_h1'] = 'Statistik';

$langFile['editor_pageSettings_title'] = 'Titel';
$langFile['editor_pageSettings_title_tip'] = 'Der Titel der Seite';
$langFile['editor_pageSettings_field1'] = 'Kurzbeschreibung';
$langFile['editor_pageSettings_field1_inputTip'] = 'Wenn das Feld leer ist, wird die Webseiten-Beschreibung aus den Webseiten-Einstellungen verwendet.';
$langFile['editor_pageSettings_field1_tip'] = 'Eine kurze Zusammenfassung der Seite. Diese kommt in die META-Tags der Seite.[br /][br /][span class=hint]'.$langFile['editor_pageSettings_field1_inputTip'].'[/span]';
$langFile['editor_pageSettings_field2'] = 'Tags';
$langFile['editor_pageSettings_field2_tip'] = 'Tags sind Stichworte f&uuml;r diese Seite.';
$langFile['editor_pageSettings_field2_tip_inputTip'] = 'Die Tags sollten mit [b]Leerzeichen[/b] getrennt werden.';
$langFile['editor_pageSettings_field3'] = 'Seitendatum';
$langFile['editor_pageSettings_field3_tip'] = 'Das Datum kann dazu verwendet werden, Seiten nach Datum zu sortieren. (z.B. bei Veranstaltungen)';
$langFile['editor_pageSettings_pagedate_before_inputTip'] = 'Text vor dem Datum::z.B. "vom 31. Juni bis".';
$langFile['editor_pageSettings_pagedate_after_inputTip'] = 'Text nach dem Datum::';
$langFile['editor_pageSettings_pagedate_day_inputTip'] = 'Tag::';
$langFile['editor_pageSettings_pagedate_month_inputTip'] = 'Monat::';
$langFile['editor_pageSettings_pagedate_year_inputTip'] = 'Jahr::[b]Format[/b] JJJJ';
$langFile['editor_pageSettings_field4'] = 'Status der Seite';
$langFile['editor_pageSettings_field4_tip'] = '[b]Nur wenn die Seite &ouml;ffentlich ist, wird diese auf der Webseite angezeigt![/b]';

$langFile['editor_pageSettings_pagedate_error'] = 'Fehlerhaftes Datumsformat';
$langFile['editor_pageSettings_pagedate_error_tip'] = 'Dieser Monat hat eventuell keine 31 Tage.[br /]Das Datum sollte folgendes Format haben:';

// ---------- page advanced settings
$langFile['editor_advancedpageSettings_h1'] = 'Erweiterte Einstellungen';

$langFile['editor_advancedpageSettings_field1'] = 'Seiten Stylesheet-Datei';
$langFile['editor_advancedpageSettings_stylesheet_ifempty'] = 'Wenn alle Felder leer sind, dann werden zuerst die Stylesheet-Einstellungen der Kategorie verwendet, wenn diese auch leer sind dann die aus den HTML-Editor-Einstellungen.';

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

$langFile['editor_savepage_error_save'] .= $langFile['ERROR_SAVE_FOLDER_PART1'].$adminConfig['savePath'].$langFile['ERROR_FOLDER_PART2'];// also in de.shared.php

// ---------- plugin settings
$langFile['editor_pluginSettings_h1'] = 'Plugin Einstellungen';

/*
* unsavedPage.php
*/

$langFile['unsavedPage_question_h1'] = '<span class="brown">Die Seite wurde ver&auml;ndert.</span><br />Willst du die Seite jetzt speichern?';

/*
* deletePage.php
*/

// ---------- DELETE PAGE
$langFile['deletePage_question_part1'] = 'M&ouml;chtest du die Seite';
$langFile['deletePage_question_part2'] = 'wirklich l&ouml;schen?';

$langFile['deletePage_finishnotexisting_part1'] = 'Die Seite';
$langFile['deletePage_finish_part2'] = 'wurde erfolgreich gel&ouml;scht';
$langFile['deletePage_notexisting_part2'] = 'existiert nicht';

$langFile['deletePage_finish_error'] = 'FEHLER: Die Seite konnte nicht gel&ouml;scht werden!';

/*
* pageThumbnailDelete.php
*/

// ---------- PAGE THUMBNAIL DELETE
$langFile['pageThumbnailDelete_question_part1'] = 'M&ouml;chtest du das Thumbnail von der Seite';
$langFile['pageThumbnailDelete_question_part2'] = 'wirklich l&ouml;schen?';

$langFile['pageThumbnailDelete_name'] = 'Der Thumbnail';
$langFile['pageThumbnailDelete_finish_part2'] = 'wurde erfolgreich gel&ouml;scht';
$langFile['pageThumbnailDelete_notexisting_part2'] = 'existiert nicht';

$langFile['pageThumbnailDelete_finish_error'] = 'FEHLER: Das Thumbnail konnte nicht gel&ouml;scht werden!';


/*
* pageThumbnailUpload.php
*/

// ---------- PAGE THUMBNAIL UPLOAD
$langFile['pagethumbnail_h1_part1'] = 'Seiten-Thumbnail f&uuml;r';
$langFile['pagethumbnail_h1_part2'] = 'hochladen';
$langFile['pagethumbnail_field1'] = 'Bild ausw&auml;hlen';

$langFile['pagethumbnail_thumbinfo_formats'] = 'Nur folgende Dateiformate sind erlaubt'; //<br /><b>JPG</b>, <b>JPEG</b>, <b>GIF</b>, <b>PNG</b>
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

// -> BACKUP

$langFile['BACKUP_TITLE_BACKUP'] = 'Backup';
$langFile['BACKUP_TITLE_RESTORE'] = 'Wiederherstellen';

$langFile['BACKUP_TITLE_RESTORE_FROMFILES'] = 'Vorhandene Backups';
$langFile['BACKUP_TITLE_RESTORE_FROMUPLOAD'] = 'Backup-Datei hochladen';

$langFile['BACKUP_BUTTON_DOWNLOAD'] = 'aktuelles Backup erstellen und herunterladen';
$langFile['BACKUP_TEXT_RESTORE'] = 'W&auml;hle hier eine <span class="logoname"><span>fein</span>dura</span> Backup-Datei aus um einen alten Stand wieder herzustellen.<br /><span class="red">Achtung! Alle derzeitigen Einstellungen und Seiten werden damit &uuml;berschrieben!</span>';

$langFile['BACKUP_TITLE_LASTBACKUPS'] = 'Backups herunterladen';
$langFile['BACKUP_TEXT_NOBACKUP'] = 'Es wurde noch kein Backup erstellt.';

$langFile['BACKUP_ERROR_FILENOTFOUND'] = 'Backup-Datei wurde nicht gefunden in:';

/*
* search.php
*/

// ---------- SEARCH
$langFile['search_h1'] = 'Seiten durchsuchen';
$langFile['search_results_h1'] = 'Suchergebnisse f&uuml;r';
$langFile['search_results_text1'] = '&Uuml;bereinstimmungen im Titel';
$langFile['search_results_text2'] = '&Uuml;bereinstimmungen im Datum oder der Kategorie';
$langFile['search_results_text3'] = '&Uuml;bereinstimmende W&ouml;rter:';
$langFile['search_results_text4'] = '&Uuml;bereinstimmenden Satz gefunden';
$langFile['search_results_text8'] = '&Uuml;bereinstimmung mit der Seiten ID';
$langFile['search_results_count'] = 'Treffer';
$langFile['search_results_time_part1'] = 'in'; // 12 Treffer in 0.32 Sekunden
$langFile['search_results_time_part2'] = 'Sekunden';


// -----------------------------------------------------------------------------------------------
// RETURN ****************************************************************************************
// -----------------------------------------------------------------------------------------------
return $langFile;

?>