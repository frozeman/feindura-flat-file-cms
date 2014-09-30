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
 * Also dont use " or ' use &quot; and &#145; instead.
 *
 * <samp>
 * $langFile['GROUP_TYPE_NAME'] = 'langfile example text';
 * </samp>
 *
 * The TYPE's can be<br>
 *    - INPUT
 *    - LINK
 *    - BUTTON
 *    - TITLE
 *    - TEXT
 *    - EXAMPLE
 *    - ERROR
 *    - TOOLTIP / TIP
 *    - MESSAGE // should contain <div class="alert"></div>
 *
 * need a RETURN $langFile; at the END
 */

// -> LOGIN <-

$langFile['LOGIN_INPUT_USERNAME']                                         = 'Benutzername';
$langFile['LOGIN_INPUT_PASSWORD']                                         = 'Passwort';
$langFile['LOGIN_BUTTON_LOGIN']                                           = 'Login';
$langFile['LOGIN_TEXT_COOKIESNEEDED']                                     = 'Cookies müssen aktivert sein!';

$langFile['LOGIN_LINK_FORGOTPASSWORD']                                    = 'Passwort vergessen?';
$langFile['LOGIN_LINK_BACKTOLOGIN']                                       = 'zurück zum Login';
$langFile['LOGIN_BUTTON_SENDNEWPASSWORD']                                 = 'Passwort zurücksetzen';
$langFile['LOGIN_TEXT_NEWPASSWORDEMAIL_SUBJECT']                          = 'feindura CMS Passwort angefordert von';
$langFile['LOGIN_TEXT_NEWPASSWORDEMAIL_MESSAGE']                          = 'Du hast ein neues Passwort für dein feindura - Flat File CMS angefordert.
Dein Benutzername und dein neues Passwort lauten:';

$langFile['LOGIN_ERROR_FORGOTPASSWORD_NOEMAIL']                           = 'Der Benutzer hat keine E-Mail Adressse angegeben.';
$langFile['LOGIN_ERROR_FORGOTPASSWORD_NOTSEND']                           = 'FEHLER<br>beim senden des neuen Passworts an die vom Benutzer angegebene E-Mail Adresse.';
$langFile['LOGIN_ERROR_FORGOTPASSWORD_NOTSAVED']                          = 'FEHLER<br>Konnte das neu erzeugte Passwort nicht speichern.';
$langFile['LOGIN_ERROR_FORGOTPASSWORD_SUCCESS']                           = 'Es wurde ein neues Passwort and folgende E-Mail Adresse verschickt';

$langFile['LOGIN_ERROR_WRONGUSER']                                        = 'Benutzer nicht vorhanden';
$langFile['LOGIN_ERROR_WRONGPASSWORD']                                    = 'falsches Passwort';

$langFile['LOGIN_TEXT_LOGOUT_PART1']                                      = 'Erfolgreich ausgeloggt';
$langFile['LOGIN_TEXT_LOGOUT_PART2']                                      = 'weiter zur Webseite';

$langFile['LOGIN_TIP_AUTOLOGOUT']                                         = 'Automatischer logout';


// -> GENERAL <-

$langFile['DATE_Y-M-D']                                                   = 'JJJJ-MM-TT';
$langFile['DATE_D.M.Y']                                                   = 'TT.MM.JJJJ';
$langFile['DATE_D/M/Y']                                                   = 'TT/MM/JJJJ';
$langFile['DATE_M/D/Y']                                                   = 'MM/TT/JJJJ';
$langFile['CATEGORIES_TEXT_NONCATEGORY']                                  = 'Seiten';
$langFile['CATEGORIES_TOOLTIP_NONCATEGORY']                               = 'Seiten ohne Kategorie';
$langFile['TEXT_EXAMPLE']                                                 = 'Beispiel';

$langFile['HEADER_BUTTON_GOTOWEBSITE_FRONTENDEDITING']                    = 'Frontend-Bearbeitung::Klick hier um die Seiten direkt in der Webseite zu bearbeiten.';

$langFile['BUTTON_MORE']                                                  = 'mehr';

// PERMISSIONS
$langFile['PERMISSIONS_TEXT_DONTHAVEPERMISSION']                          = 'Du bist nicht berechtigt dies zu verändern.';

// THUMBNAILS
$langFile['THUMBNAIL_TEXT_UNIT']                                          = 'Pixel';

$langFile['THUMBNAIL_TEXT_NAME']                                          = 'Seiten-Thumbnail';
$langFile['THUMBNAIL_TEXT_WIDTH']                                         = 'Thumbnail <b>Breite</b>';
$langFile['THUMBNAIL_TEXT_HEIGHT']                                        = 'Thumbnail <b>Höhe</b>';

$langFile['THUMBNAIL_TOOLTIP_WIDTH']                                      = 'Standardbreite::Die Breite des Thumbnails in Pixeln.[br][br]Das Bild wird beim hochladen auf die angegebene Größe skaliert.';
$langFile['THUMBNAIL_TOOLTIP_HEIGHT']                                     = 'Standardhöhe::Die Höhe des Thumbnails in Pixeln.[br][br]Das Bild wird beim hochladen auf die angegebene Größe skaliert.';

$langFile['THUMBNAIL_TEXT_RATIO']                                         = 'Seitenverhältnis';
$langFile['THUMBNAIL_TEXT_KEEPRATIO']                                     = 'Seitenverhältnis beibehalten';
$langFile['THUMBNAIL_TEXT_FIXEDRATIO']                                    = 'festes Seitenverhältnis';
$langFile['THUMBNAIL_TOOLTIP_FIXEDRATIO']                                 = 'Höhe und Breite ist fest einstellbar.';
$langFile['THUMBNAIL_TOOLTIP_KEEPRATIO_X']                                = 'Wird an der [strong]Breite[/strong] ausgerichtet.';
$langFile['THUMBNAIL_TOOLTIP_KEEPRATIO_Y']                                = 'Wird an der [strong]Höhe[/strong] ausgerichtet.';

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
$langFile['PATHS_TOOLTIP_ABSOLUTE']                                       = 'Absoluter Pfad::Absoluter Dateisystem-Pfad. (Aber relativ zum Dokumenten-Wurzelverzeichnis)[br][br][span class=hint]/server/htdocs[strong]/pfad/[/strong][/span]';
$langFile['PATHS_TOOLTIP_RELATIVE']                                       = 'Relativer Pfad::Relativer URI Pfad, bedeuted relativ zum aktuellen Dokument.';

// STATISTICS
$langFile['STATISTICS_TITLE_BROWSERCHART']                                = 'Browserspektrum der Besucher';
$langFile['STATISTICS_TEXT_ROBOTCOUNT']                                   = 'Web-Crawler';
$langFile['STATISTICS_TOOLTIP_ROBOTCOUNT']                                = 'Web-Crawler::Oder auch Robots genannt sind Programmscripte von Suchmaschienen, die Seiten analysieren und indizieren.';

$langFile['STATISTICS_TEXT_SEARCHWORD_PART1']                             = 'hat'; // "exampleword" led 20 times to this website
$langFile['STATISTICS_TEXT_SEARCHWORD_PART2']                             = 'mal auf diese Seite geführt';
$langFile['STATISTICS_TOOLTIP_SEARCHWORD']                                = 'Anklicken um nach diesem Suchwort in allen Seiten zu suchen.';

$langFile['STATISTICS_TEXT_VISITORCOUNT']                                 = 'Besuche bisher';
$langFile['STATISTICS_TEXT_CURRENTVISITORS']                              = 'Aktuelle Besucher';
$langFile['STATISTICS_TEXT_CURRENT']                                      = 'Aktuell';
$langFile['STATISTICS_TEXT_LASTACTIVITY']                                 = 'Letzte Aktivität';

$langFile['STATISTICS_TITLE_PAGESTATISTICS']                              = 'Seiten Statistiken';

$langFile['STATISTICS_TEXT_VISITTIME_MAX']                                = 'Längste Verweildauer';
$langFile['STATISTICS_TEXT_VISITTIME_MIN']                                = 'Kürzeste Verweildauer';
$langFile['STATISTICS_TEXT_FIRSTVISIT']                                   = 'von';
$langFile['STATISTICS_TEXT_LASTVISIT']                                    = 'bis';
$langFile['STATISTICS_TEXT_NOVISIT']                                      = 'Es hat noch niemand diese Seite besucht.';
$langFile['STATISTICS_TEXT_SEARCHWORD_DESCRIPTION']                       = '<span class="toolTipTop" title="::Die von
Google, Yahoo oder Bing (MSN) auf diese Seite geführt haben">Suchworte</span>';

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
$langFile['LOG_PAGE_MOVEDTOCATEGORY_CATEGORY']                            = 'in Kategorie'; // Example Page in Category
$langFile['LOG_PAGE_SORTED']                                              = 'Seite neu sortiert';

$langFile['LOG_THUMBNAIL_UPLOAD']                                         = 'Neues Thumbnail hochgeladen';
$langFile['LOG_THUMBNAIL_DELETE']                                         = 'Thumbnail gelöscht';

$langFile['LOG_USER_ADD']                                                 = 'Neuen Benutzer angelegt';
$langFile['LOG_USER_DELETED']                                             = 'Benutzer gelöscht';
$langFile['LOG_USER_PASSWORD_CHANGED']                                    = 'Benutzerpasswort geändert';
$langFile['LOG_USER_SAVED']                                               = 'Benutzer gespeichert';

$langFile['LOG_ADMINSETUP_SAVED']                                         = 'Administrator-Einstellungen gespeichert';
$langFile['LOG_ADMINSETUP_CKSTYLES']                                      = '&quot;Stil&quot;-Auswahl des HTML-Editors gespeichert';

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

$langFile['LOG_PAGELANGUAGE_DELETED']                                     = 'Sprache &quot;%s&quot; gelöscht für Seite';
$langFile['LOG_PAGELANGUAGE_ADD']                                         = 'Sprache &quot;%s&quot; hinzugefügt für Seite';


// PAGE/CATEGORY STATUS
$langFile['STATUS_PAGE_PUBLIC']                                           = 'Seite ist öffentlich';
$langFile['STATUS_PAGE_NONPUBLIC']                                        = 'Seite ist versteckt';

$langFile['STATUS_CATEGORY_PUBLIC']                                       = 'Kategorie ist öffentlich';
$langFile['STATUS_CATEGORY_NONPUBLIC']                                    = 'Kategorie ist versteckt';

// USER LIST
$langFile['USER_TEXT_USER']                                               = 'Benutzer';
$langFile['USER_TEXT_NOUSER']                                             = 'Es wurden noch keine Benutzer angelegt.';
$langFile['USER_TEXT_CURRENTUSER']                                        = 'Das bist du!';
$langFile['USER_TEXT_USERSONLINE']                                        = 'Dieser Benutzer ist online::Letzte Aktivität';

$langFile['LOGO_TEXT']                                                    = 'Version';


// CKEDITOR transport
$langFile['CKEDITOR_TITLE_LINKS']                                         = 'feindura Seiten';
$langFile['CKEDITOR_TITLE_SNIPPETS']                                      = 'Codeschnipsel';
$langFile['CKEDITOR_TEXT_SNIPPETS']                                       = 'Wähle ein Codeschnipsel aus um es in der Seite zu platzieren.';
$langFile['CKEDITOR_BUTTON_EDITSNIPPET']                                  = 'Codeschnipsel bearbeiten';
$langFile['CKEDITOR_TITLE_PLUGINS']                                       = 'Plugins';
$langFile['CKEDITOR_BUTTON_EDITPLUGIN']                                   = 'Plugin bearbeiten';

// -> BUTTON TEXTS

// MAIN MENU
$langFile['BUTTON_DASHBOARD']                                             = 'Übersicht';
$langFile['BUTTON_PAGES']                                                 = 'Seiten';
$langFile['BUTTON_ADDONS']                                                = 'Add-ons';
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
$langFile['BUTTON_WEBSITELANGUAGE_ADD']                                   = 'Sprache hinzufügen';
$langFile['BUTTON_TOOLTIP_WEBSITELANGUAGE_ADD']                           = 'Füge eine neue Sprache zu dieser Seite hinzu';
$langFile['BUTTON_WEBSITELANGUAGE_DELETE']                                = 'Sprache löschen';
$langFile['BUTTON_TOOLTIP_WEBSITELANGUAGE_DELETE']                        = 'Sprache &quot;%s&quot; für diese Seite löschen';
$langFile['BUTTON_SHOWINMENU']                                            = 'In Menüs anzeigen';
$langFile['BUTTON_HIDEINMENU']                                            = 'In Menüs verstecken';
$langFile['BUTTON_TOOLTIP_SHOWHIDEINMENU']                                = 'Legt fest ob diese Seite in Menüs angezeigt wird oder nicht.';

// OTHER BUTTONS
$langFile['BUTTON_UP']                                                    = 'Nach oben';
$langFile['BUTTON_INFO']                                                  = 'Info';
$langFile['BUTTON_EDIT']                                                  = 'Bearbeiten';
$langFile['BUTTON_RESET']                                                 = 'Zurücksetzen';
$langFile['BUTTON_OK']                                                    = 'OK';


// -> GENERAL ERROR TEXTS
$langFile['ERROR_SAVE_SETTINGS']                                          = '<b>Die Einstellungen konnten nicht gespeichert werden.</b>';
$langFile['ERROR_SAVE_FILE']                                              = '<br><br>Bitte überprüfe die Schreibrechte der Datei: ';

$langFile['ERROR_READ_FOLDER_PART1']                                      = '<br><br>Bitte überprüfe die Leserechte des &quot;';
$langFile['ERROR_SAVE_FOLDER_PART1']                                      = '<br><br>Bitte überprüfe die Schreibrechte des &quot;';

$langFile['ERROR_FOLDER_PART2']                                           = '&quot; Ordners dessen Unterordner und Dateien.';

// -> WARNINGS
$langFile['WARNING_TITLE_STARTPAGE']                                      = 'Die Startseite ist nicht festgelegt!';
$langFile['WARNING_TEXT_STARTPAGE']                                       = 'Bitte lege eine Seite als Startseite fest.<br>Gehe zu <a href="?site=pages">'.$langFile['BUTTON_PAGES'].'</a> und klicke bei der gewünschten Seite auf das <span class="icons startpage"></span> Symbol';

$langFile['WARNING_TITLE_DOCUMENTROOT']                                   = 'Das Dokumenten-Wurzelverzeichnis konnte nicht automatisch bestimmt werden!';
$langFile['WARNING_TEXT_DOCUMENTROOT']                                    = 'Damit <span class="feinduraInline">fein<em>dura</em></span> richtig funktionieren kann trage bitte das Dokumenten-Wurzelverzeichnis (Document-Root) in den <a href="?site=adminSetup#adminSettings">Administrator-Einstellungen</a> manuell ein.';

$langFile['WARNING_TITLE_BASEPATH']                                       = '<span class="feinduraInline">fein<em>dura</em></span> wurde noch nicht konfiguriert!';
$langFile['WARNING_TEXT_BASEPATH']                                        = 'Der <i>Basispfad</i> stimmt nicht mit dem in den Administrator-Einstellungen angegebenen Pfad überein.<br>
Bitte gehe in die <a href                                                 ="?site=adminSetup#adminSettings">Administrator-Einstellungen</a> und konfiguriere dein <span class="feinduraInline">fein<em>dura</em></span> CMS';

$langFile['WARNING_TITLE_JAVASCRIPT']                                     = 'Bitte aktiviere Javascript';
$langFile['WARNING_TEXT_JAVASCRIPT']                                      = '<strong>Um <span class="feinduraInline">fein<em>dura</em></span> voll nutzen zu können, muss Javascript aktiviert sein!</strong>';

$langFile['WARNING_TITLE_UNTITLEDCATEGORIES']                             = 'Fehlende Kategorienamen';

$langFile['DASHBOARD_TITLE_IEWARNING']                                    = '<span class="feinduraInline">fein<em>dura</em></span> ist nicht für ältere Versionen des Internet Explorers ausgelegt';
$langFile['DASHBOARD_TEXT_IEWARNING']                                     = 'Um das <span class="feinduraInline">fein<em>dura</em></span> CMS vollständig nutzen zu können ist mindestens der Internet Explorer 9 nötig.<br><br>Bitte installiere eine neuere Version des Internet Explorers,<br> oder installiere das <a href="http://www.google.com/chromeframe" target="_blank">Google Chrome Frame Plugin</a> für den Internet Explorer,<br>oder lade dir den kostenlosen <a href="http://www.mozilla.org/firefox/">Firefox</a> oder <a href="http://www.google.com/chrome/">Chrome</a> Browser herunter.';

$langFile['GENERAL_TEXT_CURRENTLYEDITED']                                 = 'Seite wird gerade bearbeitet...';

// MESSAGES
$langFile['MESSAGE_TEXT_CHANGEDSTATUS']                                   = 'Der Status wurde geändert.';
$langFile['MESSAGE_TEXT_CHANGEDSHOWINMENU']                               = 'Der Menüstatus wurde erfolgreich geändert.';

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

$langFile['DASHBOARD_TITLE_WELCOME']                                      = 'Willkommen in <span class="feinduraInline">fein<em>dura</em></span>,<br>dem Content Management System deiner Webseite';

$langFile['DASHBOARD_TITLE_STATISTICS']                                   = 'Webseiten-Statistik';

$langFile['DASHBOARD_TITLE_USER']                                         = 'Benutzer';
$langFile['DASHBOARD_TITLE_ACTIVITY']                                     = 'Letzte Tätigkeiten';
$langFile['DASHBOARD_TEXT_ACTIVITY_NONE']                                 = 'Keine';

$langFile['DASHBOARD_TITLE_STATISTICS_MOSTVISITED']                       = 'Meist besuchte Seiten';
$langFile['DASHBOARD_TITLE_STATISTICS_LASTVISITED']                       = 'Zuletzt besuchte Seiten';
$langFile['DASHBOARD_TITLE_STATISTICS_LASTEDITED']                        = 'Zuletzt bearbeitete Seiten';
$langFile['DASHBOARD_TITLE_STATISTICS_LONGESTVIEWED']                     = 'Am längsten betrachtete Seiten';

$langFile['DASHBOARD_TITLE_REFERER']                                      = 'Webseiten von denen die letzten Besucher gekommen sind';

/*
* listPages.php
*/

// ---------- PAGES SORTABLE LIST
$langFile['SORTABLEPAGELIST_h1']                                          = 'Der Inhalt deiner Webseite';
$langFile['SORTABLEPAGELIST_headText1']                                   = 'Filter';
$langFile['SORTABLEPAGELIST_headText3']                                   = 'Besucher';
$langFile['SORTABLEPAGELIST_headText4']                                   = 'Status';
$langFile['SORTABLEPAGELIST_headText5']                                   = 'Funktionen';

$langFile['SORTABLEPAGELIST_TIP_PAGEDATE']                                = 'Seiten-Datum';
$langFile['SORTABLEPAGELIST_TIP_LASTEDIT']                                = 'zuletzt bearbeitet';
$langFile['SORTABLEPAGELIST_TIP_TAGS']                                    = 'Tags';
$langFile['SORTABLEPAGELIST_TIP_LOCALIZATION']                            = 'Sprachen';

$langFile['SORTABLEPAGELIST_TIP_SORTALPHABETICAL']                        = 'alphabetisch sortiert';
$langFile['SORTABLEPAGELIST_TIP_SORTBYPAGEDATE']                          = 'nach Seitendatum sortiert';

$langFile['SORTABLEPAGELIST_functions_editPage']                          = 'Seite bearbeiten';

$langFile['SORTABLEPAGELIST_TIP_CHANGESTATUS']                            = 'Hier klicken um den Status zu ändern.';

$langFile['SORTABLEPAGELIST_TOOLTIP_LANGUAGEMISSING']                     = 'Fehlende Sprachen';

$langFile['file_error_read']                                              = '<b>Die Seite konnte nicht gelesen werden.</b>'.$langFile['ERROR_READ_FOLDER_PART1'].'%spages/'.$langFile['ERROR_FOLDER_PART2'];
$langFile['SORTABLEPAGELIST_changeStatusPage_error_save']                 = '<b>Der Status der Seite konnte nicht geändert werden.</b>'.$langFile['ERROR_SAVE_FOLDER_PART1'].'%spages/'.$langFile['ERROR_FOLDER_PART2'];
$langFile['SORTABLEPAGELIST_setStartPage_error_save']                     .= $langFile['ERROR_SAVE_FILE'].' &quot;%sconfig/website.config.php&quot;'; // also in de.shared.php
$langFile['SORTABLEPAGELIST_changeStatusCategory_error_save']             = '<b>Der Status der Kategorie konnte nicht geändert werden.</b>'.$langFile['ERROR_SAVE_FOLDER_PART1'].'%spages/'.$langFile['ERROR_FOLDER_PART2'];

$langFile['SORTABLEPAGELIST_info']                                        = 'Du kannst die <b>Seiten-Anordnung</b> per <b>Drag and Drop</b> verändern und auch Seiten zwischen den Kategorien verschieben.';
$langFile['SORTABLEPAGELIST_save']                                        = 'Speichere die neue Anordnung ...';
$langFile['SORTABLEPAGELIST_save_finished']                               = 'Neu Anordnung erfolgreich gespeichert!';
$langFile['SORTABLEPAGELIST_error_save']                                  = '<b>Die Seiten konnten nicht gespeichert werden.</b>'.$langFile['ERROR_SAVE_FOLDER_PART1'].'%spages/'.$langFile['ERROR_FOLDER_PART2'];
$langFile['SORTABLEPAGELIST_error_read']                                  = '<b>Die Seiten konnten nicht gelesen werden.</b>'.$langFile['ERROR_READ_FOLDER_PART1'].'%spages/'.$langFile['ERROR_FOLDER_PART2'];
$langFile['SORTABLEPAGELIST_error_move']                                  = '<b>Konnte die Seite nicht in die neue Kategorie verschieben.</b>'.$langFile['ERROR_SAVE_FOLDER_PART1'].'%spages/'.$langFile['ERROR_FOLDER_PART2'];
$langFile['SORTABLEPAGELIST_categoryEmpty']                               = 'Keine Seiten vorhanden';
$langFile['SORTABLEPAGELIST_TIP_DRATOREARRANGE']                          = 'Zum sortieren ziehen.';

$langFile['SORTABLEPAGELIST_TIP_SUBCATEGORYOFPAGES_SINGULAR']             = 'Unterkategorie der Seite:';
$langFile['SORTABLEPAGELIST_TIP_SUBCATEGORYOFPAGES_PLURAL']               = 'Unterkategorie der Seiten:';


// ---------- FORMULAR
$langFile['FORM_BUTTON_SUBMIT']                                           = 'Speichern';
$langFile['FORM_BUTTON_CANCEL']                                           = 'Alle Eingaben zurücksetzen';

/*
* adminSetup.php
*/

// ---------- ADMIN SETUP (on toolTips tooTips.js converts the "[" and "]" tags in the title attribute to "<" ">")
$langFile['ADMINSETUP_TEXT_VERSION']                                      = '<span class="feinduraInline">fein<em>dura</em></span> Version';
$langFile['ADMINSETUP_TEXT_PHPVERSION']                                   = 'PHP Version';
$langFile['ADMINSETUP_TITLE_DOCUMENTROOT']                                = 'Dokumenten-Wurzelverzeichnis';

$langFile['ADMINSETUP_TITLE_ERROR']                                       = 'Es sind Fehler aufgetreten';
$langFile['ADMINSETUP_TOOLTIP_WRITEACCESSERROR']                          = 'Bei Dateien und Verzeichnissen müssen die Schreibrechte auf %o gesetzt werden.';

$langFile['ADMINSETUP_TEXT_WRITEACCESSERROR']                             = 'ist nicht beschreibbar';
$langFile['ADMINSETUP_TEXT_ISFOLDERERROR']                                = 'ist kein Verzeichnis';

// ---------- general Settings
$langFile['ADMINSETUP_GENERAL_error_save']                                = $langFile['ERROR_SAVE_SETTINGS'].$langFile['ERROR_SAVE_FILE'].'%sconfig/admin.config.php';

$langFile['ADMINSETUP_GENERAL_h1']                                        = 'Grund-Einstellungen';

$langFile['ADMINSETUP_GENERAL_TEXT_DOCUMENTROOT']                         = 'Dokumenten-Wurzelverzeichnis';
$langFile['ADMINSETUP_GENERAL_TOOLTIP_DOCUMENTROOT']                      = 'Bitte gib das Dokumenten-Wurzelverzeichnis manuell ein.[br][span class=hint]z.B. &quot;/server/user/htdocs&quot;[/span]';
$langFile['ADMINSETUP_GENERAL_field1']                                    = 'Webseiten-URL';
$langFile['ADMINSETUP_GENERAL_field1_tip']                                = 'Die URL ihrer Webseite wird automatisch eingefügt.';
$langFile['ADMINSETUP_GENERAL_field1_inputTip']                           = 'Die URL wird automatisch eingefügt';
$langFile['ADMINSETUP_GENERAL_field1_inputWarningText']                   = 'Bitte speichere die Einstellungen!';
$langFile['ADMINSETUP_GENERAL_field2']                                    = 'feindura-Pfad';
$langFile['ADMINSETUP_GENERAL_field2_tip']                                = 'Der Hauptpfad wird automatisch ermittelt und beim speichern der Einstellungen übernommen.';
$langFile['ADMINSETUP_GENERAL_field2_inputTip']                           = 'Der Pfad wird automatisch eingefügt';
$langFile['ADMINSETUP_GENERAL_field2_inputWarningText']                   = 'Bitte speichere die Einstellungen!';
$langFile['ADMINSETUP_GENERAL_field8']                                    = 'Webseitenpfad';
$langFile['ADMINSETUP_GENERAL_field8_tip']                                = 'Der [strong]absolute Pfad[/strong], unter dem sich die Webseite befindet.[br][br][span class=hint]Kann kann auch einen Dateinamen enthalten z.b &quot;/webseite/index.php&quot;[/span]';
$langFile['ADMINSETUP_GENERAL_editfiles_additonal']                       = '[br][br]Diese Dateien können dann weiter unten oder in den Webseiten-Einstellungen bearbeitet werden (sollte dies in den Benutzer-Einstellungen aktiviert sein).[br][br]';
$langFile['ADMINSETUP_GENERAL_field5']                                    = 'Pfad für Webseitendateien';
$langFile['ADMINSETUP_GENERAL_field5_tip']                                = 'Hier kann ein Pfad zu webseiten-spezifischen Dateien angeben werden, welche dann direkt in [span class=feinduraInline]fein[em]dura[/em][/span] bearbeitet werden können.'.$langFile['ADMINSETUP_GENERAL_editfiles_additonal'];
$langFile['ADMINSETUP_GENERAL_field6']                                    = 'Pfad für Stylesheetdateien';
$langFile['ADMINSETUP_GENERAL_field6_tip']                                = 'Hier kann ein Pfad zu Stylesheet-Dateien angeben werden, welche dann direkt in [span class=feinduraInline]fein[em]dura[/em][/span] bearbeitet werden können.'.$langFile['ADMINSETUP_GENERAL_editfiles_additonal'];
$langFile['ADMINSETUP_GENERAL_TEXT_PERMISSIONS']                          = 'Schreibrechte für Dateien und Verzeichnisse';
$langFile['ADMINSETUP_GENERAL_TIP_PERMISSIONS']                           = 'Jeder von [span class=feinduraInline]fein[em]dura[/em][/span] erstellten Datei oder Verzeichnis wird versucht diese Schreibrechte zuzuweisen.';
$langFile['ADMINSETUP_TEXT_VARNAMEPAGE']                                  = 'Seiten URL Name';
$langFile['ADMINSETUP_TEXT_VARNAMECATEGORY']                              = 'Kategorie URL Name';
$langFile['ADMINSETUP_TEXT_VARNAMEMODUL']                                 = 'Modul URL Name';
$langFile['ADMINSETUP_TIP_VARNAME']                                       = 'Der Name der in der URL verwendet wird, um die Seiten zu verlinken.';
$langFile['ADMINSETUP_TIP_EMPTYVARNAME']                                  = 'Wenn das Feld leer ist, wird der Standard Name verwendet: ';
$langFile['ADMINSETUP_TEXT_TIMEZONE']                                     = 'Zeitzone';
$langFile['ADMINSETUP_TIP_TIMEZONE']                                      = 'Wird nur für das [span class=feinduraInline]fein[em]dura[/em][/span] Backend verwendet.';
$langFile['ADMINSETUP_GENERAL_PRETTYURL']                                 = 'URL Format';
$langFile['ADMINSETUP_GENERAL_PRETTYURL_true']                            = 'Pretty URLs';
$langFile['ADMINSETUP_GENERAL_PRETTYURL_true_example']                    = '/%s/kategorie-name/seiten-name';
$langFile['ADMINSETUP_GENERAL_PRETTYURL_false']                           = 'URLs mit Variablen';
$langFile['ADMINSETUP_GENERAL_PRETTYURL_false_example']                   = 'index.php?%s=1&%s=1';
$langFile['ADMINSETUP_GENERAL_PRETTYURL_tip']                             = 'Das URL Format, welches für die Seiten-Verlinkung verwendet wird.[br][br]Pretty URLs funktionieren nur wenn im [strong]Apache Server[/strong] das [strong]mod_rewrite[/strong] Modul verfügbar ist.';
$langFile['ADMINSETUP_GENERAL_PRETTYURL_warning']                         = 'WARNUNG!::[span class=red]Sollten Fehler bei der Vewendung von Pretty URLs auftreten, muss die [strong].htaccess Datei[/strong] im Dokumenten-Wurzelverzeichnis Pfad des Webservers gelöscht werden.[/span][br][br](In manchen FTP-Programmen muss man erst die versteckten Dateien anzeigen, um die .htaccess Datei sichtbar zu machen)';

// ---------- Pretty url ERRORs
$langFile['ADMINSETUP_GENERAL_PRETTYURL_error_save']                      = '<b>Pretty URLs</b> konnte nicht aktiviert werden'.$langFile['ERROR_SAVE_FILE'].'/.htaccess';
$langFile['ADMINSETUP_GENERAL_PRETTYURL_error_modul']                     = '<b>Pretty URLs</b> konnte nicht aktiviert werden da das Apache Modul: MOD_REWRITE nicht gefunden wurde';

// ---------- cache settings
$langFile['ADMINSETUP_TEXT_CACHE']                                        = 'Cache aktivieren';
$langFile['ADMINSETUP_TIP_CACHE']                                         = 'Wenn aktiv, werden die Seiten zwischengespeichert. Das kann die Website beschleunigen, aber auch dazu führen dass Inhalte nicht aktuell angezeigt werden.[br][br][span class=hint]Beim speichern der Seiten wird der Cache automatisch neu erzeugt.[/span]';
$langFile['ADMINSETUP_TEXT_CACHETIMEOUT']                                 = 'Cache-Dauer';
$langFile['ADMINSETUP_TIP_CACHETIMEOUT']                                  = 'Gibt die Zeit an nach der der Cache automatisch erneuert wird.';
$langFile['ADMINSETUP_HINT_CACHETIMEOUT']                                 = 'Stunden';

// ---------- editor Settings
$langFile['adminSetup_editorSettings_h1']                                 = 'HTML-Editor-Einstellungen';
$langFile['ADMINSETUP_TEXT_EDITOR_HTMLLAWED']                             = 'HTML filtern (verwendet <a href="http://www.bioinformatics.org/phplabware/internal_utilities/htmLawed/" target="_blank">htmlLawed</a>)';
$langFile['ADMINSETUP_TIP_EDITOR_HTMLLAWED']                              = 'Filtert den HTML-Code bevor er gespeichert wird, das kann jedoch bei HTML-Code mit viel Javascript zu Problemen führen.';
$langFile['ADMINSETUP_TEXT_EDITOR_SAFEHTML']                              = 'sicheres HTML (<a href="http://www.bioinformatics.org/phplabware/internal_utilities/htmLawed/htmLawed_README.htm#s3.6" target="_blank">Details</a>)';
$langFile['ADMINSETUP_TIP_EDITOR_SAFEHTML']                               = 'Dadurch wird der HTML-Code mit den sichersten Einstellungen gefiltert, d.h. zum Beispiel dass keine &lt;applet&gt;,&lt;embed&gt;,&lt;embed&gt;,&lt;object &gt; und &lt;script&gt; Tags erlaubt sind.';
$langFile['ADMINSETUP_TEXT_EDITOR_EDITORSTYLES']                          = 'Stil-Auswahl aktivieren';
$langFile['ADMINSETUP_TIP_EDITOR_EDITORSTYLES']                           = 'Die Stil-Auswahl erlaubt es benutzerdefinierte HTML-Elemente in dem HTML-Editor zu verwenden.[br][br][span class=hint]Wenn diese Option aktiviert ist, können diese HTML-Elemente weiter unten bearbeitet bzw. angelegt werden.[/span]';
$langFile['ADMINSETUP_TEXT_EDITOR_SNIPPETS']                              = 'Codeschnipsel aktivieren';
$langFile['ADMINSETUP_TIP_EDITOR_SNIPPETS']                               = 'Erlaubt das einfügen von Codeschnipseln in die einzelnen Seiten.[br]Klicke im Editor auf folgendes Icon: [img class=icons src=library/thirdparty/ckeditor/plugins/feinduraSnippets/feinduraSnippetsIcon.png][br][br][span class=hint]Wenn diese Option aktiviert ist, können die Codeschnipsel weiter unten bearbeitet bzw. angelegt werden.[/span]';
$langFile['adminSetup_editorSettings_field1']                             = 'ENTER-Taste Modus';
$langFile['adminSetup_editorSettings_field1_hint']                        = 'SHIFT + ENTER erzeugt ein &quot;%s&quot;';
$langFile['adminSetup_editorSettings_field1_tip']                         = 'Legt fest welcher HTML-Tag beim drücken der ENTER-Taste gesetzt wird.[br][br][span class=hint]'.$langFile['adminSetup_editorSettings_field1_hint'].'.[/span]';
$langFile['adminSetup_editorSettings_field3_inputTip']                    = 'Wenn das Feld leer ist, wird keine Id verwendet.';
$langFile['adminSetup_editorSettings_field4_inputTip']                    = 'Wenn das Feld leer ist, wird keine Klasse verwendet.';

// THUMBNAILS Settings
$langFile['adminSetup_thumbnailSettings_h1']                              = 'Seiten-Thumbnail-Einstellungen';

// ---------- styleFile Settings
$langFile['adminSetup_styleFileSettings_h1']                              = '&quot;Stil&quot;-Auswahl des HTML-Editors bearbeiten';
$langFile['adminSetup_styleFileSettings_error_save']                      = '<b>Die Datei &quot;EditorStyles.js&quot; konnte nicht gespeichert werden.</b>'.$langFile['ERROR_SAVE_FILE'];

// ---------- editFiles Settings
$langFile['EDITFILESSETTINGS_TITLE_STYLESHEETS']                          = 'Stylesheetdateien bearbeiten';
$langFile['EDITFILESSETTINGS_TITLE_WEBSITEFILES']                         = 'Webseitendateien bearbeiten';
$langFile['EDITFILESSETTINGS_TITLE_SNIPPETS']                             = 'Codeschnipsel bearbeiten';
$langFile['EDITFILESSETTINGS_TEXT_NODIR']                                 = 'ist kein gültiges Verzeichnis!';
$langFile['EDITFILESSETTINGS_TEXT_CHOOSEFILE']                            = 'Datei auswählen';
$langFile['EDITFILESSETTINGS_TEXT_CREATEFILE']                            = 'Neue Datei anlegen';
$langFile['EDITFILESSETTINGS_TIP_CREATEFILE']                             = 'Wenn hier ein Dateiname eingetragen wird, dann wird eine Neue Datei erstellt, und [strong]die derzeit ausgewählte Datei wird nicht gespeichert![/strong]';
$langFile['EDITFILESSETTINGS_TEXT_NOFILE']                                = 'Es sind noch keine Dateien vorhanden.';

$langFile['EDITFILESSETTINGS_TEXT_DELETEFILE']                            = 'Datei löschen';
$langFile['EDITFILESSETTINGS_TEXT_DELETEFILE_QUESTION']                   = 'Datei %s wirklich löschen?';

$langFile['EDITFILESSETTINGS_ERROR_SAVEFILE']                             = '<b>Die Datei konnte nicht gespeichert werden.</b>'.$langFile['ERROR_SAVE_FILE'];
$langFile['EDITFILESSETTINGS_ERROR_DELETEFILE']                           = '<b>Die Datei konnte nicht gelöscht werden.</b>'.$langFile['ERROR_SAVE_FILE'];

/*
* pageSetup.php
*/

// ---------- CATEGORY SETUP (on toolTips tooTips.js converts the "[" and "]" tags in the title attribute to "<" ">")
$langFile['PAGESETUP_PAGES_TIP_TAG']                                      = 'Tags können dazu verwendet werden Seiten untereinander in Beziehung zu setzen (abhängig von der Programmierung der Webseite)';

// ---------- page settings
$langFile['PAGESETUP_PAGES_TITLE_NONCATEGORYPAGES']                       = 'Seiten ohne Kategorie';
$langFile['PAGESETUP_PAGES_TEXT_CREATEPAGES']                             = 'Seiten erstellen/löschen';
$langFile['PAGESETUP_PAGES_TIP_CREATEPAGES']                              = 'Legt fest ob der Benutzer Seiten ohne Kategorie erstellen und löschen kann.';
$langFile['PAGESETUP_PAGES_TEXT_UPLOADTHUMBNAILS']                        = 'Thumbnails hochladen';
$langFile['PAGESETUP_PAGES_TIP_UPLOADTHUMBNAILS']                         = 'Legt fest ob der Benutzer, innerhalb der Seiten ohne Kategorie, Seiten-Thumbnails hochladen kann.';
$langFile['PAGESETUP_PAGES_TEXT_EDITTAGS']                                = 'Tags bearbeiten';
$langFile['PAGESETUP_PAGES_TIP_EDITTAGS']                                 = 'Legt fest ob der Benutzer, innerhalb der Seiten ohne Kategorie, Tags bearbeiten kann.[br]'.$langFile['PAGESETUP_PAGES_TIP_TAG'];
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


$langFile['PAGESETUP_CATEGORY_TITLE_ADVANCEDSETTINGS']                    = 'Erweiterte Einstellungen';
$langFile['PAGESETUP_CATEGORY_HINT_ADVANCEDSETTINGS']                     = 'Wenn diese Einstellungen ausgefüllt werden, werden die Seiten-Thumbnail-Einstellungen weiter oben und die '.$langFile['adminSetup_editorSettings_h1'].' in den <a href="?site=adminSetup">Administrator-Einstellungen</a> überschrieben.';

$langFile['PAGESETUP_CATEGORY_TIP_STYLESHEETS_EMPTY']                     = 'Wenn alle Felder leer sind, dann werden die Stylesheet-Einstellungen aus den '.$langFile['adminSetup_editorSettings_h1'].' verwendet.';

$langFile['PAGESETUP_CATEGORY_TEXT_CATEGORYSTATUS']                       = 'Status der Kategorie';
$langFile['PAGESETUP_CATEGORY_TIP_CATEGORYSTATUS']                        = 'Legt fest ob die Kategorie auf der Webseite sichtbar ist.';
$langFile['PAGESETUP_CATEGORY_TEXT_CREATEPAGES']                          = 'Seiten erstellen/löschen';
$langFile['PAGESETUP_CATEGORY_TIP_CREATEPAGES']                           = 'Legt fest ob der Benutzer kann in dieser Kategorie Seiten erstellen und löschen kann.';
$langFile['PAGESETUP_CATEGORY_TEXT_UPLOADTHUMBNAILS']                     = 'Thumbnails hochladen';
$langFile['PAGESETUP_CATEGORY_TIP_UPLOADTHUMBNAILS']                      = 'Legt fest ob der Benutzer Thumbnails für jede Seite in dieser Kategorie hochladen kann.';
$langFile['PAGESETUP_CATEGORY_TEXT_EDITTAGS']                             = 'Tags bearbeiten';
$langFile['PAGESETUP_CATEGORY_TIP_EDITTAGS']                              = 'Es können Tags für die Seiten in dieser Kategorie festgelegt werden.[br]'.$langFile['PAGESETUP_PAGES_TIP_TAG'];
$langFile['PAGESETUP_CATEGORY_TEXT_ACTIVATEPLUGINS']                      = 'Plugins aktivieren';
$langFile['PAGESETUP_CATEGORY_TIP_ACTIVATEPLUGINS']                       = 'Plugins für die Seiten in dieser Kategorie aktivieren';

$langFile['PAGESETUP_TEXT_EDITPAGEDATE']                                  = 'Seitendatum bearbeiten';
$langFile['PAGESETUP_TIP_EDITPAGEDATE']                                   = 'Das Seitendatum kann dazu verwendet werden, Seiten auf der Webseite nach Datum zu sortieren';
$langFile['PAGESETUP_TEXT_PAGEDATERANGE']                                 = 'als Zeitraum';


$langFile['PAGESETUP_TEXT_FEEDS']                                         = 'Feeds aktivieren';
$langFile['PAGESETUP_TIP_FEEDS']                                          = 'RSS 2.0 und Atom Feed für diese Seiten aktivieren.';
$langFile['PAGESETUP_CATEGORY_TIP_FEEDS']                                 = 'RSS 2.0 und Atom Feed für diese Kategorie aktivieren.';

$langFile['PAGESETUP_TEXT_SUBCATEGORY']                                   = 'Unterkategorien bearbeiten';
$langFile['PAGESETUP_TIP_SUBCATEGORY']                                    = 'Eine Unterkategorie kann für jede Seite eingestellt werden.';

$langFile['PAGESETUP_TEXT_SORTMANUALLY']                                  = 'Seiten manuell sortieren';
$langFile['PAGESETUP_TIP_SORTMANUALLY']                                   = 'Neu erstellte Seiten erscheinen [strong]oben[/strong].';

$langFile['PAGESETUP_TIP_SORTBYPAGEDATE']                                 = 'Seiten nach Seitendatum sortieren';
$langFile['PAGESETUP_TIP_SORTBYDATE']                                     = 'Seiten mit jüngeren Datum erscheinen [strong]oben[/strong].[br][br][span class=hint]Manuelles Sortieren ist nicht mehr möglich.[/span]';

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
$langFile['websiteSetup_websiteConfig_field2_tip']                        = 'Der Name der Organisation/Firma/Person, die diese Seite veröffentlicht.';
$langFile['websiteSetup_websiteConfig_field3']                            = 'Copyright';
$langFile['websiteSetup_websiteConfig_field3_tip']                        = 'Der Copyright-Besitzer der Webseite.';

$langFile['websiteSetup_websiteConfig_field4']                            = 'Suchmaschinen-Stichworte';
$langFile['websiteSetup_websiteConfig_field4_tip']                        = 'Die meisten Suchmaschienen durchsuchen den Seiteninhalt nach Stichworten, jedoch sollte man hier einige Schlüsselwörter angeben, welche in den <meta> Tags der webseite verwendet werden.';
$langFile['websiteSetup_websiteConfig_field4_inputTip']                   = 'Die Stichworte müssen mit &quot;,&quot; getrennt werden::'.$langFile['TEXT_EXAMPLE'].':[br]stichwort1,stichwort2,etc';
$langFile['websiteSetup_websiteConfig_field5']                            = 'Webseitenbeschreibung';
$langFile['websiteSetup_websiteConfig_field5_tip']                        = 'Eine kurze Beschreibung die von den Suchmaschienen verwendet wird wenn Stichworte in der Webseiten-URL gefunden wurden aber nicht im inhalt.';
$langFile['websiteSetup_websiteConfig_field5_inputTip']                   = 'Ein kurzer Text mit nicht mehr als 3 Zeilen.';

$langFile['WEBSITESETUP_TITLE_PAGESETTINGS']                           = 'Erweiterte Webseiten-Einstellungen';
$langFile['WEBSITESETUP_TEXT_MAINTENANCE']                             = 'Webseite deaktivieren';
$langFile['WEBSITESETUP_TIP_MAINTENANCE']                              = 'Zeigt anstatt der Webseite eine Meldung, dass diese derzeit bearbeitet wird.';
$langFile['WEBSITESETUP_TEXT_SITEMAPFILES']                            = 'Sitemap-Dateien erzeugen (<a href="http://www.sitemaps.org/" target="_blank">Details</a>)';
$langFile['WEBSITESETUP_TIP_SITEMAPFILES']                             = 'Die Sitemap-Dateien vereinfachen Suchmaschinen das Indizieren der Webseite.';
$langFile['WEBSITESETUP_TEXT_VISITORTIMEZONE']                         = 'Besucherzeitzone verwenden';
$langFile['WEBSITESETUP_TIP_VISITORTIMEZONE']                          = 'Versucht die Zeitzone des Besuchers zu erfassen, um Zeitangaben in der lokalen Zeit des Besuchers darzustellen.[br][br][span class=hint]Beim ersten Besuch der Webseite wird die Seite neu geladen.[span]';
$langFile['WEBSITESETUP_TEXT_MULTILANGUAGEWEBSITE']                    = 'Mehrsprachige Webseite';
$langFile['WEBSITESETUP_TEXT_MAINLANGUAGE']                            = 'Hauptsprache';
$langFile['WEBSITESETUP_TIP_MAINLANGUAGE']                             = 'Die Hauptsprache wird verwendet, wenn nicht automatisch eine passende Sprache erfasst werden konnte.';
$langFile['WEBSITESETUP_TEXT_DATEFORMAT']                              = 'Datumsformat';
$langFile['WEBSITESETUP_TIP_DATEFORMAT']                               = 'Welches in der Webseite verwendet wird.';


/*
* statisticSetup.php
*/

// ---------- STATISITC SETUP (on toolTips tooTips.js converts the "[" and "]" tags in the tittle attribute to "<" ">")
$langFile['STATISTICSSETUP_ERROR_SAVE']                                   = $langFile['ERROR_SAVE_SETTINGS'].$langFile['ERROR_SAVE_FILE'].'%sconfig/statistic.config.php';

$langFile['STATISTICSSETUP_TITLE_STATISTICSSETTINGS']                     = 'Statistik-Einstellungen';
$langFile['STATISTICSSETUP_TEXT_REFERERNUMBER']                           = 'Anzahl der <b>Referrer-URLs</b>';
$langFile['STATISTICSSETUP_TIP_REFERERNUMBER']                            = 'Gibt an wieviele Referrer-URLs ([i]URLs die auf diese Webseite geführt haben[/i]) maximal gespeichert werden.';
$langFile['STATISTICSSETUP_TEXT_ACTIVITYNUMBER']                          = 'Anzahl der <b>Tätigkeiten-Logs</b>';
$langFile['STATISTICSSETUP_TIP_ACTIVITYNUMBER']                           = 'Gibt an wieviele Tätigkeiten-Logs maximal gespeichert werden.';


$langFile['statisticSetup_clearStatistic_h1']                             = 'Statistiken löschen';
$langFile['statisticSetup_clearStatistics_websiteStatistic']              = 'Webseiten-Statistik';
$langFile['statisticSetup_clearStatistics_websiteStatistic_tip']          = '[strong]Beinhaltet[/strong][ul][li]Gesamtanzahl der Besuche[/li][li]Gesamtanzahl der Web-Crawler[/li][li]Datum des ersten Besuchs[/li][li]Datum des letzten Besuchs[/li][li]Browserspektrum[/li][/ul]';
$langFile['statisticSetup_clearStatistics_pagesStatistic']                = 'Seiten-Statistiken';
$langFile['statisticSetup_clearStatistics_pagesStatistic_tip']            = '[strong]Beinhaltet[/strong][ul][li]Anzahl der Seitenbesuche[/li][li]Datum des ersten Seitenbesuchs[/li][li]Datum des letzten Seitenbesuchs[/li][li]kürzeste Verweildauer[/li][li]längste Verweildauer[/li][li]Suchmaschienen-Stichworte welche auf diese Seite geführt haben[/li][/ul]';
$langFile['statisticSetup_clearStatistics_pagesStaylengthStatistics']     = 'nur die Seiten-Verweildauer-Statistiken';
$langFile['statisticSetup_clearStatistics_pagesStaylengthStatistics_tip'] = '';
$langFile['statisticSetup_clearStatistics_refererLog']                    = 'Referrer-URLs Log'; // engl.: referer
$langFile['statisticSetup_clearStatistics_refererLog_tip']                = 'Eine Liste mit allen URLs welche auf diese Webseite geführt haben.';
$langFile['statisticSetup_clearStatistics_taskLog']                       = 'Logs der letzten Tätigkeiten';
$langFile['statisticSetup_clearStatistics_taskLog_tip']                   = 'Beinhaltet eine Liste der letzten Tätigkeiten.';

$langFile['statisticSetup_clearStatistics_question_h1']                   = 'Willst du diese Statistiken wirklich löschen?';

$langFile['statisticSetup_clearStatistic_pagesStatistics_error_read']     = 'Fehler beim löschen der Seiten-Statistiken.'.$langFile['ERROR_SAVE_FOLDER_PART1'].'%sstatistics/pages/'.$langFile['ERROR_FOLDER_PART2'];

/*
* userSetup.php
*/

$langFile['USERSETUP_h1']                                                 = 'Benutzer-Verwaltung';
$langFile['USERSETUP_userSelection']                                      = 'Benutzer';

$langFile['USERSETUP_createUser']                                         = 'Neuen Benutzer anlegen';
$langFile['USERSETUP_createUser_created']                                 = 'Neuen Benutzer angelegt';
$langFile['USERSETUP_createUser_unnamed']                                 = 'Unbenannter Benutzer';

$langFile['USERSETUP_deleteUser']                                         = 'Benutzer löschen';
$langFile['USERSETUP_deleteUser_deleted']                                 = 'Benutzer gelöscht';

$langFile['USERSETUP_username']                                           = 'Benutzername';
$langFile['USERSETUP_username_missing']                                   = 'Es wurde noch keine Benutzername für diesen Benutzer festgelegt.';
$langFile['USERSETUP_password']                                           = 'Passwort';
$langFile['USERSETUP_password_change']                                    = 'Passwort ändern';
$langFile['USERSETUP_password_confirm']                                   = 'Passwort wiederholen';
$langFile['USERSETUP_password_confirm_wrong']                             = 'Die beiden Passwörter stimmen nicht überein.';
$langFile['USERSETUP_password_missing']                                   = 'Es wurde noch keine Passwort für diesen Benutzer festgelegt.';
$langFile['USERSETUP_password_success']                                   = 'Passwort erfolgreich geändert!';
$langFile['USERSETUP_email']                                              = 'E-Mail';
$langFile['USERSETUP_email_tip']                                          = 'Wenn der Benutzer sein Passwort vergessen hat, wird an diese E-Mail ein neues Passwort gesendet.';

$langFile['USERSETUP_admin']                                              = 'Administrator';
$langFile['USERSETUP_admin_tip']                                          = 'Legt fest ob der Benutzer Administratorrechte besitzt.';

$langFile['USERSETUP_error_create']                                       = '<b>Ein neuer Benutzer konnte nicht angelegt werden.</b>'.$langFile['ERROR_SAVE_FILE'].'%sconfig/user.config.php';
$langFile['USERSETUP_error_save']                                         = $langFile['ERROR_SAVE_SETTINGS'].$langFile['ERROR_SAVE_FILE'].'%sconfig/user.config.php';

// ---------- USER PERMISSION
$langFile['USERSETUP_USERPERMISSIONS_TITLE']                              = 'Benutzerrechte';
$langFile['USERSETUP_USERPERMISSIONS_TEXT_ACTIVATEWEBSITESETTINGS']       = 'Webseiten-Einstellungen bearbeiten';
$langFile['USERSETUP_USERPERMISSIONS_TEXT_EDITWEBSITEFILES']              = 'Webseitendateien in den <a href="index.php?site=websiteSetup">Webseiten-Einstellungen</a> bearbeiten';
$langFile['USERSETUP_USERPERMISSIONS_TEXT_EDITSTYLESHEETS']               = 'Stylesheetdateien in den <a href="index.php?site=websiteSetup">Webseiten-Einstellungen</a> bearbeiten';
$langFile['USERSETUP_USERPERMISSIONS_TEXT_EDITSNIPPETS']                  = 'Codeschnipsel in den <a href="index.php?site=websiteSetup">Webseiten-Einstellungen</a> bearbeiten';
$langFile['USERSETUP_USERPERMISSIONS_TEXT_FILEMANAGER']                   = 'Dateimanager aktivieren';
$langFile['USERSETUP_USERPERMISSIONS_TEXT_FRONTENDEDITING']               = 'Frontend-Bearbeitung aktivieren';
$langFile['USERSETUP_USERPERMISSIONS_TEXT_USERINFORMATION']               = '<strong>Benutzerinformation</strong> in der <a href="?site=dashboard">'.$langFile['BUTTON_DASHBOARD'].'</a>';
$langFile['USERSETUP_USERPERMISSIONS_TIP_USERINFORMATION']                = 'Benutzerinformationen::Dieser Text wird auf der [span class=feinduraInline]fein[em]dura[/em][/span] '.$langFile['BUTTON_DASHBOARD'].' angezeigt.';
$langFile['USERSETUP_USERPERMISSIONS_TIP_USERINFORMATION_NOINFO']         = 'Wenn Du keine Informationen für den Benutzer anzeigen möchtest lasse das Feld leer';

$langFile['USERSETUP_USERPERMISSIONS_TITLE_EDITABLECATEGORIES-PAGES']     = 'Wähle Kategorien und Seiten aus die der Benutzer bearbeiten kann<br>(Wenn nichts ausgewählt wurde kann alles bearbeitet werden)';
$langFile['USERSETUP_USERPERMISSIONS_TEXT_CLEARSELECTION']                = 'Auswahl löschen';


/*
* editor.php
*/

// ---------- page info
$langFile['EDITOR_TITLE_CREATEPAGE']                                      = 'Neue Seite erstellen';
$langFile['EDITOR_TITLE_ADDLANGUAGE']                                     = 'Sprache &quot;%s&quot; zur Seite hinzufügen';
$langFile['EDITOR_pageinfo_lastsavedate']                                 = 'zuletzt bearbeitet';
$langFile['EDITOR_pageinfo_lastsaveauthor']                               = 'von';
$langFile['EDITOR_pageinfo_linktothispage']                               = 'Link zu dieser Seite';
$langFile['EDITOR_pageinfo_id']                                           = 'Seiten ID';
$langFile['EDITOR_pageinfo_id_tip']                                       = 'Unter dieser ID wird die Seite auf dem Server gespeichert.';
$langFile['EDITOR_pageinfo_category']                                     = 'Kategorie';
$langFile['EDITOR_pageinfo_category_noCategory']                          = 'keine Kategorie';

$langFile['EDITOR_TEXT_CHOOSETEMPLATE']                                   = 'Benutze Vorlage';
$langFile['EDITOR_TEXT_TEMPALATECOPYADDITION']                            = 'Kopie';

$langFile['EDITOR_block_edited']                                          = 'wurden bearbeitet';
$langFile['EDITOR_pageNotSaved']                                          = 'noch nicht gespeichert';

$langFile['EDITOR_EDITLINK']                                              = 'Link bearbeiten';

// ---------- page settings
$langFile['EDITOR_pagestatistics_h1']                                     = 'Statistik';

$langFile['EDITOR_pageSettings_title']                                    = 'Titel';
$langFile['EDITOR_pageSettings_title_tip']                                = 'Der Titel der Seite, kann die folgenden HTML-Tags enthalten:[br]<a> <span> <em> <strong> <i> <b> <abbr> <code> <samp> <kbd> <var>';
$langFile['EDITOR_pageSettings_field1']                                   = 'Kurzbeschreibung';
$langFile['EDITOR_pageSettings_field1_inputTip']                          = 'Wenn das Feld leer ist, wird die Webseiten-Beschreibung aus den Webseiten-Einstellungen verwendet.';
$langFile['EDITOR_pageSettings_field1_tip']                               = 'Eine kurze Zusammenfassung der Seite. Diese kommt in die META-Tags der Seite.[br][br][span class=hint]'.$langFile['EDITOR_pageSettings_field1_inputTip'].'[/span]';
$langFile['EDITOR_pageSettings_field2']                                   = 'Tags';
$langFile['EDITOR_pageSettings_field2_tip']                               = 'Tags sind Stichworte für diese Seite.';
$langFile['EDITOR_pageSettings_field2_tip_inputTip']                      = 'Die Tags müssen mit &quot;,&quot; (Komma) getrennt werden.';
$langFile['EDITOR_pageSettings_field3']                                   = 'Seitendatum';
$langFile['EDITOR_pageSettings_field3_tip']                               = 'Das Datum kann dazu verwendet werden, Seiten nach Datum zu sortieren. (z.B. bei Veranstaltungen)';
$langFile['EDITOR_pageSettings_field4']                                   = 'Status der Seite';
$langFile['EDITOR_pageSettings_field4_tip']                               = '[strong]Nur wenn die Seite öffentlich ist, wird diese auf der Webseite angezeigt![/strong]';

$langFile['EDITOR_PAGESETTINGS_NOPAGEDATE']                               = 'Kein Datum angegeben';

$langFile['EDITOR_TEXT_SUBCATEGORY']                                      = 'Unterkategorie';
$langFile['EDITOR_TIP_SUBCATEGORY']                                       = 'Erlaubt, in der Webseite, das erstellen eines Untermenüs für diese Seite.';

$langFile['EDITOR_BUTTON_RESTORELASTSTATE']                               = 'Version von %s wiederherstellen';
$langFile['EDITOR_MESSAGE_RESTOREDTOLASTSTATE']                           = 'Version von %s wiederhergestellt.';

// ---------- page advanced settings
$langFile['EDITOR_advancedpageSettings_h1']                               = 'Seitenspezifische HTML-Editor-Einstellungen';

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
$langFile['EDITOR_pluginSettings_h1']                                     = 'Plugins hinzufügen';
$langFile['EDITOR_TEXT_EDITPLUGINSINEDITOR']                              = 'Nach dem du ein Plugin aktiviert hast, bleib mit der Maus darüber um es in den Editor ziehen zu können, oder nutze im Editor das Icon %s.';
$langFile['EDITOR_MESSAGE_PLUGINSSAVED']                                  = '<div class="alert alert-success">Plugins gespeichert!</div>';//<div class="alert">Klicken Sie auf ein Plugin, um es zu bearbeiten.</div>';
$langFile['EDITOR_TIP_DRAGPLUGIN']                                        = 'Ziehe das Plugin in den Editor um es zu platzieren.';


/*
* unsavedPage.php
*/

$langFile['UNSAVEDPAGE_QUESTION_CONTINUE']                                = 'Die Seite wurde verändert!<br><span class="brown">Willst du fortfahren?</span>';

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
* deletePageLanguage.php
*/

// ---------- DELETE PAGE LANGUAGE

$langFile['WINDOWBOX_TEXT_DELETEPAGELANGUAGE_QUESTION']                   = 'Soll die Sprache &quot;%s&quot; für diese Seite wirklich gelöscht werden?';


/*
* addPageLanguage.php
*/

// ---------- ADD PAGE LANGUAGE

$langFile['WINDOWBOX_TEXT_ADDPAGE_SELECTLANGUAGE']                        = 'Sprache auswählen';


/*
* deletewebsiteLanguages.php
*/

// ---------- DELETE WEBSITE LANGUAGES

$langFile['WINDOWBOX_TITLE_DELETEWEBSITELANGUAGES_QUESTION']              = 'Die folgenden Sprachen werden von allen Seiten gelöscht!<br>&quot;%s&quot;';
$langFile['WINDOWBOX_TEXT_DELETEWEBSITELANGUAGES_QUESTION']               = 'Mehrsprachige Webseite wurde deaktiviert!<br>Alle Seiten werden auf die vorherige Hauptsprache (<b>%s</b>) umgestellt.';


/*
* deletePageThumbnail.php
*/

// ---------- PAGE THUMBNAIL DELETE
$langFile['PAGETHUMBNAIL_TEXT_DELETE_QUESTION_START']                     = 'Möchtest du das Thumbnail von der Seite';
$langFile['PAGETHUMBNAIL_TEXT_DELETE_QUESTION_END']                       = 'wirklich löschen?';
$langFile['PAGETHUMBNAIL_ERROR_DELETE']                                   = 'FEHLER: Das Thumbnail konnte nicht gelöscht werden!';


/*
* uploadPageThumbnail.php
*/

// ---------- PAGE THUMBNAIL UPLOAD
$langFile['pagethumbnail_h1_part1']                                       = 'Seiten-Thumbnail für';
$langFile['pagethumbnail_h1_part2']                                       = 'hochladen';
$langFile['pagethumbnail_field1']                                         = 'Bild auswählen';

$langFile['pagethumbnail_thumbinfo_formats']                              = 'Nur folgende Dateiformate sind erlaubt'; //<br><b>JPG</b>, <b>JPEG</b>, <b>GIF</b>, <b>PNG</b>
$langFile['pagethumbnail_thumbinfo_filesize']                             = 'maximale Dateigröße';
$langFile['pagethumbnail_thumbinfo_standardthumbsize']                    = 'Standardbildgröße';

$langFile['pagethumbnail_thumbsize_h1']                                   = 'Bildgröße selbst festlegen';
$langFile['pagethumbnail_thumbsize_width']                                = 'Bildbreite';
$langFile['pagethumbnail_thumbsize_height']                               = 'Bildhöhe';

$langFile['pagethumbnail_submit_tip']                                     = 'Bild hochladen';

$langFile['PAGETHUMBNAIL_ERROR_nofile']                                   = 'Du hast keine Datei ausgewählt.';
$langFile['PAGETHUMBNAIL_ERROR_nouploadedfile']                           = 'Es wurde keine Datei hochgeladen.';
$langFile['PAGETHUMBNAIL_ERROR_filesize']                                 = 'Wahrscheinlich ist die hochgeladene Datei zu groß.<br>Die maximal erlaubte Dateigröße beträgt';
$langFile['PAGETHUMBNAIL_ERROR_wrongformat']                              = 'Die ausgewählte Datei hat ein nicht unterstütztes Format';
$langFile['PAGETHUMBNAIL_ERROR_NODIR_START']                              = 'Das Thumbnail-Verzeichnis'; // ..thumbnail-folder..
$langFile['PAGETHUMBNAIL_ERROR_NODIR_END']                                = 'existiert nicht.';
$langFile['PAGETHUMBNAIL_ERROR_CREATEDIR_END']                            = 'konnte nicht erstellt werden.';
$langFile['PAGETHUMBNAIL_ERROR_COULDNTMOVEFILE']                          = 'Konnte die hochgeladene Datei nicht in das Thumbnail-Verzeichnis %s verschieben.';
$langFile['PAGETHUMBNAIL_ERROR_CHANGEIMAGESIZE']                          = 'Die Bildgröße konnte nicht geändert werden.';
$langFile['PAGETHUMBNAIL_ERROR_deleteoldfile']                            = 'Das alte Thumbnail-Bild konnte nicht gelöscht werden.';
$langFile['PAGETHUMBNAIL_TEXT_fileexists']                                = 'Es existiert bereits eine Datei mit diesem Namen.<br>Die Hochgeladene Datei wurde umbenannt nach';
$langFile['PAGETHUMBNAIL_TEXT_finish']                                    = 'Das Bild wurde erfolgreich hochgeladen.';

// -> BACKUP

$langFile['BACKUP_TITLE_BACKUP']                                          = 'Backup';
$langFile['BACKUP_TITLE_RESTORE']                                         = 'Wiederherstellen';

$langFile['BACKUP_TITLE_RESTORE_FROMFILES']                               = 'Vorhandenes Backup auswählen';
$langFile['BACKUP_TITLE_RESTORE_FROMUPLOAD']                              = 'Backup-Datei hochladen';

$langFile['BACKUP_TEXT_RESTORE_BACKUPBEFORERESTORE']                      = 'Backup vor der Wiederherstellung';

$langFile['BACKUP_BUTTON_DOWNLOAD']                                       = 'aktuelles Backup erstellen';
$langFile['BACKUP_TEXT_BACKUP']                                           = 'Ein Backup erstellt eine <code>.zip</code> Datei mit den <span class="blue">"pages","config"</span> und <span class="blue">"statistic"</span> Verzeichnissen.<br>Das Upload-Verzeichnis wird nicht gesichert.';
$langFile['BACKUP_TEXT_RESTORE']                                          = '<p>Wähle hier eine <span class="feinduraName"><span>fein</span>dura</span> Backup-Datei aus um einen alten Stand wieder herzustellen.</p><div class="alert"><strong>Hinweis</strong> Vor der Wiederherstellung wird ein Backup des aktuellen Standes erstellt.</div>';
$langFile['BACKUP_TOOLTIP_DELETE']                                        = 'Backup löschen';
$langFile['BACKUP_TEXT_DELETE_QUESTION']                                  = '%s wirklich löschen?'; // backup 2010-11-05 15:03 wirklich löschen?

$langFile['BACKUP_TITLE_LASTBACKUPS']                                     = 'Backups herunterladen';
$langFile['BACKUP_TEXT_NOBACKUP']                                         = 'Es wurde noch kein Backup erstellt.';

$langFile['BACKUP_ERROR_FILENOTFOUND']                                    = 'Backup-Datei wurde nicht gefunden in:';
$langFile['BACKUP_ERROR_NORESTROEFILE']                                   = 'Es wurde keine Backup-Datei für die Wiederherstellung ausgewählt.';
$langFile['BACKUP_ERROR_DELETE']                                          = 'Backup konnte nicht gelöscht werden!';


// -> ADDONS

$langFile['ADDONS_TITLE_ADDON']                                           = 'Wähle ein <span class="feinduraInline">fein<em>dura</em></span> Add-on';
$langFile['ADDONS_TEXT_AUTHOR']                                           = 'Autor';
$langFile['ADDONS_TEXT_WEBSITE']                                          = 'Website';
$langFile['ADDONS_TEXT_VERSION']                                          = 'Version';
$langFile['ADDONS_TEXT_REQUIREMENTS']                                     = 'Benötigt';


// -> UPDATE

$langFile['UPDATE_TITLE']                                                 = 'Die Inhalte müssen aktualisiert werden';
$langFile['UPDATE_TEXT_CHECKPATHS']                                       = 'Schaue bitte ob die folgenden Pfade stimmen, bevor du startest.';
$langFile['UPDATE_TEXT_BASEPATH']                                         = 'Pfad zu <span class="feinduraInline">fein<em>dura</em></span>';
$langFile['UPDATE_TEXT_WEBSITEPATH']                                      = 'Webseitenpfad';
$langFile['UPDATE_TEXT_SUCCESS']                                          = 'Inhalte erfolgreich aktualisiert!';
$langFile['UPDATE_BUTTON_UPDATE']                                         = 'AKTUALISIEREN';
$langFile['UPDATE_ERROR_MOVEUPLOADFOLDER']                                = 'Upload Ordner konnte nicht kopiert werden! Bitte verschiebe den Ordner "%s" manuell nach "dein_feindura_verzeichnis/upload/".';
$langFile['UPDATE_ERROR_MOVEPAGESFOLDER']                                 = 'Seiten Ordner konnte nicht kopiert werden! Bitte verschiebe den Ordner "%s" manuell nach "dein_feindura_verzeichnis/pages/".';
$langFile['UPDATE_ERROR_SAVEADMINCONFIG']                                 = 'Administrator Einstellungen konnten nicht aktualisiert werden.';
$langFile['UPDATE_ERROR_SAVECATEGORYCONFIG']                              = 'Kategorie Einstellungen konnten nicht aktualisiert werden.';
$langFile['UPDATE_ERROR_SAVEUSERCONFIG']                                  = 'Benutzer Einstellungen konnten nicht aktualisiert werden.';
$langFile['UPDATE_ERROR_SAVEWEBSITECONFIG']                               = 'Webseiten Einstellungen konnten nicht aktualisiert werden.';
$langFile['UPDATE_ERROR_SAVEPAGES']                                       = 'Seiten konnten nicht aktualisiert werden.';
$langFile['UPDATE_ERROR_CLEARACTIVITYLOG']                                = 'Aktivitäts Log konnte nicht gelöscht werden.';
$langFile['UPDATE_ERROR_SAVEWEBSITESTATISTICS']                           = 'Webseiten Statistics konnten nicht aktualisiert werden.';
$langFile['UPDATE_ERROR_SAVEREFERERLOG']                                  = 'Referer Log konnten nicht aktualisiert werden.';
$langFile['UPDATE_ERROR_DELETEOLDFILES']                                  = 'Konnte alte Verzeichnisse und Dateien nicht löschen.<br>Bitte lösche folgende Dateien und Verzeichnisse manuell:';
$langFile['UPDATE_ERROR_RENAMESTATISTICSFOLDER']                          = 'Couldn\'t rename the "feinduraFolder/statistic" folder "feinduraFolder/statistic<strong>s</strong>, please rename it manually!"';


// -----------------------------------------------------------------------------------------------
// RETURN ****************************************************************************************
// -----------------------------------------------------------------------------------------------
return $langFile;
