<?php
/*
 * feindura - Flat File Content Management System
 * Copyright (C) Fabian Vogels$adminConfig['savePath']er [frozeman.de]
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
 * ENGLISH (EN) language-file for the feindura CMS (BACKEND)
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
$langFile['thumbSize_unit'] = 'pixel';

$langFile['thumbnail_name'] = 'Page-Thumbnail';
$langFile['thumbnail_name_width'] = 'Standard <b>Width</b>';
$langFile['thumbnail_name_height'] = 'Standard <b>Height</b>';

$langFile['thumbnail_tip'] = 'It\'s possible that you still see the previous image after the upload, that due to the browser cache.[br /][br /]Um da To update the current image you have refresh the page (F5).';

$langFile['thumbnail_width_tip'] = 'Standardwidth::The width of the thumbnail in pixels.[br /][br /]The image will be resized to this value after the upload.';
$langFile['thumbnail_height_tip'] = 'Standardheight::The height of the thumbnail in pixels.[br /][br /]The image will be resized to this value after the upload.';

$langFile['thumbnail_ratio_name'] = 'Ratio';
$langFile['thumbnail_ratio_fieldText'] = 'keep ratio';
$langFile['thumbnail_ratio_noRatio'] = 'fixed ratio';
$langFile['thumbnail_ratio_noRatio_tip'] = 'Height and width is set manually';
$langFile['thumbnail_ratio_x_tip'] = 'Will be aligned by the [i]width[/i].';
$langFile['thumbnail_ratio_y_tip'] = 'Will be aligned by the [i]height[/i].';

// ---------- stylesheet
$langFile['stylesheet_name_styleFile'] = 'Stylesheet files';
$langFile['stylesheet_name_styleId'] = 'Stylesheet-Id';
$langFile['stylesheet_name_styleClass'] = 'Stylesheet-Class';

$langFile['stylesheet_styleFile_tip'] = 'Here you can specify stylesheet files, which will be used to style the HTML editor content.';
$langFile['stylesheet_styleId_tip'] = 'Here you can specify an Id-attribut, which will be add to the &lt;body&gt; tag  of the HTML-Editor.';
$langFile['stylesheet_styleClass_tip'] = 'Here you can specify an Class-attribut, which will be add to the &lt;body&gt; tag  of the HTML-Editor.';


$langFile['stylesheet_styleFile_addButton_tip'] = 'add stylesheet file';
$langFile['stylesheet_styleFile_example'] = '<b>Example</b> &quot;/style/layout.css&quot;';

// ---------- paths

$langFile['path_absolutepath'] = 'absolute path';
$langFile['path_relativepath'] = 'relative path';
$langFile['path_absolutepath_tip'] = 'Absolute Path';
$langFile['path_relativepath_tip'] = 'Relative Path';

// ---------- STATISTIC

$langFile['home_browser_h1'] = 'Browser Usage of the Users';
$langFile['log_spiderCount'] = 'web spiders';
$langFile['log_spiderCount_tip'] = 'web spider::Or webcrawler are programs of search engines which analyse and index websites.';

$langFile['log_searchwordtothissite_part1'] = 'has'; // "wort" hat 20 mal auf diese Seite geführt
$langFile['log_searchwordtothissite_part2'] = 'times led to this site';
$langFile['log_searchwordtothissite_tip'] = 'Click to search for this word in all pages.';

$langFile['log_visitCount'] = 'Visitors';
$langFile['log_currentVisitors'] = 'current visitors';
$langFile['log_currentVisitors_lastActivity'] = 'last activity';
$langFile['log_visitTime_max'] = 'longest length of stay';
$langFile['log_visitTime_min'] = 'shortest length of stay';
$langFile['log_firstVisit'] = 'first visit';
$langFile['log_lastVisit'] = 'last visit';
$langFile['log_novisit'] = 'Yet nobody visit this website.';
$langFile['log_tags_description'] = 'Searchwords which led from
<a href="http://www.google.de">Google</a>,
<a href="http://www.yahoo.de">Yahoo</a> or
<a href="http://www.bing.com">Bing (MSN)</a> to this website.';
$langFile['log_notags'] = 'No searchwords led yet to this website.';

$langFile['log_hour_single'] = 'hour';
$langFile['log_hour_multiple'] = 'hours';
$langFile['log_minute_single'] = 'minute';
$langFile['log_minute_multiple'] = 'minutes';
$langFile['log_second_single'] = 'second';
$langFile['log_second_multiple'] = 'seconds';

$langFile['log_browser_others'] = 'other';

/* ----------------------------------------------------------------------------------------------
* ---------- LOG TEXTs
*/

$langFile['log_page_saved'] = 'Page saved';
$langFile['log_page_new'] = 'New page created';
$langFile['log_page_delete'] = 'Page deleted';

$langFile['log_listPages_moved'] = 'Moved page to category';
$langFile['log_listPages_moved_in'] = 'in category'; // Example Page in Category
$langFile['log_listPages_sorted'] = 'Page sorting changed';

$langFile['log_pageThumbnail_upload'] = 'New thumbnail uploaded';
$langFile['log_pageThumbnail_delete'] = 'Thumbnail deleted';

$langFile['log_userSetup_useradd'] = 'New user created';
$langFile['log_userSetup_userdeleted'] = 'User deleted';
$langFile['log_userSetup_userpass_changed'] = 'User password changed';

$langFile['log_adminSetup_saved'] = 'Administrator-Settings saved';
$langFile['log_adminSetup_ckstyles'] = '&quot;Formatting-Styles&quot; of the HTML-Editor saved';

$langFile['log_websiteSetup_saved'] = 'Website-Settings saved';

$langFile['log_statisticSetup_saved'] = 'Statistic-Settings saved';
$langFile['log_clearStatistic_websiteStatistic'] = 'Website-Statistic deleted';
$langFile['log_clearStatistic_pagesStatistics'] = 'Page-Statistics deleted';
$langFile['log_clearStatistic_pagesStaylengthStatistics'] = 'Page-Length-Of-Stay-Statistics deleted';
$langFile['log_clearStatistic_refererLog'] = 'Referrer-Log deleted';
$langFile['log_clearStatistic_taskLog'] = 'Last Activities-Log deleted';

$langFile['log_pageSetup_saved'] = 'Page-Settings saved';
$langFile['log_pageSetup_categories_saved'] = 'Categories saved';

$langFile['log_pageSetup_saved'] = 'Category-Settings saved';
$langFile['log_pageSetup_new'] = 'New category created';
$langFile['log_pageSetup_delete'] = 'Category deleted';
$langFile['log_pageSetup_move'] = 'Category moved';

$langFile['log_pluginSetup_saved'] = 'Plugin-Settings saved of';

$langFile['log_file_saved'] = 'File saved';

$langFile['log_file_deleted'] = 'File deleted';

// ----------- page/category public/nonpuplic

$langFile['status_page_public'] = 'Page is public';
$langFile['status_page_nonpublic'] = 'Page is hidden';

$langFile['status_category_public'] = 'Category is public';
$langFile['status_category_nonpublic'] = 'Category is hidden';

// ----------- leftSidebar.loader.php

$langFile['user_nousers'] = 'No users';
$langFile['user_currentuser'] = 'The user under which you\'re logged';

/* ----------------------------------------------------------------------------------------------
* ---------- GENERAL TEXTs
*/

$langFile['txt_logo'] = 'Version ';
$langFile['txt_loading'] = 'Page is loading..';

/* ----------------------------------------------------------------------------------------------
* ---------- FRONTEND shared TEXTs
*/

$langFile['date_yesterday'] = 'Yesterday';
$langFile['date_today'] = 'Today';
$langFile['date_tomorrow'] = 'Tomorrow';

/* ----------------------------------------------------------------------------------------------
* --------- BUTTON-TEXT (index.php)
*/

// --- mainMenu
$langFile['btn_home'] = 'Dashboard';
$langFile['btn_pages'] = 'Pages';
$langFile['btn_addons'] = 'Addons';
$langFile['btn_settings'] = 'Website Settings';
$langFile['btn_search'] = 'Search Pages';

// --- adminMenu
$langFile['title_adminMenu'] = 'Administration';
$langFile['btn_adminSetup'] = 'Administrator Settings';
$langFile['btn_pageSetup'] = 'Pages Settings';
$langFile['btn_pluginSetup'] = 'Plugins Settings';
$langFile['btn_statisticSetup'] = 'Statistic Settings';
$langFile['btn_userSetup'] = 'User Management';

// --- subMenu/footer
$langFile['btn_fileManager'] = 'File Manager';
$langFile['btn_fileManager_tip'] = 'manage your files and pictures';
$langFile['btn_createPage'] = 'New Page';
$langFile['btn_createPage_tip'] = 'Create new page';
$langFile['btn_deletePage'] = 'Delete Page';
$langFile['btn_deletePage_tip'] = 'Delete this page';
$langFile['btn_pageThumbnailUpload'] = 'Upload a page thumbnail';
$langFile['btn_pageThumbnailUpload_tip'] = 'Upload a thumbnail for this page';
$langFile['btn_pageThumbnailDelete'] = 'Delete a page thumbnail';
$langFile['btn_pageThumbnailDelete_tip'] = 'Delete the thumbnail of this page';
$langFile['btn_startPage_tip'] = 'Set this page as start page';
$langFile['btn_startPage_set'] = 'This page is the start page';

// --- other
$langFile['btn_fastUp'] = 'Up';
$langFile['date_int'] = 'YYYY-MM-DD';
$langFile['date_eu'] = 'DD.MM.YYYY';
$langFile['categories_noncategory_name'] = 'Pages';
$langFile['categories_noncategory_tip'] = 'Pages without category';
$langFile['text_example'] = 'Example';

/* ----------------------------------------------------------------------------------------------
* ---------- ERROR TEXTs
*/

$langFile['error_save_settings'] = '<b>The settings could not be saved</b>';
$langFile['error_save_file'] = '<br /><br />Please check the  read- and write permissions of the file: ';

$langFile['error_read_folder_part1'] = '<br /><br />Please check the read permissions of the &quot;';
$langFile['error_save_folder_part1'] = '<br /><br />Please check the write permissions of the &quot;';

$langFile['error_folder_end'] = '&quot; Folder, it\'s subfolders and files.';
$langFile['error_folderDatabase_end'] = '&quot; Folder, it\'s subfolders and files.'; // (or the database)



/* ----------------------------------------------------------------------------------------------
* ---------- WARNINGs
*/

$langFile['warning_startPageWarning_h1'] = 'The start page is not set!';
$langFile['warning_startPageWarning'] = 'Please set a page as start page.<br />Go to <a href="?site=pages">'.$langFile['btn_pages'].'</a> and click on the <span class="startPageIcon"></span> icon on the desired page.';


$langFile['warning_fmsConfWarning_h1'] = '<span class="logoname">fein<span>dura</span></span> is not configurated!';
$langFile['warning_fmsConfWarning'] = 'The <i>base path</i> of the CMS doesn\'t match the one in the administrator-settings.<br />
Please go to the <a href="?site=adminSetup">administrator-settings</a> and configure your <span class="logoname">fein<span>dura</span></span> CMS';

$langFile['warning_jsWarning_h1'] = 'Please activate Javascript';
// no <p> tag on the start and the end, its already in the home.php
$langFile['warning_jsWarning'] = '<strong>To fully use <span class="logoname">fein<span>dura</span></span>, you need to activate  Javascript!</strong></p>
<h2>in Firefox</h2>
<p>Click on &quot;Edit&quot; &gt; &quot;Preferences&quot; and under content chedck the box &quot;activate JavaScript&quot; and finish with OK.</p>
<h2>in Internet Explorer</h2>
<p>Click on &quot;Extras&quot; &gt; &quot;Internetoptionens&quot;.<br />
There you set under &quote;Security&quote; &gt; &quote;Standardlevel&quote; choose &quot;adjust Level&quot; and activate under &quote;Scripting&quote; the piont &quot;activate Active Scripting&quot;.</p>
<h2>in Safari</h2>
<p>Click in the top menu bar on the icon on the right, choose &quot;Preferences&quot;. Activate under &quot;Security&quot; the point &quot;activate JavaScript&quot; and click OK to finish.</p>
<h2>in Mozilla</h2>
<p>Click on &quot;Edit&quot; &gt; &quot;Preferences&quot;. Under the point &quot;Advanced&quot; &gt; &quot;Scripts &amp; Plugins&quot; check &quot;Navigator&quot; and finish with OK.</p>
<h2>in Opera</h2>
<p>Click on &quot;Extras&quot; &gt; &quot;Preferences&quot;. Under &quot;Advanced&quot; &gt; &quot;Content&quot; check &quot;activate JavaScript&quot; and click OK to finsih.';

$langFile['warning_ieOld_h1'] = '<span class="logoname">fein<span>dura</span></span> is not made for older versions of the Internet Explorers';
$langFile['warning_ieOld'] = 'To completely use  <span class="logoname">fein<span>dura</span></span> CMS you need at leats Internet Explorer 7.<br /><br />Please install a newer version of the Internet Explorer,<br /> or install the <a href="http://www.google.com/chromeframe" target="_blank">Google Chrome Frame Plugin</a> for Internet Explorer,<br />or download and install the free <a href="http://www.mozilla.org/firefox/">Firefox Browser</a>.';

/* ----------------------------------------------------------------------------------------------
* leftSidebar.loader.php
*/

// ---------- QUICKMENU

$langFile['btn_quickmenu_categories'] = 'Categories';
$langFile['btn_quickmenu_pages'] = 'Pages of';

/* ----------------------------------------------------------------------------------------------
* home.php
*/

// ---------- HOME
$langFile['home_userInfo_h1'] = 'User Information';

$langFile['home_welcome_h1'] = 'Welcome in <span class="logoname">fein<span>dura</span></span>,<br />the Content Management System of your website';
$langFile['home_welcome_text'] = '<span class="logoname">fein<span>dura</span></span> is a <span class="toolTip" title="flat files::That are files on the server, in which the content of the website is stored.">flat file</span> based Content Management System.<br />Here you can manage the content of your website.';

$langFile['home_statistic_h1'] = 'Website-Statistic';

$langFile['home_user_h1'] = 'User';
$langFile['home_taskLog_h1'] = 'last activities';
$langFile['home_taskLog_nolog'] = 'none';

$langFile['home_h1_article'] = 'the';
$langFile['home_mostVisitedPages_h1'] = 'most visted pages';
$langFile['home_lastEditedPages_h1'] = 'last edited pages';
$langFile['home_longestViewedPages_h1'] = 'longest viewed pages';

$langFile['home_refererLog_h1'] = 'Websites from which visitors came';
$langFile['home_refererLog_nolog'] = 'Yet there are no visitors which came from other websites.';
$langFile['home_novisitors'] = 'There are no visitors yet';

/* ----------------------------------------------------------------------------------------------
* listPages.php
*/

// ---------- PAGES SORTABLE LIST
$langFile['sortablePageList_h1'] = 'The content of your website';
$langFile['sortablePageList_headText1'] = '';
$langFile['sortablePageList_headText2'] = 'Last edited';
$langFile['sortablePageList_headText3'] = 'Visitors';
$langFile['sortablePageList_headText4'] = 'Status';
$langFile['sortablePageList_headText5'] = 'Functions';

$langFile['sortablePageList_pagedate'] = 'Page date';
$langFile['sortablePageList_tags'] = 'Tags';

$langFile['sortablePageList_sortOrder_manuell'] = 'manuell sorting';
$langFile['sortablePageList_sortOrder_date'] = 'sort by page date';

$langFile['sortablePageList_functions_editPage'] = 'Edit page';

$langFile['sortablePageList_changeStatus_linkPage'] = 'Click here to change the status of the page.';
$langFile['sortablePageList_changeStatus_linkCategory'] = 'Click here to change the status of the category.';

$langFile['file_error_read'] = '<b>Could not read the page.</b>'.$langFile['error_read_folder_part1'].$adminConfig['savePath'].$langFile['error_folderDatabase_end'];
$langFile['sortablePageList_setStartPage_error_save'] = '<b>Could not set the start page.</b>'.$langFile['error_save_file'].' &quot;'.$adminConfig['basePath'].'config/website.config.php&quot;';
$langFile['sortablePageList_changeStatusPage_error_save'] = '<b>Could not change the status of the page.</b>'.$langFile['error_save_folder_part1'].$adminConfig['savePath'].$langFile['error_folderDatabase_end'];
$langFile['sortablePageList_changeStatusCategory_error_save'] = '<b>Could not change the status of the category.</b>'.$langFile['error_save_folder_part1'].$adminConfig['savePath'].$langFile['error_folderDatabase_end'];

$langFile['sortablePageList_info'] = 'You can change the <b>sorting</b> of the pages and move pages between categories by <b>Drag and Drop</b>.';
$langFile['sortablePageList_save'] = 'Save new sorting ...';
$langFile['sortablePageList_save_finished'] = 'New sorting successfully saved!';
$langFile['sortablePageList_error_save'] = '<b>Could not save the page.</b>'.$langFile['error_save_folder_part1'].$adminConfig['savePath'].$langFile['error_folder_end'];
$langFile['sortablePageList_error_read'] = '<b>The pages could not be read.</b>'.$langFile['error_read_folder_part1'].$adminConfig['savePath'].$langFile['error_folder_end'];
$langFile['sortablePageList_error_move'] = '<b>Could not move the page into the new category.</b>'.$langFile['error_save_folder_part1'].$adminConfig['savePath'].$langFile['error_folder_end'];
$langFile['sortablePageList_categoryEmpty'] = 'No pages available';

// ---------- FORMULAR
$langFile['form_submit'] = 'Save';
$langFile['form_cancel'] = 'Reset all input';

// ---------- ERRORWINDOW
$langFile['form_errorWindow_h1'] = 'An error occured!';


/* ----------------------------------------------------------------------------------------------
* adminSetup.php
*/

// ---------- ADMIN SETUP (on toolTips tooTips.js converts the "[" and "]" tags in the title attribute to "<" ">")
$langFile['adminSetup_version'] = '<span class="logoname">fein<span>dura</span></span> version';
$langFile['adminSetup_phpVersion'] = 'PHP version';
$langFile['adminSetup_warning_phpversion'] = 'For full functionality of <span class="logoname">fein<span>dura</span></span> you need at least'; // PHP 4.3.0
$langFile['adminSetup_srvRootPath'] = 'Server-Root-Path';

$langFile['adminSetup_error_title'] = 'Errors occured';
$langFile['adminSetup_error_writeAccess_tip'] = 'For files and directories have need to set the permissions to 777.';

$langFile['adminSetup_error_writeAccess'] = 'is not writeable';
$langFile['adminSetup_error_isFolder'] = 'is not a directory';

// ---------- FMS Settings
$langFile['adminSetup_fmsSettings_error_save'] = $langFile['error_save_settings'].$langFile['error_save_file'].$adminConfig['basePath'].'config/admin.config.php';

$langFile['adminSetup_fmsSettings_h1'] = 'Basic-Settings';

$langFile['adminSetup_fmsSettings_savePathShouldBeOutside'] = '[span class=hint]The path should be outside of the CMS folder, if the CMS folder is password protected.[/span]';

$langFile['adminSetup_fmsSettings_field1'] = 'Website URL';
$langFile['adminSetup_fmsSettings_field1_tip'] = 'The URL of your website will be added automatically.';
$langFile['adminSetup_fmsSettings_field1_inputTip'] = 'The URL will be added automatically';
$langFile['adminSetup_fmsSettings_field1_inputWarningText'] = 'Please save the settings!';
$langFile['adminSetup_fmsSettings_field2'] = 'Base path';
$langFile['adminSetup_fmsSettings_field2_tip'] = 'The base path will be determined automatically and saved, the first time the settings are saved.';
$langFile['adminSetup_fmsSettings_field2_inputTip'] = 'The path will be added automatically';
$langFile['adminSetup_fmsSettings_field2_inputWarningText'] = 'Please save the settings!';
$langFile['adminSetup_fmsSettings_field3'] = 'Save path';
$langFile['adminSetup_fmsSettings_field3_tip'] = 'The [b]absolute path[/b] where the flat files with the page content will be saved.[br /][br /]'.$langFile['adminSetup_fmsSettings_savePathShouldBeOutside'];
$langFile['adminSetup_fmsSettings_field4'] = 'Upload path';
$langFile['adminSetup_fmsSettings_field4_tip'] = 'Files like uploaded pictures, Flash-Animations oder documents will be saved here.[br /][br /][span class=hint]The files can be uploaded on the Link button &gt; Upload in the HTML-Editor.[/span][br /][br /]'.$langFile['adminSetup_fmsSettings_savePathShouldBeOutside'];
$langFile['adminSetup_fmsSettings_editfiles_additonal'] = '[br /][br /]This files can be edited further down, or in the website-settings (if it\'s activated in the user-settings).[br /][br /]';
$langFile['adminSetup_fmsSettings_field5'] = 'File path for website files';
$langFile['adminSetup_fmsSettings_field5_tip'] = 'A folder with files which are used by the website. E.g to make a website multi-language.'.$langFile['adminSetup_fmsSettings_editfiles_additonal'].$langFile['adminSetup_fmsSettings_savePathShouldBeOutside'];
$langFile['adminSetup_fmsSettings_field6'] = 'File path for stylesheets';
$langFile['adminSetup_fmsSettings_field6_tip'] = 'A [b]absolute path[/b] where stylesheet files are. E.g. which can be edited by the user.'.$langFile['adminSetup_fmsSettings_editfiles_additonal'];
$langFile['adminSetup_fmsSettings_varName_ifempty'] = 'If the field is empty the standard name for the GET-Variablen will be used: ';
$langFile['adminSetup_fmsSettings_varName1'] = 'Page variable name';
$langFile['adminSetup_fmsSettings_varName1_inputTip'] = $langFile['adminSetup_fmsSettings_varName_ifempty'].'&quot;[b]page[/b]&quot;';
$langFile['adminSetup_fmsSettings_varName2'] = 'Category variable name';
$langFile['adminSetup_fmsSettings_varName2_inputTip'] = $langFile['adminSetup_fmsSettings_varName_ifempty'].'&quot;[b]category[/b]&quot;';
$langFile['adminSetup_fmsSettings_varName3'] = 'Modul variable name';
$langFile['adminSetup_fmsSettings_varName3_inputTip'] = $langFile['adminSetup_fmsSettings_varName_ifempty'].'&quot;[b]modul[/b]&quot;';
$langFile['adminSetup_fmsSettings_varName_tip'] = 'The name of the [b]$_GET Variable[/b] which will be used to link the pages.';
$langFile['adminSetup_fmsSettings_field7'] = 'Date format';
$langFile['adminSetup_fmsSettings_field7_tip'] = 'Will be used in [span class=logoname]fein[span]dura[/span][/span] and the website.[br /]Can be:[br /]DIN 5008 ('.$langFile['date_eu'].') oder[br /]ISO 8601 ('.$langFile['date_int'].')';
$langFile['adminSetup_fmsSettings_speakingUrl'] = 'URL format';
$langFile['adminSetup_fmsSettings_speakingUrl_true'] = 'Speaking URLs';
$langFile['adminSetup_fmsSettings_speakingUrl_true_example'] = '/category/example_category/example.html';
$langFile['adminSetup_fmsSettings_speakingUrl_false'] = 'URLs with variables';
$langFile['adminSetup_fmsSettings_speakingUrl_false_example'] = 'index.php?'.$adminConfig['varName']['category'].'=1&amp;'.$adminConfig['varName']['page'].'=1';
$langFile['adminSetup_fmsSettings_speakingUrl_tip'] = 'The URL format, which will be used to link the pages.[br /][br /]Speaking URLs work only if the [b]Apache[/b] [b]mod_rewrite[/b] modul is available.';
$langFile['adminSetup_fmsSettings_speakingUrl_warning'] = 'WARNING!::[span class=red]If an error occours while using speaking URLs, you have to delete the [b].htaccess file[/b] in the document root path of your webserver.[/span][br /][br /](In some FTP programs you have to show hidden files first, to see the .htaccess file)';

// ---------- speaking url ERRORs
$langFile['adminSetup_fmsSettings_speakingUrl_error_save'] = '<b>Speaking URLs</b> could not be activated'.$langFile['error_save_file'].'/.htaccess';
$langFile['adminSetup_fmsSettings_speakingUrl_error_modul'] = '<b>Speaking URLs</b> could not be activated, because the Apache MOD_REWRITE modul could not be found';


// ---------- user Settings
$langFile['adminSetup_userSettings_h1'] = 'User-Settings';
$langFile['adminSetup_userSettings_check1'] = 'Edit website files in the website-settings';
$langFile['adminSetup_userSettings_check2'] = 'Edit stylesheet files in the website-settings';
$langFile['adminSetup_userSettings_check3'] = 'activate file manager';

$langFile['adminSetup_userSettings_textarea1'] = '<strong>User information</strong> in <a href="?site=home">'.$langFile['btn_home'].'</a>';
$langFile['adminSetup_userSettings_textarea1_tip'] = 'User Information::This text will be shown in the '.$langFile['btn_home'].' page of [span class=logoname]fein[span]dura[/span][/span].';
$langFile['adminSetup_userSettings_textarea1_inputTip'] = 'If you don\'t want to display an information for the user, leave this field empty';

// ---------- editor Settings
$langFile['adminSetup_editorSettings_h1'] = 'HTML-Editor-Settings';
$langFile['adminSetup_editorSettings_field1'] = 'ENTER-Key mode';
$langFile['adminSetup_editorSettings_field1_hint'] = 'SHIFT + ENTER always generates a &quot;&lt;br /&gt;&quot;';
$langFile['adminSetup_editorSettings_field1_tip'] = 'Sets which HTML-Tag will be add when pressing the ENTER-Key in the HTML-Editor.[br /][br /][span class=hint]'.$langFile['adminSetup_editorSettings_field1_hint'].'.[/span]';
$langFile['adminSetup_editorSettings_field3_inputTip'] = 'If empty no Id-attribute will be used.';
$langFile['adminSetup_editorSettings_field4_inputTip'] = 'If empty no Class-attribute will be used.';

// ---------- thumbnail Settings
$langFile['adminSetup_thumbnailSettings_h1'] = 'Page-Thumbnail-Settings';
$langFile['adminSetup_thumbnailSettings_field3'] = 'Save path'; // Thumbnail-Speicherpfad
$langFile['adminSetup_thumbnailSettings_field3_tip'] = 'The path inside the upload path which will be used to save the thumbanils.';
$langFile['adminSetup_thumbnailSettings_field3_inputTip1'] = 'The upload path';
$langFile['adminSetup_thumbnailSettings_field3_inputTip2'] = 'Relative path::Relative to the &quot;[b]'.$adminConfig['uploadPath'].'image/[/b]&quot; path.[br /][br /]Starts without &quot;/&quot;';
$langFile['adminSetup_thumbnailSettings_field3_inputTip3'] = '<b>'.$langFile['text_example'].'</b> &quot;thumbnails/&quot; ';

// ---------- styleFile Settings
$langFile['adminSetup_styleFileSettings_h1'] = 'Edit &quot;Style Formatting&quot; of the HTML-Editors';
$langFile['adminSetup_styleFileSettings_error_save'] = '<b>The &quot;htmlEditorStyles.xml&quot; file could no be saved.</b>'.$langFile['error_save_file'];

// ---------- editFiles Settings
$langFile['editFilesSettings_error_save'] = '<b>The file could not be saved.</b>'.$langFile['error_save_file'];

$langFile['editFilesSettings_h1_style'] = 'Edit stylesheet files';
$langFile['editFilesSettings_h1_websitefiles'] = 'Edit website files';
$langFile['editFilesSettings_noDir'] = 'is not a valid directory!';
$langFile['editFilesSettings_chooseFile'] = 'Choose a file';
$langFile['editFilesSettings_createFile'] = 'Create a new file';
$langFile['editFilesSettings_createFile_inputTip'] = 'If you type a filename in here, a new file created and [b]the currently selected file will not be saved![/b]';
$langFile['editFilesSettings_noFile'] = 'No files available';

$langFile['editFilesSettings_deleteFile'] = 'Delete this file';
$langFile['editFilesSettings_deleteFile_question_part1'] = 'You really want to delete the file'; // Kategorie "test" löschen?
$langFile['editFilesSettings_deleteFile_question_part2'] = '?';

$langFile['editFilesSettings_deleteFile_error_delete'] = '<b>Could not delete the file.</b>'.$langFile['error_save_file'];

/* ----------------------------------------------------------------------------------------------
* pageSetup.php
*/

// ---------- CATEGORY SETUP (on toolTips tooTips.js converts the "[" and "]" tags in the title attribute to "<" ">")
$langFile['pageSetup_general_tag_tip'] = 'Tags can be used to create connections between pages (depending on the programming of the website)';

// ---------- page settings
$langFile['pageSetup_pageConfig_h1'] = 'Page-Settings';
$langFile['pageSetup_pageConfig_check1'] = 'Set start page';
$langFile['pageSetup_pageConfig_check1_tip'] = 'The user can set a page as the start page.[br /][br /]The start page will be used if no page variable is given through the [i]$_GET[/i] in the website.';

$langFile['pageSetup_pageConfig_noncategorypages_h1'] = 'Pages without category';
$langFile['pageSetup_pageConfig_check2'] = 'Create/delete pages';
$langFile['pageSetup_pageConfig_check2_tip'] = 'Specifies if the user can create and delete pages without category.';
$langFile['pageSetup_pageConfig_check3'] = 'Upload thumbnails';
$langFile['pageSetup_pageConfig_check3_tip'] = 'Specifies if the user can upload thumbnails for pages without category.';
$langFile['pageSetup_pageConfig_check4'] = 'Edit tags';
$langFile['pageSetup_pageConfig_check4_tip'] = 'Specifies if the user can edit tags in pages without category.[br /]'.$langFile['pageSetup_general_tag_tip'];
$langFile['pageSetup_pageConfig_check5'] = 'Activate plugins';
$langFile['pageSetup_pageConfig_check5_tip'] = 'Specifies if the user can use plugins in pages without category.';

// ---------- category settings
$langFile['pageSetup_h1'] = 'Manage-Categories';
$langFile['pageSetup_field1'] = 'Name';

$langFile['pageSetup_createCategory'] = 'Create new category';
$langFile['pageSetup_createCategory_created'] = 'New category created';
$langFile['pageSetup_createCategory_unnamed'] = 'Untitled category';

$langFile['pageSetup_deleteCategory'] = 'Delete category';
$langFile['pageSetup_deleteCategory_warning'] = 'WARNING: It will also delete all pages in this category!';
$langFile['pageSetup_deleteCategory_deleted'] = 'Category deleted';

$langFile['pageSetup_moveCategory_moved'] = 'Category moved';
$langFile['pageSetup_moveCategory_up_tip'] = 'Move category upwards';
$langFile['pageSetup_moveCategory_down_tip'] = 'Move category downwards';

$langFile['pageSetup_error_create'] = '<b>Could not create new category.</b>'.$langFile['error_save_folder_part1'].$adminConfig['basePath'].'config/'.$langFile['error_folderDatabase_end'];
$langFile['pageSetup_error_createDir'] = '<b>Could not the directory for the new category.</b>'.$langFile['error_save_folder_part1'].$adminConfig['savePath'].'&quot; Ordners.';
$langFile['pageSetup_error_delete'] = '<b>Could not delete the category</b>'.$langFile['error_save_file'].$adminConfig['basePath'].'config/category.config.php';
$langFile['pageSetup_error_deleteDir'] = '<b>Could not delete the directory of the category.</b>'.$langFile['error_save_folder_part1'].$adminConfig['savePath'].$langFile['error_folder_end'];
$langFile['pageSetup_error_save'] = $langFile['error_save_settings'].$langFile['error_save_file'].$adminConfig['basePath'].'config/category.config.php';


$langFile['pageSetup_advancedSettings'] = 'Advanced-Settings';
$langFile['pageSetup_advancedSettings_hint'] = 'If this settings are set, they overwrite the thumbnail-settings above and the '.$langFile['adminSetup_editorSettings_h1'].' in the <a href="?site=adminSetup">administrator-settings</a>.';

$langFile['pageSetup_stylesheet_ifempty'] = 'If all fields are empty, then the stylesheet settings from the '.$langFile['adminSetup_editorSettings_h1'].' will be used.';

$langFile['pageSetup_check1'] = 'Status of the category';
$langFile['pageSetup_check1_tip'] = 'Specifies if the category is visible on the website.';
$langFile['pageSetup_check2'] = 'Create/delete pages';
$langFile['pageSetup_check2_tip'] = 'Specifies if the user can create and delete pages in this category.';
$langFile['pageSetup_check3'] = 'Upload Thumbnails';
$langFile['pageSetup_check3_tip'] = 'Specifies if the user can upload thumbnails for pages in this category.';
$langFile['pageSetup_check4'] = 'Edit tags';
$langFile['pageSetup_check4_tip'] = 'Specifies if the user can edit tags in pages in this category.[br /]'.$langFile['pageSetup_general_tag_tip'];
$langFile['pageSetup_check8'] = 'Activate plugins';
$langFile['pageSetup_check8_tip'] = 'Specifies if the user can use plugins in pages in this category.';

$langFile['pageSetup_check5'] = 'Edit page date';
$langFile['pageSetup_check5_tip'] = 'The page date can be used to sort pages by date';

$langFile['pageSetup_check6'] = 'Sort by page date';
$langFile['pageSetup_check6_tip'] = 'The pages will be sorted by the page date.[br /][br /][span class=hint]Deactivates manually sorting[/span]';

$langFile['pageSetup_check7'] = 'Newest page always at the bottom';
$langFile['pageSetup_check7_tip'] = 'Sort pages [b]ascending[/b].[br /][br /][span class=hint]manual sorting overwrites this setting for the respective page.[/span]';


// ---------- deleting category
$langFile['pageSetup_deletCategory_question_part1'] = 'Delete category'; // Kategorie "test" löschen?
$langFile['pageSetup_deletCategory_question_part2'] = '?';

/* ----------------------------------------------------------------------------------------------
* websiteSetup.php
*/

// ---------- WEBSITE SETUP (on toolTips tooTips.js converts the "[" and "]" tags in the tittle attribute to "<" ">")
$langFile['websiteSetup_websiteConfig_error_save'] = $langFile['error_save_settings'].$langFile['error_save_file'].$adminConfig['basePath'].'config/website.config.php';

$langFile['websiteSetup_websiteConfig_h1'] = 'Website-Settings';
$langFile['websiteSetup_websiteConfig_field1'] = 'Website title';
$langFile['websiteSetup_websiteConfig_field1_tip'] = 'The title of the website will be shown in the browser bar.';
$langFile['websiteSetup_websiteConfig_field2'] = 'Publisher';
$langFile['websiteSetup_websiteConfig_field2_tip'] = 'The name of the organisation/company/person, which publish the website.';
$langFile['websiteSetup_websiteConfig_field3'] = 'Copyright';
$langFile['websiteSetup_websiteConfig_field3_tip'] = 'The copyright holder of the website.';

$langFile['websiteSetup_websiteConfig_field4'] = 'Search engine keywords';
$langFile['websiteSetup_websiteConfig_field4_tip'] = 'The most search engines search the website content for keywords, however you should list some keywords here, which will be stored in the &lt;meta&gt; tags of the page.';
$langFile['websiteSetup_websiteConfig_field4_inputTip'] = 'The keywords must be separated with &quot;,&quot;::'.$langFile['text_example'].':[br /]stichwort1,stichwort2,etc';
$langFile['websiteSetup_websiteConfig_field5'] = 'Website description';
$langFile['websiteSetup_websiteConfig_field5_tip'] = 'A short description which will search engines use, if the searchwords were found in the website URL and not in the content.';
$langFile['websiteSetup_websiteConfig_field5_inputTip'] = 'A short text with not more than 3 lines.';

/* ----------------------------------------------------------------------------------------------
* statisticSetup.php
*/

// ---------- STATISITC SETUP (on toolTips tooTips.js converts the "[" and "]" tags in the tittle attribute to "<" ">")
$langFile['statisticSetup_statisticConfig_error_save'] = $langFile['error_save_settings'].$langFile['error_save_file'].$adminConfig['basePath'].'config/statistic.config.php';

$langFile['statisticSetup_statisticConfig_h1'] = 'Statistic-Settings';
$langFile['statisticSetup_statisticConfig_field1'] = 'Number of the visible <b>most visited</b> pages';
$langFile['statisticSetup_statisticConfig_field1_tip'] = 'Specifies how much most visted pages will be displayed on the dashboard page.';
$langFile['statisticSetup_statisticConfig_field2'] = 'Number of the visible <b>longest viewed</b> pages';
$langFile['statisticSetup_statisticConfig_field2_tip'] = 'Specifies how much longest viewed pages will be displayed on the dashboard page.';
$langFile['statisticSetup_statisticConfig_field3'] = 'Number of the visible <b>last edited</b> pages';
$langFile['statisticSetup_statisticConfig_field3_tip'] = 'Specifies how much last edited pages will be displayed on the dashboard page.';

$langFile['statisticSetup_statisticConfig_field4'] = 'maximal number of <b>Referrer-URLs</b>';
$langFile['statisticSetup_statisticConfig_field4_tip'] = 'Specifies how much Referrer-URLs ([i]URLs which lead to the website[/i]) will be saved and displayed.';
$langFile['statisticSetup_statisticConfig_field5'] = 'maximal number of <b>Activities-Log</b>';
$langFile['statisticSetup_statisticConfig_field5_tip'] = 'Specifies how much Activities-Log will be saved and displayed.';


$langFile['statisticSetup_clearStatistic_h1'] = 'Delete statistics';
$langFile['statisticSetup_clearStatistics_websiteStatistic'] = 'Website-Statistic';
$langFile['statisticSetup_clearStatistics_websiteStatistic_tip'] = '[b]Contains[/b][ul][li]Total number of visitors[/li][li]Total number of web spiders[/li][li]Date of the first visit[/li][li]Date of the last visit[/li][li]Browser spectrum[/li][/ul]';
$langFile['statisticSetup_clearStatistics_pagesStatistic'] = 'Page-Statistics';
$langFile['statisticSetup_clearStatistics_pagesStatistic_tip'] = '[b]Contains[/b][ul][li]Number of page visitors[/li][li]Date of the first page visit[/li][li]Date of the last page visit[/li][li]shortest length of stay[/li][li]longest length of stay[/li][li]Keywords which led to this site[/li][/ul]';
$langFile['statisticSetup_clearStatistics_pagesStaylengthStatistics'] = 'only the Page-Length-Of-Stay-Statistics';
$langFile['statisticSetup_clearStatistics_pagesStaylengthStatistics_tip'] = '';
$langFile['statisticSetup_clearStatistics_refererLog'] = 'Referrer-URLs Log'; // engl.: referer
$langFile['statisticSetup_clearStatistics_refererLog_tip'] = 'A list of all URLs which led top this website.';
$langFile['statisticSetup_clearStatistics_taskLog'] = 'Activities-Log';
$langFile['statisticSetup_clearStatistics_taskLog_tip'] = 'A list of the last activities.';

$langFile['statisticSetup_clearStatistics_question_h1'] = 'Are you sure you want to delete these statistics?';

$langFile['statisticSetup_clearStatistic_pagesStatistics_error_read'] = 'Error while deleting the page statistics.'.$langFile['error_save_folder_part1'].$adminConfig['savePath'].$langFile['error_folderDatabase_end'];

/* ----------------------------------------------------------------------------------------------
* pluginSetup.php
*/

// ---------- PLUGIN SETUP (on toolTips tooTips.js converts the "[" and "]" tags in the tittle attribute to "<" ">")
$langFile['pluginSetup_editFiles_h1'] = 'Edit files';
$langFile['pluginSetup_pluginconfig_active'] = 'activate Plugin';
$langFile['pluginSetup_pluginconfig_error_save'] = $langFile['error_save_settings'].$langFile['error_save_file'].$adminConfig['basePath'];


/* ----------------------------------------------------------------------------------------------
* editor.php
*/

// ---------- page info
$langFile['editor_h1_createpage'] = 'Create new page';
$langFile['editor_pageinfo_lastsavedate'] = 'last edit';
$langFile['editor_pageinfo_lastsaveauthor'] = 'by';
$langFile['editor_pageinfo_linktothispage'] = 'Link to this page';
$langFile['editor_pageinfo_id'] = 'Page ID';
$langFile['editor_pageinfo_id_tip'] = 'The page will be saved under this ID on the server.';
$langFile['editor_pageinfo_category'] = 'Category';
$langFile['editor_pageinfo_category_noCategory'] = 'no category (ID 0)';

$langFile['editor_block_edited'] = 'were edited';

// ---------- page settings
$langFile['editor_pageSettings_h1'] = 'Settings';
$langFile['editor_pagestatistics_h1'] = 'Statistic';

$langFile['editor_pageSettings_title'] = 'Title';
$langFile['editor_pageSettings_title_tip'] = 'The title of the page';
$langFile['editor_pageSettings_field1'] = 'Short description';
$langFile['editor_pageSettings_field1_inputTip'] = 'If empty it uses the description of the website from the Website-Settings.';
$langFile['editor_pageSettings_field1_tip'] = 'A short summary of the page content. This description will be used in the META-Tags of the page.[br /][br /][span class=hint]'.$langFile['editor_pageSettings_field1_inputTip'].'[/span]';
$langFile['editor_pageSettings_field2'] = 'Tags';
$langFile['editor_pageSettings_field2_tip'] = 'Tags are keywords for this page.';
$langFile['editor_pageSettings_field2_tip_inputTip'] = 'The Tags should separated by [b]whitespaces[/b].';
$langFile['editor_pageSettings_field3'] = 'Pagedate';
$langFile['editor_pageSettings_field3_tip'] = 'The date can be used to sort pages by date. (z.B. bei Veranstaltungen)';
$langFile['editor_pageSettings_pagedate_before_inputTip'] = 'Text before the date::e.g. &quot;from 31st June until&quot;.';
$langFile['editor_pageSettings_pagedate_after_inputTip'] = 'Text after the date::';
$langFile['editor_pageSettings_pagedate_day_inputTip'] = 'Day::';
$langFile['editor_pageSettings_pagedate_month_inputTip'] = 'Month::';
$langFile['editor_pageSettings_pagedate_year_inputTip'] = 'Year::[b]Format[/b] YYYY';
$langFile['editor_pageSettings_field4'] = 'Status of the page';
$langFile['editor_pageSettings_field4_tip'] = '[b]Only if the page is public, it will be shown on the website![/b]';

$langFile['editor_pageSettings_pagedate_error'] = 'Wrong date format';
$langFile['editor_pageSettings_pagedate_error_tip'] = 'This month has eventually no 31 days.[br /]The date should have the follwing format:';

// ---------- page advanced settings
$langFile['editor_advancedpageSettings_h1'] = 'Advanced Settings';

$langFile['editor_advancedpageSettings_field1'] = 'Page stylesheet-file';
$langFile['editor_advancedpageSettings_stylesheet_ifempty'] = 'If the fields are empty, then the Stylesheet-Settings of the category will be used and if they are also empty then the one from the HTML-Editor-Settings.';

$langFile['editor_htmleditor_hotkeys_h1'] = 'Shortcut keys';
$langFile['editor_htmleditor_hotkeys_field1'] = 'select all';
$langFile['editor_htmleditor_hotkeys_field2'] = 'copy';
$langFile['editor_htmleditor_hotkeys_field3'] = 'paste';
$langFile['editor_htmleditor_hotkeys_field4'] = 'cut';
$langFile['editor_htmleditor_hotkeys_field5'] = 'undo';
$langFile['editor_htmleditor_hotkeys_field6'] = 'redo';
$langFile['editor_htmleditor_hotkeys_field7'] = 'set link';
$langFile['editor_htmleditor_hotkeys_field8'] = 'bold';
$langFile['editor_htmleditor_hotkeys_field9'] = 'italic';
$langFile['editor_htmleditor_hotkeys_field10'] = 'underline';
$langFile['editor_htmleditor_hotkeys_or'] = 'or';

$langFile['editor_savepage_error_save'] = '<b>The page could not be saved.</b>'.$langFile['error_save_folder_part1'].$adminConfig['savePath'].$langFile['error_folderDatabase_end'];

// ---------- plugin settings
$langFile['editor_pluginSettings_h1'] = 'Plugin Settings';

/* ----------------------------------------------------------------------------------------------
* deletePage.php
*/

// ---------- DELETE PAGE
$langFile['deletePage_question_part1'] = 'You really want to delete the page';
$langFile['deletePage_question_part2'] = '?';

$langFile['deletePage_finishnotexisting_part1'] = 'The page';
$langFile['deletePage_finish_part2'] = 'was successfully deleted';
$langFile['deletePage_notexisting_part2'] = 'doesn \'t exist';

$langFile['deletePage_finish_error'] = 'ERROR: The page could not be deleted!';

/* ----------------------------------------------------------------------------------------------
* pageThumbnailDelete.php
*/

// ---------- PAGE THUMBNAIL DELETE
$langFile['pageThumbnailDelete_question_part1'] = 'You really want to delete the thumbnail of the page';
$langFile['pageThumbnailDelete_question_part2'] = '?';

$langFile['pageThumbnailDelete_name'] = 'The thumbnail';
$langFile['pageThumbnailDelete_finish_part2'] = 'was successfully deleted';
$langFile['pageThumbnailDelete_notexisting_part2'] = 'doesn \'t exist';

$langFile['pageThumbnailDelete_finish_error'] = 'ERROR: The thumbnail could not be deleted!';


/* ----------------------------------------------------------------------------------------------
* pageThumbnailUpload.php
*/

// ---------- PAGE THUMBNAIL UPLOAD
$langFile['pagethumbnail_h1_part1'] = 'Upload page thumbnail of';
$langFile['pagethumbnail_h1_part2'] = '';
$langFile['pagethumbnail_field1'] = 'Select image';

$langFile['pagethumbnail_thumbinfo_formats'] = 'Only the following file formats are allowed'; //<br /><b>JPG</b>, <b>JPEG</b>, <b>GIF</b>, <b>PNG</b>
$langFile['pagethumbnail_thumbinfo_filesize'] = 'maximum filesize';
$langFile['pagethumbnail_thumbinfo_standardthumbsize'] = 'Standard image size';

$langFile['pagethumbnail_thumbsize_h1'] = 'Set image size yourself';
$langFile['pagethumbnail_thumbsize_width'] = 'Width';
$langFile['pagethumbnail_thumbsize_height'] = 'Height';

$langFile['pagethumbnail_submit_tip'] = 'Upload image';

$langFile['pagethumbnail_upload_error_nofile'] = 'You didn\'t select any file.';
$langFile['pagethumbnail_upload_error_nouploadedfile'] = 'No file was uploaded.';
$langFile['pagethumbnail_upload_error_filesize'] = 'The filesize of the uploaded image is probably to big.<br />The maximum filesize is';
$langFile['pagethumbnail_upload_error_wrongformat'] = 'The selecet file has a not supported format';
$langFile['pagethumbnail_upload_error_nodir_part1'] = 'The thumbnail folder'; // The thumbnail-folder..
$langFile['pagethumbnail_upload_error_nodir_part2'] = 'doesn\'t exist or couldn\'t be created.';
$langFile['pagethumbnail_upload_error_couldntmovefile_part1'] = 'Could not move the uploaded file in the thumbnail folder'; // ..thumbnail-folder..
$langFile['pagethumbnail_upload_error_couldntmovefile_part2'] = '.';
$langFile['pagethumbnail_upload_error_changeimagesize'] = 'Couldn\'t resize the image.';
$langFile['pagethumbnail_upload_error_deleteoldfile'] = 'Couldn\'t delete the old thumbnail.';
$langFile['pagethumbnail_upload_response_fileexists'] = 'A image with this filename already exists.<br />The uploaded file was renamed to';
$langFile['pagethumbnail_upload_response_finish'] = 'Succesfully uploaded the image.';

/* ----------------------------------------------------------------------------------------------
* search.php
*/

// ---------- SEARCH
$langFile['search_h1'] = 'Search pages';
$langFile['search_results_h1'] = 'Search results for';
$langFile['search_results_text1'] = 'Matches in the title';
$langFile['search_results_text2'] = 'Matches in the date or the category';
$langFile['search_results_text3'] = 'Matching words:';
$langFile['search_results_text4'] = 'Matching sentence';
$langFile['search_results_text8'] = 'Matching with the page ID';
$langFile['search_results_count'] = 'Results';
$langFile['search_results_time_part1'] = 'in'; // 12 Treffer in 0.32 Sekunden
$langFile['search_results_time_part2'] = 'seconds';


// -----------------------------------------------------------------------------------------------
// RETURN ****************************************************************************************
// -----------------------------------------------------------------------------------------------
return $langFile;

?>