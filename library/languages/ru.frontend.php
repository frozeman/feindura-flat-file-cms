<?php
/*
 * feindura - Flat File Content Management System
 * Copyright (C) Fabian Vogelsteller [frozeman.de]
 *
 * Translated by Konstantin Zorg <ekumena@gmail.com>, http://q-topia.ru
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
 * RUSSIAN (RU) language-file for the feindura CMS (FRONTEND)
 *
 * need a RETURN $frontendLangFile; at the END
 */


/*
// -> GENERAL <-
*/

$frontendLangFile['HEADER_TIP_GOTOBACKEND']               = 'Панель управления::Нажмите что бы войти в панель управления.';
$frontendLangFile['PAGEFUNCTIONS_TIP_EDITINBACKEND']      = 'Редактировать страницу в панели управления.';

$frontendLangFile['EDITPAGE_TIP_DISABLED']                = 'Редактирование в интерфейс не представляется возможным::содержание было изменено с помощью сценариев.';
$frontendLangFile['TOPBAR_TIP_FRONTENDEDITING']           = 'Выбор редактируемой области, чтобы начать редактирование.';
$frontendLangFile['TOPBAR_TIP_DEACTIVATEFRONTENDEDITING'] = 'Отключить Внешнего интерфейса Редактирование';

// FRONTEND ERROR TEXTS

$frontendLangFile['PAGE_ERROR_NOPAGE']               = 'Запрашиваемая страница не существует.';
$frontendLangFile['PAGE_ERROR_PAGENOTPUBLIC']        = 'Запрашиваемая страница недоступна.';
$frontendLangFile['INFO_MAINTENACE']                 = 'На сайте будут доступны в ближайшее время.';


// DATE TEXTS

$frontendLangFile['DATE_TEXT_YESTERDAY']             = 'Вчера';
$frontendLangFile['DATE_TEXT_TODAY']                 = 'Сегодня';
$frontendLangFile['DATE_TEXT_TOMORROW']              = 'Завтра';


// ADDITIONAL PAGE TEXTS

$frontendLangFile['PAGE_TEXT_MORE']                  = 'подробнее';


// -----------------------------------------------------------------------------------------------
// RETURN ****************************************************************************************
// -----------------------------------------------------------------------------------------------
return $frontendLangFile;
