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
 * FRENCH (FR) language-file for the feindura CMS (FRONTEND)
 * 
 * need a RETURN $frontendLangFile; at the END
 */

 
/*
// -> GENERAL <-
*/

$frontendLangFile['HEADER_TIP_GOTOBACKEND']          = 'Feindura::Cliquez ici pour aller à la CMS.';
$frontendLangFile['PAGEFUNCTIONS_TIP_EDITINBACKEND'] = 'Modifier cette page dans le backend';

$frontendLangFile['EDITPAGE_TIP_DISABLED']           = 'Il n\'est pas possible de modifier la page::La page contient [i]<script>[/i] tags et par conséquent seulement peuvent être édités dans le backend.';


// FRONTEND ERROR TEXTS

$frontendLangFile['PAGE_ERROR_NOPAGE']               = 'la page demandée n\'existe pas.';
$frontendLangFile['PAGE_ERROR_PAGENOTPUBLIC']        = 'la page demandée est désactivée.';


// DATE TEXTS

$frontendLangFile['DATE_TEXT_YESTERDAY']             = 'hier';
$frontendLangFile['DATE_TEXT_TODAY']                 = 'aujourd\'hui';
$frontendLangFile['DATE_TEXT_TOMORROW']              = 'demain';


// ADDITIONAL PAGE TEXTS

$frontendLangFile['PAGE_TEXT_MORE']                  = 'plus';

// -----------------------------------------------------------------------------------------------
// RETURN ****************************************************************************************
// -----------------------------------------------------------------------------------------------
return $frontendLangFile;
?>