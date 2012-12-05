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
 * ROMANIAN (RO) language-file for the feindura CMS (BACKEND)
 *
 * IMPORTANT:<br>
 * if you want to write html-code in the toolTip texts (mostly they end with ".._tip" or ".._inputTip")
 * use only "[" and "]" instead of "<" and ">" for the HTML-tags and use no " this would end the title="" tag where the toolTip text is in.
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

$langFile['LOGIN_INPUT_USERNAME']                                         = 'Utilizator';
$langFile['LOGIN_INPUT_PASSWORD']                                         = 'Parola';
$langFile['LOGIN_BUTTON_LOGIN']                                           = 'login';
$langFile['LOGIN_TEXT_COOKIESNEEDED']                                     = 'Cookie-urile trebuie activate!';

$langFile['LOGIN_LINK_FORGOTPASSWORD']                                    = 'Ai uitat parola??';
$langFile['LOGIN_LINK_BACKTOLOGIN']                                       = 'Inapoi la logare';
$langFile['LOGIN_BUTTON_SENDNEWPASSWORD']                                 = 'Reseteaza parola';
$langFile['LOGIN_TEXT_NEWPASSWORDEMAIL_SUBJECT']                          = 'Ai solicitat parola Feindura de la:';
$langFile['LOGIN_TEXT_NEWPASSWORDEMAIL_MESSAGE']                          = 'Ai solicitat o parola noua pentru CMS - Feindura.
Your username and your new password are:';

$langFile['LOGIN_ERROR_FORGOTPASSWORD_NOEMAIL']                           = 'Utilizatorul nu are adresa de email.';
$langFile['LOGIN_ERROR_FORGOTPASSWORD_NOTSEND']                           = 'EROARE<br> in timpul trimiterii parolei noi la adresa specificata de utilizator ';
$langFile['LOGIN_ERROR_FORGOTPASSWORD_NOTSAVED']                          = 'EROARE<br> Nu pot salva parola nou generata.';
$langFile['LOGIN_ERROR_FORGOTPASSWORD_SUCCESS']                           = 'Parola noua a fost trimisa la adresa de email urmatoare';

$langFile['LOGIN_ERROR_WRONGUSER']                                        = 'Utilizatorul nu exista';
$langFile['LOGIN_ERROR_WRONGPASSWORD']                                    = 'parola gresita';

$langFile['LOGIN_TEXT_LOGOUT_PART1']                                      = 'Iesire cu succes';
$langFile['LOGIN_TEXT_LOGOUT_PART2']                                      = 'catre website';

$langFile['LOGIN_TIP_AUTOLOGOUT']                                         = 'iesire automata';


// -> GENERAL <-

$langFile['DATE_Y-M-D']                                                   = 'YYYY-MM-DD';
$langFile['DATE_D.M.Y']                                                   = 'DD.MM.YYYY';
$langFile['DATE_D/M/Y']                                                   = 'DD/MM/YYYY';
$langFile['DATE_M/D/Y']                                                   = 'MM/DD/YYYY';
$langFile['CATEGORIES_TEXT_NONCATEGORY']                                  = 'Pagini';
$langFile['CATEGORIES_TOOLTIP_NONCATEGORY']                               = 'Pagini fara categorie';
$langFile['TEXT_EXAMPLE']                                                 = 'Exemple';

$langFile['HEADER_BUTTON_GOTOWEBSITE_FRONTENDEDITING']                    = 'Editare in frontend:: Click aici pentru a edita paginile direct in site.';

$langFile['BUTTON_MORE']                                                  = 'mai mult';

// PERMISSIONS
$langFile['PERMISSIONS_TEXT_DONTHAVEPERMISSION']                          = 'Nu esti autorizat sa schimbi asta.';

// THUMBNAILS
$langFile['THUMBNAIL_TEXT_UNIT']                                          = 'pixel';

$langFile['THUMBNAIL_TEXT_NAME']                                          = 'Thumbnail-ul paginii';
$langFile['THUMBNAIL_TEXT_WIDTH']                                         = 'Thumbnail <b>latime</b>';
$langFile['THUMBNAIL_TEXT_HEIGHT']                                        = 'Thumbnail <b>inaltime</b>';

$langFile['THUMBNAIL_TOOLTIP_WIDTH']                                      = 'Latime standard::Latimea thumbnail-ului in pixeli.[br][br]Imaginea va fi redimensionata la aceasta dimensiune dupa incarcare.';
$langFile['THUMBNAIL_TOOLTIP_HEIGHT']                                     = 'Inaltime standard::Inaltimea thumbnail-ului in pixeli.[br][br]Imaginea va fi redimensionata la aceasta dimensiune dupa incarcare.';

$langFile['THUMBNAIL_TEXT_RATIO']                                         = 'Proportie';
$langFile['THUMBNAIL_TEXT_KEEPRATIO']                                     = 'pastreaza proportia';
$langFile['THUMBNAIL_TEXT_FIXEDRATIO']                                    = 'proportie fixa';
$langFile['THUMBNAIL_TOOLTIP_FIXEDRATIO']                                 = 'Inaltime si latime setate manual';
$langFile['THUMBNAIL_TOOLTIP_KEEPRATIO_X']                                = 'Se va alinia cu  [i]latimea[/i].';
$langFile['THUMBNAIL_TOOLTIP_KEEPRATIO_Y']                                = 'Se va alinia cu [i]inaltimea[/i].';

// STYLESHEETS
$langFile['STYLESHEETS_TEXT_STYLEFILE']                                   = 'Fisiere stylesheet ';
$langFile['STYLESHEETS_TEXT_ID']                                          = 'Stylesheet-Id';
$langFile['STYLESHEETS_TEXT_CLASS']                                       = 'Stylesheet-Class';

$langFile['STYLESHEETS_TOOLTIP_STYLEFILE']                                = 'Aici poti specifica fisierele stylesheet ce vor fi utilizate pentru formatarea continutului HTML.';
$langFile['STYLESHEETS_TOOLTIP_ID']                                       = 'Aici poti defini un Atribut ID, care va fi adaugat la <body> tag-ul editorului HTML.';
$langFile['STYLESHEETS_TOOLTIP_CLASS']                                    = 'Aici poti defini un Atribut Clasa, care va fi adaugat la <body> tag-ul editorului HTML.';

$langFile['STYLESHEETS_TOOLTIP_ADDSTYLEFILE']                             = 'adauga fisier stylesheet ';
$langFile['STYLESHEETS_EXAMPLE_STYLEFILE']                                = '<b>Exemplu</b> &quot;/style/layout.css&quot;';

// PATHS
$langFile['PATHS_TEXT_ABSOLUTE']                                          = 'cale absoluta';
$langFile['PATHS_TEXT_RELATIVE']                                          = 'cale relativa';
$langFile['PATHS_TOOLTIP_ABSOLUTE']                                       = 'Cale absoluta::Sistem de fisiere cu cale absoluta. (Dar relativa la radacina documentelor)[br][br][span class=hint]/server/htdocs[strong]/path/[/strong][/span]';
$langFile['PATHS_TOOLTIP_RELATIVE']                                       = 'Cale relativa::Cale URI relativa  , adica relativ la documentul curent.';

// STATISTICS
$langFile['STATISTICS_TITLE_BROWSERCHART']                                = 'Utilizare browsere';
$langFile['STATISTICS_TEXT_ROBOTCOUNT']                                   = 'web-crawler';
$langFile['STATISTICS_TOOLTIP_ROBOTCOUNT']                                = 'web-crawler::Sau robots, sunt programe ale motoarelor de cautare care analizeaza si indexeaza site-ul.';

$langFile['STATISTICS_TEXT_SEARCHWORD_PART1']                             = 'led'; // "exampleword" led 20 times to this website
$langFile['STATISTICS_TEXT_SEARCHWORD_PART2']                             = 'ori pe acest site';
$langFile['STATISTICS_TOOLTIP_SEARCHWORD']                                = 'Click  pentru a cauta acest cuvant in pagini.';

$langFile['STATISTICS_TEXT_VISITORCOUNT']                                 = 'Vizite pana acum';
$langFile['STATISTICS_TEXT_CURRENTVISITORS']                              = 'Vizitatori curenti';
$langFile['STATISTICS_TEXT_CURRENT']                                      = 'Acum';
$langFile['STATISTICS_TEXT_LASTACTIVITY']                                 = 'Ultima activitate';

$langFile['STATISTICS_TITLE_PAGESTATISTICS']                              = 'Statisticile Paginii';

$langFile['STATISTICS_TEXT_VISITTIME_MAX']                                = 'cea mai lunga perioada a vizitei';
$langFile['STATISTICS_TEXT_VISITTIME_MIN']                                = 'cea mai scurta perioada a vizitei';
$langFile['STATISTICS_TEXT_FIRSTVISIT']                                   = 'de la';
$langFile['STATISTICS_TEXT_LASTVISIT']                                    = 'pana la';
$langFile['STATISTICS_TEXT_NOVISIT']                                      = 'Pana acum nu aveti nici un vizitator.';
$langFile['STATISTICS_TEXT_SEARCHWORD_DESCRIPTION']                       = '<span class="toolTipTop" title="::Au venit din Google, Yahoo sau Bing (MSN) catre acest site.">Searchwords</span>';

$langFile['STATISTICS_TEXT_HOUR_SINGULAR']                                = 'ora';
$langFile['STATISTICS_TEXT_HOUR_PLURAL']                                  = 'ore';
$langFile['STATISTICS_TEXT_MINUTE_SINGULAR']                              = 'minut';
$langFile['STATISTICS_TEXT_MINUTE_PLURAL']                                = 'minute';
$langFile['STATISTICS_TEXT_SECOND_SINGULAR']                              = 'secunda';
$langFile['STATISTICS_TEXT_SECOND_PLURAL']                                = 'secunde';

$langFile['STATISTICS_TEXT_BROWSERCHART_OTHERS']                          = 'alte';

// LOG TEXTS
$langFile['LOG_PAGE_SAVED']                                               = 'Pagina salvata';
$langFile['LOG_PAGE_NEW']                                                 = 'Pagina nou creata';
$langFile['LOG_PAGE_DELETE']                                              = 'Pagina stearsa';

$langFile['LOG_PAGE_MOVEDINCATEGORY']                                     = 'Pagina mutata la categorie';
$langFile['LOG_PAGE_MOVEDTOCATEGORY_CATEGORY']                            = 'La categorie'; // Example Page in Category
$langFile['LOG_PAGE_SORTED']                                              = 'Ordinea paginilor s-a schimbat';

$langFile['LOG_THUMBNAIL_UPLOAD']                                         = 'Un nou thumbnail a fost incarcat';
$langFile['LOG_THUMBNAIL_DELETE']                                         = 'Thumbnail sters';

$langFile['LOG_USER_ADD']                                                 = 'Utilizator nou creat';
$langFile['LOG_USER_DELETED']                                             = 'Utilizator sters';
$langFile['LOG_USER_PASSWORD_CHANGED']                                    = 'Parola utilizator stearsa';
$langFile['LOG_USER_SAVED']                                               = 'Utilizator salvat';

$langFile['LOG_ADMINSETUP_SAVED']                                         = 'Setari Adminstrator salvate';
$langFile['LOG_ADMINSETUP_CKSTYLES']                                      = '&quot;Formatting-Styles&quot; of the HTML-Editor saved';

$langFile['LOG_WEBSITESETUP_SAVED']                                       = 'Setarile Website-ului au fost salvate';

$langFile['LOG_STATISTICSETUP_SAVED']                                     = 'Setarile Statisticilor salvate';
$langFile['LOG_CLEARSTATISTICS_WEBSITESTATISTIC']                         = 'Statisticile site-ului sterse';
$langFile['LOG_CLEARSTATISTICS_PAGESTATISTICS']                           = 'statisticile paginii au fost sterse';
$langFile['LOG_CLEARSTATISTICS_PAGESTAYLENGTH']                           = 'Statisticile lungimii vizitei pe pagina, sterse';
$langFile['LOG_CLEARSTATISTICS_REFERERLOG']                               = 'Referrer-Log sters';
$langFile['LOG_CLEARSTATISTICS_ACTIVITYLOG']                              = 'Log-ul activitatilor, sters';

$langFile['LOG_PAGESETUP_SAVED']                                          = 'Setarile paginii salvate';
$langFile['LOG_PAGESETUP_CATEGORIES_SAVED']                               = 'Categorii salvate';

$langFile['LOG_PAGESETUP_CATEGORIES_NEW']                                 = 'Categorie nou creata';
$langFile['LOG_PAGESETUP_CATEGORIES_DELETED']                             = 'Categorie stearsa';
$langFile['LOG_PAGESETUP_CATEGORIES_MOVED']                               = 'Categorie mutata';

$langFile['LOG_FILE_SAVED']                                               = 'Fisier salvat';
$langFile['LOG_FILE_DELETED']                                             = 'Fisier sters';

$langFile['LOG_BACKUP_CREATED']                                           = 'Backup realizat';
$langFile['LOG_BACKUP_RESTORED']                                          = 'Backup restaurat';
$langFile['LOG_BACKUP_DELETED']                                           = 'Backup sters';

$langFile['LOG_PAGELANGUAGE_DELETED']                                     = 'Limba stearsa &quot;%s&quot; pentru pagina';
$langFile['LOG_PAGELANGUAGE_ADD']                                         = 'Adauga limba &quot;%s&quot; pentru pagina';

// PAGE/CATEGORY STATUS
$langFile['STATUS_PAGE_PUBLIC']                                           = 'Pagina este publica';
$langFile['STATUS_PAGE_NONPUBLIC']                                        = 'Pagina este ascunsa';

$langFile['STATUS_CATEGORY_PUBLIC']                                       = 'Categoria este publica';
$langFile['STATUS_CATEGORY_NONPUBLIC']                                    = 'Categoria este ascunsa';

// USER LIST
$langFile['USER_TEXT_USER']                                               = 'Utilizator';
$langFile['USER_TEXT_NOUSER']                                             = 'Nici un utilizator nu a fost creat.';
$langFile['USER_TEXT_CURRENTUSER']                                        = 'Acesta esti tu!';
$langFile['USER_TEXT_USERSONLINE']                                        = 'Acest utiizator este online::Ultima activitate';

$langFile['LOGO_TEXT']                                                    = 'Versiune';
$langFile['txt_logo_gotowebsite']                                         = 'Click aici pentru a merge pe site-ul tau.';

// CKEDITOR transport
$langFile['CKEDITOR_TITLE_LINKS']                                         = 'pagini feindura';
$langFile['CKEDITOR_TITLE_SNIPPETS']                                      = 'Code snippets';
$langFile['CKEDITOR_TEXT_SNIPPETS']                                       = 'Alegeti un code snippet pentru a-l plasa in pagina.';
$langFile['CKEDITOR_BUTTON_EDITSNIPPET']                                  = 'Editeaza code snippet';
$langFile['CKEDITOR_TITLE_PLUGINS']                                       = 'Plugin-uri';
$langFile['CKEDITOR_BUTTON_EDITPLUGIN']                                   = 'Editeaza plugin';

$langFile['CKEDITOR_TEXT_PLUGINS']                                        = 'Alege un plugin pentru a-l plasa in pagina.';

// -> BUTTON TEXTS

// MAIN MENU
$langFile['BUTTON_DASHBOARD']                                             = 'Tablou de bord';
$langFile['BUTTON_PAGES']                                                 = 'Pagini';
$langFile['BUTTON_ADDONS']                                                = 'Add-on-uri';
$langFile['BUTTON_WEBSITESETTINGS']                                       = 'Setare Website';
$langFile['BUTTON_SEARCH']                                                = 'Cauta Pagini';

// ADMIN MENU
$langFile['HEADER_TITLE_ADMINMENU']                                       = 'Administrare';
$langFile['BUTTON_ADMINSETUP']                                            = 'Setari Administrator';
$langFile['BUTTON_PAGESETUP']                                             = 'Setari Pagini';
$langFile['BUTTON_STATISTICSETUP']                                        = 'Setari Statistici';
$langFile['BUTTON_USERSETUP']                                             = 'Utilizatori';
$langFile['BUTTON_BACKUP']                                                = 'Backup-uri';

// SUB MENU/FOOTER
$langFile['BUTTON_FILEMANAGER']                                           = 'Manager fisiere';
$langFile['BUTTON_TOOLTIP_FILEMANAGER']                                   = 'Management pentru fisiere si imagini';
$langFile['BUTTON_CREATEPAGE']                                            = 'Pagina Noua';
$langFile['BUTTON_TOOLTIP_CREATEPAGE']                                    = 'Creaza o pagina noua';
$langFile['BUTTON_DELETEPAGE']                                            = 'Sterge Pagina';
$langFile['BUTTON_TOOLTIP_DELETEPAGE']                                    = 'Sterge aceasta pagina';
$langFile['BUTTON_FRONTENDEDITPAGE']                                      = 'Editare in frontend';
$langFile['BUTTON_TOOLTIP_FRONTENDEDITPAGE']                              = 'Editeaza aceasta pgania direct din site';
$langFile['BUTTON_THUMBNAIL_UPLOAD']                                      = 'Incarca thumbnail';
$langFile['BUTTON_TOOLTIP_THUMBNAIL_UPLOAD']                              = 'Incarca un thumbnail pentru aceasta pagina';
$langFile['BUTTON_THUMBNAIL_DELETE']                                      = 'Sterge thumbnail';
$langFile['BUTTON_TOOLTIP_THUMBNAIL_DELETE']                              = 'Sterge acest thumbnail pentru aceasta pagina';
$langFile['BUTTON_WEBSITELANGUAGE_ADD']                                   = 'Adauga Limba';
$langFile['BUTTON_TOOLTIP_WEBSITELANGUAGE_ADD']                           = 'Adauga o limba acestei pagini';
$langFile['BUTTON_WEBSITELANGUAGE_DELETE']                                = 'Sterge Limba';
$langFile['BUTTON_TOOLTIP_WEBSITELANGUAGE_DELETE']                        = 'Sterge limba &quot;%s&quot; pentru aceasta pagina';
$langFile['BUTTON_SHOWINMENU']                                            = 'Arata in meniu';
$langFile['BUTTON_HIDEINMENU']                                            = 'Ascunde din meniu';
$langFile['BUTTON_TOOLTIP_SHOWHIDEINMENU']                                = 'Determina daca pagina este afisata in meniu sau nu.';

// OTHER BUTTONS
$langFile['BUTTON_UP']                                                    = 'Sus';
$langFile['BUTTON_INFO']                                                  = 'Info';
$langFile['BUTTON_EDIT']                                                  = 'Editeaza';
$langFile['BUTTON_RESET']                                                 = 'Restaureaza';
$langFile['BUTTON_OK']                                                    = 'OK';

// -> GENERAL ERROR TEXTS
$langFile['ERROR_SAVE_SETTINGS']                                          = '<b>Setarile nu pot fi salvate</b>';
$langFile['ERROR_SAVE_FILE']                                              = '<br><br>Verificati permisiunile de scriere-citire ale fisierelor: ';

$langFile['ERROR_READ_FOLDER_PART1']                                      = '<br><br>Verificati permisiunile de citire ale &quot;';
$langFile['ERROR_SAVE_FOLDER_PART1']                                      = '<br><br>Verificati permisiunile de scriere ale &quot;';

$langFile['ERROR_FOLDER_PART2']                                           = '&quot; Foldere, subfoldere si fisiere.';

// -> WARNINGS
$langFile['WARNING_TITLE_STARTPAGE']                                      = 'Pagina de start nu a fost setata!';
$langFile['WARNING_TEXT_STARTPAGE']                                       = 'Seteaza o pagina ca pagina de start.<br>Du-te la <a href="?site=pages">'.$langFile['BUTTON_PAGES'].'</a> si da click pe <span class="icons startpage"></span> icon-ul paginii dorite.';

$langFile['WARNING_TITLE_DOCUMENTROOT']                                   = 'Radacina documentului tau nu poate fi rezolvat automat!';
$langFile['WARNING_TEXT_DOCUMENTROOT']                                    = 'Pentru <span class="feinduraInline">fein<em>dura</em></span> pentru a funcționa corect, trebuie să setați manual DocumentRoot în <a href="?site=adminSetup#adminSettings">setari administrator</a>.';

$langFile['WARNING_TITLE_BASEPATH']                                       = '<span class="feinduraInline">fein<em>dura</em></span> nu este configurat!';
$langFile['WARNING_TEXT_BASEPATH']                                        = '<i>Calea de baza</i> a CMS-ului nu se potriveste cu cea din setarile de administrare.<br>Please go to the <a href="?site=adminSetup#adminSettings">setari administrare</a> si configureaza <span class="feinduraInline">fein<em>dura</em></span> CMS.';

$langFile['WARNING_TITLE_JAVASCRIPT']                                     = 'Activati Javascript';
$langFile['WARNING_TEXT_JAVASCRIPT']                                      = '<strong>Pentru a utiliza deplin <span class="feinduraInline">fein<em>dura</em></span>, trebuie sa activati  Javascript!</strong>';

$langFile['WARNING_TITLE_UNTITLEDCATEGORIES']                             = 'Numele categoriilor lipseste';

$langFile['DASHBOARD_TITLE_IEWARNING']                                    = '<span class="feinduraInline">fein<em>dura</em></span> nu est facut pentru versiuni vechi de Internet Explorer';
$langFile['DASHBOARD_TEXT_IEWARNING']                                     = 'Pentru o utilizare completa a  <span class="feinduraInline">fein<em>dura</em></span> CMS iti trebuie cel putin Internet Explorer 9.<br><br>Instalati o versiune mai noua a Internet Explorer,<br> sau instalati <a href="http://www.google.com/chromeframe" target="_blank">Google Chrome Frame Plugin</a> for Internet Explorer,<br>sau descarcati si instalati <a href="http://www.mozilla.org/firefox/">Firefox</a> or <a href="http://www.google.com/chrome/">Chrome</a>.';

$langFile['GENERAL_TEXT_CURRENTLYEDITED']                                 = 'Pagina este in acest moment editata...';

// MESSAGES
$langFile['MESSAGE_TEXT_CHANGEDSTATUS']                                   = 'Statusul a fost schimbat cu succes.';
$langFile['MESSAGE_TEXT_CHANGEDSHOWINMENU']                               = 'Statusul meniului a fost schimbat cu succes.';


/*
* leftSidebar.loader.php
*/

// ---------- QUICKMENU

$langFile['SIDEBARMENU_TITLE_CATEGORIES']                                 = 'Categorii';
$langFile['SIDEBARMENU_TITLE_PAGES']                                      = 'Pagini din';

/*
* dashboard.php
*/

// ---------- DASHBOARD
$langFile['DASHBOARD_TITLE_USERINFO']                                     = 'Informatii utilizator';

$langFile['DASHBOARD_TITLE_WELCOME']                                      = 'Bine ai venit la  <span class="feinduraInline">fein<em>dura</em></span>,<br>CMS-ul site-ului tau';

$langFile['DASHBOARD_TITLE_STATISTICS']                                   = 'Statistici - Website';

$langFile['DASHBOARD_TITLE_USER']                                         = 'Utilizatori';
$langFile['DASHBOARD_TITLE_ACTIVITY']                                     = 'Activitati';
$langFile['DASHBOARD_TEXT_ACTIVITY_NONE']                                 = 'nimic';

$langFile['DASHBOARD_TITLE_STATISTICS_MOSTVISITED']                       = 'cele mai vizitate pagini';
$langFile['DASHBOARD_TITLE_STATISTICS_LASTVISITED']                       = 'ultima pagina vizitata';
$langFile['DASHBOARD_TITLE_STATISTICS_LASTEDITED']                        = 'ultima pagina editata';
$langFile['DASHBOARD_TITLE_STATISTICS_LONGESTVIEWED']                     = 'pagina cu cea mai lunga vizualizare';

$langFile['DASHBOARD_TITLE_REFERER']                                      = 'Vizitatorii au venit din';

/*
* listPages.php
*/

// ---------- PAGES SORTABLE LIST
$langFile['SORTABLEPAGELIST_h1']                                          = 'Continutul website-ului tau';
$langFile['SORTABLEPAGELIST_headText1']                                   = 'Filtrare';
$langFile['SORTABLEPAGELIST_headText3']                                   = 'Vizitatori';
$langFile['SORTABLEPAGELIST_headText4']                                   = 'Status';
$langFile['SORTABLEPAGELIST_headText5']                                   = 'Functii';

$langFile['SORTABLEPAGELIST_TIP_PAGEDATE']                                = 'Data paginii';
$langFile['SORTABLEPAGELIST_TIP_LASTEDIT']                                = 'Ultima editata';
$langFile['SORTABLEPAGELIST_TIP_TAGS']                                    = 'Tags';
$langFile['SORTABLEPAGELIST_TIP_LOCALIZATION']                            = 'Limbii';

$langFile['SORTABLEPAGELIST_TIP_SORTALPHABETICAL']                        = 'sortare alfabetica';
$langFile['SORTABLEPAGELIST_TIP_SORTBYPAGEDATE']                          = 'sortare dupa data paginii';

$langFile['SORTABLEPAGELIST_functions_editPage']                          = 'Editeaza pagina';

$langFile['SORTABLEPAGELIST_TIP_CHANGESTATUS']                            = 'Click aici pentru a schimba statusul.';

$langFile['SORTABLEPAGELIST_TOOLTIP_LANGUAGEMISSING']                     = 'Limba lipseste';

$langFile['file_error_read']                                              = '<b>Nu pot citi pagina.</b>'.$langFile['ERROR_READ_FOLDER_PART1'].'%spages/'.$langFile['ERROR_FOLDER_PART2'];
$langFile['SORTABLEPAGELIST_setStartPage_error_save']                     .= $langFile['ERROR_SAVE_FILE'].' &quot;%sconfig/website.config.php&quot;'; // also in en.shared.php
$langFile['SORTABLEPAGELIST_changeStatusPage_error_save']                 = '<b>Nu pot schimba statusul paginii.</b>'.$langFile['ERROR_SAVE_FOLDER_PART1'].'%spages/'.$langFile['ERROR_FOLDER_PART2'];
$langFile['SORTABLEPAGELIST_changeStatusCategory_error_save']             = '<b>Nu pot schimba statusul categoriei.</b>'.$langFile['ERROR_SAVE_FOLDER_PART1'].'%spages/'.$langFile['ERROR_FOLDER_PART2'];

$langFile['SORTABLEPAGELIST_info']                                        = 'Poti schimba  <b>aranjamentul</b> paginilor si le poti muta dintr-o categorie in alta prin <b>Drag and Drop</b>.';
$langFile['SORTABLEPAGELIST_save']                                        = 'Salveaza noua sortare ...';
$langFile['SORTABLEPAGELIST_save_finished']                               = 'Sortarea noua a fost salvata cu succes!';
$langFile['SORTABLEPAGELIST_error_save']                                  = '<b>Nu pot salva pagina.</b>'.$langFile['ERROR_SAVE_FOLDER_PART1'].'%spages/'.$langFile['ERROR_FOLDER_PART2'];
$langFile['SORTABLEPAGELIST_error_read']                                  = '<b>Pagina nu poate fi citita.</b>'.$langFile['ERROR_READ_FOLDER_PART1'].'%spages/'.$langFile['ERROR_FOLDER_PART2'];
$langFile['SORTABLEPAGELIST_error_move']                                  = '<b>Nu pot muta pagina intr-a categorie noua.</b>'.$langFile['ERROR_SAVE_FOLDER_PART1'].'%spages/'.$langFile['ERROR_FOLDER_PART2'];
$langFile['SORTABLEPAGELIST_categoryEmpty']                               = 'Nici o pagina disponibila';
$langFile['SORTABLEPAGELIST_TIP_DRATOREARRANGE']                          = 'Drag pentru rearanjare.';

$langFile['SORTABLEPAGELIST_TIP_SUBCATEGORYOFPAGES_SINGULAR']             = 'Subcategorie a paginii:';
$langFile['SORTABLEPAGELIST_TIP_SUBCATEGORYOFPAGES_PLURAL']               = 'Subcategorie a paginilor:';


// ---------- FORMULAR
$langFile['FORM_BUTTON_SUBMIT']                                           = 'Salveaza';
$langFile['FORM_BUTTON_CANCEL']                                           = 'Reseteaza toate intrarile';


/*
* adminSetup.php
*/

// ---------- ADMIN SETUP (on toolTips tooTips.js converts the "[" and "]" tags in the title attribute to "<" ">")
$langFile['ADMINSETUP_TEXT_VERSION']                                      = 'versiune <span class="feinduraInline">fein<em>dura</em></span> ';
$langFile['ADMINSETUP_TEXT_PHPVERSION']                                   = 'versiune PHP';
$langFile['ADMINSETUP_TITLE_DOCUMENTROOT']                                = ' Radacina document';

$langFile['ADMINSETUP_TITLE_ERROR']                                       = 'Erori aparute';
$langFile['ADMINSETUP_TOOLTIP_WRITEACCESSERROR']                          = 'Folderele si fisierele au nevoie de setarea permisiuni in %o.';

$langFile['ADMINSETUP_TEXT_WRITEACCESSERROR']                             = 'nu se poate scrie/salva';
$langFile['ADMINSETUP_TEXT_ISFOLDERERROR']                                = 'nu este un director';

// ---------- general Settings
$langFile['ADMINSETUP_GENERAL_error_save']                                = $langFile['ERROR_SAVE_SETTINGS'].$langFile['ERROR_SAVE_FILE'].'%sconfig/admin.config.php';

$langFile['ADMINSETUP_GENERAL_h1']                                        = 'Setari de baza';

$langFile['ADMINSETUP_GENERAL_TEXT_DOCUMENTROOT']                         = 'DocumentRoot';
$langFile['ADMINSETUP_GENERAL_TOOLTIP_DOCUMENTROOT']                      = 'Vă rugăm să introduceți în document root manual.[br][span class=hint]d.e. &quot;/server/user/htdocs&quot;[/span]';
$langFile['ADMINSETUP_GENERAL_field1']                                    = 'Website URL';
$langFile['ADMINSETUP_GENERAL_field1_tip']                                = 'URL site-ului va fi adaugat automat.';
$langFile['ADMINSETUP_GENERAL_field1_inputTip']                           = 'URL va fi adaugat automat';
$langFile['ADMINSETUP_GENERAL_field1_inputWarningText']                   = 'Salveaza setarile!';
$langFile['ADMINSETUP_GENERAL_field2']                                    = 'calea feindura';
$langFile['ADMINSETUP_GENERAL_field2_tip']                                = 'Calea de baza va fi determinata automat si salvata, la prima salvare a setarilor.';
$langFile['ADMINSETUP_GENERAL_field2_inputTip']                           = 'Calea va fi adaugata automat';
$langFile['ADMINSETUP_GENERAL_field2_inputWarningText']                   = 'Salveaza setarile!';
$langFile['ADMINSETUP_GENERAL_field8']                                    = 'Cale website';
$langFile['ADMINSETUP_GENERAL_field8_tip']                                = 'Calea [strong]absoluta[/strong] unde este situat website-ul.[br][br][span class=hint] Poate de asemenea sa contina nume de fisier e.g &quot;/website/index.php&quot;[/span]';
$langFile['ADMINSETUP_GENERAL_editfiles_additonal']                       = '[br][br]Aceste fisiere pot fi editate mai jos sau in setarile site-ului (daca au fost activate in setarile utilizator).[br][br]';
$langFile['ADMINSETUP_GENERAL_field5']                                    = 'Calea pentru fisierele site-ului';
$langFile['ADMINSETUP_GENERAL_field5_tip']                                = 'Aici puteti adauga calea catre fisierele specifice ale site-ului, ce ar trebui sa fie editabile in[span class=feinduraInline]fein[em]dura[/em][/span].'.$langFile['ADMINSETUP_GENERAL_editfiles_additonal'];
$langFile['ADMINSETUP_GENERAL_field6']                                    = 'Cale pentru stylesheets';
$langFile['ADMINSETUP_GENERAL_field6_tip']                                = 'Aici poti aduga calea pentru fisierul stylesheet, ce ar trebui sa fie editabil in [span class=feinduraInline]fein[em]dura[/em][/span].'.$langFile['ADMINSETUP_GENERAL_editfiles_additonal'];
$langFile['ADMINSETUP_GENERAL_TEXT_PERMISSIONS']                          = 'Permisiune pentru foldere si fisiere';
$langFile['ADMINSETUP_GENERAL_TIP_PERMISSIONS']                           = 'Toate fisierele si folderele create de [span class=feinduraInline]fein[em]dura[/em][/span]  vor primi aceasta permisiune.';
$langFile['ADMINSETUP_TEXT_VARNAMEPAGE']                                  = 'Nume URL pentru pagina';
$langFile['ADMINSETUP_TEXT_VARNAMECATEGORY']                              = 'Nume URL pentru categorie';
$langFile['ADMINSETUP_TEXT_VARNAMEMODUL']                                 = 'Nume URL modul';
$langFile['ADMINSETUP_TIP_VARNAME']                                       = 'Numele ce va fi folosit in URL pentru a link-a paginile.';
$langFile['ADMINSETUP_TIP_EMPTYVARNAME']                                  = 'Daca acest camp este gol, va fi folosit numele standard: ';
$langFile['ADMINSETUP_TEXT_TIMEZONE']                                     = 'Fus orar';
$langFile['ADMINSETUP_TIP_TIMEZONE']                                      = 'Va fi folosit/a numai de adminisrarea [span class=feinduraInline]fein[em]dura[/em][/span].';
$langFile['ADMINSETUP_GENERAL_PRETTYURL']                               = 'Format URL';
$langFile['ADMINSETUP_GENERAL_PRETTYURL_true']                          = 'Pretty URLs';
$langFile['ADMINSETUP_GENERAL_PRETTYURL_true_example']                  = '/%s/example-category/example-page';
$langFile['ADMINSETUP_GENERAL_PRETTYURL_false']                         = 'URL-uri cu variabile';
$langFile['ADMINSETUP_GENERAL_PRETTYURL_false_example']                 = 'index.php?%s=1&%s=1';
$langFile['ADMINSETUP_GENERAL_PRETTYURL_tip']                           = 'Format URL, ce va fi folosit pentru link-ul paginilor.[br][br]Pretty URL functioneaza numai daca [strong]Apache Server[/strong] [strong]mod_rewrite[/strong] este disponibil.';
$langFile['ADMINSETUP_GENERAL_PRETTYURL_warning']                       = 'ATENTIONARE!::[span class=red]Daca apare o eroare in utilizarea Pretty URLs, trebuie sa stergi [strong]fisierul .htaccess [/strong] din radacina serverului.[/span][br][br](In unele programe FTP trebuie setat sa arate toat fisierele ascunse, pentru a vedea fisierul .htaccess)';

// ---------- Pretty url ERRORs
$langFile['ADMINSETUP_GENERAL_PRETTYURL_error_save']                    = '<b>Pretty URL</b> nu pot fi activate'.$langFile['ERROR_SAVE_FILE'].'/.htaccess';
$langFile['ADMINSETUP_GENERAL_PRETTYURL_error_modul']                   = '<b>Pretty URL</b> nu pot fi activate, deoarece modulul Apache module MOD_REWRITE nu a fost gasit';

// ---------- cache settings
$langFile['ADMINSETUP_TEXT_CACHE']                                        = 'Activeaza cache';
$langFile['ADMINSETUP_TIP_CACHE']                                         = 'Daca este activ, toate paginile vor intra in cache. Aces lucru poate imbunatatii viteza site-ului dar, poate duce la actualizare cu intarziere a continutului.[br][br][span class=hint] Cache-ul va fi actualizat la salvarea paginii.[/span]';
$langFile['ADMINSETUP_TEXT_CACHETIMEOUT']                                 = 'Cache timeout';
$langFile['ADMINSETUP_TIP_CACHETIMEOUT']                                  = 'Indica limita de timp dupa care cache-ul va fi actualizat.';
$langFile['ADMINSETUP_HINT_CACHETIMEOUT']                                 = 'ore';

// ---------- editor Settings
$langFile['adminSetup_editorSettings_h1']                                 = 'Setari HTML-Editor';
$langFile['ADMINSETUP_TEXT_EDITOR_HTMLLAWED']                             = 'Filtrare HTML (uses <a href="http://www.bioinformatics.org/phplabware/internal_utilities/htmLawed/" target="_blank">htmlLawed</a>)';
$langFile['ADMINSETUP_TIP_EDITOR_HTMLLAWED']                              = 'Filtrare HTML inainte de salvare. Poate crea probleme in cod HTML cu mult Javascript.';
$langFile['ADMINSETUP_TEXT_EDITOR_SAFEHTML']                              = 'Safe HTML (<a href="http://www.bioinformatics.org/phplabware/internal_utilities/htmLawed/htmLawed_README.htm#s3.6" target="_blank">details</a>)';
$langFile['ADMINSETUP_TIP_EDITOR_SAFEHTML']                               = 'HTML-ul  va fi filtrat folosind cele mai sigure setari.Asta inseamna ca, de exemplu &lt;applet&gt;,&lt;embed&gt;,&lt;embed&gt;,&lt;object &gt; and &lt;script&gt; tags nu sunt permise.';
$langFile['ADMINSETUP_TEXT_EDITOR_EDITORSTYLES']                          = 'activare Style-Selection';
$langFile['ADMINSETUP_TIP_EDITOR_EDITORSTYLES']                           = 'Styles-Selection permite utilizarea de elemente HTML custom in HTML-Editor.[br][br][span class=hint]Daca aceasta optiune este acivata poti edita/crea elemente HTML mai jos.[/span]';
$langFile['ADMINSETUP_TEXT_EDITOR_SNIPPETS']                              = 'activare code snippets';
$langFile['ADMINSETUP_TIP_EDITOR_SNIPPETS']                               = 'Face posibila amplasarea de code snippets in pagini.[br]Click pe icon-ul din HTML-Editor: [img class=icons src=library/thirdparty/ckeditor/plugins/feinduraSnippets/feinduraSnippetsIcon.png][br][br][span class=hint] Daca aceasta optiune este activata poti edita/crea code snippets mai jos.[/span]';
$langFile['adminSetup_editorSettings_field1']                             = 'ENTER-Key mod';
$langFile['adminSetup_editorSettings_field1_hint']                        = 'SHIFT + ENTER genereaza &quot;%s&quot;';
$langFile['adminSetup_editorSettings_field1_tip']                         = 'Seturi pe care  HTML-Tag le va adauga la apasarea ENTER in HTML-Editor.[br][br][span class=hint]'.$langFile['adminSetup_editorSettings_field1_hint'].'.[/span]';
$langFile['adminSetup_editorSettings_field3_inputTip']                    = 'Daca este gol nu va fi folosit nici un Id-attribute.';
$langFile['adminSetup_editorSettings_field4_inputTip']                    = 'Daca este gol nu va fi folosit nici o Class-attribute .';

// THUMBNAILS Settings
$langFile['adminSetup_thumbnailSettings_h1']                              = 'Setari-Thumbnail-Pagina';

// ---------- styleFile Settings
$langFile['adminSetup_styleFileSettings_h1']                              = 'Editeaza Styles-Selection din HTML-Editor';
$langFile['adminSetup_styleFileSettings_error_save']                      = '<b>Fisierul &quot;EditorStyles.js&quot; nu poate fi salvat.</b>'.$langFile['ERROR_SAVE_FILE'];

// ---------- editFiles Settings
$langFile['EDITFILESSETTINGS_TITLE_STYLESHEETS']                          = 'Editeaza fisierul stylesheet';
$langFile['EDITFILESSETTINGS_TITLE_WEBSITEFILES']                         = 'Editeaza fisierele website-ului';
$langFile['EDITFILESSETTINGS_TITLE_SNIPPETS']                             = 'Editeaza code snippets';
$langFile['EDITFILESSETTINGS_TEXT_NODIR']                                 = 'nu este un director valid!';
$langFile['EDITFILESSETTINGS_TEXT_CHOOSEFILE']                            = 'Alege un fisier';
$langFile['EDITFILESSETTINGS_TEXT_CREATEFILE']                            = 'Creaza un fisier nou';
$langFile['EDITFILESSETTINGS_TIP_CREATEFILE']                             = 'Daca scri un nume de fisier aici, un fisier nou creat si[strong] fisierele selectate acum nu vor fi salvate![/strong]';
$langFile['EDITFILESSETTINGS_TEXT_NOFILE']                                = 'Nici un fisier disponibil';

$langFile['EDITFILESSETTINGS_TEXT_DELETEFILE']                            = 'Sterge aces fisier';
$langFile['EDITFILESSETTINGS_TEXT_DELETEFILE_QUESTION']                   = 'Sigur stergi acest fisier %s?';

$langFile['EDITFILESSETTINGS_ERROR_SAVEFILE']                             = '<b>Fisierul nu poate fi salvat.</b>'.$langFile['ERROR_SAVE_FILE'];
$langFile['EDITFILESSETTINGS_ERROR_DELETEFILE']                           = '<b>Fisierul nu poate fi sters.</b>'.$langFile['ERROR_SAVE_FILE'];

/*
* pageSetup.php
*/

// ---------- CATEGORY SETUP (on toolTips tooTips.js converts the "[" and "]" tags in the title attribute to "<" ">")
$langFile['PAGESETUP_PAGES_TIP_TAG']                                      = 'Tag-urile pot fi folosite pentru a crea legaturi intre pagini ( depinzand si de programarea site-ului)';

// ---------- page settings
$langFile['PAGESETUP_PAGES_TITLE_NONCATEGORYPAGES']                       = 'Pagini fara categorie';
$langFile['PAGESETUP_PAGES_TEXT_CREATEPAGES']                             = 'Creaza/sterge pagini';
$langFile['PAGESETUP_PAGES_TIP_CREATEPAGES']                              = 'Specifica daca utilizatorul poate crea si sterge pagini fara categorie.';
$langFile['PAGESETUP_PAGES_TEXT_UPLOADTHUMBNAILS']                        = 'Incarca thumbnail-uri';
$langFile['PAGESETUP_PAGES_TIP_UPLOADTHUMBNAILS']                         = 'Specifica daca utilizatorul poate  incarca thumbnail-uri pentru pagini fara categorie.';
$langFile['PAGESETUP_PAGES_TEXT_EDITTAGS']                                = 'Editeaza tag-uri';
$langFile['PAGESETUP_PAGES_TIP_EDITTAGS']                                 = 'Specifica daca utilizatorul poate edita tag-uri in pagini fara categorie.[br]'.$langFile['PAGESETUP_PAGES_TIP_TAG'];
$langFile['PAGESETUP_PAGES_TEXT_ACTIVATEPLUGINS']                         = 'Activeaza plugins';
$langFile['PAGESETUP_PAGES_TIP_ACTIVATEPLUGINS']                          = 'Specifica daca utilizatorul poate utiliza plugin-uri in pagini fara categorie.';

// ---------- category settings
$langFile['PAGESETUP_CATEGORY_TITLE_CATEGORIES']                          = 'Management categorii';
$langFile['PAGESETUP_CATEGORY_TEXT_CATEGORYNAME']                         = 'Nume';

$langFile['PAGESETUP_CATEGORY_TEXT_CREATECATEGORY']                       = 'Creaza categorie noua';
$langFile['PAGESETUP_CATEGORY_TEXT_CREATECATEGORY_CREATED']               = 'Categorie noua creata';
$langFile['PAGESETUP_CATEGORY_TEXT_CREATECATEGORY_UNNAMED']               = 'Categorie fara titlu';

$langFile['PAGESETUP_CATEGORY_TEXT_DELETECATEGORY']                       = 'Sterge categorie';
$langFile['PAGESETUP_CATEGORY_TEXT_DELETECATEGORY_WARNING']               = 'ATENTIONARE: Se vor sterge si paginile din aceasta categorie';
$langFile['PAGESETUP_CATEGORY_TEXT_DELETECATEGORY_DELETED']               = 'Categorie stearsa';
$langFile['PAGESETUP_CATEGORY_TEXT_DELETECATEGORY_QUESTION_START']        = 'Sterge categorie'; // Kategorie "test" löschen?
$langFile['PAGESETUP_CATEGORY_TEXT_DELETECATEGORY_QUESTION_END']          = '?';

$langFile['PAGESETUP_CATEGORY_TEXT_MOVECATEGORY_MOVED']                   = 'Category mutata';
$langFile['PAGESETUP_CATEGORY_TIP_MOVECATEGORY_UP']                       = 'Muta categoria mai sus';
$langFile['PAGESETUP_CATEGORY_TIP_MOVECATEGORY_DOWN']                     = 'Muta categoria mai jos';

$langFile['PAGESETUP_CATEGORY_ERROR_CREATECATEGORY']                      = '<b>Nu pot crea o categorie noua.</b>'.$langFile['ERROR_SAVE_FOLDER_PART1'].'%sconfig/'.$langFile['ERROR_FOLDER_PART2'];
$langFile['PAGESETUP_CATEGORY_ERROR_CREATEDIR']                           = '<b>Nu pot crea un director pentru categoria noua.</b>'.$langFile['ERROR_SAVE_FOLDER_PART1'].'%spages/'.'&quot; Ordners.';
$langFile['PAGESETUP_CATEGORY_ERROR_DELETECATEGORY']                      = '<b>Nu pot sterge categoria</b>'.$langFile['ERROR_SAVE_FILE'].'%sconfig/category.config.php';
$langFile['PAGESETUP_CATEGORY_ERROR_DELETEDIR']                           = '<b>Nu pot sterge directorul categoriei.</b>'.$langFile['ERROR_SAVE_FOLDER_PART1'].'%spages/'.$langFile['ERROR_FOLDER_PART2'];
$langFile['PAGESETUP_CATEGORY_ERROR_SAVE']                                = $langFile['ERROR_SAVE_SETTINGS'].$langFile['ERROR_SAVE_FILE'].'%sconfig/category.config.php';


$langFile['PAGESETUP_CATEGORY_TITLE_ADVANCEDSETTINGS']                    = 'Setari avansate';
$langFile['PAGESETUP_CATEGORY_HINT_ADVANCEDSETTINGS']                     = 'Daca folositi aceste setari ele vor suprascrie setarile thumbnail de mai sus '.$langFile['adminSetup_editorSettings_h1'].' in <a href="?site=adminSetup">setari administrare</a>.';

$langFile['PAGESETUP_CATEGORY_TIP_STYLESHEETS_EMPTY']                     = 'Daca toate campurile sunt goale, atunci setarile stylesheet din '.$langFile['adminSetup_editorSettings_h1'].' vor fi folosite.';

$langFile['PAGESETUP_CATEGORY_TEXT_CATEGORYSTATUS']                       = 'Status-ul categoriei';
$langFile['PAGESETUP_CATEGORY_TIP_CATEGORYSTATUS']                        = 'Specifica daca categoria este vizibila pe website.';
$langFile['PAGESETUP_CATEGORY_TEXT_CREATEPAGES']                          = 'Creaza/Sterge pagini';
$langFile['PAGESETUP_CATEGORY_TIP_CREATEPAGES']                           = 'Specifica daca utilizatorul poate crea si sterge pagini in aceasta categorie.';
$langFile['PAGESETUP_CATEGORY_TEXT_UPLOADTHUMBNAILS']                     = 'Incarca Thumbnail-uri';
$langFile['PAGESETUP_CATEGORY_TIP_UPLOADTHUMBNAILS']                      = 'Specifica daca utilizatorul poate incarca thumbnail-uri pentru pagini in aceasta categorie.';
$langFile['PAGESETUP_CATEGORY_TEXT_EDITTAGS']                             = 'Editeaza tag-uri';
$langFile['PAGESETUP_CATEGORY_TIP_EDITTAGS']                              = 'Specifica daca utilizatorul poate edita tag-uri pentru pagini in aceasta categorie.[br]'.$langFile['PAGESETUP_PAGES_TIP_TAG'];
$langFile['PAGESETUP_CATEGORY_TEXT_ACTIVATEPLUGINS']                      = 'Activeaza plugin-uri';
$langFile['PAGESETUP_CATEGORY_TIP_ACTIVATEPLUGINS']                       = 'Specifica daca utilizatorul poate utiliza plugin-uri pentru pagini in aceasta categorie.';

$langFile['PAGESETUP_TEXT_EDITPAGEDATE']                                  = 'Editeaza data paginii';
$langFile['PAGESETUP_TIP_EDITPAGEDATE']                                   = 'Data paginii poate fi utilizata pentru sortarea paginilor dupa data';
$langFile['PAGESETUP_TEXT_PAGEDATERANGE']                                 = 'ca interval';

$langFile['PAGESETUP_TEXT_FEEDS']                                         = 'Activeaza feed-uri';
$langFile['PAGESETUP_TIP_FEEDS']                                          = 'Activeaza RSS 2.0 si Atom Feed pentru pagini fara categorie.';
$langFile['PAGESETUP_CATEGORY_TIP_FEEDS']                                 = 'Activeaza RSS 2.0 si Atom Feed pentru pagini in aceasta categorie.';

$langFile['PAGESETUP_TEXT_SUBCATEGORY']                                   = 'Editeaza subcategorii';
$langFile['PAGESETUP_TIP_SUBCATEGORY']                                    = 'Permite alegerea unei subcategorii pentru fiecare pagina.';

$langFile['PAGESETUP_TIP_SORTBYPAGEDATE']                                 = 'Sorteaza paginile dupa data';
$langFile['PAGESETUP_TIP_SORTBYDATE']                                     = 'Paginile cu o data mai apropiata vor aparea [strong]primele[/strong].[br][br][span class=hint]Dezactivati sortarea manuala.[/span]';

$langFile['PAGESETUP_TEXT_SORTMANUALLY']                                  = 'Sorteaza paginile manual';
$langFile['PAGESETUP_TIP_SORTMANUALLY']                                   = 'Paginile nou create vor fi afisate [strong]primele[/strong].';

$langFile['PAGESETUP_TEXT_SORTALPHABETICAL']                              = 'Sorteaza paginile alfabetic';
$langFile['PAGESETUP_TIP_SORTALPHABETICAL']                               = '[span class=hint]Dezactivati sortarea manuala.[/span]';

$langFile['PAGESETUP_TEXT_SORTREVERSE']                                   = 'inverseaza ordinea de sortare';
$langFile['PAGESETUP_TIP_SORTREVERSE']                                    = 'Inverseaza ordinea de sortare pentru pagini.';


/*
* websiteSetup.php
*/

// ---------- WEBSITE SETUP (on toolTips tooTips.js converts the "[" and "]" tags in the tittle attribute to "<" ">")
$langFile['websiteSetup_websiteConfig_error_save']                        = $langFile['ERROR_SAVE_SETTINGS'].$langFile['ERROR_SAVE_FILE'].'%sconfig/website.config.php';

$langFile['websiteSetup_websiteConfig_h1']                                = 'Setari Website';
$langFile['websiteSetup_websiteConfig_field1']                            = 'Titlu website';
$langFile['websiteSetup_websiteConfig_field1_tip']                        = 'Titlul website-ului afisat in bara browser-ului.';
$langFile['websiteSetup_websiteConfig_field2']                            = 'Autor';
$langFile['websiteSetup_websiteConfig_field2_tip']                        = 'Numele celui care a publicat site-ul.';
$langFile['websiteSetup_websiteConfig_field3']                            = 'Copyright';
$langFile['websiteSetup_websiteConfig_field3_tip']                        = 'Detinatoriul drepturilor de copyright pentru website.';
$langFile['websiteSetup_websiteConfig_field4']                            = 'Cuvinte cheie';
$langFile['websiteSetup_websiteConfig_field4_tip']                        = 'Cele mai multe motoare de cautare cauta cuvintele cheie in text, oricum trebuie trecute cateva cuvinte cheie si aici, ce vor fi afisate in <meta> tag-urile paginii.';
$langFile['websiteSetup_websiteConfig_field4_inputTip']                   = 'Cuvintele cheie trebuie separate de &quot;,&quot;::'.$langFile['TEXT_EXAMPLE'].':[br]stichwort1,stichwort2,etc';
$langFile['websiteSetup_websiteConfig_field5']                            = 'Descriere website';
$langFile['websiteSetup_websiteConfig_field5_tip']                        = 'O scurta descriere pentru uzul motoarelor de cautare, daca cuvintele de cautare au fost gasite in URL si nu in continut.';
$langFile['websiteSetup_websiteConfig_field5_inputTip']                   = 'Un text scurt, nu mai lung de trei randuri.';

$langFile['WEBSITESETUP_TITLE_PAGESETTINGS']                              = 'Setari Avansate Website';
$langFile['WEBSITESETUP_TEXT_MAINTENANCE']                                = 'Dezactiveaza Website';
$langFile['WEBSITESETUP_TIP_MAINTENANCE']                                 = 'Afiseaza un mesaj in locul site-ului, ce transmite ca site-ul se afla in mentenanta.';
$langFile['WEBSITESETUP_TEXT_SITEMAPFILES']                               = 'Creaza Sitemap-Files (<a href="http://www.sitemaps.org/" target="_blank">Detalii</a>)';
$langFile['WEBSITESETUP_TIP_SITEMAPFILES']                                = 'Fisierele sitemap simplifica indexarea site-ului de catre motoarele de cautare.';
$langFile['WEBSITESETUP_TEXT_VISITORTIMEZONE']                            = 'Preia fusul orar al vizitatorului';
$langFile['WEBSITESETUP_TIP_VISITORTIMEZONE']                             = 'Incearca sa preia fusul orar al vizitatorului pentru a putea afisa masaje in functie de acesta.[br][br][span class=hint]Website-ul va fi reincarcat la prima vizita.[/br]';
$langFile['WEBSITESETUP_TEXT_MULTILANGUAGEWEBSITE']                       = 'Website multilingv';
$langFile['WEBSITESETUP_TEXT_MAINLANGUAGE']                               = 'Limba principala';
$langFile['WEBSITESETUP_TIP_MAINLANGUAGE']                                = 'Se va alege limba principla in mod automat, daca nu a fost selectata o alta limba.';
$langFile['WEBSITESETUP_TEXT_DATEFORMAT']                                 = 'Format data';
$langFile['WEBSITESETUP_TIP_DATEFORMAT']                                  = 'Va fi folosit pe website.';


/*
* statisticSetup.php
*/

// ---------- STATISITC SETUP (on toolTips tooTips.js converts the "[" and "]" tags in the tittle attribute to "<" ">")
$langFile['STATISTICSSETUP_ERROR_SAVE']                                   = $langFile['ERROR_SAVE_SETTINGS'].$langFile['ERROR_SAVE_FILE'].'%sconfig/statistic.config.php';

$langFile['STATISTICSSETUP_TITLE_STATISTICSSETTINGS']                     = 'Setari Statistici';
$langFile['STATISTICSSETUP_TEXT_REFERERNUMBER']                           = 'Numar de  <b>Referrer-URL-uri</b>';
$langFile['STATISTICSSETUP_TIP_REFERERNUMBER']                            = 'Specifica cate Referrer-URL-uri ([i]URLs ce au condus la acest site[/i]) vor fi salvate si afisate.';
$langFile['STATISTICSSETUP_TEXT_ACTIVITYNUMBER']                          = 'Numar de <b>Log-uri Activitate</b>';
$langFile['STATISTICSSETUP_TIP_ACTIVITYNUMBER']                           = 'Specifica cate Log-uri Activitate vor fi salvate si afisate.';


$langFile['statisticSetup_clearStatistic_h1']                             = 'Sterge statisticile';
$langFile['statisticSetup_clearStatistics_websiteStatistic']              = 'Statistici-Website';
$langFile['statisticSetup_clearStatistics_websiteStatistic_tip']          = '[strong]Contine[/strong][ul][li]numarul total de vizite[/li][li]numarul total de web-crawlers[/li][li]data primei vizite[/li][li]data ultimei vizite[/li][li]tip de Browser[/li][/ul]';
$langFile['statisticSetup_clearStatistics_pagesStatistic']                = 'Statistici Pagini';
$langFile['statisticSetup_clearStatistics_pagesStatistic_tip']            = '[strong]Contine[/strong][ul][li]numarul de pagini vizitate[/li][li]data primei vizite pe pagina[/li][li]data ultimei pagini vizitate[/li][li]cea mai scurta perioada pe pagina[/li][li]cea mai lunga perioada pe pagina[/li][li]Cuvinte cheie[/li][/ul]';
$langFile['statisticSetup_clearStatistics_pagesStaylengthStatistics']     = 'numai statisticile legate de durata vizitei';
$langFile['statisticSetup_clearStatistics_pagesStaylengthStatistics_tip'] = '';
$langFile['statisticSetup_clearStatistics_refererLog']                    = 'Referrer-URLs Log'; // engl.: referer
$langFile['statisticSetup_clearStatistics_refererLog_tip']                = 'Lista URL-urilor ce au condus spre acest website.';
$langFile['statisticSetup_clearStatistics_taskLog']                       = 'Log-uri acivitate';
$langFile['statisticSetup_clearStatistics_taskLog_tip']                   = 'Lista activitatilor.';

$langFile['statisticSetup_clearStatistics_question_h1']                   = 'Sigur vrei sa stergi aceste statistici?';

$langFile['statisticSetup_clearStatistic_pagesStatistics_error_read']     = 'Eroare la stergerea statisticilor paginii.'.$langFile['ERROR_SAVE_FOLDER_PART1'].'%sstatistics/pages/'.$langFile['ERROR_FOLDER_PART2'];

/*
* userSetup.php
*/

$langFile['USERSETUP_h1']                                                 = 'Management Utilizatori';
$langFile['USERSETUP_userSelection']                                      = 'Utilizatori';

$langFile['USERSETUP_createUser']                                         = 'Creaza utilizator nou';
$langFile['USERSETUP_createUser_created']                                 = 'Utilizator nou creat';
$langFile['USERSETUP_createUser_unnamed']                                 = 'Utilizator fara nume';

$langFile['USERSETUP_deleteUser']                                         = 'Sterge utilizator';
$langFile['USERSETUP_deleteUser_deleted']                                 = 'Utilizator sters';

$langFile['USERSETUP_username']                                           = 'Nume utilizator';
$langFile['USERSETUP_username_missing']                                   = 'Nu este setat nume utilizator inca.';
$langFile['USERSETUP_password']                                           = 'Parola';
$langFile['USERSETUP_password_change']                                    = 'schimba parola';
$langFile['USERSETUP_password_confirm']                                   = 'Confirma parola';
$langFile['USERSETUP_password_confirm_wrong']                             = 'Cele doua parole nu corespund.';
$langFile['USERSETUP_password_missing']                                   = 'Nu este setata o parola inca.';
$langFile['USERSETUP_password_success']                                   = 'Parola schimbata cu succes!';
$langFile['USERSETUP_email']                                              = 'E-Mail';
$langFile['USERSETUP_email_tip']                                          = 'Daca utilizatorul si-a uitat parola, o noua parola va fi trimisa pe e-mail.';

$langFile['USERSETUP_admin']                                              = 'Administrator';
$langFile['USERSETUP_admin_tip']                                          = 'Determina daca utilizatorul are drepturi de administrare.';

$langFile['USERSETUP_error_create']                                       = '<b> NU am putut crea un utilizator nou.</b>'.$langFile['ERROR_SAVE_FILE'].'%sconfig/user.config.php';
$langFile['USERSETUP_error_save']                                         = $langFile['ERROR_SAVE_SETTINGS'].$langFile['ERROR_SAVE_FILE'].'%sconfig/user.config.php';

// ---------- USER PERMISSION
$langFile['USERSETUP_USERPERMISSIONS_TITLE']                              = 'Drepturi utilizator';
$langFile['USERSETUP_USERPERMISSIONS_TEXT_ACTIVATEWEBSITESETTINGS']       = 'Editare setari Website';
$langFile['USERSETUP_USERPERMISSIONS_TEXT_EDITWEBSITEFILES']              = 'Editeaza fisierele website in <a href="index.php?site=websiteSetup">Setari Website</a>';
$langFile['USERSETUP_USERPERMISSIONS_TEXT_EDITSTYLESHEETS']               = 'Editeaza fisierele stylesheet in <a href="index.php?site=websiteSetup">Setari Website</a>';
$langFile['USERSETUP_USERPERMISSIONS_TEXT_EDITSNIPPETS']                  = 'Editeaza code snippets in <a href="index.php?site=websiteSetup">Setari Website</a>';
$langFile['USERSETUP_USERPERMISSIONS_TEXT_FILEMANAGER']                   = 'Activeaza manager de fisiere';
$langFile['USERSETUP_USERPERMISSIONS_TEXT_FRONTENDEDITING']               = 'Activeaza editare in frontend';

$langFile['USERSETUP_USERPERMISSIONS_TEXT_USERINFORMATION']               = '<strong>Informatii utilizator</strong> in <a href="?site=dashboard">'.$langFile['BUTTON_DASHBOARD'].'</a>';
$langFile['USERSETUP_USERPERMISSIONS_TIP_USERINFORMATION']                = 'Informatii utilizator::Acest text va fi afisat in  '.$langFile['BUTTON_DASHBOARD'].' pagina [span class=feinduraInline]fein[em]dura[/em][/span].';
$langFile['USERSETUP_USERPERMISSIONS_TIP_USERINFORMATION_NOINFO']         = 'Daca nu doresti sa afisezi informatii despre utilizator, lasa campul liber';

$langFile['USERSETUP_USERPERMISSIONS_TITLE_EDITABLECATEGORIES-PAGES']     = 'Selecteaza Categorii si Pagini ce vor putea fi editate de utilizator<br>(Daca nu este selectat nimic, atunci totul va putea fi editat)';
$langFile['USERSETUP_USERPERMISSIONS_TEXT_CLEARSELECTION']                = 'Sterge selectia';

/*
* editor.php
*/

// ---------- page info
$langFile['EDITOR_TITLE_CREATEPAGE']                                      = 'Creaza pagina noua';
$langFile['EDITOR_TITLE_ADDLANGUAGE']                                     = 'Adauga limba noua acestei pagini';
$langFile['EDITOR_pageinfo_lastsavedate']                                 = 'ultima editare';
$langFile['EDITOR_pageinfo_lastsaveauthor']                               = 'de';
$langFile['EDITOR_pageinfo_linktothispage']                               = 'Link catre aceasta pagina';
$langFile['EDITOR_pageinfo_id']                                           = 'ID Pagina';
$langFile['EDITOR_pageinfo_id_tip']                                       = 'Aceasta pagina va fi salvata sub acest ID pe server.';
$langFile['EDITOR_pageinfo_category']                                     = 'Categorii';
$langFile['EDITOR_pageinfo_category_noCategory']                          = 'fara categorie';

$langFile['EDITOR_TEXT_CHOOSETEMPLATE']                                   = 'Utilizeaza template';
$langFile['EDITOR_TEXT_TEMPALATECOPYADDITION']                            = 'copiaza';

$langFile['EDITOR_block_edited']                                          = 'au fost editate';
$langFile['EDITOR_pageNotSaved']                                          = 'nu au fost salvate';

$langFile['EDITOR_EDITLINK']                                              = 'Editeaza link';

// ---------- page settings
$langFile['EDITOR_pagestatistics_h1']                                     = 'Statistici';

$langFile['EDITOR_pageSettings_title']                                    = 'Titlu';
$langFile['EDITOR_pageSettings_title_tip']                                = 'Titlul paginii poate contine urmatoarele HTML tags:[br]<a> <span> <em> <strong> <i> <b> <abbr> <code> <samp> <kbd> <var>';
$langFile['EDITOR_pageSettings_field1']                                   = 'Descriere scurta';
$langFile['EDITOR_pageSettings_field1_inputTip']                          = 'Daca este gol va fi utilizata descrierea din Setari Website.';
$langFile['EDITOR_pageSettings_field1_tip']                               = 'O scurta descriere a continutului paginii. Aceasta descriere va fi folosita in  META-Tag-ul paginii.[br][br][span class=hint]'.$langFile['EDITOR_pageSettings_field1_inputTip'].'[/span]';
$langFile['EDITOR_pageSettings_field2']                                   = 'Tag-uri';
$langFile['EDITOR_pageSettings_field2_tip']                               = 'Tag-urile sunt cuvinte cheie pentru aceasta pagina.';
$langFile['EDITOR_pageSettings_field2_tip_inputTip']                      = 'Tag-urile trebuie separate de &quot;,&quot; (comma).';
$langFile['EDITOR_pageSettings_field3']                                   = 'Data pagina';
$langFile['EDITOR_pageSettings_field3_tip']                               = 'Data poate fi utilizata pentru sortare in functie de data. (e.g. la Evenimente)';
$langFile['EDITOR_pageSettings_field4']                                   = 'Statusul paginii';
$langFile['EDITOR_pageSettings_field4_tip']                               = '[strong]Numai daca statusul este public, pagina va fi afisata pe site![/strong]';

$langFile['EDITOR_PAGESETTINGS_NOPAGEDATE']                               = 'Fara data';

$langFile['EDITOR_TEXT_SUBCATEGORY']                                      = 'Subcategorie';
$langFile['EDITOR_TIP_SUBCATEGORY']                                       = 'Permite crearea unui submeniu pentru aceasta pagina in website.';

$langFile['EDITOR_BUTTON_RESTORELASTSTATE']                               = 'Restaurare la versiunea din %s';
$langFile['EDITOR_MESSAGE_RESTOREDTOLASTSTATE']                           = 'Restaureaza versiunea din %s.';

// ---------- page advanced settings
$langFile['EDITOR_advancedpageSettings_h1']                               = 'Setari HTML-Editor specifice acestei pagini';

$langFile['EDITOR_advancedpageSettings_field1']                           = 'Fisierul stylesheet al paginii';
$langFile['EDITOR_advancedpageSettings_stylesheet_ifempty']               = 'Daca campurile sunt goale, atunci Setarile Stylesheet ale categoriei vor fi utilizate si daca acestea sunt de asemenea goale, atunci vor fi folosite cele de la HTML-Editor-Settings.';

$langFile['EDITOR_htmleditor_hotkeys_h1']                                 = 'Shortcut keys';
$langFile['EDITOR_htmleditor_hotkeys_field1']                             = 'Selecteaza tot';
$langFile['EDITOR_htmleditor_hotkeys_field2']                             = 'copy';
$langFile['EDITOR_htmleditor_hotkeys_field3']                             = 'paste';
$langFile['EDITOR_htmleditor_hotkeys_field4']                             = 'cut';
$langFile['EDITOR_htmleditor_hotkeys_field5']                             = 'undo';
$langFile['EDITOR_htmleditor_hotkeys_field6']                             = 'redo';
$langFile['EDITOR_htmleditor_hotkeys_field7']                             = 'set link';
$langFile['EDITOR_htmleditor_hotkeys_field8']                             = 'bold';
$langFile['EDITOR_htmleditor_hotkeys_field9']                             = 'italic';
$langFile['EDITOR_htmleditor_hotkeys_field10']                            = 'underline';
$langFile['EDITOR_htmleditor_hotkeys_or']                                 = 'or';

$langFile['EDITOR_savepage_error_save']                                   .= $langFile['ERROR_SAVE_FOLDER_PART1'].'%spages/'.$langFile['ERROR_FOLDER_PART2'];// also in en.shared.php

// ---------- plugin settings
$langFile['EDITOR_pluginSettings_h1']                                     = 'Adauga plugin-uri';
$langFile['EDITOR_TEXT_EDITPLUGINSINEDITOR']                              = 'Dupa ce activezi un plugin, hoover peste plugin  pentru a-l putea trage in Editor, sau plaseaza-l direct in editor, utilizand %s icon.';
$langFile['EDITOR_MESSAGE_PLUGINSSAVED']                                  = '<div class="alert alert-success">Plugin salvat!</div>';//<div class="alert">Click on a plugin to edit its properties.</div>';
$langFile['EDITOR_TIP_DRAGPLUGIN']                                        = 'Trage plugin-ul in Editor.';

/*
* unsavedPage.php
*/

$langFile['UNSAVEDPAGE_QUESTION_CONTINUE']                                = 'Pagina s-a schimbat!<br><span class="brown">Vrei sa continui?</span>';

/*
* deletePage.php
*/

// ---------- DELETE PAGE
$langFile['deletePage_question_part1']                                    = 'Sigur vrei sa stergi pagina';
$langFile['deletePage_question_part2']                                    = '?';

$langFile['deletePage_notexisting_part1']                                 = 'Pagina';
$langFile['deletePage_notexisting_part2']                                 = 'nu exista';

$langFile['deletePage_finish_error']                                      = 'EROARE: Pagina nu poate fi stearsa!';

/*
* deletePageLanguage.php
*/

// ---------- DELETE PAGE LANGUAGE

$langFile['WINDOWBOX_TEXT_DELETEPAGELANGUAGE_QUESTION']                   = 'Sigur vrei sa stergi limba &quot;%s&quot; pentru aceasta pagina?';

/*
* addPageLanguage.php
*/

// ---------- ADD PAGE LANGUAGE

$langFile['WINDOWBOX_TEXT_ADDPAGE_SELECTLANGUAGE']                        = 'Selecteaza limba';


/*
* deletewebsiteLanguages.php
*/

// ---------- DELETE WEBSITE LANGUAGES

$langFile['WINDOWBOX_TITLE_DELETEWEBSITELANGUAGES_QUESTION']              = 'Urmatoarele limbi vor fi sterse pentru toate paginile!<br>&quot;%s&quot;';
$langFile['WINDOWBOX_TEXT_DELETEWEBSITELANGUAGES_QUESTION']               = 'Site-ul multilingv dezactivat!<br>Toate paginile vor fi setate pe limba utilizata anterior (<b>%s</b>).';


/*
* deletePageThumbnail.php
*/

// ---------- PAGE THUMBNAIL DELETE
$langFile['PAGETHUMBNAIL_TEXT_DELETE_QUESTION_START']                     = 'Sigur vrei sa stergi thumbnail-ul paginii';
$langFile['PAGETHUMBNAIL_TEXT_DELETE_QUESTION_END']                       = '?';
$langFile['PAGETHUMBNAIL_ERROR_DELETE']                                   = 'EROARE: Thumbnail-ul nu poate fi sters!';


/*
* incarcaPageThumbnail.php
*/

// ---------- PAGE THUMBNAIL UPLOAD
$langFile['pagethumbnail_h1_part1']                                       = 'Incarca thumbnail-ul paginii din';
$langFile['pagethumbnail_h1_part2']                                       = '';
$langFile['pagethumbnail_field1']                                         = 'Selecteaza imagine';

$langFile['pagethumbnail_thumbinfo_formats']                              = 'Urmatoarele formate sunt adminse'; //<br><b>JPG</b>, <b>JPEG</b>, <b>GIF</b>, <b>PNG</b>
$langFile['pagethumbnail_thumbinfo_filesize']                             = 'marime fisier maxima';
$langFile['pagethumbnail_thumbinfo_standardthumbsize']                    = 'Dimensiune imagine standard';

$langFile['pagethumbnail_thumbsize_h1']                                   = 'Seteaza tu dimensiunea imaginii';
$langFile['pagethumbnail_thumbsize_width']                                = 'Latime';
$langFile['pagethumbnail_thumbsize_height']                               = 'Inaltime';

$langFile['pagethumbnail_submit_tip']                                     = 'Incarca imagine';

$langFile['PAGETHUMBNAIL_ERROR_nofile']                                   = 'Nu ai selectat nici un fisier.';
$langFile['PAGETHUMBNAIL_ERROR_noincarcaedfile']                           = 'Nici un fisier nu a fost incarcat.';
$langFile['PAGETHUMBNAIL_ERROR_filesize']                                 = 'Marimea fisierului imagine este probabil prea mare.<br>Dimensiunea maxima este';
$langFile['PAGETHUMBNAIL_ERROR_wrongformat']                              = 'Fisierul selectat nu este un format acceptat';
$langFile['PAGETHUMBNAIL_ERROR_NODIR_START']                              = 'Folder thumbnail-uri'; // The thumbnail-folder..
$langFile['PAGETHUMBNAIL_ERROR_NODIR_END']                                = 'nu exista.';
$langFile['PAGETHUMBNAIL_ERROR_CREATEDIR_END']                            = 'nu poate fi creat.';
$langFile['PAGETHUMBNAIL_ERROR_COULDNTMOVEFILE']                          = 'Nu pot muta fisierul incarcat in folderul thumbnail %s.';
$langFile['PAGETHUMBNAIL_ERROR_CHANGEIMAGESIZE']                          = 'Nu pot redimensiona imaginea.';
$langFile['PAGETHUMBNAIL_ERROR_deleteoldfile']                            = 'Nu pot sterge thumbnail-ul vechi.';
$langFile['PAGETHUMBNAIL_TEXT_fileexists']                                = 'O imagine cu acest nume exista deja.<br>Fisierul incarcat a fost redenumit in';
$langFile['PAGETHUMBNAIL_TEXT_finish']                                    = 'Imagine incarcata cu succes.';

// -> BACKUP

$langFile['BACKUP_TITLE_BACKUP']                                          = 'Backup';
$langFile['BACKUP_TITLE_RESTORE']                                         = 'Restaurare';

$langFile['BACKUP_TITLE_RESTORE_FROMFILES']                               = 'Alege un backup preexistent';
$langFile['BACKUP_TITLE_RESTORE_FROMUPLOAD']                              = 'Incarca fisier backup';

$langFile['BACKUP_TEXT_RESTORE_BACKUPBEFORERESTORE']                      = 'Backup inainte de restaurare';

$langFile['BACKUP_BUTTON_DOWNLOAD']                                       = 'Creaza backup curent';
$langFile['BACKUP_TEXT_BACKUP']                                           = 'Back-up-ul creaza un fisier <code>.zip</code> cu<span class="blue">"pages","config"</span> si <span class="blue">"statistic"</span>.<br>Fisierul upload nu va fi salvat.';
$langFile['BACKUP_TEXT_RESTORE']                                          = '<p>Selectati un fisier de back-up <span class="feinduraName"><span>fein</span>dura</span>, pentru a restaura o instanta anterioara.</p><div class="alert"><strong>Hint!</strong> Un back-up a starii curente a fost salvat inainte de restaurare.</div>';
$langFile['BACKUP_TOOLTIP_DELETE']                                        = 'Sterge backup';
$langFile['BACKUP_TEXT_DELETE_QUESTION']                                  = 'Sigur stergi %s?'; // really delete backup 2010-11-05 15:03?

$langFile['BACKUP_TITLE_LASTBACKUPS']                                     = 'Download backup-uri';
$langFile['BACKUP_TEXT_NOBACKUP']                                         = 'Niciun backup creat inca.';

$langFile['BACKUP_ERROR_FILENOTFOUND']                                    = 'Backup-ul nu a fost gasit la:';
$langFile['BACKUP_ERROR_NORESTROEFILE']                                   = 'Nici un fisier de back-up nu a fost selectat.';
$langFile['BACKUP_ERROR_DELETE']                                          = 'Backup-ul nu poate fi sters!';

// -> ADDONS

$langFile['ADDONS_TITLE_ADDON']                                           = 'Alege un Add-on <span class="feinduraInline">fein<em>dura</em></span> ';
$langFile['ADDONS_TEXT_AUTHOR']                                           = 'Autor';
$langFile['ADDONS_TEXT_WEBSITE']                                          = 'Website';
$langFile['ADDONS_TEXT_VERSION']                                          = 'Versiune';
$langFile['ADDONS_TEXT_REQUIREMENTS']                                     = 'Cerinte';


// -> UPDATE

$langFile['UPDATE_TITLE']                                                 = 'Continutul trebuie updatat';
$langFile['UPDATE_TEXT_CHECKPATHS']                                       = 'Fii sigur ca urmatoarele cai sunt corecte inainte de update.';
$langFile['UPDATE_TEXT_BASEPATH']                                         = 'Cale catre <span class="feinduraInline">fein<em>dura</em></span>';
$langFile['UPDATE_TEXT_WEBSITEPATH']                                      = 'Cale Website';
$langFile['UPDATE_TEXT_SUCCESS']                                          = 'Continut updatat cu succes!';
$langFile['UPDATE_BUTTON_UPDATE']                                         = 'UPDATE';
$langFile['UPDATE_ERROR_MOVEUPLOADFOLDER']                                = 'Fisierul Upload nu poate fi mutat! Mutati folderul "%s" manual la "your_feindura_folder/upload/".';
$langFile['UPDATE_ERROR_MOVEPAGESFOLDER']                                 = 'Fisierul Pages nu poate fi copiat! Mutati folderul "%s" manual la "your_feindura_folder/pages/".';
$langFile['UPDATE_ERROR_SAVEADMINCONFIG']                                 = 'Setarile Admin nu pot si actualizate.';
$langFile['UPDATE_ERROR_SAVECATEGORYCONFIG']                              = 'Setarile de categorie nu pot fi actualizate.';
$langFile['UPDATE_ERROR_SAVEUSERCONFIG']                                  = 'Setarile utilizator nu pot fi actualizate.';
$langFile['UPDATE_ERROR_SAVEWEBSITECONFIG']                               = 'Setarile website nu pot fi actualizate.';
$langFile['UPDATE_ERROR_SAVEPAGES']                                       = 'Paginile nu pot fi actualizate.';
$langFile['UPDATE_ERROR_CLEARACTIVITYLOG']                                = 'Log-ul activitati nu poate fi golit.';
$langFile['UPDATE_ERROR_SAVEWEBSITESTATISTICS']                           = 'Statisticile website nu pot fi actualizate.';
$langFile['UPDATE_ERROR_SAVEREFERERLOG']                                  = 'Referer Log nu poate fi actualizat.';
$langFile['UPDATE_ERROR_DELETEOLDFILES']                                  = 'Nu pot sterge folderele si fisierele vechi,<br>Verificati si stergeti manual aceste foldere si fisiere:';
$langFile['UPDATE_ERROR_RENAMESTATISTICSFOLDER']                          = 'Couldn\'t rename the "feinduraFolder/statistic" folder "feinduraFolder/statistic<strong>s</strong>, please rename it manually!"';


// -----------------------------------------------------------------------------------------------
// RETURN ****************************************************************************************
// -----------------------------------------------------------------------------------------------
return $langFile;
