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
 *    - TOOLTIP 
 * 
 * need a RETURN $langFile; at the END
 */

// -> LOGIN <-

$langFile['LOGIN_INPUT_USERNAME']                               = 'Nome Utente';
$langFile['LOGIN_INPUT_PASSWORD']                               = 'Password';
$langFile['LOGIN_BUTTON_LOGIN']                                 = 'ACCESSO';
$langFile['LOGIN_TEXT_COOKIESNEEDED']                           = 'I cookies devono essere attivati';

$langFile['LOGIN_LINK_FORGOTPASSWORD']                          = 'Hai dimenticato la tua password?';
$langFile['LOGIN_LINK_BACKTOLOGIN']                             = 'Torna all\'accesso';
$langFile['LOGIN_BUTTON_SENDNEWPASSWORD']                       = 'INVIA';
$langFile['LOGIN_TEXT_NEWPASSWORDEMAIL_SUBJECT']                = 'Hai richiesto la password di feindura CMS da';
$langFile['LOGIN_TEXT_NEWPASSWORDEMAIL_MESSAGE']                = 'Hai richiesto una nuova password per il tuo feindura - Flat File CMS. 
                                                                Il tuo nome utente e la tua nuova password:';

$langFile['LOGIN_ERROR_FORGOTPASSWORD_NOEMAIL']                 = 'Utente senza indirizzo EMail.';
$langFile['LOGIN_ERROR_FORGOTPASSWORD_NOTSEND']                 = 'ERRORE<br> durante l\'invio della nuova password per l\'indirizzo email dell\'utente specificato';
$langFile['LOGIN_ERROR_FORGOTPASSWORD_NOTSAVED']                = 'ERRORE<br> Impossibile salvare la nuova password generata.';
$langFile['LOGIN_ERROR_FORGOTPASSWORD_SUCCESS']                 = 'Una nuova password è stata inviata al seguente indirizzo email';

$langFile['LOGIN_ERROR_WRONGUSER']                              = 'L\'utente non esiste';
$langFile['LOGIN_ERROR_WRONGPASSWORD']                          = 'password errata';

$langFile['LOGIN_TEXT_LOGOUT_PART1']                            = 'Disconnesso con successo';
$langFile['LOGIN_TEXT_LOGOUT_PART2']                            = 'entra nel tuo sito web';

$langFile['LOGIN_TIP_AUTOLOGOUT']                               = 'Sarai Disconnesso Tra';


// -> GENERAL <-

$langFile['DATE_INT']                                           = 'YYYY-MM-DD';
$langFile['DATE_EU']                                            = 'DD.MM.YYYY';
$langFile['CATEGORIES_TEXT_NONCATEGORY']                        = 'Pagine';
$langFile['CATEGORIES_TOOLTIP_NONCATEGORY']                     = 'Pagine Senza Categoria';
$langFile['TEXT_EXAMPLE']                                       = 'Esempio';

$langFile['HEADER_BUTTON_GOTOWEBSITE']                          = 'Editing Frontale::Clicca qui per modificare le pagine direttamente nel tuo sito web.';

// THUMBNAILS
$langFile['THUMBNAIL_TEXT_UNIT']                                = 'pixel';

$langFile['THUMBNAIL_TEXT_NAME']                                = 'Pagina-Miniatura';
$langFile['THUMBNAIL_TEXT_WIDTH']                               = 'Larghezza <b>Miniatura</b>';
$langFile['THUMBNAIL_TEXT_HEIGHT']                              = 'Altezza <b>Miniatura</b>';

$langFile['THUMBNAIL_TOOLTIP_WIDTH']                            = 'Larghezza Standard::La larghezza della miniatura è sempre misurata in pixels.[br /][br /]L\'immagine verrà ridimensionata a questo valore dopo il caricamento.';
$langFile['THUMBNAIL_TOOLTIP_HEIGHT']                           = 'Altezza Standard::L\'altezza della miniatura è sempre misurata in pixels.[br /][br /]L\'immagine verrà ridimensionata a questo valore dopo il caricamento.';

$langFile['THUMBNAIL_TEXT_RATIO']                               = 'Rapporto';
$langFile['THUMBNAIL_TEXT_KEEPRATIO']                           = 'mantenere questo rapporto';
$langFile['THUMBNAIL_TEXT_FIXEDRATIO']                          = 'rapporto manuale fisso';
$langFile['THUMBNAIL_TOOLTIP_FIXEDRATIO']                       = 'Larghezza e Altezza sono impostate manualmente';
$langFile['THUMBNAIL_TOOLTIP_KEEPRATIO_X']                      = 'Sarà allineata dalla [i]larghezza[/i].';
$langFile['THUMBNAIL_TOOLTIP_KEEPRATIO_Y']                      = 'Sarà allineata dall\' [i]altezza[/i].';

// STYLESHEETS
$langFile['STYLESHEETS_TEXT_STYLEFILE']                         = 'Files Fogli di stile';
$langFile['STYLESHEETS_TEXT_ID']                                = 'Id-Fogli di stile';
$langFile['STYLESHEETS_TEXT_CLASS']                             = 'Classe-Fogli di stile';

$langFile['STYLESHEETS_TOOLTIP_STYLEFILE']                      = 'Qui è possibile specificare i files dei fogli di stile, che verranno utilizzati per lo stile del contenuto dall\'editor HTML.';
$langFile['STYLESHEETS_TOOLTIP_ID']                             = 'Qui è possibile specificare un attributo-Id, che sarà aggiunto al tag <body> dall\'Editor-HTML.';
$langFile['STYLESHEETS_TOOLTIP_CLASS']                          = 'Qui è possibile specificare un attributo di classe, che sarà aggiunto al tag <body> dall\'Editor-HTML.';

$langFile['STYLESHEETS_TOOLTIP_ADDSTYLEFILE']                   = 'aggiungi un nuovo foglio di stile';
$langFile['STYLESHEETS_EXAMPLE_STYLEFILE']                      = '<b>Esempio</b> &quot;/style/layout.css&quot;';

// PATHS
$langFile['PATHS_TEXT_ABSOLUTE']                                = 'percorso assoluto';
$langFile['PATHS_TEXT_RELATIVE']                                = 'percorso relativo';
$langFile['PATHS_TOOLTIP_ABSOLUTE']                             = 'Percorso Assoluto';
$langFile['PATHS_TOOLTIP_RELATIVE']                             = 'Percorso Relativo';

// STATISTICS
$langFile['STATISTICS_TITLE_BROWSERCHART']                      = 'Il browser usato dagli utenti';
$langFile['STATISTICS_TEXT_ROBOTCOUNT']                         = 'web-crawler';
$langFile['STATISTICS_TOOLTIP_ROBOTCOUNT']                      = 'web-crawler::I Crawlers detti anche robots sono (programmi e algoritmi) che i motori di ricerca usano lanciandoli in rete per analizzare e indicizzare le pagine index dei siti web.';

$langFile['STATISTICS_TEXT_SEARCHWORD_PART1']                   = 'ha portato'; // "exampleword" led 20 times to this website
$langFile['STATISTICS_TEXT_SEARCHWORD_PART2']                   = 'volte a questo sito';
$langFile['STATISTICS_TOOLTIP_SEARCHWORD']                      = 'Clicca qui per la ricerca di questa parola nelle pagine.';

$langFile['STATISTICS_TEXT_VISITORCOUNT']                       = 'visitatori totali';
$langFile['STATISTICS_TEXT_CURRENTVISITORS']                    = 'visitatori correnti';
$langFile['STATISTICS_TEXT_LASTACTIVITY']                       = 'ultima attività';

$langFile['STATISTICS_TITLE_PAGESTATISTICS']                    = 'Statistiche Pagine';

$langFile['STATISTICS_TEXT_VISITTIME_MAX']                      = 'permanenza più lunga';
$langFile['STATISTICS_TEXT_VISITTIME_MIN']                      = 'permanenza più breve ';
$langFile['STATISTICS_TEXT_FIRSTVISIT']                         = 'prima visita';
$langFile['STATISTICS_TEXT_LASTVISIT']                          = 'ultima visita';
$langFile['STATISTICS_TEXT_NOVISIT']                            = 'Nessuno mai ancora ha visito questo sito.';
$langFile['STATISTICS_TEXT_SEARCHWORD_DESCRIPTION']             = 'Parole di ricerca che hanno portato da
                                                                <a href="http://www.google.de">Google</a>,
                                                                <a href="http://www.yahoo.de">Yahoo</a> or
                                                                <a href="http://www.bing.com">Bing (MSN)</a> a questo sito.';

$langFile['STATISTICS_TEXT_HOUR_SINGULAR']                      = 'ora';
$langFile['STATISTICS_TEXT_HOUR_PLURAL']                        = 'ore';
$langFile['STATISTICS_TEXT_MINUTE_SINGULAR']                    = 'minuto';
$langFile['STATISTICS_TEXT_MINUTE_PLURAL']                      = 'minuti';
$langFile['STATISTICS_TEXT_SECOND_SINGULAR']                    = 'secondo';
$langFile['STATISTICS_TEXT_SECOND_PLURAL']                      = 'secondi';

$langFile['STATISTICS_TEXT_BROWSERCHART_OTHERS']                = 'altro';

// LOG TEXTS
$langFile['LOG_PAGE_SAVED']                                     = 'Pagina salvata';
$langFile['LOG_PAGE_NEW']                                       = 'Nuova pagina creata';
$langFile['LOG_PAGE_DELETE']                                    = 'Pagina eliminata';

$langFile['LOG_PAGE_MOVEDINCATEGORY']                           = 'Spostare pagina alla categoria';
$langFile['LOG_PAGE_MOVEDINCATEGORY_CATEGORY']                  = 'nella categoria'; // Example Page in Category
$langFile['LOG_PAGE_SORTED']                                    = 'Ordinamento pagina modificata';

$langFile['LOG_THUMBNAIL_UPLOAD']                               = 'Nuova miniatura caricata';
$langFile['LOG_THUMBNAIL_DELETE']                               = 'Miniatura cancellata';

$langFile['LOG_USER_ADD']                                       = 'Nuovo utente creato';
$langFile['LOG_USER_DELETED']                                   = 'Utente cancellato';
$langFile['LOG_USER_PASSWORD_CHANGED']                          = 'Password utente cambiata';
$langFile['LOG_USER_SAVED']                                     = 'Utente salvato';

$langFile['LOG_ADMINSETUP_SAVED']                               = 'Impostazioni-Amministratore salvate';
$langFile['LOG_ADMINSETUP_CKSTYLES']                            = '&quot;Formattazione-Stili&quot; con Editor-HTML salvata';

$langFile['LOG_WEBSITESETUP_SAVED']                             = 'Impostazioni-Website salvate';

$langFile['LOG_STATISTICSETUP_SAVED']                           = 'Impostazioni-Statistiche salvate';
$langFile['LOG_CLEARSTATISTICS_WEBSITESTATISTIC']               = 'Statistiche-Website cancellate';
$langFile['LOG_CLEARSTATISTICS_PAGESTATISTICS']                 = 'Statistiche-Pagina cancellate';
$langFile['LOG_CLEARSTATISTICS_PAGESTAYLENGTH']                 = 'Statistica-Durata-Permanenza-Pagina cancellati';
$langFile['LOG_CLEARSTATISTICS_REFERERLOG']                     = 'Log-Referrer cancellato';
$langFile['LOG_CLEARSTATISTICS_ACTIVITYLOG']                    = 'Log-Ultime Attività cancellato';

$langFile['LOG_PAGESETUP_SAVED']                                = 'Impostazioni-Pagina salvate';
$langFile['LOG_PAGESETUP_CATEGORIES_SAVED']                     = 'Categorie salvate';

$langFile['LOG_PAGESETUP_CATEGORIES_NEW']                       = 'Nuova categora creata';
$langFile['LOG_PAGESETUP_CATEGORIES_DELETED']                   = 'Categoria cancellata';
$langFile['LOG_PAGESETUP_CATEGORIES_MOVED']                     = 'Categoria spostata';

$langFile['LOG_FILE_SAVED']                                     = 'File salvato';
$langFile['LOG_FILE_DELETED']                                   = 'File cancellato';

$langFile['LOG_BACKUP_CREATED']                                 = 'Backup creato';
$langFile['LOG_BACKUP_RESTORED']                                = 'Backup ripristinato';
$langFile['LOG_BACKUP_DELETED']                                 = 'Backup cancellato';

// PAGE/CATEGORY STATUS
$langFile['STATUS_PAGE_PUBLIC']                                 = 'Pagina Pubblica';
$langFile['STATUS_PAGE_NONPUBLIC']                              = 'Pagina Nascosta';

$langFile['STATUS_CATEGORY_PUBLIC']                             = 'Categora Pubblica';
$langFile['STATUS_CATEGORY_NONPUBLIC']                          = 'Categoria Nascosta';

// USER LIST
$langFile['USER_TEXT_NOUSER']                                   = 'Nessun Utente';
$langFile['USER_TEXT_CURRENTUSER']                              = 'Nome Utente Registrato';
$langFile['USER_TEXT_USERSONLINE']                              = 'Questo utente è loggato::Ultime attività';

$langFile['LOGO_TEXT']                                          = 'Versione';
$langFile['txt_logo_gotowebsite']                               = 'Clicca qui per entrare nel tuo sito web.';
$langFile['LOADING_TEXT_LOAD']                                  = 'Attendi che la pagina venga caricata..';

// CKEDITOR transport
$langFile['CKEDITOR_TITLE_LINKS']                               = 'pagine feindura';


// -> BUTTON TEXTS

// MAIN MENU
$langFile['BUTTON_DASHBOARD']                                   = 'Cruscotto';
$langFile['BUTTON_PAGES']                                       = 'Pagine';
$langFile['BUTTON_ADDONS']                                      = 'Addons';
$langFile['BUTTON_WEBSITESETTINGS']                             = 'Impostazioni';
$langFile['BUTTON_SEARCH'] = 'Ricerca Pagine';

// ADMIN MENU
$langFile['HEADER_TITLE_ADMINMENU']                             = 'Amministrazione';
$langFile['BUTTON_ADMINSETUP']                                  = 'Generale';
$langFile['BUTTON_PAGESETUP']                                   = 'Pagine';
$langFile['BUTTON_STATISTICSETUP']                              = 'Statistiche';
$langFile['BUTTON_USERSETUP']                                   = 'Utenti';
$langFile['BUTTON_BACKUP']                                      = 'Backups';

// SUB MENU/FOOTER
$langFile['BUTTON_FILEMANAGER']                                 = 'File Manager';
$langFile['BUTTON_TOOLTIP_FILEMANAGER']                         = 'Gestisci Files E Immagini';
$langFile['BUTTON_CREATEPAGE']                                  = 'Nuova Pagina';
$langFile['BUTTON_TOOLTIP_CREATEPAGE']                          = 'Crea Nuova Pagina';
$langFile['BUTTON_DELETEPAGE']                                  = 'Elimina Pagina';
$langFile['BUTTON_TOOLTIP_DELETEPAGE']                          = 'Elimina Questa Pagina';
$langFile['BUTTON_FRONTENDEDITPAGE']                            = 'Modifica Pagina Frontalmente';
$langFile['BUTTON_TOOLTIP_FRONTENDEDITPAGE']                    = 'Modifica Pagina Sul Sito.';
$langFile['BUTTON_THUMBNAIL_UPLOAD']                            = 'Carica Miniatura Nella Pagina';
$langFile['BUTTON_TOOLTIP_THUMBNAIL_UPLOAD']                    = 'Carica Miniatura';
$langFile['BUTTON_THUMBNAIL_DELETE']                            = 'Elimina Miniatura Della Pagina';
$langFile['BUTTON_TOOLTIP_THUMBNAIL_DELETE']                    = 'Elimina Miniatura';

// OTHER BUTTONS
$langFile['BUTTON_UP']                                          = 'Torna Su';


// -> GENERAL ERROR TEXTS
$langFile['ERROR_SAVE_SETTINGS']                                = '<b>Le impostazioni non possono essere salvate</b>';
$langFile['ERROR_SAVE_FILE']                                    = '<br><br>Si prega di verificare i permessi di lettura e scrittura del file: ';

$langFile['ERROR_READ_FOLDER_PART1']                            = '<br><br>Si prega di controllare le autorizzazioni di lettura del &quot;';
$langFile['ERROR_SAVE_FOLDER_PART1']                            = '<br><br>Si prega di controllare le autorizzazioni di scrittura del &quot;';

$langFile['ERROR_FOLDER_PART2']                                 = '&quot;Cartelle, sottocartelle e file.&quot;';

// -> WARNINGS
$langFile['WARNING_TITLE_STARTPAGE']                            = 'La pagina iniziale non è impostata!';
$langFile['WARNING_TEXT_STARTPAGE']                             = 'Si prega di impostare una pagina come pagina iniziale.<br>Vai a <a href="?site=pages">'.$langFile['BUTTON_PAGES'].'</a> e fare clic sull\' <span class="startPageIcon"></span> icona della pagina desiderata.';

$langFile['WARNING_TITLE_DOCUMENTROOT']                         = 'La root del documento non può essere risolta automaticamente!';
$langFile['WARNING_TEXT_DOCUMENTROOT']                          = 'Per risolvere correttamente la root del documento, andare su <a href="?site=adminSetup#adminSettings">impostazioni-amministratore</a> e settare il &quot;percorso reale&quot; del tuo <span class="logoname">fein<span>dura</span></span> CMS manualmente.';

$langFile['WARNING_TITLE_BASEPATH']                             = '<span class="logoname">fein<span>dura</span></span> non è configurato!';
$langFile['WARNING_TEXT_BASEPATH']                              = 'Il <i> percorso di base</i> del CMS non corrisponde a quello delle impostazioni-amministratore.<br>
                                                                Si prega di andare su <a href="?site=adminSetup#adminSettings">impostazioni-amministratore</a> per configurare il tuo <span class="logoname">fein<span>dura</span></span> CMS.';

$langFile['WARNING_TITLE_JAVASCRIPT']                           = 'Si prega di attivare Javascript';
// no <p> tag on the start and the end, its already in the dashboard.php
$langFile['WARNING_TEXT_JAVASCRIPT']                            = '<strong>Per utilizzare appieno <span class="logoname">fein<span>dura</span></span>, è necessario attivare il  Javascript!</strong></p>
                                                                <h2>in Firefox</h2>
                                                                <p>Fare clic su "Opzioni" > "Contenuti" e nella scheda contenuto selezionare con una spunta la casella "activa JavaScript" e finire con un click su OK.</p>
                                                                <h2>in Internet Explorer</h2>
                                                                <p>Fare clic su "Strumenti" > "Opzioni Internet".<br>
                                                                Si imposta in &quote;Protezione&quote; > &quote;Livello Standard&quote; scegliere "regolare il livello" e attivare la voce "Quote Scripting, in quel punto attivare "Active Scripting".</p>
                                                                <h2>in Safari</h2>
                                                                <p>Fare clic nella barra dei menu in alto sull\'icona a destra, scegliere "Preferenze". Attiva sotto "sicurezza" il punto "Attiva JavaScript" e fare clic su OK per terminare.</p>
                                                                <h2>in Mozilla</h2>
                                                                <p>Fare clic su "Opzioni" > "Preferenze". Sotto il punto "Advanced" > "Scripts & Plugins" controlla "Navigator" e fare clic su OK per terminare.</p>
                                                                <h2>in Opera</h2>
                                                                <p>Fare clic su "Extra" > "Preferenze". sotto "Avanzate" > Controlla "Contenuto" "Attiva JavaScript" e fare clic su OK per terminare.';

$langFile['DASHBOARD_TITLE_IEWARNING']                          = '<span class="logoname">fein<span>dura</span></span> non è fatto per le versioni di browser obsoleti e precedenti di <br>Internet Explorers';
$langFile['DASHBOARD_TEXT_IEWARNING']                           = 'Per utilizzare completamente  <span class="logoname">fein<span>dura</span></span> CMS è necessario almeno Internet Explorer 8.<br><br>Si prega di installare una versione più recente di Internet Explorer,<br> o installare <a href="http://www.google.com/chromeframe" target="_blank">Google Chrome Frame Plugin</a> per Internet Explorer,<br>o scaricare e installare il programma gratuito <a href="http://www.mozilla.org/firefox/">Firefox</a> o <a href="http://www.google.com/chrome/">Chrome</a> Browser.';

$langFile['GENERAL_TEXT_CURRENTLYEDITED']                       = 'Attendi pagina in corso di modifica...';

/*
* leftSidebar.loader.php
*/

// ---------- QUICKMENU

$langFile['SIDEBARMENU_TITLE_CATEGORIES']                       = 'Categorie';
$langFile['SIDEBARMENU_TITLE_PAGES']                            = 'pagine di';

/*
* dashboard.php
*/

// ---------- DASHBOARD
$langFile['DASHBOARD_TITLE_USERINFO']                           = 'Informazioni-Utente';

$langFile['DASHBOARD_TITLE_WELCOME']                            = 'Benvenuti in - <span class="logoname">fein<span>dura</span></span> - (Content Management System) <br>Un Sistema Di Gestione Dei Contenuti Per Il Tuo Sito Web.';
$langFile['DASHBOARD_TEXT_WELCOME']                             = '<span class="logoname">fein<span>dura</span></span> usa il sistema <span class="toolTip" title="Files Flat::Flat è un sistema che non necessita di database per memorizzazione il contenuto, esso viene scritto direttamente nei files che verranno poi stipati in una cartella appositamente creata sul server e in cui il contenuto del sito WEB viene memorizzato.">files flat</span> basati come Content Management System.<br>Qui è possibile gestire il contenuto del tuo sito web senza l\'uso di database.
                                                                <br> Software Tradotto In Lingua Italiana Da: <a href="http://www.sberlamediatica.altervista.org">Un Uomo In Blues</a>';

$langFile['DASHBOARD_TITLE_STATISTICS']                         = 'Statistiche-Sito-Web';

$langFile['DASHBOARD_TITLE_USER']                               = 'Utente';
$langFile['DASHBOARD_TITLE_ACTIVITY']                           = 'ultime attività';
$langFile['DASHBOARD_TEXT_ACTIVITY_NONE']                       = 'nessuno';

$langFile['DASHBOARD_TITLE_STATISTICS_MOSTVISITED']             = 'pagine più visitate';
$langFile['DASHBOARD_TITLE_STATISTICS_LASTVISITED']             = 'ultime pagine visitate';
$langFile['DASHBOARD_TITLE_STATISTICS_LASTEDITED']              = 'ultime pagine modificate';
$langFile['DASHBOARD_TITLE_STATISTICS_LONGESTVIEWED']           = 'pagine visitate più a lungo';

$langFile['DASHBOARD_TITLE_REFERER']                            = 'Siti web da cui i visitatori provenivano';

/*
* listPages.php
*/

// ---------- PAGES SORTABLE LIST
$langFile['sortablePageList_h1']                                = 'Il contenuto del tuo sito web';
$langFile['sortablePageList_headText1']                         = 'filtro';
$langFile['sortablePageList_headText2']                         = 'Ultima modifica';
$langFile['sortablePageList_headText3']                         = 'Visitatori';
$langFile['sortablePageList_headText4']                         = 'Stato';
$langFile['sortablePageList_headText5']                         = 'Funzioni';

$langFile['sortablePageList_pagedate'] = 'Data pagina';
$langFile['sortablePageList_tags']                              = 'Tags';

$langFile['SORTABLEPAGELIST_TIP_SORTALPHABETICAL']              = 'in ordine alfabetico';
$langFile['SORTABLEPAGELIST_TIP_SORTBYPAGEDATE']                = 'in ordine per data';

$langFile['sortablePageList_functions_editPage']                = 'Modifica Pagina';

$langFile['sortablePageList_changeStatus_linkPage']             = 'Clicca qui per cambiare lo stato della pagina.';
$langFile['sortablePageList_changeStatus_linkCategory']         = 'Clicca qui per cambiare lo stato della categoria.';

$langFile['file_error_read']                                    = '<b>Impossibile leggere la pagina.</b>'.$langFile['ERROR_READ_FOLDER_PART1'].'%spages/'.$langFile['ERROR_FOLDER_PART2'];
$langFile['sortablePageList_setStartPage_error_save']          .= $langFile['ERROR_SAVE_FILE'].' &quot;%sconfig/website.config.php&quot;'; // also in en.shared.php
$langFile['sortablePageList_changeStatusPage_error_save']       = '<b>Impossibile modificare lo stato della pagina.</b>'.$langFile['ERROR_SAVE_FOLDER_PART1'].'%spages/'.$langFile['ERROR_FOLDER_PART2'];
$langFile['sortablePageList_changeStatusCategory_error_save']   = '<b>Impossibile modificare lo stato della categoria.</b>'.$langFile['ERROR_SAVE_FOLDER_PART1'].'%spages/'.$langFile['ERROR_FOLDER_PART2'];

$langFile['sortablePageList_info']                              = '&#200; possibile modificare questo <b>ordinamento</b> delle pagine spostandole da su a giù nella categoria usando il <b>Drag and Drop</b>.';
$langFile['sortablePageList_save']                              = 'Salva nuovo ordinamento ...';
$langFile['sortablePageList_save_finished']                     = 'Nuovo ordinamento salvato con successo!';
$langFile['sortablePageList_error_save']                        = '<b>Impossibile salvare la pagina.</b>'.$langFile['ERROR_SAVE_FOLDER_PART1'].'%spages/'.$langFile['ERROR_FOLDER_PART2'];
$langFile['sortablePageList_error_read']                        = '<b>Non è stato possibile leggere le pagine.</b>'.$langFile['ERROR_READ_FOLDER_PART1'].'%spages/'.$langFile['ERROR_FOLDER_PART2'];
$langFile['sortablePageList_error_move']                        = '<b>Impossibile spostare la pagina nella nuova categoria.</b>'.$langFile['ERROR_SAVE_FOLDER_PART1'].'%spages/'.$langFile['ERROR_FOLDER_PART2'];
$langFile['sortablePageList_categoryEmpty']                     = 'Non ci sono pagine disponibili';

// ---------- FORMULAR
$langFile['FORM_BUTTON_SUBMIT']                                 = 'Salva Impostazioni';
$langFile['FORM_BUTTON_CANCEL']                                 = 'Ripristina tutti gli input';

/*
* adminSetup.php
*/

// ---------- ADMIN SETUP (on toolTips tooTips.js converts the "[" and "]" tags in the title attribute to "<" ">")
$langFile['ADMINSETUP_TEXT_VERSION']                            = 'versione <span class="logoname">fein<span>dura</span></span>';
$langFile['ADMINSETUP_TEXT_PHPVERSION']                         = 'versione PHP';
$langFile['ADMINSETUP_TITLE_DOCUMENTROOT']                      = 'Root Documenti';

$langFile['ADMINSETUP_TITLE_ERROR']                             = 'Si sono verificati errori';
$langFile['ADMINSETUP_TOOLTIP_WRITEACCESSERROR']                = 'Per i file e le directory hai bisogno di impostare le autorizzazioni a %o.';

$langFile['ADMINSETUP_TEXT_WRITEACCESSERROR']                   = 'non è scrivibile';
$langFile['ADMINSETUP_TEXT_ISFOLDERERROR']                      = 'non è una directory';

// ---------- general Settings
$langFile['ADMINSETUP_GENERAL_error_save']                      = $langFile['ERROR_SAVE_SETTINGS'].$langFile['ERROR_SAVE_FILE'].'%sconfig/admin.config.php';

$langFile['ADMINSETUP_GENERAL_h1']                              = 'Impostazioni-Di-Base';

$langFile['ADMINSETUP_GENERAL_field1']                          = 'URL Sito Web';
$langFile['ADMINSETUP_GENERAL_field1_tip']                      = 'L\'URL del tuo sito verrà aggiunto automaticamente.';
$langFile['ADMINSETUP_GENERAL_field1_inputTip']                 = 'L\'URL verrà aggiunto automaticamente';
$langFile['ADMINSETUP_GENERAL_field1_inputWarningText']         = 'Si prega di salvare le impostazioni!';
$langFile['ADMINSETUP_GENERAL_field2']                          = 'Percorso Feindura';
$langFile['ADMINSETUP_GENERAL_field2_tip']                      = 'Il percorso di base sarà determinato automaticamente e salvato, per la prima volta le impostazioni vengono salvate.';
$langFile['ADMINSETUP_GENERAL_field2_inputTip']                 = 'Il percorso verrà aggiunto automaticamente';
$langFile['ADMINSETUP_GENERAL_field2_inputWarningText']         = 'Si prega di salvare le impostazioni!';
$langFile['ADMINSETUP_GENERAL_TEXT_REALBASEPATH']               = 'Percorso Reale feindura';
$langFile['ADMINSETUP_GENERAL_TOOLTIP_REALBASEPATH']            = 'Il percorso del file reale del tuo [span class=logoname]fein[span]dura[/span][/span] cms, relativo alla radice dei documenti.';
$langFile['ADMINSETUP_GENERAL_EXAMPLE_REALBASEPATH']            = '<b>Esempio</b> &quot;/cms/&quot;';
$langFile['ADMINSETUP_GENERAL_field8']                          = 'Percorso Sito Web';
$langFile['ADMINSETUP_GENERAL_field8_tip']                      = 'Il [b]percorso assoluto[/b] in cui il sito si trova.';
$langFile['ADMINSETUP_GENERAL_field4']                          = 'Percorso Upload';
$langFile['ADMINSETUP_GENERAL_field4_tip']                      = 'File come foto caricate, Animazioni-Flash e altri tipi di documenti verranno salvati qui.[br /][br /][span class=hint]I file possono essere caricati sul pulsante Link > Carica in Editor-HTML o nel file manager.[/span]';
$langFile['ADMINSETUP_GENERAL_editfiles_additonal']             = '[br /][br /]Questi file possono essere modificati più in basso, o nelle impostazioni-website (se è attivato dalle impostazioni-utente).[br /][br /]';
$langFile['ADMINSETUP_GENERAL_field5']                          = 'Percorso Per I File';
$langFile['ADMINSETUP_GENERAL_field5_tip']                      = 'Crea un percorso per la cartella con i file che vengono utilizzati dal tuo sito web. Esempio: per fare un sito web multi-language.'.$langFile['ADMINSETUP_GENERAL_editfiles_additonal'];
$langFile['ADMINSETUP_GENERAL_field6']                          = 'Percorso Per I Fogli Di Stile';
$langFile['ADMINSETUP_GENERAL_field6_tip']                      = 'Un [b]percorso assoluto[/b] in cui i file sono fogli di stile. Esempio: che può essere modificato dall\'utente.'.$langFile['ADMINSETUP_GENERAL_editfiles_additonal'];
$langFile['ADMINSETUP_GENERAL_TEXT_PERMISSIONS']                = 'Autoriz.ni File E Cartelle';
$langFile['ADMINSETUP_GENERAL_TIP_PERMISSIONS']                 = 'Ogni file o cartella creata da [span class=logoname]fein[span]dura[/span][/span] otterrà le autorizzazioni in scrittura automaticamente.';
$langFile['ADMINSETUP_GENERAL_varName_ifempty']                 = 'Se il campo è vuoto per il nome standard della Variable $_GET sarà utilizzato: ';
$langFile['ADMINSETUP_GENERAL_varName1']                        = 'Nome Pagina';
$langFile['ADMINSETUP_GENERAL_varName1_inputTip']               = $langFile['ADMINSETUP_GENERAL_varName_ifempty'].'&quot;[b]page[/b]&quot;';
$langFile['ADMINSETUP_GENERAL_varName2']                        = 'Nome Categoria';
$langFile['ADMINSETUP_GENERAL_varName2_inputTip']               = $langFile['ADMINSETUP_GENERAL_varName_ifempty'].'&quot;[b]category[/b]&quot;';
$langFile['ADMINSETUP_GENERAL_varName3']                        = 'Nome Modulo';
$langFile['ADMINSETUP_GENERAL_varName3_inputTip']               = $langFile['ADMINSETUP_GENERAL_varName_ifempty'].'&quot;[b]modulo[/b]&quot;';
$langFile['ADMINSETUP_GENERAL_varName_tip']                     = 'Il nome della variabile [b]$_GET[/b] che verrà utilizzato per collegare le pagine del sito web.';
$langFile['ADMINSETUP_GENERAL_field7']                          = 'Formato Data';
$langFile['ADMINSETUP_GENERAL_field7_tip']                      = 'Sarà utilizzato da [span class=logoname]fein[span]dura[/span][/span] per le date del sito web.[br /]Può essere:[br /]DIN 5008 ('.$langFile['DATE_EU'].') oppure[br /]ISO 8601 ('.$langFile['DATE_INT'].')';
$langFile['ADMINSETUP_TEXT_TIMEZONE']                           = 'Time Zone';
$langFile['ADMINSETUP_TIP_TIMEZONE']                            = 'Utilizzato da [span class=logoname]fein[span]dura[/span][/span] solo per il Backend.';
$langFile['ADMINSETUP_GENERAL_speakingUrl']                     = 'Formato URL';
$langFile['ADMINSETUP_GENERAL_speakingUrl_true']                = 'Speaking URLs';
$langFile['ADMINSETUP_GENERAL_speakingUrl_true_example']        = '/category/example_category/example.html';
$langFile['ADMINSETUP_GENERAL_speakingUrl_false']               = 'URLs con variabili';
$langFile['ADMINSETUP_GENERAL_speakingUrl_false_example']       = 'index.php?%s=1&%s=1';
$langFile['ADMINSETUP_GENERAL_speakingUrl_tip']                 = 'Questo sarà il formato URL che verrà utilizzato per collegare le pagine.[br /][br /]Speaking URLs funziona solo se [b]Apache[/b] ha attivato [b]mod_rewrite[/b] e il modulo è disponibile.';
$langFile['ADMINSETUP_GENERAL_speakingUrl_warning']             = 'ATTENZIONE!::[span class=red]Se si verifica un errore durante l\'utilizzo di [i]Speaking URLs[/i], sarà necessario eliminare il file - [b].htaccess[/b] - [br /]Questo file dal percorso principale del vostro server web va eliminato solo se si desidera usare speaking URLs.[/span][br /][br /](In alcuni programmi FTP si devono mostrare i file nascosti in primo luogo, per vedere il file .Htaccess altrimenti esso risulterà invisibile)';

// ---------- speaking url ERRORs
$langFile['ADMINSETUP_GENERAL_speakingUrl_error_save']          = '<b>Speaking URLs</b> non può essere attivato'.$langFile['ERROR_SAVE_FILE'].'/.htaccess';
$langFile['ADMINSETUP_GENERAL_speakingUrl_error_modul']         = '<b>Speaking URLs</b> non può essere attivato, poiché Apache MOD_REWRITE modul non è stato trovato';


// ---------- user Settings
$langFile['ADMINSETUP_USERPERMISSIONS_TITLE']                   = 'Autorizzazioni-Utente';
$langFile['ADMINSETUP_USERPERMISSIONS_check1']                  = 'Modificare i files dalle Impostazioni-SitoWeb';
$langFile['ADMINSETUP_USERPERMISSIONS_check2']                  = 'Modificare i files fogli di stile in Impostazioni-SitoWeb';
$langFile['ADMINSETUP_USERPERMISSIONS_TEXT_FILEMANAGER']        = 'Attivare il file manager';
$langFile['ADMINSETUP_USERPERMISSIONS_TIP_WARNING_FILEMANAGER'] = 'File manager disattivato::È necessario impostare il percorso di upload in Impostazioni-Di-Base, prima di poter attivare il file manager.';
$langFile['ADMINSETUP_USERPERMISSIONS_TEXT_FRONTENDEDITING']    = 'Attivare la modifica frontale';

$langFile['ADMINSETUP_USERPERMISSIONS_textarea1']               = '<strong>Informazioni Utente</strong> in <a href="?site=dashboard">'.$langFile['BUTTON_DASHBOARD'].'</a>';
$langFile['ADMINSETUP_USERPERMISSIONS_textarea1_tip']           = 'Informazioni Utente::Questo testo verrà visualizzato nel '.$langFile['BUTTON_DASHBOARD'].' della pagina di [span class=logoname]fein[span]dura[/span][/span].';
$langFile['ADMINSETUP_USERPERMISSIONS_textarea1_inputTip']      = 'Se non si desidera visualizzare le informazioni per l\'utente, lasciare questo campo vuoto';

// ---------- editor Settings
$langFile['adminSetup_editorSettings_h1']                       = 'Impostazzioni-Editor-HTML';
$langFile['ADMINSETUP_TEXT_EDITOR_HTMLLAWED']                   = 'Il filtro HTML (utilizza <a href="http://www.bioinformatics.org/phplabware/internal_utilities/htmLawed/">htmlLawed</a>)';
$langFile['ADMINSETUP_TIP_EDITOR_HTMLLAWED']                    = 'Filtrare il codice HTML prima di salvare. Questo per evitare concause e problemi nel codice HTML con un sacco di Javascript.';
$langFile['ADMINSETUP_TEXT_EDITOR_SAFEHTML']                    = 'safe HTML (<a href="http://www.bioinformatics.org/phplabware/internal_utilities/htmLawed/htmLawed_README.htm#s3.6">dettagli</a>)';
$langFile['ADMINSETUP_TIP_EDITOR_SAFEHTML']                     = 'Questo è il codice HTML con le impostazioni più sicure che viene filtrato, vale a dire per esempio che nessun tag del tipo &lt;applet&gt;,&lt;embed&gt;,&lt;embed&gt;,&lt;object &gt; e &lt;script&gt; sono ammessi.';
$langFile['adminSetup_editorSettings_field1']                   = 'ENTER-Key mode';
$langFile['adminSetup_editorSettings_field1_hint']              = 'SHIFT + ENTER genera sempre un &quot;&lt;br&gt;&quot;';
$langFile['adminSetup_editorSettings_field1_tip']               = 'Specifica quali tag HTML quando si preme il tasto ENTER verranno impostati.[br /][br /][span class=hint]'.$langFile['adminSetup_editorSettings_field1_hint'].'.[/span]';
$langFile['adminSetup_editorSettings_field3_inputTip']          = 'Se il campo è vuoto, non viene utilizzato l\'ID.';
$langFile['adminSetup_editorSettings_field4_inputTip']          = 'Se il campo è vuoto, nessuna classe verrà utilizza.';

// THUMBNAILS Settings
$langFile['adminSetup_thumbnailSettings_h1']                    = 'Pagina-Impostazioni-Miniature';
$langFile['adminSetup_thumbnailSettings_field3']                = 'Percorso Salvato'; // Thumbnail-Speicherpfad
$langFile['adminSetup_thumbnailSettings_field3_tip']            = 'Inserisci la cartella all\'interno del percorso di caricamento relativo che sarà usato per salvare le miniature.';
$langFile['adminSetup_thumbnailSettings_field3_inputTip1']      = 'Il percorso dei files caricati';
$langFile['adminSetup_thumbnailSettings_field3_inputTip2']      = 'Percorso Relativo::Rispetta questo percorso relativo e inserisci qui i file delle miniature &quot;[b]%s[/b] thumbnails&quot;.[br /][br /]Usa sempre un nome con la sintassi minuscola senza spazi e non inserire all\'inizio del nome lo slash &quot;/&quot;';
$langFile['adminSetup_thumbnailSettings_field3_inputTip3']      = '<b>'.$langFile['TEXT_EXAMPLE'].'</b> &quot;thumbnails/&quot; ';

// ---------- styleFile Settings
$langFile['adminSetup_styleFileSettings_h1']                    = 'Stile &quot;Styles&quot; Seleziona-L\'editor-HTML-Per-Modificare';
$langFile['adminSetup_styleFileSettings_error_save']            = '<b>il file &quot;EditorHTMLStyles.js&quot; non può essere salvato.</b>'.$langFile['ERROR_SAVE_FILE'];

// ---------- editFiles Settings
$langFile['editFilesSettings_error_save']                       = '<b>Il file non può essere salvato.</b>'.$langFile['ERROR_SAVE_FILE'];

$langFile['editFilesSettings_h1_style']                         = 'Pagina-Fogli-Di-Stile';
$langFile['editFilesSettings_h1_websitefiles']                  = 'Pagine-Web-Da-Modificare';
$langFile['editFilesSettings_noDir']                            = 'non è una directory valida!';
$langFile['editFilesSettings_chooseFile']                       = 'selezionare il file';
$langFile['editFilesSettings_createFile']                       = 'Creare Un Nuovo File';
$langFile['editFilesSettings_createFile_inputTip']              = 'Qui, puoi immette un nome di file, quindi un nuovo file verrà creato. [br][b]I nuovi files creati non verrnno salvati nei backups![/b]';
$langFile['editFilesSettings_noFile']                           = 'Non ci sono file disponibili';

$langFile['editFilesSettings_deleteFile']                       = 'Cancella il file';
$langFile['editFilesSettings_deleteFile_question_part1']        = 'Sei sicuro di voler cancellare il file'; // Kategorie "test" löschen?
$langFile['editFilesSettings_deleteFile_question_part2']        = '?';

$langFile['editFilesSettings_deleteFile_error_delete']          = '<b>Impossibile eliminare il file.</b>'.$langFile['ERROR_SAVE_FILE'];

/*
* pageSetup.php
*/

// ---------- CATEGORY SETUP (on toolTips tooTips.js converts the "[" and "]" tags in the title attribute to "<" ">")
$langFile['PAGESETUP_PAGES_TIP_TAG']                            = 'I Tags possono essere utilizzati per creare connessioni tra le pagine (a seconda della programmazione del sito)';

// ---------- page settings
$langFile['PAGESETUP_PAGES_TITLE_PAGESETTINGS']                 = 'Impostazzioni-Pagina';
$langFile['PAGESETUP_PAGES_TEXT_SETSTARTPAGE']                  = 'Imposta Pagina Iniziale';
$langFile['PAGESETUP_PAGES_TIP_SETSTARTPAGE']                   = 'L\'utente può impostare una pagina come pagina iniziale.[br /][br /]Se selezionata questa impostazione l\'utente può decidere la pagina da visualizzare all\'entrata nel sito. Quando nessuna variabile [i]$_GET[/i] di altre pagine vengono passate nel sito o in qualunque pagina che è stata già visualizzata, sarà quella selezionata la Home Page.';

$langFile['PAGESETUP_PAGES_TITLE_NONCATEGORYPAGES']             = 'Pagine-Senza-Categoria';
$langFile['PAGESETUP_PAGES_TEXT_CREATEPAGES']                   = 'Creare Cancellare Pagine';
$langFile['PAGESETUP_PAGES_TIP_CREATEPAGES']                    = 'Determina se l\'utente può creare o eliminare le pagine senza categoria.';
$langFile['PAGESETUP_PAGES_TEXT_UPLOADTHUMBNAILS']              = 'Carica Miniature';
$langFile['PAGESETUP_PAGES_TIP_UPLOADTHUMBNAILS']               = 'Determina se l\'utente, all\'interno delle pagine senza una categoria, può caricare e usare le miniature in esse inserite.';
$langFile['PAGESETUP_PAGES_TEXT_EDITTAGS']                      = 'Modificare Tag';
$langFile['PAGESETUP_PAGES_TIP_EDITTAGS']                       = 'Determina se l\'utente, all\'interno delle pagine senza una categoria, può modificare i tag.[br /]'.$langFile['PAGESETUP_PAGES_TIP_TAG'];
$langFile['PAGESETUP_PAGES_TEXT_ACTIVATEPLUGINS']               = 'Abilitare Plugin';
$langFile['PAGESETUP_PAGES_TIP_ACTIVATEPLUGINS']                = 'Determina se l\'utente, all\'interno delle pagine senza una categoria, può utilizzare i plugin.';

// ---------- category settings
$langFile['PAGESETUP_CATEGORY_TITLE_CATEGORIES']                = 'Gestione-Delle-Categorie';
$langFile['PAGESETUP_CATEGORY_TEXT_CATEGORYNAME']               = 'Nome';

$langFile['PAGESETUP_CATEGORY_TEXT_CREATECATEGORY']             = 'Crea una nuova categoria';
$langFile['PAGESETUP_CATEGORY_TEXT_CREATECATEGORY_CREATED']     = 'Nuova categoria creata';
$langFile['PAGESETUP_CATEGORY_TEXT_CREATECATEGORY_UNNAMED']     = 'Categoria Senza titolo';

$langFile['PAGESETUP_CATEGORY_TEXT_DELETECATEGORY']                = 'Elimina la categoria';
$langFile['PAGESETUP_CATEGORY_TEXT_DELETECATEGORY_WARNING']        = 'ATTENZIONE: Elimina tutte le pagine in questa categoria!';
$langFile['PAGESETUP_CATEGORY_TEXT_DELETECATEGORY_DELETED']        = 'Categoria cancellata';
$langFile['PAGESETUP_CATEGORY_TEXT_DELETECATEGORY_QUESTION_START'] = 'Elimina la categoria'; // Kategorie "test" löschen?
$langFile['PAGESETUP_CATEGORY_TEXT_DELETECATEGORY_QUESTION_END']   = '?';

$langFile['PAGESETUP_CATEGORY_TEXT_MOVECATEGORY_MOVED']         = 'Categoria spostata';
$langFile['PAGESETUP_CATEGORY_TIP_MOVECATEGORY_UP']             = 'Sposta verso l\'alto questa categoria';
$langFile['PAGESETUP_CATEGORY_TIP_MOVECATEGORY_DOWN']           = 'Spostare verso il basso questa categoria';

$langFile['PAGESETUP_CATEGORY_ERROR_CREATECATEGORY']            = '<b>Impossibile creare nuova categoria.</b>'.$langFile['ERROR_SAVE_FOLDER_PART1'].'%sconfig/'.$langFile['ERROR_FOLDER_PART2'];
$langFile['PAGESETUP_CATEGORY_ERROR_CREATEDIR']                 = '<b>Impossibile creare la cartella nuova categoria.</b>'.$langFile['ERROR_SAVE_FOLDER_PART1'].'%spages/'.'&quot; Ordners.';
$langFile['PAGESETUP_CATEGORY_ERROR_DELETECATEGORY']            = '<b>Impossibile eliminare la categoria.</b>'.$langFile['ERROR_SAVE_FILE'].'%sconfig/category.config.php';
$langFile['PAGESETUP_CATEGORY_ERROR_DELETEDIR']                 = '<b>Impossibile eliminare la directory della categoria.</b>'.$langFile['ERROR_SAVE_FOLDER_PART1'].'%spages/'.$langFile['ERROR_FOLDER_PART2'];
$langFile['PAGESETUP_CATEGORY_ERROR_SAVE']                      = $langFile['ERROR_SAVE_SETTINGS'].$langFile['ERROR_SAVE_FILE'].'%sconfig/category.config.php';


$langFile['PAGESETUP_CATEGORY_TITLE_ADVANCEDSETTINGS']          = 'Impostazioni-Avanzate';
$langFile['PAGESETUP_CATEGORY_HINT_ADVANCEDSETTINGS']           = 'Se le informazioni qui inserite sono correttamente impostate, puoi continuare a sovrascriverci sopra editando il foglio di stile alla voce '.$langFile['adminSetup_editorSettings_h1'].' da <a href="?site=adminSetup">impostazioni-amministratore</a>.';

$langFile['PAGESETUP_CATEGORY_TIP_STYLESHEETS_EMPTY']           = 'Se questo campo è vuoto, le informazioni del foglio di stile possono essere editate dalle '.$langFile['adminSetup_editorSettings_h1'].' e utilizzate come foglio di stile corrente per il tuo sito web.';

$langFile['PAGESETUP_CATEGORY_TEXT_CATEGORYSTATUS']             = 'Stato Della Categoria';
$langFile['PAGESETUP_CATEGORY_TIP_CATEGORYSTATUS']              = 'Specifica se la categoria è visibile sul sito e quindi reperibile in rete.';
$langFile['PAGESETUP_CATEGORY_TEXT_CREATEPAGES']                = 'Creare Cancella Pagine';
$langFile['PAGESETUP_CATEGORY_TIP_CREATEPAGES']                 = 'Specifica se l\'utente può creare o cancellare le pagine in questa categoria.';
$langFile['PAGESETUP_CATEGORY_TEXT_UPLOADTHUMBNAILS']           = 'Caricare Miniature';
$langFile['PAGESETUP_CATEGORY_TIP_UPLOADTHUMBNAILS']            = 'Specifica se l\'utente può caricare le miniature delle pagine in questa categoria.';
$langFile['PAGESETUP_CATEGORY_TEXT_EDITTAGS']                   = 'Modificare I Tag';
$langFile['PAGESETUP_CATEGORY_TIP_EDITTAGS']                    = 'Specifica se l\'utente può modificare i tag nella pagine in questa categoria.[br /]'.$langFile['PAGESETUP_PAGES_TIP_TAG'];
$langFile['PAGESETUP_CATEGORY_TEXT_ACTIVATEPLUGINS']            = 'Attivare Plugin';
$langFile['PAGESETUP_CATEGORY_TIP_ACTIVATEPLUGINS']             = 'Specifica se l\'utente può utilizzare i plugin nelle pagine in questa categoria.';
$langFile['PAGESETUP_CATEGORY_HINT_ACTIVATEPLUGINS']            = 'Tenere premuto il tasto CTRL per selezionare più di un plugin.';

$langFile['PAGESETUP_TEXT_EDITPAGEDATE']                        = 'Modificare Date';
$langFile['PAGESETUP_TIP_EDITPAGEDATE']                         = 'La data nelle pagina può essere utilizzata per ordinarle in base alla loro pubblicazione';

$langFile['PAGESETUP_TEXT_FEEDS']                               = 'Attivare Feeds';
$langFile['PAGESETUP_TIP_FEEDS']                                = 'Attiva RSS 2.0 e Atom Feed per le pagine senza categoria.';
$langFile['PAGESETUP_CATEGORY_TIP_FEEDS']                       = 'Attiva RSS 2.0 e Atom Feed per le pagine in questa categoria.';

$langFile['PAGESETUP_TIP_SORTBYPAGEDATE']                       = 'Ordinare Per Data';
$langFile['PAGESETUP_TIP_SORTBYDATE']                           = 'Le pagine con una data più recente appariranno in [b]testa[/b] alla lista delle pagine.[br /][br /][span class=hint]Usa questa impostazione per inserire le pagine in ordine di creazione.[/span]';

$langFile['PAGESETUP_TEXT_SORTMANUALLY']                        = 'Ordinare Manualmente';
$langFile['PAGESETUP_TIP_SORTMANUALLY']                         = 'Le Pagine appena create, appariranno sempre [b]in cima[/b] alla lista delle pagine.';

$langFile['PAGESETUP_TEXT_SORTALPHABETICAL']                    = 'Ordinare Alfabeticamente';
$langFile['PAGESETUP_TIP_SORTALPHABETICAL']                     = '[span class=hint]Usa questa impostazione per inserire le pagine in ordine alfabetico.[/span]';

$langFile['PAGESETUP_TEXT_SORTREVERSE']                         = 'Ordine Inverso';
$langFile['PAGESETUP_TIP_SORTREVERSE']                          = 'Inverti l\'ordine delle pagine.';


/*
* websiteSetup.php
*/

// ---------- WEBSITE SETUP (on toolTips tooTips.js converts the "[" and "]" tags in the tittle attribute to "<" ">")
$langFile['websiteSetup_websiteConfig_error_save']              = $langFile['ERROR_SAVE_SETTINGS'].$langFile['ERROR_SAVE_FILE'].'%sconfig/website.config.php';

$langFile['websiteSetup_websiteConfig_h1']                      = 'Impostazioni-SitoWeb';
$langFile['websiteSetup_websiteConfig_field1']                  = 'Titolo Sito Web';
$langFile['websiteSetup_websiteConfig_field1_tip']              = 'Il titolo del sito web verrà mostrato nella barra del browser.';
$langFile['websiteSetup_websiteConfig_field2']                  = 'Editore Publisher';
$langFile['websiteSetup_websiteConfig_field2_tip']              = 'Nome organizzazione, compagnia, persona, che pubblicano sul sito.';
$langFile['websiteSetup_websiteConfig_field3']                  = 'Copyright';
$langFile['websiteSetup_websiteConfig_field3_tip']              = 'Il titolare del copyright di tutti i contenuti del sito web.';

$langFile['websiteSetup_websiteConfig_field4']                  = 'Parole Chiave';
$langFile['websiteSetup_websiteConfig_field4_tip']              = 'La maggior parte dei motori di ricerca inseguono i contenuti del sito per parole chiave, tuttavia qui è possibile elencare alcune parole chiave che saranno memorizzate nei tag <meta> delle pagine web.';
$langFile['websiteSetup_websiteConfig_field4_inputTip']         = 'Parole Chiave Separate Da &quot;,&quot;::'.$langFile['TEXT_EXAMPLE'].':[br /]stichwort1,stichwort2,etc';
$langFile['websiteSetup_websiteConfig_field5']                  = 'Descrizione Sito Web';
$langFile['websiteSetup_websiteConfig_field5_tip']              = 'Inserire qui una breve descrizione per l\'uso dei motori di ricerca, se lo SearchWords è stato trovato nell\'URL del sito web e non nel contenuto verrà mostrato come titolo di anteprima dal motore di ricerca.';
$langFile['websiteSetup_websiteConfig_field5_inputTip']         = 'Testo Breve Non Più Di 3 Linee.';

/*
* statisticSetup.php
*/

// ---------- STATISITC SETUP (on toolTips tooTips.js converts the "[" and "]" tags in the tittle attribute to "<" ">")
$langFile['STATISTICSSETUP_ERROR_SAVE']                         = $langFile['ERROR_SAVE_SETTINGS'].$langFile['ERROR_SAVE_FILE'].'%sconfig/statistic.config.php';

$langFile['STATISTICSSETUP_TITLE_STATISTICSSETTINGS']           = 'Impostazioni-Statistiche';
$langFile['STATISTICSSETUP_TEXT_MOSTVISTED']                    = '<b>Più Visitate</b>';
$langFile['STATISTICSSETUP_TIP_MOSTVISTED']                     = 'Numero di pagine più visitate. Specifica la quantità di pagine più visitate da visualizzare. Questo dato verrà inserito sulla pagina Cruscotto.';
$langFile['STATISTICSSETUP_TEXT_LONGESTVIEWED']                 = '<b>Lunga Permanenza</b>';
$langFile['STATISTICSSETUP_TIP_LONGESTVIEWED']                  = 'Numero di pagine a lunga permanenza visitate. Specifica la quantità di pagine a lunga permanenza da visualizzare. Questo dato verrà inserito nella pagina Cruscotto.';
$langFile['STATISTICSSETUP_TEXT_LASTEDITED']                    = '<b>Ultima Modifica</b>';
$langFile['STATISTICSSETUP_TIP_LASTEDITED']                     = 'Numero di pagine ultima modifica. Specifica la quantità di ultime pagine modificate da visualizzare. Questo dato verrà inserito nella pagina Cruscotto.';
$langFile['STATISTICSSETUP_TEXT_LASTVISITED']                   = '<b>Ultima Visita</b>';
$langFile['STATISTICSSETUP_TIP_LASTVISITED']                    = 'Numero di pagine ultima visita. Specifica la quantità di ultime pagine visitate da visualizzare. Questo dato verrà inserito sulla pagina Cruscotto.';
$langFile['STATISTICSSETUP_TEXT_REFERERNUMBER']                 = '<b>Referrer-URLs</b>';
$langFile['STATISTICSSETUP_TIP_REFERERNUMBER']                  = 'Numero di Referrer-URLs. Specifica la quantità di Referrer-URLs ([i]URLs che hanno portato al sito[/i]) da visualizzare. Questi dati verranno salvati e inserito nella pagina Cruscotto.';
$langFile['STATISTICSSETUP_TEXT_ACTIVITYNUMBER']                = '<b>Log-Attività</b>';
$langFile['STATISTICSSETUP_TIP_ACTIVITYNUMBER']                 = 'Numero di Log-Attività. Specifica la quantità di attività svolte nel sito da visualizzare. Questo dato sarà salvato in un log e i dati inseriti a lato del Cruscotto.';


$langFile['statisticSetup_clearStatistic_h1']                             = 'Elimina-Statistiche';
$langFile['statisticSetup_clearStatistics_websiteStatistic']              = 'Statistiche-SitoWeb';
$langFile['statisticSetup_clearStatistics_websiteStatistic_tip']          = '[b]Contiene[/b][ul][li]Numero totale di visitatori[/li][li]Numero totale di web-crawler[/li][li]Data della prima visita[/li][li]Data dell\'ultima visita[/li][li]Browser spectrum[/li][/ul]';
$langFile['statisticSetup_clearStatistics_pagesStatistic']                = 'Statistiche-Pagina';
$langFile['statisticSetup_clearStatistics_pagesStatistic_tip']            = '[b]Contiene[/b][ul][li]Numero di visitatori della pagina[/li][li]Data della prima visita[/li][li]Data dell\'ultima visita[/li][li]La durata della visita più breve[/li][li]La durata della visita più lunga[/li][li]Parole chiave che portano al sito[/li][/ul]';
$langFile['statisticSetup_clearStatistics_pagesStaylengthStatistics']     = 'Statistiche-Length-Of-Stay';
$langFile['statisticSetup_clearStatistics_pagesStaylengthStatistics_tip'] = 'Elimina l\'elenco della pagina Length-Of-Stay';
$langFile['statisticSetup_clearStatistics_refererLog']                    = 'Referrer-URLs Log'; // engl.: referer
$langFile['statisticSetup_clearStatistics_refererLog_tip']                = 'Elimina l\'elenco di tutti gli URL che hanno portato a questo sito.';
$langFile['statisticSetup_clearStatistics_taskLog']                       = 'Activities-Log';
$langFile['statisticSetup_clearStatistics_taskLog_tip']                   = 'Elimina l\'elenco delle ultime attività.';

$langFile['statisticSetup_clearStatistics_question_h1']                   = 'Sei sicuro di voler cancellare queste statistiche?';

$langFile['statisticSetup_clearStatistic_pagesStatistics_error_read']     = 'Errore durante l\'eliminazione delle statistiche della pagina.'.$langFile['ERROR_SAVE_FOLDER_PART1'].'%sstatistic/pages/'.$langFile['ERROR_FOLDER_PART2'];

/*
* userSetup.php
*/

$langFile['userSetup_h1']                                       = 'Gestione-Utenti';
$langFile['userSetup_userSelection']                            = 'Utenti';

$langFile['userSetup_createUser']                               = 'Crea un nuovo utente';
$langFile['userSetup_createUser_created']                       = 'Nuovo utente creato';
$langFile['userSetup_createUser_unnamed']                       = 'Inserisci Info';

$langFile['userSetup_deleteUser']                               = 'Elimina Utente';
$langFile['userSetup_deleteUser_deleted']                       = 'Utente Cancellato';

$langFile['userSetup_username']                                 = 'Nome Utente';
$langFile['userSetup_username_missing']                         = 'Non c\'è ancota un Nome Utente.';
$langFile['userSetup_password']                                 = 'Password';
$langFile['userSetup_password_change']                          = 'Cambia Password';
$langFile['userSetup_password_confirm']                         = 'Conferma Password';
$langFile['userSetup_password_confirm_wrong']                   = 'Le due password non corrispondono.';
$langFile['userSetup_password_missing']                         = 'Non c\'è ancora nessuna password impostata.';
$langFile['userSetup_password_success']                         = 'Password modificata correttamente!';
$langFile['userSetup_email']                                    = 'E-Mail';
$langFile['userSetup_email_tip']                                = 'Se l\'utente ha dimenticato la propria password, una nuova password verrà inviata a questo indirizzo e-mail.';

$langFile['userSetup_admin']                                    = 'Amministratore';
$langFile['userSetup_admin_tip']                                = 'Determina se l\'utente disporrà dei diritti di amministrazione.';

$langFile['userSetup_error_create']                             = '<b>Un nuovo utente non può essere creato.</b>'.$langFile['ERROR_SAVE_FILE'].'%sconfig/user.config.php';
$langFile['userSetup_error_save']                               = $langFile['ERROR_SAVE_SETTINGS'].$langFile['ERROR_SAVE_FILE'].'%sconfig/user.config.php';

/*
* editor.php
*/

// ---------- page info
$langFile['EDITOR_h1_createpage']                               = 'Crea una nuova pagina';
$langFile['EDITOR_pageinfo_lastsavedate']                       = 'ultima modifica';
$langFile['EDITOR_pageinfo_lastsaveauthor']                     = 'di';
$langFile['EDITOR_pageinfo_linktothispage']                     = 'Collegamento a questa pagina';
$langFile['EDITOR_pageinfo_id']                                 = 'ID Pagina';
$langFile['EDITOR_pageinfo_id_tip']                             = 'La pagina verrà salvata con questo ID sul server.';
$langFile['EDITOR_pageinfo_category']                           = 'Categoria';
$langFile['EDITOR_pageinfo_category_noCategory']                = 'nessuna categoria (ID 0)';

$langFile['EDITOR_TEXT_CHOOSETEMPLATE']                         = 'Usa modello';

$langFile['EDITOR_block_edited']                                = 'sono stati modificati';
$langFile['EDITOR_pageNotSaved']                                = 'non è stata salvata';

// ---------- page settings
$langFile['EDITOR_pageSettings_h1']                             = 'Impostazioni';
$langFile['EDITOR_pagestatistics_h1']                           = 'Statistiche';

$langFile['EDITOR_pageSettings_title']                          = 'Titolo';
$langFile['EDITOR_pageSettings_title_tip']                      = 'Il titolo della pagina';
$langFile['EDITOR_pageSettings_field1']                         = 'Breve descrizione';
$langFile['EDITOR_pageSettings_field1_inputTip']                = 'Se vuoto, utilizza la descrizione nel tag del sito  dalle Impostazioni-SitoWeb.';
$langFile['EDITOR_pageSettings_field1_tip']                     = 'Una breve sintesi del contenuto della pagina. Questa descrizione sarà utilizzata nella meta-tag della pagina.[br /][br /][span class=hint]'.$langFile['EDITOR_pageSettings_field1_inputTip'].'[/span]';
$langFile['EDITOR_pageSettings_field2']                         = 'Tags';
$langFile['EDITOR_pageSettings_field2_tip']                     = 'I tag sono parole chiave che fanno da riferimento per questa pagina.';
$langFile['EDITOR_pageSettings_field2_tip_inputTip']            = 'I tag devono essere separati da una virgola &quot;,&quot;.';
$langFile['EDITOR_pageSettings_field3']                         = 'Pagedate';
$langFile['EDITOR_pageSettings_field3_tip']                     = 'La data può essere utilizzata per ordinare le pagine in base al tempo della sua creazione. (ad esempio in occasione di eventi)';
$langFile['EDITOR_pageSettings_pagedate_before_inputTip']       = 'Testo prima della data::ad esempio  &quot;dal 31 giugno fino al&quot;.';
$langFile['EDITOR_pageSettings_pagedate_after_inputTip']        = 'Testo dopo la data::';
$langFile['EDITOR_pageSettings_pagedate_day_inputTip']          = 'Giorno::';
$langFile['EDITOR_pageSettings_pagedate_month_inputTip']        = 'Mese::';
$langFile['EDITOR_pageSettings_pagedate_year_inputTip']         = 'Anno::[b]Format[/b] YYYY';
$langFile['EDITOR_pageSettings_field4']                         = 'Stato della pagina';
$langFile['EDITOR_pageSettings_field4_tip']                     = '[b]Solo quando la pagina è pubblica, sarà visualizzata sul Web![/b]';

$langFile['EDITOR_pageSettings_pagedate_error']                 = 'Il formato della data è sbagliato';
$langFile['EDITOR_pageSettings_pagedate_error_tip']             = 'Questo mese finalmente non è di 31 giorni.[br /]La data dovrebbe avere il seguente formato:';

// ---------- page advanced settings
$langFile['EDITOR_advancedpageSettings_h1']                     = 'Impostazioni Avanzate';

$langFile['EDITOR_advancedpageSettings_field1']                 = 'Pagina stylesheet-file';
$langFile['EDITOR_advancedpageSettings_stylesheet_ifempty']     = 'Quando tutti i campi sono vuoti, verra utilizzato la prima impostazione del foglio di stile, la categoria sarà utilizzata anche se il foglo di stile è vuoto e potra essere editato con l\'editor HTML delle impostazioni.';

$langFile['EDITOR_htmleditor_hotkeys_h1']                       = 'Tasti di scelta rapida';
$langFile['EDITOR_htmleditor_hotkeys_field1']                   = 'seleziona tutto';
$langFile['EDITOR_htmleditor_hotkeys_field2']                   = 'copia';
$langFile['EDITOR_htmleditor_hotkeys_field3']                   = 'incolla';
$langFile['EDITOR_htmleditor_hotkeys_field4']                   = 'taglia';
$langFile['EDITOR_htmleditor_hotkeys_field5']                   = 'undo';
$langFile['EDITOR_htmleditor_hotkeys_field6']                   = 'redo';
$langFile['EDITOR_htmleditor_hotkeys_field7']                   = 'set link';
$langFile['EDITOR_htmleditor_hotkeys_field8']                   = 'bold';
$langFile['EDITOR_htmleditor_hotkeys_field9']                   = 'italic';
$langFile['EDITOR_htmleditor_hotkeys_field10']                  = 'underline';
$langFile['EDITOR_htmleditor_hotkeys_or']                       = 'oppure';

$langFile['EDITOR_savepage_error_save']                        .= $langFile['ERROR_SAVE_FOLDER_PART1'].'%spages/'.$langFile['ERROR_FOLDER_PART2'];// also in en.shared.php

// ---------- plugin settings
$langFile['EDITOR_pluginSettings_h1']                           = 'Impostazioni Plugin';

/*
* unsavedPage.php
*/

$langFile['unsavedPage_question_h1']                            = '<span class="brown">La pagina è stata modificata.</span><br>Vuoi salvare la pagina ora?';

/*
* deletePage.php
*/

// ---------- DELETE PAGE
$langFile['deletePage_question_part1']                          = 'Sei sicuro di voler eliminare la pagina';
$langFile['deletePage_question_part2']                          = '?';

$langFile['deletePage_notexisting_part1']                       = 'La pagina';
$langFile['deletePage_notexisting_part2']                       = 'non esiste';

$langFile['deletePage_finish_error']                            = 'ERRORE: La pagina non può essere cancellata!';

/*
* pageThumbnailDelete.php
*/

// ---------- PAGE THUMBNAIL DELETE
$langFile['PAGETHUMBNAIL_TEXT_DELETE_QUESTION_START']           = 'Sei sicuro di voler cancellare la miniatura della pagina';
$langFile['PAGETHUMBNAIL_TEXT_DELETE_QUESTION_END']             = '?';
$langFile['PAGETHUMBNAIL_ERROR_DELETE']                         = 'ERRORE: La miniatura non può essere cancellata!';


/*
* pageThumbnailUpload.php
*/

// ---------- PAGE THUMBNAIL UPLOAD
$langFile['pagethumbnail_h1_part1']                             = 'Carica miniatura della pagina di';
$langFile['pagethumbnail_h1_part2']                             = '';
$langFile['pagethumbnail_field1']                               = 'Seleziona immagine';

$langFile['pagethumbnail_thumbinfo_formats']                    = 'Solo i seguenti formati di file sono autorizzati'; //<br><b>JPG</b>, <b>JPEG</b>, <b>GIF</b>, <b>PNG</b>
$langFile['pagethumbnail_thumbinfo_filesize']                   = 'file di dimensione massima';
$langFile['pagethumbnail_thumbinfo_standardthumbsize']          = 'Dimensioni immagine standard';

$langFile['pagethumbnail_thumbsize_h1']                         = 'Impostare la dimensione immagine manualmente';
$langFile['pagethumbnail_thumbsize_width']                      = 'Larghezza';
$langFile['pagethumbnail_thumbsize_height']                     = 'Altezza';

$langFile['pagethumbnail_submit_tip']                           = 'Carica immagine';

$langFile['PAGETHUMBNAIL_ERROR_nofile']                         = 'Non hai selezionato un file.';
$langFile['PAGETHUMBNAIL_ERROR_nouploadedfile']                 = 'Nessun file è stato caricato.';
$langFile['PAGETHUMBNAIL_ERROR_filesize']                       = 'La dimensione del file di immagine caricata è probabilmente troppo grande.<br>La dimensione massima del file è';
$langFile['PAGETHUMBNAIL_ERROR_wrongformat']                    = 'Il file selezionato ha un formato non supportato';
$langFile['PAGETHUMBNAIL_ERROR_NODIR_START']                    = 'Cartella anteprima'; // The thumbnail-folder..
$langFile['PAGETHUMBNAIL_ERROR_NODIR_END']                      = 'non esiste.';
$langFile['PAGETHUMBNAIL_ERROR_CREATEDIR_END']                  = 'non può essere creata.';
$langFile['PAGETHUMBNAIL_ERROR_COULDNTMOVEFILE']                = 'Impossibile spostare il file caricato nella cartella delle miniature %s.';
$langFile['PAGETHUMBNAIL_ERROR_CHANGEIMAGESIZE']                = 'Impossibile ridimensionare l\'immagine.';
$langFile['PAGETHUMBNAIL_ERROR_deleteoldfile']                  = 'Impossibile eliminare le vecchie minuature.';
$langFile['PAGETHUMBNAIL_TEXT_fileexists']                      = 'Un immagine con questo nome esiste già.<br>Il file caricato è stato rinominato';
$langFile['PAGETHUMBNAIL_TEXT_finish']                          = 'Immagine caricata con successo.';

// -> BACKUP

$langFile['BACKUP_TITLE_BACKUP']                                = 'Backup';
$langFile['BACKUP_TITLE_RESTORE']                               = 'Ripristina';

$langFile['BACKUP_TITLE_RESTORE_FROMFILES']                     = 'Scegli un backup esistente';
$langFile['BACKUP_TITLE_RESTORE_FROMUPLOAD']                    = 'Carica file di backup';

$langFile['BACKUP_TEXT_RESTORE_BACKUPBEFORERESTORE']            = 'Backup prima del ripristino';

$langFile['BACKUP_BUTTON_DOWNLOAD']                             = 'crea backup corrente';
$langFile['BACKUP_TEXT_BACKUP']                                 = 'Un backup crea una cartella in un file <code>nomefile.zip</code> con le <span class="blue">pagine del sito, i file di configurazione</span> e i <span class="blue"> file delle statistiche</span> I backup servono per ripristinare uno stato precedente dell\'intero sito web.<br><b>ATTENZIONE</b>. La cartella di upload non verrà salvata nel backup ma dovrà essere salvata via FTP.';
$langFile['BACKUP_TEXT_RESTORE']                                = 'Seleziona qui un <span class="logoname"><span>fein</span>dura</span> backup file, per ripristinare uno stato precedente.<br><span class="blue">Un backup dello stato attuale verrà creato prima di quello del ripristino.</ span>';
$langFile['BACKUP_TOOLTIP_DELETE']                              = 'Elimina backup';
$langFile['BACKUP_TEXT_DELETE_QUESTION']                        = 'Vuoi davvero cancellare questo %s?'; // really delete backup 2010-11-05 15:03?

$langFile['BACKUP_TITLE_LASTBACKUPS']                           = 'Scarica i backups';
$langFile['BACKUP_TEXT_NOBACKUP']                               = 'Nessun backup è stato ancora creato.';

$langFile['BACKUP_ERROR_FILENOTFOUND']                          = 'Il backup non è stato trovato:';
$langFile['BACKUP_ERROR_NORESTROEFILE']                         = 'Nessun file di backup da ripristinare è stato selezionato.';
$langFile['BACKUP_ERROR_DELETE']                                = 'Il backup non può essere cancellato!';


// -----------------------------------------------------------------------------------------------
// RETURN ****************************************************************************************
// -----------------------------------------------------------------------------------------------
return $langFile;

?>