<?php
/*
    feindura - Flat File Content Management System
    Copyright (C) 2009 Fabian Vogelsteller [frozeman.de]

    This program is free software;
    you can redistribute it and/or modify it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 3 of the License, or (at your option) any later version.

    This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY;
    without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
    See the GNU General Public License for more details.

    You should have received a copy of the GNU General Public License along with this program;
    if not,see <http://www.gnu.org/licenses/>.

* DE german languagefile for the feindura CMS (FRONTEND)
* 
* NEEDS a RETURN $langFile; at the END*/



// ---------------------------------------------------------------------------------------------------------------------
// --- GENERAL



// ---------------------------------------------------------------------------------------------------------------------
// --------- FRONTEND Error texts

$frontendLangFile['error_noPage'] = 'Die Seite existiert nicht';
$frontendLangFile['error_pageClosed'] = 'Die Seite ist zur Zeit nicht &ouml;ffentlich';


// ---------------------------------------------------------------------------------------------------------------------
// --------- date texts

$frontendLangFile['date_yesterday'] = 'Gestern';
$frontendLangFile['date_today'] = 'Heute';
$frontendLangFile['date_tomorrow'] = 'Morgen';

// ---------------------------------------------------------------------------------------------------------------------
// --------- additional page texts

$frontendLangFile['page_more'] = 'mehr';



// ---------------------------------------------------------------------------------------------------------------------
// *********************************************************************************************************************
// ---------------------------------------------------------------------------------------------------------------------
// returns the $langFile var, if its included in an if
return $frontendLangFile;

?>