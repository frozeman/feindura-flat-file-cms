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
 * ENGLISH (EN) language-file for the feindura CMS (FRONTEND)
 *
 * need a RETURN $frontendLangFile; at the END
 */


/*
// -> GENERAL <-
*/

$frontendLangFile['HEADER_TIP_GOTOBACKEND']               = 'Feindura::Click here to go to the backend.';
$frontendLangFile['PAGEFUNCTIONS_TIP_EDITINBACKEND']      = 'Edit this page in the backend';

$frontendLangFile['EDITPAGE_TIP_DISABLED']                = 'Editing in frontend not possible::The content was changed by scripts.';
$frontendLangFile['TOPBAR_TIP_FRONTENDEDITING']           = 'Select an editable area to start editing.';
$frontendLangFile['TOPBAR_TIP_DEACTIVATEFRONTENDEDITING'] = 'Deactivate Frontend Editing';

// FRONTEND ERROR TEXTS

$frontendLangFile['PAGE_ERROR_NOPAGE']               = 'The requested page doesn\'t exist.';
$frontendLangFile['PAGE_ERROR_PAGENOTPUBLIC']        = 'The requested page is currently not available.';
$frontendLangFile['INFO_MAINTENACE']                 = 'This website will be available soon.';


// DATE TEXTS

$frontendLangFile['DATE_TEXT_YESTERDAY']             = 'Yesterday';
$frontendLangFile['DATE_TEXT_TODAY']                 = 'Today';
$frontendLangFile['DATE_TEXT_TOMORROW']              = 'Tomorrow';


// ADDITIONAL PAGE TEXTS

$frontendLangFile['PAGE_TEXT_MORE']                  = 'more';


// -----------------------------------------------------------------------------------------------
// RETURN ****************************************************************************************
// -----------------------------------------------------------------------------------------------
return $frontendLangFile;
