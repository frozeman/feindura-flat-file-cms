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
 * need a RETURN $frontendLangFile; at the END
 */



// -> GENERAL <-

$sharedLangFile['HEADER_BUTTON_LOGOUT']                     = 'Déconnexion Cliquez ici pour être.';

$sharedLangFile['SORTABLEPAGELIST_functions_startPage']     = 'Définir comme page d&#145;accueil';
$sharedLangFile['SORTABLEPAGELIST_functions_startPage_set'] = 'Cette page est la page d\'acceuil';

$sharedLangFile['LOADING_TEXT_LOAD']                        = 'site en connexion...';

/* date texts */

$sharedLangFile['DATE_TEXT_YESTERDAY']                      = 'hier';
$sharedLangFile['DATE_TEXT_TODAY']                          = 'aujourd\'hui';
$sharedLangFile['DATE_TEXT_TOMORROW']                       = 'demain';


// -> SEARCH

$sharedLangFile['SEARCH_TITLE']                             = 'fouiller les pages';
$sharedLangFile['SEARCH_TITLE_RESULTS']                     = 'résultat de recherche pour';
$sharedLangFile['SEARCH_TEXT_MATCH_ID']                     = 'convergence avec l\'ID de la page';
$sharedLangFile['SEARCH_TEXT_MATCH_CATEGORY']               = 'catégorie';
$sharedLangFile['SEARCH_TEXT_MATCH_SEARCHWORDS']            = 'mots de recherche';
$sharedLangFile['SEARCH_TEXT_MATCH_TAGS']                   = 'Tags';
$sharedLangFile['SEARCH_TEXT_RESULTS']                      = 'résultat';
$sharedLangFile['SEARCH_TEXT_TIME_1']                       = 'en'; // 12 résultat en 0.32 secondes
$sharedLangFile['SEARCH_TEXT_TIME_2']                       = 'secondes';


// -> ERROR TEXTs

$sharedLangFile['errorWindow_h1']                           = 'une erreur s\'est produite!';
$sharedLangFile['SORTABLEPAGELIST_setStartPage_error_save'] = '<b>activation de la page d\'accueil impossible.</b>';
$sharedLangFile['ERROR_SAVEPAGE']                           = '<b>Cette page ne pouvait pas être sauvegardée.</b>';
$sharedLangFile['ADMINSETUP_ERROR_PHPVERSION']              = 'ERREUR<br><br><span class="feinduraInline">fein<em>dura</em></span> nécessite au moins la version de PHP'; // PHP 5.2.3

// -----------------------------------------------------------------------------------------------
// RETURN ****************************************************************************************
// -----------------------------------------------------------------------------------------------
return $sharedLangFile;
