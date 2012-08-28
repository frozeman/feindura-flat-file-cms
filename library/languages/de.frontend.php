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
 * GERMAN (DE) language-file for the feindura CMS (FRONTEND)
 *
 * need a RETURN $frontendLangFile; at the END
 */


/*
// -> GENERAL <-
*/

$frontendLangFile['HEADER_TIP_GOTOBACKEND']               = 'Feindura::Klick hier um zum Backend zu gelangen.';
$frontendLangFile['PAGEFUNCTIONS_TIP_EDITINBACKEND']      = 'Seite im Backend bearbeiten';

$frontendLangFile['EDITPAGE_TIP_DISABLED']                = 'Bearbeiten im frontend nicht möglich::Der Inhalt wurde durch Scripte verändert.';
$frontendLangFile['TOPBAR_TIP_FRONTENDEDITING']           = 'Wähle eine bearbeitbares Feld aus, um mit dem bearbeiten zu beginnen';
$frontendLangFile['TOPBAR_TIP_DEACTIVATEFRONTENDEDITING'] = 'Frontend-Bearbeitung deaktivieren';


// FRONTEND ERROR TEXTS

$frontendLangFile['PAGE_ERROR_NOPAGE']               = 'Die angeforderte Seite existiert nicht.';
$frontendLangFile['PAGE_ERROR_PAGENOTPUBLIC']        = 'Die angeforderte Seite ist deaktiviert.';
$frontendLangFile['INFO_MAINTENACE']                 = 'Die Webseite steht in kürze zur Verfügung.';


// DATE TEXTS

$frontendLangFile['DATE_TEXT_YESTERDAY']             = 'Gestern';
$frontendLangFile['DATE_TEXT_TODAY']                 = 'Heute';
$frontendLangFile['DATE_TEXT_TOMORROW']              = 'Morgen';


// ADDITIONAL PAGE TEXTS

$frontendLangFile['PAGE_TEXT_MORE']                  = 'mehr';

// -----------------------------------------------------------------------------------------------
// RETURN ****************************************************************************************
// -----------------------------------------------------------------------------------------------
return $frontendLangFile;
