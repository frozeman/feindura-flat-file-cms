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

$langFile['LOGIN_INPUT_USERNAME']                                         = 'Username';
$langFile['LOGIN_INPUT_PASSWORD']                                         = 'Password';
$langFile['LOGIN_BUTTON_LOGIN']                                           = 'login';
$langFile['LOGIN_TEXT_COOKIESNEEDED']                                     = 'Cookies must be activated!';

$langFile['LOGIN_LINK_FORGOTPASSWORD']                                    = 'Forgot your password?';
$langFile['LOGIN_LINK_BACKTOLOGIN']                                       = 'back to login';
$langFile['LOGIN_BUTTON_SENDNEWPASSWORD']                                 = 'Reset password';
$langFile['LOGIN_TEXT_NEWPASSWORDEMAIL_SUBJECT']                          = 'You requested your feindura CMS password from';
$langFile['LOGIN_TEXT_NEWPASSWORDEMAIL_MESSAGE']                          = 'You have requested a new password for your feindura - Flat File CMS.
Your username and your new password are:';

$langFile['LOGIN_ERROR_FORGOTPASSWORD_NOEMAIL']                           = 'The user has no E-Mail address.';
$langFile['LOGIN_ERROR_FORGOTPASSWORD_NOTSEND']                           = 'ERROR<br> while sending the new password to the user-specified email address';
$langFile['LOGIN_ERROR_FORGOTPASSWORD_NOTSAVED']                          = 'ERROR<br> Could not save the new generated password.';
$langFile['LOGIN_ERROR_FORGOTPASSWORD_SUCCESS']                           = 'A new password is send to the following e-mail address';

$langFile['LOGIN_ERROR_WRONGUSER']                                        = 'User does not exist';
$langFile['LOGIN_ERROR_WRONGPASSWORD']                                    = 'wrong password';

$langFile['LOGIN_TEXT_LOGOUT_PART1']                                      = 'Successfully logged out';
$langFile['LOGIN_TEXT_LOGOUT_PART2']                                      = 'further to the website';

$langFile['LOGIN_TIP_AUTOLOGOUT']                                         = 'Automatically logout';


// -> GENERAL <-

$langFile['DATE_Y-M-D']                                                   = 'YYYY-MM-DD';
$langFile['DATE_D.M.Y']                                                   = 'DD.MM.YYYY';
$langFile['DATE_D/M/Y']                                                   = 'DD/MM/YYYY';
$langFile['DATE_M/D/Y']                                                   = 'MM/DD/YYYY';
$langFile['CATEGORIES_TEXT_NONCATEGORY']                                  = 'Pages';
$langFile['CATEGORIES_TOOLTIP_NONCATEGORY']                               = 'Pages without category';
$langFile['TEXT_EXAMPLE']                                                 = 'Example';

$langFile['HEADER_BUTTON_GOTOWEBSITE_FRONTENDEDITING']                    = 'Frontend Editing::Click here to edit the pages directly in your website.';

$langFile['BUTTON_MORE']                                                  = 'more';

// PERMISSIONS
$langFile['PERMISSIONS_TEXT_DONTHAVEPERMISSION']                          = 'You are not authorized to change this.';

// THUMBNAILS
$langFile['THUMBNAIL_TEXT_UNIT']                                          = 'pixel';

$langFile['THUMBNAIL_TEXT_NAME']                                          = 'Page-Thumbnail';
$langFile['THUMBNAIL_TEXT_WIDTH']                                         = 'Thumbnail <b>width</b>';
$langFile['THUMBNAIL_TEXT_HEIGHT']                                        = 'Thumbnail <b>height</b>';

$langFile['THUMBNAIL_TOOLTIP_WIDTH']                                      = 'Standardwidth::The width of the thumbnail in pixels.[br][br]The image will be resized to this value after the upload.';
$langFile['THUMBNAIL_TOOLTIP_HEIGHT']                                     = 'Standardheight::The height of the thumbnail in pixels.[br][br]The image will be resized to this value after the upload.';

$langFile['THUMBNAIL_TEXT_RATIO']                                         = 'Ratio';
$langFile['THUMBNAIL_TEXT_KEEPRATIO']                                     = 'keep ratio';
$langFile['THUMBNAIL_TEXT_FIXEDRATIO']                                    = 'fixed ratio';
$langFile['THUMBNAIL_TOOLTIP_FIXEDRATIO']                                 = 'Height and width is set manually';
$langFile['THUMBNAIL_TOOLTIP_KEEPRATIO_X']                                = 'Will be aligned by the [i]width[/i].';
$langFile['THUMBNAIL_TOOLTIP_KEEPRATIO_Y']                                = 'Will be aligned by the [i]height[/i].';

// STYLESHEETS
$langFile['STYLESHEETS_TEXT_STYLEFILE']                                   = 'Stylesheet files';
$langFile['STYLESHEETS_TEXT_ID']                                          = 'Stylesheet-Id';
$langFile['STYLESHEETS_TEXT_CLASS']                                       = 'Stylesheet-Class';

$langFile['STYLESHEETS_TOOLTIP_STYLEFILE']                                = 'Here you can specify stylesheet files, which will be used to style the HTML editor content.';
$langFile['STYLESHEETS_TOOLTIP_ID']                                       = 'Here you can specify an Id-attribut, which will be add to the <body> tag  of the HTML-Editor.';
$langFile['STYLESHEETS_TOOLTIP_CLASS']                                    = 'Here you can specify an Class-attribut, which will be add to the <body> tag  of the HTML-Editor.';

$langFile['STYLESHEETS_TOOLTIP_ADDSTYLEFILE']                             = 'add stylesheet file';
$langFile['STYLESHEETS_EXAMPLE_STYLEFILE']                                = '<b>Example</b> &quot;/style/layout.css&quot;';

// PATHS
$langFile['PATHS_TEXT_ABSOLUTE']                                          = 'absolute path';
$langFile['PATHS_TEXT_RELATIVE']                                          = 'relative path';
$langFile['PATHS_TOOLTIP_ABSOLUTE']                                       = 'Absolute Path::Absolute file system Path. (But relative to the Documentroot)[br][br][span class=hint]/server/htdocs[strong]/path/[/strong][/span]';
$langFile['PATHS_TOOLTIP_RELATIVE']                                       = 'Relative Path::Relative URI Path, means relative to the current document.';

// STATISTICS
$langFile['STATISTICS_TITLE_BROWSERCHART']                                = 'Browser usage';
$langFile['STATISTICS_TEXT_ROBOTCOUNT']                                   = 'web-crawler';
$langFile['STATISTICS_TOOLTIP_ROBOTCOUNT']                                = 'web-crawler::Or robots are programs of search engines which analyse and index websites.';

$langFile['STATISTICS_TEXT_SEARCHWORD_PART1']                             = 'led'; // "exampleword" led 20 times to this website
$langFile['STATISTICS_TEXT_SEARCHWORD_PART2']                             = 'times to this site';
$langFile['STATISTICS_TOOLTIP_SEARCHWORD']                                = 'Click to search for this word in the pages.';

$langFile['STATISTICS_TEXT_VISITORCOUNT']                                 = 'Visits so far';
$langFile['STATISTICS_TEXT_CURRENTVISITORS']                              = 'Current Visitors';
$langFile['STATISTICS_TEXT_CURRENT']                                      = 'Currently';
$langFile['STATISTICS_TEXT_LASTACTIVITY']                                 = 'Last activity';

$langFile['STATISTICS_TITLE_PAGESTATISTICS']                              = 'Page Statistics';

$langFile['STATISTICS_TEXT_VISITTIME_MAX']                                = 'longest length of stay';
$langFile['STATISTICS_TEXT_VISITTIME_MIN']                                = 'shortest length of stay';
$langFile['STATISTICS_TEXT_FIRSTVISIT']                                   = 'from';
$langFile['STATISTICS_TEXT_LASTVISIT']                                    = 'to';
$langFile['STATISTICS_TEXT_NOVISIT']                                      = 'Yet nobody visit this website.';
$langFile['STATISTICS_TEXT_SEARCHWORD_DESCRIPTION']                       = '<span class="toolTipTop" title="::Which led from
Google, Yahoo or Bing (MSN) to this website.">Searchwords</span>';

$langFile['STATISTICS_TEXT_HOUR_SINGULAR']                                = 'hour';
$langFile['STATISTICS_TEXT_HOUR_PLURAL']                                  = 'hours';
$langFile['STATISTICS_TEXT_MINUTE_SINGULAR']                              = 'minute';
$langFile['STATISTICS_TEXT_MINUTE_PLURAL']                                = 'minutes';
$langFile['STATISTICS_TEXT_SECOND_SINGULAR']                              = 'second';
$langFile['STATISTICS_TEXT_SECOND_PLURAL']                                = 'seconds';

$langFile['STATISTICS_TEXT_BROWSERCHART_OTHERS']                          = 'other';

// LOG TEXTS
$langFile['LOG_PAGE_SAVED']                                               = 'Page saved';
$langFile['LOG_PAGE_NEW']                                                 = 'New page created';
$langFile['LOG_PAGE_DELETE']                                              = 'Page deleted';

$langFile['LOG_PAGE_MOVEDINCATEGORY']                                     = 'Moved page to category';
$langFile['LOG_PAGE_MOVEDTOCATEGORY_CATEGORY']                            = 'to category'; // Example Page in Category
$langFile['LOG_PAGE_SORTED']                                              = 'Page sorting changed';

$langFile['LOG_THUMBNAIL_UPLOAD']                                         = 'New thumbnail uploaded';
$langFile['LOG_THUMBNAIL_DELETE']                                         = 'Thumbnail deleted';

$langFile['LOG_USER_ADD']                                                 = 'New user created';
$langFile['LOG_USER_DELETED']                                             = 'User deleted';
$langFile['LOG_USER_PASSWORD_CHANGED']                                    = 'User password changed';
$langFile['LOG_USER_SAVED']                                               = 'User saved';

$langFile['LOG_ADMINSETUP_SAVED']                                         = 'Administrator-Settings saved';
$langFile['LOG_ADMINSETUP_CKSTYLES']                                      = '&quot;Formatting-Styles&quot; of the HTML-Editor saved';

$langFile['LOG_WEBSITESETUP_SAVED']                                       = 'Website-Settings saved';

$langFile['LOG_STATISTICSETUP_SAVED']                                     = 'Statistic-Settings saved';
$langFile['LOG_CLEARSTATISTICS_WEBSITESTATISTIC']                         = 'Website-Statistic deleted';
$langFile['LOG_CLEARSTATISTICS_PAGESTATISTICS']                           = 'Page-Statistics deleted';
$langFile['LOG_CLEARSTATISTICS_PAGESTAYLENGTH']                           = 'Page-Length-Of-Stay-Statistics deleted';
$langFile['LOG_CLEARSTATISTICS_REFERERLOG']                               = 'Referrer-Log deleted';
$langFile['LOG_CLEARSTATISTICS_ACTIVITYLOG']                              = 'Activities-Log deleted';

$langFile['LOG_PAGESETUP_SAVED']                                          = 'Page-Settings saved';
$langFile['LOG_PAGESETUP_CATEGORIES_SAVED']                               = 'Categories saved';

$langFile['LOG_PAGESETUP_CATEGORIES_NEW']                                 = 'New category created';
$langFile['LOG_PAGESETUP_CATEGORIES_DELETED']                             = 'Category deleted';
$langFile['LOG_PAGESETUP_CATEGORIES_MOVED']                               = 'Category moved';

$langFile['LOG_FILE_SAVED']                                               = 'File saved';
$langFile['LOG_FILE_DELETED']                                             = 'File deleted';

$langFile['LOG_BACKUP_CREATED']                                           = 'Backup created';
$langFile['LOG_BACKUP_RESTORED']                                          = 'Backup restored';
$langFile['LOG_BACKUP_DELETED']                                           = 'Backup deleted';

$langFile['LOG_PAGELANGUAGE_DELETED']                                     = 'Deleted language &quot;%s&quot; for page';
$langFile['LOG_PAGELANGUAGE_ADD']                                         = 'Add language &quot;%s&quot; for page';

// PAGE/CATEGORY STATUS
$langFile['STATUS_PAGE_PUBLIC']                                           = 'Page is public';
$langFile['STATUS_PAGE_NONPUBLIC']                                        = 'Page is hidden';

$langFile['STATUS_CATEGORY_PUBLIC']                                       = 'Category is public';
$langFile['STATUS_CATEGORY_NONPUBLIC']                                    = 'Category is hidden';

// USER LIST
$langFile['USER_TEXT_USER']                                               = 'User';
$langFile['USER_TEXT_NOUSER']                                             = 'No users were created.';
$langFile['USER_TEXT_CURRENTUSER']                                        = 'That&#145;s you!';
$langFile['USER_TEXT_USERSONLINE']                                        = 'This user is online::Latest activity';

$langFile['LOGO_TEXT']                                                    = 'Version';
$langFile['txt_logo_gotowebsite']                                         = 'Click here to go to your website.';

// CKEDITOR transport
$langFile['CKEDITOR_TITLE_LINKS']                                         = 'feindura pages';
$langFile['CKEDITOR_TITLE_SNIPPETS']                                      = 'Code snippets';
$langFile['CKEDITOR_TEXT_SNIPPETS']                                       = 'Choose a code snippet to place in the page.';
$langFile['CKEDITOR_BUTTON_EDITSNIPPET']                                  = 'Edit code snippet';
$langFile['CKEDITOR_TITLE_PLUGINS']                                       = 'Plugins';
$langFile['CKEDITOR_BUTTON_EDITPLUGIN']                                   = 'Edit plugin';

$langFile['CKEDITOR_TEXT_PLUGINS']                                        = 'Choose a plugin to place in the page.';

// -> BUTTON TEXTS

// MAIN MENU
$langFile['BUTTON_DASHBOARD']                                             = 'Dashboard';
$langFile['BUTTON_PAGES']                                                 = 'Pages';
$langFile['BUTTON_ADDONS']                                                = 'Add-ons';
$langFile['BUTTON_WEBSITESETTINGS']                                       = 'Website Settings';
$langFile['BUTTON_SEARCH']                                                = 'Search Pages';

// ADMIN MENU
$langFile['HEADER_TITLE_ADMINMENU']                                       = 'Administration';
$langFile['BUTTON_ADMINSETUP']                                            = 'Administrator Settings';
$langFile['BUTTON_PAGESETUP']                                             = 'Pages Settings';
$langFile['BUTTON_STATISTICSETUP']                                        = 'Statistic Settings';
$langFile['BUTTON_USERSETUP']                                             = 'Users';
$langFile['BUTTON_BACKUP']                                                = 'Backups';

// SUB MENU/FOOTER
$langFile['BUTTON_FILEMANAGER']                                           = 'File Manager';
$langFile['BUTTON_TOOLTIP_FILEMANAGER']                                   = 'Manage your files and pictures';
$langFile['BUTTON_CREATEPAGE']                                            = 'New Page';
$langFile['BUTTON_TOOLTIP_CREATEPAGE']                                    = 'Create a new page';
$langFile['BUTTON_DELETEPAGE']                                            = 'Delete Page';
$langFile['BUTTON_TOOLTIP_DELETEPAGE']                                    = 'Delete this page';
$langFile['BUTTON_FRONTENDEDITPAGE']                                      = 'Frontend editing';
$langFile['BUTTON_TOOLTIP_FRONTENDEDITPAGE']                              = 'Edit this page directly in the website';
$langFile['BUTTON_THUMBNAIL_UPLOAD']                                      = 'Upload thumbnail';
$langFile['BUTTON_TOOLTIP_THUMBNAIL_UPLOAD']                              = 'Upload a thumbnail for this page';
$langFile['BUTTON_THUMBNAIL_DELETE']                                      = 'Delete thumbnail';
$langFile['BUTTON_TOOLTIP_THUMBNAIL_DELETE']                              = 'Delete the thumbnail of this page';
$langFile['BUTTON_WEBSITELANGUAGE_ADD']                                   = 'Add Language';
$langFile['BUTTON_TOOLTIP_WEBSITELANGUAGE_ADD']                           = 'Add a new language to this page';
$langFile['BUTTON_WEBSITELANGUAGE_DELETE']                                = 'Delete Language';
$langFile['BUTTON_TOOLTIP_WEBSITELANGUAGE_DELETE']                        = 'Delete language &quot;%s&quot; for this page';
$langFile['BUTTON_SHOWINMENU']                                            = 'Show in menus';
$langFile['BUTTON_HIDEINMENU']                                            = 'Hide from menus';
$langFile['BUTTON_TOOLTIP_SHOWHIDEINMENU']                                = 'Determines whether the page is displayed in menus or not.';

// OTHER BUTTONS
$langFile['BUTTON_UP']                                                    = 'Up';
$langFile['BUTTON_INFO']                                                  = 'Info';
$langFile['BUTTON_EDIT']                                                  = 'Edit';
$langFile['BUTTON_RESET']                                                 = 'Restore';
$langFile['BUTTON_OK']                                                    = 'OK';

// -> GENERAL ERROR TEXTS
$langFile['ERROR_SAVE_SETTINGS']                                          = '<b>The settings could not be saved</b>';
$langFile['ERROR_SAVE_FILE']                                              = '<br><br>Please check the  read- and write permissions of the file: ';

$langFile['ERROR_READ_FOLDER_PART1']                                      = '<br><br>Please check the read permissions of the &quot;';
$langFile['ERROR_SAVE_FOLDER_PART1']                                      = '<br><br>Please check the write permissions of the &quot;';

$langFile['ERROR_FOLDER_PART2']                                           = '&quot; Folder, it&#145;s subfolders and files.';

// -> WARNINGS
$langFile['WARNING_TITLE_STARTPAGE']                                      = 'The start page is not set!';
$langFile['WARNING_TEXT_STARTPAGE']                                       = 'Please set a page as start page.<br>Go to <a href="?site=pages">'.$langFile['BUTTON_PAGES'].'</a> and click on the <span class="icons startpage"></span> icon on the desired page.';

$langFile['WARNING_TITLE_DOCUMENTROOT']                                   = 'Your Document Root couldn&#145;t be resolved automatically!';
$langFile['WARNING_TEXT_DOCUMENTROOT']                                    = 'For <span class="feinduraInline">fein<em>dura</em></span> to function properly, you have to set the  Documentroot manually in the <a href="?site=adminSetup#adminSettings">Administrator Settings</a>.';

$langFile['WARNING_TITLE_BASEPATH']                                       = '<span class="feinduraInline">fein<em>dura</em></span> is not configurated!';
$langFile['WARNING_TEXT_BASEPATH']                                        = 'The <i>base path</i> of the CMS doesn&#145;t match the one in the administrator-settings.<br>
Please go to the <a href                                                  ="?site=adminSetup#adminSettings">administrator-settings</a> and configure your <span class="feinduraInline">fein<em>dura</em></span> CMS.';

$langFile['WARNING_TITLE_JAVASCRIPT']                                     = 'Please activate Javascript';
$langFile['WARNING_TEXT_JAVASCRIPT']                                      = '<strong>To fully use <span class="feinduraInline">fein<em>dura</em></span>, you need to activate  Javascript!</strong>';

$langFile['WARNING_TITLE_UNTITLEDCATEGORIES']                             = 'Missing category names';

$langFile['DASHBOARD_TITLE_IEWARNING']                                    = '<span class="feinduraInline">fein<em>dura</em></span> is not made for older versions of the Internet Explorer';
$langFile['DASHBOARD_TEXT_IEWARNING']                                     = 'To completely use  <span class="feinduraInline">fein<em>dura</em></span> CMS you need at leats Internet Explorer 9.<br><br>Please install a newer version of the Internet Explorer,<br> or install the <a href="http://www.google.com/chromeframe" target="_blank">Google Chrome Frame Plugin</a> for Internet Explorer,<br>or download and install the free <a href="http://www.mozilla.org/firefox/">Firefox</a> or <a href="http://www.google.com/chrome/">Chrome</a> Browser.';

$langFile['GENERAL_TEXT_CURRENTLYEDITED']                                 = 'Page is currently being edited...';

// MESSAGES
$langFile['MESSAGE_TEXT_CHANGEDSTATUS']                                   = 'The status was successfully changed.';
$langFile['MESSAGE_TEXT_CHANGEDSHOWINMENU']                               = 'The menu status was successfully changed.';


/*
* leftSidebar.loader.php
*/

// ---------- QUICKMENU

$langFile['SIDEBARMENU_TITLE_CATEGORIES']                                 = 'Categories';
$langFile['SIDEBARMENU_TITLE_PAGES']                                      = 'Pages of';

/*
* dashboard.php
*/

// ---------- DASHBOARD
$langFile['DASHBOARD_TITLE_USERINFO']                                     = 'User Information';

$langFile['DASHBOARD_TITLE_WELCOME']                                      = 'Welcome in <span class="feinduraInline">fein<em>dura</em></span>,<br>the Content Management System of your website';

$langFile['DASHBOARD_TITLE_STATISTICS']                                   = 'Website-Statistic';

$langFile['DASHBOARD_TITLE_USER']                                         = 'Users';
$langFile['DASHBOARD_TITLE_ACTIVITY']                                     = 'Activities';
$langFile['DASHBOARD_TEXT_ACTIVITY_NONE']                                 = 'none';

$langFile['DASHBOARD_TITLE_STATISTICS_MOSTVISITED']                       = 'most visted pages';
$langFile['DASHBOARD_TITLE_STATISTICS_LASTVISITED']                       = 'last visited pages';
$langFile['DASHBOARD_TITLE_STATISTICS_LASTEDITED']                        = 'last edited pages';
$langFile['DASHBOARD_TITLE_STATISTICS_LONGESTVIEWED']                     = 'longest viewed pages';

$langFile['DASHBOARD_TITLE_REFERER']                                      = 'Visitors came from';

/*
* listPages.php
*/

// ---------- PAGES SORTABLE LIST
$langFile['SORTABLEPAGELIST_h1']                                          = 'The content of your website';
$langFile['SORTABLEPAGELIST_headText1']                                   = 'Filter';
$langFile['SORTABLEPAGELIST_headText3']                                   = 'Visitors';
$langFile['SORTABLEPAGELIST_headText4']                                   = 'Status';
$langFile['SORTABLEPAGELIST_headText5']                                   = 'Functions';

$langFile['SORTABLEPAGELIST_TIP_PAGEDATE']                                = 'Page date';
$langFile['SORTABLEPAGELIST_TIP_LASTEDIT']                                = 'Last edited';
$langFile['SORTABLEPAGELIST_TIP_TAGS']                                    = 'Tags';
$langFile['SORTABLEPAGELIST_TIP_LOCALIZATION']                            = 'Languages';

$langFile['SORTABLEPAGELIST_TIP_SORTALPHABETICAL']                        = 'alphabetical sorted';
$langFile['SORTABLEPAGELIST_TIP_SORTBYPAGEDATE']                          = 'sort by page date';

$langFile['SORTABLEPAGELIST_functions_editPage']                          = 'Edit page';

$langFile['SORTABLEPAGELIST_TIP_CHANGESTATUS']                            = 'Click here to change the status.';

$langFile['SORTABLEPAGELIST_TOOLTIP_LANGUAGEMISSING']                     = 'Missing languages';

$langFile['file_error_read']                                              = '<b>Could not read the page.</b>'.$langFile['ERROR_READ_FOLDER_PART1'].'%spages/'.$langFile['ERROR_FOLDER_PART2'];
$langFile['SORTABLEPAGELIST_setStartPage_error_save']                     .= $langFile['ERROR_SAVE_FILE'].' &quot;%sconfig/website.config.php&quot;'; // also in en.shared.php
$langFile['SORTABLEPAGELIST_changeStatusPage_error_save']                 = '<b>Could not change the status of the page.</b>'.$langFile['ERROR_SAVE_FOLDER_PART1'].'%spages/'.$langFile['ERROR_FOLDER_PART2'];
$langFile['SORTABLEPAGELIST_changeStatusCategory_error_save']             = '<b>Could not change the status of the category.</b>'.$langFile['ERROR_SAVE_FOLDER_PART1'].'%spages/'.$langFile['ERROR_FOLDER_PART2'];

$langFile['SORTABLEPAGELIST_info']                                        = 'You can change the <b>arrangement</b> of the pages and move pages between categories by <b>Drag and Drop</b>.';
$langFile['SORTABLEPAGELIST_save']                                        = 'Save new sorting ...';
$langFile['SORTABLEPAGELIST_save_finished']                               = 'Successfully saved new sorting!';
$langFile['SORTABLEPAGELIST_error_save']                                  = '<b>Could not save the page.</b>'.$langFile['ERROR_SAVE_FOLDER_PART1'].'%spages/'.$langFile['ERROR_FOLDER_PART2'];
$langFile['SORTABLEPAGELIST_error_read']                                  = '<b>The pages could not be read.</b>'.$langFile['ERROR_READ_FOLDER_PART1'].'%spages/'.$langFile['ERROR_FOLDER_PART2'];
$langFile['SORTABLEPAGELIST_error_move']                                  = '<b>Could not move the page into the new category.</b>'.$langFile['ERROR_SAVE_FOLDER_PART1'].'%spages/'.$langFile['ERROR_FOLDER_PART2'];
$langFile['SORTABLEPAGELIST_categoryEmpty']                               = 'No pages available';
$langFile['SORTABLEPAGELIST_TIP_DRATOREARRANGE']                          = 'Drag to rearrange.';

$langFile['SORTABLEPAGELIST_TIP_SUBCATEGORYOFPAGES_SINGULAR']             = 'Subcategory of the page:';
$langFile['SORTABLEPAGELIST_TIP_SUBCATEGORYOFPAGES_PLURAL']               = 'Subcategory of the pages:';


// ---------- FORMULAR
$langFile['FORM_BUTTON_SUBMIT']                                           = 'Save';
$langFile['FORM_BUTTON_CANCEL']                                           = 'Reset all input';


/*
* adminSetup.php
*/

// ---------- ADMIN SETUP (on toolTips tooTips.js converts the "[" and "]" tags in the title attribute to "<" ">")
$langFile['ADMINSETUP_TEXT_VERSION']                                      = '<span class="feinduraInline">fein<em>dura</em></span> version';
$langFile['ADMINSETUP_TEXT_PHPVERSION']                                   = 'PHP version';
$langFile['ADMINSETUP_TITLE_DOCUMENTROOT']                                = ' Document Root';

$langFile['ADMINSETUP_TITLE_ERROR']                                       = 'Errors occured';
$langFile['ADMINSETUP_TOOLTIP_WRITEACCESSERROR']                          = 'For files and directories have need to set the permissions to %o.';

$langFile['ADMINSETUP_TEXT_WRITEACCESSERROR']                             = 'is not writeable';
$langFile['ADMINSETUP_TEXT_ISFOLDERERROR']                                = 'is not a directory';

// ---------- general Settings
$langFile['ADMINSETUP_GENERAL_error_save']                                = $langFile['ERROR_SAVE_SETTINGS'].$langFile['ERROR_SAVE_FILE'].'%sconfig/admin.config.php';

$langFile['ADMINSETUP_GENERAL_h1']                                        = 'Basic-Settings';

$langFile['ADMINSETUP_GENERAL_TEXT_DOCUMENTROOT']                         = 'Documentroot';
$langFile['ADMINSETUP_GENERAL_TOOLTIP_DOCUMENTROOT']                      = 'Please type in the document root manually.[br][span class=hint]e.g. &quot;/server/user/htdocs&quot;[/span]';
$langFile['ADMINSETUP_GENERAL_field1']                                    = 'Website URL';
$langFile['ADMINSETUP_GENERAL_field1_tip']                                = 'The URL of your website will be added automatically.';
$langFile['ADMINSETUP_GENERAL_field1_inputTip']                           = 'The URL will be added automatically';
$langFile['ADMINSETUP_GENERAL_field1_inputWarningText']                   = 'Please save the settings!';
$langFile['ADMINSETUP_GENERAL_field2']                                    = 'feindura path';
$langFile['ADMINSETUP_GENERAL_field2_tip']                                = 'The base path will be determined automatically and saved, the first time the settings are saved.';
$langFile['ADMINSETUP_GENERAL_field2_inputTip']                           = 'The path will be added automatically';
$langFile['ADMINSETUP_GENERAL_field2_inputWarningText']                   = 'Please save the settings!';
$langFile['ADMINSETUP_GENERAL_field8']                                    = 'Website path';
$langFile['ADMINSETUP_GENERAL_field8_tip']                                = 'The [strong]absolute path[/strong] where the website is situated.[br][br][span class=hint]Can also contain filenames e.g &quot;/website/index.php&quot;[/span]';
$langFile['ADMINSETUP_GENERAL_editfiles_additonal']                       = '[br][br]This files can be edited further down, or in the website-settings (if it&#145;s activated in the user-settings).[br][br]';
$langFile['ADMINSETUP_GENERAL_field5']                                    = 'Path for website files';
$langFile['ADMINSETUP_GENERAL_field5_tip']                                = 'Here you can add a path to website-specific files, which should be editable in [span class=feinduraInline]fein[em]dura[/em][/span].'.$langFile['ADMINSETUP_GENERAL_editfiles_additonal'];
$langFile['ADMINSETUP_GENERAL_field6']                                    = 'Path for stylesheets';
$langFile['ADMINSETUP_GENERAL_field6_tip']                                = 'Here you can add a path to stylesheet files, which should be editable in [span class=feinduraInline]fein[em]dura[/em][/span].'.$langFile['ADMINSETUP_GENERAL_editfiles_additonal'];
$langFile['ADMINSETUP_GENERAL_TEXT_PERMISSIONS']                          = 'Permissions for files and folders';
$langFile['ADMINSETUP_GENERAL_TIP_PERMISSIONS']                           = 'Every file or folder created by [span class=feinduraInline]fein[em]dura[/em][/span] will get these permissions.';
$langFile['ADMINSETUP_TEXT_VARNAMEPAGE']                                  = 'Page URL name';
$langFile['ADMINSETUP_TEXT_VARNAMECATEGORY']                              = 'Category URL name';
$langFile['ADMINSETUP_TEXT_VARNAMEMODUL']                                 = 'Modul URL name';
$langFile['ADMINSETUP_TIP_VARNAME']                                       = 'The name which will be used in the URL to link the pages.';
$langFile['ADMINSETUP_TIP_EMPTYVARNAME']                                  = 'If the field is empty the standard name will be used: ';
$langFile['ADMINSETUP_TEXT_TIMEZONE']                                     = 'Time zone';
$langFile['ADMINSETUP_TIP_TIMEZONE']                                      = 'Will only be used by the [span class=feinduraInline]fein[em]dura[/em][/span] Backend.';
$langFile['ADMINSETUP_GENERAL_PRETTYURL']                               = 'URL format';
$langFile['ADMINSETUP_GENERAL_PRETTYURL_true']                          = 'Pretty URLs';
$langFile['ADMINSETUP_GENERAL_PRETTYURL_true_example']                  = '/%s/example-category/example-page';
$langFile['ADMINSETUP_GENERAL_PRETTYURL_false']                         = 'URLs with variables';
$langFile['ADMINSETUP_GENERAL_PRETTYURL_false_example']                 = 'index.php?%s=1&%s=1';
$langFile['ADMINSETUP_GENERAL_PRETTYURL_tip']                           = 'The URL format, which will be used to link the pages.[br][br]Pretty URLs work only if the [strong]Apache Server[/strong] [strong]mod_rewrite[/strong] module is available.';
$langFile['ADMINSETUP_GENERAL_PRETTYURL_warning']                       = 'WARNING!::[span class=red]If an error occours while using Pretty URLs, you have to delete the [strong].htaccess file[/strong] in the document root path of your webserver.[/span][br][br](In some FTP programs you have to show hidden files first, to see the .htaccess file)';

// ---------- Pretty url ERRORs
$langFile['ADMINSETUP_GENERAL_PRETTYURL_error_save']                    = '<b>Pretty URLs</b> could not be activated'.$langFile['ERROR_SAVE_FILE'].'/.htaccess';
$langFile['ADMINSETUP_GENERAL_PRETTYURL_error_modul']                   = '<b>Pretty URLs</b> could not be activated, because the Apache module MOD_REWRITE modul could not be found';

// ---------- cache settings
$langFile['ADMINSETUP_TEXT_CACHE']                                        = 'Activate cache';
$langFile['ADMINSETUP_TIP_CACHE']                                         = 'If active, all pages will be cached. This can seed up the website, but also leads to not so actual content.[br][br][span class=hint]The cached will be refreshed, when saving pages.[/span]';
$langFile['ADMINSETUP_TEXT_CACHETIMEOUT']                                 = 'Cache timeout';
$langFile['ADMINSETUP_TIP_CACHETIMEOUT']                                  = 'Indicates the time after which the cache will be refreshed.';
$langFile['ADMINSETUP_HINT_CACHETIMEOUT']                                 = 'hours';

// ---------- editor Settings
$langFile['adminSetup_editorSettings_h1']                                 = 'HTML-Editor-Settings';
$langFile['ADMINSETUP_TEXT_EDITOR_HTMLLAWED']                             = 'Filter HTML (uses <a href="http://www.bioinformatics.org/phplabware/internal_utilities/htmLawed/" target="_blank">htmlLawed</a>)';
$langFile['ADMINSETUP_TIP_EDITOR_HTMLLAWED']                              = 'Filters the HTML code before saving. This can cause problems in HTML code with a lot of Javascript.';
$langFile['ADMINSETUP_TEXT_EDITOR_SAFEHTML']                              = 'Safe HTML (<a href="http://www.bioinformatics.org/phplabware/internal_utilities/htmLawed/htmLawed_README.htm#s3.6" target="_blank">details</a>)';
$langFile['ADMINSETUP_TIP_EDITOR_SAFEHTML']                               = 'The HTML-Code will be filtered with the safest settings. That means that for example &lt;applet&gt;,&lt;embed&gt;,&lt;embed&gt;,&lt;object &gt; and &lt;script&gt; tags are not allowed.';
$langFile['ADMINSETUP_TEXT_EDITOR_EDITORSTYLES']                          = 'activate Style-Selection';
$langFile['ADMINSETUP_TIP_EDITOR_EDITORSTYLES']                           = 'The Styles-Selection allows you to use custom HTML-Elements in the HTML-Editor.[br][br][span class=hint]If this option is activated, you can edit/create HTML-Elements further down.[/span]';
$langFile['ADMINSETUP_TEXT_EDITOR_SNIPPETS']                              = 'activate code snippets';
$langFile['ADMINSETUP_TIP_EDITOR_SNIPPETS']                               = 'Makes it possible to place code snippets in the pages.[br]Click on the icon in the HTML-Editor: [img class=icons src=library/thirdparty/ckeditor/plugins/feinduraSnippets/feinduraSnippetsIcon.png][br][br][span class=hint]If this option is activated, you can edit/create code snippets further down.[/span]';
$langFile['adminSetup_editorSettings_field1']                             = 'ENTER-Key mode';
$langFile['adminSetup_editorSettings_field1_hint']                        = 'SHIFT + ENTER generates a &quot;%s&quot;';
$langFile['adminSetup_editorSettings_field1_tip']                         = 'Sets which HTML-Tag will be add when pressing the ENTER-Key in the HTML-Editor.[br][br][span class=hint]'.$langFile['adminSetup_editorSettings_field1_hint'].'.[/span]';
$langFile['adminSetup_editorSettings_field3_inputTip']                    = 'If empty no Id-attribute will be used.';
$langFile['adminSetup_editorSettings_field4_inputTip']                    = 'If empty no Class-attribute will be used.';

// THUMBNAILS Settings
$langFile['adminSetup_thumbnailSettings_h1']                              = 'Page-Thumbnail-Settings';

// ---------- styleFile Settings
$langFile['adminSetup_styleFileSettings_h1']                              = 'Edit the Styles-Selection of the HTML-Editor';
$langFile['adminSetup_styleFileSettings_error_save']                      = '<b>The &quot;EditorStyles.js&quot; file could no be saved.</b>'.$langFile['ERROR_SAVE_FILE'];

// ---------- editFiles Settings
$langFile['EDITFILESSETTINGS_TITLE_STYLESHEETS']                          = 'Edit stylesheet files';
$langFile['EDITFILESSETTINGS_TITLE_WEBSITEFILES']                         = 'Edit website files';
$langFile['EDITFILESSETTINGS_TITLE_SNIPPETS']                             = 'Edit code snippets';
$langFile['EDITFILESSETTINGS_TEXT_NODIR']                                 = 'is not a valid directory!';
$langFile['EDITFILESSETTINGS_TEXT_CHOOSEFILE']                            = 'Choose a file';
$langFile['EDITFILESSETTINGS_TEXT_CREATEFILE']                            = 'Create a new file';
$langFile['EDITFILESSETTINGS_TIP_CREATEFILE']                             = 'If you type a filename in here, a new file created and [strong]the currently selected file will not be saved![/strong]';
$langFile['EDITFILESSETTINGS_TEXT_NOFILE']                                = 'No files available';

$langFile['EDITFILESSETTINGS_TEXT_DELETEFILE']                            = 'Delete this file';
$langFile['EDITFILESSETTINGS_TEXT_DELETEFILE_QUESTION']                   = 'You really want to delete the file %s?';

$langFile['EDITFILESSETTINGS_ERROR_SAVEFILE']                             = '<b>The file could not be saved.</b>'.$langFile['ERROR_SAVE_FILE'];
$langFile['EDITFILESSETTINGS_ERROR_DELETEFILE']                           = '<b>Could not delete the file.</b>'.$langFile['ERROR_SAVE_FILE'];

/*
* pageSetup.php
*/

// ---------- CATEGORY SETUP (on toolTips tooTips.js converts the "[" and "]" tags in the title attribute to "<" ">")
$langFile['PAGESETUP_PAGES_TIP_TAG']                                      = 'Tags can be used to create connections between pages (depending on the programming of the website)';

// ---------- page settings
$langFile['PAGESETUP_PAGES_TITLE_NONCATEGORYPAGES']                       = 'Pages without category';
$langFile['PAGESETUP_PAGES_TEXT_CREATEPAGES']                             = 'Create/delete pages';
$langFile['PAGESETUP_PAGES_TIP_CREATEPAGES']                              = 'Specifies if the user can create and delete pages without category.';
$langFile['PAGESETUP_PAGES_TEXT_UPLOADTHUMBNAILS']                        = 'Upload thumbnails';
$langFile['PAGESETUP_PAGES_TIP_UPLOADTHUMBNAILS']                         = 'Specifies if the user can upload thumbnails for pages without category.';
$langFile['PAGESETUP_PAGES_TEXT_EDITTAGS']                                = 'Edit tags';
$langFile['PAGESETUP_PAGES_TIP_EDITTAGS']                                 = 'Specifies if the user can edit tags in pages without category.[br]'.$langFile['PAGESETUP_PAGES_TIP_TAG'];
$langFile['PAGESETUP_PAGES_TEXT_ACTIVATEPLUGINS']                         = 'Activate plugins';
$langFile['PAGESETUP_PAGES_TIP_ACTIVATEPLUGINS']                          = 'Specifies if the user can use plugins in pages without category.';

// ---------- category settings
$langFile['PAGESETUP_CATEGORY_TITLE_CATEGORIES']                          = 'Manage categories';
$langFile['PAGESETUP_CATEGORY_TEXT_CATEGORYNAME']                         = 'Name';

$langFile['PAGESETUP_CATEGORY_TEXT_CREATECATEGORY']                       = 'Create new category';
$langFile['PAGESETUP_CATEGORY_TEXT_CREATECATEGORY_CREATED']               = 'New category created';
$langFile['PAGESETUP_CATEGORY_TEXT_CREATECATEGORY_UNNAMED']               = 'Untitled category';

$langFile['PAGESETUP_CATEGORY_TEXT_DELETECATEGORY']                       = 'Delete category';
$langFile['PAGESETUP_CATEGORY_TEXT_DELETECATEGORY_WARNING']               = 'WARNING: It will also delete all pages in this category!';
$langFile['PAGESETUP_CATEGORY_TEXT_DELETECATEGORY_DELETED']               = 'Category deleted';
$langFile['PAGESETUP_CATEGORY_TEXT_DELETECATEGORY_QUESTION_START']        = 'Delete category'; // Kategorie "test" löschen?
$langFile['PAGESETUP_CATEGORY_TEXT_DELETECATEGORY_QUESTION_END']          = '?';

$langFile['PAGESETUP_CATEGORY_TEXT_MOVECATEGORY_MOVED']                   = 'Category moved';
$langFile['PAGESETUP_CATEGORY_TIP_MOVECATEGORY_UP']                       = 'Move category upwards';
$langFile['PAGESETUP_CATEGORY_TIP_MOVECATEGORY_DOWN']                     = 'Move category downwards';

$langFile['PAGESETUP_CATEGORY_ERROR_CREATECATEGORY']                      = '<b>Could not create new category.</b>'.$langFile['ERROR_SAVE_FOLDER_PART1'].'%sconfig/'.$langFile['ERROR_FOLDER_PART2'];
$langFile['PAGESETUP_CATEGORY_ERROR_CREATEDIR']                           = '<b>Could not the directory for the new category.</b>'.$langFile['ERROR_SAVE_FOLDER_PART1'].'%spages/'.'&quot; Ordners.';
$langFile['PAGESETUP_CATEGORY_ERROR_DELETECATEGORY']                      = '<b>Could not delete the category</b>'.$langFile['ERROR_SAVE_FILE'].'%sconfig/category.config.php';
$langFile['PAGESETUP_CATEGORY_ERROR_DELETEDIR']                           = '<b>Could not delete the directory of the category.</b>'.$langFile['ERROR_SAVE_FOLDER_PART1'].'%spages/'.$langFile['ERROR_FOLDER_PART2'];
$langFile['PAGESETUP_CATEGORY_ERROR_SAVE']                                = $langFile['ERROR_SAVE_SETTINGS'].$langFile['ERROR_SAVE_FILE'].'%sconfig/category.config.php';


$langFile['PAGESETUP_CATEGORY_TITLE_ADVANCEDSETTINGS']                    = 'Advanced Settings';
$langFile['PAGESETUP_CATEGORY_HINT_ADVANCEDSETTINGS']                     = 'If this settings are set, they overwrite the thumbnail-settings above and the '.$langFile['adminSetup_editorSettings_h1'].' in the <a href="?site=adminSetup">administrator-settings</a>.';

$langFile['PAGESETUP_CATEGORY_TIP_STYLESHEETS_EMPTY']                     = 'If all fields are empty, then the stylesheet settings from the '.$langFile['adminSetup_editorSettings_h1'].' will be used.';

$langFile['PAGESETUP_CATEGORY_TEXT_CATEGORYSTATUS']                       = 'Status of the category';
$langFile['PAGESETUP_CATEGORY_TIP_CATEGORYSTATUS']                        = 'Specifies if the category is visible on the website.';
$langFile['PAGESETUP_CATEGORY_TEXT_CREATEPAGES']                          = 'Create/delete pages';
$langFile['PAGESETUP_CATEGORY_TIP_CREATEPAGES']                           = 'Specifies if the user can create and delete pages in this category.';
$langFile['PAGESETUP_CATEGORY_TEXT_UPLOADTHUMBNAILS']                     = 'Upload Thumbnails';
$langFile['PAGESETUP_CATEGORY_TIP_UPLOADTHUMBNAILS']                      = 'Specifies if the user can upload thumbnails for pages in this category.';
$langFile['PAGESETUP_CATEGORY_TEXT_EDITTAGS']                             = 'Edit tags';
$langFile['PAGESETUP_CATEGORY_TIP_EDITTAGS']                              = 'Specifies if the user can edit tags in pages in this category.[br]'.$langFile['PAGESETUP_PAGES_TIP_TAG'];
$langFile['PAGESETUP_CATEGORY_TEXT_ACTIVATEPLUGINS']                      = 'Activate plugins';
$langFile['PAGESETUP_CATEGORY_TIP_ACTIVATEPLUGINS']                       = 'Specifies if the user can use plugins in pages in this category.';

$langFile['PAGESETUP_TEXT_EDITPAGEDATE']                                  = 'Edit page date';
$langFile['PAGESETUP_TIP_EDITPAGEDATE']                                   = 'The page date can be used to sort pages by date';
$langFile['PAGESETUP_TEXT_PAGEDATERANGE']                                 = 'as date range';

$langFile['PAGESETUP_TEXT_FEEDS']                                         = 'Activate feeds';
$langFile['PAGESETUP_TIP_FEEDS']                                          = 'Activate RSS 2.0 and Atom Feed for the pages without category.';
$langFile['PAGESETUP_CATEGORY_TIP_FEEDS']                                 = 'Activate RSS 2.0 and Atom Feed for the pages in this category.';

$langFile['PAGESETUP_TEXT_SUBCATEGORY']                                   = 'Edit subcategories';
$langFile['PAGESETUP_TIP_SUBCATEGORY']                                    = 'Allows to choose a subcategory for each page.';

$langFile['PAGESETUP_TIP_SORTBYPAGEDATE']                                 = 'Sort pages by page date';
$langFile['PAGESETUP_TIP_SORTBYDATE']                                     = 'Pages with a younger date appear at the [strong]top[/strong].[br][br][span class=hint]Deactivates manually sorting.[/span]';

$langFile['PAGESETUP_TEXT_SORTMANUALLY']                                  = 'Sort pages manually';
$langFile['PAGESETUP_TIP_SORTMANUALLY']                                   = 'Newly created pages appear at the [strong]top[/strong].';

$langFile['PAGESETUP_TEXT_SORTALPHABETICAL']                              = 'Sort pages alphabetical';
$langFile['PAGESETUP_TIP_SORTALPHABETICAL']                               = '[span class=hint]Deactivates manually sorting.[/span]';

$langFile['PAGESETUP_TEXT_SORTREVERSE']                                   = 'reverse sort order';
$langFile['PAGESETUP_TIP_SORTREVERSE']                                    = 'Reverse the sort order of the pages.';


/*
* websiteSetup.php
*/

// ---------- WEBSITE SETUP (on toolTips tooTips.js converts the "[" and "]" tags in the tittle attribute to "<" ">")
$langFile['websiteSetup_websiteConfig_error_save']                        = $langFile['ERROR_SAVE_SETTINGS'].$langFile['ERROR_SAVE_FILE'].'%sconfig/website.config.php';

$langFile['websiteSetup_websiteConfig_h1']                                = 'Website-Settings';
$langFile['websiteSetup_websiteConfig_field1']                            = 'Website title';
$langFile['websiteSetup_websiteConfig_field1_tip']                        = 'The title of the website will be shown in the browser bar.';
$langFile['websiteSetup_websiteConfig_field2']                            = 'Publisher';
$langFile['websiteSetup_websiteConfig_field2_tip']                        = 'The name of the organisation/company/person, which publish the website.';
$langFile['websiteSetup_websiteConfig_field3']                            = 'Copyright';
$langFile['websiteSetup_websiteConfig_field3_tip']                        = 'The copyright holder of the website.';
$langFile['websiteSetup_websiteConfig_field4']                            = 'Search engine keywords';
$langFile['websiteSetup_websiteConfig_field4_tip']                        = 'The most search engines search the website content for keywords, however you should list some keywords here, which will be stored in the <meta> tags of the page.';
$langFile['websiteSetup_websiteConfig_field4_inputTip']                   = 'The keywords must be separated with &quot;,&quot;::'.$langFile['TEXT_EXAMPLE'].':[br]stichwort1,stichwort2,etc';
$langFile['websiteSetup_websiteConfig_field5']                            = 'Website description';
$langFile['websiteSetup_websiteConfig_field5_tip']                        = 'A short description which will search engines use, if the searchwords were found in the website URL and not in the content.';
$langFile['websiteSetup_websiteConfig_field5_inputTip']                   = 'A short text with not more than 3 lines.';

$langFile['WEBSITESETUP_TITLE_PAGESETTINGS']                              = 'Advanced Website-Settings';
$langFile['WEBSITESETUP_TEXT_MAINTENANCE']                                = 'Deactivate Website';
$langFile['WEBSITESETUP_TIP_MAINTENANCE']                                 = 'Shows a message instead of the website, which says that the website is currently being edited.';
$langFile['WEBSITESETUP_TEXT_SITEMAPFILES']                               = 'Create Sitemap-Files (<a href="http://www.sitemaps.org/" target="_blank">Details</a>)';
$langFile['WEBSITESETUP_TIP_SITEMAPFILES']                                = 'The sitemap files simplify search engines to index this site.';
$langFile['WEBSITESETUP_TEXT_VISITORTIMEZONE']                            = 'Get Visitors Timezone';
$langFile['WEBSITESETUP_TIP_VISITORTIMEZONE']                             = 'Try to get the timezone of the visitor, to display time disclosures in the local time of the visitor.[br][br][span class=hint]The website will be reloaded on the first visit.[/br]';
$langFile['WEBSITESETUP_TEXT_MULTILANGUAGEWEBSITE']                       = 'Multi language Website';
$langFile['WEBSITESETUP_TEXT_MAINLANGUAGE']                               = 'Main language';
$langFile['WEBSITESETUP_TIP_MAINLANGUAGE']                                = 'The main language will be selected, if no matching language could be determined automatically.';
$langFile['WEBSITESETUP_TEXT_DATEFORMAT']                                 = 'Date format';
$langFile['WEBSITESETUP_TIP_DATEFORMAT']                                  = 'Will be used in the Website.';


/*
* statisticSetup.php
*/

// ---------- STATISITC SETUP (on toolTips tooTips.js converts the "[" and "]" tags in the tittle attribute to "<" ">")
$langFile['STATISTICSSETUP_ERROR_SAVE']                                   = $langFile['ERROR_SAVE_SETTINGS'].$langFile['ERROR_SAVE_FILE'].'%sconfig/statistic.config.php';

$langFile['STATISTICSSETUP_TITLE_STATISTICSSETTINGS']                     = 'Statistic-Settings';
$langFile['STATISTICSSETUP_TEXT_REFERERNUMBER']                           = 'Number of <b>Referrer-URLs</b>';
$langFile['STATISTICSSETUP_TIP_REFERERNUMBER']                            = 'Specifies how much Referrer-URLs ([i]URLs which lead to the website[/i]) will be saved and displayed.';
$langFile['STATISTICSSETUP_TEXT_ACTIVITYNUMBER']                          = 'Number of <b>Activities-Log</b>';
$langFile['STATISTICSSETUP_TIP_ACTIVITYNUMBER']                           = 'Specifies how much Activities-Log will be saved and displayed.';


$langFile['statisticSetup_clearStatistic_h1']                             = 'Delete statistics';
$langFile['statisticSetup_clearStatistics_websiteStatistic']              = 'Website-Statistic';
$langFile['statisticSetup_clearStatistics_websiteStatistic_tip']          = '[strong]Contains[/strong][ul][li]Total number of visits[/li][li]Total number of web-crawlers[/li][li]Date of the first visit[/li][li]Date of the last visit[/li][li]Browser spectrum[/li][/ul]';
$langFile['statisticSetup_clearStatistics_pagesStatistic']                = 'Page-Statistics';
$langFile['statisticSetup_clearStatistics_pagesStatistic_tip']            = '[strong]Contains[/strong][ul][li]Number of page visits[/li][li]Date of the first page visit[/li][li]Date of the last page visit[/li][li]shortest length of stay[/li][li]longest length of stay[/li][li]Keywords which led to this site[/li][/ul]';
$langFile['statisticSetup_clearStatistics_pagesStaylengthStatistics']     = 'only the Page-Length-Of-Stay-Statistics';
$langFile['statisticSetup_clearStatistics_pagesStaylengthStatistics_tip'] = '';
$langFile['statisticSetup_clearStatistics_refererLog']                    = 'Referrer-URLs Log'; // engl.: referer
$langFile['statisticSetup_clearStatistics_refererLog_tip']                = 'A list of all URLs which led top this website.';
$langFile['statisticSetup_clearStatistics_taskLog']                       = 'Activities-Log';
$langFile['statisticSetup_clearStatistics_taskLog_tip']                   = 'A list of the activities.';

$langFile['statisticSetup_clearStatistics_question_h1']                   = 'Are you sure you want to delete these statistics?';

$langFile['statisticSetup_clearStatistic_pagesStatistics_error_read']     = 'Error while deleting the page statistics.'.$langFile['ERROR_SAVE_FOLDER_PART1'].'%sstatistics/pages/'.$langFile['ERROR_FOLDER_PART2'];

/*
* userSetup.php
*/

$langFile['USERSETUP_h1']                                                 = 'User-Management';
$langFile['USERSETUP_userSelection']                                      = 'Users';

$langFile['USERSETUP_createUser']                                         = 'Create new user';
$langFile['USERSETUP_createUser_created']                                 = 'New user created';
$langFile['USERSETUP_createUser_unnamed']                                 = 'Unnamed user';

$langFile['USERSETUP_deleteUser']                                         = 'Delete user';
$langFile['USERSETUP_deleteUser_deleted']                                 = 'User deleted';

$langFile['USERSETUP_username']                                           = 'Username';
$langFile['USERSETUP_username_missing']                                   = 'There is no username set yet.';
$langFile['USERSETUP_password']                                           = 'Password';
$langFile['USERSETUP_password_change']                                    = 'change password';
$langFile['USERSETUP_password_confirm']                                   = 'Password confirmation';
$langFile['USERSETUP_password_confirm_wrong']                             = 'The two passwords do not match.';
$langFile['USERSETUP_password_missing']                                   = 'There is no password set yet.';
$langFile['USERSETUP_password_success']                                   = 'Password successfully changed!';
$langFile['USERSETUP_email']                                              = 'E-Mail';
$langFile['USERSETUP_email_tip']                                          = 'If the user has forgotten his password, a new password will be sent to this e-mail.';

$langFile['USERSETUP_admin']                                              = 'Administrator';
$langFile['USERSETUP_admin_tip']                                          = 'Determines whether the user has administrator rights.';

$langFile['USERSETUP_error_create']                                       = '<b> A new user could not be created.</b>'.$langFile['ERROR_SAVE_FILE'].'%sconfig/user.config.php';
$langFile['USERSETUP_error_save']                                         = $langFile['ERROR_SAVE_SETTINGS'].$langFile['ERROR_SAVE_FILE'].'%sconfig/user.config.php';

// ---------- USER PERMISSION
$langFile['USERSETUP_USERPERMISSIONS_TITLE']                              = 'User permissions';
$langFile['USERSETUP_USERPERMISSIONS_TEXT_ACTIVATEWEBSITESETTINGS']       = 'Edit Website-Settings';
$langFile['USERSETUP_USERPERMISSIONS_TEXT_EDITWEBSITEFILES']              = 'Edit website files in the <a href="index.php?site=websiteSetup">Website-Settings</a>';
$langFile['USERSETUP_USERPERMISSIONS_TEXT_EDITSTYLESHEETS']               = 'Edit stylesheet files in the <a href="index.php?site=websiteSetup">Website-Settings</a>';
$langFile['USERSETUP_USERPERMISSIONS_TEXT_EDITSNIPPETS']                  = 'Edit code snippets in the <a href="index.php?site=websiteSetup">Website-Settings</a>';
$langFile['USERSETUP_USERPERMISSIONS_TEXT_FILEMANAGER']                   = 'Activate file manager';
$langFile['USERSETUP_USERPERMISSIONS_TEXT_FRONTENDEDITING']               = 'Activate frontend editing';

$langFile['USERSETUP_USERPERMISSIONS_TEXT_USERINFORMATION']               = '<strong>User information</strong> in the <a href="?site=dashboard">'.$langFile['BUTTON_DASHBOARD'].'</a>';
$langFile['USERSETUP_USERPERMISSIONS_TIP_USERINFORMATION']                = 'User Information::This text will be shown in the '.$langFile['BUTTON_DASHBOARD'].' page of [span class=feinduraInline]fein[em]dura[/em][/span].';
$langFile['USERSETUP_USERPERMISSIONS_TIP_USERINFORMATION_NOINFO']         = 'If you don&#145;t want to display an information for the user, leave this field empty';

$langFile['USERSETUP_USERPERMISSIONS_TITLE_EDITABLECATEGORIES-PAGES']     = 'Select Categories and Pages which the user should be able to edit<br>(If nothing is selected, everything can be edited)';
$langFile['USERSETUP_USERPERMISSIONS_TEXT_CLEARSELECTION']                = 'Clear selection';

/*
* editor.php
*/

// ---------- page info
$langFile['EDITOR_TITLE_CREATEPAGE']                                      = 'Create new page';
$langFile['EDITOR_TITLE_ADDLANGUAGE']                                     = 'Add language &quot;%s&quot; to the page';
$langFile['EDITOR_pageinfo_lastsavedate']                                 = 'last edit on';
$langFile['EDITOR_pageinfo_lastsaveauthor']                               = 'by';
$langFile['EDITOR_pageinfo_linktothispage']                               = 'Link to this page';
$langFile['EDITOR_pageinfo_id']                                           = 'Page ID';
$langFile['EDITOR_pageinfo_id_tip']                                       = 'The page will be saved under this ID on the server.';
$langFile['EDITOR_pageinfo_category']                                     = 'Category';
$langFile['EDITOR_pageinfo_category_noCategory']                          = 'no category';

$langFile['EDITOR_TEXT_CHOOSETEMPLATE']                                   = 'Use template';
$langFile['EDITOR_TEXT_TEMPALATECOPYADDITION']                            = 'copy';

$langFile['EDITOR_block_edited']                                          = 'were edited';
$langFile['EDITOR_pageNotSaved']                                          = 'not saved';

$langFile['EDITOR_EDITLINK']                                              = 'Edit link';

// ---------- page settings
$langFile['EDITOR_pagestatistics_h1']                                     = 'Statistic';

$langFile['EDITOR_pageSettings_title']                                    = 'Title';
$langFile['EDITOR_pageSettings_title_tip']                                = 'The title of the page, can contain the following HTML tags:[br]<a> <span> <em> <strong> <i> <b> <abbr> <code> <samp> <kbd> <var>';
$langFile['EDITOR_pageSettings_field1']                                   = 'Short description';
$langFile['EDITOR_pageSettings_field1_inputTip']                          = 'If empty it uses the description of the website from the Website-Settings.';
$langFile['EDITOR_pageSettings_field1_tip']                               = 'A short summary of the page content. This description will be used in the META-Tags of the page.[br][br][span class=hint]'.$langFile['EDITOR_pageSettings_field1_inputTip'].'[/span]';
$langFile['EDITOR_pageSettings_field2']                                   = 'Tags';
$langFile['EDITOR_pageSettings_field2_tip']                               = 'Tags are keywords for this page.';
$langFile['EDITOR_pageSettings_field2_tip_inputTip']                      = 'The Tags must be separated by &quot;,&quot; (comma).';
$langFile['EDITOR_pageSettings_field3']                                   = 'Pagedate';
$langFile['EDITOR_pageSettings_field3_tip']                               = 'The date can be used to sort pages by date. (e.g. on Events)';
$langFile['EDITOR_pageSettings_field4']                                   = 'Status of the page';
$langFile['EDITOR_pageSettings_field4_tip']                               = '[strong]Only if the page is public, it will be shown in the website![/strong]';

$langFile['EDITOR_PAGESETTINGS_NOPAGEDATE']                               = 'No date';

$langFile['EDITOR_TEXT_SUBCATEGORY']                                      = 'Subcategory';
$langFile['EDITOR_TIP_SUBCATEGORY']                                       = 'Allows to create a sub menu for this page in the website.';

$langFile['EDITOR_BUTTON_RESTORELASTSTATE']                               = 'Restore to the version from %s';
$langFile['EDITOR_MESSAGE_RESTOREDTOLASTSTATE']                           = 'Restored the version from %s.';

// ---------- page advanced settings
$langFile['EDITOR_advancedpageSettings_h1']                               = 'Page specific HTML-Editor-Settings';

$langFile['EDITOR_advancedpageSettings_field1']                           = 'Page stylesheet-file';
$langFile['EDITOR_advancedpageSettings_stylesheet_ifempty']               = 'If the fields are empty, then the Stylesheet-Settings of the category will be used and if they are also empty then the one from the HTML-Editor-Settings.';

$langFile['EDITOR_htmleditor_hotkeys_h1']                                 = 'Shortcut keys';
$langFile['EDITOR_htmleditor_hotkeys_field1']                             = 'select all';
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
$langFile['EDITOR_pluginSettings_h1']                                     = 'Add plugins';
$langFile['EDITOR_TEXT_EDITPLUGINSINEDITOR']                              = 'After you activated a plugin, hover over the plugin to be able to drag it into the Editor, or place it directly in the editor, using the %s icon.';
$langFile['EDITOR_MESSAGE_PLUGINSSAVED']                                  = '<div class="alert alert-success">Plugins saved!</div>';//<div class="alert">Click on a plugin to edit its properties.</div>';
$langFile['EDITOR_TIP_DRAGPLUGIN']                                        = 'Drag the plugin into the Editor.';

/*
* unsavedPage.php
*/

$langFile['UNSAVEDPAGE_QUESTION_CONTINUE']                                = 'The page has been changed!<br><span class="brown">Do you want to continue?</span>';

/*
* deletePage.php
*/

// ---------- DELETE PAGE
$langFile['deletePage_question_part1']                                    = 'You really want to delete the page';
$langFile['deletePage_question_part2']                                    = '?';

$langFile['deletePage_notexisting_part1']                                 = 'The page';
$langFile['deletePage_notexisting_part2']                                 = 'doesn &#145;t exist';

$langFile['deletePage_finish_error']                                      = 'ERROR: The page could not be deleted!';

/*
* deletePageLanguage.php
*/

// ---------- DELETE PAGE LANGUAGE

$langFile['WINDOWBOX_TEXT_DELETEPAGELANGUAGE_QUESTION']                   = 'Do you really want to delete the language &quot;%s&quot; for this page?';

/*
* addPageLanguage.php
*/

// ---------- ADD PAGE LANGUAGE

$langFile['WINDOWBOX_TEXT_ADDPAGE_SELECTLANGUAGE']                        = 'Select language';


/*
* deletewebsiteLanguages.php
*/

// ---------- DELETE WEBSITE LANGUAGES

$langFile['WINDOWBOX_TITLE_DELETEWEBSITELANGUAGES_QUESTION']              = 'The following languages will be deleted from all pages!<br>&quot;%s&quot;';
$langFile['WINDOWBOX_TEXT_DELETEWEBSITELANGUAGES_QUESTION']               = 'Multi language website was deactivated!<br>All pages will be set to the former main language (<b>%s</b>).';


/*
* deletePageThumbnail.php
*/

// ---------- PAGE THUMBNAIL DELETE
$langFile['PAGETHUMBNAIL_TEXT_DELETE_QUESTION_START']                     = 'You really want to delete the thumbnail of the page';
$langFile['PAGETHUMBNAIL_TEXT_DELETE_QUESTION_END']                       = '?';
$langFile['PAGETHUMBNAIL_ERROR_DELETE']                                   = 'ERROR: The thumbnail could not be deleted!';


/*
* uploadPageThumbnail.php
*/

// ---------- PAGE THUMBNAIL UPLOAD
$langFile['pagethumbnail_h1_part1']                                       = 'Upload page thumbnail of';
$langFile['pagethumbnail_h1_part2']                                       = '';
$langFile['pagethumbnail_field1']                                         = 'Select image';

$langFile['pagethumbnail_thumbinfo_formats']                              = 'Only the following file formats are allowed'; //<br><b>JPG</b>, <b>JPEG</b>, <b>GIF</b>, <b>PNG</b>
$langFile['pagethumbnail_thumbinfo_filesize']                             = 'maximum filesize';
$langFile['pagethumbnail_thumbinfo_standardthumbsize']                    = 'Standard image size';

$langFile['pagethumbnail_thumbsize_h1']                                   = 'Set image size yourself';
$langFile['pagethumbnail_thumbsize_width']                                = 'Width';
$langFile['pagethumbnail_thumbsize_height']                               = 'Height';

$langFile['pagethumbnail_submit_tip']                                     = 'Upload image';

$langFile['PAGETHUMBNAIL_ERROR_nofile']                                   = 'You didn&#145;t select any file.';
$langFile['PAGETHUMBNAIL_ERROR_nouploadedfile']                           = 'No file was uploaded.';
$langFile['PAGETHUMBNAIL_ERROR_filesize']                                 = 'The filesize of the uploaded image is probably to big.<br>The maximum filesize is';
$langFile['PAGETHUMBNAIL_ERROR_wrongformat']                              = 'The selecet file has a not supported format';
$langFile['PAGETHUMBNAIL_ERROR_NODIR_START']                              = 'The thumbnail folder'; // The thumbnail-folder..
$langFile['PAGETHUMBNAIL_ERROR_NODIR_END']                                = 'doesn&#145;t exist.';
$langFile['PAGETHUMBNAIL_ERROR_CREATEDIR_END']                            = 'couldn&#145;t be created.';
$langFile['PAGETHUMBNAIL_ERROR_COULDNTMOVEFILE']                          = 'Could not move the uploaded file to the thumbnail folder %s.';
$langFile['PAGETHUMBNAIL_ERROR_CHANGEIMAGESIZE']                          = 'Couldn&#145;t resize the image.';
$langFile['PAGETHUMBNAIL_ERROR_deleteoldfile']                            = 'Couldn&#145;t delete the old thumbnail.';
$langFile['PAGETHUMBNAIL_TEXT_fileexists']                                = 'A image with this filename already exists.<br>The uploaded file was renamed to';
$langFile['PAGETHUMBNAIL_TEXT_finish']                                    = 'Succesfully uploaded the image.';

// -> BACKUP

$langFile['BACKUP_TITLE_BACKUP']                                          = 'Backup';
$langFile['BACKUP_TITLE_RESTORE']                                         = 'Restore';

$langFile['BACKUP_TITLE_RESTORE_FROMFILES']                               = 'Choose existing backup';
$langFile['BACKUP_TITLE_RESTORE_FROMUPLOAD']                              = 'Upload backup file';

$langFile['BACKUP_TEXT_RESTORE_BACKUPBEFORERESTORE']                      = 'Backup before the restore';

$langFile['BACKUP_BUTTON_DOWNLOAD']                                       = 'create current backup';
$langFile['BACKUP_TEXT_BACKUP']                                           = 'A backup creates a <code>.zip</code> file with the <span class="blue">"pages","config"</span> and <span class="blue">"statistic"</span> folders.<br>The upload folder will not be saved.';
$langFile['BACKUP_TEXT_RESTORE']                                          = '<p>Select here a <span class="feinduraName"><span>fein</span>dura</span> backup file, to restore an old state.</p><div class="alert"><strong>Hint!</strong> A backup of the current state will be created before the restore.</div>';
$langFile['BACKUP_TOOLTIP_DELETE']                                        = 'Delete backup';
$langFile['BACKUP_TEXT_DELETE_QUESTION']                                  = 'Really delete %s?'; // really delete backup 2010-11-05 15:03?

$langFile['BACKUP_TITLE_LASTBACKUPS']                                     = 'Download backups';
$langFile['BACKUP_TEXT_NOBACKUP']                                         = 'No backup created yet.';

$langFile['BACKUP_ERROR_FILENOTFOUND']                                    = 'Backup was not found at:';
$langFile['BACKUP_ERROR_NORESTROEFILE']                                   = 'No backup file to restore was selected.';
$langFile['BACKUP_ERROR_DELETE']                                          = 'Backup could not be deleted!';

// -> ADDONS

$langFile['ADDONS_TITLE_ADDON']                                           = 'Choose a <span class="feinduraInline">fein<em>dura</em></span> Add-on';
$langFile['ADDONS_TEXT_AUTHOR']                                           = 'Author';
$langFile['ADDONS_TEXT_WEBSITE']                                          = 'Website';
$langFile['ADDONS_TEXT_VERSION']                                          = 'Version';
$langFile['ADDONS_TEXT_REQUIREMENTS']                                     = 'Requirements';


// -> UPDATE

$langFile['UPDATE_TITLE']                                                 = 'Content must be updated';
$langFile['UPDATE_TEXT_CHECKPATHS']                                       = 'Make sure the following paths are correct before you update.';
$langFile['UPDATE_TEXT_BASEPATH']                                         = 'Path to <span class="feinduraInline">fein<em>dura</em></span>';
$langFile['UPDATE_TEXT_WEBSITEPATH']                                      = 'Website path';
$langFile['UPDATE_TEXT_SUCCESS']                                          = 'Content successfully updated!';
$langFile['UPDATE_BUTTON_UPDATE']                                         = 'UPDATE';
$langFile['UPDATE_ERROR_MOVEUPLOADFOLDER']                                = 'Upload folder could not be moved! Please move the folder "%s" manually to "your_feindura_folder/upload/".';
$langFile['UPDATE_ERROR_MOVEPAGESFOLDER']                                 = 'Pages could not be copied! Please move the folder "%s" manually to "your_feindura_folder/pages/".';
$langFile['UPDATE_ERROR_SAVEADMINCONFIG']                                 = 'Admin Settings couldn&#145;t be updated.';
$langFile['UPDATE_ERROR_SAVECATEGORYCONFIG']                              = 'Category Settings couldn&#145;t be updated.';
$langFile['UPDATE_ERROR_SAVEUSERCONFIG']                                  = 'User Settings couldn&#145;t be updated.';
$langFile['UPDATE_ERROR_SAVEWEBSITECONFIG']                               = 'Website Settings couldn&#145;t be updated.';
$langFile['UPDATE_ERROR_SAVEPAGES']                                       = 'Pages couldn&#145;t be updated.';
$langFile['UPDATE_ERROR_CLEARACTIVITYLOG']                                = 'Activity log couldn&#145;t be cleared.';
$langFile['UPDATE_ERROR_SAVEWEBSITESTATISTICS']                           = 'Website Statistics couldn&#145;t be updated.';
$langFile['UPDATE_ERROR_SAVEREFERERLOG']                                  = 'Referer Log couldn&#145;t be updated.';
$langFile['UPDATE_ERROR_DELETEOLDFILES']                                  = 'Could not remove old files and folders,<br>Please check these files and folders, and remove them manually:';
$langFile['UPDATE_ERROR_RENAMESTATISTICSFOLDER']                          = 'Couldn\'t rename the "feinduraFolder/statistic" folder "feinduraFolder/statistic<strong>s</strong>, please rename it manually!"';


// -----------------------------------------------------------------------------------------------
// RETURN ****************************************************************************************
// -----------------------------------------------------------------------------------------------
return $langFile;
