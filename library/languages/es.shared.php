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
 * SPANISH (ES) language-file for the feindura CMS (FRONTEND and BACKEND)
 *
 * need a RETURN $frontendLangFile; at the END
 */


// -> GENERAL <-

$sharedLangFile['HEADER_BUTTON_LOGOUT']                     = 'Haz click aquí para salir.';
$sharedLangFile['SORTABLEPAGELIST_functions_startPage']     = 'Establecer como página de inicio';
$sharedLangFile['SORTABLEPAGELIST_functions_startPage_set'] = 'Esta es la página de inicio';

$sharedLangFile['LOADING_TEXT_LOAD']                        = 'Cargando página...';

/* date texts */

$sharedLangFile['DATE_TEXT_YESTERDAY']                      = 'Ayer';
$sharedLangFile['DATE_TEXT_TODAY']                          = 'Hoy';
$sharedLangFile['DATE_TEXT_TOMORROW']                       = 'Mañana';


// -> SEARCH

$sharedLangFile['SEARCH_TITLE']                             = 'Buscar páginas';
$sharedLangFile['SEARCH_TITLE_RESULTS']                     = 'Resultados de la búsqueda para';
$sharedLangFile['SEARCH_TEXT_MATCH_ID']                     = 'ID de páginas encontradas';
$sharedLangFile['SEARCH_TEXT_MATCH_CATEGORY']               = 'Categoria';
$sharedLangFile['SEARCH_TEXT_MATCH_SEARCHWORDS']            = 'Buscar palabras';
$sharedLangFile['SEARCH_TEXT_MATCH_TAGS']                   = 'Etiquetas';
$sharedLangFile['SEARCH_TEXT_RESULTS']                      = 'Resultados';
$sharedLangFile['SEARCH_TEXT_TIME_1']                       = 'en'; // 12 matches in 0.32 seconds
$sharedLangFile['SEARCH_TEXT_TIME_2']                       = 'segundos';


// -> ERROR TEXTs

$sharedLangFile['errorWindow_h1']                           = '¡Se ha producido un error!';
$sharedLangFile['SORTABLEPAGELIST_setStartPage_error_save'] = '<b>No se puede establecer la página de inicio.</b>';
$sharedLangFile['ERROR_SAVEPAGE']                           = '<b>La página no pudo guardarse.</b>';
$sharedLangFile['ADMINSETUP_ERROR_PHPVERSION']              = 'ERROR<br><br><span class="feinduraInline">fein<em>dura</em></span> requiere al menos la versión de PHP '; // PHP 5.2.3

// -----------------------------------------------------------------------------------------------
// RETURN ****************************************************************************************
// -----------------------------------------------------------------------------------------------
return $sharedLangFile;
