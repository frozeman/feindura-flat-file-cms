<?php
/*
 * feindura - Flat File Content Management System
 * Copyright (C) Fabian Vogelsteller [frozeman.de]
 *
 * This program is free software;
 * you can redistribute it and/or modify it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or (at your option) any later version.
 * Traslated in Italian By Raffaele Panariello [Social Service] unuomoinblues@gmail.com
 * This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY;
 * without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 * See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along with this program;
 * if not,see <http://www.gnu.org/licenses/>.
 */
/**
 * ITALIAN (IT) language-file for the feindura CMS (FRONTEND)
 * 
 * need a RETURN $frontendLangFile; at the END
 */


/*
// -> GENERAL <-
*/

$frontendLangFile['HEADER_TIP_GOTOBACKEND']          = 'Feindura::Clicca qui per entrare nel lato backend.';
$frontendLangFile['PAGEFUNCTIONS_TIP_EDITINBACKEND'] = 'Modifica questa pagina nel lato backend';

$frontendLangFile['EDITPAGE_TIP_DISABLED']           = 'Non &#232; possibile modificare la pagina::Questa pagina contiene tag [i]<script>[/i] ed &#232; possibile mogificarla solo nel lato backend.';


// FRONTEND ERROR TEXTS

$frontendLangFile['PAGE_ERROR_NOPAGE']               = 'La pagina richiesta non esiste.';
$frontendLangFile['PAGE_ERROR_PAGENOTPUBLIC']        = 'La pagina richiesta non &#232; attualmente disponibile.';


// DATE TEXTS

$frontendLangFile['DATE_TEXT_YESTERDAY']             = 'Ieri';
$frontendLangFile['DATE_TEXT_TODAY']                 = 'Oggi';
$frontendLangFile['DATE_TEXT_TOMORROW']              = 'Domani';


// ADDITIONAL PAGE TEXTS

$frontendLangFile['PAGE_TEXT_MORE']                  = 'altro';


// -----------------------------------------------------------------------------------------------
// RETURN ****************************************************************************************
// -----------------------------------------------------------------------------------------------
return $frontendLangFile;

?>