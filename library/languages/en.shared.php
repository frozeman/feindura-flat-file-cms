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
 * ENGLISH (EN) language-file for the feindura CMS (FRONTEND and BACKEND)
 * 
 * need a RETURN $frontendLangFile; at the END
 */


// -> GENERAL <-

$sharedLangFile['HEADER_BUTTON_LOGOUT'] = 'Logout::Click here to logout.';
$sharedLangFile['sortablePageList_functions_startPage'] = 'Set this page as start page';
$sharedLangFile['sortablePageList_functions_startPage_set'] = 'This page is the start page';

/* date texts */

$sharedLangFile['DATE_TEXT_YESTERDAY'] = 'Yesterday';
$sharedLangFile['DATE_TEXT_TODAY'] = 'Today';
$sharedLangFile['DATE_TEXT_TOMORROW'] = 'Tomorrow';


// -> SEARCH

$sharedLangFile['SEARCH_TITLE'] = 'Search pages';
$sharedLangFile['SEARCH_TITLE_RESULTS'] = 'Search results for';
$sharedLangFile['SEARCH_TEXT_MATCH_CATEGORY'] = 'category';
$sharedLangFile['SEARCH_TEXT_MATCH_SEARCHWORDS'] = 'searchwords';
$sharedLangFile['SEARCH_TEXT_MATCH_TAGS'] = 'Tags';
$sharedLangFile['SEARCH_TEXT_RESULTS'] = 'results';
$sharedLangFile['SEARCH_TEXT_TIME_1'] = 'in'; // 12 matches in 0.32 seconds
$sharedLangFile['SEARCH_TEXT_TIME_2'] = 'seconds';


// -> ERROR TEXTs

$sharedLangFile['errorWindow_h1'] = 'An error occured!';
$sharedLangFile['sortablePageList_setStartPage_error_save'] = '<b>Could not set the start page.</b>';
$sharedLangFile['editor_savepage_error_save'] = '<b>The page could not be saved.</b>';
$sharedLangFile['ADMINSETUP_ERROR_PHPVERSION'] = 'ERROR<br /><br /><span class="logoname">fein<span>dura</span></span> requires at least PHP version'; // PHP 5.2.3

// -----------------------------------------------------------------------------------------------
// RETURN ****************************************************************************************
// -----------------------------------------------------------------------------------------------
return $sharedLangFile;

?>