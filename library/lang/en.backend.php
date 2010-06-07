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
$langFile['stylesheet_name_styleFile'] = 'Stylesheet-File';
$langFile['stylesheet_name_styleId'] = 'Stylesheet-Id';
$langFile['stylesheet_name_styleClass'] = 'Stylesheet-Class';

$langFile['stylesheet_styleFile_tip'] = 'Here you can specify a stylesheet-file, which will be used to style the HTML editor content.';
$langFile['stylesheet_styleId_tip'] = 'Here you can specify an Id-attribut, which will be add to the &lt;body&gt; tag  of the HTML-Editor.';
$langFile['stylesheet_styleClass_tip'] = 'Here you can specify an Class-attribut, which will be add to the &lt;body&gt; tag  of the HTML-Editor.';

$langFile['stylesheet_styleFile_example'] = '<b>Example</b> &quot;/style/layout.css&quot;';

// ---------- paths

$langFile['path_absolutepath'] = 'absolute path';
$langFile['path_relativepath'] = 'relative path';
$langFile['path_absolutepath_tip'] = 'Absolute Path::Starts with a &quot;/&quot;';
$langFile['path_relativepath_tip'] = 'Relative Path::Starts without &quot;/&quot;';

// ---------- STATISTIC

$langFile['home_browser_h1'] = 'Browser Usage of the Users';
$langFile['log_spiderCount'] = 'Spider';
$langFile['log_spiderCount_tip'] = 'Spider::Or webcrawler are programs of search engines which analyse and index websites.';

$langFile['log_searchwordtothissite_part1'] = 'has'; // "wort" hat 20 mal auf diese Seite geführt
$langFile['log_searchwordtothissite_part2'] = 'times led to this site';
$langFile['log_searchwordtothissite_tip'] = 'Click to search for this word in all pages.';

$langFile['log_visitCount'] = 'Visitors';
$langFile['log_visitTime_max'] = 'longest retention';
$langFile['log_visitTime_min'] = 'shortest retention';
$langFile['log_firstVisit'] = 'since';
$langFile['log_lastVisit'] = 'last visit';
$langFile['log_novisit'] = 'Nobody visit this website yet.';
$langFile['log_tags_description'] = 'Serchwords which led from
<a href="http://www.google.de">Google</a>,
<a href="http://www.yahoo.de">Yahoo</a> oder
<a href="http://www.bing.com">Bing (MSN)</a> to this website.';
$langFile['log_notags'] = 'No searchwords led to this website yet.';

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
$langFile['log_page_new'] = 'Created new page';
$langFile['log_page_delete'] = 'Deleted Page';

$langFile['log_listPages_moved'] = 'Moved page in category';
$langFile['log_listPages_moved_in'] = 'in'; // Example Page in Category
$langFile['log_listPages_sorted'] = 'Resorted page';

$langFile['log_pageThumbnail_upload'] = 'Uploaded new thumbnail';
$langFile['log_pageThumbnail_delete'] = 'Deleted thumbnail';

$langFile['log_userSetup_useradd'] = 'Created new user';

$langFile['log_adminSetup_saved'] = 'Saved Administrator-Settings';
$langFile['log_adminSetup_ckstyles'] = 'Saved &quot;Formatting-Styles&quot; of the HTML-Editor';

$langFile['log_websiteSetup_saved'] = 'Saved Website-Settings';

$langFile['log_statisticSetup_saved'] = 'SavedStatistikc-Settings';
$langFile['log_clearStatistic_websiteStatistic'] = 'Deleted Website-Statistic';
$langFile['log_clearStatistic_pagesStatistics'] = 'Deleted Page-Statistics';
$langFile['log_clearStatistic_refererLog'] = 'Deleted Referrer-Log';
$langFile['log_clearStatistic_taskLog'] = 'Deleted last Activities-Log';

$langFile['log_pageSetup_saved'] = 'Saved Page-Settings';

$langFile['log_pageSetup_saved'] = 'Saved Category-Settings';
$langFile['log_pageSetup_new'] = 'Created new category';
$langFile['log_pageSetup_delete'] = 'Deleted category';
$langFile['log_pageSetup_move'] = 'Moved category';

$langFile['log_pluginSetup_saved'] = 'Saved Plugin-Settings';

$langFile['log_file_saved'] = 'Saved file';

$langFile['log_file_deleted'] = 'Deleted file';

// ----------- page/category public/nonpuplic

$langFile['status_page_public'] = 'Page is public';
$langFile['status_page_nonpublic'] = 'Page is hidden';

$langFile['status_category_public'] = 'Category is public';
$langFile['status_category_nonpublic'] = 'Category is hidden';

// ----------- sidebar.include.php

$langFile['user_nousers'] = 'No users';
$langFile['user_currentuser'] = 'The user under which you\'re logged';

/* ----------------------------------------------------------------------------------------------
* ---------- GENERAL TEXTs
*/

$langFile['txt_logo'] = 'feindura, Version ';
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
$langFile['btn_home'] = 'Overview';
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
$langFile['home_userInfo_h1'] = 'User information';

$langFile['home_welcome_h1'] = 'Welcome in <span class="logoname">fein<span>dura</span></span><br />the Content Management System of your website.';
$langFile['home_welcome_text'] = '<span class="logoname">fein<span>dura</span></span> is a <span class="toolTip" title="flat files::are files on the server, in which the content of the website is stored.">flat file</span> based Content Management System.<br />Here you can manage the content of your website.';

$langFile['home_statistic_h1'] = 'Website-Statistic';

$langFile['home_user_h1'] = 'User';
$langFile['home_taskLog_h1'] = 'last activities';
$langFile['home_taskLog_nolog'] = 'none';

$langFile['home_h1_article'] = 'the';
$langFile['home_mostVisitedPages_h1'] = 'most visted pages';
$langFile['home_lastEditedPages_h1'] = 'last visited pages';
$langFile['home_longestViewedPages_h1'] = 'longest viewed pages';

$langFile['home_refererLog_h1'] = 'Websites from which visitors came';
$langFile['home_refererLog_nolog'] = 'There are no visitors which came from other websites yet.';
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

$langFile['file_error_read'] = '<b>Could not read the page.</b>'.$langFile['error_read_folder_part1'].$adminConfig['basePath'].$adminConfig['savePath'].$langFile['error_folderDatabase_end'];
$langFile['sortablePageList_setStartPage_error_save'] = '<b>Could not set the start page.</b>'.$langFile['error_save_file'].' &quot;'.$adminConfig['basePath'].'config/website.config.php&quot;';
$langFile['sortablePageList_changeStatusPage_error_save'] = '<b>Could not change the status of the page.</b>'.$langFile['error_save_folder_part1'].$adminConfig['basePath'].$adminConfig['savePath'].$langFile['error_folderDatabase_end'];
$langFile['sortablePageList_changeStatusCategory_error_save'] = '<b>Could not change the status of the category.</b>'.$langFile['error_save_folder_part1'].$adminConfig['basePath'].$adminConfig['savePath'].$langFile['error_folderDatabase_end'];

$langFile['sortablePageList_info'] = 'You can change the <b>sorting</b> of the pages and move pages between categories by <b>Drag and Drop</b>.';
$langFile['sortablePageList_save'] = 'Save new sorting ...';
$langFile['sortablePageList_save_finished'] = 'New sorting successfully saved!';
$langFile['sortablePageList_error_save'] = '<b>Could not save the page.</b>'.$langFile['error_save_folder_part1'].$adminConfig['basePath'].$adminConfig['savePath'].$langFile['error_folder_end'];
$langFile['sortablePageList_error_read'] = '<b>The pages could not be read.</b>'.$langFile['error_read_folder_part1'].$adminConfig['basePath'].$adminConfig['savePath'].$langFile['error_folder_end'];
$langFile['sortablePageList_error_move'] = '<b>Could not move the page into the new category.</b>'.$langFile['error_save_folder_part1'].$adminConfig['basePath'].$adminConfig['savePath'].$langFile['error_folder_end'];
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
$langFile['adminSetup_fmsSettings_field4_tip'] = '[b]Absolute path[/b][br /]Files like uploaded pictures, Flash-Animations oder documents will be saved here.[br /][br /]Subfolders for each filetyp will be created automatically[br /](images, flash, files)[br /][br /][span class=hint]The files can be uploaded on the Link button &gt; Upload in the HTML-Editor.[/span][br /][br /]'.$langFile['adminSetup_fmsSettings_savePathShouldBeOutside'];
$langFile['adminSetup_fmsSettings_editfiles_additonal'] = '[br /][br /]This files can be edited further down or in the website-settings (if it\'s activated in the user-settings).[br /][br /]';
$langFile['adminSetup_fmsSettings_field5'] = 'File path for website files';
$langFile['adminSetup_fmsSettings_field5_tip'] = 'This files can be usefull, for Example, to make a website multi-language.'.$langFile['adminSetup_fmsSettings_editfiles_additonal'].$langFile['adminSetup_fmsSettings_savePathShouldBeOutside'];
$langFile['adminSetup_fmsSettings_field6'] = 'File path for stylesheets';
$langFile['adminSetup_fmsSettings_field6_tip'] = 'The [b]absolute path[/b], where the stylesheet files of the website are.'.$langFile['adminSetup_fmsSettings_editfiles_additonal'];
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
$langFile['adminSetup_fmsSettings_speakingUrl_tip'] = 'The URL format, which will be used to link the pages.[br /][br /]Speaking URLs only work if the [b]Apache[/b] [b]mod_rewrite[/b] modul is available.';
$langFile['adminSetup_fmsSettings_speakingUrl_warning'] = 'WARNING!::[span class=red]If an error occours while using speaking URLs, you have to delete the [b].htaccess file[/b] in the document root path of your webserver.[/span][br /][br /](In some FTP programs you have to show hidden files first, to see the .htaccess file)';

// ---------- speaking url ERRORs
$langFile['adminSetup_fmsSettings_speakingUrl_error_save'] = '<b>Speaking URLs</b> could not be activated'.$langFile['error_save_file'].'/.htaccess';

// ---------- user Settings
$langFile['adminSetup_userSettings_h1'] = 'User-Settings';
$langFile['adminSetup_userSettings_check1'] = 'Edit website files in the website-settings';
$langFile['adminSetup_userSettings_check2'] = 'Edit stylesheet files in the website-settings';

$langFile['adminSetup_userSettings_textarea1'] = '<strong>User information</strong> in <a href="?site=home">'.$langFile['btn_home'].'</a>';
$langFile['adminSetup_userSettings_textarea1_tip'] = 'User information::This text will be shown in the '.$langFile['btn_home'].' page of [span class=logoname]fein[span]dura[/span][/span].';
$langFile['adminSetup_userSettings_textarea1_inputTip'] = 'Let this field empty to don\'t show an information for the user';

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
$langFile['pageSetup_pageConfig_check2_tip'] = 'Says if the user can create and delete pages without category.';
$langFile['pageSetup_pageConfig_check3'] = 'Upload thumbnails';
$langFile['pageSetup_pageConfig_check3_tip'] = 'Says if the user can upload thumbnails for pages without category.';
$langFile['pageSetup_pageConfig_check4'] = 'Edit tags';
$langFile['pageSetup_pageConfig_check4_tip'] = 'Says if the user can edit tags in pages without category.[br /]'.$langFile['pageSetup_general_tag_tip'];
$langFile['pageSetup_pageConfig_check5'] = 'Activate plugins';
$langFile['pageSetup_pageConfig_check5_tip'] = 'Says if the user can use plugins in pages without category.';

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
$langFile['pageSetup_error_createDir'] = '<b>Could not the directory for the new category.</b>'.$langFile['error_save_folder_part1'].$adminConfig['basePath'].$adminConfig['savePath'].'&quot; Ordners.';
$langFile['pageSetup_error_delete'] = '<b>Could not delete the category</b>'.$langFile['error_save_file'].$adminConfig['basePath'].'config/category.config.php';
$langFile['pageSetup_error_deleteDir'] = '<b>Could not delete the directory of the category.</b>'.$langFile['error_save_folder_part1'].$adminConfig['basePath'].$adminConfig['savePath'].$langFile['error_folder_end'];
$langFile['pageSetup_error_save'] = $langFile['error_save_settings'].$langFile['error_save_file'].$adminConfig['basePath'].'config/category.config.php';


$langFile['pageSetup_advancedSettings'] = 'Advanced-Settings';
$langFile['pageSetup_advancedSettings_hint'] = 'If this settings are set, they overwrite the thumbnail-settings above and the '.$langFile['adminSetup_editorSettings_h1'].' in the <a href="?site=adminSetup">administrator-settings</a>.';

$langFile['pageSetup_stylesheet_ifempty'] = 'If this field is empty, it uses the stylesheet settings from the '.$langFile['adminSetup_editorSettings_h1'].'.';

$langFile['pageSetup_check1'] = 'Status of the category';
$langFile['pageSetup_check1_tip'] = 'Says if the category is visible on the website.';
$langFile['pageSetup_check2'] = 'Create/delete pages';
$langFile['pageSetup_check2_tip'] = 'Says if the user can create and delete pages in this category.';
$langFile['pageSetup_check3'] = 'Upload Thumbnails';
$langFile['pageSetup_check3_tip'] = 'Says if the user can upload thumbnails for pages in this category.';
$langFile['pageSetup_check4'] = 'Edit tags';
$langFile['pageSetup_check4_tip'] = 'Says if the user can edit tags in pages in this category.[br /]'.$langFile['pageSetup_general_tag_tip'];
$langFile['pageSetup_check8'] = 'Activate plugins';
$langFile['pageSetup_check8_tip'] = 'Says if the user can use plugins in pages in this category.';

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
$langFile['websiteSetup_websiteConfig_field6'] = 'E-mail address';
$langFile['websiteSetup_websiteConfig_field6_tip'] = 'This E-mail address will be used for all important contact options. [br /](e.g. contactforms etc.)';
$langFile['websiteSetup_websiteConfig_field6_inputTip'] = $langFile['text_example'].'::name@providor.com';


/* ----------------------------------------------------------------------------------------------
* statisticSetup.php
*/

// ---------- STATISITC SETUP (on toolTips tooTips.js converts the "[" and "]" tags in the tittle attribute to "<" ">")
$langFile['statisticSetup_statisticConfig_error_save'] = $langFile['error_save_settings'].$langFile['error_save_file'].$adminConfig['basePath'].'config/statistic.config.php';

$langFile['statisticSetup_statisticConfig_h1'] = 'Statistik-Einstellungen';
$langFile['statisticSetup_statisticConfig_field1'] = 'Anzahl der sichtbaren <b>meist besuchten</b> Seiten';
$langFile['statisticSetup_statisticConfig_field1_tip'] = 'Gibt an wieviele meist besuchte Seiten auf der &Uuml;bersicht-Seite angezeigt werden.';
$langFile['statisticSetup_statisticConfig_field2'] = 'Anzahl der sichtbaren <b>am l&auml;ngsten betrachteten</b> Seiten';
$langFile['statisticSetup_statisticConfig_field2_tip'] = 'Gibt an wieviele am l&auml;ngsten betrachtete Seiten auf der &Uuml;bersicht-Seite angezeigt werden.';
$langFile['statisticSetup_statisticConfig_field3'] = 'Anzahl der sichtbaren <b>zuletzt bearbeiteten</b> Seiten';
$langFile['statisticSetup_statisticConfig_field3_tip'] = 'Gibt an wieviele zuletzt bearbeitete Seiten auf der &Uuml;bersicht-Seite angezeigt werden.';

$langFile['statisticSetup_statisticConfig_field4'] = 'maximale Anzahl der zu speichernden <b>Referrer-URLs</b>';
$langFile['statisticSetup_statisticConfig_field4_tip'] = 'Gibt an wieviele Referrer-URLs ([i]URLs die auf diese Webseite gef&uuml;hrt haben[/i]) maximal gespeichert werden.';
$langFile['statisticSetup_statisticConfig_field5'] = 'maximale Anzahl der zu speichernden <b>T&auml;tigkeiten-Logs</b>';
$langFile['statisticSetup_statisticConfig_field5_tip'] = 'Gibt an wieviele T&auml;tigkeiten-Logs maximal gespeichert werden.';


$langFile['statisticSetup_clearStatistic_h1'] = 'Statistiken l&ouml;schen';
$langFile['statisticSetup_clearStatistics_websiteStatistic'] = 'Webseiten-Statistik';
$langFile['statisticSetup_clearStatistics_websiteStatistic_tip'] = '[b]Beinhaltet[/b][ul][li]Gesamtanzahl der Besucher[/li][li]Gesamtanzahl der Spider[/li][li]Datum des ersten Besuchs[/li][li]Datum des letzten Besuchs[/li][li]Browserverteilung[/li][/ul]';
$langFile['statisticSetup_clearStatistics_pagesStatistic'] = 'Seiten-Statistiken';
$langFile['statisticSetup_clearStatistics_pagesStatistic_tip'] = '[b]Beinhaltet[/b][ul][li]Anzahl der Seitenbesucher[/li][li]Datum des ersten Seitenbesuchs[/li][li]Datum des letzten Seitenbesuchs[/li][li]k&uuml;rzeste Verweildauer[/li][li]l&auml;ngste Verweildauer[/li][li]Suchmaschienen-Stichworte die auf diese Seite gef&uuml;hrt haben[/li][/ul]';
$langFile['statisticSetup_clearStatistics_refererLog'] = 'Referrer-URLs Log'; // engl.: referer
$langFile['statisticSetup_clearStatistics_refererLog_tip'] = 'Beinhaltet eine Liste mit allen Referrer-URLs die auf diese Webseite gef&uuml;hrt haben.';
$langFile['statisticSetup_clearStatistics_taskLog'] = 'Logs der letzten T&auml;tigkeiten';
$langFile['statisticSetup_clearStatistics_taskLog_tip'] = 'Beinhaltet eine Liste der letzten T&auml;tigkeiten.';

$langFile['statisticSetup_clearStatistics_question_h1'] = 'Willst du diese Statistiken wirklich l&ouml;schen?';

$langFile['statisticSetup_clearStatistic_pagesStatistics_error_read'] = 'Fehler beim l&ouml;schen der Seiten-Statistiken.'.$langFile['error_save_folder_part1'].$adminConfig['basePath'].$adminConfig['savePath'].$langFile['error_folderDatabase_end'];

/* ----------------------------------------------------------------------------------------------
* pluginSetup.php
*/

// ---------- PLUGIN SETUP (on toolTips tooTips.js converts the "[" and "]" tags in the tittle attribute to "<" ">")
$langFile['pluginSetup_editFiles_h1'] = 'Dateien bearbeiten';
$langFile['pluginSetup_pluginconfig_active'] = 'Plugin aktiviert';
$langFile['pluginSetup_pluginconfig_error_save'] = $langFile['error_save_settings'].$langFile['error_save_file'].$adminConfig['basePath'];


/* ----------------------------------------------------------------------------------------------
* editor.php
*/

// ---------- page data
$langFile['editor_h1_lastsavedate'] = 'zuletzt bearbeitet am';
$langFile['editor_h1_lastsaveauthor'] = 'von';
$langFile['editor_h1_createpage'] = 'Neue Seite erstellen';
$langFile['editor_h1_linktothispage'] = 'Link zu dieser Seite';
$langFile['editor_h1_id'] = 'Seiten ID';
$langFile['editor_h1_id_tip'] = 'Unter der Seiten ID wird die Seite auf dem Server oder in der Datenbank gespeichert.';
$langFile['editor_h1_categoryid'] = 'Kategorie ID';
$langFile['editor_h1_categoryid_noCategory'] = 'keine Kategorie';

// ---------- page settings
$langFile['editor_pageSettings_h1'] = 'Seiten-Einstellungen';
$langFile['editor_pagestatistics_h1'] = 'Seiten-Statistik';

$langFile['editor_pageSettings_title'] = 'Seiten-Titel';
$langFile['editor_pageSettings_title_tip'] = 'Der Titel der Seite';
$langFile['editor_pageSettings_field1'] = 'Seiten-Beschreibung';
$langFile['editor_pageSettings_field1_inputTip'] = 'Wenn das Feld leer ist wird die Webseiten-Beschreibung aus den Webseiten-Einstellungen verwendet.';
$langFile['editor_pageSettings_field1_inputTip'] = 'Wenn das Feld leer ist wird die Webseiten-Beschreibung aus den Webseiten-Einstellungen verwendet.';
$langFile['editor_pageSettings_field1_tip'] = 'Eine kurze Beschreibung der Seite. Diese kommt in die META-Tags der Seite.[br /][br /][span class=hint]'.$langFile['editor_pageSettings_field1_inputTip'].'[/span]';
$langFile['editor_pageSettings_field2'] = 'Tags';
$langFile['editor_pageSettings_field2_tip'] = 'Tags sind Stichworte, die mit dieser Seite verkn&uuml;pft sind.';
$langFile['editor_pageSettings_field2_tip_inputTip'] = 'Die Stichworte sollten mit [b]Leerzeichen[/b] getrennt werden.';
$langFile['editor_pageSettings_field3'] = 'Seitendatum';
$langFile['editor_pageSettings_field3_tip'] = 'Das Datum kann dazu verwendet werden, Seiten nach Aktualit&auml;t zu sortieren. (z.B. bei Veranstaltungen)';
$langFile['editor_pageSettings_pagedate_before_inputTip'] = 'Text vor dem Datum::z.B. vom Tag/Monat bis';
$langFile['editor_pageSettings_pagedate_after_inputTip'] = 'Text nach dem Datum::';
$langFile['editor_pageSettings_pagedate_day_inputTip'] = 'Tag::';
$langFile['editor_pageSettings_pagedate_month_inputTip'] = 'Monat::';
$langFile['editor_pageSettings_pagedate_year_inputTip'] = 'Jahr::[b]Format[/b] JJJJ';
$langFile['editor_pageSettings_field4'] = 'Status der Seite';
$langFile['editor_pageSettings_field4_tip'] = '[b]Nur wenn die Seite &ouml;ffentlich ist, wird diese auf der Webseite angezeigt![/b]';

$langFile['editor_pageSettings_pagedate_error'] = 'Fehlerhaftes Datumsformat';
$langFile['editor_pageSettings_pagedate_error_tip'] = 'Dieser Monat hat eventuell keine 31 Tage,[br /]und das Datum sollte folgendes Format haben:';

// ---------- page advanced settings
$langFile['editor_advancedpageSettings_h1'] = 'erweiterte Seiten-Einstellungen';

$langFile['editor_advancedpageSettings_field1'] = 'Seiten Stylesheet-Datei';
$langFile['editor_advancedpageSettings_stylesheet_ifempty'] = 'Wenn das Feld leer bleibt dann werden zuerst die Stylesheet-Einstellungen der Kategorie oder dann aus den HTML-Editor-Einstellungen verwendet.';

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

$langFile['editor_savepage_error_save'] = '<b>Die Seite konnte nicht gespeichert werden.</b>'.$langFile['error_save_folder_part1'].$adminConfig['basePath'].$adminConfig['savePath'].$langFile['error_folderDatabase_end'];

/* ----------------------------------------------------------------------------------------------
* deletePage.php
*/

// ---------- DELETE PAGE
$langFile['deletePage_question_part1'] = 'M&ouml;chtest du die Seite';
$langFile['deletePage_question_part2'] = 'wirklich l&ouml;schen?';

$langFile['deletePage_finishnotexisting_part1'] = 'Die Seite';
$langFile['deletePage_finish_part2'] = 'wurde erfolgreich gel&ouml;scht';
$langFile['deletePage_notexisting_part2'] = 'existiert nicht';

$langFile['deletePage_finish_error'] = 'FEHLER: Die Seite konnte nicht gel&ouml;scht werden!';

/* ----------------------------------------------------------------------------------------------
* pageThumbnailDelete.php
*/

// ---------- PAGE THUMBNAIL DELETE
$langFile['pageThumbnailDelete_question_part1'] = 'M&ouml;chtest du das Thumbnail von der Seite';
$langFile['pageThumbnailDelete_question_part2'] = 'wirklich l&ouml;schen?';

$langFile['pageThumbnailDelete_name'] = 'Der Thumbnail';
$langFile['pageThumbnailDelete_finish_part2'] = 'wurde erfolgreich gel&ouml;scht';
$langFile['pageThumbnailDelete_notexisting_part2'] = 'existiert nicht';

$langFile['pageThumbnailDelete_finish_error'] = 'FEHLER: Das Thumbnail konnte nicht gel&ouml;scht werden!';


/* ----------------------------------------------------------------------------------------------
* pageThumbnailUpload.php
*/

// ---------- PAGE THUMBNAIL UPLOAD
$langFile['pagethumbnail_h1_part1'] = 'Seiten-Thumbnail f&uuml;r';
$langFile['pagethumbnail_h1_part2'] = 'hochladen';
$langFile['pagethumbnail_field1'] = 'Bild ausw&auml;hlen';

$langFile['pagethumbnail_thumbinfo_formats'] = 'Nur folgende Dateiformate sind erlaubt<br /><b>JPG</b>, <b>JPEG</b> oder <b>PNG</b>';
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

/* ----------------------------------------------------------------------------------------------
* search.php
*/

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
$langFile['search_results_text8'] = '&Uuml;bereinstimmung mit der Seiten ID';
$langFile['search_results_count'] = 'Treffer';
$langFile['search_results_time_part1'] = 'in'; // 12 Treffer in 0.32 Sekunden
$langFile['search_results_time_part2'] = 'Sekunden';


// -----------------------------------------------------------------------------------------------
// RETURN ****************************************************************************************
// -----------------------------------------------------------------------------------------------
// returns the $langFile var
return $langFile;

?>