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
 * FRENCH (FR) language-file for the feindura CMS (BACKEND)
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

$langFile['LOGIN_INPUT_USERNAME']                                         = 'nom d&#145;utilisateur';
$langFile['LOGIN_INPUT_PASSWORD']                                         = 'mot de passe';
$langFile['LOGIN_BUTTON_LOGIN']                                           = 'Login';
$langFile['LOGIN_TEXT_COOKIESNEEDED']                                     = 'Cookies doivent être activés!';

$langFile['LOGIN_LINK_FORGOTPASSWORD']                                    = 'Mot de passe oublié?';
$langFile['LOGIN_LINK_BACKTOLOGIN']                                       = 'Aller au login';
$langFile['LOGIN_BUTTON_SENDNEWPASSWORD']                                 = 'Réinitialiser mon mot de passe';
$langFile['LOGIN_TEXT_NEWPASSWORDEMAIL_SUBJECT']                          = 'mot de passe feindura CMS commandé';
$langFile['LOGIN_TEXT_NEWPASSWORDEMAIL_MESSAGE']                          = 'Tu as commandé un nouveau mot de passe pour ton feindura - Flat File CMS.
Le login et ton nouveau mot de passe sont:';

$langFile['LOGIN_ERROR_FORGOTPASSWORD_NOEMAIL']                           = 'Utilisateur na pas laissé dadrèsse éléctronique.';
$langFile['LOGIN_ERROR_FORGOTPASSWORD_NOTSEND']                           = 'FEHLER<br>pendant lenvoy du nouveau mot de passe pour ladrèsse éléctronique de lutilisateur.';
$langFile['LOGIN_ERROR_FORGOTPASSWORD_NOTSAVED']                          = 'FEHLER<br>impossible de sauvegarder le nouveau mot de passe.';
$langFile['LOGIN_ERROR_FORGOTPASSWORD_SUCCESS']                           = 'Un nouveau mot de passe a été envoyé à ladrèsse suivante';

$langFile['LOGIN_ERROR_WRONGUSER']                                        = 'utilisateur nexiste pas';
$langFile['LOGIN_ERROR_WRONGPASSWORD']                                    = 'mot de passe incorrect';

$langFile['LOGIN_TEXT_LOGOUT_PART1']                                      = 'déconnexion avec succès ';
$langFile['LOGIN_TEXT_LOGOUT_PART2']                                      = 'diriger vers site web';

$langFile['LOGIN_TIP_AUTOLOGOUT']                                         = 'déconnexion automatique';


// -> GENERAL <-

$langFile['DATE_Y-M-D']                                                   = 'AAAA-MM-JJ';
$langFile['DATE_D.M.Y']                                                   = 'JJ.MM.AAAA';
$langFile['DATE_D/M/Y']                                                   = 'JJ/MM/AAAA';
$langFile['DATE_M/D/Y']                                                   = 'MM/JJ/AAAA';

$langFile['CATEGORIES_TEXT_NONCATEGORY']                                  = 'pages';
$langFile['CATEGORIES_TOOLTIP_NONCATEGORY']                               = 'pages sans catégorie';
$langFile['TEXT_EXAMPLE']                                                 = 'par exemple';

$langFile['HEADER_BUTTON_GOTOWEBSITE_FRONTENDEDITING']                    = 'Feindura::S&#145;il vous plaît cliquez ici pour éditer les pages directement sur votre site web.';

$langFile['BUTTON_MORE']                                                  = 'plus';

// PERMISSIONS
$langFile['PERMISSIONS_TEXT_DONTHAVEPERMISSION']                          = 'Vous n&#145;êtes pas autorisé à changer cette situation.';

// THUMBNAILS
$langFile['THUMBNAIL_TEXT_UNIT']                                          = 'pixel';
$langFile['THUMBNAIL_TEXT_NAME']                                          = 'miniature de la page';
$langFile['THUMBNAIL_TEXT_WIDTH']                                         = 'thumbnail <b>largeur</b>';
$langFile['THUMBNAIL_TEXT_HEIGHT']                                        = 'thumbnail <b>hauteur</b>';
$langFile['THUMBNAIL_TOOLTIP_WIDTH']                                      = 'largeur standard::La largeur du thumbnail en pixels.[br][br]L&#145;image téléchargée sera mise à l&#145;échelle normée.';
$langFile['THUMBNAIL_TOOLTIP_HEIGHT']                                     = 'hauteur standard::La hauteur du thumbnail en pixels.[br][br]L&#145;image téléchargée sera mise à l&#145;échelle normée.';
$langFile['THUMBNAIL_TEXT_RATIO']                                         = 'rapport largeur/hauteur';
$langFile['THUMBNAIL_TEXT_KEEPRATIO']                                     = 'garder le rapport largeur/hauteur';
$langFile['THUMBNAIL_TEXT_FIXEDRATIO']                                    = 'rapport largeur/hauteur fix';
$langFile['THUMBNAIL_TOOLTIP_FIXEDRATIO']                                 = 'Largeur et hauteur peuvent être adjustée ou fixée.';
$langFile['THUMBNAIL_TOOLTIP_KEEPRATIO_X']                                = 'Sera alignée selon la [strong]largeur[/strong].';
$langFile['THUMBNAIL_TOOLTIP_KEEPRATIO_Y']                                = 'Sera alignée selon la [strong]hauteur[/strong].';

// STYLESHEETS
$langFile['STYLESHEETS_TEXT_STYLEFILE']                                   = 'fichier feuille de style';
$langFile['STYLESHEETS_TEXT_ID']                                          = 'Id feuille de style';
$langFile['STYLESHEETS_TEXT_CLASS']                                       = 'classement de feuille de style';

$langFile['STYLESHEETS_TOOLTIP_STYLEFILE']                                = 'Ici des feuilles de style peuvent être indiquées pour l&#145;utilisation dans le html éditeur afin de former le contenu.';
$langFile['STYLESHEETS_TOOLTIP_ID']                                       = 'Ici un attribut ID peut être indiqué pour l&#145;attribuer au tag de l&#145;éditeur HTML-Editor <body>.';
$langFile['STYLESHEETS_TOOLTIP_CLASS']                                    = 'Ici un attribut class peut être indiqué pour l&#145;attribuer au tag de l&#145;éditeur HTML-Editor <body>.';

$langFile['STYLESHEETS_TOOLTIP_ADDSTYLEFILE']                             = 'ajouter fichier feuille de style';
$langFile['STYLESHEETS_EXAMPLE_STYLEFILE']                                = '<b>par exemple</b> &quot;/style/layout.css&quot;';

// PATHS
$langFile['PATHS_TEXT_ABSOLUTE']                                          = 'chemin absolue';
$langFile['PATHS_TEXT_RELATIVE']                                          = 'chemin relative';
$langFile['PATHS_TOOLTIP_ABSOLUTE']                                       = 'chemin absolue::Chemin de système de fichiers absolu. (Mais par rapport à la DocumentRoot)[br][br][span class=hint]/server/htdocs[strong]/chemin/[/strong][/span]';
$langFile['PATHS_TOOLTIP_RELATIVE']                                       = 'chemin relative::Chemin de l&#145;URI relative, signifie par rapport au document courant.';

// STATISTICS
$langFile['STATISTICS_TITLE_BROWSERCHART']                                = 'spectre des navigateurs des visiteurs';
$langFile['STATISTICS_TEXT_ROBOTCOUNT']                                   = 'web-crawler';
$langFile['STATISTICS_TOOLTIP_ROBOTCOUNT']                                = 'web-crawler::Aussi nommé robot d&#145;indexation sont des scripts des moteurs de recherche qui analysent et indicent des sites web.';
$langFile['STATISTICS_TEXT_SEARCHWORD_PART1']                             = 'a'; // "exampleword" led 20 times to this website
$langFile['STATISTICS_TEXT_SEARCHWORD_PART2']                             = 'mèné sur ce site';
$langFile['STATISTICS_TOOLTIP_SEARCHWORD']                                = 'Cliquez dessus pour chercher le mot de recherche dans toutes les pages.';

$langFile['STATISTICS_TEXT_VISITORCOUNT']                                 = 'visites à ce jour';
$langFile['STATISTICS_TEXT_CURRENTVISITORS']                              = 'visiteurs présents';
$langFile['STATISTICS_TEXT_CURRENT']                                      = 'Actuellement';
$langFile['STATISTICS_TEXT_LASTACTIVITY']                                 = 'Ultima attività';

$langFile['STATISTICS_TITLE_PAGESTATISTICS']                              = 'statistiques du pages';

$langFile['STATISTICS_TEXT_VISITTIME_MAX']                                = 'temps de visite le plus longs';
$langFile['STATISTICS_TEXT_VISITTIME_MIN']                                = 'temps de visite le plus court';
$langFile['STATISTICS_TEXT_FIRSTVISIT']                                   = 'de';
$langFile['STATISTICS_TEXT_LASTVISIT']                                    = 'à';
$langFile['STATISTICS_TEXT_NOVISIT']                                      = 'Personne a visité ce site web.';
$langFile['STATISTICS_TEXT_SEARCHWORD_DESCRIPTION']                       = '<span class="toolTipTop" title="::Qui ont mèné
Google, Yahoo ou Bing (MSN) sur ce site web">Mot de recherche</span>';

$langFile['STATISTICS_TEXT_HOUR_SINGULAR']                                = 'heur';
$langFile['STATISTICS_TEXT_HOUR_PLURAL']                                  = 'heures';
$langFile['STATISTICS_TEXT_MINUTE_SINGULAR']                              = 'minute';
$langFile['STATISTICS_TEXT_MINUTE_PLURAL']                                = 'minutes';
$langFile['STATISTICS_TEXT_SECOND_SINGULAR']                              = 'seconde';
$langFile['STATISTICS_TEXT_SECOND_PLURAL']                                = 'secondes';
$langFile['STATISTICS_TEXT_BROWSERCHART_OTHERS']                          = 'autres';

// LOG TEXTS
$langFile['LOG_PAGE_SAVED']                                               = 'site sauvegardé';
$langFile['LOG_PAGE_NEW']                                                 = 'page nouvelle crée';
$langFile['LOG_PAGE_DELETE']                                              = 'page éffacée';
$langFile['LOG_PAGE_MOVEDINCATEGORY']                                     = 'page mise dans catégorie';
$langFile['LOG_PAGE_MOVEDTOCATEGORY_CATEGORY']                            = 'a la catégorie'; // Example Page in Category
$langFile['LOG_PAGE_SORTED']                                              = 'page mis à l&#145;lordre';
$langFile['LOG_THUMBNAIL_UPLOAD']                                         = 'téléchargé nouveau thumbnail';
$langFile['LOG_THUMBNAIL_DELETE']                                         = 'thumbnail éffacé';
$langFile['LOG_USER_ADD']                                                 = 'nouveau utilisateur crée';
$langFile['LOG_USER_DELETED']                                             = 'utilisateur éffacé';
$langFile['LOG_USER_PASSWORD_CHANGED']                                    = 'mot de passe changé';
$langFile['LOG_USER_SAVED']                                               = 'utilisateur sauvegardé';

$langFile['LOG_ADMINSETUP_SAVED']                                         = 'nouveaux préférences l&#145;administrateur sauvegardé';
$langFile['LOG_ADMINSETUP_CKSTYLES']                                      = '&quot;choix des syles&quot; de l&#145;éditeur HTML sauvegardé';
$langFile['LOG_WEBSITESETUP_SAVED']                                       = 'préférences site web sauvegardé';
$langFile['LOG_STATISTICSETUP_SAVED']                                     = 'préférences statistiques sauvegardé';
$langFile['LOG_CLEARSTATISTICS_WEBSITESTATISTIC']                         = 'préférences statistiques éffacé';
$langFile['LOG_CLEARSTATISTICS_PAGESTATISTICS']                           = 'préférences site web éffacés';
$langFile['LOG_CLEARSTATISTICS_PAGESTAYLENGTH']                           = 'statistiques sur le temps de visite éffacées';
$langFile['LOG_CLEARSTATISTICS_REFERERLOG']                               = 'referrer-log éffacé';
$langFile['LOG_CLEARSTATISTICS_ACTIVITYLOG']                              = 'log des dernières activités éffacé';
$langFile['LOG_PAGESETUP_SAVED']                                          = 'préférences site web sauvegardé';
$langFile['LOG_PAGESETUP_CATEGORIES_SAVED']                               = 'catégories sauvegardés';

$langFile['LOG_PAGESETUP_CATEGORIES_NEW']                                 = 'nouvelle catégorie crée';
$langFile['LOG_PAGESETUP_CATEGORIES_DELETED']                             = 'catégorie éffacée';
$langFile['LOG_PAGESETUP_CATEGORIES_MOVED']                               = 'catégorie déplacée';

$langFile['LOG_FILE_SAVED']                                               = 'fichier sauvegardé';
$langFile['LOG_FILE_DELETED']                                             = 'fichier sauvegardé';

$langFile['LOG_BACKUP_CREATED']                                           = 'sauvegarde créée';
$langFile['LOG_BACKUP_RESTORED']                                          = 'restauration de sauvegarde';
$langFile['LOG_BACKUP_DELETED']                                           = 'supprimé de sauvegarde';

$langFile['LOG_PAGELANGUAGE_DELETED']                                     = 'Supprimé la langue &quot;%s&quot; pour la page';
$langFile['LOG_PAGELANGUAGE_ADD']                                         = 'Ajouter la langue &quot;%s&quot; pour la page';


// PAGE/CATEGORY STATUS
$langFile['STATUS_PAGE_PUBLIC']                                           = 'site web public';
$langFile['STATUS_PAGE_NONPUBLIC']                                        = 'site web caché';
$langFile['STATUS_CATEGORY_PUBLIC']                                       = 'catégorie est public';
$langFile['STATUS_CATEGORY_NONPUBLIC']                                    = 'catégorie est cachée';

// USER LIST
$langFile['USER_TEXT_USER']                                               = 'Utilisateur';
$langFile['USER_TEXT_NOUSER']                                             = 'Il n&#145;y avait pas les utilisateurs.';
$langFile['USER_TEXT_CURRENTUSER']                                        = 'C&#145;est vous!';
$langFile['USER_TEXT_USERSONLINE']                                        = 'Cet utilisateur est connecté:: Dernières activités';

$langFile['LOGO_TEXT']                                                    = 'Version';
$langFile['txt_logo_gotowebsite']                                         = 'Cliquez ici pour accéder à votre site Web.';


// CKEDITOR transport
$langFile['CKEDITOR_TITLE_LINKS']                                         = 'pages de feindura';
$langFile['CKEDITOR_TITLE_SNIPPETS']                                      = 'fragments de code';
$langFile['CKEDITOR_TEXT_SNIPPETS']                                       = 'Choisissez un fragments de code pour le placer dans la page.';
$langFile['CKEDITOR_BUTTON_EDITSNIPPET']                                  = 'Modifier fragment de code';
$langFile['CKEDITOR_TITLE_PLUGINS']                                       = 'plugins';
$langFile['CKEDITOR_BUTTON_EDITPLUGIN']                                   = 'Modifier le plugin';

$langFile['CKEDITOR_TEXT_PLUGINS']                                        = 'Choisissez un plugin pour le placer dans la page.';

// -> BUTTON TEXTS

// MAIN MENU
$langFile['BUTTON_DASHBOARD']                                             = 'Vue globale';
$langFile['BUTTON_PAGES']                                                 = 'Pages';
$langFile['BUTTON_ADDONS']                                                = 'Add-ons';
$langFile['BUTTON_WEBSITESETTINGS']                                       = 'Préférences site web';
$langFile['BUTTON_SEARCH']                                                = 'Fouiller tout le site web';

// ADMIN MENU
$langFile['HEADER_TITLE_ADMINMENU']                                       = 'Administration';
$langFile['BUTTON_ADMINSETUP']                                            = 'Préférences administrateur';
$langFile['BUTTON_PAGESETUP']                                             = 'Préférences site web';
$langFile['BUTTON_STATISTICSETUP']                                        = 'Préférences statistiques';
$langFile['BUTTON_USERSETUP']                                             = 'Utilisateurs';
$langFile['BUTTON_BACKUP']                                                = 'Sauvegardes';

// SUB MENU/FOOTER
$langFile['BUTTON_FILEMANAGER']                                           = 'gestionnaire des fichiers';
$langFile['BUTTON_TOOLTIP_FILEMANAGER']                                   = 'Gerér des fichiers et des images.';
$langFile['BUTTON_CREATEPAGE']                                            = 'nouvelle page';
$langFile['BUTTON_TOOLTIP_CREATEPAGE']                                    = 'Ccréer une nouvelle page.';
$langFile['BUTTON_DELETEPAGE']                                            = 'éffacer la page';
$langFile['BUTTON_TOOLTIP_DELETEPAGE']                                    = 'Éffacer cette page.';
$langFile['BUTTON_FRONTENDEDITPAGE']                                      = 'modifier la page dans le frontend';
$langFile['BUTTON_TOOLTIP_FRONTENDEDITPAGE']                              = 'Modifier cette page directement sur le site web.';
$langFile['BUTTON_THUMBNAIL_UPLOAD']                                      = 'télécharger thumbnail de la page';
$langFile['BUTTON_TOOLTIP_THUMBNAIL_UPLOAD']                              = 'Télécharger thumbnail pour cette page.';
$langFile['BUTTON_THUMBNAIL_DELETE']                                      = 'éffacer thumbnail de la page';
$langFile['BUTTON_TOOLTIP_THUMBNAIL_DELETE']                              = 'Éffacer thumbnail de cette page.';
$langFile['BUTTON_WEBSITELANGUAGE_ADD']                                   = 'Ajouter une langue';
$langFile['BUTTON_TOOLTIP_WEBSITELANGUAGE_ADD']                           = 'Ajouter une nouvelle langue sur cette page.';
$langFile['BUTTON_WEBSITELANGUAGE_DELETE']                                = 'supprimer langue';
$langFile['BUTTON_TOOLTIP_WEBSITELANGUAGE_DELETE']                        = 'Supprimer langue &quot;%s&quot; pour cette page.';
$langFile['BUTTON_SHOWINMENU']                                            = 'Afficher dans les menus';
$langFile['BUTTON_HIDEINMENU']                                            = 'Cacher dans les menus';
$langFile['BUTTON_TOOLTIP_SHOWHIDEINMENU']                                = 'Détermine si la page est affichée dans les menus ou non.';

// OTHER BUTTONS
$langFile['BUTTON_UP']                                                    = 'vers le haut';
$langFile['BUTTON_INFO']                                                  = 'Infos';
$langFile['BUTTON_EDIT']                                                  = 'Modifier';
$langFile['BUTTON_RESET']                                                 = 'Restaurer';
$langFile['BUTTON_OK']                                                    = 'OK';

// -> GENERAL ERROR TEXTS
$langFile['ERROR_SAVE_SETTINGS']                                          = '<b>Les préférences ne peuvent pas être sauvegardés.</b>';
$langFile['ERROR_SAVE_FILE']                                              = '<br><br>Svp contrôlez les droits d&#145;écriture du fichier:';

$langFile['ERROR_READ_FOLDER_PART1']                                      = '<br><br>Svp contrôlez les droits de lecture des &quot;';
$langFile['ERROR_SAVE_FOLDER_PART1']                                      = '<br><br>Svp contrôlez les droits d&#145;écriture des &quot;';

$langFile['ERROR_FOLDER_PART2']                                           = '&quot; fichiers, du sous-fichier et des dossier.';

// -> WARNINGS
$langFile['WARNING_TITLE_STARTPAGE']                                      = 'La page d&#145;acceuil n&#145;est pas définie.';
$langFile['WARNING_TEXT_STARTPAGE']                                       = 'Svp définissez une page d&#145;acceuil.<br>Gehe zu <a href="?site=pages">'.$langFile['BUTTON_PAGES'].'</a> und klicke bei der gewünschten Seite auf das <span class="icons startpage"></span> Symbol';

$langFile['WARNING_TITLE_DOCUMENTROOT']                                   = 'Le Document Root ne pouvait pas être résolus automatiquement!';
$langFile['WARNING_TEXT_DOCUMENTROOT']                                    = 'Pour <span class="feinduraInline">fein<em>dura</em></span> pour fonctionner correctement, vous devez définir le DocumentRoot manuellement dans le <a href="?site=adminSetup#adminSettings">administrator-settings</a>.';

$langFile['WARNING_TITLE_BASEPATH']                                       = '<span class="feinduraInline">fein<em>dura</em></span> n&#145;a pas encore été configuré!';
$langFile['WARNING_TEXT_BASEPATH']                                        = 'La <i>chemin de base</i>ne correspond pas avec les préférences l&#145;administrateur.<br>
Cliquez sur <a href                                                       ="?site=adminSetup#adminSettings">préférences administrateur</a> et met en service ton <span class="feinduraInline">fein<em>dura</em></span> CMS';

$langFile['WARNING_TITLE_JAVASCRIPT']                                     = 'Activer le javascript';
$langFile['WARNING_TEXT_JAVASCRIPT']                                      = '<strong>Pour <span class="feinduraInline">fein<em>dura</em></span> utiliser complètement le javasrcipt doit être activé!</strong>';

$langFile['WARNING_TITLE_UNTITLEDCATEGORIES']                             = 'Manquant les noms des catégories';

$langFile['DASHBOARD_TITLE_IEWARNING']                                    = '<span class="feinduraInline">fein<em>dura</em></span> ne fonctionne pas avec une ancienne version de l&#145;Internet Explorer.';
$langFile['DASHBOARD_TEXT_IEWARNING']                                     = 'Pour <span class="feinduraInline">fein<em>dura</em></span> utiliser le CMS entièrement, version 9 de l&#145;IE est nécessaire.<br><br>Svp installez une nouvelle version de l&#145;Internet Explorer,<br> ou bien installez <a href="http://www.google.com/chromeframe" target="_blank">Google Chrome Frame Plugin</a> pour l&#145;IE,<br> ou bien téléchargez <a href="http://www.mozilla.org/firefox/">Firefox</a> ou <a href="http://www.google.com/chrome/">Chrome</a> Browser.';

$langFile['GENERAL_TEXT_CURRENTLYEDITED']                                 = 'Page est actuellement en cours de modification...';

// MESSAGES
$langFile['MESSAGE_TEXT_CHANGEDSTATUS']                                   = 'L&#145;état a été modifié avec succès.';
$langFile['MESSAGE_TEXT_CHANGEDSHOWINMENU']                               = 'L&#145;état du menu a été modifié avec succès.';

/*
* leftSidebar.loader.php
*/

// ---------- QUICKMENU
$langFile['SIDEBARMENU_TITLE_CATEGORIES']                                 = 'catégories';
$langFile['SIDEBARMENU_TITLE_PAGES']                                      = 'pages de';

/*
* dashboard.php
*/

// ---------- DASHBOARD
$langFile['DASHBOARD_TITLE_USERINFO']                                     = 'utilisateurs';
$langFile['DASHBOARD_TITLE_WELCOME']                                      = 'Bienvenue au content management system <span class="feinduraInline">fein<em>dura</em></span><br> de ton site web';

$langFile['DASHBOARD_TITLE_STATISTICS']                                   = 'statistiques du site web';
$langFile['DASHBOARD_TITLE_USER']                                         = 'utilisateur';
$langFile['DASHBOARD_TITLE_ACTIVITY']                                     = 'dernières activités';
$langFile['DASHBOARD_TEXT_ACTIVITY_NONE']                                 = 'null';

$langFile['DASHBOARD_TITLE_STATISTICS_MOSTVISITED']                       = 'pages les plus fréquentées';
$langFile['DASHBOARD_TITLE_STATISTICS_LASTVISITED']                       = 'dernières pages visitées';
$langFile['DASHBOARD_TITLE_STATISTICS_LASTEDITED']                        = 'dernières pages rédigées';
$langFile['DASHBOARD_TITLE_STATISTICS_LONGESTVIEWED']                     = 'pages les plus regardés';
$langFile['DASHBOARD_TITLE_REFERER']                                      = 'sites web d&#145;où viennent les derniers visiteurs';

/*
* listPages.php
*/

// ---------- PAGES SORTABLE LIST
$langFile['SORTABLEPAGELIST_h1']                                          = 'contenu de ton site web';
$langFile['SORTABLEPAGELIST_headText1']                                   = 'filtre';
$langFile['SORTABLEPAGELIST_headText3']                                   = 'visiteurs';
$langFile['SORTABLEPAGELIST_headText4']                                   = 'status';
$langFile['SORTABLEPAGELIST_headText5']                                   = 'fonctions';

$langFile['SORTABLEPAGELIST_TIP_PAGEDATE']                                = 'date sur le site web';
$langFile['SORTABLEPAGELIST_TIP_LASTEDIT']                                = 'dernièrement rédigé';
$langFile['SORTABLEPAGELIST_TIP_TAGS']                                    = 'tags';
$langFile['SORTABLEPAGELIST_TIP_LOCALIZATION']                            = 'langues';

$langFile['SORTABLEPAGELIST_TIP_SORTALPHABETICAL']                        = 'triés par ordre alphabétique';
$langFile['SORTABLEPAGELIST_TIP_SORTBYPAGEDATE']                          = 'trié par ordre chronologique';

$langFile['SORTABLEPAGELIST_functions_editPage']                          = 'rédiger la page';
$langFile['SORTABLEPAGELIST_TIP_CHANGESTATUS']                            = 'Cliquer ici pour changer le status.';

$langFile['SORTABLEPAGELIST_TOOLTIP_LANGUAGEMISSING']                     = 'langues disparues';

$langFile['file_error_read']                                              = '<b>lecture du site web impossible.</b>'.$langFile['ERROR_READ_FOLDER_PART1'].'%spages/'.$langFile['ERROR_FOLDER_PART2'];
$langFile['SORTABLEPAGELIST_setStartPage_error_save']                     .= $langFile['ERROR_SAVE_FILE'].' &quot;%sconfig/website.config.php&quot;'; // also in fr.shared.php
$langFile['SORTABLEPAGELIST_changeStatusPage_error_save']                 = '<b>le status du site web ne pouvé pas être changé.</b>'.$langFile['ERROR_SAVE_FOLDER_PART1'].'%spages/'.$langFile['ERROR_FOLDER_PART2'];
$langFile['SORTABLEPAGELIST_changeStatusCategory_error_save']             = '<b>le status de la catégorie ne pouvé pas être changé.</b>'.$langFile['ERROR_SAVE_FOLDER_PART1'].'%spages/'.$langFile['ERROR_FOLDER_PART2'];
$langFile['SORTABLEPAGELIST_info']                                        = 'L&#145;ordre du site web peut être changé <b>ordre site web</b> par <b>Drag and Drop</b> ainsi que les pages peuvent être interchangées entre les catégories différentes.';
$langFile['SORTABLEPAGELIST_save']                                        = 'sauvegarder le nouvel ordre ...';
$langFile['SORTABLEPAGELIST_save_finished']                               = 'nouvel ordre sauvegardé!';
$langFile['SORTABLEPAGELIST_error_save']                                  = '<b>les pages ne pouvaient pas être sauvgardées.</b>'.$langFile['ERROR_SAVE_FOLDER_PART1'].'%spages/'.$langFile['ERROR_FOLDER_PART2'];
$langFile['SORTABLEPAGELIST_error_read']                                  = '<b>les pages ne pouvaient pas être lus.</b>'.$langFile['ERROR_READ_FOLDER_PART1'].'%spages/'.$langFile['ERROR_FOLDER_PART2'];
$langFile['SORTABLEPAGELIST_error_move']                                  = '<b>la page ne pouvait pas être mise dans la nouvelle catégorie.</b>'.$langFile['ERROR_SAVE_FOLDER_PART1'].'%spages/'.$langFile['ERROR_FOLDER_PART2'];
$langFile['SORTABLEPAGELIST_categoryEmpty']                               = 'Keine Seiten vorhanden';
$langFile['SORTABLEPAGELIST_TIP_DRATOREARRANGE']                          = 'Faites glisser pour réorganiser.';

$langFile['SORTABLEPAGELIST_TIP_SUBCATEGORYOFPAGES_SINGULAR']             = 'Sous-catégorie de la page:';
$langFile['SORTABLEPAGELIST_TIP_SUBCATEGORYOFPAGES_PLURAL']               = 'Sous-catégorie des pages:';

// ---------- FORMULAR
$langFile['FORM_BUTTON_SUBMIT']                                           = 'sauvegarder';
$langFile['FORM_BUTTON_CANCEL']                                           = 'réinitialiser les dossiers';


/*
* adminSetup.php
*/

// ---------- ADMIN SETUP (on toolTips tooTips.js converts the "[" and "]" tags in the title attribute to "<" ">")
$langFile['ADMINSETUP_TEXT_VERSION']                                      = '<span class="feinduraInline">fein<em>dura</em></span> Version';
$langFile['ADMINSETUP_TEXT_PHPVERSION']                                   = 'PHP Version';
$langFile['ADMINSETUP_TITLE_DOCUMENTROOT']                                = 'Document Root';
$langFile['ADMINSETUP_TITLE_ERROR']                                       = 'des erreurs se sont produites';
$langFile['ADMINSETUP_TOOLTIP_WRITEACCESSERROR']                          = 'Pour les fichiers et les dossiers les droits de lecture doivent être mis sur %o.';
$langFile['ADMINSETUP_TEXT_WRITEACCESSERROR']                             = 'n&#145;est pas descriptible';
$langFile['ADMINSETUP_TEXT_ISFOLDERERROR']                                = 'n&#145;est pas un dossier';

// ---------- general Settings
$langFile['ADMINSETUP_GENERAL_error_save']                                = $langFile['ERROR_SAVE_SETTINGS'].$langFile['ERROR_SAVE_FILE'].'%sconfig/admin.config.php';
$langFile['ADMINSETUP_GENERAL_h1']                                        = 'configuration de base';

$langFile['ADMINSETUP_GENERAL_TEXT_DOCUMENTROOT']                         = 'DocumentRoot';
$langFile['ADMINSETUP_GENERAL_TOOLTIP_DOCUMENTROOT']                      = 'S&#145;il vous plaît entrez dans la racine du document manuellement.[br][span class=hint]p.e. &quot;/server/user/htdocs&quot;[/span]';
$langFile['ADMINSETUP_GENERAL_field1']                                    = 'URL site web';
$langFile['ADMINSETUP_GENERAL_field1_tip']                                = 'L&#145;URL de votre site web sera mise automatiquement.';
$langFile['ADMINSETUP_GENERAL_field1_inputTip']                           = 'L&#145;URL sera mise automatiquement';
$langFile['ADMINSETUP_GENERAL_field1_inputWarningText']                   = 'Svp sauvegardez la configuration!';
$langFile['ADMINSETUP_GENERAL_field2']                                    = 'chemin du feindura';
$langFile['ADMINSETUP_GENERAL_field2_tip']                                = 'La chemin principale sera estimé automatiquement et sauvegardé avec la configuration.';
$langFile['ADMINSETUP_GENERAL_field2_inputTip']                           = 'La chemin principale sera mise automatiquement';
$langFile['ADMINSETUP_GENERAL_field2_inputWarningText']                   = 'Svp sauvegardez la configuration!';
$langFile['ADMINSETUP_GENERAL_field8']                                    = 'chemin du site web';
$langFile['ADMINSETUP_GENERAL_field8_tip']                                = 'Le [strong]chemin absolue[/strong], contenant les site web.[br][br][span class=hint]Peut également contenir des noms de fichiers, par exemple &quot;/siteweb/index.php&quot;[/span]';
$langFile['ADMINSETUP_GENERAL_editfiles_additonal']                       = '[br][br]ces fichiers peuvent être rédigés plus bas ou dans le paramètrages du site web (si cette option est activé pour le site web).[br][br]';
$langFile['ADMINSETUP_GENERAL_field5']                                    = 'chemin d&#145;un dossier des fichiers';
$langFile['ADMINSETUP_GENERAL_field5_tip']                                = 'Ici, vous pouvez ajouter un chemin vers les fichiers spécifiques pour la site web, ce qui devrait être modifiable dans [span class=feinduraInline]fein[em]dura[/em][/span].'.$langFile['ADMINSETUP_GENERAL_editfiles_additonal'];
$langFile['ADMINSETUP_GENERAL_field6']                                    = 'chemin des feuilles de style';
$langFile['ADMINSETUP_GENERAL_field6_tip']                                = 'Ici, vous pouvez ajouter un chemin vers les fichiers stylesheet, ce qui devrait être modifiable dans [span class=feinduraInline]fein[em]dura[/em][/span].'.$langFile['ADMINSETUP_GENERAL_editfiles_additonal'];
$langFile['ADMINSETUP_GENERAL_TEXT_PERMISSIONS']                          = 'autorisations des fichiers et des répertoires';
$langFile['ADMINSETUP_GENERAL_TIP_PERMISSIONS']                           = 'Chaque fichier ou un dossier créé par [span class=feinduraInline]fein[em]dura[/em][/span] obtiendrez ces autorisations.';
$langFile['ADMINSETUP_TEXT_VARNAMEPAGE']                                  = 'Nom de l&#145;URL page';
$langFile['ADMINSETUP_TEXT_VARNAMECATEGORY']                              = 'Nom de l&#145;URL catégorie';
$langFile['ADMINSETUP_TEXT_VARNAMEMODUL']                                 = 'Nom de l&#145;URL modul';
$langFile['ADMINSETUP_TIP_VARNAME']                                       = 'Le nom qui sera utilisé dans l&#145;URL pour vous reliez les pages.';
$langFile['ADMINSETUP_TIP_EMPTYVARNAME']                                  = 'si le panneua est vide, le nom standard sera utilisé: ';
$langFile['ADMINSETUP_TEXT_TIMEZONE']                                     = 'heure locale';
$langFile['ADMINSETUP_TIP_TIMEZONE']                                      = 'Ne seront utilisées que par les [span class=feinduraInline]fein[em]dura[/em][/span] backend.';
$langFile['ADMINSETUP_GENERAL_PRETTYURL']                                 = 'format URL';
$langFile['ADMINSETUP_GENERAL_PRETTYURL_true']                            = 'Pretty URLs';
$langFile['ADMINSETUP_GENERAL_PRETTYURL_true_example']                    = '/%s/category-name/example-page';
$langFile['ADMINSETUP_GENERAL_PRETTYURL_false']                           = 'URL avec variables';
$langFile['ADMINSETUP_GENERAL_PRETTYURL_false_example']                   = 'index.php?%s=1&%s=1';
$langFile['ADMINSETUP_GENERAL_PRETTYURL_tip']                             = 'Le format de d&#145;URL pour le référencement du site web.[br][br]Pretty URLs fonctionnent seulement si [strong]Apache Server[/strong] le [strong]mod_rewrite[/strong] module est disponible.';
$langFile['ADMINSETUP_GENERAL_PRETTYURL_warning']                         = 'Attention!::[span class=red]Si des erreurs se produisent pendant l&#145;utilisation des Pretty URLs, le fichier [strong].htaccess[/strong] dans la chemin documentaire root du serveur doit être éffacé.[/span][br][br](dans certains logiciels FTP les fichiers cachés doivent être indiqués pour montrer le fichier .htaccess)';

// ---------- Pretty url ERRORs
$langFile['ADMINSETUP_GENERAL_PRETTYURL_error_save']                      = '<b>Pretty URLs</b> ne pouvaient pas être activés'.$langFile['ERROR_SAVE_FILE'].'/.htaccess';
$langFile['ADMINSETUP_GENERAL_PRETTYURL_error_modul']                     = '<b>Pretty URLs</b> ne pouvait pas être activé à cause du module Apache module: MOD_REWRITE peut pas être trouvé';

// ---------- cache settings
$langFile['ADMINSETUP_TEXT_CACHE']                                        = 'activer le cache';
$langFile['ADMINSETUP_TIP_CACHE']                                         = 'Si active, toutes les pages seront mises en cache. Cela peut graine jusqu&#145;à le site, mais conduit également à pas de contenu réel.[br][br][span class=hint]La mise en cache sera rafraîchi, lors de l&#145;édition des pages.[/span]';
$langFile['ADMINSETUP_TEXT_CACHETIMEOUT']                                 = 'cache expiration';
$langFile['ADMINSETUP_TIP_CACHETIMEOUT']                                  = 'Indique le délai après lequel le cache sera rafraîchi.';
$langFile['ADMINSETUP_HINT_CACHETIMEOUT']                                 = 'heures';

// ---------- editor Settings
$langFile['adminSetup_editorSettings_h1']                                 = 'paramètres de l&#145;éditeur HTML';
$langFile['ADMINSETUP_TEXT_EDITOR_HTMLLAWED']                             = 'filtre HTML (utilise <a href="http://www.bioinformatics.org/phplabware/internal_utilities/htmLawed/" target="_blank">htmlLawed</a>)';
$langFile['ADMINSETUP_TIP_EDITOR_HTMLLAWED']                              = 'Filtres du code HTML avant d&#145;enregistrer. Cela peut causer des problèmes dans le code HTML avec beaucoup de Javascript.';
$langFile['ADMINSETUP_TEXT_EDITOR_SAFEHTML']                              = 'secure HTML (<a href="http://www.bioinformatics.org/phplabware/internal_utilities/htmLawed/htmLawed_README.htm#s3.6" target="_blank">détails</a>)';
$langFile['ADMINSETUP_TIP_EDITOR_SAFEHTML']                               = 'Le code HTML sera filtrée avec la plus sûre paramètres. Cela signifie par exemple &lt;applet&gt;,&lt;embed&gt;,&lt;embed&gt;,&lt;object &gt; et &lt;script&gt; tags ne sont pas autorisés.';
$langFile['ADMINSETUP_TEXT_EDITOR_EDITORSTYLES']                          = 'activer style-sélection';
$langFile['ADMINSETUP_TIP_EDITOR_EDITORSTYLES']                           = 'Le styles-sélection vous permet d&#145;utiliser personnalisé des éléments HTML dans l&#145;éditeur HTML.[br][br][span class=hint]Si cette option est activée, vous pouvez éditer/créer des éléments HTML plus bas.[/span]';
$langFile['ADMINSETUP_TEXT_EDITOR_SNIPPETS']                              = 'activer fragments de code';
$langFile['ADMINSETUP_TIP_EDITOR_SNIPPETS']                               = 'Permettent de placer fragments de code dans les pages.[br]Cliquez sur l&#145;icône dans la l&#145;éditeur HTML: [img class=icons src=library/thirdparty/ckeditor/plugins/feinduraSnippets/feinduraSnippetsIcon.png][br][br][span class=hint]Si cette option est activée, vous pouvez éditer/créer des fragments de code plus bas.[/span]';
$langFile['adminSetup_editorSettings_field1']                             = 'modus ENTER-touche';
$langFile['adminSetup_editorSettings_field1_hint']                        = 'SHIFT + ENTER va créer un &quot;%s&quot;';
$langFile['adminSetup_editorSettings_field1_tip']                         = 'Va définir le HTML-tag en touchant la touche entrée[br]wird.[br][br][span class=hint]'.$langFile['adminSetup_editorSettings_field1_hint'].'.[/span]';
$langFile['adminSetup_editorSettings_field3_inputTip']                    = 'Si la case reste vide, aucune Id sera utilisé.';
$langFile['adminSetup_editorSettings_field4_inputTip']                    = 'Si la case reste vide, aucune classe sera utilisé.';

// THUMBNAILS Settings
$langFile['adminSetup_thumbnailSettings_h1']                              = 'paramètres thumbnail du site';

// ---------- styleFile Settings
$langFile['adminSetup_styleFileSettings_h1']                              = 'Modifier les styles-sélection de l&#145;éditeur HTML';
$langFile['adminSetup_styleFileSettings_error_save']                      = '<b>le fichier &quot;EditorStyles.js&quot; ne pouvait pas être sauvegardé.</b>'.$langFile['ERROR_SAVE_FILE'];

// ---------- editFiles Settings
$langFile['EDITFILESSETTINGS_TITLE_STYLESHEETS']                          = 'traiter les feuilles de style';
$langFile['EDITFILESSETTINGS_TITLE_WEBSITEFILES']                         = 'traiter les dossiers du site web';
$langFile['EDITFILESSETTINGS_TITLE_SNIPPETS']                             = 'Modifier les fragments de code';
$langFile['EDITFILESSETTINGS_TEXT_NODIR']                                 = 'pas de dossier valable!';
$langFile['EDITFILESSETTINGS_TEXT_CHOOSEFILE']                            = 'choisir fichier';
$langFile['EDITFILESSETTINGS_TEXT_CREATEFILE']                            = 'créer nouveau fichier';
$langFile['EDITFILESSETTINGS_TIP_CREATEFILE']                             = 'Si vous mettez le nom d&#145;un fichier ici, un nouveau fichier sera crée,[br]et [strong]le donnée choisi actuellement ne sera pas sauvegardé![/strong]';
$langFile['EDITFILESSETTINGS_TEXT_NOFILE']                                = 'Actuellement pas de dossiers';
$langFile['EDITFILESSETTINGS_TEXT_DELETEFILE']                            = 'éffacer fichier';
$langFile['EDITFILESSETTINGS_TEXT_DELETEFILE_QUESTION']                   = 'voulez-vous supprimer le fichier $s?';

$langFile['EDITFILESSETTINGS_ERROR_SAVEFILE']                             = '<b>le fichier ne pouvait pas être sauvegardé.</b>'.$langFile['ERROR_SAVE_FILE'];
$langFile['EDITFILESSETTINGS_ERROR_DELETEFILE']                           = '<b>le fichier ne pouvait pas être éffacé.</b>'.$langFile['ERROR_SAVE_FILE'];

/*
* pageSetup.php
*/

// ---------- CATEGORY SETUP (on toolTips tooTips.js converts the "[" and "]" tags in the title attribute to "<" ">")
$langFile['PAGESETUP_PAGES_TIP_TAG']                                      = 'Les tags peuvent être utilisés pour mettre en relation les pages entre eux (dépendant de le programmation du site web)';

// ---------- page settings
$langFile['PAGESETUP_PAGES_TITLE_NONCATEGORYPAGES']                       = 'pages sans catégories';
$langFile['PAGESETUP_PAGES_TEXT_CREATEPAGES']                             = 'créer/éffacer des pages';
$langFile['PAGESETUP_PAGES_TIP_CREATEPAGES']                              = 'Définit si l&#145;utilisateur peut créer/éffacer une page sans catégorie.';
$langFile['PAGESETUP_PAGES_TEXT_UPLOADTHUMBNAILS']                        = 'télécharger thumbnails';
$langFile['PAGESETUP_PAGES_TIP_UPLOADTHUMBNAILS']                         = 'Définit si l&#145;utilisateur peut télécharger des thumbnails au sein des pages sans catégories.';
$langFile['PAGESETUP_PAGES_TEXT_EDITTAGS']                                = 'traiter tags';
$langFile['PAGESETUP_PAGES_TIP_EDITTAGS']                                 = 'Définit si l&#145;utilisateur peut traiter des tags au sein des pages sans catégories.[br]'.$langFile['PAGESETUP_PAGES_TIP_TAG'];
$langFile['PAGESETUP_PAGES_TEXT_ACTIVATEPLUGINS']                         = 'activer plugins';
$langFile['PAGESETUP_PAGES_TIP_ACTIVATEPLUGINS']                          = 'Définit si l&#145;utilisateur peut utiliser des plugins au sein des pages.';

// ---------- category settings
$langFile['PAGESETUP_CATEGORY_TITLE_CATEGORIES']                          = 'gestion des catégories';
$langFile['PAGESETUP_CATEGORY_TEXT_CATEGORYNAME']                         = 'nom';
$langFile['PAGESETUP_CATEGORY_TEXT_CREATECATEGORY']                       = 'créer nouvelle catégorie';
$langFile['PAGESETUP_CATEGORY_TEXT_CREATECATEGORY_CREATED']               = 'nouvelle catégorie crée';
$langFile['PAGESETUP_CATEGORY_TEXT_CREATECATEGORY_UNNAMED']               = 'catégorie n&#145;est pas nommé';

$langFile['PAGESETUP_CATEGORY_TEXT_DELETECATEGORY']                       = 'éffacer la catégorie';
$langFile['PAGESETUP_CATEGORY_TEXT_DELETECATEGORY_WARNING']               = 'ATTENTION: Toutes les pages au sein de cette catégorie seront éffacées!';
$langFile['PAGESETUP_CATEGORY_TEXT_DELETECATEGORY_DELETED']               = 'catégorie éffacée';
$langFile['PAGESETUP_CATEGORY_TEXT_DELETECATEGORY_QUESTION_START']        = 'catégorie'; // éffacer catégorie "test"?
$langFile['PAGESETUP_CATEGORY_TEXT_DELETECATEGORY_QUESTION_END']          = 'éffacer?';

$langFile['PAGESETUP_CATEGORY_TEXT_MOVECATEGORY_MOVED']                   = 'catégorie déplacée';
$langFile['PAGESETUP_CATEGORY_TIP_MOVECATEGORY_UP']                       = 'Déplacer la catégorie vers le haut.';
$langFile['PAGESETUP_CATEGORY_TIP_MOVECATEGORY_DOWN']                     = 'Déplacer la catégorie vers le bas.';

$langFile['PAGESETUP_CATEGORY_ERROR_CREATECATEGORY']                      = '<b>Une nouvelle catégorie ne pouvait pas être crée.</b>'.$langFile['ERROR_SAVE_FOLDER_PART1'].'%sconfig/'.$langFile['ERROR_FOLDER_PART2'];
$langFile['PAGESETUP_CATEGORY_ERROR_CREATEDIR']                           = '<b>Un répertoire de catégorie ne pouvait pas être crée.</b>'.$langFile['ERROR_SAVE_FOLDER_PART1'].'%spages/'.'&quot; Ordners.';
$langFile['PAGESETUP_CATEGORY_ERROR_DELETECATEGORY']                      = '<b>La catégorie ne pouvait pas être éffacée.</b>'.$langFile['ERROR_SAVE_FILE'].'%sconfig/category.config.php';
$langFile['PAGESETUP_CATEGORY_ERROR_DELETEDIR']                           = '<b>Le répertoire de catégorie ne pouvait pas être éffacé.</b>'.$langFile['ERROR_SAVE_FOLDER_PART1'].'%spages/'.$langFile['ERROR_FOLDER_PART2'];
$langFile['PAGESETUP_CATEGORY_ERROR_SAVE']                                = $langFile['ERROR_SAVE_SETTINGS'].$langFile['ERROR_SAVE_FILE'].'%sconfig/category.config.php';

$langFile['PAGESETUP_CATEGORY_TITLE_ADVANCEDSETTINGS']                    = 'paramètres avancés';
$langFile['PAGESETUP_CATEGORY_HINT_ADVANCEDSETTINGS']                     = 'Si vous avez mis toutes les paramètres, les paramètres des thumbnails seront automatiquement écrasé les Wenn diese Einstellungen ausgefüllt sind überschreiben sie die Seiten-Thumbnail-Einstellungen weiter oben und die '.$langFile['adminSetup_editorSettings_h1'].' in den <a href="?site=adminSetup">Administrator-Einstellungen</a>.';
$langFile['PAGESETUP_CATEGORY_TIP_STYLESHEETS_EMPTY']                     = 'Si toutes les cases restent vides, les paramètres des stylesheet seront automatiquement'.$langFile['adminSetup_editorSettings_h1'].' exécutés.';
$langFile['PAGESETUP_CATEGORY_TEXT_CATEGORYSTATUS']                       = 'status de la catégorie';
$langFile['PAGESETUP_CATEGORY_TIP_CATEGORYSTATUS']                        = 'Définit si une catégorie sera publiée sur le site web.';
$langFile['PAGESETUP_CATEGORY_TEXT_CREATEPAGES']                          = 'créer/éffacer page';
$langFile['PAGESETUP_CATEGORY_TIP_CREATEPAGES']                           = 'Définit si un utilisateur peut créer/éffacer des pages dans cette catégorie.';
$langFile['PAGESETUP_CATEGORY_TEXT_UPLOADTHUMBNAILS']                     = 'télécharger thumbnails';
$langFile['PAGESETUP_CATEGORY_TIP_UPLOADTHUMBNAILS']                      = 'Définit si un utilisateur peut télécharger des thumbnails dans chaque page de cette catégorie.';
$langFile['PAGESETUP_CATEGORY_TEXT_EDITTAGS']                             = 'traiter tags';
$langFile['PAGESETUP_CATEGORY_TIP_EDITTAGS']                              = 'Tags peuvent être définis pour la catégorie de cette page.[br]'.$langFile['PAGESETUP_PAGES_TIP_TAG'];
$langFile['PAGESETUP_CATEGORY_TEXT_ACTIVATEPLUGINS']                      = 'activer plugins';
$langFile['PAGESETUP_CATEGORY_TIP_ACTIVATEPLUGINS']                       = 'Activer plugins pour les pages de cette catégorie';

$langFile['PAGESETUP_TEXT_EDITPAGEDATE']                                  = 'traiter la date du page';
$langFile['PAGESETUP_TIP_EDITPAGEDATE']                                   = 'La date du page peu être utilisé pour trier des pages par ordre chronologique.';
$langFile['PAGESETUP_TEXT_PAGEDATERANGE']                                 = 'comme période.';

$langFile['PAGESETUP_TEXT_FEEDS']                                         = 'activez Feeds';
$langFile['PAGESETUP_TIP_FEEDS']                                          = 'Activer RSS 2.0 et Atom Feed pour les pages sans catégorie.';
$langFile['PAGESETUP_CATEGORY_TIP_FEEDS']                                 = 'Activer RSS 2.0 et Atom Feed pour les pages de cette catégorie.';

$langFile['PAGESETUP_TEXT_SUBCATEGORY']                                   = 'traiter les sous-catégories';
$langFile['PAGESETUP_TIP_SUBCATEGORY']                                    = 'Permet de choisir une sous-catégorie pour chaque page.';

$langFile['PAGESETUP_TIP_SORTBYPAGEDATE']                                 = 'pages triée par date de pages';
$langFile['PAGESETUP_TIP_SORTBYDATE']                                     = 'Pages avec un plus jeune date apparaissent à la [strong]top[/strong].[br][br][span class=hint]Manuellement trier n&#145;est plus possible.[/span]';

$langFile['PAGESETUP_TEXT_SORTMANUALLY']                                  = 'trier les pages manuellement';
$langFile['PAGESETUP_TIP_SORTMANUALLY']                                   = 'Nouvellement créé la pages apparaissent à la [strong]top[/strong].';

$langFile['PAGESETUP_TEXT_SORTALPHABETICAL']                              = 'trier les pages par ordre alphabétique';
$langFile['PAGESETUP_TIP_SORTALPHABETICAL']                               = '[span class=hint]Manuellement trier n&#145;est plus possible.[/span]';

$langFile['PAGESETUP_TEXT_SORTREVERSE']                                   = 'inverti l&#145; ordre de tri';
$langFile['PAGESETUP_TIP_SORTREVERSE']                                    = 'Inverti l&#145; ordre de tris de les pages.';


/*
* websiteSetup.php
*/

// ---------- WEBSITE SETUP (on toolTips tooTips.js converts the "[" and "]" tags in the tittle attribute to "<" ">")
$langFile['websiteSetup_websiteConfig_error_save']                        = $langFile['ERROR_SAVE_SETTINGS'].$langFile['ERROR_SAVE_FILE'].'%sconfig/website.config.php';
$langFile['websiteSetup_websiteConfig_h1']                                = 'paramètres du site web';
$langFile['websiteSetup_websiteConfig_field1']                            = 'titre du site web';
$langFile['websiteSetup_websiteConfig_field1_tip']                        = 'Le titre du site web sera indiqué dans le navigateur.';
$langFile['websiteSetup_websiteConfig_field2']                            = 'publisher';
$langFile['websiteSetup_websiteConfig_field2_tip']                        = 'Le nom de l&#145;organisation/entreprise/personne publiant ce site.';
$langFile['websiteSetup_websiteConfig_field3']                            = 'copyright';
$langFile['websiteSetup_websiteConfig_field3_tip']                        = 'Le propriétaire du copyright du site web.';
$langFile['websiteSetup_websiteConfig_field4']                            = 'mots clés des moteurs de recherche';
$langFile['websiteSetup_websiteConfig_field4_tip']                        = 'La plupart des moteurs de recherche fouillent le contenu des pages selon des mots clés. Mettez des mots clés qui seront utilisez dans <meta> les tags du site web.';
$langFile['websiteSetup_websiteConfig_field4_inputTip']                   = 'Les mots clés doivent être séparées en &quot;,&quot; ::'.$langFile['TEXT_EXAMPLE'].':[br]mot-clé1,mot-clé2,etc';
$langFile['websiteSetup_websiteConfig_field5']                            = 'description du site web';
$langFile['websiteSetup_websiteConfig_field5_tip']                        = 'Une courte description de votre site web utilisé par les moteurs de recherche. Les mots-clé se trouveront dans l&#145;URL du site web mais dans le contenu.';
$langFile['websiteSetup_websiteConfig_field5_inputTip']                   = 'Un texte court en 3 lignes.';

$langFile['WEBSITESETUP_TITLE_PAGESETTINGS']                              = 'paramètres avancés du site web';
$langFile['WEBSITESETUP_TEXT_MAINTENANCE']                                = 'désactiver site web';
$langFile['WEBSITESETUP_TIP_MAINTENANCE']                                 = 'Affiche un message au lieu du site, qui dit que le site est actuellement en cours d&#145;édition.';
$langFile['WEBSITESETUP_TEXT_SITEMAPFILES']                               = 'Créer des fichiers Sitemap (<a href="http://www.sitemaps.org/" target="_blank">détails</a>)';
$langFile['WEBSITESETUP_TIP_SITEMAPFILES']                                = 'Les fichiers sitemap simplifier les moteurs de recherche à l&#145;index de ce site.';
$langFile['WEBSITESETUP_TEXT_VISITORTIMEZONE']                            = 'Obtenez Fuseau horaire Visiteurs';
$langFile['WEBSITESETUP_TIP_VISITORTIMEZONE']                             = 'Tenter d&#145;obtenir le fuseau horaire du visiteur, pour afficher les divulgations de temps en temps local du visiteur.[br][br][span class=hint]Le site sera rechargé à la première visite.[/span]';
$langFile['WEBSITESETUP_TEXT_MULTILANGUAGEWEBSITE']                       = 'site web multi-langues';
$langFile['WEBSITESETUP_TEXT_MAINLANGUAGE']                               = 'La langue principale';
$langFile['WEBSITESETUP_TIP_MAINLANGUAGE']                                = 'La langue principale sera choisi, si aucune langue correspondante pourrait être déterminé automatiquement.';
$langFile['WEBSITESETUP_TEXT_DATEFORMAT']                                 = 'format de date';
$langFile['WEBSITESETUP_TIP_DATEFORMAT']                                  = 'Qui est utilisé dans la site Web.';


/*
* statisticSetup.php
*/

// ---------- STATISITC SETUP (on toolTips tooTips.js converts the "[" and "]" tags in the tittle attribute to "<" ">")
$langFile['STATISTICSSETUP_ERROR_SAVE']                                   = $langFile['ERROR_SAVE_SETTINGS'].$langFile['ERROR_SAVE_FILE'].'%sconfig/statistic.config.php';

$langFile['STATISTICSSETUP_TITLE_STATISTICSSETTINGS']                     = 'paramètres des statistiques';
$langFile['STATISTICSSETUP_TEXT_REFERERNUMBER']                           = 'nombre des <b>Referrer-URLs</b>';
$langFile['STATISTICSSETUP_TIP_REFERERNUMBER']                            = 'Indique le nombre maximal des Referrer-URLs ([i]URL qui ont mènés sur ce site web[/i]).';
$langFile['STATISTICSSETUP_TEXT_ACTIVITYNUMBER']                          = 'nombre des <b>logs-activités</b>';
$langFile['STATISTICSSETUP_TIP_ACTIVITYNUMBER']                           = 'Indique le nombre des logs-activités seront sauvegardés au maximum.';

$langFile['statisticSetup_clearStatistic_h1']                             = 'éffacer statistiques';
$langFile['statisticSetup_clearStatistics_websiteStatistic']              = 'statistiques du site web';
$langFile['statisticSetup_clearStatistics_websiteStatistic_tip']          = '[strong]Contient[/strong][ul][li]tout le nombre des visites[/li][li]nombre des web-crawler[/li][li]date de la première visite[/li][li]date de la dernière visite[/li][li]spectre des navigateurs utilisés[/li][/ul]';
$langFile['statisticSetup_clearStatistics_pagesStatistic']                = 'statistiques des pages';
$langFile['statisticSetup_clearStatistics_pagesStatistic_tip']            = '[strong]Contient[/strong][ul][li]nombre de visites[/li][li]date de la première visite[/li][li]date de la dernière visite[/li][li]temps de visite le plus court[/li][li]temps de visite le plus long[/li][li]mots-clé des moteurs de recherche qui ont mènés sur le site web[/li][/ul]';
$langFile['statisticSetup_clearStatistics_pagesStaylengthStatistics']     = 'seulement les statistiques temps-de-visite';
$langFile['statisticSetup_clearStatistics_pagesStaylengthStatistics_tip'] = '';
$langFile['statisticSetup_clearStatistics_refererLog']                    = 'Referrer-URLs Log'; // engl.: referer
$langFile['statisticSetup_clearStatistics_refererLog_tip']                = 'Une liste avec tous les URLs qui ont mèné sur le site web.';
$langFile['statisticSetup_clearStatistics_taskLog']                       = 'Logs des dernièrses activités';
$langFile['statisticSetup_clearStatistics_taskLog_tip']                   = 'Contient une liste des dernières activités.';
$langFile['statisticSetup_clearStatistics_question_h1']                   = 'Voulez vous vraiment éffacer ces statistiques?';
$langFile['statisticSetup_clearStatistic_pagesStatistics_error_read']     = 'une erreur s&#145;est produite pendant l&#145;éffacement des statistiques du site web.'.$langFile['ERROR_SAVE_FOLDER_PART1'].'%sstatistics/pages/'.$langFile['ERROR_FOLDER_PART2'];

/*
* userSetup.php
*/

$langFile['USERSETUP_h1']                                                 = 'administration utilisateur';
$langFile['USERSETUP_userSelection']                                      = 'utilisateur';

$langFile['USERSETUP_createUser']                                         = 'créer nouveau utilisateur';
$langFile['USERSETUP_createUser_created']                                 = 'nouveau utilisateur crée';
$langFile['USERSETUP_createUser_unnamed']                                 = 'utilisateur inconnu';

$langFile['USERSETUP_deleteUser']                                         = 'éffacer utilisateur';
$langFile['USERSETUP_deleteUser_deleted']                                 = 'utilisateur éffacé';

$langFile['USERSETUP_username']                                           = 'nom dutilisateur';
$langFile['USERSETUP_username_missing']                                   = 'Pas de nom dutilisateur pour ce profil.';
$langFile['USERSETUP_password']                                           = 'mot de passe';
$langFile['USERSETUP_password_change']                                    = 'changer le mot de passe';
$langFile['USERSETUP_password_confirm']                                   = 'répeter le mot de passe';
$langFile['USERSETUP_password_confirm_wrong']                             = 'le deux mot de passe ne correspondent pas.';
$langFile['USERSETUP_password_missing']                                   = 'Pas de nouveau mot de passe pour ce profil.';
$langFile['USERSETUP_password_success']                                   = 'Mot de passe changé!';
$langFile['USERSETUP_email']                                              = 'adrèsse éléctronique';
$langFile['USERSETUP_email_tip']                                          = 'Si vous avev oubliez votre mot de passe, un email va être envoyé avec votre nouveau mot de passe.';

$langFile['USERSETUP_admin']                                              = 'administrateur';
$langFile['USERSETUP_admin_tip']                                          = 'Définit si lutilisateur possède les droits de ladministrateur.';

$langFile['USERSETUP_error_create']                                       = '<b>Un nouveau utilisateur na pas été crée.</b>'.$langFile['ERROR_SAVE_FILE'].'%sconfig/user.config.php';
$langFile['USERSETUP_error_save']                                         = $langFile['ERROR_SAVE_SETTINGS'].$langFile['ERROR_SAVE_FILE'].'%sconfig/user.config.php';

// ---------- USER PERMISSION
$langFile['USERSETUP_USERPERMISSIONS_TITLE']                              = 'permissions de l&#145;utilisateur';
$langFile['USERSETUP_USERPERMISSIONS_TEXT_ACTIVATEWEBSITESETTINGS']       = 'modifier paramètres du site web';
$langFile['USERSETUP_USERPERMISSIONS_TEXT_EDITWEBSITEFILES']              = 'modifier les fichiers du site web au sein du <a href="index.php?site=websiteSetup">paramétrage du site web</a>';
$langFile['USERSETUP_USERPERMISSIONS_TEXT_EDITSTYLESHEETS']               = 'modifier les fichiers de style au sein du <a href="index.php?site=websiteSetup">paramétrage du site web</a>';
$langFile['USERSETUP_USERPERMISSIONS_TEXT_EDITSNIPPETS']                  = 'modifier fragments de code au sein du <a href="index.php?site=websiteSetup">paramétrage du site web</a>';
$langFile['USERSETUP_USERPERMISSIONS_TEXT_FILEMANAGER']                   = 'activer gestionnaire de fichiers';
$langFile['USERSETUP_USERPERMISSIONS_TEXT_FRONTENDEDITING']               = 'activer pour modifier la page dans le frontend';

$langFile['USERSETUP_USERPERMISSIONS_TEXT_USERINFORMATION']               = '<strong>informations utilisateur</strong> in der <a href="?site=dashboard">'.$langFile['BUTTON_DASHBOARD'].'</a>';
$langFile['USERSETUP_USERPERMISSIONS_TIP_USERINFORMATION']                = 'Information utilisateur::Ce texte va être publié sur [span class=feinduraInline]fein[em]dura[/em][/span] '.$langFile['BUTTON_DASHBOARD'].'.';
$langFile['USERSETUP_USERPERMISSIONS_TIP_USERINFORMATION_NOINFO']         = 'N&#145;ecrivez rien dans la case, si vous ne voulez pas montrer des informations sur l&#145;utilisateur';

$langFile['USERSETUP_USERPERMISSIONS_TITLE_EDITABLECATEGORIES-PAGES']     = 'Sélectionnez Catégories et Pages que l&#145;utilisateur devrait être capable d&#145;éditer. (Si rien n&#145;est sélectionné, tout peut être modifié)';
$langFile['USERSETUP_USERPERMISSIONS_TEXT_CLEARSELECTION']                = 'Effacer la sélection';

/*
* editor.php
*/

// ---------- page info
$langFile['EDITOR_TITLE_CREATEPAGE']                                      = 'créer nouvelle page';
$langFile['EDITOR_TITLE_ADDLANGUAGE']                                     = 'Ajouter la langue &quot;%s&quot; à la page';
$langFile['EDITOR_pageinfo_lastsavedate']                                 = 'Dernière modification du';
$langFile['EDITOR_pageinfo_lastsaveauthor']                               = 'de';
$langFile['EDITOR_pageinfo_linktothispage']                               = 'lien mènant sur le site web';
$langFile['EDITOR_pageinfo_id']                                           = 'ID de la page';
$langFile['EDITOR_pageinfo_id_tip']                                       = 'Le site web sera sauvegardé sur le serveur sous cette ID.';
$langFile['EDITOR_pageinfo_category']                                     = 'catégorie';
$langFile['EDITOR_pageinfo_category_noCategory']                          = 'aucune catégorie';

$langFile['EDITOR_TEXT_CHOOSETEMPLATE']                                   = 'utiliser le modèle';
$langFile['EDITOR_TEXT_TEMPALATECOPYADDITION']                            = 'copier';

$langFile['EDITOR_block_edited']                                          = 'ont été édité';
$langFile['EDITOR_pageNotSaved']                                          = 'pas sauvegardé';

$langFile['EDITOR_EDITLINK']                                              = 'Modifier le lien';

// ---------- page settings
$langFile['EDITOR_pagestatistics_h1']                                     = 'statistiques';
$langFile['EDITOR_pageSettings_title']                                    = 'titre';
$langFile['EDITOR_pageSettings_title_tip']                                = 'Titre de la page, peut contenir les balises HTML suivantes:[br]<a> <span> <em> <strong> <i> <b> <abbr> <code> <samp> <kbd> <var>';
$langFile['EDITOR_pageSettings_field1']                                   = 'description courte';
$langFile['EDITOR_pageSettings_field1_inputTip']                          = 'Si la case reste vide la description du site web au sein des paramètres du site web sera utilisé.';
$langFile['EDITOR_pageSettings_field1_tip']                               = 'Une description courte du site web. Ceci va être mise dans les tags-META du site web.[br][br][span class=hint]'.$langFile['EDITOR_pageSettings_field1_inputTip'].'[/span]';
$langFile['EDITOR_pageSettings_field2']                                   = 'tags';
$langFile['EDITOR_pageSettings_field2_tip']                               = 'Tags sont des mots-clé de ce site web.';
$langFile['EDITOR_pageSettings_field2_tip_inputTip']                      = 'Les tags doivent être séparés par la &quot;,&quot; (virgule).';
$langFile['EDITOR_pageSettings_field3']                                   = 'date du site web';
$langFile['EDITOR_pageSettings_field3_tip']                               = 'La date peut être utilisée pour trier les pages dans l&#145;ordre chronologique. (par ex. des évenements)';
$langFile['EDITOR_pageSettings_field4']                                   = 'status de la page';
$langFile['EDITOR_pageSettings_field4_tip']                               = '[strong]Une page sera visible sur le site web seulement quand elle est publiée![/strong]';

$langFile['EDITOR_PAGESETTINGS_NOPAGEDATE']                               = 'Pas de date';

$langFile['EDITOR_TEXT_SUBCATEGORY']                                      = 'Sous-catégorie';
$langFile['EDITOR_TIP_SUBCATEGORY']                                       = 'Permet de créer un sous-menu pour cette page sur le site.';

$langFile['EDITOR_BUTTON_RESTORELASTSTATE']                               = 'Restaurer la version de %s';
$langFile['EDITOR_MESSAGE_RESTOREDTOLASTSTATE']                           = 'Version de %s restaurée.';

// ---------- page advanced settings
$langFile['EDITOR_advancedpageSettings_h1']                               = 'paramètres spécifique de la page de l&#145;éditor HTML';
$langFile['EDITOR_advancedpageSettings_field1']                           = 'page fichier feuille de style';
$langFile['EDITOR_advancedpageSettings_stylesheet_ifempty']               = 'Quand toutes les cases sont vides, les paramètres des feuilles de style de la catégorie seront utilisés. Si ceux-ci sont vides aussi, les paramètres de l&#145;éditeur HTML seront utlisés.';
$langFile['EDITOR_htmleditor_hotkeys_h1']                                 = 'touches-clés';
$langFile['EDITOR_htmleditor_hotkeys_field1']                             = 'tout sélectionner';
$langFile['EDITOR_htmleditor_hotkeys_field2']                             = 'copier';
$langFile['EDITOR_htmleditor_hotkeys_field3']                             = 'coller';
$langFile['EDITOR_htmleditor_hotkeys_field4']                             = 'couper';
$langFile['EDITOR_htmleditor_hotkeys_field5']                             = 'en arrière';
$langFile['EDITOR_htmleditor_hotkeys_field6']                             = 'réconstituer';
$langFile['EDITOR_htmleditor_hotkeys_field7']                             = 'créer un lien';
$langFile['EDITOR_htmleditor_hotkeys_field8']                             = 'gras';
$langFile['EDITOR_htmleditor_hotkeys_field9']                             = 'italique';
$langFile['EDITOR_htmleditor_hotkeys_field10']                            = 'souligné';
$langFile['EDITOR_htmleditor_hotkeys_or']                                 = 'ou';

$langFile['EDITOR_savepage_error_save']                                   .= $langFile['ERROR_SAVE_FOLDER_PART1'].'%spages/'.$langFile['ERROR_FOLDER_PART2'];// also in fr.shared.php

// ---------- plugin settings
$langFile['EDITOR_pluginSettings_h1']                                     = 'Ajouter plugins';
$langFile['EDITOR_TEXT_EDITPLUGINSINEDITOR']                              = 'Après avoir activé un plugin, survolez le plugin pour pouvoir le faire glisser dans l&#145;éditeur HTML, ou le placer directement dans l&#145;éditeur HTML, en utilisant l&#145;icône %s.';
$langFile['EDITOR_MESSAGE_PLUGINSSAVED']                                  = '<div class="alert alert-success">Plugins sauvé!</div>';//<div class="alert">Cliquez sur un plugin pour modifier ses propriétés.</div>';
$langFile['EDITOR_TIP_DRAGPLUGIN']                                        = 'Faites glisser le plugin dans l&#145;éditeur.';

/*
* unsavedPage.php
*/

$langFile['UNSAVEDPAGE_QUESTION_CONTINUE']                                 = 'La page a été modifiée!<br><span class="brown">Allez-vous continuer?</span>';

/*
* deletePage.php
*/

// ---------- DELETE PAGE
$langFile['deletePage_question_part1']                                    = 'Vous êtes sur de vraiment';
$langFile['deletePage_question_part2']                                    = 'vouloir éffacer le site?';
$langFile['deletePage_notexisting_part1']                                 = 'le site web';
$langFile['deletePage_notexisting_part2']                                 = 'n&#145;existe pas';
$langFile['deletePage_finish_error']                                      = 'ERREUR: La page ne pouvait pas être éffacée!';

/*
* deletePageLanguage.php
*/

// ---------- DELETE PAGE LANGUAGE

$langFile['WINDOWBOX_TEXT_DELETEPAGELANGUAGE_QUESTION']                   = 'Voulez-vous vraiment supprimer la langue &quot;%s&quot; pour cette page?';

/*
* addPageLanguage.php
*/

// ---------- ADD PAGE LANGUAGE

$langFile['WINDOWBOX_TEXT_ADDPAGE_SELECTLANGUAGE']                        = 'Sélectionnez la langue';


/*
* deletewebsiteLanguages.php
*/

// ---------- DELETE WEBSITE LANGUAGES

$langFile['WINDOWBOX_TITLE_DELETEWEBSITELANGUAGES_QUESTION']              = 'Les langues suivantes seront supprimées de toutes les pages!<br>&quot;%s&quot;';
$langFile['WINDOWBOX_TEXT_DELETEWEBSITELANGUAGES_QUESTION']               = 'Site web multi-langues était désactivé!<br>Toutes les pages seront mis à la langue principale ancienne (<b>%s</b>).';


/*
* deletePageThumbnail.php
*/

// ---------- PAGE THUMBNAIL DELETE
$langFile['PAGETHUMBNAIL_TEXT_DELETE_QUESTION_START']                     = 'Vous êtes sur de vraiment';
$langFile['PAGETHUMBNAIL_TEXT_DELETE_QUESTION_END']                       = 'éffacer le thumbnail de cette page?';
$langFile['PAGETHUMBNAIL_ERROR_DELETE']                                   = 'ERREUR: Le thumbnail ne pouvait pas être éffacée!';

/*
* uploadPageThumbnail.php
*/

// ---------- PAGE THUMBNAIL UPLOAD
$langFile['pagethumbnail_h1_part1']                                       = 'thumbnail de page pour';
$langFile['pagethumbnail_h1_part2']                                       = 'télécharger';
$langFile['pagethumbnail_field1']                                         = 'choisir image';
$langFile['pagethumbnail_thumbinfo_formats']                              = 'Seulement les formats suiovant seront acceptés'; //<br><b>JPG</b>, <b>JPEG</b>, <b>GIF</b>, <b>PNG</b>
$langFile['pagethumbnail_thumbinfo_filesize']                             = 'taille maximale';
$langFile['pagethumbnail_thumbinfo_standardthumbsize']                    = 'taille standard';
$langFile['pagethumbnail_thumbsize_h1']                                   = 'définir la taille de l&#145;image';
$langFile['pagethumbnail_thumbsize_width']                                = 'largeur de l&#145;image';
$langFile['pagethumbnail_thumbsize_height']                               = 'hauteur de l&#145;image';
$langFile['pagethumbnail_submit_tip']                                     = 'Télécharger l&#145;image.';
$langFile['PAGETHUMBNAIL_ERROR_nofile']                                   = 'Vous n&#145;avez pas choisi d&#145;image.';
$langFile['PAGETHUMBNAIL_ERROR_nouploadedfile']                           = 'Aucun fichier pouvait être téléchargé.';
$langFile['PAGETHUMBNAIL_ERROR_filesize']                                 = 'Le fichier télécharge est probablement trop grand.<br>Die maximal erlaubte Dateigröße beträgt';
$langFile['PAGETHUMBNAIL_ERROR_wrongformat']                              = 'Le fichier choisi n&#145;est pas dans le bon format.';
$langFile['PAGETHUMBNAIL_ERROR_NODIR_START']                              = 'le répertoire des thumbnails'; // ..thumbnail-folder..
$langFile['PAGETHUMBNAIL_ERROR_NODIR_END']                                = 'e&#145;existe pas.';
$langFile['PAGETHUMBNAIL_ERROR_CREATEDIR_END']                            = 'il ne pouvait pas être crée.';
$langFile['PAGETHUMBNAIL_ERROR_COULDNTMOVEFILE']                          = 'Le fichier téléchargé ne pouvait pas être déplacé dans le dossier des thumbnails %s.';
$langFile['PAGETHUMBNAIL_ERROR_CHANGEIMAGESIZE']                          = 'La taille de l&#145;image ne pouvait pas être changée.';
$langFile['PAGETHUMBNAIL_ERROR_deleteoldfile']                            = 'Le thumbnail récent ne pouvait pas être éffacé.';
$langFile['PAGETHUMBNAIL_TEXT_fileexists']                                = 'Il existe dèjà un fichier avec ce nom.<br>Le nom du fichier a été changé en';
$langFile['PAGETHUMBNAIL_TEXT_finish']                                    = 'L&#145;image a été télécharge avec succès';

// -> BACKUP

$langFile['BACKUP_TITLE_BACKUP']                                          = 'sauvegarde';
$langFile['BACKUP_TITLE_RESTORE']                                         = 'rétablir';

$langFile['BACKUP_TITLE_RESTORE_FROMFILES']                               = 'choisir de sauvegarde existant';
$langFile['BACKUP_TITLE_RESTORE_FROMUPLOAD']                              = 'télécharger le fichier de sauvegarde';

$langFile['BACKUP_TEXT_RESTORE_BACKUPBEFORERESTORE']                      = 'sauvegarde avant la récupération';

$langFile['BACKUP_BUTTON_DOWNLOAD']                                       = 'créer de sauvegarde actuelle';
$langFile['BACKUP_TEXT_BACKUP']                                           = 'Une sauvegarde crée un fichier <code>.zip</code> avec le <span class="blue">"pages", "config"</span> et <span class="blue">"statistic"</span>dossiers.<br>Le dossier de upload ne sera pas sauvé.';
$langFile['BACKUP_TEXT_RESTORE']                                          = '<p>Sélectionnez ici une <span class="feinduraName"><span>fein</span>dura</span> fichier de sauvegarde, de rétablir un état ancien.</p><div class="alert"><strong>Allusion</strong> Avant de restaurer une sauvegarde de état actuel est créé.</div>';
$langFile['BACKUP_TOOLTIP_DELETE']                                        = 'Supprimer sauvegarde.';
$langFile['BACKUP_TEXT_DELETE_QUESTION']                                  = '%s supprimer?'; // backup 2010-11-05 15:03 supprimer?

$langFile['BACKUP_TITLE_LASTBACKUPS']                                     = 'télécharger sauvegardes';
$langFile['BACKUP_TEXT_NOBACKUP']                                         = 'Pas de sauvegarde a été créé pour le moment.';

$langFile['BACKUP_ERROR_FILENOTFOUND']                                    = 'Sauvegarde n&#145;a pas été trouvé au chemin d&#145;accès:';
$langFile['BACKUP_ERROR_NORESTROEFILE']                                   = 'Il n&#145;y a pas de fichier de sauvegarde pour restaurer sélectionné.';
$langFile['BACKUP_ERROR_DELETE']                                          = 'Sauvegarde ne peut pas être supprimé!';

// -> ADDONS

$langFile['ADDONS_TITLE_ADDON']                                           = 'Sélectionnez un <span class="feinduraInline">fein<em>dura</em></span> Add-on';
$langFile['ADDONS_TEXT_AUTHOR']                                           = 'Auteur';
$langFile['ADDONS_TEXT_WEBSITE']                                          = 'Site Web';
$langFile['ADDONS_TEXT_VERSION']                                          = 'Version';
$langFile['ADDONS_TEXT_REQUIREMENTS']                                     = 'Exigences';


// -> UPDATE

$langFile['UPDATE_TITLE']                                                 = 'ALe contenu doit être mis à jour';
$langFile['UPDATE_TEXT_CHECKPATHS']                                       = 'Assurez-vous que les chemins d&#145;accès suivants sont corrects avant de vous mettre à jour.';
$langFile['UPDATE_TEXT_BASEPATH']                                         = 'Chemin vers <span class="feinduraInline">fein<em>dura</em></span>';
$langFile['UPDATE_TEXT_WEBSITEPATH']                                      = 'chemin d&#145;accès du site';
$langFile['UPDATE_TEXT_SUCCESS']                                          = 'Contenu mis à jour!';
$langFile['UPDATE_BUTTON_UPDATE']                                         = 'ACTUALISER';
$langFile['UPDATE_ERROR_MOVEUPLOADFOLDER']                                = 'Envoyer le dossier n&#145;a pas pu être déplacé! S&#145;il vous plaît déplacer le dossier "%s" manuellement "your_feindura_folder/upload/".';
$langFile['UPDATE_ERROR_MOVEPAGESFOLDER']                                 = 'Pages n&#145;a pas pu être copié! S&#145;il vous plaît déplacer le dossier "%s" manuellement "your_feindura_folder/pages/".';
$langFile['UPDATE_ERROR_SAVEADMINCONFIG']                                 = 'Paramètres administrateur n&#145;a pas pu être mis à jour.';
$langFile['UPDATE_ERROR_SAVECATEGORYCONFIG']                              = 'Paramètres catégorie n&#145;a pas pu être mis à jour.';
$langFile['UPDATE_ERROR_SAVEUSERCONFIG']                                  = 'Paramètres utilisateur n&#145;a pas pu être mis à jour.';
$langFile['UPDATE_ERROR_SAVEWEBSITECONFIG']                               = 'Paramètres du site n&#145;a pas pu être mis à jour.';
$langFile['UPDATE_ERROR_SAVEPAGES']                                       = 'Pages n&#145;a pas pu être mis à jour.';
$langFile['UPDATE_ERROR_CLEARACTIVITYLOG']                                = 'journal d&#145;activité ne peut pas être effacé.';
$langFile['UPDATE_ERROR_SAVEWEBSITESTATISTICS']                           = 'Statistiques du Site n&#145;a pas pu être mis à jour.';
$langFile['UPDATE_ERROR_SAVEREFERERLOG']                                  = 'Connexion Referer ne pouvait pas être mis à jour.';
$langFile['UPDATE_ERROR_DELETEOLDFILES']                                  = 'Impossible de supprimer les anciens fichiers et dossiers, <br> S&#145;il vous plaît vérifier ces fichiers et dossiers, et de les supprimer manuellement:';
$langFile['UPDATE_ERROR_RENAMESTATISTICSFOLDER']                          = 'Couldn\'t rename the "feinduraFolder/statistic" folder "feinduraFolder/statistic<strong>s</strong>, please rename it manually!"';

// -----------------------------------------------------------------------------------------------
// RETURN ****************************************************************************************
// -----------------------------------------------------------------------------------------------
return $langFile;
