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

$frontendLangFile['HEADER_TIP_GOTOBACKEND']               = 'Feindura::Cliquez ici pour aller à la CMS.';
$frontendLangFile['PAGEFUNCTIONS_TIP_EDITINBACKEND']      = 'Modifier cette page dans le backend';

$frontendLangFile['EDITPAGE_TIP_DISABLED']                = 'Édition dans frontend pas possible:: Le contenu a été modifié par des scripts.';
$frontendLangFile['TOPBAR_TIP_FRONTENDEDITING']           = 'Sélectionnez une zone modifiable pour commencer à éditer.';
$frontendLangFile['TOPBAR_TIP_DEACTIVATEFRONTENDEDITING'] = 'Désactiver édition frontal';

// FRONTEND ERROR TEXTS

$frontendLangFile['PAGE_ERROR_NOPAGE']               = 'La page demandée n\'existe pas.';
$frontendLangFile['PAGE_ERROR_PAGENOTPUBLIC']        = 'La page demandée est désactivée.';
$frontendLangFile['INFO_MAINTENACE']                 = 'Le site web sera bientôt disponible.';


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
