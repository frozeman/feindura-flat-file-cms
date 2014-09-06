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
 * SPANISH (ES) language-file for the feindura CMS (FRONTEND)
 *
 * need a RETURN $frontendLangFile; at the END
 */


/*
// -> GENERAL <-
*/

$frontendLangFile['HEADER_TIP_GOTOBACKEND']               = 'Feindura::Pulse aquí para ir al panel de administración.';
$frontendLangFile['PAGEFUNCTIONS_TIP_EDITINBACKEND']      = 'Edita esta página en el panel de administración';

$frontendLangFile['EDITPAGE_TIP_DISABLED']                = 'No es posible la edición directa::El contenido ha sido modificado mediante programación.';
$frontendLangFile['TOPBAR_TIP_FRONTENDEDITING']           = 'Selecciona una zona editable para modificar.';
$frontendLangFile['TOPBAR_TIP_DEACTIVATEFRONTENDEDITING'] = 'Desactivar edición directa';

// FRONTEND ERROR TEXTS

$frontendLangFile['PAGE_ERROR_NOPAGE']               = 'La página solicitada no existe.';
$frontendLangFile['PAGE_ERROR_PAGENOTPUBLIC']        = 'La página solicitada no está actualmente disponible.';
$frontendLangFile['INFO_MAINTENACE']                 = 'Este sitio web estará operativo en breve.';


// DATE TEXTS

$frontendLangFile['DATE_TEXT_YESTERDAY']             = 'Ayer';
$frontendLangFile['DATE_TEXT_TODAY']                 = 'Hoy';
$frontendLangFile['DATE_TEXT_TOMORROW']              = 'Mañana';


// ADDITIONAL PAGE TEXTS

$frontendLangFile['PAGE_TEXT_MORE']                  = 'más';


// -----------------------------------------------------------------------------------------------
// RETURN ****************************************************************************************
// -----------------------------------------------------------------------------------------------
return $frontendLangFile;
