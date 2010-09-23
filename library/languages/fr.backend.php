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
 * 
 * NEEDS a RETURN $langFile; at the END
 */

/* ----------------------------------------------------------------------------------------------
* --- LOGIN
*/

$langFile['login_username'] = 'Nome d&lsquo;utilisateur';
$langFile['login_password'] = 'Mot de passe';
$langFile['login_button_login'] = 'LOGIN';
$langFile['login_info_cookie'] = 'Les cookies doivent &ecirc;tre active';

$langFile['login_error_wrongUser'] = 'L&lsquo;utilisateur n&lsquo;existe pas';
$langFile['login_error_wrongPassword'] = 'mot de passe erron&eacute;';

$langFile['login_logout_part1'] = 'D&ecirc;connectez-vous avec succ&egrave;s';
$langFile['login_logout_part2'] = 'Suivant au le site web';
 
/* ----------------------------------------------------------------------------------------------
* --- GENERAL
*/

// ---------- thumbnail
$langFile['thumbSize_unit'] = 'pixel';
$langFile['thumbnail_name'] = 'miniature de la page';
$langFile['thumbnail_name_width'] = 'standard <b>largeur</b>';
$langFile['thumbnail_name_height'] = 'standard <b>hauteur</b>';
$langFile['thumbnail_tip'] = 'Eventuellement apr&egrave;s le t&eacute;l&eacute;chargement d&lsquo;un fichier, l&lsquo;image pr&eacute;cedente sera encore pr&eacute;sente ce qui se &eacute;ffectue par le cache du navigateur.[br /][br /]Pour voir l&lsquo;image actuelle, la page doit &ecirc;tre r&eacute;initalis&eacute;e.(F5).';
$langFile['thumbnail_width_tip'] = 'largeur standard::la largeur du thumbnail en pixels.[br /][br /]L&lsquo;image t&eacute;l&eacute;charg&eacute;e sera mise &agrave; l&lsquo;&eacute;chelle norm&eacute;e.';
$langFile['thumbnail_height_tip'] = 'hauteur standard::la hauteur du thumbnail en pixels.[br /][br /]L&lsquo;image t&eacute;l&eacute;charg&eacute;e sera mise &agrave; l&lsquo;&eacute;chelle norm&eacute;e.';
$langFile['thumbnail_ratio_name'] = 'rapport largeur/hauteur';
$langFile['thumbnail_ratio_fieldText'] = 'garder le rapport largeur/hauteur';
$langFile['thumbnail_ratio_noRatio'] = 'rapport largeur/hauteur fix';
$langFile['thumbnail_ratio_noRatio_tip'] = 'largeur et hauteur peuvent &ecirc;tre adjust&eacute;e ou fix&eacute;e';
$langFile['thumbnail_ratio_x_tip'] = 'sera align&eacute;e selon la [b]largeur[/b].';
$langFile['thumbnail_ratio_y_tip'] = 'sera align&eacute;e selon la [b]hauteur[/b].';

// ---------- stylesheet
$langFile['stylesheet_name_styleFile'] = 'fichier feuille de style';
$langFile['stylesheet_name_styleId'] = 'Id feuille de style';
$langFile['stylesheet_name_styleClass'] = 'classement de feuille de style';
$langFile['stylesheet_styleFile_tip'] = 'Ici des feuilles de style peuvent &ecirc;tre indiqu&eacute;es pour l&lsquo;utilisation dans le html &eacute;diteur afin de former le contenu.';
$langFile['stylesheet_styleId_tip'] = 'Ici un attribut ID peut &ecirc;tre indiqu&eacute; pour l&lsquo;attribuer au tag de l&lsquo;&eacute;diteur HTML <body>.';
  $langFile['stylesheet_styleClass_tip'] = 'Ici un attribut class peut &ecirc;tre indiqu&eacute; pour l&lsquo;attribuer au tag de l&lsquo;&eacute;diteur HTML.<body>.';
$langFile['stylesheet_styleFile_addButton_tip'] = 'ajouter fichier feuille de style';
$langFile['stylesheet_styleFile_example'] = '<b>example</b> "/style/layout.css"';

// ---------- paths
$langFile['path_absolutepath'] = 'trace absolue';
$langFile['path_relativepath'] = 'trace relative';
$langFile['path_absolutepath_tip'] = 'trace absolue';
$langFile['path_relativepath_tip'] = 'trace relative';

// ---------- STATISTIC
$langFile['home_browser_h1'] = 'spectre des navigateurs des visiteurs';
$langFile['log_spiderCount'] = 'web spiders';
$langFile['log_spiderCount_tip'] = 'robot d&lsquo;indexation::aussi nomm&eacute; Webcrawler sont des scripts des moteurs de recherche qui analysent et indicent des sites web.';
$langFile['log_searchwordtothissite_part1'] = 'a'; // "mot" a m&egrave;n&eacute; 20 fois sur ce site$langFile['log_searchwordtothissite_part2'] = 'm&egrave;n&eacute; sur ce site';
$langFile['log_searchwordtothissite_tip'] = 'Cliquez dessus pour chercher le mot de recherche dans toutes les pages.';
$langFile['log_visitCount'] = 'visiteurs';
$langFile['log_currentVisitors'] = 'visiteurs pr&eacute;sents';
$langFile['log_currentVisitors_lastActivity'] = 'visiteurs pr&eacute;sents';
$langFile['log_visitTime_max'] = 'temps de visite le plus longs';
$langFile['log_visitTime_min'] = 'temps de visite le plus court';
$langFile['log_firstVisit'] = 'premi&egrave;re visite';
$langFile['log_lastVisit'] = 'derni&egrave;re visite';
$langFile['log_novisit'] = 'Personne a visit&eacute; ce site web.';
$langFile['log_tags_description'] = 'Mot de recherche qui ont m&egrave;n&eacute;
<a href="http://www.google.de">Google</a>,
<a href="http://www.yahoo.de">Yahoo</a> ou
<a href="http://www.bing.com">Bing (MSN)</a> sur ce site web';
$langFile['log_notags'] = 'Aucun mot a m&egrave;n&eacute; sur ce site web.';
$langFile['log_hour_single'] = 'heur';
$langFile['log_hour_multiple'] = 'heures';
$langFile['log_minute_single'] = 'minute';
$langFile['log_minute_multiple'] = 'minutes';
$langFile['log_second_single'] = 'seconde';
$langFile['log_second_multiple'] = 'secondes';
$langFile['log_browser_others'] = 'autres';

/* ----------------------------------------------------------------------------------------------
* ---------- LOG TEXTs
*/

$langFile['log_page_saved'] = 'site sauvegard&eacute;';
$langFile['log_page_new'] = 'page nouvelle cr&eacute;e';
$langFile['log_page_delete'] = 'page &eacute;ffac&eacute;e';
$langFile['log_listPages_moved'] = 'page mise dans cat&eacute;gorie';
$langFile['log_listPages_moved_in'] = 'dans la cat&eacute;gorie'; // Example Page in Category
$langFile['log_listPages_sorted'] = 'page mis &agrave; l&lsquo;lordre';
$langFile['log_pageThumbnail_upload'] = 't&eacute;l&eacute;charg&eacute; nouveau thumbnail';
$langFile['log_pageThumbnail_delete'] = 'thumbnail &eacute;ffac&eacute;';
$langFile['log_userSetup_useradd'] = 'nouveau utilisateur cr&eacute;e';
$langFile['log_userSetup_userdeleted'] = 'utilisateur &eacute;ffac&eacute;';
$langFile['log_userSetup_userpass_changed'] = 'mot de passe chang&eacute;';
$langFile['log_adminSetup_saved'] = 'nouveaux pr&eacute;f&eacute;rences l&lsquo;administrateur sauvegard&eacute;';
$langFile['log_adminSetup_ckstyles'] = '"choix des syles" de l&lsquo;&eacute;diteur HTML sauvegard&eacute;';
$langFile['log_websiteSetup_saved'] = 'pr&eacute;f&eacute;rences site web sauvegard&eacute;';
$langFile['log_statisticSetup_saved'] = 'pr&eacute;f&eacute;rences statistiques sauvegard&eacute;';
$langFile['log_clearStatistic_websiteStatistic'] = 'pr&eacute;f&eacute;rences statistiques &eacute;ffac&eacute;';
$langFile['log_clearStatistic_pagesStatistics'] = 'pr&eacute;f&eacute;rences site web &eacute;ffac&eacute;s';
$langFile['log_clearStatistic_pagesStaylengthStatistics'] = 'statistiques sur le temps de visite &eacute;ffac&eacute;es';
$langFile['log_clearStatistic_refererLog'] = 'referrer-log &eacute;ffac&eacute;';
$langFile['log_clearStatistic_taskLog'] = 'log des derni&egrave;res activit&eacute;s &eacute;ffac&eacute;';
$langFile['log_pageSetup_saved'] = 'pr&eacute;f&eacute;rences site web sauvegard&eacute;';
$langFile['log_pageSetup_categories_saved'] = 'cat&eacute;gories sauvegard&eacute;s';
$langFile['log_pageSetup_saved'] = 'gestion des cat&eacute;gories sauvegard&eacute;e';
$langFile['log_pageSetup_new'] = 'nouvelle cat&eacute;gorie cr&eacute;e';
$langFile['log_pageSetup_delete'] = 'cat&eacute;gorie &eacute;ffac&eacute;e';
$langFile['log_pageSetup_move'] = 'cat&eacute;gorie d&eacute;plac&eacute;e';
$langFile['log_pluginSetup_saved'] = 'pr&eacute;f&eacute;rences plugins sauvegard&eacute;';
$langFile['log_file_saved'] = 'fichier sauvegard&eacute;';
$langFile['log_file_deleted'] = 'fichier sauvegard&eacute;';

// ----------- page/category public/nonpuplic
$langFile['status_page_public'] = 'site web public';
$langFile['status_page_nonpublic'] = 'site web cach&eacute;';
$langFile['status_category_public'] = 'cat&eacute;gorie est public';
$langFile['status_category_nonpublic'] = 'cat&eacute;gorie est cach&eacute;e';

// ----------- leftSidebar.loader.php
$langFile['user_nousers'] = 'il n&lsquo;y a pas d&lsquo;utilisateurs';
$langFile['user_currentuser'] = 'tu es connect&eacute; en tant qu&lsquo;utilisateurs';

/* ----------------------------------------------------------------------------------------------
* ---------- GENERAL TEXTs
*/

$langFile['txt_logo'] = 'version';
$langFile['txt_logo_gotowebsite'] = 'Cliquez ici pour acc&eacute;der &agrave; votre site Web.';
$langFile['txt_loading'] = 'site en connexion...';

/* ----------------------------------------------------------------------------------------------
* ---------- FRONTEND shared TEXTs
*/

$langFile['date_yesterday'] = 'hier';
$langFile['date_today'] = 'aujourd&lsquo;hui';
$langFile['date_tomorrow'] = 'demain';

/* ----------------------------------------------------------------------------------------------
* --------- BUTTON-TEXT (index.php)
*/

// --- mainMenu
$langFile['btn_home'] = 'vue globale';
$langFile['btn_pages'] = 'pages';
$langFile['btn_addons'] = 'addons';
$langFile['btn_settings'] = 'pr&eacute;f&eacute;rences site web';
$langFile['btn_search'] = 'fouiller tout le site web';

// --- adminMenu
$langFile['title_adminMenu'] = 'administration';
$langFile['btn_adminSetup'] = 'pr&eacute;f&eacute;rences administrateur';
$langFile['btn_pageSetup'] = 'pr&eacute;f&eacute;rences site web';
$langFile['btn_pluginSetup'] = 'pr&eacute;f&eacute;rences plugins';
$langFile['btn_statisticSetup'] = 'pr&eacute;f&eacute;rences statistiques';
$langFile['btn_userSetup'] = 'gestion de l&lsquo;utilisateur';

// --- subMenu/footer
$langFile['btn_fileManager'] = 'gestionnaire des fichiers';
$langFile['btn_fileManager_tip'] = 'ger&eacute;r des fichiers et des images';
$langFile['btn_createPage'] = 'nouvelle page';
$langFile['btn_createPage_tip'] = 'cr&eacute;er une nouvelle page';
$langFile['btn_deletePage'] = '&eacute;ffacer la page';
$langFile['btn_deletePage_tip'] = '&eacute;ffacer cette page';
$langFile['btn_pageThumbnailUpload'] = 't&eacute;l&eacute;charger thumbnail de la page';
$langFile['btn_pageThumbnailUpload_tip'] = 't&eacute;l&eacute;charger thumbnail pour cette page';
$langFile['btn_pageThumbnailDelete'] = '&eacute;ffacer thumbnail de la page';
$langFile['btn_pageThumbnailDelete_tip'] = '&eacute;ffacer thumbnail de cette page';
$langFile['btn_startPage_tip'] = 'd&eacute;finir cette page comme page d&lsquo;acceuil';
$langFile['btn_startPage_set'] = 'cette page est la page d&lsquo;acceuil';

// --- other
$langFile['btn_fastUp'] = 'vers le haut';
$langFile['date_int'] = 'AAAA-MM-JJ';
$langFile['date_eu'] = 'JJ.MM.AAAA';
$langFile['categories_noncategory_name'] = 'pages';
$langFile['categories_noncategory_tip'] = 'pages sans cat&eacute;gorie';
$langFile['text_example'] = 'example';

/* ----------------------------------------------------------------------------------------------
* ---------- ERROR TEXTs
*/

$langFile['error_save_settings'] = '<b>Les pr&eacute;f&eacute;rences ne peuvent pas &ecirc;tre sauvegard&eacute;s.</b>';
  $langFile['error_save_file'] = '<br /><br />Svp contr&ocirc;lez les droits d&lsquo;&eacute;criture du fichier:';
$langFile['error_read_folder_part1'] = '<br /><br />Svp contr&ocirc;lez les droits de lecture des "';
$langFile['error_save_folder_part1'] = '<br /><br />Svp contr&ocirc;lez les droits d&lsquo;&eacute;criture des "';
$langFile['error_folder_end'] = '" fichiers, du sous-fichier et des donn&eacute;es.';
$langFile['error_folderDatabase_end'] = '" fichiers, du sous-fichier et des donn&eacute;es.'; // (ou de la base de donn&eacute;es)

/* ----------------------------------------------------------------------------------------------
* ---------- WARNINGs
*/

$langFile['warning_startPageWarning_h1'] = 'La page d&lsquo;acceuil n&lsquo;est pas d&eacute;finie.';
$langFile['warning_startPageWarning'] = 'Svp d&eacute;finissez une page d&lsquo;acceuil.<br />Gehe zu <a href="?site=pages">'.$langFile['btn_pages'].'</a> und klicke bei der gew&uuml;nschten Seite auf das <span class="startPageIcon"></span> Symbol';
$langFile['warning_fmsConfWarning_h1'] = '<span class="logoname">fein<span>dura</span></span> n&lsquo;a pas encore &eacute;t&eacute; configur&eacute;!';
$langFile['warning_fmsConfWarning'] = 'La <i>trace de base</i>ne correspond pas avec les pr&eacute;f&eacute;rences l&lsquo;administrateur.<br />
Cliquez sur <a href="?site=adminSetup">pr&eacute;f&eacute;rences administrateur</a> et met en service ton <span class="logoname">fein<span>dura</span></span> CMS';
$langFile['warning_jsWarning_h1'] = 'Activer le javascript';
// no <p> tag on the start and the end, its already in the home.php
$langFile['warning_jsWarning'] = '<strong>Pour <span class="logoname">fein<span>dura</span></span> utiliser compl&egrave;tement le javasrcipt doit &ecirc;tre activ&eacute;!</strong></p>
<h2>dans le navigateur Firefox</h2>
<p>Cliquez dans le menu sur "ins&eacute;rer" > "param&egrave;tres". Sous contenu cliquez sur "activer JavaScript" et valider avec ok.</p>
<h2>dans le navigateur Internet Explorer</h2>
<p>Cliquez dans le menu sur "outils" > "options internet".<br />
Cliquez sur s&eacute;curit&eacute; ou sur "standard" ou bien "adapter standard" et puis activez le "activer Active Scripting" sous l&lsquo;onglet. Validez avec ok.</p>
<h2>dans le navigateur Safari</h2>
<p>Cliquez dans le menu sur le symbol tout droit, choississez "param&egrave;tres". Allez sur "s&eacute;curit&eacute;" pour activer "JavaScript aktivieren". Validez avec ok.</p>
<h2>dans le navigateur Mozilla</h2>
<p>Cliquez dans le menu sur "&eacute;diter" > "pr&eacute;f&eacute;rences". Allez sur "avanc&eacute;" > "scripts & plugins" et cochez la croix "navigateur" an. Validez avec ok.</p>
<h2>dans le navigateur Opera</h2>
<p>Cliquez dans le menu sur "extras" > "param&egrave;tres". Allez sur "avanc&eacute;" > "contenu" et cochez la croix "activer JavaScript". Validez avec ok.';

$langFile['warning_ieOld_h1'] = '<span class="logoname">fein<span>dura</span></span> ne fonctionne pas avec une ancienne version de l&lsquo;Internet Explorer.';
$langFile['warning_ieOld'] = 'Pour <span class="logoname">fein<span>dura</span></span> utiliser le CMS enti&egrave;rement, version 7 de l&lsquo;IE est n&eacute;cessaire.<br /><br />Svp installez une nouvelle version de l&lsquo;Internet Explorer,<br /> ou bien installez <a href="http://www.google.com/chromeframe" target="_blank">Google Chrome Frame Plugin</a> pour l&lsquo;IE,<br /> ou bien t&eacute;l&eacute;chargez <a href="http://www.mozilla.org/firefox/">Firefox Browser</a>.';

/* ----------------------------------------------------------------------------------------------
* leftSidebar.loader.php
*/

// ---------- QUICKMENU
$langFile['btn_quickmenu_categories'] = 'cat&eacute;gories';
$langFile['btn_quickmenu_pages'] = 'pages de';

/* ----------------------------------------------------------------------------------------------
* home.php
*/

// ---------- HOME
$langFile['home_userInfo_h1'] = 'informations utilisateur';
$langFile['home_welcome_h1'] = 'Bienvenue au content management system <span class="logoname">fein<span>dura</span></span><br /> de ton site web';
$langFile['home_welcome_text'] = '<span class="logoname">fein<span>dura</span></span> est un  Content Management System bas&eacute; sur <span class="toolTip" title="Flat-Files.::fichiers sur un server contenant le contenu du site web">Flat-Files</span>. <br />Ici tu peux g&eacute;rer le contenu de ton site web.';
$langFile['home_statistic_h1'] = 'statistiques du site web';
$langFile['home_user_h1'] = 'utilisateur';
$langFile['home_taskLog_h1'] = 'derni&egrave;res activit&eacute;s';
$langFile['home_taskLog_nolog'] = 'null';
$langFile['home_h1_article'] = 'les';
$langFile['home_mostVisitedPages_h1'] = 'pages les plus fr&eacute;quent&eacute;es';
$langFile['home_lastEditedPages_h1'] = 'derni&egrave;res pages r&eacute;dig&eacute;es';
$langFile['home_longestViewedPages_h1'] = 'pages les plus regard&eacute;s';
$langFile['home_refererLog_h1'] = 'sites web d&lsquo;o&ugrave; viennent les derniers visiteurs';
$langFile['home_refererLog_nolog'] = 'actuellement il n&lsquo;y pas eu de visiteurs d&lsquo;autres sites web.';
$langFile['home_novisitors'] = 'actuellement il n&lsquo;y a pas eu de visiteurs sur le site web.';

/* ----------------------------------------------------------------------------------------------
* listPages.php
*/

// ---------- PAGES SORTABLE LIST
$langFile['sortablePageList_h1'] = 'contenu de ton site web';
$langFile['sortablePageList_headText1'] = '';
$langFile['sortablePageList_headText2'] = 'derni&egrave;rement r&eacute;dig&eacute;';
$langFile['sortablePageList_headText3'] = 'visiteurs';
$langFile['sortablePageList_headText4'] = 'status';
$langFile['sortablePageList_headText5'] = 'fonctions';
$langFile['sortablePageList_pagedate'] = 'date sur le site web';
$langFile['sortablePageList_tags'] = 'tags';
$langFile['sortablePageList_sortOrder_manuell'] = 'manuellement tri&eacute;';
$langFile['sortablePageList_sortOrder_date'] = 'tri&eacute; par ordre chronologique';
$langFile['sortablePageList_functions_editPage'] = 'r&eacute;diger la page';
$langFile['sortablePageList_changeStatus_linkPage'] = 'Cliquer ici pour changer le status du site web.';
$langFile['sortablePageList_changeStatus_linkCategory'] = 'Cliquer ici pour changer le status de la cat&eacute;gorie.';
$langFile['file_error_read'] = '<b>lecture du site web impossible.</b>'.$langFile['error_read_folder_part1'].$adminConfig['savePath'].$langFile['error_folderDatabase_end'];
$langFile['sortablePageList_setStartPage_error_save'] = '<b>activation de la page d&lsquo;accueil impossible.</b>'.$langFile['error_save_file'].' "'.$adminConfig['basePath'].'config/website.config.php"';
$langFile['sortablePageList_changeStatusPage_error_save'] = '<b>le status du site web ne pouv&eacute; pas &ecirc;tre chang&eacute;.</b>'.$langFile['error_save_folder_part1'].$adminConfig['savePath'].$langFile['error_folderDatabase_end'];
$langFile['sortablePageList_changeStatusCategory_error_save'] = '<b>le status de la cat&eacute;gorie ne pouv&eacute; pas &ecirc;tre chang&eacute;.</b>'.$langFile['error_save_folder_part1'].$adminConfig['savePath'].$langFile['error_folderDatabase_end'];
$langFile['sortablePageList_info'] = 'L&lsquo;ordre du site web peut &ecirc;tre chang&eacute; <b>ordre site web</b> par <b>Drag and Drop</b> ainsi que les pages peuvent &ecirc;tre interchang&eacute;es entre les cat&eacute;gories diff&eacute;rentes.';
$langFile['sortablePageList_save'] = 'sauvegarder le nouvel ordre ...';
$langFile['sortablePageList_save_finished'] = 'nouvel ordre sauvegard&eacute;!';
$langFile['sortablePageList_error_save'] = '<b>les pages ne pouvaient pas &ecirc;tre sauvgard&eacute;es.</b>'.$langFile['error_save_folder_part1'].$adminConfig['savePath'].$langFile['error_folder_end'];
$langFile['sortablePageList_error_read'] = '<b>les pages ne pouvaient pas &ecirc;tre lus.</b>'.$langFile['error_read_folder_part1'].$adminConfig['savePath'].$langFile['error_folder_end'];
$langFile['sortablePageList_error_move'] = '<b>la page ne pouvait pas &ecirc;tre mise dans la nouvelle cat&eacute;gorie.</b>'.$langFile['error_save_folder_part1'].$adminConfig['savePath'].$langFile['error_folder_end'];
$langFile['sortablePageList_categoryEmpty'] = 'Keine Seiten vorhanden';

// ---------- FORMULAR
$langFile['form_submit'] = 'sauvegarder';
$langFile['form_cancel'] = 'r&eacute;initialiser les donn&eacute;es';

// ---------- ERRORWINDOW
$langFile['form_errorWindow_h1'] = 'une erreur s&lsquo;est produite!';

/* ----------------------------------------------------------------------------------------------
* adminSetup.php
*/

// ---------- ADMIN SETUP (on toolTips tooTips.js converts the "[" and "]" tags in the title attribute to "<" ">")
$langFile['adminSetup_version'] = '<span class="logoname">fein<span>dura</span></span> Version';
$langFile['adminSetup_phpVersion'] = 'PHP Version';
$langFile['adminSetup_warning_phpversion'] = 'pour la fonctionalit&eacute; tu as besoin d&lsquo;au moins'; // PHP 4.3.0
$langFile['adminSetup_srvRootPath'] = 'trace Server-Root';
$langFile['adminSetup_error_title'] = 'des erreurs se sont produites';
$langFile['adminSetup_error_writeAccess_tip'] = 'pour les fichiers et les donn&eacute;es les droits de lecture doivent &ecirc;tre mis sur 777.';
$langFile['adminSetup_error_writeAccess'] = 'n&lsquo;est pas descriptible';
$langFile['adminSetup_error_isFolder'] = 'n&lsquo;est pas un dossier';

// ---------- FMS Settings
$langFile['adminSetup_fmsSettings_error_save'] = $langFile['error_save_settings'].$langFile['error_save_file'].$adminConfig['basePath'].'config/admin.config.php';
$langFile['adminSetup_fmsSettings_h1'] = 'configuration de base';
$langFile['adminSetup_fmsSettings_savePathShouldBeOutside'] = '[span class=hint]la trace doit &ecirc;tre en dehors du dossier CMS, si le dossier CMS n&eacute;cessite un mot de passe.[/span]';
$langFile['adminSetup_fmsSettings_field1'] = 'URL site web';
$langFile['adminSetup_fmsSettings_field1_tip'] = 'l&lsquo;URL de votre site web sera mise automatiquement.';
$langFile['adminSetup_fmsSettings_field1_inputTip'] = 'l&lsquo;URL sera mise automatiquement';
$langFile['adminSetup_fmsSettings_field1_inputWarningText'] = 'Svp sauvegardez la configuration!';
$langFile['adminSetup_fmsSettings_field2'] = 'trace principale';
$langFile['adminSetup_fmsSettings_field2_tip'] = 'la trace principale sera estim&eacute; automatiquement et sauvegard&eacute; avec la configuration.';
$langFile['adminSetup_fmsSettings_field2_inputTip'] = 'la trace principale sera mise automatiquement';
$langFile['adminSetup_fmsSettings_field2_inputWarningText'] = 'Svp sauvegardez la configuration!';
$langFile['adminSetup_fmsSettings_field3'] = 'r&eacute;pertoire du dossier';
$langFile['adminSetup_fmsSettings_field3_tip'] = 'lz [b]trace absolue[/b], contenant les Flat-Files du  contenu du site web.[br /][br /]'.$langFile['adminSetup_fmsSettings_savePathShouldBeOutside'];
$langFile['adminSetup_fmsSettings_field4'] = 'trace upload';
$langFile['adminSetup_fmsSettings_field4_tip'] = 'Ici des fichiers comme des images, animations flashs ou documents vont &ecirc;tre t&eacute;l&eacute;charg&eacute;s.[br /][br /][span class=hint]pour ins&eacute;rer des fichiers, cliquez dans le HTML-Editor ins&eacute;rer lien > upload t&eacute;l&eacute;charg&eacute;.[/span][br /][br /]'.$langFile['adminSetup_fmsSettings_savePathShouldBeOutside'];
$langFile['adminSetup_fmsSettings_editfiles_additonal'] = '[br /][br /]ces fichiers peuvent &ecirc;tre r&eacute;dig&eacute;s plus bas ou dans le param&egrave;trages du site web (si cette option est activ&eacute; pour le site web).[br /][br /]';
$langFile['adminSetup_fmsSettings_field5'] = 'trace du dossier du site web';
$langFile['adminSetup_fmsSettings_field5_tip'] = 'un dossier contenant des fichiers. ces fichiers peuvent par ex. &ecirc;tre utilis&eacute;s pour avoir une version multilinguale du site web.'.$langFile['adminSetup_fmsSettings_editfiles_additonal'].$langFile['adminSetup_fmsSettings_savePathShouldBeOutside'];
$langFile['adminSetup_fmsSettings_field6'] = 'trace des feuilles de style';
$langFile['adminSetup_fmsSettings_field6_tip'] = 'une trace absolue [b]trace absolue[/b] contenat les feuilles de style qui peuvent &ecirc;tre r&eacute;dig&eacute;s par ex. par les utilisateurs.'.$langFile['adminSetup_fmsSettings_editfiles_additonal'];
$langFile['adminSetup_fmsSettings_varName_ifempty'] = 'si le panneua est vide, le nom standard des variables GET sera utilis&eacute;: ';
$langFile['adminSetup_fmsSettings_varName1'] = 'page nom des variables';
$langFile['adminSetup_fmsSettings_varName1_inputTip'] = $langFile['adminSetup_fmsSettings_varName_ifempty'].'"[b]page[/b]"';
$langFile['adminSetup_fmsSettings_varName2'] = 'cat&eacute;gories nom des variables';
$langFile['adminSetup_fmsSettings_varName2_inputTip'] = $langFile['adminSetup_fmsSettings_varName_ifempty'].'"[b]category[/b]"';
$langFile['adminSetup_fmsSettings_varName3'] = 'module nom des variables';
$langFile['adminSetup_fmsSettings_varName3_inputTip'] = $langFile['adminSetup_fmsSettings_varName_ifempty'].'"[b]modul[/b]"';
$langFile['adminSetup_fmsSettings_varName_tip'] = 'le nom des variables [b]$_GET Variable[/b] utilis&eacute; pour le r&eacute;f&eacute;rencement du site web.';
$langFile['adminSetup_fmsSettings_field7'] = 'format de date';
$langFile['adminSetup_fmsSettings_field7_tip'] = 'Sera [span class=logoname]fein[span]dura[/span][/span] et le site web.[br /]mettre:[br /]DIN 5008 ('.$langFile['date_eu'].') ou[br /]ISO 8601 ('.$langFile['date_int'].')';
$langFile['adminSetup_fmsSettings_speakingUrl'] = 'format URL';
$langFile['adminSetup_fmsSettings_speakingUrl_true'] = 'speaking URLs';
$langFile['adminSetup_fmsSettings_speakingUrl_true_example'] = '/category/beispiel_category/beispiel.html';
$langFile['adminSetup_fmsSettings_speakingUrl_false'] = 'variables avec des URL';
$langFile['adminSetup_fmsSettings_speakingUrl_false_example'] = 'index.php?'.$adminConfig['varName']['category'].'=1&'.$adminConfig['varName']['page'].'=1';
$langFile['adminSetup_fmsSettings_speakingUrl_tip'] = 'le format de d&lsquo;URL pour le r&eacute;f&eacute;rencement du site web.[br /][br /]Speaking URLs fonctionnent seulement si [b]Apache[/b] le [b]mod_rewrite[/b] module est disponible.';
$langFile['adminSetup_fmsSettings_speakingUrl_warning'] = 'Attention!::[span class=red]Si des erreurs se produisent pendant l&lsquo;utilisation des speaking URLs auftreten, le fichier [b].htaccess Datei[/b] dans la trace documentaire root du serveur doit &ecirc;tre &eacute;ffac&eacute;.[/span][br /][br /](dans certains logiciels FTP les fichiers cach&eacute;s doivent &ecirc;tre indiqu&eacute;s pour montrer le fichier .htaccess)';

// ---------- speaking url ERRORs
$langFile['adminSetup_fmsSettings_speakingUrl_error_save'] = '<b>Speaking URLs</b> ne pouvaient pas &ecirc;tre activ&eacute;s'.$langFile['error_save_file'].'/.htaccess';
$langFile['adminSetup_fmsSettings_speakingUrl_error_modul'] = '<b>Speaking URLs</b> ne pouvait pas &ecirc;tre activ&eacute; &agrave; cause du module Apache: MOD_REWRITE peut pas &ecirc;tre trouv&eacute;';

// ---------- user Settings
$langFile['adminSetup_userSettings_h1'] = 'pr&eacute;f&eacute;rences utilisateur';
$langFile['adminSetup_userSettings_check1'] = 'traiter les donn&eacute;es du site web au sein du param&eacute;trage du site web';
$langFile['adminSetup_userSettings_check2'] = 'traiter les feuilles de style au sein du param&eacute;trage du site web';
$langFile['adminSetup_userSettings_check3'] = 'activer gestion des donn&eacute;es';
$langFile['adminSetup_userSettings_textarea1'] = '<strong>informations utilisateur</strong> in der <a href="?site=home">'.$langFile['btn_home'].'</a>';
$langFile['adminSetup_userSettings_textarea1_tip'] = 'information utilisateur::Ce texte va &ecirc;tre publi&eacute; sur [span class=logoname]fein[span]dura[/span][/span] '.$langFile['btn_home'].'.';
$langFile['adminSetup_userSettings_textarea1_inputTip'] = 'N&lsquo;ecrivez rien dans la case, si vous ne voulez pas montrer des informations sur l&lsquo;utilisateur';

// ---------- editor Settings
$langFile['adminSetup_editorSettings_h1'] = 'param&egrave;tres de l&lsquo;&eacute;diteur HTML';
$langFile['adminSetup_editorSettings_field1'] = 'modus touche-entr&eacute;e';
$langFile['adminSetup_editorSettings_field1_hint'] = 'shift + entr&eacute;e va cr&eacute;er un "<br />"';
$langFile['adminSetup_editorSettings_field1_tip'] = 'Va d&eacute;finir le HTML-tag en touchant la touche entr&eacute;e[br]wird.[br /][br /][span class=hint]'.$langFile['adminSetup_editorSettings_field1_hint'].'.[/span]';
$langFile['adminSetup_editorSettings_field3_inputTip'] = 'Si la case reste vide, aucune Id sera utilis&eacute;.';
$langFile['adminSetup_editorSettings_field4_inputTip'] = 'Si la case reste vide, aucune classe sera utilis&eacute;.';

// ---------- thumbnail Settings
$langFile['adminSetup_thumbnailSettings_h1'] = 'param&egrave;tres thumbnail du site';
$langFile['adminSetup_thumbnailSettings_field3'] = 'trace de sauvegarde'; // trace de sauvegarde thumbnail
$langFile['adminSetup_thumbnailSettings_field3_tip'] = 'trace au sein de la trace upload des donn&eacute;es ou les thumbnails seront sauvegard&eacute;s.';
$langFile['adminSetup_thumbnailSettings_field3_inputTip1'] = 'trace upload des donn&eacute;es';
$langFile['adminSetup_thumbnailSettings_field3_inputTip2'] = 'trace relative::d&eacute;p&eacute;ndant de la "[b]'.$adminConfig['uploadPath'].'[/b]" trace.[br /][br /]Commence sans "/"';
$langFile['adminSetup_thumbnailSettings_field3_inputTip3'] = '<b>'.$langFile['text_example'].'</b> "thumbnails/" ';

// ---------- styleFile Settings
$langFile['adminSetup_styleFileSettings_h1'] = 'adapter le "choix du style" dans l&lsquo;&eacute;diteur HTML';
$langFile['adminSetup_styleFileSettings_error_save'] = '<b>le fichier "htmlEditorStyles.xml" ne pouvait pas &ecirc;tre sauvegard&eacute;.</b>'.$langFile['error_save_file'];

// ---------- editFiles Settings
$langFile['editFilesSettings_error_save'] = '<b>le fichier ne pouvait pas &ecirc;tre sauvegard&eacute;.</b>'.$langFile['error_save_file'];
$langFile['editFilesSettings_h1_style'] = 'traiter les feuilles de style';
$langFile['editFilesSettings_h1_websitefiles'] = 'traiter les donn&eacute;es du site web';
$langFile['editFilesSettings_noDir'] = 'pas de dossier valable!';
$langFile['editFilesSettings_chooseFile'] = 'choisir fichier';
$langFile['editFilesSettings_createFile'] = 'cr&eacute;er nouveau fichier';
$langFile['editFilesSettings_createFile_inputTip'] = 'Si vous mettez le nom d&lsquo;un fichier ici, un nouveau fichier sera cr&eacute;e,[br /]et [b]le donn&eacute;e choisi actuellement ne sera pas sauvegard&eacute;![/b]';
$langFile['editFilesSettings_noFile'] = 'Actuellement pas de donn&eacute;es';
$langFile['editFilesSettings_deleteFile'] = '&eacute;ffacer fichier';
$langFile['editFilesSettings_deleteFile_question_part1'] = 'fichier'; // &eacute;ffacer la cat&eacute;gorie "test"?
$langFile['editFilesSettings_deleteFile_question_part2'] = 'voulez-vous vraiment &eacute;ffacer ces donn&eacute;es?';
$langFile['editFilesSettings_deleteFile_error_delete'] = '<b>le fichier ne pouvait pas &ecirc;tre &eacute;ffac&eacute;.</b>'.$langFile['error_save_file'];

/* ----------------------------------------------------------------------------------------------
* pageSetup.php
*/

// ---------- CATEGORY SETUP (on toolTips tooTips.js converts the "[" and "]" tags in the title attribute to "<" ">")
$langFile['pageSetup_general_tag_tip'] = 'les tags peuvent &ecirc;tre utilis&eacute;s pour mettre en relation les pages entre eux (d&eacute;pendant de le programmation du site web)';

// ---------- page settings
$langFile['pageSetup_pageConfig_h1'] = 'param&egrave;tres du site web';
$langFile['pageSetup_pageConfig_check1'] = 'la page d&lsquo;acceuil peut &ecirc;tre d&eacute;finie';
$langFile['pageSetup_pageConfig_check1_tip'] = 'la page d&lsquo;acceuil peut &ecirc;tre d&eacute;finie par l&lsquo;utilisateur.[br /][br /]La page d&lsquo;acceuil d&eacute;finie sera publi&eacute;, si aucune variable du site web sera transmise ou bien la page ne sera pas &eacute;xecut&eacute;e.';
$langFile['pageSetup_pageConfig_noncategorypages_h1'] = 'pages sans cat&eacute;gories';
$langFile['pageSetup_pageConfig_check2'] = 'cr&eacute;er/&eacute;ffacer des pages';
$langFile['pageSetup_pageConfig_check2_tip'] = 'D&eacute;finit si l&lsquo;utilisateur peut cr&eacute;er/&eacute;ffacer une page sans cat&eacute;gorie.';
$langFile['pageSetup_pageConfig_check3'] = 't&eacute;l&eacute;charger thumbnails';
$langFile['pageSetup_pageConfig_check3_tip'] = 'D&eacute;finit si l&lsquo;utilisateur peut t&eacute;l&eacute;charger des thumbnails au sein des pages sans cat&eacute;gories.';
$langFile['pageSetup_pageConfig_check4'] = 'traiter tags';
$langFile['pageSetup_pageConfig_check4_tip'] = 'D&eacute;finit si l&lsquo;utilisateur peut traiter des tags au sein des pages sans cat&eacute;gories.[br /]'.$langFile['pageSetup_general_tag_tip'];
$langFile['pageSetup_pageConfig_check5'] = 'activer plugins';
$langFile['pageSetup_pageConfig_check5_tip'] = 'D&eacute;finit si l&lsquo;utilisateur peut utiliser des plugins au sein des pages.';

// ---------- category settings
$langFile['pageSetup_h1'] = 'gestion des cat&eacute;gories';
$langFile['pageSetup_field1'] = 'nom';
$langFile['pageSetup_createCategory'] = 'cr&eacute;er nouvelle cat&eacute;gorie';
$langFile['pageSetup_createCategory_created'] = 'nouvelle cat&eacute;gorie cr&eacute;e';
$langFile['pageSetup_createCategory_unnamed'] = 'cat&eacute;gorie n&lsquo;est pas nomm&eacute;';
$langFile['pageSetup_deleteCategory'] = '&eacute;ffacer la cat&eacute;gorie';
$langFile['pageSetup_deleteCategory_warning'] = 'ATTENTION: Toutes les pages au sein de cette cat&eacute;gorie seront &eacute;ffac&eacute;es!';
$langFile['pageSetup_deleteCategory_deleted'] = 'cat&eacute;gorie &eacute;ffac&eacute;e';
$langFile['pageSetup_moveCategory_moved'] = 'cat&eacute;gorie d&eacute;plac&eacute;e';
$langFile['pageSetup_moveCategory_up_tip'] = 'd&eacute;placer la cat&eacute;gorie vers le haut';
$langFile['pageSetup_moveCategory_down_tip'] = 'd&eacute;placer la cat&eacute;gorie vers le bas';
$langFile['pageSetup_error_create'] = '<b>Une nouvelle cat&eacute;gorie ne pouvait pas &ecirc;tre cr&eacute;e.</b>'.$langFile['error_save_folder_part1'].$adminConfig['basePath'].'config/'.$langFile['error_folderDatabase_end'];
$langFile['pageSetup_error_createDir'] = '<b>Un r&eacute;pertoire de cat&eacute;gorie ne pouvait pas &ecirc;tre cr&eacute;e.</b>'.$langFile['error_save_folder_part1'].$adminConfig['savePath'].'" Ordners.';
$langFile['pageSetup_error_delete'] = '<b>La cat&eacute;gorie ne pouvait pas &ecirc;tre &eacute;ffac&eacute;e.</b>'.$langFile['error_save_file'].$adminConfig['basePath'].'config/category.config.php';
$langFile['pageSetup_error_deleteDir'] = '<b>Le r&eacute;pertoire de cat&eacute;gorie ne pouvait pas &ecirc;tre &eacute;ffac&eacute;.</b>'.$langFile['error_save_folder_part1'].$adminConfig['savePath'].$langFile['error_folder_end'];
$langFile['pageSetup_error_save'] = $langFile['error_save_settings'].$langFile['error_save_file'].$adminConfig['basePath'].'config/category.config.php';
$langFile['pageSetup_advancedSettings'] = 'param&egrave;tres avanc&eacute;s';
$langFile['pageSetup_advancedSettings_hint'] = 'Si vous avez mis toutes les param&egrave;tres, les param&egrave;tres des thumbnails seront automatiquement &eacute;cras&eacute; les Wenn diese Einstellungen ausgef&uuml;llt sind &uuml;berschreiben sie die Seiten-Thumbnail-Einstellungen weiter oben und die '.$langFile['adminSetup_editorSettings_h1'].' in den <a href="?site=adminSetup">Administrator-Einstellungen</a>.';
$langFile['pageSetup_stylesheet_ifempty'] = 'Si toutes les cases restent vides, les param&egrave;tres des stylesheet seront automatiquement'.$langFile['adminSetup_editorSettings_h1'].' ex&eacute;cut&eacute;s.';
$langFile['pageSetup_check1'] = 'status de la cat&eacute;gorie';
$langFile['pageSetup_check1_tip'] = 'd&eacute;finit si une cat&eacute;gorie sera publi&eacute;e sur le site web.';
$langFile['pageSetup_check2'] = 'cr&eacute;er/&eacute;ffacer page';
$langFile['pageSetup_check2_tip'] = 'd&eacute;finit si un utilisateur peut cr&eacute;er/&eacute;ffacer des pages dans cette cat&eacute;gorie.';
$langFile['pageSetup_check3'] = 't&eacute;l&eacute;charger thumbnails';
$langFile['pageSetup_check3_tip'] = 'd&eacute;finit si un utilisateur peut t&eacute;l&eacute;charger des thumbnails dans chaque page de cette cat&eacute;gorie.';
$langFile['pageSetup_check4'] = 'traiter tags';
$langFile['pageSetup_check4_tip'] = 'tags peuvent &ecirc;tre d&eacute;finis pour la cat&eacute;gorie de cette page.[br /]'.$langFile['pageSetup_general_tag_tip'];
$langFile['pageSetup_check8'] = 'activer plugins';
$langFile['pageSetup_check8_tip'] = 'activer plugins pour les pages de cette cat&eacute;gorie';
$langFile['pageSetup_check5'] = 'traiter la date du site web';
$langFile['pageSetup_check5_tip'] = 'la date du site web peu &ecirc;tre utilis&eacute; pour trier des pages par ordre chronologique.';
$langFile['pageSetup_check6'] = 'trier par ordre chronologique';
$langFile['pageSetup_check6_tip'] = 'les pages seront tri&eacute; par ordre chronologique.[br /][br /][span class=hint]Manuellement trier n&lsquo;est plus possible.[/span]';
$langFile['pageSetup_check7'] = 'page actuelle se trouve en bas';
$langFile['pageSetup_check7_tip'] = 'Trie les pages [b]par ordre croissant[/b].[br /][br /][span class=hint]Manuellement trier &eacute;crase les param&egrave;tres de la page concern&eacute;e.[/span]';

// ---------- deleting category
$langFile['pageSetup_deletCategory_question_part1'] = 'cat&eacute;gorie'; // &eacute;ffacer cat&eacute;gorie "test"?
$langFile['pageSetup_deletCategory_question_part2'] = '&eacute;ffacer?';

/* ----------------------------------------------------------------------------------------------
* websiteSetup.php
*/

// ---------- WEBSITE SETUP (on toolTips tooTips.js converts the "[" and "]" tags in the tittle attribute to "<" ">")
$langFile['websiteSetup_websiteConfig_error_save'] = $langFile['error_save_settings'].$langFile['error_save_file'].$adminConfig['basePath'].'config/website.config.php';
$langFile['websiteSetup_websiteConfig_h1'] = 'param&egrave;tres du site web';
$langFile['websiteSetup_websiteConfig_field1'] = 'titre du site web';
$langFile['websiteSetup_websiteConfig_field1_tip'] = 'le titre du site web sera indiqu&eacute; dans le navigateur.';
$langFile['websiteSetup_websiteConfig_field2'] = 'publisher';
$langFile['websiteSetup_websiteConfig_field2_tip'] = 'le nom de l&lsquo;organisation/entreprise/personne publiant ce site.';
$langFile['websiteSetup_websiteConfig_field3'] = 'copyright';
$langFile['websiteSetup_websiteConfig_field3_tip'] = 'le propri&eacute;taire du copyright du site web.';
$langFile['websiteSetup_websiteConfig_field4'] = 'mots cl&eacute;s des moteurs de recherche';
$langFile['websiteSetup_websiteConfig_field4_tip'] = 'La plupart des moteurs de recherche fouillent le contenu des pages selon des mots cl&eacute;s. Mettez des mots cl&eacute;s qui seront utilisez dans <meta> les tags du site web.';
$langFile['websiteSetup_websiteConfig_field4_inputTip'] = 'les mots cl&eacute;s doivent &ecirc;tre s&eacute;par&eacute;es en "," ::'.$langFile['text_example'].':[br /]mot-cl&eacute;1,mot-cl&eacute;2,etc';
$langFile['websiteSetup_websiteConfig_field5'] = 'description du site web';
$langFile['websiteSetup_websiteConfig_field5_tip'] = 'Une courte description de votre site web utilis&eacute; par les moteurs de recherche. Les mots-cl&eacute; se trouveront dans l&lsquo;URL du site web mais dans le contenu.';
$langFile['websiteSetup_websiteConfig_field5_inputTip'] = 'Un texte court en 3 lignes.';

/* ----------------------------------------------------------------------------------------------
* statisticSetup.php
*/

// ---------- STATISITC SETUP (on toolTips tooTips.js converts the "[" and "]" tags in the tittle attribute to "<" ">")
$langFile['statisticSetup_statisticConfig_error_save'] = $langFile['error_save_settings'].$langFile['error_save_file'].$adminConfig['basePath'].'config/statistic.config.php';
$langFile['statisticSetup_statisticConfig_h1'] = 'param&egrave;tres des statistiques';
$langFile['statisticSetup_statisticConfig_field1'] = 'Nombre de pages publi&eacute;es le <b>plus visit&eacute;es</b>';
$langFile['statisticSetup_statisticConfig_field1_tip'] = 'Indique le nombre de pages les plus visit&eacute;es que seront list&eacute;es sur la page-aper&ccedil;u g&eacute;n&eacute;rale.';
$langFile['statisticSetup_statisticConfig_field2'] = 'Nombre de pages publi&eacute;es <b>les plus visit&eacute;es</b>';
$langFile['statisticSetup_statisticConfig_field2_tip'] = 'Indique le nombre de pages les plus regard&eacute;es sur la page -aper&ccedil;u g&eacute;n&eacute;rale.';
$langFile['statisticSetup_statisticConfig_field3'] = 'nombre de pages publi&eacute;es <b>derni&egrave;rement trait&eacute;es</b>';
$langFile['statisticSetup_statisticConfig_field3_tip'] = 'Indique les pages derni&egrave;rement trait&eacute;es sur la page-aper&ccedil;u-g&eacute;n&eacute;rale.';
$langFile['statisticSetup_statisticConfig_field4'] = 'nombre maximal des <b>Referrer-URLs</b>';
$langFile['statisticSetup_statisticConfig_field4_tip'] = 'Indique le nombre maximal des Referrer-URLs ([i]URL qui ont m&egrave;n&eacute;s sur ce site web[/i]).';
$langFile['statisticSetup_statisticConfig_field5'] = 'nombre maximal des <b>logs-activit&eacute;s</b>';
$langFile['statisticSetup_statisticConfig_field5_tip'] = 'Indique le nombre des logs-activit&eacute;s seront sauvegard&eacute;s au maximum.';
$langFile['statisticSetup_clearStatistic_h1'] = '&eacute;ffacer statistiques';
$langFile['statisticSetup_clearStatistics_websiteStatistic'] = 'statistiques du site web';
$langFile['statisticSetup_clearStatistics_websiteStatistic_tip'] = '[b]Contient[/b][ul][li]tout le nombre des visiteurs[/li][li]nombre des robots d&lsquo;indexation[/li][li]date de la premi&egrave;re visite[/li][li]date de la derni&egrave;re visite[/li][li]spectre des navigateurs utilis&eacute;s[/li][/ul]';
$langFile['statisticSetup_clearStatistics_pagesStatistic'] = 'statistiques des pages';
$langFile['statisticSetup_clearStatistics_pagesStatistic_tip'] = '[b]contient[/b][ul][li]nombre de visiteurs[/li][li]date de la premi&egrave;re visite[/li][li]date de la derni&egrave;re visite[/li][li]temps de visite le plus court[/li][li]temps de visite le plus long[/li][li]mots-cl&eacute; des moteurs de recherche qui ont m&egrave;n&eacute;s sur le site web[/li][/ul]';
$langFile['statisticSetup_clearStatistics_pagesStaylengthStatistics'] = 'seulement les statistiques temps-de-visite';
$langFile['statisticSetup_clearStatistics_pagesStaylengthStatistics_tip'] = '';
$langFile['statisticSetup_clearStatistics_refererLog'] = 'Referrer-URLs Log'; // engl.: referer
$langFile['statisticSetup_clearStatistics_refererLog_tip'] = 'Une liste avec tous les URLs qui ont m&egrave;n&eacute; sur le site web.';
$langFile['statisticSetup_clearStatistics_taskLog'] = 'Logs des derni&egrave;rses activit&eacute;s';
$langFile['statisticSetup_clearStatistics_taskLog_tip'] = 'Contient une liste des derni&egrave;res activit&eacute;s.';
$langFile['statisticSetup_clearStatistics_question_h1'] = 'Voulez vous vraiment &eacute;ffacer ces statistiques?';
$langFile['statisticSetup_clearStatistic_pagesStatistics_error_read'] = 'une erreur s&lsquo;est produite pendant l&lsquo;&eacute;ffacement des statistiques du site web.'.$langFile['error_save_folder_part1'].$adminConfig['savePath'].$langFile['error_folderDatabase_end'];

/* ----------------------------------------------------------------------------------------------
* pluginSetup.php
*/

// ---------- PLUGIN SETUP (on toolTips tooTips.js converts the "[" and "]" tags in the tittle attribute to "<" ">")
$langFile['pluginSetup_editFiles_h1'] = 'traiter les fichiers';
$langFile['pluginSetup_pluginconfig_active'] = 'Plugin activ&eacute;';
$langFile['pluginSetup_pluginconfig_error_save'] = $langFile['error_save_settings'].$langFile['error_save_file'].$adminConfig['basePath'];

/* ----------------------------------------------------------------------------------------------
* editor.php
*/

// ---------- page info
$langFile['editor_h1_createpage'] = 'cr&eacute;er nouvelle page';
$langFile['editor_pageinfo_lastsavedate'] = 'derni&egrave;rement trait&eacute;';
$langFile['editor_pageinfo_lastsaveauthor'] = 'de';
$langFile['editor_pageinfo_linktothispage'] = 'lien m&egrave;nant sur le site web';
$langFile['editor_pageinfo_id'] = 'ID de la page';
$langFile['editor_pageinfo_id_tip'] = 'le site web sera sauvegard&eacute; sur le serveur sous cette ID.';
$langFile['editor_pageinfo_category'] = 'cat&eacute;gorie';
$langFile['editor_pageinfo_category_noCategory'] = 'aucune cat&eacute;gorie (ID 0)';

$langFile['editor_block_edited'] = 'ont &eacute;t&eacute; &eacute;dit&eacute;';

// ---------- page settings
$langFile['editor_pageSettings_h1'] = 'param&egrave;tres';
$langFile['editor_pagestatistics_h1'] = 'statistiques';
$langFile['editor_pageSettings_title'] = 'titre';
$langFile['editor_pageSettings_title_tip'] = 'titre de la page';
$langFile['editor_pageSettings_field1'] = 'description courte';
$langFile['editor_pageSettings_field1_inputTip'] = 'Si la case reste vide la description du site web au sein des param&egrave;tres du site web sera utilis&eacute;.';
$langFile['editor_pageSettings_field1_tip'] = 'Une description courte du site web. Ceci va &ecirc;tre mise dans les tags-META du site web.[br /][br /][span class=hint]'.$langFile['editor_pageSettings_field1_inputTip'].'[/span]';
$langFile['editor_pageSettings_field2'] = 'tags';
$langFile['editor_pageSettings_field2_tip'] = 'tags sont des mots-cl&eacute; de ce site web.';
$langFile['editor_pageSettings_field2_tip_inputTip'] = 'les tags doivent &ecirc;tre s&eacute;par&eacute;s par la [b]barre d&lsquo;espacement[/b].';
$langFile['editor_pageSettings_field3'] = 'date du site web';
$langFile['editor_pageSettings_field3_tip'] = 'La date peut &ecirc;tre utilis&eacute;e pour trier les pages dans l&lsquo;ordre chronologique. (par ex. des &eacute;venements)';
$langFile['editor_pageSettings_pagedate_before_inputTip'] = 'texte avant la date::par ex. &quot;du 31. juin&quot;.';
$langFile['editor_pageSettings_pagedate_after_inputTip'] = 'texte apr&egrave;s la date::';
$langFile['editor_pageSettings_pagedate_day_inputTip'] = 'jour::';
$langFile['editor_pageSettings_pagedate_month_inputTip'] = 'mois::';
$langFile['editor_pageSettings_pagedate_year_inputTip'] = 'an::[b]format[/b] aaaa';
$langFile['editor_pageSettings_field4'] = 'status de la page';
$langFile['editor_pageSettings_field4_tip'] = '[b]Une page sera visible sur le site web seulement quand elle est publi&eacute;e![/b]';
$langFile['editor_pageSettings_pagedate_error'] = 'format de date incorrect';
$langFile['editor_pageSettings_pagedate_error_tip'] = 'Ce mois n&lsquo;a peut &ecirc;tre pas 31 jours.[br /]La date devrait avoir le format suivant:';

// ---------- page advanced settings
$langFile['editor_advancedpageSettings_h1'] = 'param&egrave;tres avanc&eacute;s';
$langFile['editor_advancedpageSettings_field1'] = 'page fichier feuille de style';
$langFile['editor_advancedpageSettings_stylesheet_ifempty'] = 'Quand toutes les cases sont vides, les param&egrave;tres des feuilles de style de la cat&eacute;gorie seront utilis&eacute;s. Si ceux-ci sont vides aussi, les param&egrave;tres de l&lsquo;&eacute;diteur HTML seront utlis&eacute;s.';
$langFile['editor_htmleditor_hotkeys_h1'] = 'touches-cl&eacute;s';
$langFile['editor_htmleditor_hotkeys_field1'] = 'tout s&eacute;lectionner';
$langFile['editor_htmleditor_hotkeys_field2'] = 'copier';
$langFile['editor_htmleditor_hotkeys_field3'] = 'coller';
$langFile['editor_htmleditor_hotkeys_field4'] = 'couper';
$langFile['editor_htmleditor_hotkeys_field5'] = 'en arri&egrave;re';
$langFile['editor_htmleditor_hotkeys_field6'] = 'r&eacute;constituer';
$langFile['editor_htmleditor_hotkeys_field7'] = 'cr&eacute;er un lien';
$langFile['editor_htmleditor_hotkeys_field8'] = 'gras';
$langFile['editor_htmleditor_hotkeys_field9'] = 'italique';
$langFile['editor_htmleditor_hotkeys_field10'] = 'soulign&eacute;';
$langFile['editor_htmleditor_hotkeys_or'] = 'ou';

$langFile['editor_savepage_error_save'] = '<b>Cette page ne pouvait pas &ecirc;tre sauvegard&eacute;e.</b>'.$langFile['error_save_folder_part1'].$adminConfig['savePath'].$langFile['error_folderDatabase_end'];

// ---------- plugin settings
$langFile['editor_pluginSettings_h1'] = 'pr&eacute;f&eacute;rence plugin';

/* ----------------------------------------------------------------------------------------------
* deletePage.php
*/

// ---------- DELETE PAGE
$langFile['deletePage_question_part1'] = 'Vous &ecirc;tes sur de vraiment';
$langFile['deletePage_question_part2'] = 'vouloir &eacute;ffacer le site?';
$langFile['deletePage_finishnotexisting_part1'] = 'le site web';
$langFile['deletePage_finish_part2'] = 'a &eacute;t&eacute; &eacute;ffac&eacute;';
$langFile['deletePage_notexisting_part2'] = 'n&lsquo;existe pas';
$langFile['deletePage_finish_error'] = 'ERREUR: La page ne pouvait pas &ecirc;tre &eacute;ffac&eacute;e!';

/* ----------------------------------------------------------------------------------------------
* pageThumbnailDelete.php
*/

// ---------- PAGE THUMBNAIL DELETE
$langFile['pageThumbnailDelete_question_part1'] = 'Vous &ecirc;tes sur de vraiment';
$langFile['pageThumbnailDelete_question_part2'] = '&eacute;ffacer le thumbnail de cette page?';
$langFile['pageThumbnailDelete_name'] = 'le thumbnail';
$langFile['pageThumbnailDelete_finish_part2'] = 'a &eacute;t&eacute; &eacute;ffac&eacute;!';
$langFile['pageThumbnailDelete_notexisting_part2'] = 'n&lsquo;existe pas';
$langFile['pageThumbnailDelete_finish_error'] = 'ERREUR: Le thumbnail ne pouvait pas &ecirc;tre &eacute;ffac&eacute;e!';

/* ----------------------------------------------------------------------------------------------
* pageThumbnailUpload.php
*/

// ---------- PAGE THUMBNAIL UPLOAD
$langFile['pagethumbnail_h1_part1'] = 'thumbnail de page pour';
$langFile['pagethumbnail_h1_part2'] = 't&eacute;l&eacute;charger';
$langFile['pagethumbnail_field1'] = 'choisir image';
$langFile['pagethumbnail_thumbinfo_formats'] = 'Seulement les formats suiovant seront accept&eacute;s'; //<br /><b>JPG</b>, <b>JPEG</b>, <b>GIF</b>, <b>PNG</b>
$langFile['pagethumbnail_thumbinfo_filesize'] = 'taille maximale';
$langFile['pagethumbnail_thumbinfo_standardthumbsize'] = 'taille standard';
$langFile['pagethumbnail_thumbsize_h1'] = 'd&eacute;finir la taille de l&lsquo;image';
$langFile['pagethumbnail_thumbsize_width'] = 'largeur de l&lsquo;image';
$langFile['pagethumbnail_thumbsize_height'] = 'hauteur de l&lsquo;image';
$langFile['pagethumbnail_submit_tip'] = 't&eacute;l&eacute;charger l&lsquo;image';
$langFile['pagethumbnail_upload_error_nofile'] = 'Vous n&lsquo;avez pas choisi d&lsquo;image.';
$langFile['pagethumbnail_upload_error_nouploadedfile'] = 'Aucun fichier pouvait &ecirc;tre t&eacute;l&eacute;charg&eacute;.';
$langFile['pagethumbnail_upload_error_filesize'] = 'Le fichier t&eacute;l&eacute;charge est probablement trop grand.<br />Die maximal erlaubte Dateigr&ouml;&szlig;e betr&auml;gt';
$langFile['pagethumbnail_upload_error_wrongformat'] = 'Le fichier choisi n&lsquo;est pas dans le bon format.';
$langFile['pagethumbnail_upload_error_nodir_part1'] = 'le r&eacute;pertoire des thumbnails'; // ..thumbnail-folder..
$langFile['pagethumbnail_upload_error_nodir_part2'] = 'e&lsquo;existe pas ou il ne pouvait pas &ecirc;tre cr&eacute;e.';
$langFile['pagethumbnail_upload_error_couldntmovefile_part1'] = 'Le fichier t&eacute;l&eacute;charg&eacute; ne pouvait pas &ecirc;tre d&eacute;plac&eacute; dans le dossier des thumbnails.'; // ..thumbnail-folder..
$langFile['pagethumbnail_upload_error_couldntmovefile_part2'] = 'd&eacute;placer.';
$langFile['pagethumbnail_upload_error_changeimagesize'] = 'La taille de l&lsquo;image ne pouvait pas &ecirc;tre chang&eacute;e.';
$langFile['pagethumbnail_upload_error_deleteoldfile'] = 'Le thumbnail r&eacute;cent ne pouvait pas &ecirc;tre &eacute;ffac&eacute;.';
$langFile['pagethumbnail_upload_response_fileexists'] = 'Il existe d&egrave;j&agrave; un fichier avec ce nom.<br />Le nom du fichier a &eacute;t&eacute; chang&eacute; en';
$langFile['pagethumbnail_upload_response_finish'] = 'L&lsquo;image a &eacute;t&eacute; t&eacute;l&eacute;charge avec succ&egrave;s';

/* ----------------------------------------------------------------------------------------------
* search.php
*/

// ---------- SEARCH
$langFile['search_h1'] = 'fouiller les pages';
$langFile['search_results_h1'] = 'r&eacute;sultat de recherche pour';
$langFile['search_results_text1'] = 'convergences dans le titre';
$langFile['search_results_text2'] = 'convergences dans la date ou la cat&eacute;gorie';
$langFile['search_results_text3'] = 'mots conforms:';
$langFile['search_results_text4'] = 'trouv&eacute; une phrase conforme';
$langFile['search_results_text8'] = 'convergence avec l&lsquo;ID de la page';
$langFile['search_results_count'] = 'r&eacute;sultat';
$langFile['search_results_time_part1'] = 'en'; // 12 r&eacute;sultat en 0.32 secondes
$langFile['search_results_time_part2'] = 'secondes';

// -----------------------------------------------------------------------------------------------
// RETURN ****************************************************************************************
// -----------------------------------------------------------------------------------------------
return $langFile;
?>