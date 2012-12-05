<?php
/*
 * feindura - Flat File Content Management System
 * Copyright (C) Fabian Vogelsteller [frozeman.de]
 * Traslated in Italian By Raffaele Panariello [Social Service] unuomoinblues@gmail.com
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
 * ITALIAN (IT) language-file for the feindura CMS (BACKEND)
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

$langFile['LOGIN_INPUT_USERNAME']                                         = 'Nome Utente';
$langFile['LOGIN_INPUT_PASSWORD']                                         = 'Password';
$langFile['LOGIN_BUTTON_LOGIN']                                           = 'Accesso';
$langFile['LOGIN_TEXT_COOKIESNEEDED']                                     = 'I cookies devono essere attivati!';

$langFile['LOGIN_LINK_FORGOTPASSWORD']                                    = 'Hai dimenticato la tua password?';
$langFile['LOGIN_LINK_BACKTOLOGIN']                                       = 'Torna all&#145;accesso';
$langFile['LOGIN_BUTTON_SENDNEWPASSWORD']                                 = 'Reimposta password';
$langFile['LOGIN_TEXT_NEWPASSWORDEMAIL_SUBJECT']                          = 'Hai richiesto la password di feindura CMS da';
$langFile['LOGIN_TEXT_NEWPASSWORDEMAIL_MESSAGE']                          = 'Hai richiesto una nuova password per il tuo feindura - Flat File CMS.
Il tuo nome utente e la tua nuova password:';

$langFile['LOGIN_ERROR_FORGOTPASSWORD_NOEMAIL']                           = 'Utente senza indirizzo EMail.';
$langFile['LOGIN_ERROR_FORGOTPASSWORD_NOTSEND']                           = 'ERRORE<br> durante l&#145;invio della nuova password per l&#145;indirizzo email dell&#145;utente specificato';
$langFile['LOGIN_ERROR_FORGOTPASSWORD_NOTSAVED']                          = 'ERRORE<br> Impossibile salvare la nuova password generata.';
$langFile['LOGIN_ERROR_FORGOTPASSWORD_SUCCESS']                           = 'Una nuova password è stata inviata al seguente indirizzo email';

$langFile['LOGIN_ERROR_WRONGUSER']                                        = 'L&#145;utente non esiste';
$langFile['LOGIN_ERROR_WRONGPASSWORD']                                    = 'password errata';

$langFile['LOGIN_TEXT_LOGOUT_PART1']                                      = 'Disconnesso con successo';
$langFile['LOGIN_TEXT_LOGOUT_PART2']                                      = 'entra nel tuo sito web';

$langFile['LOGIN_TIP_AUTOLOGOUT']                                         = 'Sarai Disconnesso Tra';


// -> GENERAL <-

$langFile['DATE_Y-M-D']                                                   = 'AAAA-MM-GG';
$langFile['DATE_D.M.Y']                                                   = 'GG.MM.AAAA';
$langFile['DATE_D/M/Y']                                                   = 'GG/MM/AAAA';
$langFile['DATE_M/D/Y']                                                   = 'MM/GG/AAAA';
$langFile['CATEGORIES_TEXT_NONCATEGORY']                                  = 'Pagine';
$langFile['CATEGORIES_TOOLTIP_NONCATEGORY']                               = 'Pagine Senza Categoria';
$langFile['TEXT_EXAMPLE']                                                 = 'Esempio';

$langFile['HEADER_BUTTON_GOTOWEBSITE_FRONTENDEDITING']                    = 'Editing Frontale::Clicca qui per modificare le pagine direttamente nel tuo sito web.';

$langFile['BUTTON_MORE']                                                  = 'altro';

// PERMISSIONS
$langFile['PERMISSIONS_TEXT_DONTHAVEPERMISSION']                          = 'Non sei autorizzato a cambiare questa situazione.';

// THUMBNAILS
$langFile['THUMBNAIL_TEXT_UNIT']                                          = 'pixel';

$langFile['THUMBNAIL_TEXT_NAME']                                          = 'Pagina-Miniatura';
$langFile['THUMBNAIL_TEXT_WIDTH']                                         = 'Larghezza <b>Miniatura</b>';
$langFile['THUMBNAIL_TEXT_HEIGHT']                                        = 'Altezza <b>Miniatura</b>';

$langFile['THUMBNAIL_TOOLTIP_WIDTH']                                      = 'Larghezza Standard::La larghezza della miniatura è sempre misurata in pixels.[br][br]L&#145;immagine verrà ridimensionata a questo valore dopo il caricamento.';
$langFile['THUMBNAIL_TOOLTIP_HEIGHT']                                     = 'Altezza Standard::L&#145;altezza della miniatura è sempre misurata in pixels.[br][br]L&#145;immagine verrà ridimensionata a questo valore dopo il caricamento.';

$langFile['THUMBNAIL_TEXT_RATIO']                                         = 'Rapporto';
$langFile['THUMBNAIL_TEXT_KEEPRATIO']                                     = 'mantenere questo rapporto';
$langFile['THUMBNAIL_TEXT_FIXEDRATIO']                                    = 'rapporto manuale fisso';
$langFile['THUMBNAIL_TOOLTIP_FIXEDRATIO']                                 = 'Larghezza e Altezza sono impostate manualmente';
$langFile['THUMBNAIL_TOOLTIP_KEEPRATIO_X']                                = 'Sarà allineata dalla [i]larghezza[/i].';
$langFile['THUMBNAIL_TOOLTIP_KEEPRATIO_Y']                                = 'Sarà allineata dall&#145; [i]altezza[/i].';

// STYLESHEETS
$langFile['STYLESHEETS_TEXT_STYLEFILE']                                   = 'Files Fogli di stile';
$langFile['STYLESHEETS_TEXT_ID']                                          = 'Id-Fogli di stile';
$langFile['STYLESHEETS_TEXT_CLASS']                                       = 'Classe-Fogli di stile';

$langFile['STYLESHEETS_TOOLTIP_STYLEFILE']                                = 'Qui è possibile specificare i files dei fogli di stile, che verranno utilizzati per lo stile del contenuto dall&#145;editor HTML.';
$langFile['STYLESHEETS_TOOLTIP_ID']                                       = 'Qui è possibile specificare un attributo-Id, che sarà aggiunto al tag <body> dall&#145;Editor-HTML.';
$langFile['STYLESHEETS_TOOLTIP_CLASS']                                    = 'Qui è possibile specificare un attributo di classe, che sarà aggiunto al tag <body> dall&#145;Editor-HTML.';

$langFile['STYLESHEETS_TOOLTIP_ADDSTYLEFILE']                             = 'aggiungi un nuovo foglio di stile';
$langFile['STYLESHEETS_EXAMPLE_STYLEFILE']                                = '<b>Esempio</b> &quot;/style/layout.css&quot;';

// PATHS
$langFile['PATHS_TEXT_ABSOLUTE']                                          = 'percorso assoluto';
$langFile['PATHS_TEXT_RELATIVE']                                          = 'percorso relativo';
$langFile['PATHS_TOOLTIP_ABSOLUTE']                                       = 'Percorso Assoluto::Percorso del file di sistema assoluto. (Ma rispetto alla DocumentRoot)[br][br][span class=hint]/server/htdocs[strong]/percorso/[/strong][/span]';
$langFile['PATHS_TOOLTIP_RELATIVE']                                       = 'Percorso Relativo::Percorso URI relativo, significa che rispetto al documento corrente.';

// STATISTICS
$langFile['STATISTICS_TITLE_BROWSERCHART']                                = 'Il browser usato dagli visitatori';
$langFile['STATISTICS_TEXT_ROBOTCOUNT']                                   = 'web-crawler';
$langFile['STATISTICS_TOOLTIP_ROBOTCOUNT']                                = 'web-crawler::I Crawlers detti anche robots sono (programmi e algoritmi) che i motori di ricerca usano lanciandoli in rete per analizzare e indicizzare le pagine index dei siti web.';

$langFile['STATISTICS_TEXT_SEARCHWORD_PART1']                             = 'ha portato'; // "exampleword" led 20 times to this website
$langFile['STATISTICS_TEXT_SEARCHWORD_PART2']                             = 'volte a questo sito';
$langFile['STATISTICS_TOOLTIP_SEARCHWORD']                                = 'Clicca qui per la ricerca di questa parola nelle pagine.';

$langFile['STATISTICS_TEXT_VISITORCOUNT']                                 = 'Visite finora';
$langFile['STATISTICS_TEXT_CURRENTVISITORS']                              = 'Visitatori correnti';
$langFile['STATISTICS_TEXT_CURRENT']                                      = 'Attualmente';
$langFile['STATISTICS_TEXT_LASTACTIVITY']                                 = 'Altima attività';

$langFile['STATISTICS_TITLE_PAGESTATISTICS']                              = 'Statistiche Pagine';

$langFile['STATISTICS_TEXT_VISITTIME_MAX']                                = 'permanenza più lunga';
$langFile['STATISTICS_TEXT_VISITTIME_MIN']                                = 'permanenza più breve ';
$langFile['STATISTICS_TEXT_FIRSTVISIT']                                   = 'da';
$langFile['STATISTICS_TEXT_LASTVISIT']                                    = 'a';
$langFile['STATISTICS_TEXT_NOVISIT']                                      = 'Nessuno mai ancora ha visito questo sito.';
$langFile['STATISTICS_TEXT_SEARCHWORD_DESCRIPTION']                       = '<span class="toolTipTop" title="::Che hanno portato da
Google, Yahoo o Bing (MSN) a questo sito.">Parole di ricerca</span>';

$langFile['STATISTICS_TEXT_HOUR_SINGULAR']                                = 'ora';
$langFile['STATISTICS_TEXT_HOUR_PLURAL']                                  = 'ore';
$langFile['STATISTICS_TEXT_MINUTE_SINGULAR']                              = 'minuto';
$langFile['STATISTICS_TEXT_MINUTE_PLURAL']                                = 'minuti';
$langFile['STATISTICS_TEXT_SECOND_SINGULAR']                              = 'secondo';
$langFile['STATISTICS_TEXT_SECOND_PLURAL']                                = 'secondi';

$langFile['STATISTICS_TEXT_BROWSERCHART_OTHERS']                          = 'altro';

// LOG TEXTS
$langFile['LOG_PAGE_SAVED']                                               = 'Pagina salvata';
$langFile['LOG_PAGE_NEW']                                                 = 'Nuova pagina creata';
$langFile['LOG_PAGE_DELETE']                                              = 'Pagina eliminata';

$langFile['LOG_PAGE_MOVEDINCATEGORY']                                     = 'Spostare pagina alla categoria';
$langFile['LOG_PAGE_MOVEDTOCATEGORY_CATEGORY']                            = 'nella categoria'; // Example Page in Category
$langFile['LOG_PAGE_SORTED']                                              = 'Ordinamento pagina modificata';

$langFile['LOG_THUMBNAIL_UPLOAD']                                         = 'Nuova miniatura caricata';
$langFile['LOG_THUMBNAIL_DELETE']                                         = 'Miniatura cancellata';

$langFile['LOG_USER_ADD']                                                 = 'Nuovo utente creato';
$langFile['LOG_USER_DELETED']                                             = 'Utente cancellato';
$langFile['LOG_USER_PASSWORD_CHANGED']                                    = 'Password utente cambiata';
$langFile['LOG_USER_SAVED']                                               = 'Utente salvato';

$langFile['LOG_ADMINSETUP_SAVED']                                         = 'Impostazioni-Amministratore salvate';
$langFile['LOG_ADMINSETUP_CKSTYLES']                                      = '&quot;Formattazione-Stili&quot; con Editor-HTML salvata';

$langFile['LOG_WEBSITESETUP_SAVED']                                       = 'Impostazioni-Website salvate';

$langFile['LOG_STATISTICSETUP_SAVED']                                     = 'Impostazioni-Statistiche salvate';
$langFile['LOG_CLEARSTATISTICS_WEBSITESTATISTIC']                         = 'Statistiche-Website cancellate';
$langFile['LOG_CLEARSTATISTICS_PAGESTATISTICS']                           = 'Statistiche-Pagina cancellate';
$langFile['LOG_CLEARSTATISTICS_PAGESTAYLENGTH']                           = 'Statistica-Durata-Permanenza-Pagina cancellati';
$langFile['LOG_CLEARSTATISTICS_REFERERLOG']                               = 'Log-Referrer cancellato';
$langFile['LOG_CLEARSTATISTICS_ACTIVITYLOG']                              = 'Log-Ultime Attività cancellato';

$langFile['LOG_PAGESETUP_SAVED']                                          = 'Impostazioni-Pagina salvate';
$langFile['LOG_PAGESETUP_CATEGORIES_SAVED']                               = 'Categorie salvate';

$langFile['LOG_PAGESETUP_CATEGORIES_NEW']                                 = 'Nuova categora creata';
$langFile['LOG_PAGESETUP_CATEGORIES_DELETED']                             = 'Categoria cancellata';
$langFile['LOG_PAGESETUP_CATEGORIES_MOVED']                               = 'Categoria spostata';

$langFile['LOG_FILE_SAVED']                                               = 'File salvato';
$langFile['LOG_FILE_DELETED']                                             = 'File cancellato';

$langFile['LOG_BACKUP_CREATED']                                           = 'Backup creato';
$langFile['LOG_BACKUP_RESTORED']                                          = 'Backup ripristinato';
$langFile['LOG_BACKUP_DELETED']                                           = 'Backup cancellato';

$langFile['LOG_PAGELANGUAGE_DELETED']                                     = 'Eliminata lingua &quot;%s&quot; per la pagina';
$langFile['LOG_PAGELANGUAGE_ADD']                                         = 'Aggiungi lingua &quot;%s&quot; per la pagina';


// PAGE/CATEGORY STATUS
$langFile['STATUS_PAGE_PUBLIC']                                           = 'Pagina Pubblica';
$langFile['STATUS_PAGE_NONPUBLIC']                                        = 'Pagina Nascosta';

$langFile['STATUS_CATEGORY_PUBLIC']                                       = 'Categora Pubblica';
$langFile['STATUS_CATEGORY_NONPUBLIC']                                    = 'Categoria Nascosta';

// USER LIST
$langFile['USER_TEXT_USER']                                               = 'Utente';
$langFile['USER_TEXT_NOUSER']                                             = 'Non c&#145;erano utenti.';
$langFile['USER_TEXT_CURRENTUSER']                                        = 'Che sei tu!';
$langFile['USER_TEXT_USERSONLINE']                                        = 'Questo utente è online::Ultime attività';

$langFile['LOGO_TEXT']                                                    = 'Versione';
$langFile['txt_logo_gotowebsite']                                         = 'Clicca qui per entrare nel tuo sito web.';


// CKEDITOR transport
$langFile['CKEDITOR_TITLE_LINKS']                                         = 'Pagine feindura';
$langFile['CKEDITOR_TITLE_SNIPPETS']                                      = 'Frammenti di codice';
$langFile['CKEDITOR_TEXT_SNIPPETS']                                       = 'Scegli un frammento di codice per inserirlo nella pagina.';
$langFile['CKEDITOR_BUTTON_EDITSNIPPET']                                  = 'Modifica frammento di codice';
$langFile['CKEDITOR_TITLE_PLUGINS']                                       = 'Plugins';
$langFile['CKEDITOR_BUTTON_EDITPLUGIN']                                   = 'Modifica Plugin';

$langFile['CKEDITOR_TEXT_PLUGINS']                                        = 'Scegli un plugin per inserirlo nella pagina.';


// -> BUTTON TEXTS

// MAIN MENU
$langFile['BUTTON_DASHBOARD']                                             = 'Cruscotto';
$langFile['BUTTON_PAGES']                                                 = 'Pagine';
$langFile['BUTTON_ADDONS']                                                = 'Add-ons';
$langFile['BUTTON_WEBSITESETTINGS']                                       = 'Impostazioni SitoWeb';
$langFile['BUTTON_SEARCH']                                                = 'Ricerca Pagine';

// ADMIN MENU
$langFile['HEADER_TITLE_ADMINMENU']                                       = 'Impostazioni Amministrazione';
$langFile['BUTTON_ADMINSETUP']                                            = 'Impostazioni Generale';
$langFile['BUTTON_PAGESETUP']                                             = 'Impostazioni Pagine';
$langFile['BUTTON_STATISTICSETUP']                                        = 'Impostazioni Statistiche';
$langFile['BUTTON_USERSETUP']                                             = 'Utenti';
$langFile['BUTTON_BACKUP']                                                = 'Backups';

// SUB MENU/FOOTER
$langFile['BUTTON_FILEMANAGER']                                           = 'File Manager';
$langFile['BUTTON_TOOLTIP_FILEMANAGER']                                   = 'Gestisci Files E Immagini';
$langFile['BUTTON_CREATEPAGE']                                            = 'Nuova Pagina';
$langFile['BUTTON_TOOLTIP_CREATEPAGE']                                    = 'Crea Nuova Pagina';
$langFile['BUTTON_DELETEPAGE']                                            = 'Elimina Pagina';
$langFile['BUTTON_TOOLTIP_DELETEPAGE']                                    = 'Elimina Questa Pagina';
$langFile['BUTTON_FRONTENDEDITPAGE']                                      = 'Modifica Pagina Frontalmente';
$langFile['BUTTON_TOOLTIP_FRONTENDEDITPAGE']                              = 'Modifica Pagina Sul Sito.';
$langFile['BUTTON_THUMBNAIL_UPLOAD']                                      = 'Carica Miniatura';
$langFile['BUTTON_TOOLTIP_THUMBNAIL_UPLOAD']                              = 'Carica Miniatura Nella Pagina';
$langFile['BUTTON_THUMBNAIL_DELETE']                                      = 'Elimina Miniatura';
$langFile['BUTTON_TOOLTIP_THUMBNAIL_DELETE']                              = 'Elimina Miniatura Della Pagina';
$langFile['BUTTON_WEBSITELANGUAGE_ADD']                                   = 'Aggiungi Lingua';
$langFile['BUTTON_TOOLTIP_WEBSITELANGUAGE_ADD']                           = 'Aggiungere un nuovo linguaggio di questa pagina';
$langFile['BUTTON_WEBSITELANGUAGE_DELETE']                                = 'Elimina Lingua';
$langFile['BUTTON_TOOLTIP_WEBSITELANGUAGE_DELETE']                        = 'Eliminare Lingua &quot;%s&quot; per questa pagina';
$langFile['BUTTON_SHOWINMENU']                                            = 'Show in menus';
$langFile['BUTTON_HIDEINMENU']                                            = 'Hide from menus';
$langFile['BUTTON_TOOLTIP_SHOWHIDEINMENU']                                = 'Whether or not to hide this page from menus.';
$langFile['BUTTON_SHOWINMENU']                                            = 'Mostra nel menu';
$langFile['BUTTON_HIDEINMENU']                                            = 'Nascondi dal menu';
$langFile['BUTTON_TOOLTIP_SHOWHIDEINMENU']                                = 'Determina se la pagina viene visualizzata nel menu o meno.';

// OTHER BUTTONS
$langFile['BUTTON_UP']                                                    = 'Torna Su';
$langFile['BUTTON_INFO']                                                  = 'Info';
$langFile['BUTTON_EDIT']                                                  = 'Modifica';
$langFile['BUTTON_RESET']                                                 = 'Ristabilire';
$langFile['BUTTON_OK']                                                    = 'OK';

// -> GENERAL ERROR TEXTS
$langFile['ERROR_SAVE_SETTINGS']                                          = '<b>Le impostazioni non possono essere salvate</b>';
$langFile['ERROR_SAVE_FILE']                                              = '<br><br>Si prega di verificare i permessi di lettura e scrittura del file: ';

$langFile['ERROR_READ_FOLDER_PART1']                                      = '<br><br>Si prega di controllare le autorizzazioni di lettura del &quot;';
$langFile['ERROR_SAVE_FOLDER_PART1']                                      = '<br><br>Si prega di controllare le autorizzazioni di scrittura del &quot;';

$langFile['ERROR_FOLDER_PART2']                                           = '&quot;Cartelle, sottocartelle e file.&quot;';

// -> WARNINGS
$langFile['WARNING_TITLE_STARTPAGE']                                      = 'La pagina iniziale non è impostata!';
$langFile['WARNING_TEXT_STARTPAGE']                                       = 'Si prega di impostare una pagina come pagina iniziale.<br>Vai a <a href="?site=pages">'.$langFile['BUTTON_PAGES'].'</a> e fare clic sull&#145; <span class="icons startpage"></span> icona della pagina desiderata.';

$langFile['WARNING_TITLE_DOCUMENTROOT']                                   = 'La root del documento non può essere risolta automaticamente!';
$langFile['WARNING_TEXT_DOCUMENTROOT']                                    = 'Per <span class="feinduraInline">fein<em>dura</em></span> per funzionare correttamente, è necessario impostare la DocumentRoot manualmente su <a href="?site=adminSetup#adminSettings">impostazioni-amministratore</a>.';

$langFile['WARNING_TITLE_BASEPATH']                                       = '<span class="feinduraInline">fein<em>dura</em></span> non è configurato!';
$langFile['WARNING_TEXT_BASEPATH']                                        = 'Il <i> percorso di base</i> del CMS non corrisponde a quello delle impostazioni-amministratore.<br>
Si prega di andare su <a href                                             ="?site=adminSetup#adminSettings">impostazioni-amministratore</a> per configurare il tuo <span class="feinduraInline">fein<em>dura</em></span> CMS.';

$langFile['WARNING_TITLE_JAVASCRIPT']                                     = 'Si prega di attivare Javascript';
$langFile['WARNING_TEXT_JAVASCRIPT']                                      = '<strong>Per utilizzare appieno <span class="feinduraInline">fein<em>dura</em></span>, è necessario attivare il  Javascript!</strong>';

$langFile['WARNING_TITLE_UNTITLEDCATEGORIES']                             = 'Manca nomi delle categorie';

$langFile['DASHBOARD_TITLE_IEWARNING']                                    = '<span class="feinduraInline">fein<em>dura</em></span> non è fatto per le versioni di browser obsoleti e precedenti di <br>Internet Explorers';
$langFile['DASHBOARD_TEXT_IEWARNING']                                     = 'Per utilizzare completamente  <span class="feinduraInline">fein<em>dura</em></span> CMS è necessario almeno Internet Explorer 9.<br><br>Si prega di installare una versione più recente di Internet Explorer,<br> o installare <a href="http://www.google.com/chromeframe" target="_blank">Google Chrome Frame Plugin</a> per Internet Explorer,<br>o scaricare e installare il programma gratuito <a href="http://www.mozilla.org/firefox/">Firefox</a> o <a href="http://www.google.com/chrome/">Chrome</a> Browser.';

$langFile['GENERAL_TEXT_CURRENTLYEDITED']                                 = 'Attendi pagina in corso di modifica...';

// MESSAGES
$langFile['MESSAGE_TEXT_CHANGEDSTATUS']                                   = 'Lo stato è stata cambiata con successo.';
$langFile['MESSAGE_TEXT_CHANGEDSHOWINMENU']                               = 'Lo stato del menu è stata cambiata con successo.';


/*
* leftSidebar.loader.php
*/

// ---------- QUICKMENU

$langFile['SIDEBARMENU_TITLE_CATEGORIES']                                 = 'Categorie';
$langFile['SIDEBARMENU_TITLE_PAGES']                                      = 'pagine di';

/*
* dashboard.php
*/

// ---------- DASHBOARD
$langFile['DASHBOARD_TITLE_USERINFO']                                     = 'Utenti';

$langFile['DASHBOARD_TITLE_WELCOME']                                      = 'Benvenuti in <span class="feinduraInline">fein<em>dura</em></span> - Flat File CMS.<br>Un Sistema Di Gestione Dei Contenuti Per Il Tuo Sito Web.';

$langFile['DASHBOARD_TITLE_STATISTICS']                                   = 'Statistiche-Sito-Web';

$langFile['DASHBOARD_TITLE_USER']                                         = 'Utente';
$langFile['DASHBOARD_TITLE_ACTIVITY']                                     = 'ultime attività';
$langFile['DASHBOARD_TEXT_ACTIVITY_NONE']                                 = 'nessuno';

$langFile['DASHBOARD_TITLE_STATISTICS_MOSTVISITED']                       = 'pagine più visitate';
$langFile['DASHBOARD_TITLE_STATISTICS_LASTVISITED']                       = 'ultime pagine visitate';
$langFile['DASHBOARD_TITLE_STATISTICS_LASTEDITED']                        = 'ultime pagine modificate';
$langFile['DASHBOARD_TITLE_STATISTICS_LONGESTVIEWED']                     = 'pagine visitate più a lungo';

$langFile['DASHBOARD_TITLE_REFERER']                                      = 'Siti web da cui i visitatori provenivano';

/*
* listPages.php
*/

// ---------- PAGES SORTABLE LIST
$langFile['SORTABLEPAGELIST_h1']                                          = 'Il contenuto del tuo sito web';
$langFile['SORTABLEPAGELIST_headText1']                                   = 'filtro';
$langFile['SORTABLEPAGELIST_headText3']                                   = 'Visitatori';
$langFile['SORTABLEPAGELIST_headText4']                                   = 'Stato';
$langFile['SORTABLEPAGELIST_headText5']                                   = 'Funzioni';

$langFile['SORTABLEPAGELIST_TIP_PAGEDATE']                                = 'Data pagina';
$langFile['SORTABLEPAGELIST_TIP_LASTEDIT']                                = 'Ultima modifica';
$langFile['SORTABLEPAGELIST_TIP_TAGS']                                    = 'Tags';
$langFile['SORTABLEPAGELIST_TIP_LOCALIZATION']                            = 'Lingue';

$langFile['SORTABLEPAGELIST_TIP_SORTALPHABETICAL']                        = 'in ordine alfabetico';
$langFile['SORTABLEPAGELIST_TIP_SORTBYPAGEDATE']                          = 'in ordine per data';

$langFile['SORTABLEPAGELIST_functions_editPage']                          = 'Modifica Pagina';

$langFile['SORTABLEPAGELIST_TIP_CHANGESTATUS']                            = 'Clicca qui per cambiare lo stato.';

$langFile['SORTABLEPAGELIST_TOOLTIP_LANGUAGEMISSING']                     = 'Lingue mancanti';

$langFile['file_error_read']                                              = '<b>Impossibile leggere la pagina.</b>'.$langFile['ERROR_READ_FOLDER_PART1'].'%spages/'.$langFile['ERROR_FOLDER_PART2'];
$langFile['SORTABLEPAGELIST_setStartPage_error_save']                     .= $langFile['ERROR_SAVE_FILE'].' &quot;%sconfig/website.config.php&quot;'; // also in en.shared.php
$langFile['SORTABLEPAGELIST_changeStatusPage_error_save']                 = '<b>Impossibile modificare lo stato della pagina.</b>'.$langFile['ERROR_SAVE_FOLDER_PART1'].'%spages/'.$langFile['ERROR_FOLDER_PART2'];
$langFile['SORTABLEPAGELIST_changeStatusCategory_error_save']             = '<b>Impossibile modificare lo stato della categoria.</b>'.$langFile['ERROR_SAVE_FOLDER_PART1'].'%spages/'.$langFile['ERROR_FOLDER_PART2'];

$langFile['SORTABLEPAGELIST_info']                                        = '&#200; possibile modificare questo <b>ordinamento</b> delle pagine spostandole da su a giù nella categoria usando il <b>Drag and Drop</b>.';
$langFile['SORTABLEPAGELIST_save']                                        = 'Salva nuovo ordinamento ...';
$langFile['SORTABLEPAGELIST_save_finished']                               = 'Nuovo ordinamento salvato con successo!';
$langFile['SORTABLEPAGELIST_error_save']                                  = '<b>Impossibile salvare la pagina.</b>'.$langFile['ERROR_SAVE_FOLDER_PART1'].'%spages/'.$langFile['ERROR_FOLDER_PART2'];
$langFile['SORTABLEPAGELIST_error_read']                                  = '<b>Non è stato possibile leggere le pagine.</b>'.$langFile['ERROR_READ_FOLDER_PART1'].'%spages/'.$langFile['ERROR_FOLDER_PART2'];
$langFile['SORTABLEPAGELIST_error_move']                                  = '<b>Impossibile spostare la pagina nella nuova categoria.</b>'.$langFile['ERROR_SAVE_FOLDER_PART1'].'%spages/'.$langFile['ERROR_FOLDER_PART2'];
$langFile['SORTABLEPAGELIST_categoryEmpty']                               = 'Non ci sono pagine disponibili';
$langFile['SORTABLEPAGELIST_TIP_DRATOREARRANGE']                          = 'Trascina per riorganizzare.';

$langFile['SORTABLEPAGELIST_TIP_SUBCATEGORYOFPAGES_SINGULAR']             = 'Sottocategoria della pagina:';
$langFile['SORTABLEPAGELIST_TIP_SUBCATEGORYOFPAGES_PLURAL']               = 'Sottocategoria delle pagine:';

// ---------- FORMULAR
$langFile['FORM_BUTTON_SUBMIT']                                           = 'Salva Impostazioni';
$langFile['FORM_BUTTON_CANCEL']                                           = 'Ripristina tutti gli input';

/*
* adminSetup.php
*/

// ---------- ADMIN SETUP (on toolTips tooTips.js converts the "[" and "]" tags in the title attribute to "<" ">")
$langFile['ADMINSETUP_TEXT_VERSION']                                      = 'versione <span class="feinduraInline">fein<em>dura</em></span>';
$langFile['ADMINSETUP_TEXT_PHPVERSION']                                   = 'versione PHP';
$langFile['ADMINSETUP_TITLE_DOCUMENTROOT']                                = 'Root Documenti';

$langFile['ADMINSETUP_TITLE_ERROR']                                       = 'Si sono verificati errori';
$langFile['ADMINSETUP_TOOLTIP_WRITEACCESSERROR']                          = 'Per i file e le directory hai bisogno di impostare le autorizzazioni a %o.';

$langFile['ADMINSETUP_TEXT_WRITEACCESSERROR']                             = 'non è scrivibile';
$langFile['ADMINSETUP_TEXT_ISFOLDERERROR']                                = 'non è una directory';

// ---------- general Settings
$langFile['ADMINSETUP_GENERAL_error_save']                                = $langFile['ERROR_SAVE_SETTINGS'].$langFile['ERROR_SAVE_FILE'].'%sconfig/admin.config.php';

$langFile['ADMINSETUP_GENERAL_h1']                                        = 'Impostazioni-Di-Base';

$langFile['ADMINSETUP_GENERAL_TEXT_DOCUMENTROOT']                         = 'DocumentRoot';
$langFile['ADMINSETUP_GENERAL_TOOLTIP_DOCUMENTROOT']                      = 'Si prega di digitare il principale documento manualmente.[br][span class=hint]a.e. &quot;/server/user/htdocs&quot;[/span]';
$langFile['ADMINSETUP_GENERAL_field1']                                    = 'URL Sito Web';
$langFile['ADMINSETUP_GENERAL_field1_tip']                                = 'L&#145;URL del tuo sito verrà aggiunto automaticamente.';
$langFile['ADMINSETUP_GENERAL_field1_inputTip']                           = 'L&#145;URL verrà aggiunto automaticamente';
$langFile['ADMINSETUP_GENERAL_field1_inputWarningText']                   = 'Si prega di salvare le impostazioni!';
$langFile['ADMINSETUP_GENERAL_field2']                                    = 'Percorso Feindura';
$langFile['ADMINSETUP_GENERAL_field2_tip']                                = 'Il percorso di base sarà determinato automaticamente e salvato, per la prima volta le impostazioni vengono salvate.';
$langFile['ADMINSETUP_GENERAL_field2_inputTip']                           = 'Il percorso verrà aggiunto automaticamente';
$langFile['ADMINSETUP_GENERAL_field2_inputWarningText']                   = 'Si prega di salvare le impostazioni!';
$langFile['ADMINSETUP_GENERAL_field8']                                    = 'Percorso Sito Web';
$langFile['ADMINSETUP_GENERAL_field8_tip']                                = 'Il [strong]percorso assoluto[/strong] in cui il sito si trova.[br][br][span class=hint]Può anche contenere i nomi di file, ad esempio &quot;/website/index.php&quot;[/span]';
$langFile['ADMINSETUP_GENERAL_editfiles_additonal']                       = '[br][br]Questi file possono essere modificati più in basso, o nelle impostazioni-website (se è attivato dalle impostazioni-utente).[br][br]';
$langFile['ADMINSETUP_GENERAL_field5']                                    = 'Percorso Per I File';
$langFile['ADMINSETUP_GENERAL_field5_tip']                                = 'Qui è possibile aggiungere un percorso per i sito-specifici file, che dovrebbe essere modificabile in [span class=feinduraInline]fein[em]dura[/em][/span].'.$langFile['ADMINSETUP_GENERAL_editfiles_additonal'];
$langFile['ADMINSETUP_GENERAL_field6']                                    = 'Percorso Per I Fogli Di Stile';
$langFile['ADMINSETUP_GENERAL_field6_tip']                                = 'Qui è possibile aggiungere un percorso per i file di fogli di stile, che dovrebbe essere modificabile in [span class=feinduraInline]fein[em]dura[/em][/span].'.$langFile['ADMINSETUP_GENERAL_editfiles_additonal'];
$langFile['ADMINSETUP_GENERAL_TEXT_PERMISSIONS']                          = 'Autoriz.ni File E Cartelle';
$langFile['ADMINSETUP_GENERAL_TIP_PERMISSIONS']                           = 'Ogni file o cartella creata da [span class=feinduraInline]fein[em]dura[/em][/span] otterrà le autorizzazioni in scrittura automaticamente.';
$langFile['ADMINSETUP_TEXT_VARNAMEPAGE']                                  = 'Nome del URL pagina';
$langFile['ADMINSETUP_TEXT_VARNAMECATEGORY']                              = 'Nome del URL categoria';
$langFile['ADMINSETUP_TEXT_VARNAMEMODUL']                                 = 'Nome del URL modul';
$langFile['ADMINSETUP_TIP_VARNAME']                                       = 'Il nome che verrà utilizzato nell&#145;URL per collegare le pagine.';
$langFile['ADMINSETUP_TIP_EMPTYVARNAME']                                  = 'Se il campo è vuoto per il nome standard sarà utilizzato: ';
$langFile['ADMINSETUP_TEXT_TIMEZONE']                                     = 'Time Zone';
$langFile['ADMINSETUP_TIP_TIMEZONE']                                      = 'Utilizzato da [span class=feinduraInline]fein[em]dura[/em][/span] solo per il Backend.';
$langFile['ADMINSETUP_GENERAL_PRETTYURL']                                 = 'Formato URL';
$langFile['ADMINSETUP_GENERAL_PRETTYURL_true']                            = 'Pretty URLs';
$langFile['ADMINSETUP_GENERAL_PRETTYURL_true_example']                    = '/%s/category-name/example-page';
$langFile['ADMINSETUP_GENERAL_PRETTYURL_false']                           = 'URLs con variabili';
$langFile['ADMINSETUP_GENERAL_PRETTYURL_false_example']                   = 'index.php?%s=1&%s=1';
$langFile['ADMINSETUP_GENERAL_PRETTYURL_tip']                             = 'Questo sarà il formato URL che verrà utilizzato per collegare le pagine.[br][br]Pretty URLs funziona solo se [strong]Apache Server[/strong] ha attivato [strong]mod_rewrite[/strong] e il modulo è disponibile.';
$langFile['ADMINSETUP_GENERAL_PRETTYURL_warning']                         = 'ATTENZIONE!::[span class=red]Se si verifica un errore durante l&#145;utilizzo di [i]Pretty URLs[/i], sarà necessario eliminare il file - [strong].htaccess[/strong] - [br]Questo file dal percorso principale del vostro server web va eliminato solo se si desidera usare Pretty URLs.[/span][br][br](In alcuni programmi FTP si devono mostrare i file nascosti in primo luogo, per vedere il file .Htaccess altrimenti esso risulterà invisibile)';

// ---------- Pretty url ERRORs
$langFile['ADMINSETUP_GENERAL_PRETTYURL_error_save']                      = '<b>Pretty URLs</b> non può essere attivato'.$langFile['ERROR_SAVE_FILE'].'/.htaccess';
$langFile['ADMINSETUP_GENERAL_PRETTYURL_error_modul']                     = '<b>Pretty URLs</b> non può essere attivato, poiché Apache MOD_REWRITE modul non è stato trovato';

// ---------- cache settings
$langFile['ADMINSETUP_TEXT_CACHE']                                        = 'Attivare la cache';
$langFile['ADMINSETUP_TIP_CACHE']                                         = 'Se attivo, tutte le pagine saranno memorizzate nella cache. Questo può sementi contenenti al massimo il sito web, ma porta anche a non così contenuto effettivo.[br][br][span class=hint]La cache verrà aggiornata, quando si modificano le pagine.[/span]';
$langFile['ADMINSETUP_TEXT_CACHETIMEOUT']                                 = 'Cache timeout';
$langFile['ADMINSETUP_TIP_CACHETIMEOUT']                                  = 'Indica il tempo dopo il quale la cache viene aggiornata.';
$langFile['ADMINSETUP_HINT_CACHETIMEOUT']                                 = 'orario';

// ---------- editor Settings
$langFile['adminSetup_editorSettings_h1']                                 = 'Impostazzioni-Editor-HTML';
$langFile['ADMINSETUP_TEXT_EDITOR_HTMLLAWED']                             = 'Il filtro HTML (utilizza <a href="http://www.bioinformatics.org/phplabware/internal_utilities/htmLawed/" target="_blank">htmlLawed</a>)';
$langFile['ADMINSETUP_TIP_EDITOR_HTMLLAWED']                              = 'Filtrare il codice HTML prima di salvare. Questo per evitare concause e problemi nel codice HTML con un sacco di Javascript.';
$langFile['ADMINSETUP_TEXT_EDITOR_SAFEHTML']                              = 'safe HTML (<a href="http://www.bioinformatics.org/phplabware/internal_utilities/htmLawed/htmLawed_README.htm#s3.6" target="_blank">dettagli</a>)';
$langFile['ADMINSETUP_TIP_EDITOR_SAFEHTML']                               = 'Questo è il codice HTML con le impostazioni più sicure che viene filtrato, vale a dire per esempio che nessun tag del tipo &lt;applet&gt;,&lt;embed&gt;,&lt;embed&gt;,&lt;object &gt; e &lt;script&gt; sono ammessi.';
$langFile['ADMINSETUP_TEXT_EDITOR_EDITORSTYLES']                          = 'attivare Stili-Selezione';
$langFile['ADMINSETUP_TIP_EDITOR_EDITORSTYLES']                           = 'Il Stili-Selezione consente di utilizzare personalizzati elementi HTML nel codice Editor-HTML.[br][br][span class=hint]Se questa opzione è attivata, è possibile modificare/creare elementi HTML più in basso.[/span]';
$langFile['ADMINSETUP_TEXT_EDITOR_SNIPPETS']                              = 'attivare frammenti di codice';
$langFile['ADMINSETUP_TIP_EDITOR_SNIPPETS']                               = 'Permette di inserire frammenti di codice nelle pagine.[br]Fare clic sull&#145;icona nella editor Editor-HTML: [img class=icons src=library/thirdparty/ckeditor/plugins/feinduraSnippets/feinduraSnippetsIcon.png][br][br][span class=hint]Se questa opzione è attivata, è possibile modificare/creare frammenti di codice più in basso.[/span]';
$langFile['adminSetup_editorSettings_field1']                             = 'ENTER-Key mode';
$langFile['adminSetup_editorSettings_field1_hint']                        = 'SHIFT + ENTER genera un &quot;%s&quot;';
$langFile['adminSetup_editorSettings_field1_tip']                         = 'Specifica quali tag HTML quando si preme il tasto ENTER verranno impostati.[br][br][span class=hint]'.$langFile['adminSetup_editorSettings_field1_hint'].'.[/span]';
$langFile['adminSetup_editorSettings_field3_inputTip']                    = 'Se il campo è vuoto, non viene utilizzato l&#145;ID.';
$langFile['adminSetup_editorSettings_field4_inputTip']                    = 'Se il campo è vuoto, nessuna classe verrà utilizza.';

// THUMBNAILS Settings
$langFile['adminSetup_thumbnailSettings_h1']                              = 'Pagina-Impostazioni-Miniature';

// ---------- styleFile Settings
$langFile['adminSetup_styleFileSettings_h1']                              = 'Modificare gli Stili-Selezione del HTML-Editor';
$langFile['adminSetup_styleFileSettings_error_save']                      = '<b>il file &quot;EditorHTMLStyles.js&quot; non può essere salvato.</b>'.$langFile['ERROR_SAVE_FILE'];

// ---------- editFiles Settings
$langFile['EDITFILESSETTINGS_TITLE_STYLESHEETS']                          = 'Modificare i file di fogli di stile';
$langFile['EDITFILESSETTINGS_TITLE_WEBSITEFILES']                         = 'Modificare i file del sito web';
$langFile['EDITFILESSETTINGS_TITLE_SNIPPETS']                             = 'Modifica frammenti di codice';
$langFile['EDITFILESSETTINGS_TEXT_NODIR']                                 = 'non è una directory valida!';
$langFile['EDITFILESSETTINGS_TEXT_CHOOSEFILE']                            = 'selezionare il file';
$langFile['EDITFILESSETTINGS_TEXT_CREATEFILE']                            = 'Creare Un Nuovo File';
$langFile['EDITFILESSETTINGS_TIP_CREATEFILE']                             = 'Qui, puoi immette un nome di file, quindi un nuovo file verrà creato. [br][strong]I nuovi files creati non verrnno salvati nei backups![/strong]';
$langFile['EDITFILESSETTINGS_TEXT_NOFILE']                                = 'Non ci sono file disponibili';

$langFile['EDITFILESSETTINGS_TEXT_DELETEFILE']                            = 'Cancella il file';
$langFile['EDITFILESSETTINGS_TEXT_DELETEFILE_QUESTION']                   = 'Sei sicuro di voler cancellare il file %s?';

$langFile['EDITFILESSETTINGS_ERROR_SAVEFILE']                             = '<b>Il file non può essere salvato.</b>'.$langFile['ERROR_SAVE_FILE'];
$langFile['EDITFILESSETTINGS_ERROR_DELETEFILE']                           = '<b>Impossibile eliminare il file.</b>'.$langFile['ERROR_SAVE_FILE'];

/*
* pageSetup.php
*/

// ---------- CATEGORY SETUP (on toolTips tooTips.js converts the "[" and "]" tags in the title attribute to "<" ">")
$langFile['PAGESETUP_PAGES_TIP_TAG']                                      = 'I Tags possono essere utilizzati per creare connessioni tra le pagine (a seconda della programmazione del sito)';

// ---------- page settings
$langFile['PAGESETUP_PAGES_TITLE_NONCATEGORYPAGES']                       = 'Pagine-Senza-Categoria';
$langFile['PAGESETUP_PAGES_TEXT_CREATEPAGES']                             = 'Creare Cancellare Pagine';
$langFile['PAGESETUP_PAGES_TIP_CREATEPAGES']                              = 'Determina se l&#145;utente può creare o eliminare le pagine senza categoria.';
$langFile['PAGESETUP_PAGES_TEXT_UPLOADTHUMBNAILS']                        = 'Carica Miniature';
$langFile['PAGESETUP_PAGES_TIP_UPLOADTHUMBNAILS']                         = 'Determina se l&#145;utente, all&#145;interno delle pagine senza una categoria, può caricare e usare le miniature in esse inserite.';
$langFile['PAGESETUP_PAGES_TEXT_EDITTAGS']                                = 'Modificare Tag';
$langFile['PAGESETUP_PAGES_TIP_EDITTAGS']                                 = 'Determina se l&#145;utente, all&#145;interno delle pagine senza una categoria, può modificare i tag.[br]'.$langFile['PAGESETUP_PAGES_TIP_TAG'];
$langFile['PAGESETUP_PAGES_TEXT_ACTIVATEPLUGINS']                         = 'Abilitare Plugin';
$langFile['PAGESETUP_PAGES_TIP_ACTIVATEPLUGINS']                          = 'Determina se l&#145;utente, all&#145;interno delle pagine senza una categoria, può utilizzare i plugin.';

// ---------- category settings
$langFile['PAGESETUP_CATEGORY_TITLE_CATEGORIES']                          = 'Gestione-Delle-Categorie';
$langFile['PAGESETUP_CATEGORY_TEXT_CATEGORYNAME']                         = 'Nome';

$langFile['PAGESETUP_CATEGORY_TEXT_CREATECATEGORY']                       = 'Crea una nuova categoria';
$langFile['PAGESETUP_CATEGORY_TEXT_CREATECATEGORY_CREATED']               = 'Nuova categoria creata';
$langFile['PAGESETUP_CATEGORY_TEXT_CREATECATEGORY_UNNAMED']               = 'Categoria Senza titolo';

$langFile['PAGESETUP_CATEGORY_TEXT_DELETECATEGORY']                       = 'Elimina la categoria';
$langFile['PAGESETUP_CATEGORY_TEXT_DELETECATEGORY_WARNING']               = 'ATTENZIONE: Elimina tutte le pagine in questa categoria!';
$langFile['PAGESETUP_CATEGORY_TEXT_DELETECATEGORY_DELETED']               = 'Categoria cancellata';
$langFile['PAGESETUP_CATEGORY_TEXT_DELETECATEGORY_QUESTION_START']        = 'Elimina la categoria'; // Kategorie "test" löschen?
$langFile['PAGESETUP_CATEGORY_TEXT_DELETECATEGORY_QUESTION_END']          = '?';

$langFile['PAGESETUP_CATEGORY_TEXT_MOVECATEGORY_MOVED']                   = 'Categoria spostata';
$langFile['PAGESETUP_CATEGORY_TIP_MOVECATEGORY_UP']                       = 'Sposta verso l&#145;alto questa categoria';
$langFile['PAGESETUP_CATEGORY_TIP_MOVECATEGORY_DOWN']                     = 'Spostare verso il basso questa categoria';

$langFile['PAGESETUP_CATEGORY_ERROR_CREATECATEGORY']                      = '<b>Impossibile creare nuova categoria.</b>'.$langFile['ERROR_SAVE_FOLDER_PART1'].'%sconfig/'.$langFile['ERROR_FOLDER_PART2'];
$langFile['PAGESETUP_CATEGORY_ERROR_CREATEDIR']                           = '<b>Impossibile creare la cartella nuova categoria.</b>'.$langFile['ERROR_SAVE_FOLDER_PART1'].'%spages/'.'&quot; Ordners.';
$langFile['PAGESETUP_CATEGORY_ERROR_DELETECATEGORY']                      = '<b>Impossibile eliminare la categoria.</b>'.$langFile['ERROR_SAVE_FILE'].'%sconfig/category.config.php';
$langFile['PAGESETUP_CATEGORY_ERROR_DELETEDIR']                           = '<b>Impossibile eliminare la directory della categoria.</b>'.$langFile['ERROR_SAVE_FOLDER_PART1'].'%spages/'.$langFile['ERROR_FOLDER_PART2'];
$langFile['PAGESETUP_CATEGORY_ERROR_SAVE']                                = $langFile['ERROR_SAVE_SETTINGS'].$langFile['ERROR_SAVE_FILE'].'%sconfig/category.config.php';


$langFile['PAGESETUP_CATEGORY_TITLE_ADVANCEDSETTINGS']                    = 'Impostazioni-Avanzate';
$langFile['PAGESETUP_CATEGORY_HINT_ADVANCEDSETTINGS']                     = 'Se le informazioni qui inserite sono correttamente impostate, puoi continuare a sovrascriverci sopra editando il foglio di stile alla voce '.$langFile['adminSetup_editorSettings_h1'].' da <a href="?site=adminSetup">impostazioni-amministratore</a>.';

$langFile['PAGESETUP_CATEGORY_TIP_STYLESHEETS_EMPTY']                     = 'Se questo campo è vuoto, le informazioni del foglio di stile possono essere editate dalle '.$langFile['adminSetup_editorSettings_h1'].' e utilizzate come foglio di stile corrente per il tuo sito web.';

$langFile['PAGESETUP_CATEGORY_TEXT_CATEGORYSTATUS']                       = 'Stato Della Categoria';
$langFile['PAGESETUP_CATEGORY_TIP_CATEGORYSTATUS']                        = 'Specifica se la categoria è visibile sul sito e quindi reperibile in rete.';
$langFile['PAGESETUP_CATEGORY_TEXT_CREATEPAGES']                          = 'Creare Cancella Pagine';
$langFile['PAGESETUP_CATEGORY_TIP_CREATEPAGES']                           = 'Specifica se l&#145;utente può creare o cancellare le pagine in questa categoria.';
$langFile['PAGESETUP_CATEGORY_TEXT_UPLOADTHUMBNAILS']                     = 'Caricare Miniature';
$langFile['PAGESETUP_CATEGORY_TIP_UPLOADTHUMBNAILS']                      = 'Specifica se l&#145;utente può caricare le miniature delle pagine in questa categoria.';
$langFile['PAGESETUP_CATEGORY_TEXT_EDITTAGS']                             = 'Modificare I Tag';
$langFile['PAGESETUP_CATEGORY_TIP_EDITTAGS']                              = 'Specifica se l&#145;utente può modificare i tag nella pagine in questa categoria.[br]'.$langFile['PAGESETUP_PAGES_TIP_TAG'];
$langFile['PAGESETUP_CATEGORY_TEXT_ACTIVATEPLUGINS']                      = 'Attivare Plugin';
$langFile['PAGESETUP_CATEGORY_TIP_ACTIVATEPLUGINS']                       = 'Specifica se l&#145;utente può utilizzare i plugin nelle pagine in questa categoria.';

$langFile['PAGESETUP_TEXT_EDITPAGEDATE']                                  = 'Modificare Date';
$langFile['PAGESETUP_TIP_EDITPAGEDATE']                                   = 'La data nelle pagina può essere utilizzata per ordinarle in base alla loro pubblicazione';
$langFile['PAGESETUP_TEXT_PAGEDATERANGE']                                 = 'come periodo';

$langFile['PAGESETUP_TEXT_FEEDS']                                         = 'Attivare Feeds';
$langFile['PAGESETUP_TIP_FEEDS']                                          = 'Attiva RSS 2.0 e Atom Feed per le pagine senza categoria.';
$langFile['PAGESETUP_CATEGORY_TIP_FEEDS']                                 = 'Attiva RSS 2.0 e Atom Feed per le pagine in questa categoria.';

$langFile['PAGESETUP_TEXT_SUBCATEGORY']                                   = 'Modificare le sottocategorie';
$langFile['PAGESETUP_TIP_SUBCATEGORY']                                    = 'Permette di scegliere una sottocategoria per ogni pagina.';

$langFile['PAGESETUP_TIP_SORTBYPAGEDATE']                                 = 'Ordinare Per Data';
$langFile['PAGESETUP_TIP_SORTBYDATE']                                     = 'Le pagine con una data più recente appariranno in [strong]testa[/strong] alla lista delle pagine.[br][br][span class=hint]Usa questa impostazione per inserire le pagine in ordine di creazione.[/span]';

$langFile['PAGESETUP_TEXT_SORTMANUALLY']                                  = 'Ordinare Manualmente';
$langFile['PAGESETUP_TIP_SORTMANUALLY']                                   = 'Le Pagine appena create, appariranno sempre [strong]in cima[/strong] alla lista delle pagine.';

$langFile['PAGESETUP_TEXT_SORTALPHABETICAL']                              = 'Ordinare Alfabeticamente';
$langFile['PAGESETUP_TIP_SORTALPHABETICAL']                               = '[span class=hint]Usa questa impostazione per inserire le pagine in ordine alfabetico.[/span]';

$langFile['PAGESETUP_TEXT_SORTREVERSE']                                   = 'Ordine Inverso';
$langFile['PAGESETUP_TIP_SORTREVERSE']                                    = 'Inverti l&#145;ordine delle pagine.';


/*
* websiteSetup.php
*/

// ---------- WEBSITE SETUP (on toolTips tooTips.js converts the "[" and "]" tags in the tittle attribute to "<" ">")
$langFile['websiteSetup_websiteConfig_error_save']                        = $langFile['ERROR_SAVE_SETTINGS'].$langFile['ERROR_SAVE_FILE'].'%sconfig/website.config.php';

$langFile['websiteSetup_websiteConfig_h1']                                = 'Impostazioni-SitoWeb';
$langFile['websiteSetup_websiteConfig_field1']                            = 'Titolo Sito Web';
$langFile['websiteSetup_websiteConfig_field1_tip']                        = 'Il titolo del sito web verrà mostrato nella barra del browser.';
$langFile['websiteSetup_websiteConfig_field2']                            = 'Editore Publisher';
$langFile['websiteSetup_websiteConfig_field2_tip']                        = 'Nome organizzazione, compagnia, persona, che pubblicano sul sito.';
$langFile['websiteSetup_websiteConfig_field3']                            = 'Copyright';
$langFile['websiteSetup_websiteConfig_field3_tip']                        = 'Il titolare del copyright di tutti i contenuti del sito web.';

$langFile['websiteSetup_websiteConfig_field4']                            = 'Parole Chiave';
$langFile['websiteSetup_websiteConfig_field4_tip']                        = 'La maggior parte dei motori di ricerca inseguono i contenuti del sito per parole chiave, tuttavia qui è possibile elencare alcune parole chiave che saranno memorizzate nei tag <meta> delle pagine web.';
$langFile['websiteSetup_websiteConfig_field4_inputTip']                   = 'Parole Chiave Separate Da &quot;,&quot;::'.$langFile['TEXT_EXAMPLE'].':[br]stichwort1,stichwort2,etc';
$langFile['websiteSetup_websiteConfig_field5']                            = 'Descrizione Sito Web';
$langFile['websiteSetup_websiteConfig_field5_tip']                        = 'Inserire qui una breve descrizione per l&#145;uso dei motori di ricerca, se lo SearchWords è stato trovato nell&#145;URL del sito web e non nel contenuto verrà mostrato come titolo di anteprima dal motore di ricerca.';
$langFile['websiteSetup_websiteConfig_field5_inputTip']                   = 'Testo Breve Non Più Di 3 Linee.';

$langFile['WEBSITESETUP_TITLE_PAGESETTINGS']                              = 'Impostazioni-Avanzate-SitoWeb';
$langFile['WEBSITESETUP_TEXT_MAINTENANCE']                                = 'Disattivare sito web';
$langFile['WEBSITESETUP_TIP_MAINTENANCE']                                 = 'Mostra un messaggio invece del sito, che dice che il sito è attualmente in fase di modifica.';
$langFile['WEBSITESETUP_TEXT_SITEMAPFILES']                               = 'Creare file Sitemap (<a href="http://www.sitemaps.org/" target="_blank">Dettagli</a>)';
$langFile['WEBSITESETUP_TIP_SITEMAPFILES']                                = 'I file sitemap semplificare i motori di ricerca di indicizzare il sito.';
$langFile['WEBSITESETUP_TEXT_VISITORTIMEZONE']                            = 'Prendi Fuso orario visitatori';
$langFile['WEBSITESETUP_TIP_VISITORTIMEZONE']                             = 'Cercare di ottenere il fuso orario del visitatore, per visualizzare le comunicazioni in tempo l&#145;ora locale del visitatore.[br][br][span class=hint]Il sito verrà ricaricato alla prima visita.[/span]';
$langFile['WEBSITESETUP_TEXT_MULTILANGUAGEWEBSITE']                       = 'Sito web multi lingua';
$langFile['WEBSITESETUP_TEXT_MAINLANGUAGE']                               = 'Lingua principale';
$langFile['WEBSITESETUP_TIP_MAINLANGUAGE']                                = 'La lingua principale sarà selezionato, se non la lingua di corrispondenza è stato possibile determinare automaticamente.';
$langFile['WEBSITESETUP_TEXT_DATEFORMAT']                                 = 'Formato Data';
$langFile['WEBSITESETUP_TIP_DATEFORMAT']                                  = 'Che viene utilizzato nella sito Web.';


/*
* statisticSetup.php
*/

// ---------- STATISITC SETUP (on toolTips tooTips.js converts the "[" and "]" tags in the tittle attribute to "<" ">")
$langFile['STATISTICSSETUP_ERROR_SAVE']                                   = $langFile['ERROR_SAVE_SETTINGS'].$langFile['ERROR_SAVE_FILE'].'%sconfig/statistic.config.php';

$langFile['STATISTICSSETUP_TITLE_STATISTICSSETTINGS']                     = 'Impostazioni-Statistiche';
$langFile['STATISTICSSETUP_TEXT_REFERERNUMBER']                           = '<b>Referrer-URLs</b>';
$langFile['STATISTICSSETUP_TIP_REFERERNUMBER']                            = 'Numero di Referrer-URLs. Specifica la quantità di Referrer-URLs ([i]URLs che hanno portato al sito[/i]) da visualizzare. Questi dati verranno salvati e inserito nella pagina Cruscotto.';
$langFile['STATISTICSSETUP_TEXT_ACTIVITYNUMBER']                          = '<b>Log-Attività</b>';
$langFile['STATISTICSSETUP_TIP_ACTIVITYNUMBER']                           = 'Numero di Log-Attività. Specifica la quantità di attività svolte nel sito da visualizzare. Questo dato sarà salvato in un log e i dati inseriti a lato del Cruscotto.';


$langFile['statisticSetup_clearStatistic_h1']                             = 'Elimina-Statistiche';
$langFile['statisticSetup_clearStatistics_websiteStatistic']              = 'Statistiche-SitoWeb';
$langFile['statisticSetup_clearStatistics_websiteStatistic_tip']          = '[strong]Contiene[/strong][ul][li]Numero totale di visite[/li][li]Numero totale di web-crawler[/li][li]Data della prima visita[/li][li]Data dell&#145;ultima visita[/li][li]Browser spectrum[/li][/ul]';
$langFile['statisticSetup_clearStatistics_pagesStatistic']                = 'Statistiche-Pagina';
$langFile['statisticSetup_clearStatistics_pagesStatistic_tip']            = '[strong]Contiene[/strong][ul][li]Numero di visite della pagina[/li][li]Data della prima visita[/li][li]Data dell&#145;ultima visita[/li][li]La durata della visita più breve[/li][li]La durata della visita più lunga[/li][li]Parole chiave che portano al sito[/li][/ul]';
$langFile['statisticSetup_clearStatistics_pagesStaylengthStatistics']     = 'Statistiche-Length-Of-Stay';
$langFile['statisticSetup_clearStatistics_pagesStaylengthStatistics_tip'] = 'Elimina l&#145;elenco della pagina Length-Of-Stay';
$langFile['statisticSetup_clearStatistics_refererLog']                    = 'Referrer-URLs Log'; // engl.: referer
$langFile['statisticSetup_clearStatistics_refererLog_tip']                = 'Elimina l&#145;elenco di tutti gli URL che hanno portato a questo sito.';
$langFile['statisticSetup_clearStatistics_taskLog']                       = 'Activities-Log';
$langFile['statisticSetup_clearStatistics_taskLog_tip']                   = 'Elimina l&#145;elenco delle ultime attività.';

$langFile['statisticSetup_clearStatistics_question_h1']                   = 'Sei sicuro di voler cancellare queste statistiche?';

$langFile['statisticSetup_clearStatistic_pagesStatistics_error_read']     = 'Errore durante l&#145;eliminazione delle statistiche della pagina.'.$langFile['ERROR_SAVE_FOLDER_PART1'].'%sstatistics/pages/'.$langFile['ERROR_FOLDER_PART2'];

/*
* userSetup.php
*/

$langFile['USERSETUP_h1']                                                 = 'Gestione-Utenti';
$langFile['USERSETUP_userSelection']                                      = 'Utenti';

$langFile['USERSETUP_createUser']                                         = 'Crea un nuovo utente';
$langFile['USERSETUP_createUser_created']                                 = 'Nuovo utente creato';
$langFile['USERSETUP_createUser_unnamed']                                 = 'Inserisci Info';

$langFile['USERSETUP_deleteUser']                                         = 'Elimina Utente';
$langFile['USERSETUP_deleteUser_deleted']                                 = 'Utente Cancellato';

$langFile['USERSETUP_username']                                           = 'Nome Utente';
$langFile['USERSETUP_username_missing']                                   = 'Non c&#145;è ancota un Nome Utente.';
$langFile['USERSETUP_password']                                           = 'Password';
$langFile['USERSETUP_password_change']                                    = 'Cambia Password';
$langFile['USERSETUP_password_confirm']                                   = 'Conferma Password';
$langFile['USERSETUP_password_confirm_wrong']                             = 'Le due password non corrispondono.';
$langFile['USERSETUP_password_missing']                                   = 'Non c&#145;è ancora nessuna password impostata.';
$langFile['USERSETUP_password_success']                                   = 'Password modificata correttamente!';
$langFile['USERSETUP_email']                                              = 'E-Mail';
$langFile['USERSETUP_email_tip']                                          = 'Se l&#145;utente ha dimenticato la propria password, una nuova password verrà inviata a questo indirizzo e-mail.';

$langFile['USERSETUP_admin']                                              = 'Amministratore';
$langFile['USERSETUP_admin_tip']                                          = 'Determina se l&#145;utente disporrà dei diritti di amministrazione.';

$langFile['USERSETUP_error_create']                                       = '<b>Un nuovo utente non può essere creato.</b>'.$langFile['ERROR_SAVE_FILE'].'%sconfig/user.config.php';
$langFile['USERSETUP_error_save']                                         = $langFile['ERROR_SAVE_SETTINGS'].$langFile['ERROR_SAVE_FILE'].'%sconfig/user.config.php';

// ---------- USER PERMISSION
$langFile['USERSETUP_USERPERMISSIONS_TITLE']                              = 'Autorizzazioni-Utente';
$langFile['USERSETUP_USERPERMISSIONS_TEXT_ACTIVATEWEBSITESETTINGS']       = 'Modificare Impostazioni-SitoWeb';
$langFile['USERSETUP_USERPERMISSIONS_TEXT_EDITWEBSITEFILES']              = 'Modificare i files dalle <a href="index.php?site=websiteSetup">Impostazioni-SitoWeb</a>';
$langFile['USERSETUP_USERPERMISSIONS_TEXT_EDITSTYLESHEETS']               = 'Modificare i files fogli di stile in <a href="index.php?site=websiteSetup">Impostazioni-SitoWeb</a>';
$langFile['USERSETUP_USERPERMISSIONS_TEXT_EDITSNIPPETS']                  = 'Modifica frammenti di codice nel <a href="index.php?site=websiteSetup">Impostazioni-SitoWeb</a>';
$langFile['USERSETUP_USERPERMISSIONS_TEXT_FILEMANAGER']                   = 'Attivare il file manager';
$langFile['USERSETUP_USERPERMISSIONS_TEXT_FRONTENDEDITING']               = 'Attivare la modifica frontale';

$langFile['USERSETUP_USERPERMISSIONS_TEXT_USERINFORMATION']               = '<strong>Informazioni Utente</strong> in <a href="?site=dashboard">'.$langFile['BUTTON_DASHBOARD'].'</a>';
$langFile['USERSETUP_USERPERMISSIONS_TIP_USERINFORMATION']                = 'Informazioni Utente::Questo testo verrà visualizzato nel '.$langFile['BUTTON_DASHBOARD'].' della pagina di [span class=feinduraInline]fein[em]dura[/em][/span].';
$langFile['USERSETUP_USERPERMISSIONS_TIP_USERINFORMATION_NOINFO']         = 'Se non si desidera visualizzare le informazioni per l&#145;utente, lasciare questo campo vuoto';

$langFile['USERSETUP_USERPERMISSIONS_TITLE_EDITABLECATEGORIES-PAGES']     = 'Selezionare Categorie e pagine che l&#145;utente dovrebbe essere grado di modificare. (Se non è selezionata, tutto può essere modificato)';
$langFile['USERSETUP_USERPERMISSIONS_TEXT_CLEARSELECTION']                = 'Cancella selezione';

/*
* editor.php
*/

// ---------- page info
$langFile['EDITOR_TITLE_CREATEPAGE']                                      = 'Crea una nuova pagina';
$langFile['EDITOR_TITLE_ADDLANGUAGE']                                     = 'Aggiungi lingua &quot;%s&quot; alla pagina';
$langFile['EDITOR_pageinfo_lastsavedate']                                 = 'Ultima modifica al';
$langFile['EDITOR_pageinfo_lastsaveauthor']                               = 'di';
$langFile['EDITOR_pageinfo_linktothispage']                               = 'Collegamento a questa pagina';
$langFile['EDITOR_pageinfo_id']                                           = 'ID Pagina';
$langFile['EDITOR_pageinfo_id_tip']                                       = 'La pagina verrà salvata con questo ID sul server.';
$langFile['EDITOR_pageinfo_category']                                     = 'Categoria';
$langFile['EDITOR_pageinfo_category_noCategory']                          = 'nessuna categoria';

$langFile['EDITOR_TEXT_CHOOSETEMPLATE']                                   = 'Usa modello';
$langFile['EDITOR_TEXT_TEMPALATECOPYADDITION']                            = 'copiare';

$langFile['EDITOR_block_edited']                                          = 'sono stati modificati';
$langFile['EDITOR_pageNotSaved']                                          = 'non è stata salvata';

$langFile['EDITOR_EDITLINK']                                              = 'Modifica il link';

// ---------- page settings
$langFile['EDITOR_pagestatistics_h1']                                     = 'Statistiche';

$langFile['EDITOR_pageSettings_title']                                    = 'Titolo';
$langFile['EDITOR_pageSettings_title_tip']                                = 'Il titolo della pagina, può contenere i seguenti tag HTML:[br]<a> <span> <em> <strong> <i> <b> <abbr> <code> <samp> <kbd> <var>';
$langFile['EDITOR_pageSettings_field1']                                   = 'Breve descrizione';
$langFile['EDITOR_pageSettings_field1_inputTip']                          = 'Se vuoto, utilizza la descrizione nel tag del sito  dalle Impostazioni-SitoWeb.';
$langFile['EDITOR_pageSettings_field1_tip']                               = 'Una breve sintesi del contenuto della pagina. Questa descrizione sarà utilizzata nella meta-tag della pagina.[br][br][span class=hint]'.$langFile['EDITOR_pageSettings_field1_inputTip'].'[/span]';
$langFile['EDITOR_pageSettings_field2']                                   = 'Tags';
$langFile['EDITOR_pageSettings_field2_tip']                               = 'I tag sono parole chiave che fanno da riferimento per questa pagina.';
$langFile['EDITOR_pageSettings_field2_tip_inputTip']                      = 'I tag devono essere separati da una &quot;,&quot; (virgola).';
$langFile['EDITOR_pageSettings_field3']                                   = 'Pagedate';
$langFile['EDITOR_pageSettings_field3_tip']                               = 'La data può essere utilizzata per ordinare le pagine in base al tempo della sua creazione. (ad esempio in occasione di eventi)';
$langFile['EDITOR_pageSettings_field4']                                   = 'Stato della pagina';
$langFile['EDITOR_pageSettings_field4_tip']                               = '[strong]Solo quando la pagina è pubblica, sarà visualizzata sul Web![/strong]';

$langFile['EDITOR_PAGESETTINGS_NOPAGEDATE']                               = 'Senza data';

$langFile['EDITOR_TEXT_SUBCATEGORY']                                      = 'Sottocategoria';
$langFile['EDITOR_TIP_SUBCATEGORY']                                       = 'Permette di creare un menù secondario per questa pagina nel sito.';

$langFile['EDITOR_BUTTON_RESTORELASTSTATE']                               = 'Ripristinare la versione di %s';
$langFile['EDITOR_MESSAGE_RESTOREDTOLASTSTATE']                           = 'Versione di %s restaurata.';

// ---------- page advanced settings
$langFile['EDITOR_advancedpageSettings_h1']                               = 'Pagina specifica impostazioni-Editor-HTML';

$langFile['EDITOR_advancedpageSettings_field1']                           = 'Pagina stylesheet-file';
$langFile['EDITOR_advancedpageSettings_stylesheet_ifempty']               = 'Quando tutti i campi sono vuoti, verra utilizzato la prima impostazione del foglio di stile, la categoria sarà utilizzata anche se il foglo di stile è vuoto e potra essere editato con l&#145;editor HTML delle impostazioni.';

$langFile['EDITOR_htmleditor_hotkeys_h1']                                 = 'Tasti di scelta rapida';
$langFile['EDITOR_htmleditor_hotkeys_field1']                             = 'seleziona tutto';
$langFile['EDITOR_htmleditor_hotkeys_field2']                             = 'copia';
$langFile['EDITOR_htmleditor_hotkeys_field3']                             = 'incolla';
$langFile['EDITOR_htmleditor_hotkeys_field4']                             = 'taglia';
$langFile['EDITOR_htmleditor_hotkeys_field5']                             = 'undo';
$langFile['EDITOR_htmleditor_hotkeys_field6']                             = 'redo';
$langFile['EDITOR_htmleditor_hotkeys_field7']                             = 'set link';
$langFile['EDITOR_htmleditor_hotkeys_field8']                             = 'bold';
$langFile['EDITOR_htmleditor_hotkeys_field9']                             = 'italic';
$langFile['EDITOR_htmleditor_hotkeys_field10']                            = 'underline';
$langFile['EDITOR_htmleditor_hotkeys_or']                                 = 'oppure';

$langFile['EDITOR_savepage_error_save']                                   .= $langFile['ERROR_SAVE_FOLDER_PART1'].'%spages/'.$langFile['ERROR_FOLDER_PART2'];// also in en.shared.php

// ---------- plugin settings
$langFile['EDITOR_pluginSettings_h1']                                     = 'Aggiungi Plugin';
$langFile['EDITOR_TEXT_EDITPLUGINSINEDITOR']                              = 'Dopo aver attivato un plugin, passa il mouse sopra il plugin di essere possibile trascinare nell&#145;editor HTML, o posizionare direttamente nell&#145;editor HTML, usando l&#145;icona %s.';
$langFile['EDITOR_MESSAGE_PLUGINSSAVED']                                  = '<div class="alert alert-success">Plugins salvato!</div>';//<div class="alert">Click on un plugin per modificarne le proprietà.</div>';
$langFile['EDITOR_TIP_DRAGPLUGIN']                                        = 'Trascinare il plugin nell&#145;editor.';


/*
* unsavedPage.php
*/

$langFile['UNSAVEDPAGE_QUESTION_CONTINUE']                                = 'La pagina è stata modificata!<br><span class="brown">Vuoi continuare?</span>';

/*
* deletePage.php
*/

// ---------- DELETE PAGE
$langFile['deletePage_question_part1']                                    = 'Sei sicuro di voler eliminare la pagina';
$langFile['deletePage_question_part2']                                    = '?';

$langFile['deletePage_notexisting_part1']                                 = 'La pagina';
$langFile['deletePage_notexisting_part2']                                 = 'non esiste';

$langFile['deletePage_finish_error']                                      = 'ERRORE: La pagina non può essere cancellata!';

/*
* deletePageLanguage.php
*/

// ---------- DELETE PAGE LANGUAGE

$langFile['WINDOWBOX_TEXT_DELETEPAGELANGUAGE_QUESTION']                   = 'Sei sicuro di voler eliminare il lingua &quot;%s&quot; per questa pagina?';


/*
* addPageLanguage.php
*/

// ---------- ADD PAGE LANGUAGE

$langFile['WINDOWBOX_TEXT_ADDPAGE_SELECTLANGUAGE']                        = 'Seleziona la lingua';


/*
* deletewebsiteLanguages.php
*/

// ---------- DELETE WEBSITE LANGUAGES

$langFile['WINDOWBOX_TITLE_DELETEWEBSITELANGUAGES_QUESTION']              = 'Le seguenti lingue verranno eliminate da tutte le pagine!<br>&quot;%s&quot;';
$langFile['WINDOWBOX_TEXT_DELETEWEBSITELANGUAGES_QUESTION']               = 'Sito multilingue è stato disattivato!<br>Tutte le pagine verrà impostata la lingua principale precedente (<b>%s</b>).';


/*
* deletePageThumbnail.php
*/

// ---------- PAGE THUMBNAIL DELETE
$langFile['PAGETHUMBNAIL_TEXT_DELETE_QUESTION_START']                     = 'Sei sicuro di voler cancellare la miniatura della pagina';
$langFile['PAGETHUMBNAIL_TEXT_DELETE_QUESTION_END']                       = '?';
$langFile['PAGETHUMBNAIL_ERROR_DELETE']                                   = 'ERRORE: La miniatura non può essere cancellata!';


/*
* uploadPageThumbnail.php
*/

// ---------- PAGE THUMBNAIL UPLOAD
$langFile['pagethumbnail_h1_part1']                                       = 'Carica miniatura della pagina di';
$langFile['pagethumbnail_h1_part2']                                       = '';
$langFile['pagethumbnail_field1']                                         = 'Seleziona immagine';

$langFile['pagethumbnail_thumbinfo_formats']                              = 'Solo i seguenti formati di file sono autorizzati'; //<br><b>JPG</b>, <b>JPEG</b>, <b>GIF</b>, <b>PNG</b>
$langFile['pagethumbnail_thumbinfo_filesize']                             = 'file di dimensione massima';
$langFile['pagethumbnail_thumbinfo_standardthumbsize']                    = 'Dimensioni immagine standard';

$langFile['pagethumbnail_thumbsize_h1']                                   = 'Impostare la dimensione immagine manualmente';
$langFile['pagethumbnail_thumbsize_width']                                = 'Larghezza';
$langFile['pagethumbnail_thumbsize_height']                               = 'Altezza';

$langFile['pagethumbnail_submit_tip']                                     = 'Carica immagine';

$langFile['PAGETHUMBNAIL_ERROR_nofile']                                   = 'Non hai selezionato un file.';
$langFile['PAGETHUMBNAIL_ERROR_nouploadedfile']                           = 'Nessun file è stato caricato.';
$langFile['PAGETHUMBNAIL_ERROR_filesize']                                 = 'La dimensione del file di immagine caricata è probabilmente troppo grande.<br>La dimensione massima del file è';
$langFile['PAGETHUMBNAIL_ERROR_wrongformat']                              = 'Il file selezionato ha un formato non supportato';
$langFile['PAGETHUMBNAIL_ERROR_NODIR_START']                              = 'Cartella anteprima'; // The thumbnail-folder..
$langFile['PAGETHUMBNAIL_ERROR_NODIR_END']                                = 'non esiste.';
$langFile['PAGETHUMBNAIL_ERROR_CREATEDIR_END']                            = 'non può essere creata.';
$langFile['PAGETHUMBNAIL_ERROR_COULDNTMOVEFILE']                          = 'Impossibile spostare il file caricato nella cartella delle miniature %s.';
$langFile['PAGETHUMBNAIL_ERROR_CHANGEIMAGESIZE']                          = 'Impossibile ridimensionare l&#145;immagine.';
$langFile['PAGETHUMBNAIL_ERROR_deleteoldfile']                            = 'Impossibile eliminare le vecchie minuature.';
$langFile['PAGETHUMBNAIL_TEXT_fileexists']                                = 'Un immagine con questo nome esiste già.<br>Il file caricato è stato rinominato';
$langFile['PAGETHUMBNAIL_TEXT_finish']                                    = 'Immagine caricata con successo.';

// -> BACKUP

$langFile['BACKUP_TITLE_BACKUP']                                          = 'Backup';
$langFile['BACKUP_TITLE_RESTORE']                                         = 'Ripristina';

$langFile['BACKUP_TITLE_RESTORE_FROMFILES']                               = 'Scegli un backup esistente';
$langFile['BACKUP_TITLE_RESTORE_FROMUPLOAD']                              = 'Carica file di backup';

$langFile['BACKUP_TEXT_RESTORE_BACKUPBEFORERESTORE']                      = 'Backup prima del ripristino';

$langFile['BACKUP_BUTTON_DOWNLOAD']                                       = 'crea backup corrente';
$langFile['BACKUP_TEXT_BACKUP']                                           = 'Un backup crea una cartella in un file <code>nomefile.zip</code> con le <span class="blue">"pages","config"</span> e i <span class="blue">"statistic"</span> I backup servono per ripristinare uno stato precedente dell&#145;intero sito web.<br><strong>ATTENZIONE</strong>. La cartella di upload non verrà salvata nel backup ma dovrà essere salvata via FTP.';
$langFile['BACKUP_TEXT_RESTORE']                                          = '<p>Seleziona qui un <span class="feinduraName"><span>fein</span>dura</span> backup file, per ripristinare uno stato precedente.</p><div class="alert"><strong>Suggerimento</strong> Un backup dello stato attuale verrà creato prima di quello del ripristino.</div>';
$langFile['BACKUP_TOOLTIP_DELETE']                                        = 'Elimina backup';
$langFile['BACKUP_TEXT_DELETE_QUESTION']                                  = 'Vuoi davvero cancellare questo %s?'; // really delete backup 2010-11-05 15:03?

$langFile['BACKUP_TITLE_LASTBACKUPS']                                     = 'Scarica i backups';
$langFile['BACKUP_TEXT_NOBACKUP']                                         = 'Nessun backup è stato ancora creato.';

$langFile['BACKUP_ERROR_FILENOTFOUND']                                    = 'Il backup non è stato trovato:';
$langFile['BACKUP_ERROR_NORESTROEFILE']                                   = 'Nessun file di backup da ripristinare è stato selezionato.';
$langFile['BACKUP_ERROR_DELETE']                                          = 'Il backup non può essere cancellato!';

// -> ADDONS

$langFile['ADDONS_TITLE_ADDON']                                           = 'Selezionare un <span class="feinduraInline">fein<em>dura</em></span> Add-on';
$langFile['ADDONS_TEXT_AUTHOR']                                           = 'Autore';
$langFile['ADDONS_TEXT_WEBSITE']                                          = 'Sito web';
$langFile['ADDONS_TEXT_VERSION']                                          = 'Versione';
$langFile['ADDONS_TEXT_REQUIREMENTS']                                     = 'Requisiti';


// -> UPDATE

$langFile['UPDATE_TITLE']                                                 = 'I contenuti devono essere aggiornati';
$langFile['UPDATE_TEXT_CHECKPATHS']                                       = 'Assicurarsi che i percorsi siano corretti prima di aggiornare.';
$langFile['UPDATE_TEXT_BASEPATH']                                         = 'Percorso per il <span class="feinduraInline">fein<em>dura</em> </span>';
$langFile['UPDATE_TEXT_WEBSITEPATH']                                      = 'Percorso del sito web';
$langFile['UPDATE_TEXT_SUCCESS']                                          = 'Contenuto aggiornato con successo';
$langFile['UPDATE_BUTTON_UPDATE']                                         = 'AGGIORNA';
$langFile['UPDATE_ERROR_MOVEUPLOADFOLDER']                                = 'Carica cartella non può essere spostato! Si prega di spostare la cartella "%s" manualmente "your_feindura_folder/upload/".';
$langFile['UPDATE_ERROR_MOVEPAGESFOLDER']                                 = 'Le pagine non possono essere copiate! Si prega di spostare la cartella "%s" manualmente "your_feindura_folder/pages/".';
$langFile['UPDATE_ERROR_SAVEADMINCONFIG']                                 = 'Impostazioni amministratore non può essere aggiornata.';
$langFile['UPDATE_ERROR_SAVECATEGORYCONFIG']                              = 'Impostazioni di categoria non può essere aggiornata.';
$langFile['UPDATE_ERROR_SAVEUSERCONFIG']                                  = 'Impostazioni utente non può essere aggiornata.';
$langFile['UPDATE_ERROR_SAVEWEBSITECONFIG']                               = 'Impostazioni sito web non può essere aggiornata.';
$langFile['UPDATE_ERROR_SAVEPAGES']                                       = 'Le pagine non può essere aggiornata.';
$langFile['UPDATE_ERROR_CLEARACTIVITYLOG']                                = 'Registro attività non può essere cancellato.';
$langFile['UPDATE_ERROR_SAVEWEBSITESTATISTICS']                           = 'Statistiche del sito web non può essere aggiornata.';
$langFile['UPDATE_ERROR_SAVEREFERERLOG']                                  = 'Log Referer non può essere aggiornata.';
$langFile['UPDATE_ERROR_DELETEOLDFILES']                                  = 'Impossibile rimuovere i file vecchi e cartelle, <br> Si prega di verificare i file e cartelle, e rimuovere manualmente:';
$langFile['UPDATE_ERROR_RENAMESTATISTICSFOLDER']                          = 'Couldn\'t rename the "feinduraFolder/statistic" folder "feinduraFolder/statistic<strong>s</strong>, please rename it manually!"';

// -----------------------------------------------------------------------------------------------
// RETURN ****************************************************************************************
// -----------------------------------------------------------------------------------------------
return $langFile;
