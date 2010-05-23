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
 * NEEDS a RETURN $frontendLangFile; at the END
 */


/* ----------------------------------------------------------------------------------------------
* --- GENERAL
*/



/* ----------------------------------------------------------------------------------------------
* --------- FRONTEND Error texts
*/

$frontendLangFile['error_noPage'] = 'The requested page doesn\'t exist.';
$frontendLangFile['error_pageClosed'] = 'The requested page is currently not available.';


/* ----------------------------------------------------------------------------------------------
* --------- date texts
*/

$frontendLangFile['date_yesterday'] = 'Yesterday';
$frontendLangFile['date_today'] = 'Today';
$frontendLangFile['date_tomorrow'] = 'Tomorrow';

/* ----------------------------------------------------------------------------------------------
* --------- additional page texts
*/

$frontendLangFile['page_more'] = 'more';


// -----------------------------------------------------------------------------------------------
// RETURN ****************************************************************************************
// -----------------------------------------------------------------------------------------------
// returns the $frontendLangFile var
return $frontendLangFile;

?>