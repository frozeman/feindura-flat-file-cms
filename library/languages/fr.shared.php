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
 * FRENCH (FR) language-file for the feindura CMS (FRONTEND and BACKEND)
 * 
 * NEEDS a RETURN $frontendLangFile; at the END
 */



// -> GENERAL <-

$sharedLangFile['HEADER_BUTTON_LOGOUT'] = 'D&eacute;connexion::D&eacute;connexion Cliquez ici pour &ecirc;tre.';

$sharedLangFile['sortablePageList_functions_startPage'] = 'd&eacute;finir cette page comme page d\'acceuil';
$sharedLangFile['sortablePageList_functions_startPage_set'] = 'cette page est la page d\'acceuil';

/* date texts */

$sharedLangFile['DATE_TEXT_YESTERDAY'] = 'hier';
$sharedLangFile['DATE_TEXT_TODAY'] = 'aujourd\'hui';
$sharedLangFile['DATE_TEXT_TOMORROW'] = 'demain';


// -> SEARCH

$langFile['SEARCH_TITLE'] = 'fouiller les pages';
$langFile['SEARCH_TITLE_RESULTS'] = 'r&eacute;sultat de recherche pour';
$langFile['SEARCH_TEXT_MATCH_ID'] = 'convergence avec l\'ID de la page';
$langFile['SEARCH_TEXT_MATCH_CATEGORY'] = 'cat&eacute;gorie';
$langFile['SEARCH_TEXT_MATCH_SEARCHWORDS'] = 'mots de recherche';
$langFile['SEARCH_TEXT_MATCH_TAGS'] = 'Tags';
$langFile['SEARCH_TEXT_RESULTS'] = 'r&eacute;sultat';
$langFile['SEARCH_TEXT_TIME_1'] = 'en'; // 12 r&eacute;sultat en 0.32 secondes
$langFile['SEARCH_TEXT_TIME_2'] = 'secondes';


// -> ERROR TEXTs

$sharedLangFile['errorWindow_h1'] = 'une erreur s\'est produite!';
$sharedLangFile['sortablePageList_setStartPage_error_save'] = '<b>activation de la page d\'accueil impossible.</b>';
$sharedLangFile['editor_savepage_error_save'] = '<b>Cette page ne pouvait pas &ecirc;tre sauvegard&eacute;e.</b>';
$sharedLangFile['ADMINSETUP_ERROR_PHPVERSION'] = 'ERREUR<br /><br /><span class="logoname">fein<span>dura</span></span> n&eacute;cessite au moins la version de PHP'; // PHP 5.1.0

// -----------------------------------------------------------------------------------------------
// RETURN ****************************************************************************************
// -----------------------------------------------------------------------------------------------
return $sharedLangFile;
?>