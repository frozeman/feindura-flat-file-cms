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

// -> LOGIN <-

$langFile['LOGIN_INPUT_USERNAME'] = 'Username';
$langFile['LOGIN_INPUT_PASSWORD'] = 'Password';
$langFile['LOGIN_BUTTON_LOGIN'] = 'LOG IN';
$langFile['LOGIN_TEXT_COOKIESNEEDED'] = 'Cookies must be activated';

$langFile['LOGIN_LINK_FORGOTPASSWORD'] = 'Forgot your password?';
$langFile['LOGIN_LINK_BACKTOLOGIN'] = 'back to login';
$langFile['LOGIN_BUTTON_SENDNEWPASSWORD'] = 'SEND';
$langFile['LOGIN_TEXT_NEWPASSWORDEMAIL_SUBJECT'] = 'You requested your feindura CMS password from';
$langFile['LOGIN_TEXT_NEWPASSWORDEMAIL_MESSAGE'] = 'You have requested a new password for your feindura - Flat File CMS.
Your username and your new password are:';

$langFile['LOGIN_ERROR_FORGOTPASSWORD_NOEMAIL'] = 'The user has no E-Mail address.';
$langFile['LOGIN_ERROR_FORGOTPASSWORD_NOTSEND'] = 'ERROR<br /> while sending the new password to the user-specified email address';
$langFile['LOGIN_ERROR_FORGOTPASSWORD_NOTSAVED'] = 'ERROR<br /> Could not save the new generated password.';
$langFile['LOGIN_ERROR_FORGOTPASSWORD_SUCCESS'] = 'A new password is send to the following e-mail address';

$langFile['LOGIN_ERROR_WRONGUSER'] = 'User does not exist';
$langFile['LOGIN_ERROR_WRONGPASSWORD'] = 'wrong password';

$langFile['LOGIN_TEXT_LOGOUT_PART1'] = 'Successfully logged out';
$langFile['LOGIN_TEXT_LOGOUT_PART2'] = 'further to the website';


// -> GENERAL <-

$langFile['DATE_INT'] = 'YYYY-MM-DD';
$langFile['DATE_EU'] = 'DD.MM.YYYY';
$langFile['CATEGORIES_TEXT_NONCATEGORY'] = 'Pages';
$langFile['CATEGORIES_TOOLTIP_NONCATEGORY'] = 'Pages without category';
$langFile['TEXT_EXAMPLE'] = 'Example';

$langFile['HEADER_BUTTON_GOTOWEBSITE'] = 'Frontend Editing::Click here to edit the pages directly in your website.';

// THUMBNAILS
$langFile['THUMBNAIL_TEXT_UNIT'] = 'pixel';

$langFile['THUMBNAIL_TEXT_NAME'] = 'Page-Thumbnail';
$langFile['THUMBNAIL_TEXT_WIDTH'] = 'Standard <b>Width</b>';
$langFile['THUMBNAIL_TEXT_HEIGHT'] = 'Standard <b>Height</b>';

$langFile['THUMBNAIL_TOOLTIP_PREVIEW'] = 'It\'s possible that you still see the previous image after the upload, that due to the browser cache.[br /][br /]Um da To update the current image you have refresh the page (F5).';

$langFile['THUMBNAIL_TOOLTIP_WIDTH'] = 'Standardwidth::The width of the thumbnail in pixels.[br /][br /]The image will be resized to this value after the upload.';
$langFile['THUMBNAIL_TOOLTIP_HEIGHT'] = 'Standardheight::The height of the thumbnail in pixels.[br /][br /]The image will be resized to this value after the upload.';

$langFile['THUMBNAIL_TEXT_RATIO'] = 'Ratio';
$langFile['THUMBNAIL_TEXT_KEEPRATIO'] = 'keep ratio';
$langFile['THUMBNAIL_TEXT_FIXEDRATIO'] = 'fixed ratio';
$langFile['THUMBNAIL_TOOLTIP_FIXEDRATIO'] = 'Height and width is set manually';
$langFile['THUMBNAIL_TOOLTIP_KEEPRATIO_X'] = 'Will be aligned by the [i]width[/i].';
$langFile['THUMBNAIL_TOOLTIP_KEEPRATIO_Y'] = 'Will be aligned by the [i]height[/i].';

// STYLESHEETS
$langFile['STYLESHEETS_TEXT_STYLEFILE'] = 'Stylesheet files';
$langFile['STYLESHEETS_TEXT_ID'] = 'Stylesheet-Id';
$langFile['STYLESHEETS_TEXT_CLASS'] = 'Stylesheet-Class';

$langFile['STYLESHEETS_TOOLTIP_STYLEFILE'] = 'Here you can specify stylesheet files, which will be used to style the HTML editor content.';
$langFile['STYLESHEETS_TOOLTIP_ID'] = 'Here you can specify an Id-attribut, which will be add to the &lt;body&gt; tag  of the HTML-Editor.';
$langFile['STYLESHEETS_TOOLTIP_CLASS'] = 'Here you can specify an Class-attribut, which will be add to the &lt;body&gt; tag  of the HTML-Editor.';

$langFile['STYLESHEETS_TOOLTIP_ADDSTYLEFILE'] = 'add stylesheet file';
$langFile['STYLESHEETS_EXAMPLE_STYLEFILE'] = '<b>Example</b> &quot;/style/layout.css&quot;';

// PATHS
$langFile['PATHS_TEXT_ABSOLUTE'] = 'absolute path';
$langFile['PATHS_TEXT_RELATIVE'] = 'relative path';
$langFile['PATHS_TOOLTIP_ABSOLUTE'] = 'Absolute Path';
$langFile['PATHS_TOOLTIP_RELATIVE'] = 'Relative Path';

// STATISTICS
$langFile['STATISTICS_TITLE_BROWSERCHART'] = 'Browser usage of the users';
$langFile['STATISTICS_TEXT_SPIDERCOUNT'] = 'web spiders';
$langFile['STATISTICS_TOOLTIP_SPIDERCOUNT'] = 'web spider::Or webcrawler are programs of search engines which analyse and index websites.';

$langFile['STATISTICS_TEXT_SEARCHWORD_PART1'] = 'led'; // "exampleword" led 20 times to this website
$langFile['STATISTICS_TEXT_SEARCHWORD_PART2'] = 'times to this site';
$langFile['STATISTICS_TOOLTIP_SEARCHWORD'] = 'Click to search for this word in the pages.';

$langFile['STATISTICS_TEXT_VISITORCOUNT'] = 'visitors';
$langFile['STATISTICS_TEXT_CURRENTVISITORS'] = 'current visitors';
$langFile['STATISTICS_TEXT_LASTACTIVITY'] = 'last activity';

$langFile['STATISTICS_TITLE_PAGESTATISTICS'] = 'Page Statistics';

$langFile['STATISTICS_TEXT_VISITTIME_MAX'] = 'longest length of stay';
$langFile['STATISTICS_TEXT_VISITTIME_MIN'] = 'shortest length of stay';
$langFile['STATISTICS_TEXT_FIRSTVISIT'] = 'first visit';
$langFile['STATISTICS_TEXT_LASTVISIT'] = 'last visit';
$langFile['STATISTICS_TEXT_NOVISIT'] = 'Yet nobody visit this website.';
$langFile['STATISTICS_TEXT_SEARCHWORD_DESCRIPTION'] = 'Searchwords which led from
<a href="http://www.google.de">Google</a>,
<a href="http://www.yahoo.de">Yahoo</a> or
<a href="http://www.bing.com">Bing (MSN)</a> to this website.';
$langFile['STATISTICS_TEXT_NOSEARCHWORDS'] = 'No searchwords led yet to this website.';

$langFile['STATISTICS_TEXT_HOUR_SINGULAR'] = 'hour';
$langFile['STATISTICS_TEXT_HOUR_PLURAL'] = 'hours';
$langFile['STATISTICS_TEXT_MINUTE_SINGULAR'] = 'minute';
$langFile['STATISTICS_TEXT_MINUTE_PLURAL'] = 'minutes';
$langFile['STATISTICS_TEXT_SECOND_SINGULAR'] = 'second';
$langFile['STATISTICS_TEXT_SECOND_PLURAL'] = 'seconds';

$langFile['STATISTICS_TEXT_BROWSERCHART_OTHERS'] = 'other';

// LOG TEXTS
$langFile['LOG_PAGE_SAVED'] = 'Page saved';
$langFile['LOG_PAGE_NEW'] = 'New page created';
$langFile['LOG_PAGE_DELETE'] = 'Page deleted';

$langFile['LOG_PAGE_MOVEDINCATEGORY'] = 'Moved page to category';
$langFile['LOG_PAGE_MOVEDINCATEGORY_CATEGORY'] = 'in category'; // Example Page in Category
$langFile['LOG_PAGE_SORTED'] = 'Page sorting changed';

$langFile['LOG_THUMBNAIL_UPLOAD'] = 'New thumbnail uploaded';
$langFile['LOG_THUMBNAIL_DELETE'] = 'Thumbnail deleted';

$langFile['LOG_USER_ADD'] = 'New user created';
$langFile['LOG_USER_DELETED'] = 'User deleted';
$langFile['LOG_USER_PASSWORD_CHANGED'] = 'User password changed';
$langFile['LOG_USER_SAVED'] = 'User saved';

$langFile['LOG_ADMINSETUP_SAVED'] = 'Administrator-Settings saved';
$langFile['LOG_ADMINSETUP_CKSTYLES'] = '&quot;Formatting-Styles&quot; of the HTML-Editor saved';

$langFile['LOG_WEBSITESETUP_SAVED'] = 'Website-Settings saved';

$langFile['LOG_STATISTICSETUP_SAVED'] = 'Statistic-Settings saved';
$langFile['LOG_CLEARSTATISTICS_WEBSITESTATISTIC'] = 'Website-Statistic deleted';
$langFile['LOG_CLEARSTATISTICS_PAGESTATISTICS'] = 'Page-Statistics deleted';
$langFile['LOG_CLEARSTATISTICS_PAGESTAYLENGTH'] = 'Page-Length-Of-Stay-Statistics deleted';
$langFile['LOG_CLEARSTATISTICS_REFERERLOG'] = 'Referrer-Log deleted';
$langFile['LOG_CLEARSTATISTICS_ACTIVITYLOG'] = 'Last Activities-Log deleted';

$langFile['LOG_PAGESETUP_SAVED'] = 'Page-Settings saved';
$langFile['LOG_PAGESETUP_CATEGORIES_SAVED'] = 'Categories saved';

$langFile['LOG_PAGESETUP_CATEGORIES_NEW'] = 'New category created';
$langFile['LOG_PAGESETUP_CATEGORIES_DELETED'] = 'Category deleted';
$langFile['LOG_PAGESETUP_CATEGORIES_MOVED'] = 'Category moved';

$langFile['LOG_PLUGINSETUP_SAVED'] = 'Plugin-Settings saved of';

$langFile['LOG_FILE_SAVED'] = 'File saved';
$langFile['LOG_FILE_DELETED'] = 'File deleted';

// PAGE/CATEGORY STATUS
$langFile['STATUS_PAGE_PUBLIC'] = 'Page is public';
$langFile['STATUS_PAGE_NONPUBLIC'] = 'Page is hidden';

$langFile['STATUS_CATEGORY_PUBLIC'] = 'Category is public';
$langFile['STATUS_CATEGORY_NONPUBLIC'] = 'Category is hidden';

// USER LIST
$langFile['USER_TEXT_NOUSER'] = 'No users';
$langFile['USER_TEXT_CURRENTUSER'] = 'The user under which you\'re logged';
$langFile['USER_TEXT_USERSONLINE'] = 'This user is also logged in::Latest activity';

$langFile['LOGO_TEXT'] = 'Version';
$langFile['txt_logo_gotowebsite'] = 'Click here to go to your website.';
$langFile['LOADING_TEXT_LOAD'] = 'Page is loading..';


// -> BUTTON TEXTS

// MAIN MENU
$langFile['BUTTON_HOME'] = 'Dashboard';
$langFile['BUTTON_PAGES'] = 'Pages';
$langFile['BUTTON_ADDONS'] = 'Addons';
$langFile['BUTTON_WEBSITESETTINGS'] = 'Website Settings';
$langFile['BUTTON_SEARCH'] = 'Search Pages';

// ADMIN MENU
$langFile['HEADER_TITLE_ADMINMENU'] = 'Administration';
$langFile['BUTTON_ADMINSETUP'] = 'Administrator Settings';
$langFile['BUTTON_PAGESETUP'] = 'Pages Settings';
$langFile['BUTTON_PLUGINSETUP'] = 'Plugins Settings';
$langFile['BUTTON_STATISTICSETUP'] = 'Statistic Settings';
$langFile['BUTTON_USERSETUP'] = 'User Management';
$langFile['BUTTON_BACKUP'] = 'Backup Restore';

// SUB MENU/FOOTER
$langFile['BUTTON_FILEMANAGER'] = 'File Manager';
$langFile['BUTTON_TOOLTIP_FILEMANAGER'] = 'manage your files and pictures';
$langFile['BUTTON_CREATEPAGE'] = 'New Page';
$langFile['BUTTON_TOOLTIP_CREATEPAGE'] = 'Create new page';
$langFile['BUTTON_DELETEPAGE'] = 'Delete Page';
$langFile['BUTTON_TOOLTIP_DELETEPAGE'] = 'Delete this page';
$langFile['BUTTON_THUMBNAIL_UPLOAD'] = 'Upload a page thumbnail';
$langFile['BUTTON_TOOLTIP_THUMBNAIL_UPLOAD'] = 'Upload a thumbnail for this page';
$langFile['BUTTON_THUMBNAIL_DELETE'] = 'Delete a page thumbnail';
$langFile['BUTTON_TOOLTIP_THUMBNAIL_DELETE'] = 'Delete the thumbnail of this page';

// OTHER BUTTONS
$langFile['BUTTON_UP'] = 'Up';


// -> GENERAL ERROR TEXTS
$langFile['ERROR_SAVE_SETTINGS'] = '<b>The settings could not be saved</b>';
$langFile['ERROR_SAVE_FILE'] = '<br /><br />Please check the  read- and write permissions of the file: ';

$langFile['ERROR_READ_FOLDER_PART1'] = '<br /><br />Please check the read permissions of the &quot;';
$langFile['ERROR_SAVE_FOLDER_PART1'] = '<br /><br />Please check the write permissions of the &quot;';

$langFile['ERROR_FOLDER_PART2'] = '&quot; Folder, it\'s subfolders and files.';

/*
* ---------- WARNINGs
*/

$langFile['warning_startPageWarning_h1'] = 'The start page is not set!';
$langFile['warning_startPageWarning'] = 'Please set a page as start page.<br />Go to <a href="?site=pages">'.$langFile['BUTTON_PAGES'].'</a> and click on the <span class="startPageIcon"></span> icon on the desired page.';


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

/*
* leftSidebar.loader.php
*/

// ---------- QUICKMENU

$langFile['btn_quickmenu_categories'] = 'Categories';
$langFile['btn_quickmenu_pages'] = 'Pages of';

/*
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

/*
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

$langFile['file_error_read'] = '<b>Could not read the page.</b>'.$langFile['ERROR_READ_FOLDER_PART1'].$adminConfig['savePath'].$langFile['ERROR_FOLDER_PART2'];
$langFile['sortablePageList_setStartPage_error_save'] .= $langFile['ERROR_SAVE_FILE'].' &quot;'.$adminConfig['basePath'].'config/website.config.php&quot;'; // also in en.shared.php
$langFile['sortablePageList_changeStatusPage_error_save'] = '<b>Could not change the status of the page.</b>'.$langFile['ERROR_SAVE_FOLDER_PART1'].$adminConfig['savePath'].$langFile['ERROR_FOLDER_PART2'];
$langFile['sortablePageList_changeStatusCategory_error_save'] = '<b>Could not change the status of the category.</b>'.$langFile['ERROR_SAVE_FOLDER_PART1'].$adminConfig['savePath'].$langFile['ERROR_FOLDER_PART2'];

$langFile['sortablePageList_info'] = 'You can change the <b>sorting</b> of the pages and move pages between categories by <b>Drag and Drop</b>.';
$langFile['sortablePageList_save'] = 'Save new sorting ...';
$langFile['sortablePageList_save_finished'] = 'New sorting successfully saved!';
$langFile['sortablePageList_error_save'] = '<b>Could not save the page.</b>'.$langFile['ERROR_SAVE_FOLDER_PART1'].$adminConfig['savePath'].$langFile['ERROR_FOLDER_PART2'];
$langFile['sortablePageList_error_read'] = '<b>The pages could not be read.</b>'.$langFile['ERROR_READ_FOLDER_PART1'].$adminConfig['savePath'].$langFile['ERROR_FOLDER_PART2'];
$langFile['sortablePageList_error_move'] = '<b>Could not move the page into the new category.</b>'.$langFile['ERROR_SAVE_FOLDER_PART1'].$adminConfig['savePath'].$langFile['ERROR_FOLDER_PART2'];
$langFile['sortablePageList_categoryEmpty'] = 'No pages available';

// ---------- FORMULAR
$langFile['form_submit'] = 'Save';
$langFile['form_cancel'] = 'Reset all input';


/*
* adminSetup.php
*/

// ---------- ADMIN SETUP (on toolTips tooTips.js converts the "[" and "]" tags in the title attribute to "<" ">")
$langFile['adminSetup_version'] = '<span class="logoname">fein<span>dura</span></span> version';
$langFile['adminSetup_phpVersion'] = 'PHP version';
$langFile['adminSetup_warning_phpversion'] = 'For full functionality of <span class="logoname">fein<span>dura</span></span> you need at least'; // PHP 4.3.0
$langFile['adminSetup_srvRootPath'] = 'Server-Root-Path';

$langFile['adminSetup_error_title'] = 'Errors occured';
$langFile['adminSetup_error_writeAccess_tip'] = 'For files and directories have need to set the permissions to '.decoct(PERMISSIONS).'.';

$langFile['adminSetup_error_writeAccess'] = 'is not writeable';
$langFile['adminSetup_error_isFolder'] = 'is not a directory';

// ---------- FMS Settings
$langFile['adminSetup_fmsSettings_error_save'] = $langFile['ERROR_SAVE_SETTINGS'].$langFile['ERROR_SAVE_FILE'].$adminConfig['basePath'].'config/admin.config.php';

$langFile['adminSetup_fmsSettings_h1'] = 'Basic-Settings';

$langFile['adminSetup_fmsSettings_field1'] = 'Website URL';
$langFile['adminSetup_fmsSettings_field1_tip'] = 'The URL of your website will be added automatically.';
$langFile['adminSetup_fmsSettings_field1_inputTip'] = 'The URL will be added automatically';
$langFile['adminSetup_fmsSettings_field1_inputWarningText'] = 'Please save the settings!';
$langFile['adminSetup_fmsSettings_field2'] = 'feindura path';
$langFile['adminSetup_fmsSettings_field2_tip'] = 'The base path will be determined automatically and saved, the first time the settings are saved.';
$langFile['adminSetup_fmsSettings_field2_inputTip'] = 'The path will be added automatically';
$langFile['adminSetup_fmsSettings_field2_inputWarningText'] = 'Please save the settings!';
$langFile['adminSetup_fmsSettings_field8'] = 'Website path';
$langFile['adminSetup_fmsSettings_field8_tip'] = 'The [b]absolute path[/b] where the website is situated.';
$langFile['adminSetup_fmsSettings_field3'] = 'Save path';
$langFile['adminSetup_fmsSettings_field3_tip'] = 'The [b]absolute path[/b] where the flat files with the page content will be saved.';
$langFile['adminSetup_fmsSettings_field4'] = 'Upload path';
$langFile['adminSetup_fmsSettings_field4_tip'] = 'Files like uploaded pictures, Flash-Animations oder documents will be saved here.[br /][br /][span class=hint]The files can be uploaded on the Link button &gt; Upload in the HTML-Editor or in the file manager.[/span]';
$langFile['adminSetup_fmsSettings_editfiles_additonal'] = '[br /][br /]This files can be edited further down, or in the website-settings (if it\'s activated in the user-settings).[br /][br /]';
$langFile['adminSetup_fmsSettings_field5'] = 'File path for website files';
$langFile['adminSetup_fmsSettings_field5_tip'] = 'A folder with files which are used by the website. E.g to make a website multi-language.'.$langFile['adminSetup_fmsSettings_editfiles_additonal'];
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
$langFile['adminSetup_fmsSettings_field7_tip'] = 'Will be used in [span class=logoname]fein[span]dura[/span][/span] and the website.[br /]Can be:[br /]DIN 5008 ('.$langFile['DATE_EU'].') oder[br /]ISO 8601 ('.$langFile['DATE_INT'].')';
$langFile['adminSetup_fmsSettings_speakingUrl'] = 'URL format';
$langFile['adminSetup_fmsSettings_speakingUrl_true'] = 'Speaking URLs';
$langFile['adminSetup_fmsSettings_speakingUrl_true_example'] = '/category/example_category/example.html';
$langFile['adminSetup_fmsSettings_speakingUrl_false'] = 'URLs with variables';
$langFile['adminSetup_fmsSettings_speakingUrl_false_example'] = 'index.php?'.$adminConfig['varName']['category'].'=1&amp;'.$adminConfig['varName']['page'].'=1';
$langFile['adminSetup_fmsSettings_speakingUrl_tip'] = 'The URL format, which will be used to link the pages.[br /][br /]Speaking URLs work only if the [b]Apache[/b] [b]mod_rewrite[/b] modul is available.';
$langFile['adminSetup_fmsSettings_speakingUrl_warning'] = 'WARNING!::[span class=red]If an error occours while using speaking URLs, you have to delete the [b].htaccess file[/b] in the document root path of your webserver.[/span][br /][br /](In some FTP programs you have to show hidden files first, to see the .htaccess file)';

// ---------- speaking url ERRORs
$langFile['adminSetup_fmsSettings_speakingUrl_error_save'] = '<b>Speaking URLs</b> could not be activated'.$langFile['ERROR_SAVE_FILE'].'/.htaccess';
$langFile['adminSetup_fmsSettings_speakingUrl_error_modul'] = '<b>Speaking URLs</b> could not be activated, because the Apache MOD_REWRITE modul could not be found';


// ---------- user Settings
$langFile['adminSetup_userSettings_h1'] = 'User-Settings';
$langFile['adminSetup_userSettings_check1'] = 'Edit website files in the website-settings';
$langFile['adminSetup_userSettings_check2'] = 'Edit stylesheet files in the website-settings';
$langFile['adminSetup_userSettings_check3'] = 'activate file manager';

$langFile['adminSetup_userSettings_textarea1'] = '<strong>User information</strong> in <a href="?site=home">'.$langFile['BUTTON_HOME'].'</a>';
$langFile['adminSetup_userSettings_textarea1_tip'] = 'User Information::This text will be shown in the '.$langFile['BUTTON_HOME'].' page of [span class=logoname]fein[span]dura[/span][/span].';
$langFile['adminSetup_userSettings_textarea1_inputTip'] = 'If you don\'t want to display an information for the user, leave this field empty';

// ---------- editor Settings
$langFile['adminSetup_editorSettings_h1'] = 'HTML-Editor-Settings';
$langFile['adminSetup_editorSettings_field1'] = 'ENTER-Key mode';
$langFile['adminSetup_editorSettings_field1_hint'] = 'SHIFT + ENTER always generates a &quot;&lt;br /&gt;&quot;';
$langFile['adminSetup_editorSettings_field1_tip'] = 'Sets which HTML-Tag will be add when pressing the ENTER-Key in the HTML-Editor.[br /][br /][span class=hint]'.$langFile['adminSetup_editorSettings_field1_hint'].'.[/span]';
$langFile['adminSetup_editorSettings_field3_inputTip'] = 'If empty no Id-attribute will be used.';
$langFile['adminSetup_editorSettings_field4_inputTip'] = 'If empty no Class-attribute will be used.';

// THUMBNAILS Settings
$langFile['adminSetup_thumbnailSettings_h1'] = 'Page-Thumbnail-Settings';
$langFile['adminSetup_thumbnailSettings_field3'] = 'Save path'; // Thumbnail-Speicherpfad
$langFile['adminSetup_thumbnailSettings_field3_tip'] = 'The path inside the upload path which will be used to save the thumbanils.';
$langFile['adminSetup_thumbnailSettings_field3_inputTip1'] = 'The upload path';
$langFile['adminSetup_thumbnailSettings_field3_inputTip2'] = 'Relative path::Relative to the &quot;[b]'.$adminConfig['uploadPath'].'[/b]&quot; path.[br /][br /]Starts without &quot;/&quot;';
$langFile['adminSetup_thumbnailSettings_field3_inputTip3'] = '<b>'.$langFile['TEXT_EXAMPLE'].'</b> &quot;thumbnails/&quot; ';

// ---------- styleFile Settings
$langFile['adminSetup_styleFileSettings_h1'] = 'Edit &quot;Style Formatting&quot; of the HTML-Editors';
$langFile['adminSetup_styleFileSettings_error_save'] = '<b>The &quot;htmlEditorStyles.xml&quot; file could no be saved.</b>'.$langFile['ERROR_SAVE_FILE'];

// ---------- editFiles Settings
$langFile['editFilesSettings_error_save'] = '<b>The file could not be saved.</b>'.$langFile['ERROR_SAVE_FILE'];

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

$langFile['editFilesSettings_deleteFile_error_delete'] = '<b>Could not delete the file.</b>'.$langFile['ERROR_SAVE_FILE'];

/*
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

$langFile['pageSetup_error_create'] = '<b>Could not create new category.</b>'.$langFile['ERROR_SAVE_FOLDER_PART1'].$adminConfig['basePath'].'config/'.$langFile['ERROR_FOLDER_PART2'];
$langFile['pageSetup_error_createDir'] = '<b>Could not the directory for the new category.</b>'.$langFile['ERROR_SAVE_FOLDER_PART1'].$adminConfig['savePath'].'&quot; Ordners.';
$langFile['pageSetup_error_delete'] = '<b>Could not delete the category</b>'.$langFile['ERROR_SAVE_FILE'].$adminConfig['basePath'].'config/category.config.php';
$langFile['pageSetup_error_deleteDir'] = '<b>Could not delete the directory of the category.</b>'.$langFile['ERROR_SAVE_FOLDER_PART1'].$adminConfig['savePath'].$langFile['ERROR_FOLDER_PART2'];
$langFile['pageSetup_error_save'] = $langFile['ERROR_SAVE_SETTINGS'].$langFile['ERROR_SAVE_FILE'].$adminConfig['basePath'].'config/category.config.php';


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

/*
* websiteSetup.php
*/

// ---------- WEBSITE SETUP (on toolTips tooTips.js converts the "[" and "]" tags in the tittle attribute to "<" ">")
$langFile['websiteSetup_websiteConfig_error_save'] = $langFile['ERROR_SAVE_SETTINGS'].$langFile['ERROR_SAVE_FILE'].$adminConfig['basePath'].'config/website.config.php';

$langFile['websiteSetup_websiteConfig_h1'] = 'Website-Settings';
$langFile['websiteSetup_websiteConfig_field1'] = 'Website title';
$langFile['websiteSetup_websiteConfig_field1_tip'] = 'The title of the website will be shown in the browser bar.';
$langFile['websiteSetup_websiteConfig_field2'] = 'Publisher';
$langFile['websiteSetup_websiteConfig_field2_tip'] = 'The name of the organisation/company/person, which publish the website.';
$langFile['websiteSetup_websiteConfig_field3'] = 'Copyright';
$langFile['websiteSetup_websiteConfig_field3_tip'] = 'The copyright holder of the website.';

$langFile['websiteSetup_websiteConfig_field4'] = 'Search engine keywords';
$langFile['websiteSetup_websiteConfig_field4_tip'] = 'The most search engines search the website content for keywords, however you should list some keywords here, which will be stored in the &lt;meta&gt; tags of the page.';
$langFile['websiteSetup_websiteConfig_field4_inputTip'] = 'The keywords must be separated with &quot;,&quot;::'.$langFile['TEXT_EXAMPLE'].':[br /]stichwort1,stichwort2,etc';
$langFile['websiteSetup_websiteConfig_field5'] = 'Website description';
$langFile['websiteSetup_websiteConfig_field5_tip'] = 'A short description which will search engines use, if the searchwords were found in the website URL and not in the content.';
$langFile['websiteSetup_websiteConfig_field5_inputTip'] = 'A short text with not more than 3 lines.';

/*
* statisticSetup.php
*/

// ---------- STATISITC SETUP (on toolTips tooTips.js converts the "[" and "]" tags in the tittle attribute to "<" ">")
$langFile['statisticSetup_statisticConfig_error_save'] = $langFile['ERROR_SAVE_SETTINGS'].$langFile['ERROR_SAVE_FILE'].$adminConfig['basePath'].'config/statistic.config.php';

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

$langFile['statisticSetup_clearStatistic_pagesStatistics_error_read'] = 'Error while deleting the page statistics.'.$langFile['ERROR_SAVE_FOLDER_PART1'].$adminConfig['savePath'].$langFile['ERROR_FOLDER_PART2'];

/*
* userSetup.php
*/

$langFile['userSetup_h1'] = 'User-Management';
$langFile['userSetup_userSelection'] = 'Users';

$langFile['userSetup_createUser'] = 'Create new user';
$langFile['userSetup_createUser_created'] = 'New user created';
$langFile['userSetup_createUser_unnamed'] = 'Unnamed user';

$langFile['userSetup_deleteUser'] = 'Delete user';
$langFile['userSetup_deleteUser_deleted'] = 'User deleted';

$langFile['userSetup_username'] = 'Username';
$langFile['userSetup_username_missing'] = 'There is no username set yet.';
$langFile['userSetup_password'] = 'Password';
$langFile['userSetup_password_change'] = 'change password';
$langFile['userSetup_password_confirm'] = 'Password confirmation';
$langFile['userSetup_password_confirm_wrong'] = 'The two passwords do not match.';
$langFile['userSetup_password_missing'] = 'There is no password set yet.';
$langFile['userSetup_password_success'] = 'Password successfully changed!';
$langFile['userSetup_email'] = 'E-Mail';
$langFile['userSetup_email_tip'] = 'If the user has forgotten his password, a new password will be sent to this e-mail.';

$langFile['userSetup_admin'] = 'Administrator';
$langFile['userSetup_admin_tip'] = 'Determines whether the user has administrator rights.';

$langFile['userSetup_error_create'] = '<b> A new user could not be created.</b>'.$langFile['ERROR_SAVE_FILE'].$adminConfig['basePath'].'config/user.config.php';
$langFile['userSetup_error_save'] = $langFile['ERROR_SAVE_SETTINGS'].$langFile['ERROR_SAVE_FILE'].$adminConfig['basePath'].'config/user.config.php';

/*
* pluginSetup.php
*/

// ---------- PLUGIN SETUP (on toolTips tooTips.js converts the "[" and "]" tags in the tittle attribute to "<" ">")

$langFile['pluginSetup_h1'] = 'Plugins-Settings';
$langFile['pluginSetup_description'] = 'Plugins provide enhanced capabilities for the pages of the website. You can add the below activated plugins to every page, as far as they are acivated in the <a href="?site=pageSetup">'.$langFile['pageSetup_pageConfig_h1'].'</a>, in the respective category.<br /><br /><i>The plugins will be included in the website through the <a href="http://feindura.org/api/%5BImplementation%5D/feindura.html#showPlugins">ShowPlugins()</a> method.</i>';

$langFile['pluginSetup_editFiles_h1'] = 'Edit files';
$langFile['pluginSetup_pluginconfig_active'] = 'activate Plugin';
$langFile['pluginSetup_pluginconfig_error_save'] = $langFile['ERROR_SAVE_SETTINGS'].$langFile['ERROR_SAVE_FILE'].$adminConfig['basePath'];


/*
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
$langFile['editor_pageNotSaved'] = 'not saved';

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

$langFile['editor_savepage_error_save'] .= $langFile['ERROR_SAVE_FOLDER_PART1'].$adminConfig['savePath'].$langFile['ERROR_FOLDER_PART2'];// also in en.shared.php

// ---------- plugin settings
$langFile['editor_pluginSettings_h1'] = 'Plugin Settings';

/*
* unsavedPage.php
*/

$langFile['unsavedPage_question_h1'] = '<span class="brown">The page has been changed.</span><br />Do you want to save the page now?';

/*
* deletePage.php
*/

// ---------- DELETE PAGE
$langFile['deletePage_question_part1'] = 'You really want to delete the page';
$langFile['deletePage_question_part2'] = '?';

$langFile['deletePage_finishnotexisting_part1'] = 'The page';
$langFile['deletePage_finish_part2'] = 'was successfully deleted';
$langFile['deletePage_notexisting_part2'] = 'doesn \'t exist';

$langFile['deletePage_finish_error'] = 'ERROR: The page could not be deleted!';

/*
* pageThumbnailDelete.php
*/

// ---------- PAGE THUMBNAIL DELETE
$langFile['pageThumbnailDelete_question_part1'] = 'You really want to delete the thumbnail of the page';
$langFile['pageThumbnailDelete_question_part2'] = '?';

$langFile['pageThumbnailDelete_name'] = 'The thumbnail';
$langFile['pageThumbnailDelete_finish_part2'] = 'was successfully deleted';
$langFile['pageThumbnailDelete_notexisting_part2'] = 'doesn \'t exist';

$langFile['pageThumbnailDelete_finish_error'] = 'ERROR: The thumbnail could not be deleted!';


/*
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

// -> BACKUP

$langFile['BACKUP_TITLE_BACKUP'] = 'Backup';
$langFile['BACKUP_TITLE_RESTORE'] = 'Restore';

$langFile['BACKUP_TITLE_RESTORE_FROMFILES'] = 'Existing backups';
$langFile['BACKUP_TITLE_RESTORE_FROMUPLOAD'] = 'Upload backup file';

$langFile['BACKUP_BUTTON_DOWNLOAD'] = 'create and download current backup';
$langFile['BACKUP_TEXT_RESTORE'] = 'Select here a <span class="logoname"><span>fein</span>dura</span> backup file, to restore an old state.<br /><span class="red">Attention! All current settings and pages will be overwritten!</span>';

$langFile['BACKUP_TITLE_LASTBACKUPS'] = 'Download backups';
$langFile['BACKUP_TEXT_NOBACKUP'] = 'No backup created yet.';

$langFile['BACKUP_ERROR_FILENOTFOUND'] = 'Backup was not found at:';

/*
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