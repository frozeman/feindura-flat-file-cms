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
 * ROMANIAN (RO) language-file for the feindura CMS (FRONTEND and BACKEND)
 *
 * need a RETURN $frontendLangFile; at the END
 */


// -> GENERAL <-

$sharedLangFile['HEADER_BUTTON_LOGOUT']                     = 'Click aici pentru iesire.';
$sharedLangFile['SORTABLEPAGELIST_functions_startPage']     = 'Setati o pagina de start';
$sharedLangFile['SORTABLEPAGELIST_functions_startPage_set'] = 'Aceasta este pagina de start';

$sharedLangFile['LOADING_TEXT_LOAD']                        = 'Pagina este in incarcare..';

/* date texts */

$sharedLangFile['DATE_TEXT_YESTERDAY']                      = 'Ieri';
$sharedLangFile['DATE_TEXT_TODAY']                          = 'Azi';
$sharedLangFile['DATE_TEXT_TOMORROW']                       = 'Maine';


// -> SEARCH

$sharedLangFile['SEARCH_TITLE']                             = 'Cauta paginile';
$sharedLangFile['SEARCH_TITLE_RESULTS']                     = 'Cauta rezultate pentru';
$sharedLangFile['SEARCH_TEXT_MATCH_ID']                     = 'Cu ID pagina corespondent';
$sharedLangFile['SEARCH_TEXT_MATCH_CATEGORY']               = 'Categorie';
$sharedLangFile['SEARCH_TEXT_MATCH_SEARCHWORDS']            = 'Cuvinte cheie';
$sharedLangFile['SEARCH_TEXT_MATCH_TAGS']                   = 'Tag-uri';
$sharedLangFile['SEARCH_TEXT_RESULTS']                      = 'Rezultate';
$sharedLangFile['SEARCH_TEXT_TIME_1']                       = 'in'; // 12 matches in 0.32 seconds
$sharedLangFile['SEARCH_TEXT_TIME_2']                       = 'secunde';


// -> ERROR TEXTs

$sharedLangFile['errorWindow_h1']                           = 'A aparut o eroare!';
$sharedLangFile['SORTABLEPAGELIST_setStartPage_error_save'] = '<b>Nu se poate seta pagina de start.</b>';
$sharedLangFile['ERROR_SAVEPAGE']                           = '<b>Pagina nu poate fi salvata.</b>';
$sharedLangFile['ADMINSETUP_ERROR_PHPVERSION']              = 'EROARE<br><br><span class="feinduraInline">fein<em>dura</em></span> are nevoie de versiunea PHP minim'; // PHP 5.2.3

// -----------------------------------------------------------------------------------------------
// RETURN ****************************************************************************************
// -----------------------------------------------------------------------------------------------
return $sharedLangFile;
