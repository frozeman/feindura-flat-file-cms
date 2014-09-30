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
 * RUSSIAN (RU) language-file for the feindura CMS (BACKEND)
 *
 * IMPORTANT:<br>
 * if you want to write html-code in the toolTip texts (mostly they end with ".._tip" or ".._inputTip")
 * use only "[" and "]" instead of "<" and ">" for the HTML-tags and use no " this would end the title="" tag where the toolTip text is in.
 *
 * Also dont use " or ' use &quot; and &#145; instead.
 *
 * <samp>
 * $langFile['GROUP_TYPE_NAME'] = 'langfile example text';
 * </samp>
 *
 * The TYPE's can be<br>
 *    - INPUT
 *    - LINK
 *    - BUTTON
 *    - TITLE
 *    - TEXT
 *    - EXAMPLE
 *    - ERROR
 *    - TOOLTIP / TIP
 *    - MESSAGE // should contain <div class="alert"></div>
 *
 * need a RETURN $langFile; at the END
 */

// -> LOGIN <-

$langFile['LOGIN_INPUT_USERNAME']                                         = 'Логин';
$langFile['LOGIN_INPUT_PASSWORD']                                         = 'Пароль';
$langFile['LOGIN_BUTTON_LOGIN']                                           = 'Войти';
$langFile['LOGIN_TEXT_COOKIESNEEDED']                                     = 'Cookie должны быть включены!';

$langFile['LOGIN_LINK_FORGOTPASSWORD']                                    = 'Забыли пароль?';
$langFile['LOGIN_LINK_BACKTOLOGIN']                                       = 'к форме входа';
$langFile['LOGIN_BUTTON_SENDNEWPASSWORD']                                 = 'Сброс пароля';
$langFile['LOGIN_TEXT_NEWPASSWORDEMAIL_SUBJECT']                          = 'Вы запросили восстановление пароля';
$langFile['LOGIN_TEXT_NEWPASSWORDEMAIL_MESSAGE']                          = 'Вы запросили новый пароль.
Ваш логин и новый пароль:';

$langFile['LOGIN_ERROR_FORGOTPASSWORD_NOEMAIL']                           = 'Пользователь не имеет E-Mail адреса.';
$langFile['LOGIN_ERROR_FORGOTPASSWORD_NOTSEND']                           = 'ОШИБКА<br> При отправке нового пароля на email пользователя.';
$langFile['LOGIN_ERROR_FORGOTPASSWORD_NOTSAVED']                          = 'ОШИБКА<br> Не удается сохранить новый пароль.';
$langFile['LOGIN_ERROR_FORGOTPASSWORD_SUCCESS']                           = 'Новый пароль отправлен по следующему адресу';

$langFile['LOGIN_ERROR_WRONGUSER']                                        = 'Пользователя не найдено';
$langFile['LOGIN_ERROR_WRONGPASSWORD']                                    = 'пароль неверный';

$langFile['LOGIN_TEXT_LOGOUT_PART1']                                      = 'Вы успешно вышли';
$langFile['LOGIN_TEXT_LOGOUT_PART2']                                      = 'перейти на сайт';

$langFile['LOGIN_TIP_AUTOLOGOUT']                                         = 'Автоматический выход';


// -> GENERAL <-

$langFile['DATE_Y-M-D']                                                   = 'ГГГГ-MM-ДД';
$langFile['DATE_D.M.Y']                                                   = 'ДД.MM.ГГГГ';
$langFile['DATE_D/M/Y']                                                   = 'ДД/MM/ГГГГ';
$langFile['DATE_M/D/Y']                                                   = 'MM/ДД/ГГГГ';

$langFile['CATEGORIES_TEXT_NONCATEGORY']                                  = 'Страницы';
$langFile['CATEGORIES_TOOLTIP_NONCATEGORY']                               = 'Страницы без категории';
$langFile['TEXT_EXAMPLE']                                                 = 'Пример';

$langFile['HEADER_BUTTON_GOTOWEBSITE_FRONTENDEDITING']                    = 'Редактировать на сайте::Нажмите что бы редактировать страницы на сайте.';

$langFile['BUTTON_MORE']                                                  = 'гораздо';

// PERMISSIONS
$langFile['PERMISSIONS_TEXT_DONTHAVEPERMISSION']                          = 'Вы не авторизованы, чтобы изменить это.';

// THUMBNAILS
$langFile['THUMBNAIL_TEXT_UNIT']                                          = 'пикселей';

$langFile['THUMBNAIL_TEXT_NAME']                                          = 'Миниатюра';
$langFile['THUMBNAIL_TEXT_WIDTH']                                         = 'Миниатюра <b>ширина</b>';
$langFile['THUMBNAIL_TEXT_HEIGHT']                                        = 'Миниатюра <b>высота</b>';

$langFile['THUMBNAIL_TOOLTIP_WIDTH']                                      = 'Стандартная ширина::Ширина миниатюры в пикселах.[br][br]Изображение будет уменьшено согласно этому значению.';
$langFile['THUMBNAIL_TOOLTIP_HEIGHT']                                     = 'Стандартная высота::Высота миниатюры в пикселах.[br][br]Изображение будет уменьшено согласно этому значению.';

$langFile['THUMBNAIL_TEXT_RATIO']                                         = 'Пропорции';
$langFile['THUMBNAIL_TEXT_KEEPRATIO']                                     = 'сохранять пропорции';
$langFile['THUMBNAIL_TEXT_FIXEDRATIO']                                    = 'фиксированные пропорции';
$langFile['THUMBNAIL_TOOLTIP_FIXEDRATIO']                                 = 'Высота и ширина задаются в ручную.';
$langFile['THUMBNAIL_TOOLTIP_KEEPRATIO_X']                                = 'Пропорционально уменьшается по [i]ширине[/i].';
$langFile['THUMBNAIL_TOOLTIP_KEEPRATIO_Y']                                = 'Пропорционально уменьшается по [i]высоте[/i].';

// STYLESHEETS
$langFile['STYLESHEETS_TEXT_STYLEFILE']                                   = 'Файлы каскадных стилей';
$langFile['STYLESHEETS_TEXT_ID']                                          = 'Stylesheet-Id';
$langFile['STYLESHEETS_TEXT_CLASS']                                       = 'Stylesheet-Class';

$langFile['STYLESHEETS_TOOLTIP_STYLEFILE']                                = 'Индивидуальный файл каскадных стилей для страницы.';
$langFile['STYLESHEETS_TOOLTIP_ID']                                       = 'Здесь вы можете указать атрибут ID который будет добавлен к тегу <body>.';
$langFile['STYLESHEETS_TOOLTIP_CLASS']                                    = 'Здесь вы можете указать атрибут class который будет добавлен к тегу <body>.';

$langFile['STYLESHEETS_TOOLTIP_ADDSTYLEFILE']                             = 'добавить файл каскадных стилей';
$langFile['STYLESHEETS_EXAMPLE_STYLEFILE']                                = '<b>Пример</b> &quot;/style/layout.css&quot;';

// PATHS
$langFile['PATHS_TEXT_ABSOLUTE']                                          = 'абсолютный путь';
$langFile['PATHS_TEXT_RELATIVE']                                          = 'относительный путь';
$langFile['PATHS_TOOLTIP_ABSOLUTE']                                       = 'Абсолютный путь::Абсолютный путь файловой системы. (Но по отношению к DocumentRoot)[br][br][span class=hint]/server/htdocs[strong]/path/[/strong][/span]';
$langFile['PATHS_TOOLTIP_RELATIVE']                                       = 'Относительный путь::Относительный путь URI, значит, по отношению к текущему документу.';

// STATISTICS
$langFile['STATISTICS_TITLE_BROWSERCHART']                                = 'Браузеры используемые посетителями';
$langFile['STATISTICS_TEXT_ROBOTCOUNT']                                   = 'Пауки & боты';
$langFile['STATISTICS_TOOLTIP_ROBOTCOUNT']                                = 'Пауки & боты::Пауки или роботы индексирующие и проверяющие сайт.';

$langFile['STATISTICS_TEXT_SEARCHWORD_PART1']                             = 'пришло'; // "exampleword" led 20 times to this website
$langFile['STATISTICS_TEXT_SEARCHWORD_PART2']                             = 'раз на сайт';
$langFile['STATISTICS_TOOLTIP_SEARCHWORD']                                = 'Нажмите для поиска слова на странице.';

$langFile['STATISTICS_TEXT_VISITORCOUNT']                                 = 'Посетителей до сих пор';
$langFile['STATISTICS_TEXT_CURRENTVISITORS']                              = 'Текущие посетителей';
$langFile['STATISTICS_TEXT_CURRENT']                                      = 'в настоящее время';
$langFile['STATISTICS_TEXT_LASTACTIVITY']                                 = 'Последняя активность';

$langFile['STATISTICS_TITLE_PAGESTATISTICS']                              = 'Статистика по страницам';

$langFile['STATISTICS_TEXT_VISITTIME_MAX']                                = 'самые продолжительные визиты';
$langFile['STATISTICS_TEXT_VISITTIME_MIN']                                = 'самые короткие визиты';
$langFile['STATISTICS_TEXT_FIRSTVISIT']                                   = 'с';
$langFile['STATISTICS_TEXT_LASTVISIT']                                    = 'до';
$langFile['STATISTICS_TEXT_NOVISIT']                                      = 'Еще никто не посещал сайт.';
$langFile['STATISTICS_TEXT_SEARCHWORD_DESCRIPTION']                       = '<span class="toolTipTop" title="::По которым приходят из
Google, Yahoo или Bing (MSN) на сайт.">Ключевые слова</span>';

$langFile['STATISTICS_TEXT_HOUR_SINGULAR']                                = 'час';
$langFile['STATISTICS_TEXT_HOUR_PLURAL']                                  = 'часов';
$langFile['STATISTICS_TEXT_MINUTE_SINGULAR']                              = 'минута';
$langFile['STATISTICS_TEXT_MINUTE_PLURAL']                                = 'минут';
$langFile['STATISTICS_TEXT_SECOND_SINGULAR']                              = 'секунда';
$langFile['STATISTICS_TEXT_SECOND_PLURAL']                                = 'секунд';

$langFile['STATISTICS_TEXT_BROWSERCHART_OTHERS']                          = 'другое';

// LOG TEXTS
$langFile['LOG_PAGE_SAVED']                                               = 'Сохранена страница';
$langFile['LOG_PAGE_NEW']                                                 = 'Создана страница';
$langFile['LOG_PAGE_DELETE']                                              = 'Удалена страница';

$langFile['LOG_PAGE_MOVEDINCATEGORY']                                     = 'Перемещение страницы в категорию';
$langFile['LOG_PAGE_MOVEDTOCATEGORY_CATEGORY']                            = 'в категории'; // Example Page in Category
$langFile['LOG_PAGE_SORTED']                                              = 'Сортировка страниц изменена';

$langFile['LOG_THUMBNAIL_UPLOAD']                                         = 'Миниатюра загружена';
$langFile['LOG_THUMBNAIL_DELETE']                                         = 'Миниатюра удалена';

$langFile['LOG_USER_ADD']                                                 = 'Пользователь создан';
$langFile['LOG_USER_DELETED']                                             = 'Пользователь удален';
$langFile['LOG_USER_PASSWORD_CHANGED']                                    = 'Пароль пользователя изменен';
$langFile['LOG_USER_SAVED']                                               = 'Пользователь сохранен';

$langFile['LOG_ADMINSETUP_SAVED']                                         = 'Установки сохранены';
$langFile['LOG_ADMINSETUP_CKSTYLES']                                      = '&quot;Стили визуального редактора&quot; сохранены';

$langFile['LOG_WEBSITESETUP_SAVED']                                       = 'Конфигурация сайта сохранена';

$langFile['LOG_STATISTICSETUP_SAVED']                                     = 'Настройки статистики сохранены';
$langFile['LOG_CLEARSTATISTICS_WEBSITESTATISTIC']                         = 'Статистика сайта обнулена';
$langFile['LOG_CLEARSTATISTICS_PAGESTATISTICS']                           = 'Статистика страниц обнулена';
$langFile['LOG_CLEARSTATISTICS_PAGESTAYLENGTH']                           = 'Статистика прибывания на страницах обнулена';
$langFile['LOG_CLEARSTATISTICS_REFERERLOG']                               = 'Статистика источников переходов обнулена';
$langFile['LOG_CLEARSTATISTICS_ACTIVITYLOG']                              = 'Статистика последних действий обнулена';

$langFile['LOG_PAGESETUP_SAVED']                                          = 'Настройки страниц сохранены';
$langFile['LOG_PAGESETUP_CATEGORIES_SAVED']                               = 'Категория сохранена';

$langFile['LOG_PAGESETUP_CATEGORIES_NEW']                                 = 'Создана категория';
$langFile['LOG_PAGESETUP_CATEGORIES_DELETED']                             = 'Категория удалена';
$langFile['LOG_PAGESETUP_CATEGORIES_MOVED']                               = 'Категория перемещена';

$langFile['LOG_FILE_SAVED']                                               = 'Файл сохранен';
$langFile['LOG_FILE_DELETED']                                             = 'Файл удален';

$langFile['LOG_BACKUP_CREATED']                                           = 'Копия создана';
$langFile['LOG_BACKUP_RESTORED']                                          = 'Копия восстановлена';
$langFile['LOG_BACKUP_DELETED']                                           = 'Копия удалена';

$langFile['LOG_PAGELANGUAGE_DELETED']                                     = 'Удаленные языка &quot;%s&quot; на странице';
$langFile['LOG_PAGELANGUAGE_ADD']                                         = 'Добавить язык &quot;%s&quot; на странице';


// PAGE/CATEGORY STATUS
$langFile['STATUS_PAGE_PUBLIC']                                           = 'Страница активна';
$langFile['STATUS_PAGE_NONPUBLIC']                                        = 'Страница скрыта';

$langFile['STATUS_CATEGORY_PUBLIC']                                       = 'Категория активна';
$langFile['STATUS_CATEGORY_NONPUBLIC']                                    = 'Категория скрыта';

// USER LIST
$langFile['USER_TEXT_USER']                                               = 'Пользователь';
$langFile['USER_TEXT_NOUSER']                                             = 'Существовали не пользователей.';
$langFile['USER_TEXT_CURRENTUSER']                                        = 'Что это ты!';
$langFile['USER_TEXT_USERSONLINE']                                        = 'Этот пользователь есть онлайн::Последние действия';

$langFile['LOGO_TEXT']                                                    = 'Версия';
$langFile['txt_logo_gotowebsite']                                         = 'Нажмите что бы перейти на сайт.';


// CKEDITOR transport
$langFile['CKEDITOR_TITLE_LINKS']                                         = 'feindura страницы';
$langFile['CKEDITOR_TITLE_SNIPPETS']                                      = 'Фрагменты кода';
$langFile['CKEDITOR_TEXT_SNIPPETS']                                       = 'Выберите фрагмент кода, чтобы поместить его на страницу.';
$langFile['CKEDITOR_BUTTON_EDITSNIPPET']                                  = 'Редактировать фрагмент кода';
$langFile['CKEDITOR_TITLE_PLUGINS']                                       = 'Плагины';
$langFile['CKEDITOR_BUTTON_EDITPLUGIN']                                   = 'Редактировать плагин';

$langFile['CKEDITOR_TEXT_PLUGINS']                                        = 'Выберите плагин, чтобы поместить его на страницу.';


// -> BUTTON TEXTS

// MAIN MENU
$langFile['BUTTON_DASHBOARD']                                             = 'Сводка';
$langFile['BUTTON_PAGES']                                                 = 'Страницы';
$langFile['BUTTON_ADDONS']                                                = 'Add-ons';
$langFile['BUTTON_WEBSITESETTINGS']                                       = 'Настройки сайта';
$langFile['BUTTON_SEARCH']                                                = 'Искать страницы';

// ADMIN MENU
$langFile['HEADER_TITLE_ADMINMENU']                                       = 'Панель управления';
$langFile['BUTTON_ADMINSETUP']                                            = 'Основные настройки';
$langFile['BUTTON_PAGESETUP']                                             = 'Настройки категорий';
$langFile['BUTTON_STATISTICSETUP']                                        = 'Настройки статистики';
$langFile['BUTTON_USERSETUP']                                             = 'Пользователи';
$langFile['BUTTON_BACKUP']                                                = 'Резервные копии';

// SUB MENU/FOOTER
$langFile['BUTTON_FILEMANAGER']                                           = 'Файл-менеджер';
$langFile['BUTTON_TOOLTIP_FILEMANAGER']                                   = 'Управление файлами и картинками';
$langFile['BUTTON_CREATEPAGE']                                            = 'Новая страница';
$langFile['BUTTON_TOOLTIP_CREATEPAGE']                                    = 'Создать новую страницу';
$langFile['BUTTON_DELETEPAGE']                                            = 'Удалить страницу';
$langFile['BUTTON_TOOLTIP_DELETEPAGE']                                    = 'Удалить эту страницу';
$langFile['BUTTON_FRONTENDEDITPAGE']                                      = 'Редактировать страницу на сайте';
$langFile['BUTTON_TOOLTIP_FRONTENDEDITPAGE']                              = 'Редактировать эту страницу непосредственно на сайте.';
$langFile['BUTTON_THUMBNAIL_UPLOAD']                                      = 'Загрузить миниатюру к странице';
$langFile['BUTTON_TOOLTIP_THUMBNAIL_UPLOAD']                              = 'Загрузить миниатюру к этой странице';
$langFile['BUTTON_THUMBNAIL_DELETE']                                      = 'Удалить минитюру страницы';
$langFile['BUTTON_TOOLTIP_THUMBNAIL_DELETE']                              = 'Удалить миниатюру к этой странице';
$langFile['BUTTON_WEBSITELANGUAGE_ADD']                                   = 'Добавить языка';
$langFile['BUTTON_TOOLTIP_WEBSITELANGUAGE_ADD']                           = 'Добавить новый язык для этой страницы';
$langFile['BUTTON_WEBSITELANGUAGE_DELETE']                                = 'Удаление языка';
$langFile['BUTTON_TOOLTIP_WEBSITELANGUAGE_DELETE']                        = 'Удаление языка &quot;%s&quot; для этой страницы';
$langFile['BUTTON_SHOWINMENU']                                            = 'Show in menus';
$langFile['BUTTON_HIDEINMENU']                                            = 'Hide from menus';
$langFile['BUTTON_TOOLTIP_SHOWHIDEINMENU']                                = 'Whether or not to hide this page from menus.';
$langFile['BUTTON_SHOWINMENU']                                            = 'Показывать в меню';
$langFile['BUTTON_HIDEINMENU']                                            = 'Скрыть из меню';
$langFile['BUTTON_TOOLTIP_SHOWHIDEINMENU']                                = 'Определяет, является ли страница отображается в меню или нет.';

// OTHER BUTTONS
$langFile['BUTTON_UP']                                                    = 'Вверх';
$langFile['BUTTON_INFO']                                                  = 'Информация';
$langFile['BUTTON_EDIT']                                                  = 'Редактировать';
$langFile['BUTTON_RESET']                                                 = 'Восстановление';
$langFile['BUTTON_OK']                                                    = 'OK';

// -> GENERAL ERROR TEXTS
$langFile['ERROR_SAVE_SETTINGS']                                          = '<b>Не удается сохранить настройки</b>';
$langFile['ERROR_SAVE_FILE']                                              = '<br><br>Пожалуйста проверьте права на чтение и запись для файла: ';

$langFile['ERROR_READ_FOLDER_PART1']                                      = '<br><br>Пожалуйста проверьте права на чтение для файла&quot;';
$langFile['ERROR_SAVE_FOLDER_PART1']                                      = '<br><br>Пожалуйста проверьте права на запись для файла&quot;';

$langFile['ERROR_FOLDER_PART2']                                           = '&quot; Дириктория, это поддиректория и файлы.';

// -> WARNINGS
$langFile['WARNING_TITLE_STARTPAGE']                                      = 'Главная страница не установлена!';
$langFile['WARNING_TEXT_STARTPAGE']                                       = 'Пожалуйста установите главную страницу.<br>Пройдите к <a href="?site=pages">'.$langFile['BUTTON_PAGES'].'</a> и выберите <span class="icons startpage"></span> иконку для назначения страницы.';

$langFile['WARNING_TITLE_DOCUMENTROOT']                                   = 'Ваш Document Root не удается обнаружить автоматически!';
$langFile['WARNING_TEXT_DOCUMENTROOT']                                    = 'Для <span class="feinduraInline">fein<em>dura</em></span> функционировать должным образом, вы должны установить Document Root вручную в <a href="?site=adminSetup#adminSettings">Основные настройки</a>.';

$langFile['WARNING_TITLE_BASEPATH']                                       = '<span class="feinduraInline">fein<em>dura</em></span> не настроена!';
$langFile['WARNING_TEXT_BASEPATH']                                        = '<i>Базовый путь</i> неверный, установите базовый путь на странице Основные настройки - Базовые настройки.';

$langFile['WARNING_TITLE_JAVASCRIPT']                                     = 'Включите Javascript!';
$langFile['WARNING_TEXT_JAVASCRIPT']                                      = '<strong>Для полноценного использования <span class="feinduraInline">fein<em>dura</em></span> необходимо включить Javascript!</strong>';

$langFile['WARNING_TITLE_UNTITLEDCATEGORIES']                             = 'Отсутствие названия категории';

$langFile['DASHBOARD_TITLE_IEWARNING']                                    = '<span class="feinduraInline">fein<em>dura</em></span> не предназначена для устаревших версий Internet Explorers';
$langFile['DASHBOARD_TEXT_IEWARNING']                                     = 'Для нормального использования <span class="feinduraInline">fein<em>dura</em></span> CMS вам необходимо использовать хотя бы Internet Explorer 9.<br><br>Пожалуйста установите новую версию Internet Explorer,<br> или <a href="http://www.google.com/chromeframe" target="_blank">Google Chrome Frame Plugin</a> для Internet Explorer,<br>или установите альтернативный браузер - <a href="http://www.mozilla.org/firefox/">Firefox</a> либо <a href="http://www.google.com/chrome/">Chrome</a>.';

$langFile['GENERAL_TEXT_CURRENTLYEDITED']                                 = 'Страница в данный момент редактируется...';

// MESSAGES
$langFile['MESSAGE_TEXT_CHANGEDSTATUS']                                   = 'Статус был успешно изменен.';
$langFile['MESSAGE_TEXT_CHANGEDSHOWINMENU']                               = 'Он меню статус был успешно изменен.';


/*
* leftSidebar.loader.php
*/

// ---------- QUICKMENU

$langFile['SIDEBARMENU_TITLE_CATEGORIES']                                 = 'Категории';
$langFile['SIDEBARMENU_TITLE_PAGES']                                      = 'Страницы';

$langFile['btn_quickmenu_categories']                                     = 'Категории';
$langFile['btn_quickmenu_pages']                                          = 'Страницы';

/*
* dashboard.php
*/

// ---------- DASHBOARD
$langFile['DASHBOARD_TITLE_USERINFO']                                     = 'пользователей';

$langFile['DASHBOARD_TITLE_WELCOME']                                      = 'Добро пожаловать в панель управления <span class="feinduraInline">fein<em>dura</em></span>,<br> превосходной системы управления контентом';

$langFile['DASHBOARD_TITLE_STATISTICS']                                   = 'Статистика сайта';

$langFile['DASHBOARD_TITLE_USER']                                         = 'Пользователь';
$langFile['DASHBOARD_TITLE_ACTIVITY']                                     = 'последние действия';
$langFile['DASHBOARD_TEXT_ACTIVITY_NONE']                                 = 'пусто';

$langFile['DASHBOARD_TITLE_STATISTICS_MOSTVISITED']                       = 'наиболее посещаемые';
$langFile['DASHBOARD_TITLE_STATISTICS_LASTVISITED']                       = 'последние просмотренные';
$langFile['DASHBOARD_TITLE_STATISTICS_LASTEDITED']                        = 'последние измененные';
$langFile['DASHBOARD_TITLE_STATISTICS_LONGESTVIEWED']                     = 'дольше всего просматривали';

$langFile['DASHBOARD_TITLE_REFERER']                                      = 'Источники посещений';

/*
* listPages.php
*/

// ---------- PAGES SORTABLE LIST
$langFile['SORTABLEPAGELIST_h1']                                          = 'Содержание сайта';
$langFile['SORTABLEPAGELIST_headText1']                                   = 'фильтр';
$langFile['SORTABLEPAGELIST_headText3']                                   = 'Визитов';
$langFile['SORTABLEPAGELIST_headText4']                                   = 'Статус';
$langFile['SORTABLEPAGELIST_headText5']                                   = 'Операции';

$langFile['SORTABLEPAGELIST_TIP_PAGEDATE']                                = 'Дата';
$langFile['SORTABLEPAGELIST_TIP_LASTEDIT']                                = 'Редактировалось';
$langFile['SORTABLEPAGELIST_TIP_TAGS']                                    = 'Таги';
$langFile['SORTABLEPAGELIST_TIP_LOCALIZATION']                            = 'Языки';

$langFile['SORTABLEPAGELIST_TIP_SORTALPHABETICAL']                        = 'сортировать по алфавиту';
$langFile['SORTABLEPAGELIST_TIP_SORTBYPAGEDATE']                          = 'сортировать по дате';

$langFile['SORTABLEPAGELIST_functions_editPage']                          = 'Редактировать';

$langFile['SORTABLEPAGELIST_TIP_CHANGESTATUS']                            = 'Нажмите что бы изменить.';

$langFile['SORTABLEPAGELIST_TOOLTIP_LANGUAGEMISSING']                     = 'Отсутствует языках';

$langFile['file_error_read']                                              = '<b>Не удается прочесть страницу.</b>'.$langFile['ERROR_READ_FOLDER_PART1'].'%spages/'.$langFile['ERROR_FOLDER_PART2'];
$langFile['SORTABLEPAGELIST_setStartPage_error_save']                     .= $langFile['ERROR_SAVE_FILE'].' &quot;%sconfig/website.config.php&quot;'; // also in en.shared.php
$langFile['SORTABLEPAGELIST_changeStatusPage_error_save']                 = '<b>Не удается изменить статус страницы.</b>'.$langFile['ERROR_SAVE_FOLDER_PART1'].'%spages/'.$langFile['ERROR_FOLDER_PART2'];
$langFile['SORTABLEPAGELIST_changeStatusCategory_error_save']             = '<b>Не удается изменить статус категории.</b>'.$langFile['ERROR_SAVE_FOLDER_PART1'].'%spages/'.$langFile['ERROR_FOLDER_PART2'];

$langFile['SORTABLEPAGELIST_info']                                        = 'Вы можете менять порядок <b>соглашение</b> используя принцип <b>Нажми & Тащи</b> :)';
$langFile['SORTABLEPAGELIST_save']                                        = 'Сохранение сортировки ...';
$langFile['SORTABLEPAGELIST_save_finished']                               = 'Порядок сортировки изменен!';
$langFile['SORTABLEPAGELIST_error_save']                                  = '<b>Не удается сохранить страницу.</b>'.$langFile['ERROR_SAVE_FOLDER_PART1'].'%spages/'.$langFile['ERROR_FOLDER_PART2'];
$langFile['SORTABLEPAGELIST_error_read']                                  = '<b>Страницы не читаются!</b>'.$langFile['ERROR_READ_FOLDER_PART1'].'%spages/'.$langFile['ERROR_FOLDER_PART2'];
$langFile['SORTABLEPAGELIST_error_move']                                  = '<b>Не удается переместить страницу в новую категорию.</b>'.$langFile['ERROR_SAVE_FOLDER_PART1'].'%spages/'.$langFile['ERROR_FOLDER_PART2'];
$langFile['SORTABLEPAGELIST_categoryEmpty']                               = 'Нет страниц';
$langFile['SORTABLEPAGELIST_TIP_DRATOREARRANGE']                          = 'Перетащите для перегруппировки.';

$langFile['SORTABLEPAGELIST_TIP_SUBCATEGORYOFPAGES_SINGULAR']             = 'Подкатегория на странице:';
$langFile['SORTABLEPAGELIST_TIP_SUBCATEGORYOFPAGES_PLURAL']               = 'Подкатегория из страниц:';

// ---------- FORMULAR
$langFile['FORM_BUTTON_SUBMIT']                                           = 'Сохранить';
$langFile['FORM_BUTTON_CANCEL']                                           = 'Сбросить все поля';


/*
* adminSetup.php
*/

// ---------- ADMIN SETUP (on toolTips tooTips.js converts the "[" and "]" tags in the title attribute to "<" ">")
$langFile['ADMINSETUP_TEXT_VERSION']                                      = '<span class="feinduraInline">fein<em>dura</em></span> версия';
$langFile['ADMINSETUP_TEXT_PHPVERSION']                                   = 'PHP версия';
$langFile['ADMINSETUP_TITLE_DOCUMENTROOT']                                = ' Document Root';

$langFile['ADMINSETUP_TITLE_ERROR']                                       = 'Произошли ошибки';
$langFile['ADMINSETUP_TOOLTIP_WRITEACCESSERROR']                          = 'Для директорий и файлов необходимо установить права %o';

$langFile['ADMINSETUP_TEXT_WRITEACCESSERROR']                             = 'нет прав на запись';
$langFile['ADMINSETUP_TEXT_ISFOLDERERROR']                                = 'не является директорией';

// ---------- general Settings
$langFile['ADMINSETUP_GENERAL_error_save']                                = $langFile['ERROR_SAVE_SETTINGS'].$langFile['ERROR_SAVE_FILE'].'%sconfig/admin.config.php';

$langFile['ADMINSETUP_GENERAL_h1']                                        = 'Базовые настройки';

$langFile['ADMINSETUP_GENERAL_TEXT_DOCUMENTROOT']                         = 'DocumentRoot';
$langFile['ADMINSETUP_GENERAL_TOOLTIP_DOCUMENTROOT']                      = 'Пожалуйста, введите в корневом каталоге документов вручную.[br][span class=hint]например &quot;/server/user/htdocs&quot;[/span]';
$langFile['ADMINSETUP_GENERAL_field1']                                    = 'URL сайта';
$langFile['ADMINSETUP_GENERAL_field1_tip']                                = 'URL сайта определяется автоматически.';
$langFile['ADMINSETUP_GENERAL_field1_inputTip']                           = 'URL сайта определяется автоматически.';
$langFile['ADMINSETUP_GENERAL_field1_inputWarningText']                   = 'Пожалуйста, сохраните настройки!';
$langFile['ADMINSETUP_GENERAL_field2']                                    = 'Путь к feindura';
$langFile['ADMINSETUP_GENERAL_field2_tip']                                = 'Базовый путь определяется автоматически и сохраняется при первом сохранении настроек.';
$langFile['ADMINSETUP_GENERAL_field2_inputTip']                           = 'Путь будет добавлен автоматически';
$langFile['ADMINSETUP_GENERAL_field2_inputWarningText']                   = 'Пожалуйста, сохраните настройки!';
$langFile['ADMINSETUP_GENERAL_field8']                                    = 'Путь к сайту';
$langFile['ADMINSETUP_GENERAL_field8_tip']                                = '[strong]Абсолютный путь[/strong] расположения файлов сайта.[br][br][span class=hint]также могут содержать имена, например &quot;/website/index.php&quot;[/span]';
$langFile['ADMINSETUP_GENERAL_editfiles_additonal']                       = '[br][br]Файлы могут редактироваться в сеции Настройки сайта, (если выбраны соответсвующие Пользовательские настроки).[br][br]';
$langFile['ADMINSETUP_GENERAL_field5']                                    = 'Путь к файлам сайта';
$langFile['ADMINSETUP_GENERAL_field5_tip']                                = 'Здесь вы можете добавить путь к cайт конкретные файлы, которые должны быть доступны для редактирования в [span class=feinduraInline]fein[em]dura[/em][/span].'.$langFile['ADMINSETUP_GENERAL_editfiles_additonal'];
$langFile['ADMINSETUP_GENERAL_field6']                                    = 'Путь к файлам стилей';
$langFile['ADMINSETUP_GENERAL_field6_tip']                                = 'Здесь вы можете добавить путь к файлам стилей, которые должны быть доступны для редактирования в [span class=feinduraInline]fein[em]dura[/em][/span].'.$langFile['ADMINSETUP_GENERAL_editfiles_additonal'];
$langFile['ADMINSETUP_GENERAL_TEXT_PERMISSIONS']                          = 'Права для файлов и директорий';
$langFile['ADMINSETUP_GENERAL_TIP_PERMISSIONS']                           = 'Каждый файл или директория созданные [span class=feinduraInline]fein[em]dura[/em][/span] будут иметь указанные здесь права.';
$langFile['ADMINSETUP_TEXT_VARNAMEPAGE']                                  = 'Ном-дель URL страницы';
$langFile['ADMINSETUP_TEXT_VARNAMECATEGORY']                              = 'Ном-дель URL категории';
$langFile['ADMINSETUP_TEXT_VARNAMEMODUL']                                 = 'Ном-дель URL модуль';
$langFile['ADMINSETUP_TIP_VARNAME']                                       = 'Имя, которое будет использоваться в URL, чтобы связать страницы.';
$langFile['ADMINSETUP_TIP_EMPTYVARNAME']                                  = 'Если это поле пустым стандартное имя будет использоваться: ';
$langFile['ADMINSETUP_TEXT_TIMEZONE']                                     = 'Часовой пояс';
$langFile['ADMINSETUP_TIP_TIMEZONE']                                      = 'Используется только в [span class=feinduraInline]fein[em]dura[/em][/span] панели управления.';
$langFile['ADMINSETUP_GENERAL_PRETTYURL']                                 = 'Формат URL';
$langFile['ADMINSETUP_GENERAL_PRETTYURL_true']                            = 'Красивые URL&#145;ы';
$langFile['ADMINSETUP_GENERAL_PRETTYURL_true_example']                    = '/%s/category-name/example-page';
$langFile['ADMINSETUP_GENERAL_PRETTYURL_false']                           = 'URL с переменными';
$langFile['ADMINSETUP_GENERAL_PRETTYURL_false_example']                   = 'index.php?%s=1&%s=1';
$langFile['ADMINSETUP_GENERAL_PRETTYURL_tip']                             = 'Формат URL используется при формировании всех ссылок на сайте.[br][br]Красивые URL&#145;ы работают только если есть модуль [strong]Apache Server[/strong] [strong]mod_rewrite[/strong].[br][br][strong]ВНИМАНИЕ: С РУССКИМИ НАЗВАНИЯМИ СТРАНИЦ И КАТЕГОРИЙ Красивые URL&#145;ы НЕ РАБОТАЕТ (на данный момент)![/strong]';
$langFile['ADMINSETUP_GENERAL_PRETTYURL_warning']                         = 'ВНИМАНИЕ!::[span class=red]Если при использовании Красивые URL&#145;ы возникнут проблемы, вы должны удалить файл [strong].htaccess[/strong] из корня сайта.[/span]';

// ---------- PRETTY URL ERRORs
$langFile['ADMINSETUP_GENERAL_PRETTYURL_error_save']                      = '<b>Красивые URL&#145;ы</b> не могут быть активированы '.$langFile['ERROR_SAVE_FILE'].'/.htaccess';
$langFile['ADMINSETUP_GENERAL_PRETTYURL_error_modul']                     = '<b>Красивые URL&#145;ы</b> не могут быть активироываны, не найден модуль MOD_REWRITE';

// ---------- cache settings
$langFile['ADMINSETUP_TEXT_CACHE']                                        = 'Включить кэш';
$langFile['ADMINSETUP_TIP_CACHE']                                         = 'Если активный, все страницы будут кэшироваться. Это может семян на веб-сайте, но и приводит к не очень реальное содержание.[br][br][span class=hint] кэшироваться будет обновлена​​, при редактировании страницы.[/span]';
$langFile['ADMINSETUP_TEXT_CACHETIMEOUT']                                 = 'кэш тайм-аут';
$langFile['ADMINSETUP_TIP_CACHETIMEOUT']                                  = 'Показывает время, после которого кэш будет обновлен.';
$langFile['ADMINSETUP_HINT_CACHETIMEOUT']                                 = 'часов';

// ---------- editor Settings
$langFile['adminSetup_editorSettings_h1']                                 = 'Настройки визуального редактора';
$langFile['ADMINSETUP_TEXT_EDITOR_HTMLLAWED']                             = 'фильтровать HTML (использует <a href="http://www.bioinformatics.org/phplabware/internal_utilities/htmLawed/" target="_blank">htmlLawed</a>)';
$langFile['ADMINSETUP_TIP_EDITOR_HTMLLAWED']                              = 'Фильтровать HTML код перед сохранением (решает проблему если в коде имеется много вставок javascript).';
$langFile['ADMINSETUP_TEXT_EDITOR_SAFEHTML']                              = 'безопасный HTML (<a href="http://www.bioinformatics.org/phplabware/internal_utilities/htmLawed/htmLawed_README.htm#s3.6" target="_blank">подробней</a>)';
$langFile['ADMINSETUP_TIP_EDITOR_SAFEHTML']                               = 'HTML-код будет фильтроваться на максимально безопасном уровне. Это означает что, например теги &lt;applet&gt;,&lt;embed&gt;,&lt;embed&gt;,&lt;object&gt; и &lt;script&gt; будут вырезаны.';
$langFile['ADMINSETUP_TEXT_EDITOR_EDITORSTYLES']                          = 'активировать редактор стилей-Selection';
$langFile['ADMINSETUP_TIP_EDITOR_EDITORSTYLES']                           = 'Стили-Selection позволяет использовать пользовательские HTML-элементов в HTML-редактор.[br][br][span class=hint]Если эта опция включена, вы можете редактировать/создавать HTML-элементов ниже.[/span]';
$langFile['ADMINSETUP_TEXT_EDITOR_SNIPPETS']                              = 'Фрагменты кода активации';
$langFile['ADMINSETUP_TIP_EDITOR_SNIPPETS']                               = 'Разрешите поставить фрагменты кода на страницах.[br]Нажмите на иконку в HTML-редактор: [img class=icons src=library/thirdparty/ckeditor/plugins/feinduraSnippets/feinduraSnippetsIcon.png][br][br][span class=hint]If this option is activated, you can edit/create code snippets further down.Если эта опция включена, вы можете редактировать/создавать фрагменты кода ниже.[/span]';
$langFile['adminSetup_editorSettings_field1']                             = 'Режим клавиши ENTER';
$langFile['adminSetup_editorSettings_field1_hint']                        = 'SHIFT + ENTER вставляет &quot;%s&quot;';
$langFile['adminSetup_editorSettings_field1_tip']                         = 'Вставляет при нажатии ENTER выбранный тег.[br][br][span class=hint]'.$langFile['adminSetup_editorSettings_field1_hint'].'.[/span]';
$langFile['adminSetup_editorSettings_field3_inputTip']                    = 'Если не задано - атрибут ID не будет присвоен.';
$langFile['adminSetup_editorSettings_field4_inputTip']                    = 'Если не задано - атрибут class не будет присвоен.';

// THUMBNAILS Settings
$langFile['adminSetup_thumbnailSettings_h1']                              = 'Настройки миниатюр';

// ---------- styleFile Settings
$langFile['adminSetup_styleFileSettings_h1']                              = 'Редактирование секции Стили-Selection для визуального редактора';
$langFile['adminSetup_styleFileSettings_error_save']                      = '<b>Файл &quot;EditorStyles.js&quot; не удается сохранить.</b>'.$langFile['ERROR_SAVE_FILE'];

// ---------- editFiles Settings

$langFile['EDITFILESSETTINGS_TITLE_STYLESHEETS']                          = 'Редактировать файлы каскадных стилей';
$langFile['EDITFILESSETTINGS_TITLE_WEBSITEFILES']                         = 'Редактировать файлы сайта';
$langFile['EDITFILESSETTINGS_TITLE_SNIPPETS']                             = 'Редактировать фрагменты кода';
$langFile['EDITFILESSETTINGS_TEXT_NODIR']                                 = 'Не корректная директория!';
$langFile['EDITFILESSETTINGS_TEXT_CHOOSEFILE']                            = 'Выберите файл';
$langFile['EDITFILESSETTINGS_TEXT_CREATEFILE']                            = 'Создать новый файл';
$langFile['EDITFILESSETTINGS_TIP_CREATEFILE']                             = 'Если ввести название файла здесь - будет создан новый файл. [strong]Текущий файл не будет сохранен![/strong]';
$langFile['EDITFILESSETTINGS_TEXT_NOFILE']                                = 'Нет файлов';

$langFile['EDITFILESSETTINGS_TEXT_DELETEFILE']                            = 'Удалить этот файл';
$langFile['EDITFILESSETTINGS_TEXT_DELETEFILE_QUESTION']                   = 'Подтвердите удаление файла %s?'; // Kategorie "test" löschen?

$langFile['EDITFILESSETTINGS_ERROR_SAVEFILE']                             = '<b>Файл не может быть сохранен.</b>'.$langFile['ERROR_SAVE_FILE'];
$langFile['EDITFILESSETTINGS_ERROR_DELETEFILE']                           = '<b>Не удается сохранить файл.</b>'.$langFile['ERROR_SAVE_FILE'];

/*
* pageSetup.php
*/

// ---------- CATEGORY SETUP (on toolTips tooTips.js converts the "[" and "]" tags in the title attribute to "<" ">")
$langFile['PAGESETUP_PAGES_TIP_TAG']                                      = 'Tags can be used to create connections between pages (depending on the programming of the website)';

// ---------- page settings
$langFile['PAGESETUP_PAGES_TITLE_NONCATEGORYPAGES']                       = 'Страницы без категории';
$langFile['PAGESETUP_PAGES_TEXT_CREATEPAGES']                             = 'Создание/удаление страниц';
$langFile['PAGESETUP_PAGES_TIP_CREATEPAGES']                              = 'Дает пользователю возможность создавать и удалять страницы без категории.';
$langFile['PAGESETUP_PAGES_TEXT_UPLOADTHUMBNAILS']                        = 'Загрузка миниатюр';
$langFile['PAGESETUP_PAGES_TIP_UPLOADTHUMBNAILS']                         = 'Дает пользователю возможность загружать миниатюры для страниц без категории.';
$langFile['PAGESETUP_PAGES_TEXT_EDITTAGS']                                = 'Редактирование тегов';
$langFile['PAGESETUP_PAGES_TIP_EDITTAGS']                                 = 'Дает пользователю возможность редактировать теги у страниц без категории.[br]'.$langFile['PAGESETUP_PAGES_TIP_TAG'];
$langFile['PAGESETUP_PAGES_TEXT_ACTIVATEPLUGINS']                         = 'Активировать плагины';
$langFile['PAGESETUP_PAGES_TIP_ACTIVATEPLUGINS']                          = 'Дает пользователю возможность использовать плагины в страницах без категории.';

// ---------- category settings
$langFile['PAGESETUP_CATEGORY_TITLE_CATEGORIES']                          = 'Управление категориями';
$langFile['PAGESETUP_CATEGORY_TEXT_CATEGORYNAME']                         = 'Имя';

$langFile['PAGESETUP_CATEGORY_TEXT_CREATECATEGORY']                       = 'Создать новую директорию';
$langFile['PAGESETUP_CATEGORY_TEXT_CREATECATEGORY_CREATED']               = 'Новая категория создана';
$langFile['PAGESETUP_CATEGORY_TEXT_CREATECATEGORY_UNNAMED']               = 'Безымянная категория';

$langFile['PAGESETUP_CATEGORY_TEXT_DELETECATEGORY']                       = 'Удалить категорию';
$langFile['PAGESETUP_CATEGORY_TEXT_DELETECATEGORY_WARNING']               = 'ВНИМАНИЕ: Помимо категории будут удалены все страницы пренадлежащие этой категории!';
$langFile['PAGESETUP_CATEGORY_TEXT_DELETECATEGORY_DELETED']               = 'Категория удалена';
$langFile['PAGESETUP_CATEGORY_TEXT_DELETECATEGORY_QUESTION_START']        = 'Удалить категорию'; // Kategorie "test" löschen?
$langFile['PAGESETUP_CATEGORY_TEXT_DELETECATEGORY_QUESTION_END']          = '?';

$langFile['PAGESETUP_CATEGORY_TEXT_MOVECATEGORY_MOVED']                   = 'Переместить категорию';
$langFile['PAGESETUP_CATEGORY_TIP_MOVECATEGORY_UP']                       = 'Сдвинуть категорию вверх';
$langFile['PAGESETUP_CATEGORY_TIP_MOVECATEGORY_DOWN']                     = 'Сдвинуть категорию вниз';

$langFile['PAGESETUP_CATEGORY_ERROR_CREATECATEGORY']                      = '<b>Не удается создать категорию.</b>'.$langFile['ERROR_SAVE_FOLDER_PART1'].'%sconfig/'.$langFile['ERROR_FOLDER_PART2'];
$langFile['PAGESETUP_CATEGORY_ERROR_CREATEDIR']                           = '<b>Не удается создать директорию для новой категории.</b>'.$langFile['ERROR_SAVE_FOLDER_PART1'].'%spages/'.'&quot; ';
$langFile['PAGESETUP_CATEGORY_ERROR_DELETECATEGORY']                      = '<b>Не удается удалить категорию</b>'.$langFile['ERROR_SAVE_FILE'].'%sconfig/category.config.php';
$langFile['PAGESETUP_CATEGORY_ERROR_DELETEDIR']                           = '<b>Не удается удалить директорию категории.</b>'.$langFile['ERROR_SAVE_FOLDER_PART1'].'%spages/'.$langFile['ERROR_FOLDER_PART2'];
$langFile['PAGESETUP_CATEGORY_ERROR_SAVE']                                = $langFile['ERROR_SAVE_SETTINGS'].$langFile['ERROR_SAVE_FILE'].'%sconfig/category.config.php';


$langFile['PAGESETUP_CATEGORY_TITLE_ADVANCEDSETTINGS']                    = 'Продвинутые настройки';
$langFile['PAGESETUP_CATEGORY_HINT_ADVANCEDSETTINGS']                     = 'Если эти настройки буду заданы это изменит стандатрные настройки миниатюр и '.$langFile['adminSetup_editorSettings_h1'].' в <a href="?site=adminSetup">Основных настройках</a>.';

$langFile['PAGESETUP_CATEGORY_TIP_STYLESHEETS_EMPTY']                     = 'Если все поля пустые настройки стилей будут взяты из '.$langFile['adminSetup_editorSettings_h1'].'.';

$langFile['PAGESETUP_CATEGORY_TEXT_CATEGORYSTATUS']                       = 'Статус категории';
$langFile['PAGESETUP_CATEGORY_TIP_CATEGORYSTATUS']                        = 'Устанавливает видимость категории на сайте.';
$langFile['PAGESETUP_CATEGORY_TEXT_CREATEPAGES']                          = 'Создание/удаление страниц';
$langFile['PAGESETUP_CATEGORY_TIP_CREATEPAGES']                           = 'Дает пользователю возможность создавать и удалять страницы в этой категории.';
$langFile['PAGESETUP_CATEGORY_TEXT_UPLOADTHUMBNAILS']                     = 'Загрузка миниатюр';
$langFile['PAGESETUP_CATEGORY_TIP_UPLOADTHUMBNAILS']                      = 'Дает пользователю возможность загружать миниатюры для страниц в этой категории.';
$langFile['PAGESETUP_CATEGORY_TEXT_EDITTAGS']                             = 'Редактирование тегов';
$langFile['PAGESETUP_CATEGORY_TIP_EDITTAGS']                              = 'Дает пользователю возможность редактировать теги для страниц в этой категории.[br]'.$langFile['PAGESETUP_PAGES_TIP_TAG'];
$langFile['PAGESETUP_CATEGORY_TEXT_ACTIVATEPLUGINS']                      = 'Активные расширения';
$langFile['PAGESETUP_CATEGORY_TIP_ACTIVATEPLUGINS']                       = 'Дает пользователю возможность использовать выбранные расширения для страниц в этой категории.';

$langFile['PAGESETUP_TEXT_EDITPAGEDATE']                                  = 'Редактировать дату';
$langFile['PAGESETUP_TIP_EDITPAGEDATE']                                   = 'Дата страницы может быть использована для сортировки.';
$langFile['PAGESETUP_TEXT_PAGEDATERANGE']                                 = 'как период';

$langFile['PAGESETUP_TEXT_FEEDS']                                         = 'Включить xml-ленты';
$langFile['PAGESETUP_TIP_FEEDS']                                          = 'Включает выдачу xml-лент для категории в форматах: RSS 2.0 и Atom.';
$langFile['PAGESETUP_CATEGORY_TIP_FEEDS']                                 = 'Включает выдачу xml-лент для категории в форматах: RSS 2.0 и Atom.';

$langFile['PAGESETUP_TEXT_SUBCATEGORY']                                   = 'Редактировать подкатегории';
$langFile['PAGESETUP_TIP_SUBCATEGORY']                                    = 'Позволяет выбрать подкатегорию для каждой страницы.';

$langFile['PAGESETUP_TIP_SORTBYPAGEDATE']                                 = 'Сортировать страницы по дате';
$langFile['PAGESETUP_TIP_SORTBYDATE']                                     = 'Страницы созданные позже (более новые) будут выводится в списке [strong]вверху[/strong].[br][br][span class=hint]Деактивирует ручную сортировку.[/span]';

$langFile['PAGESETUP_TEXT_SORTMANUALLY']                                  = 'Ручная сотрировка';
$langFile['PAGESETUP_TIP_SORTMANUALLY']                                   = 'Последние созданные страницы [strong]вверху[/strong].';

$langFile['PAGESETUP_TEXT_SORTALPHABETICAL']                              = 'Сортировать по алфавиту';
$langFile['PAGESETUP_TIP_SORTALPHABETICAL']                               = '[span class=hint]Деактивирует ручную сортировку.[/span]';

$langFile['PAGESETUP_TEXT_SORTREVERSE']                                   = 'обратный порядок сортировки';
$langFile['PAGESETUP_TIP_SORTREVERSE']                                    = 'Включить обратный порядок сортировки (реверсивный).';


/*
* websiteSetup.php
*/

// ---------- WEBSITE SETUP (on toolTips tooTips.js converts the "[" and "]" tags in the tittle attribute to "<" ">")
$langFile['websiteSetup_websiteConfig_error_save']                        = $langFile['ERROR_SAVE_SETTINGS'].$langFile['ERROR_SAVE_FILE'].'%sconfig/website.config.php';

$langFile['websiteSetup_websiteConfig_h1']                                = 'Настройки сайта';
$langFile['websiteSetup_websiteConfig_field1']                            = 'Заголовок (title)';
$langFile['websiteSetup_websiteConfig_field1_tip']                        = 'Используется в теге <title> и некоторых элементах навигации.';
$langFile['websiteSetup_websiteConfig_field2']                            = 'Автор';
$langFile['websiteSetup_websiteConfig_field2_tip']                        = 'Информация о создателе в мета-теге publisher.';
$langFile['websiteSetup_websiteConfig_field3']                            = 'Копирайты';
$langFile['websiteSetup_websiteConfig_field3_tip']                        = 'Информация о владельце и лицензии в мета-теге copyright.';

$langFile['websiteSetup_websiteConfig_field4']                            = 'Ключевые слова (meta-keywords)';
$langFile['websiteSetup_websiteConfig_field4_tip']                        = 'Используются в мета-теге keywords.';
$langFile['websiteSetup_websiteConfig_field4_inputTip']                   = 'Ключевые слова должны быть разделены &quot;,&quot;::'.$langFile['TEXT_EXAMPLE'].':[br]слово1,слово2, и т.д.';
$langFile['websiteSetup_websiteConfig_field5']                            = 'Описание (meta-description)';
$langFile['websiteSetup_websiteConfig_field5_tip']                        = 'Используется в мета-теге description.';
$langFile['websiteSetup_websiteConfig_field5_inputTip']                   = 'Короткое описание не больше 2-5 строчек.';

$langFile['WEBSITESETUP_TITLE_PAGESETTINGS']                              = 'настройках настройки сайта';
$langFile['WEBSITESETUP_TEXT_MAINTENANCE']                                = 'Отключить сайта';
$langFile['WEBSITESETUP_TIP_MAINTENANCE']                                 = 'Показывает сообщение, а не на сайт, в котором говорится, что сайт в настоящее время редактируется.';
$langFile['WEBSITESETUP_TEXT_SITEMAPFILES']                               = 'Карта сайта Файлы создать (<a href="http://www.sitemaps.org/" target="_blank">детали</a>)';
$langFile['WEBSITESETUP_TIP_SITEMAPFILES']                                = 'Карта сайта файлы упростить поисковые системы для индексации сайта.';
$langFile['WEBSITESETUP_TEXT_VISITORTIMEZONE']                            = 'Получите Посетителй часовой пояс';
$langFile['WEBSITESETUP_TIP_VISITORTIMEZONE']                             = 'Постарайтесь, чтобы получить часовой пояс посетителя, для отображения времени раскрытия информации по местному времени из посетителей.[br][br][span class=hint]Этот сайт будет обновлен на первом посещении[/span].';
$langFile['WEBSITESETUP_TEXT_MULTILANGUAGEWEBSITE']                       = 'Мульти язык сайта';
$langFile['WEBSITESETUP_TEXT_MAINLANGUAGE']                               = 'Основной язык';
$langFile['WEBSITESETUP_TIP_MAINLANGUAGE']                                = 'Основной язык будет выбран, если нет соответствующего языка может быть определен автоматически.';
$langFile['WEBSITESETUP_TEXT_DATEFORMAT']                                 = 'Формат даты';
$langFile['WEBSITESETUP_TIP_DATEFORMAT']                                  = 'Который используется в веб-страницы.';


/*
* statisticSetup.php
*/

// ---------- STATISITC SETUP (on toolTips tooTips.js converts the "[" and "]" tags in the tittle attribute to "<" ">")
$langFile['STATISTICSSETUP_ERROR_SAVE']                                   = $langFile['ERROR_SAVE_SETTINGS'].$langFile['ERROR_SAVE_FILE'].'%sconfig/statistic.config.php';

$langFile['STATISTICSSETUP_TITLE_STATISTICSSETTINGS']                     = 'Настройки статистики';
$langFile['STATISTICSSETUP_TEXT_REFERERNUMBER']                           = 'Количество <b>источников переходов</b>';
$langFile['STATISTICSSETUP_TIP_REFERERNUMBER']                            = 'Количество источников переходов выводящихся в списке секции [strong]Статистика по страницам[/strong] в [strong]Сводке[/strong].';
$langFile['STATISTICSSETUP_TEXT_ACTIVITYNUMBER']                          = 'Количество <b>последних действий</b>';
$langFile['STATISTICSSETUP_TIP_ACTIVITYNUMBER']                           = 'Максимальное количество выводящихся в левом сайд-баре последних действий.';


$langFile['statisticSetup_clearStatistic_h1']                             = 'Обнулить статистику';
$langFile['statisticSetup_clearStatistics_websiteStatistic']              = 'Статистика сайта';
$langFile['statisticSetup_clearStatistics_websiteStatistic_tip']          = '[strong]Содержит[/strong][ul][li]Общее число посещений[/li][li]Статистика пауков/ботов[/li][li]Дата первого визита[/li][li]Дата последнего визита[/li][li]Статистика браузеров[/li][/ul]';
$langFile['statisticSetup_clearStatistics_pagesStatistic']                = 'Статистика по страницам';
$langFile['statisticSetup_clearStatistics_pagesStatistic_tip']            = '[strong]Содержит[/strong][ul][li]Число посещений страниц[/li][li]Дата первого визита страницы[/li][li]Дата последнего визита страницы[/li][li]Самые короткие визиты[/li][li]Самые продолжительные визиты[/li][li]Ключевые слова из поиска[/li][/ul]';
$langFile['statisticSetup_clearStatistics_pagesStaylengthStatistics']     = 'Только статистику продолжительности пребывания на странице';
$langFile['statisticSetup_clearStatistics_pagesStaylengthStatistics_tip'] = 'Удалить только статистику продолжительности просмотров всех страниц';
$langFile['statisticSetup_clearStatistics_refererLog']                    = 'Источники переходов'; // engl.: referer
$langFile['statisticSetup_clearStatistics_refererLog_tip']                = 'Данные об источниках переходов на сайт.';
$langFile['statisticSetup_clearStatistics_taskLog']                       = 'Статистика действий';
$langFile['statisticSetup_clearStatistics_taskLog_tip']                   = 'Все последние операции и действия совершенные в панели управления.';

$langFile['statisticSetup_clearStatistics_question_h1']                   = 'Уверены что хотите обнулить статистику?';

$langFile['statisticSetup_clearStatistic_pagesStatistics_error_read']     = 'Произошла общибка при удалении файла статистики.'.$langFile['ERROR_SAVE_FOLDER_PART1'].'%sstatistics/pages/'.$langFile['ERROR_FOLDER_PART2'];

/*
* userSetup.php
*/

$langFile['USERSETUP_h1']                                                 = 'Учетные записи';
$langFile['USERSETUP_userSelection']                                      = 'Пользователи';

$langFile['USERSETUP_createUser']                                         = 'Создание нового пользователя';
$langFile['USERSETUP_createUser_created']                                 = 'Новый пользователь создан';
$langFile['USERSETUP_createUser_unnamed']                                 = 'Безымянный пользователь';

$langFile['USERSETUP_deleteUser']                                         = 'Удалить пользователя';
$langFile['USERSETUP_deleteUser_deleted']                                 = 'Пользователь удален';

$langFile['USERSETUP_username']                                           = 'Логин';
$langFile['USERSETUP_username_missing']                                   = 'Не установлено логина.';
$langFile['USERSETUP_password']                                           = 'пароль';
$langFile['USERSETUP_password_change']                                    = 'Изменить пароль';
$langFile['USERSETUP_password_confirm']                                   = 'Подтверждение пароля';
$langFile['USERSETUP_password_confirm_wrong']                             = 'Пароли не совпадают.';
$langFile['USERSETUP_password_missing']                                   = 'Не установлен пароль.';
$langFile['USERSETUP_password_success']                                   = 'Пароль изменен!';
$langFile['USERSETUP_email']                                              = 'E-Mail';
$langFile['USERSETUP_email_tip']                                          = 'Если пользователь потеряет пароль, его возможно восстановить на email.';

$langFile['USERSETUP_admin']                                              = 'Администратор';
$langFile['USERSETUP_admin_tip']                                          = 'Наделить пользователя правами администратора.';

$langFile['USERSETUP_error_create']                                       = '<b> Пользователь не может быть создан.</b>'.$langFile['ERROR_SAVE_FILE'].'%sconfig/user.config.php';
$langFile['USERSETUP_error_save']                                         = $langFile['ERROR_SAVE_SETTINGS'].$langFile['ERROR_SAVE_FILE'].'%sconfig/user.config.php';

// ---------- USER PERMISSION
$langFile['USERSETUP_USERPERMISSIONS_TITLE']                              = 'Пользовательские настройки';
$langFile['USERSETUP_USERPERMISSIONS_TEXT_ACTIVATEWEBSITESETTINGS']       = 'Редактирование Настройки сайта';
$langFile['USERSETUP_USERPERMISSIONS_TEXT_EDITWEBSITEFILES']              = 'Редактирование файлов сайта в разделе <a href="index.php?site=websiteSetup">Настройки сайта</a>';
$langFile['USERSETUP_USERPERMISSIONS_TEXT_EDITSTYLESHEETS']               = 'Редактирование файлов стилей в разделе <a href="index.php?site=websiteSetup">Настройки сайта</a>';
$langFile['USERSETUP_USERPERMISSIONS_TEXT_EDITSNIPPETS']                  = 'Редактировать фрагменты кода в разделе <a href="index.php?site=websiteSetup">Настройки сайта</a>';
$langFile['USERSETUP_USERPERMISSIONS_TEXT_FILEMANAGER']                   = 'Включить файл-менеджер';
$langFile['USERSETUP_USERPERMISSIONS_TEXT_FRONTENDEDITING']               = 'Включить редактирование непосредственно на сайте';

$langFile['USERSETUP_USERPERMISSIONS_TEXT_USERINFORMATION']               = '<strong>Инфо-блок</strong> на странице <a href="?site=dashboard">'.$langFile['BUTTON_DASHBOARD'].'</a>';
$langFile['USERSETUP_USERPERMISSIONS_TIP_USERINFORMATION']                = 'Инфо-блок::Это короткий ифнормационный текст для пользователей который будет отображаться на странице '.$langFile['BUTTON_DASHBOARD'].'.';
$langFile['USERSETUP_USERPERMISSIONS_TIP_USERINFORMATION_NOINFO']         = 'Если у вас нет информации для пользователей - оставьте поле пустым.';

$langFile['USERSETUP_USERPERMISSIONS_TITLE_EDITABLECATEGORIES-PAGES']     = 'Выберите категорию и страницы которой пользователь должен иметь возможность редактировать<br>(Если ничего не выбрано, то все может быть отредактирован)';
$langFile['USERSETUP_USERPERMISSIONS_TEXT_CLEARSELECTION']                = 'Снять выделение';

/*
* editor.php
*/

// ---------- page info
$langFile['EDITOR_TITLE_CREATEPAGE']                                      = 'Создание новой страницы';
$langFile['EDITOR_TITLE_ADDLANGUAGE']                                     = 'Добавить язык &quot;%s&quot; на странице';
$langFile['EDITOR_pageinfo_lastsavedate']                                 = 'В последний раз редактировали';
$langFile['EDITOR_pageinfo_lastsaveauthor']                               = 'с';
$langFile['EDITOR_pageinfo_linktothispage']                               = 'Ссылка на страницу';
$langFile['EDITOR_pageinfo_id']                                           = 'ID страницы';
$langFile['EDITOR_pageinfo_id_tip']                                       = 'С этим ID страница хранится на сервере.';
$langFile['EDITOR_pageinfo_category']                                     = 'Категории';
$langFile['EDITOR_pageinfo_category_noCategory']                          = 'без категории';

$langFile['EDITOR_TEXT_CHOOSETEMPLATE']                                   = 'использование шаблонов';
$langFile['EDITOR_TEXT_TEMPALATECOPYADDITION']                            = 'скопировать';

$langFile['EDITOR_block_edited']                                          = 'изменены';
$langFile['EDITOR_pageNotSaved']                                          = 'не сохранено';

$langFile['EDITOR_EDITLINK']                                              = 'Изменить ссылку';

// ---------- page settings
$langFile['EDITOR_pagestatistics_h1']                                     = 'Статистика';

$langFile['EDITOR_pageSettings_title']                                    = 'Заголовок';
$langFile['EDITOR_pageSettings_title_tip']                                = 'Заголовок страницы, mожет содержать следующие теги HTML:[br]<a> <span> <em> <strong> <i> <b> <abbr> <code> <samp> <kbd> <var>';
$langFile['EDITOR_pageSettings_field1']                                   = 'Короткое описание';
$langFile['EDITOR_pageSettings_field1_inputTip']                          = 'Если пустое - будет использовано умолчательное значение из Настроек сайта.';
$langFile['EDITOR_pageSettings_field1_tip']                               = 'Используется в мета-теге description.[br][br][span class=hint]'.$langFile['EDITOR_pageSettings_field1_inputTip'].'[/span]';
$langFile['EDITOR_pageSettings_field2']                                   = 'Таги';
$langFile['EDITOR_pageSettings_field2_tip']                               = 'Ключевые слова для страницы.';
$langFile['EDITOR_pageSettings_field2_tip_inputTip']                      = 'Таги должны быть разделены &quot;,&quot; (запятая).';
$langFile['EDITOR_pageSettings_field3']                                   = 'Дата';
$langFile['EDITOR_pageSettings_field3_tip']                               = 'Дата может быть использована для сортировки страниц.';
$langFile['EDITOR_pageSettings_field4']                                   = 'Статус страницы';
$langFile['EDITOR_pageSettings_field4_tip']                               = '[strong]Только активная страница отображается на сайте![/strong]';

$langFile['EDITOR_PAGESETTINGS_NOPAGEDATE']                               = 'без даты';

$langFile['EDITOR_TEXT_SUBCATEGORY']                                      = 'подкатегория';
$langFile['EDITOR_TIP_SUBCATEGORY']                                       = 'Позволяет создавать подменю для этой страницы на сайте.';

$langFile['EDITOR_BUTTON_RESTORELASTSTATE']                               = 'Версия %s восстановление';
$langFile['EDITOR_MESSAGE_RESTOREDTOLASTSTATE']                           = 'Версия %s восстановлено.';

// ---------- page advanced settings
$langFile['EDITOR_advancedpageSettings_h1']                               = 'Страница конкретной HTML-редактор Настройка';

$langFile['EDITOR_advancedpageSettings_field1']                           = 'Индивидуальный файл стилей';
$langFile['EDITOR_advancedpageSettings_stylesheet_ifempty']               = 'Если поле пусто будут использованы настройки категории, если в настройках категории пусто - будут использованы стандартные стили.';

$langFile['EDITOR_htmleditor_hotkeys_h1']                                 = 'Горячие клавиши';
$langFile['EDITOR_htmleditor_hotkeys_field1']                             = 'выбрать все';
$langFile['EDITOR_htmleditor_hotkeys_field2']                             = 'копировать';
$langFile['EDITOR_htmleditor_hotkeys_field3']                             = 'вставить';
$langFile['EDITOR_htmleditor_hotkeys_field4']                             = 'вырезать';
$langFile['EDITOR_htmleditor_hotkeys_field5']                             = 'шаг назад';
$langFile['EDITOR_htmleditor_hotkeys_field6']                             = 'шаг вперед';
$langFile['EDITOR_htmleditor_hotkeys_field7']                             = 'ссылки';
$langFile['EDITOR_htmleditor_hotkeys_field8']                             = 'жирный';
$langFile['EDITOR_htmleditor_hotkeys_field9']                             = 'наклонный';
$langFile['EDITOR_htmleditor_hotkeys_field10']                            = 'подчеркнутый';
$langFile['EDITOR_htmleditor_hotkeys_or']                                 = 'или';

$langFile['EDITOR_savepage_error_save']                                   .= $langFile['ERROR_SAVE_FOLDER_PART1'].'%spages/'.$langFile['ERROR_FOLDER_PART2'];// also in en.shared.php

// ---------- plugin settings
$langFile['EDITOR_pluginSettings_h1']                                     = 'Добавить плагинов';
$langFile['EDITOR_TEXT_EDITPLUGINSINEDITOR']                              = 'После того как вы активировали плагин, наведите курсор мыши на плагин, чтобы иметь возможность перетащить его в редакторе, или разместить его непосредственно в редакторе при помощи значка %s.';
$langFile['EDITOR_MESSAGE_PLUGINSSAVED']                                  = '<div class="alert alert-success">Плагины спасены!</div>';//<div class="alert">Нажмите на плагин для редактирования свойств.</div>';
$langFile['EDITOR_TIP_DRAGPLUGIN']                                        = 'Перетащите модуль в редакторе.';

/*
* unsavedPage.php
*/

$langFile['UNSAVEDPAGE_QUESTION_CONTINUE']                                = 'Страница отредактирована!<br><span class="brown">Будете ли вы продолжать?</span>';

/*
* deletePage.php
*/

// ---------- DELETE PAGE
$langFile['deletePage_question_part1']                                    = 'Подтверждаете удаление страницы';
$langFile['deletePage_question_part2']                                    = '?';

$langFile['deletePage_notexisting_part1']                                 = 'Страницы';
$langFile['deletePage_notexisting_part2']                                 = 'не существует';

$langFile['deletePage_finish_error']                                      = 'ОШИБКА: Страница не может быть удалена!';

/*
* deletePageLanguage.php
*/

// ---------- DELETE PAGE LANGUAGE

$langFile['WINDOWBOX_TEXT_DELETEPAGELANGUAGE_QUESTION']                   = 'Вы действительно хотите удалить язык &quot;%s&quot; на этой странице?';


/*
* addPageLanguage.php
*/

// ---------- ADD PAGE LANGUAGE

$langFile['WINDOWBOX_TEXT_ADDPAGE_SELECTLANGUAGE']                        = 'Выберите язык';


/*
* deletewebsiteLanguages.php
*/

// ---------- DELETE WEBSITE LANGUAGES

$langFile['WINDOWBOX_TITLE_DELETEWEBSITELANGUAGES_QUESTION']              = 'Следующих языках будут удалены со всех страниц!<br>&quot;%s&quot;';
$langFile['WINDOWBOX_TEXT_DELETEWEBSITELANGUAGES_QUESTION']               = 'Мульти язык сайта была отключена!<br>Все страницы будет установлен в бывшей основной язык (<b>%s</b>).';


/*
* deletePageThumbnail.php
*/

// ---------- PAGE THUMBNAIL DELETE
$langFile['PAGETHUMBNAIL_TEXT_DELETE_QUESTION_START']                     = 'Подтверждаете удаление миниатюры для страницы';
$langFile['PAGETHUMBNAIL_TEXT_DELETE_QUESTION_END']                       = '?';
$langFile['PAGETHUMBNAIL_ERROR_DELETE']                                   = 'ОШИБКА: миниатюра не может быть удалена!';


/*
* uploadPageThumbnail.php
*/

// ---------- PAGE THUMBNAIL UPLOAD
$langFile['pagethumbnail_h1_part1']                                       = 'Загрузить миниатюру к';
$langFile['pagethumbnail_h1_part2']                                       = '';
$langFile['pagethumbnail_field1']                                         = 'Выбор картинки';

$langFile['pagethumbnail_thumbinfo_formats']                              = 'Допустимы следующие форматы'; //<br><b>JPG</b>, <b>JPEG</b>, <b>GIF</b>, <b>PNG</b>
$langFile['pagethumbnail_thumbinfo_filesize']                             = 'максимальный размер';
$langFile['pagethumbnail_thumbinfo_standardthumbsize']                    = 'Стандартный размер';

$langFile['pagethumbnail_thumbsize_h1']                                   = 'Задать размер в ручную';
$langFile['pagethumbnail_thumbsize_width']                                = 'Ширина';
$langFile['pagethumbnail_thumbsize_height']                               = 'Высота';

$langFile['pagethumbnail_submit_tip']                                     = 'Загрузка картинки';

$langFile['PAGETHUMBNAIL_ERROR_nofile']                                   = 'Вы не выбрали файл.';
$langFile['PAGETHUMBNAIL_ERROR_nouploadedfile']                           = 'Файлы не загружены.';
$langFile['PAGETHUMBNAIL_ERROR_filesize']                                 = 'Размер загружаемого изображения превышает допустимый.<br>Допустимый объем файла';
$langFile['PAGETHUMBNAIL_ERROR_wrongformat']                              = 'Формат выбранного файла не поддерживается';
$langFile['PAGETHUMBNAIL_ERROR_NODIR_START']                              = 'Директория с миниатюрами'; // The thumbnail-folder..
$langFile['PAGETHUMBNAIL_ERROR_NODIR_END']                                = 'не существует.';
$langFile['PAGETHUMBNAIL_ERROR_CREATEDIR_END']                            = 'не создается.';
$langFile['PAGETHUMBNAIL_ERROR_COULDNTMOVEFILE']                          = 'Не удается переместить загруженное изображение в директорию с миниатюрами %s.';
$langFile['PAGETHUMBNAIL_ERROR_CHANGEIMAGESIZE']                          = 'Не удается изменить размер изображения.';
$langFile['PAGETHUMBNAIL_ERROR_deleteoldfile']                            = 'Не удается удалить старую миниатюру.';
$langFile['PAGETHUMBNAIL_TEXT_fileexists']                                = 'Изображение с таким именем файла уже есть на сервере.<br>Файл переименован в';
$langFile['PAGETHUMBNAIL_TEXT_finish']                                    = 'Изображение успешно загружено.';

// -> BACKUP

$langFile['BACKUP_TITLE_BACKUP']                                          = 'Резервная копия';
$langFile['BACKUP_TITLE_RESTORE']                                         = 'Восстановить';

$langFile['BACKUP_TITLE_RESTORE_FROMFILES']                               = 'Выбрать существующую резервную копию';
$langFile['BACKUP_TITLE_RESTORE_FROMUPLOAD']                              = 'Загрузить файл резервной копии';

$langFile['BACKUP_TEXT_RESTORE_BACKUPBEFORERESTORE']                      = 'Создайте резервную копию перед восстановлением!';

$langFile['BACKUP_BUTTON_DOWNLOAD']                                       = 'создать резервную копию';
$langFile['BACKUP_TEXT_BACKUP']                                           = 'Резервная копия упаковывается в <code>.zip</code> архив включая все файлы из директорий <span class="blue">"pages","config"</span> и <span class="blue">"statistic"</span>.<br>Директория <span class="blue">"upload"</span> не упаковывается.';
$langFile['BACKUP_TEXT_RESTORE']                                          = '<p>Выберите <span class="feinduraName"><span>fein</span>dura</span> резервную копию, для возвращения к предыдущему состоянию.</p><div class="alert"><strong>намек</strong> До восстановления рекомендуем создать новую резервную копию.</div>';
$langFile['BACKUP_TOOLTIP_DELETE']                                        = 'Удалить резервную копию';
$langFile['BACKUP_TEXT_DELETE_QUESTION']                                  = 'Удалить %s?'; // really delete backup 2010-11-05 15:03?

$langFile['BACKUP_TITLE_LASTBACKUPS']                                     = 'Скачать резервную копию';
$langFile['BACKUP_TEXT_NOBACKUP']                                         = 'Резервных копий не создано.';

$langFile['BACKUP_ERROR_FILENOTFOUND']                                    = 'Файл резервной копии не найден:';
$langFile['BACKUP_ERROR_NORESTROEFILE']                                   = 'Не выбрано файла резервной копии для восстановления.';
$langFile['BACKUP_ERROR_DELETE']                                          = 'Не удается удалить резервную копию!';


// -> ADDONS

$langFile['ADDONS_TITLE_ADDON']                                           = 'Выберите <span class="feinduraInline">fein<em>dura</em></span> Add-on';
$langFile['ADDONS_TEXT_AUTHOR']                                           = 'Автор';
$langFile['ADDONS_TEXT_WEBSITE']                                          = 'Сайт';
$langFile['ADDONS_TEXT_VERSION']                                          = 'Версия';
$langFile['ADDONS_TEXT_REQUIREMENTS']                                     = 'Требование';


// -> UPDATE

$langFile['UPDATE_TITLE']                                                 = 'Содержание должно быть обновлено';
$langFile['UPDATE_TEXT_CHECKPATHS']                                       = 'Убедитесь, что следующие пути верны, прежде чем обновлять.';
$langFile['UPDATE_TEXT_BASEPATH']                                         = 'Путь к <span class="feinduraInline">fein<em>dura</em></span>';
$langFile['UPDATE_TEXT_WEBSITEPATH']                                      = 'Сайт путь';
$langFile['UPDATE_TEXT_SUCCESS']                                          = 'Содержимое успешно обновлена!';
$langFile['UPDATE_BUTTON_UPDATE']                                         = 'ОБНОВЛЕНИЕ';
$langFile['UPDATE_ERROR_MOVEUPLOADFOLDER']                                = 'Загрузить папки не могут быть перемещены! Пожалуйста, переместите папку "%s" вручную "your_feindura_folder/upload/".';
$langFile['UPDATE_ERROR_MOVEPAGESFOLDER']                                 = 'Страницы не может быть скопирован! Пожалуйста, переместите папку "%s" вручную "your_feindura_folder/pages/".';
$langFile['UPDATE_ERROR_SAVEADMINCONFIG']                                 = 'Параметры администратора не может быть обновлен.';
$langFile['UPDATE_ERROR_SAVECATEGORYCONFIG']                              = 'Категория параметры не могут быть обновлены.';
$langFile['UPDATE_ERROR_SAVEUSERCONFIG']                                  = 'Настройки пользователя не может быть обновлен.';
$langFile['UPDATE_ERROR_SAVEWEBSITECONFIG']                               = 'Настройки сайта не может быть обновлен.';
$langFile['UPDATE_ERROR_SAVEPAGES']                                       = 'Страницы не могут быть обновлены.';
$langFile['UPDATE_ERROR_CLEARACTIVITYLOG']                                = 'Деятельность журнала не могут быть удалены.';
$langFile['UPDATE_ERROR_SAVEWEBSITESTATISTICS']                           = 'Статистика сайта не может быть обновлен.';
$langFile['UPDATE_ERROR_SAVEREFERERLOG']                                  = 'Referer Вход не может быть обновлен.';
$langFile['UPDATE_ERROR_DELETEOLDFILES']                                  = 'Не удалось удалить старые файлы и папки, <br> Пожалуйста, проверьте эти файлы и папки и удалить их вручную:';
$langFile['UPDATE_ERROR_RENAMESTATISTICSFOLDER']                          = 'Couldn\'t rename the "feinduraFolder/statistic" folder "feinduraFolder/statistic<strong>s</strong>, please rename it manually!"';

// -----------------------------------------------------------------------------------------------
// RETURN ****************************************************************************************
// -----------------------------------------------------------------------------------------------
return $langFile;
