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
 * GERMAN (DE) language-file for the feindura CMS (FRONTEND and BACKEND)
 *
 * need a RETURN $frontendLangFile; at the END
 */


// -> GENERAL <-

$sharedLangFile['HEADER_BUTTON_LOGOUT']                     = 'Klicke hier um dich auszuloggen.';
$sharedLangFile['SORTABLEPAGELIST_functions_startPage']     = 'Als Startseite festlegen';
$sharedLangFile['SORTABLEPAGELIST_functions_startPage_set'] = 'Diese Seite ist die Startseite';

$sharedLangFile['LOADING_TEXT_LOAD']                        = 'Seite wird geladen..';

/* date texts */

$sharedLangFile['DATE_TEXT_YESTERDAY']                      = 'Gestern';
$sharedLangFile['DATE_TEXT_TODAY']                          = 'Heute';
$sharedLangFile['DATE_TEXT_TOMORROW']                       = 'Morgen';


// -> SEARCH

$sharedLangFile['SEARCH_TITLE']                             = 'Seiten durchsuchen';
$sharedLangFile['SEARCH_TITLE_RESULTS']                     = 'Suchergebnisse für';
$sharedLangFile['SEARCH_TEXT_MATCH_ID']                     = 'Übereinstimmung mit der Seiten ID';
$sharedLangFile['SEARCH_TEXT_MATCH_CATEGORY']               = 'Kategorie';
$sharedLangFile['SEARCH_TEXT_MATCH_SEARCHWORDS']            = 'Suchworte';
$sharedLangFile['SEARCH_TEXT_MATCH_TAGS']                   = 'Tags';
$sharedLangFile['SEARCH_TEXT_RESULTS']                      = 'Treffer';
$sharedLangFile['SEARCH_TEXT_TIME_1']                       = 'in'; // 12 Treffer in 0.32 Sekunden
$sharedLangFile['SEARCH_TEXT_TIME_2']                       = 'Sekunden';


// -> ERROR TEXTs

$sharedLangFile['errorWindow_h1']                           = 'Es sind Fehler aufgetreten!';
$sharedLangFile['SORTABLEPAGELIST_setStartPage_error_save'] = '<b>Die Startseite konnte nicht festgelegt werden.</b>';
$sharedLangFile['ERROR_SAVEPAGE']                           = '<b>Die Seite konnte nicht gespeichert werden.</b>';
$sharedLangFile['ADMINSETUP_ERROR_PHPVERSION']              = 'FEHLER<br><br><span class="feinduraInline">fein<em>dura</em></span> benötigt mindestens PHP version'; // PHP 5.1


// -----------------------------------------------------------------------------------------------
// RETURN ****************************************************************************************
// -----------------------------------------------------------------------------------------------
return $sharedLangFile;
