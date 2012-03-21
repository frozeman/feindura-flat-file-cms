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
 * if you want to write html-code in the toolTip texts (the $langFile which have "_TOOLTIP_")
 * uses only "[" and "]" instead of "<" and ">" for the HTML-tags and use no " (write instead "), this would end the title="" tag which contains the toolTip text.
 * 
 * <samp>
 * $langFile['GROUP_TYPE_NAME'] = 'langfile example text';
 * </samp>
 * 
 * The TYPE's can be<br />
 *    - INPUT
 *    - LINK
 *    - BUTTON
 *    - TITLE
 *    - TEXT
 *    - EXAMPLE
 *    - ERROR
 *    - TOOLTIP
 * 
 * need a RETURN $langFile; at the END
 */

// -> LOGIN <-

$langFile['LOGIN_INPUT_USERNAME']                                         = 'Benutzername';
$langFile['LOGIN_INPUT_PASSWORD']                                         = 'Passwort';
$langFile['LOGIN_BUTTON_LOGIN']                                           = 'LOGIN';
$langFile['LOGIN_TEXT_COOKIESNEEDED']                                     = 'Cookies müssen aktivert sein';

$langFile['LOGIN_LINK_FORGOTPASSWORD']                                    = 'Passwort vergessen?';
$langFile['LOGIN_LINK_BACKTOLOGIN']                                       = 'zurück zum Login';
$langFile['LOGIN_BUTTON_SENDNEWPASSWORD']                                 = 'HOLEN';
$langFile['LOGIN_TEXT_NEWPASSWORDEMAIL_SUBJECT']                          = 'feindura CMS Passwort angefordert von';
$langFile['LOGIN_TEXT_NEWPASSWORDEMAIL_MESSAGE']                          = 'Du hast ein neues Passwort für dein feindura - Flat File CMS angefordert.
Dein Benutzername und dein neues Passwort lauten:';

$langFile['LOGIN_ERROR_FORGOTPASSWORD_NOEMAIL']                           = 'Der Benutzer hat keine E-Mail Adressse angegeben.';
$langFile['LOGIN_ERROR_FORGOTPASSWORD_NOTSEND']                           = 'FEHLER<br />beim senden des neuen Passworts an die vom Benutzer angegebene E-Mail Adresse.';
$langFile['LOGIN_ERROR_FORGOTPASSWORD_NOTSAVED']                          = 'FEHLER<br />Konnte das neu erzeugte Passwort nicht speichern.';
$langFile['LOGIN_ERROR_FORGOTPASSWORD_SUCCESS']                           = 'Es wurde ein neues Passwort and folgende E-Mail Adresse verschickt';

$langFile['LOGIN_ERROR_WRONGUSER']                                        = 'Benutzer nicht vorhanden';
$langFile['LOGIN_ERROR_WRONGPASSWORD']                                    = 'falsches Passwort';

$langFile['LOGIN_TEXT_LOGOUT_PART1']                                      = 'Erfolgreich ausgeloggt';
$langFile['LOGIN_TEXT_LOGOUT_PART2']                                      = 'weiter zur Webseite';

$langFile['LOGIN_TIP_AUTOLOGOUT']                                         = 'Automatischer logout';


// -> GENERAL <-

$langFile['DATE_INT']                                                     = 'JJJJ-MM-TT';
$langFile['DATE_EU']                                                      = 'TT.MM.JJJJ';
$langFile['CATEGORIES_TEXT_NONCATEGORY']                                  = 'Seiten';
$langFile['CATEGORIES_TOOLTIP_NONCATEGORY']                               = 'Seiten ohne Kategorie';
$langFile['TEXT_EXAMPLE']                                                 = 'Beispiel';

$langFile['HEADER_BUTTON_GOTOWEBSITE']                                    = 'Frontend-Bearbeitung::Klick hier um die Seiten direkt in der Webseite zu bearbeiten.';

// THUMBNAILS
$langFile['THUMBNAIL_TEXT_UNIT']                                          = 'Pixel';

$langFile['THUMBNAIL_TEXT_NAME']                                          = 'Seiten-Thumbnail';
$langFile['THUMBNAIL_TEXT_WIDTH']                                         = 'Thumbnail <b>Breite</b>';
$langFile['THUMBNAIL_TEXT_HEIGHT']                                        = 'Thumbnail <b>Höhe</b>';

$langFile['THUMBNAIL_TOOLTIP_WIDTH']                                      = 'Standardbreite::Die Breite des Thumbnails in Pixeln.[br /][br /]Das Bild wird beim hochladen auf die angegebene Größe skaliert.';
$langFile['THUMBNAIL_TOOLTIP_HEIGHT']                                     = 'Standardhöhe::Die Höhe des Thumbnails in Pixeln.[br /][br /]Das Bild wird beim hochladen auf die angegebene Größe skaliert.';

$langFile['THUMBNAIL_TEXT_RATIO']                                         = 'Seitenverhältnis';
$langFile['THUMBNAIL_TEXT_KEEPRATIO']                                     = 'Seitenverhältnis beibehalten';
$langFile['THUMBNAIL_TEXT_FIXEDRATIO']                                    = 'festes Seitenverhältnis';
$langFile['THUMBNAIL_TOOLTIP_FIXEDRATIO']                                 = 'Höhe und Breite ist fest einstellbar.';
$langFile['THUMBNAIL_TOOLTIP_KEEPRATIO_X']                                = 'Wird an der [b]Breite[/b] ausgerichtet.';
$langFile['THUMBNAIL_TOOLTIP_KEEPRATIO_Y']                                = 'Wird an der [b]Höhe[/b] ausgerichtet.';

// STYLESHEETS
$langFile['STYLESHEETS_TEXT_STYLEFILE']                                   = 'Stylesheet-Dateien';
$langFile['STYLESHEETS_TEXT_ID']                                          = 'Stylesheet-Id';
$langFile['STYLESHEETS_TEXT_CLASS']                                       = 'Stylesheet-Klasse';

$langFile['STYLESHEETS_TOOLTIP_STYLEFILE']                                = 'Hier können Stylesheet-Dateien angegeben werden, die im HTML-Editor verwendet werden um den Inhalt zu formatieren.';
$langFile['STYLESHEETS_TOOLTIP_ID']                                       = 'Hier kann eine Id-Attribut angegeben werden, das dem HTML-Editor <body> Tag zugewiesen wird.';
$langFile['STYLESHEETS_TOOLTIP_CLASS']                                    = 'Hier kann eine Class-Attribut angegeben werden, das dem HTML-Editor <body> Tag zugewiesen wird.';

$langFile['STYLESHEETS_TOOLTIP_ADDSTYLEFILE']                             = 'Stylesheet Datei hinzufügen';
$langFile['STYLESHEETS_EXAMPLE_STYLEFILE']                                = '<b>Beispiel</b> &quot;/style/layout.css&quot;';

// PATHS
$langFile['PATHS_TEXT_ABSOLUTE']                                          = 'Absoluter Pfad';
$langFile['PATHS_TEXT_RELATIVE']                                          = 'Relativer Pfad';
$langFile['PATHS_TOOLTIP_ABSOLUTE']                                       = 'Absoluter Pfad::Absoluter URI Pfad, bedeuted relativ zum Dokumenten-Wurzelverzeichnis.';
$langFile['PATHS_TOOLTIP_RELATIVE']                                       = 'Relativer Pfad::Relativer URI Pfad, bedeuted relativ zum aktuellen Dokument.';

// STATISTICS
$langFile['STATISTICS_TITLE_BROWSERCHART']                                = 'Browserspektrum der Besucher';
$langFile['STATISTICS_TEXT_ROBOTCOUNT']                                   = 'Web-Crawler';
$langFile['STATISTICS_TOOLTIP_ROBOTCOUNT']                                = 'Web-Crawler::Oder auch Robots genannt sind Programmscripte von Suchmaschienen, die Seiten analysieren und indizieren.';

$langFile['STATISTICS_TEXT_SEARCHWORD_PART1']                             = 'hat'; // "exampleword" led 20 times to this website
$langFile['STATISTICS_TEXT_SEARCHWORD_PART2']                             = 'mal auf diese Seite geführt';
$langFile['STATISTICS_TOOLTIP_SEARCHWORD']                                = 'Anklicken um nach diesem Suchwort in allen Seiten zu suchen.';

$langFile['STATISTICS_TEXT_VISITORCOUNT']                                 = 'Besucher';
$langFile['STATISTICS_TEXT_CURRENTVISITORS']                              = 'aktuelle Besucher';
$langFile['STATISTICS_TEXT_LASTACTIVITY']                                 = 'letzte Aktivität';

$langFile['STATISTICS_TITLE_PAGESTATISTICS']                              = 'Seiten Statistiken';

$langFile['STATISTICS_TEXT_VISITTIME_MAX']                                = 'längste Verweildauer';
$langFile['STATISTICS_TEXT_VISITTIME_MIN']                                = 'kürzeste Verweildauer';
$langFile['STATISTICS_TEXT_FIRSTVISIT']                                   = 'erster Besuch';
$langFile['STATISTICS_TEXT_LASTVISIT']                                    = 'letzter Besuch';
$langFile['STATISTICS_TEXT_NOVISIT']                                      = 'Es hat noch niemand diese Seite besucht.';
$langFile['STATISTICS_TEXT_SEARCHWORD_DESCRIPTION']                       = 'Suchworte die von
<a href                                                                   ="http://www.google.de">Google</a>,
<a href                                                                   ="http://www.yahoo.de">Yahoo</a> oder
<a href                                                                   ="http://www.bing.com">Bing (MSN)</a> auf diese Seite geführt haben';

$langFile['STATISTICS_TEXT_HOUR_SINGULAR']                                = 'Stunde';
$langFile['STATISTICS_TEXT_HOUR_PLURAL']                                  = 'Stunden';
$langFile['STATISTICS_TEXT_MINUTE_SINGULAR']                              = 'Minute';
$langFile['STATISTICS_TEXT_MINUTE_PLURAL']                                = 'Minuten';
$langFile['STATISTICS_TEXT_SECOND_SINGULAR']                              = 'Sekunde';
$langFile['STATISTICS_TEXT_SECOND_PLURAL']                                = 'Sekunden';

$langFile['STATISTICS_TEXT_BROWSERCHART_OTHERS']                          = 'Sonstige';

// LOG TEXTS
$langFile['LOG_PAGE_SAVED']                                               = 'Seite gespeichert';
$langFile['LOG_PAGE_NEW']                                                 = 'Neue Seite erstellt';
$langFile['LOG_PAGE_DELETE']                                              = 'Seite gelöscht';

$langFile['LOG_PAGE_MOVEDINCATEGORY']                                     = 'Seite in Kategorie verschoben';
$langFile['LOG_PAGE_MOVEDINCATEGORY_CATEGORY']                            = 'in Kategorie'; // Example Page in Category
$langFile['LOG_PAGE_SORTED']                                              = 'Seite neu sortiert';

$langFile['LOG_THUMBNAIL_UPLOAD']                                         = 'Neues Thumbnail hochgeladen';
$langFile['LOG_THUMBNAIL_DELETE']                                         = 'Thumbnail gelöscht';

$langFile['LOG_USER_ADD']                                                 = 'Neuen Benutzer angelegt';
$langFile['LOG_USER_DELETED']                                             = 'Benutzer gelöscht';
$langFile['LOG_USER_PASSWORD_CHANGED']                                    = 'Benutzerpasswort geändert';
$langFile['LOG_USER_SAVED']                                               = 'Benutzer gespeichert';

$langFile['LOG_ADMINSETUP_SAVED']                                         = 'Administrator-Einstellungen gespeichert';
$langFile['LOG_ADMINSETUP_CKSTYLES']                                      = '&quot;Stil-Auswahl&quot; des HTML-Editors gespeichert';

$langFile['LOG_WEBSITESETUP_SAVED']                                       = 'Webseiten-Einstellungen gespeichert';

$langFile['LOG_STATISTICSETUP_SAVED']                                     = 'Statistik-Einstellungen gespeichert';
$langFile['LOG_CLEARSTATISTICS_WEBSITESTATISTIC']                         = 'Webseiten-Statistik gelöscht';
$langFile['LOG_CLEARSTATISTICS_PAGESTATISTICS']                           = 'Seiten-Statistiken gelöscht';
$langFile['LOG_CLEARSTATISTICS_PAGESTAYLENGTH']                           = 'Seiten-Verweildauer-Statistiken gelöscht';
$langFile['LOG_CLEARSTATISTICS_REFERERLOG']                               = 'Referrer-Log gelöscht';
$langFile['LOG_CLEARSTATISTICS_ACTIVITYLOG']                              = 'letzte Tätigkeiten-Log gelöscht';

$langFile['LOG_PAGESETUP_SAVED']                                          = 'Seiten-Einstellungen gespeichert';
$langFile['LOG_PAGESETUP_CATEGORIES_SAVED']                               = 'Kategorien gespeichert';

$langFile['LOG_PAGESETUP_CATEGORIES_NEW']                                 = 'Neue Kategorie erstellt';
$langFile['LOG_PAGESETUP_CATEGORIES_DELETED']                             = 'Kategorie gelöscht';
$langFile['LOG_PAGESETUP_CATEGORIES_MOVED']                               = 'Kategorie verschoben';

$langFile['LOG_FILE_SAVED']                                               = 'Datei gespeichert';
$langFile['LOG_FILE_DELETED']                                             = 'Datei gelöscht';

$langFile['LOG_BACKUP_CREATED']                                           = 'Backup erstellt';
$langFile['LOG_BACKUP_RESTORED']                                          = 'Backup wiederhergestellt';
$langFile['LOG_BACKUP_DELETED']                                           = 'Backup gelöscht';

// PAGE/CATEGORY STATUS
$langFile['STATUS_PAGE_PUBLIC']                                           = 'Seite ist öffentlich';
$langFile['STATUS_PAGE_NONPUBLIC']                                        = 'Seite ist versteckt';

$langFile['STATUS_CATEGORY_PUBLIC']                                       = 'Kategorie ist öffentlich';
$langFile['STATUS_CATEGORY_NONPUBLIC']                                    = 'Kategorie ist versteckt';

// USER LIST
$langFile['USER_TEXT_NOUSER']                                             = 'Es sind keine Benutzer vorhanden';
$langFile['USER_TEXT_CURRENTUSER']                                        = 'Du bist unter diesem Benutzernamen eingeloggt';
$langFile['USER_TEXT_USERSONLINE']                                        = 'Dieser Benutzer ist ebenfalls eingeloggt::Letzte Aktivität';

$langFile['LOGO_TEXT']                                                    = 'Version';
$langFile['LOADING_TEXT_LOAD']                                            = 'Seite wird geladen..';

// CKEDITOR transport
$langFile['CKEDITOR_TITLE_LINKS']                                         = 'feindura Seiten';

// -> BUTTON TEXTS

// MAIN MENU
$langFile['BUTTON_DASHBOARD']                                             = 'Übersicht';
$langFile['BUTTON_PAGES']                                                 = 'Seiten';
$langFile['BUTTON_ADDONS']                                                = 'Addons';
$langFile['BUTTON_WEBSITESETTINGS']                                       = 'Webseiten Einstellungen';
$langFile['BUTTON_SEARCH']                                                = 'Seiten durchsuchen';

// ADMIN MENU
$langFile['HEADER_TITLE_ADMINMENU']                                       = 'Administration';
$langFile['BUTTON_ADMINSETUP']                                            = 'Administrator Einstellungen';
$langFile['BUTTON_PAGESETUP']                                             = 'Seiten Einstellungen';
$langFile['BUTTON_STATISTICSETUP']                                        = 'Statistik Einstellungen';
$langFile['BUTTON_USERSETUP']                                             = 'Benutzer';
$langFile['BUTTON_BACKUP']                                                = 'Backups';

// SUB MENU/FOOTER
$langFile['BUTTON_FILEMANAGER']                                           = 'Dateimanager';
$langFile['BUTTON_TOOLTIP_FILEMANAGER']                                   = 'Dateien und Bilder verwalten.';
$langFile['BUTTON_CREATEPAGE']                                            = 'Neue Seite';
$langFile['BUTTON_TOOLTIP_CREATEPAGE']                                    = 'Neue Seite erstellen.';
$langFile['BUTTON_DELETEPAGE']                                            = 'Seite löschen';
$langFile['BUTTON_TOOLTIP_DELETEPAGE']                                    = 'Diese Seite löschen.';
$langFile['BUTTON_FRONTENDEDITPAGE']                                      = 'Seite im Frontend bearbeiten';
$langFile['BUTTON_TOOLTIP_FRONTENDEDITPAGE']                              = 'Diese Seite direkt in der Website bearbeiten.';
$langFile['BUTTON_THUMBNAIL_UPLOAD']                                      = 'Seiten-Thumbnail hochladen';
$langFile['BUTTON_TOOLTIP_THUMBNAIL_UPLOAD']                              = 'Thumbnail für diese Seite hochladen.';
$langFile['BUTTON_THUMBNAIL_DELETE']                                      = 'Seiten-Thumbnail löschen';
$langFile['BUTTON_TOOLTIP_THUMBNAIL_DELETE']                              = 'Thumbnail von dieser Seite löschen.';

// OTHER BUTTONS
$langFile['BUTTON_UP']                                                    = 'Nach oben';


// -> GENERAL ERROR TEXTS
$langFile['ERROR_SAVE_SETTINGS']                                          = '<b>Die Einstellungen konnten nicht gespeichert werden.</b>';
$langFile['ERROR_SAVE_FILE']                                              = '<br /><br />Bitte überprüfe die Schreibrechte der Datei: ';

$langFile['ERROR_READ_FOLDER_PART1']                                      = '<br /><br />Bitte überprüfe die Leserechte des &quot;';
$langFile['ERROR_SAVE_FOLDER_PART1']                                      = '<br /><br />Bitte überprüfe die Schreibrechte des &quot;';

$langFile['ERROR_FOLDER_PART2']                                           = '&quot; Ordners dessen Unterordner und Dateien.';

// -> WARNINGS
$langFile['WARNING_TITLE_STARTPAGE']                                      = 'Die Startseite ist nicht festgelegt!';
$langFile['WARNING_TEXT_STARTPAGE']                                       = 'Bitte lege eine Seite als Startseite fest.<br />Gehe zu <a href="?site=pages">'.$langFile['BUTTON_PAGES'].'</a> und klicke bei der gewünschten Seite auf das <span class="startPageIcon"></span> Symbol';

$langFile['WARNING_TITLE_DOCUMENTROOT']                                   = 'Das Dokumenten-Wurzelverzeichnis konnte nicht automatisch bestimmt werden!';
$langFile['WARNING_TEXT_DOCUMENTROOT']                                    = 'Um das Dokumenten-Wurzelverzeichnis korrekt auflösen zu können, trage bitte den &quot;echten feindura Pfad&quot; deines <span class="logoname">fein<span>dura</span></span> CMS in den <a href="?site=adminSetup#adminSettings">Administrator-Einstellungen</a> ein.';

$langFile['WARNING_TITLE_BASEPATH']                                       = '<span class="logoname">fein<span>dura</span></span> wurde noch nicht konfiguriert!';
$langFile['WARNING_TEXT_BASEPATH']                                        = 'Der <i>Basispfad</i> stimmt nicht mit dem in den Administrator-Einstellungen angegebenen Pfad überein.<br />
Bitte gehe in die <a href                                                 ="?site=adminSetup#adminSettings">Administrator-Einstellungen</a> und konfiguriere dein <span class="logoname">fein<span>dura</span></span> CMS';

$langFile['WARNING_TITLE_JAVASCRIPT']                                     = 'Bitte aktiviere Javascript';
// no <p> tag on the start and the end, its already in the dashboard.php
$langFile['WARNING_TEXT_JAVASCRIPT']                                      = '<strong>Um <span class="logoname">fein<span>dura</span></span> voll nutzen zu können, muss Javascript aktiviert sein!</strong></p>
<h2>im Firefox</h2>
<p>Klicke in der obersten Menüleiste auf &quot;Bearbeiten&quot; > &quot;Einstellungen&quot;. Unter Inhalt aktivierst du den Punkt "JavaScript aktivieren" und bestätigst dann mit OK.</p>
<h2>im Internet Explorer</h2>
<p>Klicke in der obersten Menüleiste auf "Extras" > "Internetoptionen".<br />
Dort klickst du unter Sicherheit entweder auf "Standardstufe", oder wähle "Stufe anpassen" und aktiviere dann unter Scripting den Punkt "Active Scripting Aktivieren". Bestätige mit OK.</p>
<h2>im Safari</h2>
<p>Klicke in der obersten Menüleiste auf das Symbol ganz rechts, wähle "Einstellungen". Unter "Sicherheit" aktivierst du den Punkt "JavaScript aktivieren" und klicke zum bestätigen auf OK.</p>
<h2>im Mozilla</h2>
<p>Klicke in der obersten Menüleiste auf "Edit" > "Preferences". Unter dem Punkt "Advanced" > "Scripts & Plugins" kreuze "Navigator" an. Bestätige mit OK.</p>
<h2>im Opera</h2>
<p>Klicke in der obersten Menüleiste auf "Extras" > "Einstellungen". Unter "Erweitert" > "Inhalte" setze ein Haken bei "JavaScript aktivieren" und klicke dann OK.';

$langFile['DASHBOARD_TITLE_IEWARNING']                                    = '<span class="logoname">fein<span>dura</span></span> ist nicht für ältere Versionen des Internet Explorers ausgelegt';
$langFile['DASHBOARD_TEXT_IEWARNING']                                     = 'Um das <span class="logoname">fein<span>dura</span></span> CMS vollständig nutzen zu können ist mindestens der Internet Explorer 8 nötig.<br /><br />Bitte installiere eine neuere Version des Internet Explorers,<br /> oder installiere das <a href="http://www.google.com/chromeframe" target="_blank">Google Chrome Frame Plugin</a> für den Internet Explorer,<br />oder lade dir den kostenlosen <a href="http://www.mozilla.org/firefox/">Firefox</a> oder <a href="http://www.google.com/chrome/">Chrome</a> Browser herunter.';

$langFile['GENERAL_TEXT_CURRENTLYEDITED']                                 = 'Seite wird gerade bearbeitet...';

/*
* leftSidebar.loader.php
*/

// ---------- QUICKMENU

$langFile['SIDEBARMENU_TITLE_CATEGORIES']                                 = 'Kategorien';
$langFile['SIDEBARMENU_TITLE_PAGES']                                      = 'Seiten von';

/*
* dashboard.php
*/

// ---------- DASHBOARD
$langFile['DASHBOARD_TITLE_USERINFO']                                     = 'Benutzer Information';

$langFile['DASHBOARD_TITLE_WELCOME']                                      = 'Willkommen in <span class="logoname">fein<span>dura</span></span>,<br />dem Content Management System deiner Webseite';
$langFile['DASHBOARD_TEXT_WELCOME']                                       = '<span class="logoname">fein<span>dura</span></span> ist ein auf <span class="toolTip" title="Flat-Files::Das sind Dateien auf dem Server, in denen der Inhalt der Webseite gespeichert wird.">Flat-Files</span> basierendes Content Management System.<br />Hier kannst du den Inhalt deiner Webseite verwalten.';

$langFile['DASHBOARD_TITLE_STATISTICS']                                   = 'Webseiten-Statistik';

$langFile['DASHBOARD_TITLE_USER']                                         = 'Benutzer';
$langFile['DASHBOARD_TITLE_ACTIVITY']                                     = 'letzte Tätigkeiten';
$langFile['DASHBOARD_TEXT_ACTIVITY_NONE']                                 = 'keine';

$langFile['DASHBOARD_TITLE_STATISTICS_MOSTVISITED']                       = 'meist besuchte Seiten';
$langFile['DASHBOARD_TITLE_STATISTICS_LASTVISITED']                       = 'zuletzt besuchte Seiten';
$langFile['DASHBOARD_TITLE_STATISTICS_LASTEDITED']                        = 'zuletzt bearbeitete Seiten';
$langFile['DASHBOARD_TITLE_STATISTICS_LONGESTVIEWED']                     = 'am längsten betrachtete Seiten';

$langFile['DASHBOARD_TITLE_REFERER']                                      = 'Webseiten von denen die letzten Besucher gekommen sind';

/*
* listPages.php
*/

// ---------- PAGES SORTABLE LIST
$langFile['sortablePageList_h1']                                          = 'Der Inhalt deiner Webseite';
$langFile['sortablePageList_headText1']                                   = 'Filter';
$langFile['sortablePageList_headText2']                                   = 'zuletzt bearbeitet';
$langFile['sortablePageList_headText3']                                   = 'Besucher';
$langFile['sortablePageList_headText4']                                   = 'Status';
$langFile['sortablePageList_headText5']                                   = 'Funktionen';

$langFile['sortablePageList_pagedate']                                    = 'Seiten-Datum';
$langFile['sortablePageList_tags']                                        = 'Tags';

$langFile['SORTABLEPAGELIST_TIP_SORTALPHABETICAL']                        = 'alphabetisch sortiert';
$langFile['SORTABLEPAGELIST_TIP_SORTBYPAGEDATE']                          = 'nach Seitendatum sortiert';

$langFile['sortablePageList_functions_editPage']                          = 'Seite bearbeiten';

$langFile['sortablePageList_changeStatus_linkPage']                       = 'Hier klicken um den Status für Seite zu ändern.';
$langFile['sortablePageList_changeStatus_linkCategory']                   = 'Hier klicken um den Status für die Kategorie zu ändern.';

$langFile['file_error_read']                                              = '<b>Die Seite konnte nicht gelesen werden.</b>'.$langFile['ERROR_READ_FOLDER_PART1'].'%spages/'.$langFile['ERROR_FOLDER_PART2'];
$langFile['sortablePageList_changeStatusPage_error_save']                 = '<b>Der Status der Seite konnte nicht geändert werden.</b>'.$langFile['ERROR_SAVE_FOLDER_PART1'].'%spages/'.$langFile['ERROR_FOLDER_PART2'];
$langFile['sortablePageList_setStartPage_error_save']                     .= $langFile['ERROR_SAVE_FILE'].' &quot;%sconfig/website.config.php&quot;'; // also in de.shared.php
$langFile['sortablePageList_changeStatusCategory_error_save']             = '<b>Der Status der Kategorie konnte nicht geändert werden.</b>'.$langFile['ERROR_SAVE_FOLDER_PART1'].'%spages/'.$langFile['ERROR_FOLDER_PART2'];

$langFile['sortablePageList_info']                                        = 'Du kannst die <b>Seiten-Anordnung</b> per <b>Drag and Drop</b> verändern und auch Seiten zwischen den Kategorien verschieben.';
$langFile['sortablePageList_save']                                        = 'Speichere die neue Anordnung ...';
$langFile['sortablePageList_save_finished']                               = 'Neu Anordnung erfolgreich gespeichert!';
$langFile['sortablePageList_error_save']                                  = '<b>Die Seiten konnten nicht gespeichert werden.</b>'.$langFile['ERROR_SAVE_FOLDER_PART1'].'%spages/'.$langFile['ERROR_FOLDER_PART2'];
$langFile['sortablePageList_error_read']                                  = '<b>Die Seiten konnten nicht gelesen werden.</b>'.$langFile['ERROR_READ_FOLDER_PART1'].'%spages/'.$langFile['ERROR_FOLDER_PART2'];
$langFile['sortablePageList_error_move']                                  = '<b>Konnte die Seite nicht in die neue Kategorie verschieben.</b>'.$langFile['ERROR_SAVE_FOLDER_PART1'].'%spages/'.$langFile['ERROR_FOLDER_PART2'];
$langFile['sortablePageList_categoryEmpty']                               = 'Keine Seiten vorhanden';

// ---------- FORMULAR
$langFile['FORM_BUTTON_SUBMIT']                                           = 'Speichern';
$langFile['FORM_BUTTON_CANCEL']                                           = 'Alle Eingaben zurücksetzen';

/*
* adminSetup.php
*/

// ---------- ADMIN SETUP (on toolTips tooTips.js converts the "[" and "]" tags in the title attribute to "<" ">")
$langFile['ADMINSETUP_TEXT_VERSION']                                      = '<span class="logoname">fein<span>dura</span></span> Version';
$langFile['ADMINSETUP_TEXT_PHPVERSION']                                   = 'PHP Version';
$langFile['ADMINSETUP_TITLE_DOCUMENTROOT']                                = 'Dokumenten-Wurzelverzeichnis';

$langFile['ADMINSETUP_TITLE_ERROR']                                       = 'Es sind Fehler aufgetreten';
$langFile['ADMINSETUP_TOOLTIP_WRITEACCESSERROR']                          = 'Bei Dateien und Verzeichnissen müssen die Schreibrechte auf %o gesetzt werden.';

$langFile['ADMINSETUP_TEXT_WRITEACCESSERROR']                             = 'ist nicht beschreibbar';
$langFile['ADMINSETUP_TEXT_ISFOLDERERROR']                                = 'ist kein Verzeichnis';

// ---------- general Settings
$langFile['ADMINSETUP_GENERAL_error_save']                                = $langFile['ERROR_SAVE_SETTINGS'].$langFile['ERROR_SAVE_FILE'].'%sconfig/admin.config.php';

$langFile['ADMINSETUP_GENERAL_h1']                                        = 'Grund-Einstellungen';

$langFile['ADMINSETUP_GENERAL_field1']                                    = 'Webseiten-URL';
$langFile['ADMINSETUP_GENERAL_field1_tip']                                = 'Die URL ihrer Webseite wird automatisch eingefügt.';
$langFile['ADMINSETUP_GENERAL_field1_inputTip']                           = 'Die URL wird automatisch eingefügt';
$langFile['ADMINSETUP_GENERAL_field1_inputWarningText']                   = 'Bitte speichere die Einstellungen!';
$langFile['ADMINSETUP_GENERAL_field2']                                    = 'feindura-Pfad';
$langFile['ADMINSETUP_GENERAL_field2_tip']                                = 'Der Hauptpfad wird automatisch ermittelt und beim speichern der Einstellungen übernommen.';
$langFile['ADMINSETUP_GENERAL_field2_inputTip']                           = 'Der Pfad wird automatisch eingefügt';
$langFile['ADMINSETUP_GENERAL_field2_inputWarningText']                   = 'Bitte speichere die Einstellungen!';
$langFile['ADMINSETUP_GENERAL_TEXT_REALBASEPATH']                         = 'Echter feindura Pfad';
$langFile['ADMINSETUP_GENERAL_TOOLTIP_REALBASEPATH']                      = 'Der echte dateisystem-basierte Pfad deines [span class=logoname]fein[span]dura[/span][/span] cms, relativ zum Dokumenten-Wurzelverzeichnis.';
$langFile['ADMINSETUP_GENERAL_EXAMPLE_REALBASEPATH']                      = '<b>Beispiel</b> &quot;/cms/&quot;';
$langFile['ADMINSETUP_GENERAL_field8']                                    = 'Webseitenpfad';
$langFile['ADMINSETUP_GENERAL_field8_tip']                                = 'Der [b]absolute Pfad[/b], unter dem sich die Webseite befindet.';
$langFile['ADMINSETUP_GENERAL_field4']                                    = 'Daten-Uploadpfad';
$langFile['ADMINSETUP_GENERAL_field4_tip']                                = 'Hier werden Dateien wie Bilder, Flash-Animation oder Dokumente hochgeladen.[br /][br /][span class=hint]Dateien werden im HTML-Editor unter Link-einfügen > Upload hochgeladen oder im Dateimanager.[/span]';
$langFile['ADMINSETUP_GENERAL_editfiles_additonal']                       = '[br /][br /]Diese Dateien können dann weiter unten oder in den Webseiten-Einstellungen bearbeitet werden (sollte dies in den Benutzer-Einstellungen aktiviert sein).[br /][br /]';
$langFile['ADMINSETUP_GENERAL_field5']                                    = 'Pfad für Webseitendateien';
$langFile['ADMINSETUP_GENERAL_field5_tip']                                = 'Ein Verzeichnispfad mit Dateien. Diese Dateien können z.B. verwendet werden um eine Webseite mehrsprachig zu gestalten.'.$langFile['ADMINSETUP_GENERAL_editfiles_additonal'];
$langFile['ADMINSETUP_GENERAL_field6']                                    = 'Pfad für Stylesheetdateien';
$langFile['ADMINSETUP_GENERAL_field6_tip']                                = 'Ein [b]absoluter Pfad[/b] in dem sich Stylesheet-Dateien befinden, die z.B. vom Benutzer bearbeitet werden können.'.$langFile['ADMINSETUP_GENERAL_editfiles_additonal'];
$langFile['ADMINSETUP_GENERAL_TEXT_PERMISSIONS']                          = 'Schreibrechte für Dateien und Verzeichnisse';
$langFile['ADMINSETUP_GENERAL_TIP_PERMISSIONS']                           = 'Jeder von [span class=logoname]fein[span]dura[/span][/span] erstellten Datei oder Verzeichnis wird versucht diese Schreibrechte zuzuweisen.';
$langFile['ADMINSETUP_GENERAL_varName_ifempty']                           = 'Wenn das Feld leer ist, wird der Standard Name für die GET-Variablen verwendet: ';
$langFile['ADMINSETUP_GENERAL_varName1']                                  = 'Seiten Variablenname';
$langFile['ADMINSETUP_GENERAL_varName1_inputTip']                         = $langFile['ADMINSETUP_GENERAL_varName_ifempty'].'&quot;[b]page[/b]&quot;';
$langFile['ADMINSETUP_GENERAL_varName2']                                  = 'Kategorie Variablenname';
$langFile['ADMINSETUP_GENERAL_varName2_inputTip']                         = $langFile['ADMINSETUP_GENERAL_varName_ifempty'].'&quot;[b]category[/b]&quot;';
$langFile['ADMINSETUP_GENERAL_varName3']                                  = 'Modul Variablenname';
$langFile['ADMINSETUP_GENERAL_varName3_inputTip']                         = $langFile['ADMINSETUP_GENERAL_varName_ifempty'].'&quot;[b]modul[/b]&quot;';
$langFile['ADMINSETUP_GENERAL_varName_tip']                               = 'Der Name der [b]$_GET Variable[/b] die für die Seiten Verlinkung verwendet wird.';
$langFile['ADMINSETUP_GENERAL_field7']                                    = 'Datumsformat';
$langFile['ADMINSETUP_GENERAL_field7_tip']                                = 'Wird in [span class=logoname]fein[span]dura[/span][/span] und der Webseite verwendet.[br /]Entweder:[br /]DIN 5008 ('.$langFile['DATE_EU'].') oder[br /]ISO 8601 ('.$langFile['DATE_INT'].')';
$langFile['ADMINSETUP_TEXT_TIMEZONE']                                     = 'Zeitzone';
$langFile['ADMINSETUP_TIP_TIMEZONE']                                      = 'Wird nur für das [span class=logoname]fein[span]dura[/span][/span] Backend verwendet.';
$langFile['ADMINSETUP_GENERAL_speakingUrl']                               = 'URL Format';
$langFile['ADMINSETUP_GENERAL_speakingUrl_true']                          = 'Speaking URLs';
$langFile['ADMINSETUP_GENERAL_speakingUrl_true_example']                  = '/category/beispiel_category/beispiel.html';
$langFile['ADMINSETUP_GENERAL_speakingUrl_false']                         = 'URLs mit Variablen';
$langFile['ADMINSETUP_GENERAL_speakingUrl_false_example']                 = 'index.php?%s=1&%s=1';
$langFile['ADMINSETUP_GENERAL_speakingUrl_tip']                           = 'Das URL Format, welches für die Seiten-Verlinkung verwendet wird.[br /][br /]Speaking URLs funktionieren nur wenn im [b]Apache[/b] das [b]mod_rewrite[/b] Modul verfügbar ist.';
$langFile['ADMINSETUP_GENERAL_speakingUrl_warning']                       = 'WARNUNG!::[span class=red]Sollten Fehler bei der Vewendung von Speaking URLs auftreten, muss die [b].htaccess Datei[/b] im Dokumenten-Root Pfad des Webservers gelöscht werden.[/span][br /][br /](In manchen FTP-Programmen muss man erst die versteckten Dateien anzeigen, um die .htaccess Datei sichtbar zu machen)';

// ---------- speaking url ERRORs
$langFile['ADMINSETUP_GENERAL_speakingUrl_error_save']                    = '<b>Speaking URLs</b> konnte nicht aktiviert werden'.$langFile['ERROR_SAVE_FILE'].'/.htaccess';
$langFile['ADMINSETUP_GENERAL_speakingUrl_error_modul']                   = '<b>Speaking URLs</b> konnte nicht aktiviert werden da das Apache modul: MOD_REWRITE nicht gefunden wurde';


// ---------- user Settings
$langFile['ADMINSETUP_USERPERMISSIONS_TITLE']                             = 'Benutzerrechte';
$langFile['ADMINSETUP_USERPERMISSIONS_check1']                            = 'Webseitendateien in den Webseiten-Einstellungen bearbeiten';
$langFile['ADMINSETUP_USERPERMISSIONS_check2']                            = 'Stylesheetdateien in den Webseiten-Einstellungen bearbeiten';
$langFile['ADMINSETUP_USERPERMISSIONS_TEXT_FILEMANAGER']                  = 'Dateimanager aktivieren';
$langFile['ADMINSETUP_USERPERMISSIONS_TIP_WARNING_FILEMANAGER']           = 'Dateimanager deaktiviert::Du musst erst den Daten-Uploadpfad in den Grund-Einstellungen einstellen, bevor du den Dateimanager aktivieren kannst.';
$langFile['ADMINSETUP_USERPERMISSIONS_TEXT_FRONTENDEDITING']              = 'Frontend-Bearbeitung aktivieren';

$langFile['ADMINSETUP_USERPERMISSIONS_textarea1']                         = '<strong>Benutzerinformation</strong> in der <a href="?site=dashboard">'.$langFile['BUTTON_DASHBOARD'].'</a>';
$langFile['ADMINSETUP_USERPERMISSIONS_textarea1_tip']                     = 'Benutzerinformationen::Dieser Text wird auf der [span class=logoname]fein[span]dura[/span][/span] '.$langFile['BUTTON_DASHBOARD'].' angezeigt.';
$langFile['ADMINSETUP_USERPERMISSIONS_textarea1_inputTip']                = 'Wenn Du keine Informationen für den Benutzer anzeigen möchtest lasse das Feld leer';

// ---------- editor Settings
$langFile['adminSetup_editorSettings_h1']                                 = 'HTML-Editor-Einstellungen';
$langFile['ADMINSETUP_TEXT_EDITOR_HTMLLAWED']                             = 'HTML filtern (verwendet <a href="http://www.bioinformatics.org/phplabware/internal_utilities/htmLawed/">htmlLawed</a>)';
$langFile['ADMINSETUP_TIP_EDITOR_HTMLLAWED']                              = 'Filtert den HTML-Code bevor er gespeichert wird, das kann jedoch bei HTML-Code mit viel Javascript zu Problemen führen.';
$langFile['ADMINSETUP_TEXT_EDITOR_SAFEHTML']                              = 'sicheres HTML (<a href="http://www.bioinformatics.org/phplabware/internal_utilities/htmLawed/htmLawed_README.htm#s3.6">Details</a>)';
$langFile['ADMINSETUP_TIP_EDITOR_SAFEHTML']                               = 'Dadurch wird der HTML-Code mit den sichersten Einstellungen gefiltert, d.h. zum Beispiel dass keine &lt;applet&gt;,&lt;embed&gt;,&lt;embed&gt;,&lt;object &gt; und &lt;script&gt; Tags erlaubt sind.';
$langFile['adminSetup_editorSettings_field1']                             = 'ENTER-Taste Modus';
$langFile['adminSetup_editorSettings_field1_hint']                        = 'SHIFT + ENTER erzeugt immer ein &quot;&lt;br&gt;&quot;';
$langFile['adminSetup_editorSettings_field1_tip']                         = 'Legt fest welcher HTML-Tag beim drücken der ENTER-Taste gesetzt wird.[br /][br /][span class=hint]'.$langFile['adminSetup_editorSettings_field1_hint'].'.[/span]';
$langFile['adminSetup_editorSettings_field3_inputTip']                    = 'Wenn das Feld leer ist, wird keine Id verwendet.';
$langFile['adminSetup_editorSettings_field4_inputTip']                    = 'Wenn das Feld leer ist, wird keine Klasse verwendet.';

// THUMBNAILS Settings
$langFile['adminSetup_thumbnailSettings_h1']                              = 'Seiten-Thumbnail-Einstellungen';
$langFile['adminSetup_thumbnailSettings_field3']                          = 'Speicherpfad'; // Thumbnail-Speicherpfad
$langFile['adminSetup_thumbnailSettings_field3_tip']                      = 'Der Pfad innerhalb des Daten-Upload Pfads, in dem die Thumbnails gespeichert werden.';
$langFile['adminSetup_thumbnailSettings_field3_inputTip1']                = 'Der Daten-Upload Pfad';
$langFile['adminSetup_thumbnailSettings_field3_inputTip2']                = 'Relativer Pfad::Relativ zum &quot;[b]%s[/b]&quot; Pfad.[br /][br /]Beginnt ohne &quot;/&quot;';
$langFile['adminSetup_thumbnailSettings_field3_inputTip3']                = '<b>'.$langFile['TEXT_EXAMPLE'].'</b> &quot;thumbnails/&quot; ';

// ---------- styleFile Settings
$langFile['adminSetup_styleFileSettings_h1']                              = '&quot;Stil&quot;-Auswahl des HTML-Editors bearbeiten';
$langFile['adminSetup_styleFileSettings_error_save']                      = '<b>Die Datei &quot;htmlEditorStyles.js&quot; konnte nicht gespeichert werden.</b>'.$langFile['ERROR_SAVE_FILE'];

// ---------- editFiles Settings
$langFile['editFilesSettings_error_save']                                 = '<b>Die Datei konnte nicht gespeichert werden.</b>'.$langFile['ERROR_SAVE_FILE'];

$langFile['editFilesSettings_h1_style']                                   = 'Stylesheetdateien bearbeiten';
$langFile['editFilesSettings_h1_websitefiles']                            = 'Webseitendateien bearbeiten';
$langFile['editFilesSettings_noDir']                                      = 'ist kein gültiges Verzeichnis!';
$langFile['editFilesSettings_chooseFile']                                 = 'Datei auswählen';
$langFile['editFilesSettings_createFile']                                 = 'Neue Datei anlegen';
$langFile['editFilesSettings_createFile_inputTip']                        = 'Wenn hier ein Dateiname eingetragen wird, dann wird eine Neue Datei erstellt,[br /]und [b]die derzeit ausgewählte Datei wird nicht gespeichert![/b]';
$langFile['editFilesSettings_noFile']                                     = 'Es sind noch keine Dateien vorhanden';

$langFile['editFilesSettings_deleteFile']                                 = 'Datei löschen';
$langFile['editFilesSettings_deleteFile_question_part1']                  = 'Datei'; // Kategorie "test" löschen?
$langFile['editFilesSettings_deleteFile_question_part2']                  = 'wirklich löschen?';

$langFile['editFilesSettings_deleteFile_error_delete']                    = '<b>Die Datei konnte nicht gelöscht werden.</b>'.$langFile['ERROR_SAVE_FILE'];

/*
* pageSetup.php
*/

// ---------- CATEGORY SETUP (on toolTips tooTips.js converts the "[" and "]" tags in the title attribute to "<" ">")
$langFile['PAGESETUP_PAGES_TIP_TAG']                                      = 'Tags können dazu verwendet werden Seiten untereinander in Beziehung zu setzen (abhängig von der Programmierung der Webseite)';

// ---------- page settings
$langFile['PAGESETUP_PAGES_TITLE_PAGESETTINGS']                           = 'Seiten-Einstellungen';
$langFile['PAGESETUP_PAGES_TEXT_SETSTARTPAGE']                            = 'Startseite ist einstellbar';
$langFile['PAGESETUP_PAGES_TIP_SETSTARTPAGE']                             = 'Startseite ist vom Benutzer selbst einstellbar.[br /][br /]Die eingestellte Startseite wird angezeigt wenn keine Seiten-Variablen in der Webseite übergeben werden bzw. keine Seite aufgerufen wurde.';

$langFile['PAGESETUP_PAGES_TITLE_NONCATEGORYPAGES']                       = 'Seiten ohne Kategorie';
$langFile['PAGESETUP_PAGES_TEXT_CREATEPAGES']                             = 'Seiten erstellen/löschen';
$langFile['PAGESETUP_PAGES_TIP_CREATEPAGES']                              = 'Legt fest ob der Benutzer Seiten ohne Kategorie erstellen und löschen kann.';
$langFile['PAGESETUP_PAGES_TEXT_UPLOADTHUMBNAILS']                        = 'Thumbnails hochladen';
$langFile['PAGESETUP_PAGES_TIP_UPLOADTHUMBNAILS']                         = 'Legt fest ob der Benutzer, innerhalb der Seiten ohne Kategorie, Seiten-Thumbnails hochladen kann.';
$langFile['PAGESETUP_PAGES_TEXT_EDITTAGS']                                = 'Tags bearbeiten';
$langFile['PAGESETUP_PAGES_TIP_EDITTAGS']                                 = 'Legt fest ob der Benutzer, innerhalb der Seiten ohne Kategorie, Tags bearbeiten kann.[br /]'.$langFile['PAGESETUP_PAGES_TIP_TAG'];
$langFile['PAGESETUP_PAGES_TEXT_ACTIVATEPLUGINS']                         = 'Plugins aktivieren';
$langFile['PAGESETUP_PAGES_TIP_ACTIVATEPLUGINS']                          = 'Legt fest ob der Benutzer, innerhalb der Seiten ohne Kategorie, Plugins verwenden kann.';

// ---------- category settings
$langFile['PAGESETUP_CATEGORY_TITLE_CATEGORIES']                          = 'Kategorien-Verwaltung';
$langFile['PAGESETUP_CATEGORY_TEXT_CATEGORYNAME']                         = 'Name';

$langFile['PAGESETUP_CATEGORY_TEXT_CREATECATEGORY']                       = 'Neue Kategorie erstellen';
$langFile['PAGESETUP_CATEGORY_TEXT_CREATECATEGORY_CREATED']               = 'Neue Kategorie erstellt';
$langFile['PAGESETUP_CATEGORY_TEXT_CREATECATEGORY_UNNAMED']               = 'Unbenannte Kategorie';

$langFile['PAGESETUP_CATEGORY_TEXT_DELETECATEGORY']                       = 'Kategorie löschen';
$langFile['PAGESETUP_CATEGORY_TEXT_DELETECATEGORY_WARNING']               = 'WARNUNG: Es werden auch alle Seiten innerhalb dieser Kategorie gelöscht!';
$langFile['PAGESETUP_CATEGORY_TEXT_DELETECATEGORY_DELETED']               = 'Kategorie gelöscht';
$langFile['PAGESETUP_CATEGORY_TEXT_DELETECATEGORY_QUESTION_START']        = 'Kategorie'; // Kategorie "test" löschen?
$langFile['PAGESETUP_CATEGORY_TEXT_DELETECATEGORY_QUESTION_END']          = 'löschen?';

$langFile['PAGESETUP_CATEGORY_TEXT_MOVECATEGORY_MOVED']                   = 'Kategorie verschoben';
$langFile['PAGESETUP_CATEGORY_TIP_MOVECATEGORY_UP']                       = 'Kategorie nach oben verschieben';
$langFile['PAGESETUP_CATEGORY_TIP_MOVECATEGORY_DOWN']                     = 'Kategorie nach unten verschieben';

$langFile['PAGESETUP_CATEGORY_ERROR_CREATECATEGORY']                      = '<b>Eine neue Kategorie konnte nicht erstellt werden.</b>'.$langFile['ERROR_SAVE_FOLDER_PART1'].'%sconfig/'.$langFile['ERROR_FOLDER_PART2'];
$langFile['PAGESETUP_CATEGORY_ERROR_CREATEDIR']                           = '<b>Konnte keine neues Kategorie-Verzeichnis erstellen.</b>'.$langFile['ERROR_SAVE_FOLDER_PART1'].'%spages/'.'&quot; Ordners.';
$langFile['PAGESETUP_CATEGORY_ERROR_DELETECATEGORY']                      = '<b>Die Kategorie konnte nicht gelöscht werden.</b>'.$langFile['ERROR_SAVE_FILE'].'%sconfig/category.config.php';
$langFile['PAGESETUP_CATEGORY_ERROR_DELETEDIR']                           = '<b>Konnte das Kategorie-Verzeichnis nicht löschen.</b>'.$langFile['ERROR_SAVE_FOLDER_PART1'].'%spages/'.$langFile['ERROR_FOLDER_PART2'];
$langFile['PAGESETUP_CATEGORY_ERROR_SAVE']                                = $langFile['ERROR_SAVE_SETTINGS'].$langFile['ERROR_SAVE_FILE'].'%sconfig/category.config.php';


$langFile['PAGESETUP_CATEGORY_TITLE_ADVANCEDSETTINGS']                    = 'Erweiterte-Einstellungen';
$langFile['PAGESETUP_CATEGORY_HINT_ADVANCEDSETTINGS']                     = 'Wenn diese Einstellungen ausgefüllt sind werden die Seiten-Thumbnail-Einstellungen weiter oben und die '.$langFile['adminSetup_editorSettings_h1'].' in den <a href="?site=adminSetup">Administrator-Einstellungen</a> überschrieben.';

$langFile['PAGESETUP_CATEGORY_TIP_STYLESHEETS_EMPTY']                     = 'Wenn alle Felder leer sind, dann werden die Stylesheet-Einstellungen aus den '.$langFile['adminSetup_editorSettings_h1'].' verwendet.';

$langFile['PAGESETUP_CATEGORY_TEXT_CATEGORYSTATUS']                       = 'Status der Kategorie';
$langFile['PAGESETUP_CATEGORY_TIP_CATEGORYSTATUS']                        = 'Legt fest ob die Kategorie auf der Webseite sichtbar ist.';
$langFile['PAGESETUP_CATEGORY_TEXT_CREATEPAGES']                          = 'Seiten erstellen/löschen';
$langFile['PAGESETUP_CATEGORY_TIP_CREATEPAGES']                           = 'Legt fest ob der Benutzer kann in dieser Kategorie Seiten erstellen und löschen kann.';
$langFile['PAGESETUP_CATEGORY_TEXT_UPLOADTHUMBNAILS']                     = 'Thumbnails hochladen';
$langFile['PAGESETUP_CATEGORY_TIP_UPLOADTHUMBNAILS']                      = 'Legt fest ob der Benutzer Thumbnails für jede Seite in dieser Kategorie hochzuladen kann.';
$langFile['PAGESETUP_CATEGORY_TEXT_EDITTAGS']                             = 'Tags bearbeiten';
$langFile['PAGESETUP_CATEGORY_TIP_EDITTAGS']                              = 'Es können Tags für die Seiten in dieser Kategorie festgelegt werden.[br /]'.$langFile['PAGESETUP_PAGES_TIP_TAG'];
$langFile['PAGESETUP_CATEGORY_TEXT_ACTIVATEPLUGINS']                      = 'Plugins aktivieren';
$langFile['PAGESETUP_CATEGORY_TIP_ACTIVATEPLUGINS']                       = 'Plugins für die Seiten in dieser Kategorie aktivieren';
$langFile['PAGESETUP_CATEGORY_HINT_ACTIVATEPLUGINS']                      = 'Halte die STRG-Taste gedrückt um mehrere Plugins auszuwählen.';

$langFile['PAGESETUP_TEXT_EDITPAGEDATE']                                  = 'Seitendatum bearbeiten';
$langFile['PAGESETUP_TIP_EDITPAGEDATE']                                   = 'Das Seitendatum kann dazu verwendet werden, Seiten auf der Webseite nach Datum zu sortieren';

$langFile['PAGESETUP_TEXT_FEEDS']                                         = 'Feeds aktivieren';
$langFile['PAGESETUP_TIP_FEEDS']                                          = 'RSS 2.0 und Atom Feed für diese Seiten aktivieren.';
$langFile['PAGESETUP_CATEGORY_TIP_FEEDS']                                 = 'RSS 2.0 und Atom Feed für diese Kategorie aktivieren.';

$langFile['PAGESETUP_TEXT_SORTMANUALLY']                                  = 'Seiten manuell sortieren';
$langFile['PAGESETUP_TIP_SORTMANUALLY']                                   = 'Neu erstellte Seiten erscheinen [b]oben[/b].';

$langFile['PAGESETUP_TIP_SORTBYPAGEDATE']                                 = 'Seiten nach Seitendatum sortieren';
$langFile['PAGESETUP_TIP_SORTBYDATE']                                     = 'Seiten mit jüngeren Datum erscheinen [b]oben[/b].[br /][br /][span class=hint]Manuelles Sortieren ist nicht mehr möglich.[/span]';

$langFile['PAGESETUP_TEXT_SORTALPHABETICAL']                              = 'Seiten alphabetisch sortieren';
$langFile['PAGESETUP_TIP_SORTALPHABETICAL']                               = '[span class=hint]Manuelles Sortieren ist nicht mehr möglich.[/span]';

$langFile['PAGESETUP_TEXT_SORTREVERSE']                                   = 'Sortierreihenfolge umdrehen';
$langFile['PAGESETUP_TIP_SORTREVERSE']                                    = 'Dreht die Sortierreihenfolge der Seiten um.';


/*
* websiteSetup.php
*/

// ---------- WEBSITE SETUP (on toolTips tooTips.js converts the "[" and "]" tags in the tittle attribute to "<" ">")
$langFile['websiteSetup_websiteConfig_error_save']                        = $langFile['ERROR_SAVE_SETTINGS'].$langFile['ERROR_SAVE_FILE'].'%sconfig/website.config.php';

$langFile['websiteSetup_websiteConfig_h1']                                = 'Webseiten-Einstellungen';
$langFile['websiteSetup_websiteConfig_field1']                            = 'Webseitentitel';
$langFile['websiteSetup_websiteConfig_field1_tip']                        = 'Der Titel der Webseite wird oben in der Browserleiste angezeigt.';
$langFile['websiteSetup_websiteConfig_field2']                            = 'Publisher';
$langFile['websiteSetup_websiteConfig_field2_tip']                        = 'Der Name der Organisation/Firma/Person, die diese Seite ver&oumlffentlicht.';
$langFile['websiteSetup_websiteConfig_field3']                            = 'Copyright';
$langFile['websiteSetup_websiteConfig_field3_tip']                        = 'Der Copyright-Besitzer der Webseite.';

$langFile['websiteSetup_websiteConfig_field4']                            = 'Suchmaschinen-Stichworte';
$langFile['websiteSetup_websiteConfig_field4_tip']                        = 'Die meisten Suchmaschienen durchsuchen den Seiteninhalt nach Stichworten, jedoch sollte man hier einige Schlüsselwörter angeben, welche in den <meta> Tags der webseite verwendet werden.';
$langFile['websiteSetup_websiteConfig_field4_inputTip']                   = 'Die Stichworte müssen mit &quot;,&quot; getrennt werden::'.$langFile['TEXT_EXAMPLE'].':[br /]stichwort1,stichwort2,etc';
$langFile['websiteSetup_websiteConfig_field5']                            = 'Webseitenbeschreibung';
$langFile['websiteSetup_websiteConfig_field5_tip']                        = 'Eine kurze Beschreibung die von den Suchmaschienen verwendet wird wenn Stichworte in der Webseiten-URL gefunden wurden aber nicht im inhalt.';
$langFile['websiteSetup_websiteConfig_field5_inputTip']                   = 'Ein kurzer Text mit nicht mehr als 3 Zeilen.';

/*
* statisticSetup.php
*/

// ---------- STATISITC SETUP (on toolTips tooTips.js converts the "[" and "]" tags in the tittle attribute to "<" ">")
$langFile['STATISTICSSETUP_ERROR_SAVE']                                   = $langFile['ERROR_SAVE_SETTINGS'].$langFile['ERROR_SAVE_FILE'].'%sconfig/statistic.config.php';

$langFile['STATISTICSSETUP_TITLE_STATISTICSSETTINGS']                     = 'Statistik-Einstellungen';
$langFile['STATISTICSSETUP_TEXT_MOSTVISTED']                              = 'Anzahl der <b>meist besuchten</b> Seiten';
$langFile['STATISTICSSETUP_TIP_MOSTVISTED']                               = 'Gibt an wieviele meist besuchte Seiten auf der Übersicht-Seite angezeigt werden.';
$langFile['STATISTICSSETUP_TEXT_LONGESTVIEWED']                           = 'Anzahl der <b>am längsten betrachteten</b> Seiten';
$langFile['STATISTICSSETUP_TIP_LONGESTVIEWED']                            = 'Gibt an wieviele am längsten betrachtete Seiten auf der Übersicht-Seite angezeigt werden.';
$langFile['STATISTICSSETUP_TEXT_LASTEDITED']                              = 'Anzahl der <b>zuletzt bearbeiteten</b> Seiten';
$langFile['STATISTICSSETUP_TIP_LASTEDITED']                               = 'Gibt an wieviele zuletzt bearbeitete Seiten auf der Übersicht-Seite angezeigt werden.';
$langFile['STATISTICSSETUP_TEXT_LASTVISITED']                             = 'Anzahl der <b>zuletzt besuchten</b> Seiten';
$langFile['STATISTICSSETUP_TIP_LASTVISITED']                              = 'Gibt an wieviele zuletzt besuchte Seiten auf der Übersicht-Seite angezeigt werden.';
$langFile['STATISTICSSETUP_TEXT_REFERERNUMBER']                           = 'Anzahl der <b>Referrer-URLs</b>';
$langFile['STATISTICSSETUP_TIP_REFERERNUMBER']                            = 'Gibt an wieviele Referrer-URLs ([i]URLs die auf diese Webseite geführt haben[/i]) maximal gespeichert werden.';
$langFile['STATISTICSSETUP_TEXT_ACTIVITYNUMBER']                          = 'Anzahl der <b>Tätigkeiten-Logs</b>';
$langFile['STATISTICSSETUP_TIP_ACTIVITYNUMBER']                           = 'Gibt an wieviele Tätigkeiten-Logs maximal gespeichert werden.';


$langFile['statisticSetup_clearStatistic_h1']                             = 'Statistiken löschen';
$langFile['statisticSetup_clearStatistics_websiteStatistic']              = 'Webseiten-Statistik';
$langFile['statisticSetup_clearStatistics_websiteStatistic_tip']          = '[b]Beinhaltet[/b][ul][li]Gesamtanzahl der Besucher[/li][li]Gesamtanzahl der Web-Crawler[/li][li]Datum des ersten Besuchs[/li][li]Datum des letzten Besuchs[/li][li]Browserspektrum[/li][/ul]';
$langFile['statisticSetup_clearStatistics_pagesStatistic']                = 'Seiten-Statistiken';
$langFile['statisticSetup_clearStatistics_pagesStatistic_tip']            = '[b]Beinhaltet[/b][ul][li]Anzahl der Seitenbesucher[/li][li]Datum des ersten Seitenbesuchs[/li][li]Datum des letzten Seitenbesuchs[/li][li]kürzeste Verweildauer[/li][li]längste Verweildauer[/li][li]Suchmaschienen-Stichworte welche auf diese Seite geführt haben[/li][/ul]';
$langFile['statisticSetup_clearStatistics_pagesStaylengthStatistics']     = 'nur die Seiten-Verweildauer-Statistiken';
$langFile['statisticSetup_clearStatistics_pagesStaylengthStatistics_tip'] = '';
$langFile['statisticSetup_clearStatistics_refererLog']                    = 'Referrer-URLs Log'; // engl.: referer
$langFile['statisticSetup_clearStatistics_refererLog_tip']                = 'Eine Liste mit allen URLs welche auf diese Webseite geführt haben.';
$langFile['statisticSetup_clearStatistics_taskLog']                       = 'Logs der letzten Tätigkeiten';
$langFile['statisticSetup_clearStatistics_taskLog_tip']                   = 'Beinhaltet eine Liste der letzten Tätigkeiten.';

$langFile['statisticSetup_clearStatistics_question_h1']                   = 'Willst du diese Statistiken wirklich löschen?';

$langFile['statisticSetup_clearStatistic_pagesStatistics_error_read']     = 'Fehler beim löschen der Seiten-Statistiken.'.$langFile['ERROR_SAVE_FOLDER_PART1'].'%sstatistic/pages/'.$langFile['ERROR_FOLDER_PART2'];

/*
* userSetup.php
*/

$langFile['userSetup_h1']                                                 = 'Benutzer-Verwaltung';
$langFile['userSetup_userSelection']                                      = 'Benutzer';

$langFile['userSetup_createUser']                                         = 'Neuen Benutzer anlegen';
$langFile['userSetup_createUser_created']                                 = 'Neuen Benutzer angelegt';
$langFile['userSetup_createUser_unnamed']                                 = 'Unbenannter Benutzer';

$langFile['userSetup_deleteUser']                                         = 'Benutzer löschen';
$langFile['userSetup_deleteUser_deleted']                                 = 'Benutzer gelöscht';

$langFile['userSetup_username']                                           = 'Benutzername';
$langFile['userSetup_username_missing']                                   = 'Es wurde noch keine Benutzername für diesen Benutzer festgelegt.';
$langFile['userSetup_password']                                           = 'Passwort';
$langFile['userSetup_password_change']                                    = 'Passwort ändern';
$langFile['userSetup_password_confirm']                                   = 'Passwort wiederholen';
$langFile['userSetup_password_confirm_wrong']                             = 'Die beiden Passwörter stimmen nicht überein.';
$langFile['userSetup_password_missing']                                   = 'Es wurde noch keine Passwort für diesen Benutzer festgelegt.';
$langFile['userSetup_password_success']                                   = 'Passwort erfolgreich geändert!';
$langFile['userSetup_email']                                              = 'E-Mail';
$langFile['userSetup_email_tip']                                          = 'Wenn der Benutzer sein Passwort vergessen hat, wird an diese E-Mail ein neues Passwort gesendet.';

$langFile['userSetup_admin']                                              = 'Administrator';
$langFile['userSetup_admin_tip']                                          = 'Legt fest ob der Benutzer Administratorrechte besitzt.';

$langFile['userSetup_error_create']                                       = '<b>Ein neuer Benutzer konnte nicht angelegt werden.</b>'.$langFile['ERROR_SAVE_FILE'].'%sconfig/user.config.php';
$langFile['userSetup_error_save']                                         = $langFile['ERROR_SAVE_SETTINGS'].$langFile['ERROR_SAVE_FILE'].'%sconfig/user.config.php';

/*
* editor.php
*/

// ---------- page info
$langFile['EDITOR_h1_createpage']                                         = 'Neue Seite erstellen';
$langFile['EDITOR_pageinfo_lastsavedate']                                 = 'zuletzt bearbeitet';
$langFile['EDITOR_pageinfo_lastsaveauthor']                               = 'von';
$langFile['EDITOR_pageinfo_linktothispage']                               = 'Link zu dieser Seite';
$langFile['EDITOR_pageinfo_id']                                           = 'Seiten ID';
$langFile['EDITOR_pageinfo_id_tip']                                       = 'Unter dieser ID wird die Seite auf dem Server gespeichert.';
$langFile['EDITOR_pageinfo_category']                                     = 'Kategorie';
$langFile['EDITOR_pageinfo_category_noCategory']                          = 'keine Kategorie (ID 0)';

$langFile['EDITOR_TEXT_CHOOSETEMPLATE']                                   = 'Benutze Vorlage';

$langFile['EDITOR_block_edited']                                          = 'wurden bearbeitet';
$langFile['EDITOR_pageNotSaved']                                          = 'noch nicht gespeichert';

// ---------- page settings
$langFile['EDITOR_pageSettings_h1']                                       = 'Einstellungen';
$langFile['EDITOR_pagestatistics_h1']                                     = 'Statistik';

$langFile['EDITOR_pageSettings_title']                                    = 'Titel';
$langFile['EDITOR_pageSettings_title_tip']                                = 'Der Titel der Seite';
$langFile['EDITOR_pageSettings_field1']                                   = 'Kurzbeschreibung';
$langFile['EDITOR_pageSettings_field1_inputTip']                          = 'Wenn das Feld leer ist, wird die Webseiten-Beschreibung aus den Webseiten-Einstellungen verwendet.';
$langFile['EDITOR_pageSettings_field1_tip']                               = 'Eine kurze Zusammenfassung der Seite. Diese kommt in die META-Tags der Seite.[br /][br /][span class=hint]'.$langFile['EDITOR_pageSettings_field1_inputTip'].'[/span]';
$langFile['EDITOR_pageSettings_field2']                                   = 'Tags';
$langFile['EDITOR_pageSettings_field2_tip']                               = 'Tags sind Stichworte für diese Seite.';
$langFile['EDITOR_pageSettings_field2_tip_inputTip']                      = 'Die Tags müssen mit &quot;,&quot; getrennt werden.';
$langFile['EDITOR_pageSettings_field3']                                   = 'Seitendatum';
$langFile['EDITOR_pageSettings_field3_tip']                               = 'Das Datum kann dazu verwendet werden, Seiten nach Datum zu sortieren. (z.B. bei Veranstaltungen)';
$langFile['EDITOR_pageSettings_pagedate_before_inputTip']                 = 'Text vor dem Datum::z.B. &quot;vom 31. Juni bis&quot;.';
$langFile['EDITOR_pageSettings_pagedate_after_inputTip']                  = 'Text nach dem Datum::';
$langFile['EDITOR_pageSettings_pagedate_day_inputTip']                    = 'Tag::';
$langFile['EDITOR_pageSettings_pagedate_month_inputTip']                  = 'Monat::';
$langFile['EDITOR_pageSettings_pagedate_year_inputTip']                   = 'Jahr::[b]Format[/b] JJJJ';
$langFile['EDITOR_pageSettings_field4']                                   = 'Status der Seite';
$langFile['EDITOR_pageSettings_field4_tip']                               = '[b]Nur wenn die Seite öffentlich ist, wird diese auf der Webseite angezeigt![/b]';

$langFile['EDITOR_pageSettings_pagedate_error']                           = 'Fehlerhaftes Datumsformat';
$langFile['EDITOR_pageSettings_pagedate_error_tip']                       = 'Dieser Monat hat eventuell keine 31 Tage.[br /]Das Datum sollte folgendes Format haben:';

// ---------- page advanced settings
$langFile['EDITOR_advancedpageSettings_h1']                               = 'Erweiterte Einstellungen';

$langFile['EDITOR_advancedpageSettings_field1']                           = 'Seiten Stylesheet-Datei';
$langFile['EDITOR_advancedpageSettings_stylesheet_ifempty']               = 'Wenn alle Felder leer sind, dann werden zuerst die Stylesheet-Einstellungen der Kategorie verwendet, wenn diese auch leer sind dann die aus den HTML-Editor-Einstellungen.';

$langFile['EDITOR_htmleditor_hotkeys_h1']                                 = 'Tastenkürzel';
$langFile['EDITOR_htmleditor_hotkeys_field1']                             = 'Alles markieren';
$langFile['EDITOR_htmleditor_hotkeys_field2']                             = 'Kopieren';
$langFile['EDITOR_htmleditor_hotkeys_field3']                             = 'Einfügen';
$langFile['EDITOR_htmleditor_hotkeys_field4']                             = 'Ausschneiden';
$langFile['EDITOR_htmleditor_hotkeys_field5']                             = 'Rückgängig';
$langFile['EDITOR_htmleditor_hotkeys_field6']                             = 'Wiederherstellen';
$langFile['EDITOR_htmleditor_hotkeys_field7']                             = 'Link setzen';
$langFile['EDITOR_htmleditor_hotkeys_field8']                             = 'Fett';
$langFile['EDITOR_htmleditor_hotkeys_field9']                             = 'Kursiv';
$langFile['EDITOR_htmleditor_hotkeys_field10']                            = 'Unterstrichen';
$langFile['EDITOR_htmleditor_hotkeys_or']                                 = 'oder';

$langFile['EDITOR_savepage_error_save']                                   .= $langFile['ERROR_SAVE_FOLDER_PART1'].'%spages/'.$langFile['ERROR_FOLDER_PART2'];// also in de.shared.php

// ---------- plugin settings
$langFile['EDITOR_pluginSettings_h1']                                     = 'Plugin Einstellungen';

/*
* unsavedPage.php
*/

$langFile['unsavedPage_question_h1']                                      = '<span class="brown">Die Seite wurde verändert.</span><br />Willst du die Seite jetzt speichern?';

/*
* deletePage.php
*/

// ---------- DELETE PAGE
$langFile['deletePage_question_part1']                                    = 'Möchtest du die Seite';
$langFile['deletePage_question_part2']                                    = 'wirklich löschen?';

$langFile['deletePage_notexisting_part1']                                 = 'Die Seite';
$langFile['deletePage_notexisting_part2']                                 = 'existiert nicht';

$langFile['deletePage_finish_error']                                      = 'FEHLER: Die Seite konnte nicht gelöscht werden!';

/*
* pageThumbnailDelete.php
*/

// ---------- PAGE THUMBNAIL DELETE
$langFile['PAGETHUMBNAIL_TEXT_DELETE_QUESTION_START']                     = 'Möchtest du das Thumbnail von der Seite';
$langFile['PAGETHUMBNAIL_TEXT_DELETE_QUESTION_END']                       = 'wirklich löschen?';
$langFile['PAGETHUMBNAIL_ERROR_DELETE']                                   = 'FEHLER: Das Thumbnail konnte nicht gelöscht werden!';


/*
* pageThumbnailUpload.php
*/

// ---------- PAGE THUMBNAIL UPLOAD
$langFile['pagethumbnail_h1_part1']                                       = 'Seiten-Thumbnail für';
$langFile['pagethumbnail_h1_part2']                                       = 'hochladen';
$langFile['pagethumbnail_field1']                                         = 'Bild auswählen';

$langFile['pagethumbnail_thumbinfo_formats']                              = 'Nur folgende Dateiformate sind erlaubt'; //<br /><b>JPG</b>, <b>JPEG</b>, <b>GIF</b>, <b>PNG</b>
$langFile['pagethumbnail_thumbinfo_filesize']                             = 'maximale Dateigröße';
$langFile['pagethumbnail_thumbinfo_standardthumbsize']                    = 'Standardbildgröße';

$langFile['pagethumbnail_thumbsize_h1']                                   = 'Bildgröße selbst festlegen';
$langFile['pagethumbnail_thumbsize_width']                                = 'Bildbreite';
$langFile['pagethumbnail_thumbsize_height']                               = 'Bildhöhe';

$langFile['pagethumbnail_submit_tip']                                     = 'Bild hochladen';

$langFile['PAGETHUMBNAIL_ERROR_nofile']                                   = 'Du hast keine Datei ausgewählt.';
$langFile['PAGETHUMBNAIL_ERROR_nouploadedfile']                           = 'Es wurde keine Datei hochgeladen.';
$langFile['PAGETHUMBNAIL_ERROR_filesize']                                 = 'Wahrscheinlich ist die hochgeladene Datei zu groß.<br />Die maximal erlaubte Dateigröße beträgt';
$langFile['PAGETHUMBNAIL_ERROR_wrongformat']                              = 'Die ausgewählte Datei hat ein nicht unterstütztes Format';
$langFile['PAGETHUMBNAIL_ERROR_NODIR_START']                              = 'Das Thumbnail-Verzeichnis'; // ..thumbnail-folder..
$langFile['PAGETHUMBNAIL_ERROR_NODIR_END']                                = 'existiert nicht.';
$langFile['PAGETHUMBNAIL_ERROR_CREATEDIR_END']                            = 'konnte nicht erstellt werden.';
$langFile['PAGETHUMBNAIL_ERROR_COULDNTMOVEFILE']                          = 'Konnte die hochgeladene Datei nicht in das Thumbnail-Verzeichnis %s verschieben.';
$langFile['PAGETHUMBNAIL_ERROR_CHANGEIMAGESIZE']                          = 'Die Bildgröße konnt nicht geändert werden.';
$langFile['PAGETHUMBNAIL_ERROR_deleteoldfile']                            = 'Das alte Thumbnail-Bild konnte nicht gelöscht werden.';
$langFile['PAGETHUMBNAIL_TEXT_fileexists']                                = 'Es existiert bereits eine Datei mit diesem Namen.<br />Die Hochgeladene Datei wurde umbenannt nach';
$langFile['PAGETHUMBNAIL_TEXT_finish']                                    = 'Das Bild wurde erfolgreich hochgeladen.';

// -> BACKUP

$langFile['BACKUP_TITLE_BACKUP']                                          = 'Backup';
$langFile['BACKUP_TITLE_RESTORE']                                         = 'Wiederherstellen';

$langFile['BACKUP_TITLE_RESTORE_FROMFILES']                               = 'Vorhandenes Backup auswählen';
$langFile['BACKUP_TITLE_RESTORE_FROMUPLOAD']                              = 'Backup-Datei hochladen';

$langFile['BACKUP_TEXT_RESTORE_BACKUPBEFORERESTORE']                      = 'Backup vor der Wiederherstellung';

$langFile['BACKUP_BUTTON_DOWNLOAD']                                       = 'aktuelles Backup erstellen';
$langFile['BACKUP_TEXT_BACKUP']                                           = 'Ein Backup erstellt eine <code>.zip</code> Datei mit den <span class="blue">"pages","config"</span> und <span class="blue">"statistic"</span> Verzeichnissen.<br />Das Upload-Verzeichnis wird nicht gesichert.';
$langFile['BACKUP_TEXT_RESTORE']                                          = 'Wähle hier eine <span class="logoname"><span>fein</span>dura</span> Backup-Datei aus um einen alten Stand wieder herzustellen.<br /><span class="blue">Vor der Wiederherstellung wird ein Backup des aktuellen Standes erstellt.</span>';
$langFile['BACKUP_TOOLTIP_DELETE']                                        = 'Backup löschen';
$langFile['BACKUP_TEXT_DELETE_QUESTION']                                  = '%s wirklich löschen?'; // backup 2010-11-05 15:03 wirklich löschen?

$langFile['BACKUP_TITLE_LASTBACKUPS']                                     = 'Backups herunterladen';
$langFile['BACKUP_TEXT_NOBACKUP']                                         = 'Es wurde noch kein Backup erstellt.';

$langFile['BACKUP_ERROR_FILENOTFOUND']                                    = 'Backup-Datei wurde nicht gefunden in:';
$langFile['BACKUP_ERROR_NORESTROEFILE']                                   = 'Es wurde keine Backup-Datei für die Wiederherstellung ausgewählt.';
$langFile['BACKUP_ERROR_DELETE']                                          = 'Backup konnte nicht gelöscht werden!';


// -----------------------------------------------------------------------------------------------
// RETURN ****************************************************************************************
// -----------------------------------------------------------------------------------------------
return $langFile;

?>