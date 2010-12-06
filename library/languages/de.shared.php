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
 * NEEDS a RETURN $frontendLangFile; at the END
 */


// -> GENERAL <-

$sharedLangFile['header_button_logout'] = 'Logout::Klicke hier um dich auszuloggen.';

$sharedLangFile['sortablePageList_functions_startPage'] = 'Diese Seite als Startseite festlegen';
$sharedLangFile['sortablePageList_functions_startPage_set'] = 'Diese Seite ist die Startseite';

/* date texts */

$sharedLangFile['date_yesterday'] = 'Gestern';
$sharedLangFile['date_today'] = 'Heute';
$sharedLangFile['date_tomorrow'] = 'Morgen';


// -> SEARCH

$langFile['SEARCH_TITLE'] = 'Seiten durchsuchen';
$langFile['SEARCH_TITLE_RESULTS'] = 'Suchergebnisse f&uuml;r';
$langFile['SEARCH_TEXT_MATCH_ID'] = '&Uuml;bereinstimmung mit der Seiten ID';
$langFile['SEARCH_TEXT_MATCH_TITLE'] = '&Uuml;bereinstimmungen im Titel';
$langFile['SEARCH_TEXT_MATCH_DATE'] = '&Uuml;bereinstimmungen im Seitendatum';
$langFile['SEARCH_TEXT_MATCH_CATEGORY'] = '&Uuml;bereinstimmender Kategoriename';
$langFile['SEARCH_TEXT_MATCH_WORDS'] = '&Uuml;bereinstimmende W&ouml;rter:';
$langFile['SEARCH_TEXT_RESULTS'] = 'Treffer';
$langFile['SEARCH_TEXT_TIME_1'] = 'in'; // 12 Treffer in 0.32 Sekunden
$langFile['SEARCH_TEXT_TIME_2'] = 'Sekunden';


// -> ERROR TEXTs

$sharedLangFile['errorWindow_h1'] = 'Ein Fehler ist aufgetreten!';
$sharedLangFile['sortablePageList_setStartPage_error_save'] = '<b>Die Startseite konnte nicht festgelegt werden.</b>';
$sharedLangFile['editor_savepage_error_save'] = '<b>Die Seite konnte nicht gespeichert werden.</b>';


// -----------------------------------------------------------------------------------------------
// RETURN ****************************************************************************************
// -----------------------------------------------------------------------------------------------
return $sharedLangFile;

?>