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
 *    - TOOLTIP
 *
 * need a RETURN $langFile; at the END
 */

// -> LOGIN <-

$langFile['LOGIN_INPUT_USERNAME']                                         = 'Логин';
$langFile['LOGIN_INPUT_PASSWORD']                                         = 'Пароль';
$langFile['LOGIN_BUTTON_LOGIN']                                           = 'ВОЙТИ';
$langFile['LOGIN_TEXT_COOKIESNEEDED']                                     = 'Cookie должны быть включены';

$langFile['LOGIN_LINK_FORGOTPASSWORD']                                    = 'Забыли пароль?';
$langFile['LOGIN_LINK_BACKTOLOGIN']                                       = 'к форме входа';
$langFile['LOGIN_BUTTON_SENDNEWPASSWORD']                                 = 'ВЫСЛАТЬ';
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

$langFile['DATE_YMD']                                                     = 'YYYY-MM-DD';
$langFile['DATE_DMY']                                                     = 'DD.MM.YYYY';
$langFile['DATE_MDY']                                                     = 'MM/DD/YYYY';
$langFile['CATEGORIES_TEXT_NONCATEGORY']                                  = 'Страницы';
$langFile['CATEGORIES_TOOLTIP_NONCATEGORY']                               = 'Страницы без категории';
$langFile['TEXT_EXAMPLE']                                                 = 'Пример';

$langFile['HEADER_BUTTON_GOTOWEBSITE_FRONTENDEDITING']                    = 'Редактировать на сайте::Нажмите что бы редактировать страницы на сайте.';

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
$langFile['PATHS_TOOLTIP_ABSOLUTE']                                       = 'Абсолютный путь::Абсолютного пути URI, значит, относительно к Document Root.';
$langFile['PATHS_TOOLTIP_RELATIVE']                                       = 'Относительный путь::Относительный путь URI, значит, по отношению к текущему документу.';

// STATISTICS
$langFile['STATISTICS_TITLE_BROWSERCHART']                                = 'Браузеры используемые посетителями';
$langFile['STATISTICS_TEXT_ROBOTCOUNT']                                   = 'Пауки & боты';
$langFile['STATISTICS_TOOLTIP_ROBOTCOUNT']                                = 'Пауки & боты::Пауки или роботы индексирующие и проверяющие сайт.';

$langFile['STATISTICS_TEXT_SEARCHWORD_PART1']                             = 'пришло'; // "exampleword" led 20 times to this website
$langFile['STATISTICS_TEXT_SEARCHWORD_PART2']                             = 'раз на сайт';
$langFile['STATISTICS_TOOLTIP_SEARCHWORD']                                = 'Нажмите для поиска слова на странице.';

$langFile['STATISTICS_TEXT_VISITORCOUNT']                                 = 'посетителей';
$langFile['STATISTICS_TEXT_CURRENTVISITORS']                              = 'текущие посетители';
$langFile['STATISTICS_TEXT_LASTACTIVITY']                                 = 'последняя активность';

$langFile['STATISTICS_TITLE_PAGESTATISTICS']                              = 'Статистика по страницам';

$langFile['STATISTICS_TEXT_VISITTIME_MAX']                                = 'самые продолжительные визиты';
$langFile['STATISTICS_TEXT_VISITTIME_MIN']                                = 'самые короткие визиты';
$langFile['STATISTICS_TEXT_FIRSTVISIT']                                   = 'первое посещение';
$langFile['STATISTICS_TEXT_LASTVISIT']                                    = 'последнее посещение';
$langFile['STATISTICS_TEXT_NOVISIT']                                      = 'Еще никто не посещал сайт.';
$langFile['STATISTICS_TEXT_SEARCHWORD_DESCRIPTION']                       = 'Ключевые слова по которым приходят из
<a href                                                                   ="http://www.google.de">Google</a>,
<a href                                                                   ="http://www.yahoo.de">Yahoo</a> или
<a href                                                                   ="http://www.bing.com">Bing (MSN)</a> на сайт.';

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
$langFile['LOG_PAGE_MOVEDINCATEGORY_CATEGORY']                            = 'в категории'; // Example Page in Category
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

// USER LIST 630
$langFile['USER_TEXT_NOUSER']                                             = 'Нет пользователей';
$langFile['USER_TEXT_CURRENTUSER']                                        = 'Вы зашли под этим пользователем';
$langFile['USER_TEXT_USERSONLINE']                                        = 'Этот пользователь авторизовался::Последние действия';

$langFile['LOGO_TEXT']                                                    = 'Версия';
$langFile['txt_logo_gotowebsite']                                         = 'Нажмите что бы перейти на сайт.';
$langFile['LOADING_TEXT_LOAD']                                            = 'Загрузка страницы...';

// CKEDITOR transport
$langFile['CKEDITOR_TITLE_LINKS']                                         = 'feindura страницы';


// -> BUTTON TEXTS

// MAIN MENU
$langFile['BUTTON_DASHBOARD']                                             = 'Сводка';
$langFile['BUTTON_PAGES']                                                 = 'Страницы';
$langFile['BUTTON_ADDONS']                                                = 'Расширения';
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

// OTHER BUTTONS
$langFile['BUTTON_UP']                                                    = 'Вверх';


// -> GENERAL ERROR TEXTS
$langFile['ERROR_SAVE_SETTINGS']                                          = '<b>Не удается сохранить настройки</b>';
$langFile['ERROR_SAVE_FILE']                                              = '<br><br>Пожалуйста проверьте права на чтение и запись для файла: ';

$langFile['ERROR_READ_FOLDER_PART1']                                      = '<br><br>Пожалуйста проверьте права на чтение для файла&quot;';
$langFile['ERROR_SAVE_FOLDER_PART1']                                      = '<br><br>Пожалуйста проверьте права на запись для файла&quot;';

$langFile['ERROR_FOLDER_PART2']                                           = '&quot; Дириктория, это поддиректория и файлы.';

// -> WARNINGS
$langFile['WARNING_TITLE_STARTPAGE']                                      = 'Главная страница не установлена!';
$langFile['WARNING_TEXT_STARTPAGE']                                       = 'Пожалуйста установите главную страницу.<br>Пройдите к <a href="?site=pages">'.$langFile['BUTTON_PAGES'].'</a> и выберите <span class="startPageIcon"></span> иконку для назначения страницы.';

$langFile['WARNING_TITLE_DOCUMENTROOT']                                   = 'Ваш Document Root не удается обнаружить автоматически!';
$langFile['WARNING_TEXT_DOCUMENTROOT']                                    = 'Для корректной установки Document Root пройдите в <a href="?site=adminSetup#adminSettings">Основные настройки</a> и установите &quot;Реальный путь feindura&quot;.';

$langFile['WARNING_TITLE_BASEPATH']                                       = '<span class="logoname">fein<span>dura</span></span> не настроена!';
$langFile['WARNING_TEXT_BASEPATH']                                        = '<i>Базовый путь</i> неверный, установите базовый путь на странице Основные настройки - Базовые настройки.';

$langFile['WARNING_TITLE_JAVASCRIPT']                                     = 'Включите Javascript!';
// no <p> tag on the start and the end, its already in the dashboard.php
$langFile['WARNING_TEXT_JAVASCRIPT']                                      = '<strong>Для полноценного использования <span class="logoname">fein<span>dura</span></span> необходимо включить Javascript!</strong></p>';

$langFile['DASHBOARD_TITLE_IEWARNING']                                    = '<span class="logoname">fein<span>dura</span></span> не предназначена для устаревших версий Internet Explorers';
$langFile['DASHBOARD_TEXT_IEWARNING']                                     = 'Для нормального использования <span class="logoname">fein<span>dura</span></span> CMS вам необходимо использовать хотя бы Internet Explorer 8.<br><br>Пожалуйста установите новую версию Internet Explorer,<br> или <a href="http://www.google.com/chromeframe" target="_blank">Google Chrome Frame Plugin</a> для Internet Explorer,<br>или установите альтернативный браузер - <a href="http://www.mozilla.org/firefox/">Firefox</a> либо <a href="http://www.google.com/chrome/">Chrome</a>.';

$langFile['GENERAL_TEXT_CURRENTLYEDITED']                                 = 'Страница в данный момент редактируется...';

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
$langFile['DASHBOARD_TITLE_USERINFO']                                     = 'Карточка пользователя';

$langFile['DASHBOARD_TITLE_WELCOME']                                      = 'Добро пожаловать в панель управления <span class="logoname">fein<span>dura</span></span>,<br> превосходной системы управления контентом :)';
$langFile['DASHBOARD_TEXT_WELCOME']                                       = 'CMS <span class="logoname">fein<span>dura</span></span> основана на принципе хранения <span class="toolTip" title="flat file::Принцип хранения данных в файлах (использование ресурсов файловой системы), противопостовляется реляционным базам данных типа Mysql.">flat file</span>, т.е. использует файлы в качестве базы данных.';

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
$langFile['SORTABLEPAGELIST_headText2']                                   = 'Редактировалось';
$langFile['SORTABLEPAGELIST_headText3']                                   = 'Визитов';
$langFile['SORTABLEPAGELIST_headText4']                                   = 'Статус';
$langFile['SORTABLEPAGELIST_headText5']                                   = 'Операции';

$langFile['SORTABLEPAGELIST_TIP_PAGEDATE']                                = 'Дата';
$langFile['SORTABLEPAGELIST_TIP_TAGS']                                    = 'Таги';
$langFile['SORTABLEPAGELIST_TIP_LOCALIZATION']                            = 'Языки';

$langFile['SORTABLEPAGELIST_TIP_SORTALPHABETICAL']                        = 'сортировать по алфавиту';
$langFile['SORTABLEPAGELIST_TIP_SORTBYPAGEDATE']                          = 'сортировать по дате';

$langFile['SORTABLEPAGELIST_functions_editPage']                          = 'Редактировать';

$langFile['SORTABLEPAGELIST_changeStatus_linkPage']                       = 'Нажмите что бы изменить статус страницы.';
$langFile['SORTABLEPAGELIST_changeStatus_linkCategory']                   = 'Нажмите что бы изменить статус категории';

$langFile['SORTABLEPAGELIST_TOOLTIP_LANGUAGEMISSING']                     = 'Отсутствует языках';

$langFile['file_error_read']                                              = '<b>Не удается прочесть страницу.</b>'.$langFile['ERROR_READ_FOLDER_PART1'].'%spages/'.$langFile['ERROR_FOLDER_PART2'];
$langFile['SORTABLEPAGELIST_setStartPage_error_save']                     .= $langFile['ERROR_SAVE_FILE'].' &quot;%sconfig/website.config.php&quot;'; // also in en.shared.php
$langFile['SORTABLEPAGELIST_changeStatusPage_error_save']                 = '<b>Не удается изменить статус страницы.</b>'.$langFile['ERROR_SAVE_FOLDER_PART1'].'%spages/'.$langFile['ERROR_FOLDER_PART2'];
$langFile['SORTABLEPAGELIST_changeStatusCategory_error_save']             = '<b>Не удается изменить статус категории.</b>'.$langFile['ERROR_SAVE_FOLDER_PART1'].'%spages/'.$langFile['ERROR_FOLDER_PART2'];

$langFile['SORTABLEPAGELIST_info']                                        = 'Вы можете менять порядок <b>сортировки</b> используя принцип <b>Нажми & Тащи</b> :)';
$langFile['SORTABLEPAGELIST_save']                                        = 'Сохранение сортировки ...';
$langFile['SORTABLEPAGELIST_save_finished']                               = 'Порядок сортировки изменен!';
$langFile['SORTABLEPAGELIST_error_save']                                  = '<b>Не удается сохранить страницу.</b>'.$langFile['ERROR_SAVE_FOLDER_PART1'].'%spages/'.$langFile['ERROR_FOLDER_PART2'];
$langFile['SORTABLEPAGELIST_error_read']                                  = '<b>Страницы не читаются!</b>'.$langFile['ERROR_READ_FOLDER_PART1'].'%spages/'.$langFile['ERROR_FOLDER_PART2'];
$langFile['SORTABLEPAGELIST_error_move']                                  = '<b>Не удается переместить страницу в новую категорию.</b>'.$langFile['ERROR_SAVE_FOLDER_PART1'].'%spages/'.$langFile['ERROR_FOLDER_PART2'];
$langFile['SORTABLEPAGELIST_categoryEmpty']                               = 'Нет страниц';

// ---------- FORMULAR
$langFile['FORM_BUTTON_SUBMIT']                                           = 'Сохранить';
$langFile['FORM_BUTTON_CANCEL']                                           = 'Сбросить все поля';


/*
* adminSetup.php
*/

// ---------- ADMIN SETUP (on toolTips tooTips.js converts the "[" and "]" tags in the title attribute to "<" ">")
$langFile['ADMINSETUP_TEXT_VERSION']                                      = '<span class="logoname">fein<span>dura</span></span> версия';
$langFile['ADMINSETUP_TEXT_PHPVERSION']                                   = 'PHP версия';
$langFile['ADMINSETUP_TITLE_DOCUMENTROOT']                                = ' Document Root';

$langFile['ADMINSETUP_TITLE_ERROR']                                       = 'Произошли ошибки';
$langFile['ADMINSETUP_TOOLTIP_WRITEACCESSERROR']                          = 'Для директорий и файлов необходимо установить права %o';

$langFile['ADMINSETUP_TEXT_WRITEACCESSERROR']                             = 'нет прав на запись';
$langFile['ADMINSETUP_TEXT_ISFOLDERERROR']                                = 'не является директорией';

// ---------- general Settings
$langFile['ADMINSETUP_GENERAL_error_save']                                = $langFile['ERROR_SAVE_SETTINGS'].$langFile['ERROR_SAVE_FILE'].'%sconfig/admin.config.php';

$langFile['ADMINSETUP_GENERAL_h1']                                        = 'Базовые настройки';

$langFile['ADMINSETUP_GENERAL_field1']                                    = 'URL сайта';
$langFile['ADMINSETUP_GENERAL_field1_tip']                                = 'URL сайта определяется автоматически.';
$langFile['ADMINSETUP_GENERAL_field1_inputTip']                           = 'URL сайта определяется автоматически.';
$langFile['ADMINSETUP_GENERAL_field1_inputWarningText']                   = 'Пожалуйста, сохраните настройки!';
$langFile['ADMINSETUP_GENERAL_field2']                                    = 'Путь к feindura';
$langFile['ADMINSETUP_GENERAL_field2_tip']                                = 'Базовый путь определяется автоматически и сохраняется при первом сохранении настроек.';
$langFile['ADMINSETUP_GENERAL_field2_inputTip']                           = 'Путь будет добавлен автоматически';
$langFile['ADMINSETUP_GENERAL_field2_inputWarningText']                   = 'Пожалуйста, сохраните настройки!';
$langFile['ADMINSETUP_GENERAL_TEXT_REALBASEPATH']                         = 'Реальный путь к feindura';
$langFile['ADMINSETUP_GENERAL_TOOLTIP_REALBASEPATH']                      = 'Реальный путь к CMS [span class=logoname]fein[span]dura[/span][/span] относительно Document Root.';
$langFile['ADMINSETUP_GENERAL_EXAMPLE_REALBASEPATH']                      = '<b>Пример</b> &quot;/cms/&quot;';
$langFile['ADMINSETUP_GENERAL_field8']                                    = 'Путь к сайту';
$langFile['ADMINSETUP_GENERAL_field8_tip']                                = '[b]Абсолютный путь[/b] расположения файлов сайта.';
$langFile['ADMINSETUP_GENERAL_field4']                                    = 'Путь для загрузи файлов';
$langFile['ADMINSETUP_GENERAL_field4_tip']                                = 'Файлы вроде иллюстраций, изображений, флеш-анимациии другие будут закачиваться по этому адресу.';
$langFile['ADMINSETUP_GENERAL_editfiles_additonal']                       = '[br][br]Файлы могут редактироваться в сеции Настройки сайта, (если выбраны соответсвующие Пользовательские настроки).[br][br]';
$langFile['ADMINSETUP_GENERAL_field5']                                    = 'Путь к файлам сайта';
$langFile['ADMINSETUP_GENERAL_field5_tip']                                = 'Путь к файлам сайта. Для использования многоязычности.'.$langFile['ADMINSETUP_GENERAL_editfiles_additonal'];
$langFile['ADMINSETUP_GENERAL_field6']                                    = 'Путь к файлам стилей';
$langFile['ADMINSETUP_GENERAL_field6_tip']                                = '[b]Абсолютный путь[/b] расположения файлов каскадных стилей. Они так же могут создаваться пользователями.'.$langFile['ADMINSETUP_GENERAL_editfiles_additonal'];
$langFile['ADMINSETUP_GENERAL_TEXT_PERMISSIONS']                          = 'Права для файлов и директорий';
$langFile['ADMINSETUP_GENERAL_TIP_PERMISSIONS']                           = 'Каждый файл или директория созданные [span class=logoname]fein[span]dura[/span][/span] будут иметь указанные здесь права.';
$langFile['ADMINSETUP_GENERAL_varName_ifempty']                           = 'Если поле пусто - будет использовано стандарное имя GET-перемнной: ';
$langFile['ADMINSETUP_GENERAL_varName1']                                  = 'Переменная для страниц';
$langFile['ADMINSETUP_GENERAL_varName1_inputTip']                         = $langFile['ADMINSETUP_GENERAL_varName_ifempty'].'&quot;[b]page[/b]&quot;';
$langFile['ADMINSETUP_GENERAL_varName2']                                  = 'Переменная для категорий';
$langFile['ADMINSETUP_GENERAL_varName2_inputTip']                         = $langFile['ADMINSETUP_GENERAL_varName_ifempty'].'&quot;[b]category[/b]&quot;';
$langFile['ADMINSETUP_GENERAL_varName3']                                  = 'Переменная для модулей';
$langFile['ADMINSETUP_GENERAL_varName3_inputTip']                         = $langFile['ADMINSETUP_GENERAL_varName_ifempty'].'&quot;[b]modul[/b]&quot;';
$langFile['ADMINSETUP_GENERAL_varName_tip']                               = 'Имя GET-переменной которая будет использоваться для формирования ссылки.';
$langFile['ADMINSETUP_GENERAL_field7']                                    = 'Формат даты';
$langFile['ADMINSETUP_GENERAL_field7_tip']                                = 'Используется в [span class=logoname]fein[span]dura[/span][/span] и на сайте.';
$langFile['ADMINSETUP_TEXT_TIMEZONE']                                     = 'Часовой пояс';
$langFile['ADMINSETUP_TIP_TIMEZONE']                                      = 'Используется только в [span class=logoname]fein[span]dura[/span][/span] панели управления.';
$langFile['ADMINSETUP_GENERAL_speakingUrl']                               = 'Формат URL';
$langFile['ADMINSETUP_GENERAL_speakingUrl_true']                          = 'ЧПУ';
$langFile['ADMINSETUP_GENERAL_speakingUrl_true_example']                  = '/category/category-name/example-page';
$langFile['ADMINSETUP_GENERAL_speakingUrl_false']                         = 'URL с переменными';
$langFile['ADMINSETUP_GENERAL_speakingUrl_false_example']                 = 'index.php?%s=1&%s=1';
$langFile['ADMINSETUP_GENERAL_speakingUrl_tip']                           = 'Формат URL используется при формировании всех ссылок на сайте.[br][br]ЧПУ работают только если есть модуль [b]Apache[/b] [b]mod_rewrite[/b].[br][br][b]ВНИМАНИЕ: С РУССКИМИ НАЗВАНИЯМИ СТРАНИЦ И КАТЕГОРИЙ ЧПУ НЕ РАБОТАЕТ (на данный момент)![/b]';
$langFile['ADMINSETUP_GENERAL_speakingUrl_warning']                       = 'ВНИМАНИЕ!::[span class=red]Если при использовании ЧПУ возникнут проблемы, вы должны удалить файл [b].htaccess[/b] из корня сайта.[/span]';

// ---------- speaking url ERRORs
$langFile['ADMINSETUP_GENERAL_speakingUrl_error_save']                    = '<b>ЧПУ</b> не могут быть активированы '.$langFile['ERROR_SAVE_FILE'].'/.htaccess';
$langFile['ADMINSETUP_GENERAL_speakingUrl_error_modul']                   = '<b>ЧПУ</b> не могут быть активироываны, не найден модуль MOD_REWRITE';

// ---------- cache settings
$langFile['ADMINSETUP_TEXT_CACHE']                                        = 'Включить кэш';
$langFile['ADMINSETUP_TIP_CACHE']                                         = 'Если активный, все страницы будут кэшироваться. Это может семян на веб-сайте, но и приводит к не очень реальное содержание.[br][br][span class=hint] кэшироваться будет обновлена​​, при редактировании страницы.[/span]';
$langFile['ADMINSETUP_TEXT_CACHETIMEOUT']                                 = 'Кэширование тайм-аут';
$langFile['ADMINSETUP_TIP_CACHETIMEOUT']                                  = 'Указывает, после того, как много [b]часов[/b] кэш будет обновлен.';
$langFile['ADMINSETUP_HINT_CACHETIMEOUT']                                 = 'часов';

// ---------- user Settings
$langFile['ADMINSETUP_USERPERMISSIONS_TITLE']                             = 'Пользовательские настройки';
$langFile['ADMINSETUP_USERPERMISSIONS_check1']                            = 'Редактирование файлов сайта в разделе <a href="index.php?site=websiteSetup">Настройки сайта</a>';
$langFile['ADMINSETUP_USERPERMISSIONS_check2']                            = 'Редактирование файлов стилей в разделе <a href="index.php?site=websiteSetup">Настройки сайта</a>';
$langFile['ADMINSETUP_USERPERMISSIONS_TEXT_FILEMANAGER']                  = 'Включить файл-менеджер';
$langFile['ADMINSETUP_USERPERMISSIONS_TIP_WARNING_FILEMANAGER']           = 'Файл-менеджер выключен::Вы должны указать путь для загрузки файлов в секции "Базовых настроек" перед тем как активировать файл-менеджер.';
$langFile['ADMINSETUP_USERPERMISSIONS_TEXT_FRONTENDEDITING']              = 'Включить редактирование непосредственно на сайте';

$langFile['ADMINSETUP_USERPERMISSIONS_textarea1']                         = '<strong>Инфо-блок</strong> на странице <a href="?site=dashboard">'.$langFile['BUTTON_DASHBOARD'].'</a>';
$langFile['ADMINSETUP_USERPERMISSIONS_textarea1_tip']                     = 'Инфо-блок::Это короткий ифнормационный текст для пользователей который будет отображаться на странице '.$langFile['BUTTON_DASHBOARD'].'.';
$langFile['ADMINSETUP_USERPERMISSIONS_textarea1_inputTip']                = 'Если у вас нет информации для пользователей - оставьте поле пустым.';

// ---------- editor Settings
$langFile['adminSetup_editorSettings_h1']                                 = 'Настройки визуального редактора';
$langFile['ADMINSETUP_TEXT_EDITOR_HTMLLAWED']                             = 'фильтровать HTML (использует <a href="http://www.bioinformatics.org/phplabware/internal_utilities/htmLawed/">htmlLawed</a>)';
$langFile['ADMINSETUP_TIP_EDITOR_HTMLLAWED']                              = 'Фильтровать HTML код перед сохранением (решает проблему если в коде имеется много вставок javascript).';
$langFile['ADMINSETUP_TEXT_EDITOR_SAFEHTML']                              = 'безопасный HTML (<a href="http://www.bioinformatics.org/phplabware/internal_utilities/htmLawed/htmLawed_README.htm#s3.6">подробней</a>)';
$langFile['ADMINSETUP_TIP_EDITOR_SAFEHTML']                               = 'HTML-код будет фильтроваться на максимально безопасном уровне. Это означает что, например теги &lt;applet&gt;,&lt;embed&gt;,&lt;embed&gt;,&lt;object&gt; и &lt;script&gt; будут вырезаны.';
$langFile['adminSetup_editorSettings_field1']                             = 'Режим клавиши ENTER';
$langFile['adminSetup_editorSettings_field1_hint']                        = 'SHIFT + ENTER всегда вставляет &quot;&lt;br&gt;&quot;';
$langFile['adminSetup_editorSettings_field1_tip']                         = 'Вставляет при нажатии ENTER выбранный тег.[br][br][span class=hint]'.$langFile['adminSetup_editorSettings_field1_hint'].'.[/span]';
$langFile['adminSetup_editorSettings_field3_inputTip']                    = 'Если не задано - атрибут ID не будет присвоен.';
$langFile['adminSetup_editorSettings_field4_inputTip']                    = 'Если не задано - атрибут class не будет присвоен.';

// THUMBNAILS Settings
$langFile['adminSetup_thumbnailSettings_h1']                              = 'Настройки миниатюр';
$langFile['adminSetup_thumbnailSettings_field3']                          = 'Путь для сохранения'; // Thumbnail-Speicherpfad
$langFile['adminSetup_thumbnailSettings_field3_tip']                      = 'Дирктория в которую будут сохраняться миниатюры.';
$langFile['adminSetup_thumbnailSettings_field3_inputTip1']                = 'Директория загрузок';
$langFile['adminSetup_thumbnailSettings_field3_inputTip2']                = 'Относительный путь::Относительный путь &quot;[b]%s[/b]&quot; path.[br][br]Без открывающего слеша впереди - &quot;/&quot;';
$langFile['adminSetup_thumbnailSettings_field3_inputTip3']                = '<b>'.$langFile['TEXT_EXAMPLE'].'</b> &quot;thumbnails/&quot; ';

// ---------- styleFile Settings
$langFile['adminSetup_styleFileSettings_h1']                              = 'Редактирование секции &quot;Стилей&quot; для визуального редактора';
$langFile['adminSetup_styleFileSettings_error_save']                      = '<b>Файл &quot;htmlEditorStyles.js&quot; не удается сохранить.</b>'.$langFile['ERROR_SAVE_FILE'];

// ---------- editFiles Settings
$langFile['editFilesSettings_error_save']                                 = '<b>Не удается сохранить файл.</b>'.$langFile['ERROR_SAVE_FILE'];

$langFile['editFilesSettings_h1_style']                                   = 'Редактировать файлы каскадных стилей';
$langFile['editFilesSettings_h1_websitefiles']                            = 'Редактировать файлы сайта';
$langFile['editFilesSettings_noDir']                                      = 'Не корректная директория!';
$langFile['editFilesSettings_chooseFile']                                 = 'Выберите файл';
$langFile['editFilesSettings_createFile']                                 = 'Создать новый файл';
$langFile['editFilesSettings_createFile_inputTip']                        = 'Если ввести название файла здесь - будет создан новый файл. [b]Текущий файл не будет сохранен![/b]';
$langFile['editFilesSettings_noFile']                                     = 'Нет файлов';

$langFile['editFilesSettings_deleteFile']                                 = 'Удалить этот файл';
$langFile['editFilesSettings_deleteFile_question_part1']                  = 'Подтвердите удаление файла'; // Kategorie "test" löschen?
$langFile['editFilesSettings_deleteFile_question_part2']                  = '?';

$langFile['editFilesSettings_deleteFile_error_delete']                    = '<b>Не удается сохранить файл.</b>'.$langFile['ERROR_SAVE_FILE'];

/*
* pageSetup.php
*/

// ---------- CATEGORY SETUP (on toolTips tooTips.js converts the "[" and "]" tags in the title attribute to "<" ">")
$langFile['PAGESETUP_PAGES_TIP_TAG']                                      = 'Tags can be used to create connections between pages (depending on the programming of the website)';

// ---------- page settings
$langFile['PAGESETUP_PAGES_TITLE_PAGESETTINGS']                           = 'настройках сайта';
$langFile['PAGESETUP_PAGES_TEXT_SETSTARTPAGE']                            = 'Установка главной страницы';
$langFile['PAGESETUP_PAGES_TIP_SETSTARTPAGE']                             = 'Дает возможность установить любую страницу в качестве главной (стартовой).[br][br]Стартовая страница выводится если запрос в [i]$_GET[/i] пуст.';
$langFile['PAGESETUP_PAGES_TEXT_MULTILANGUAGEWEBSITE']                    = 'Мульти язык сайта';
$langFile['PAGESETUP_PAGES_TIP_MULTILANGUAGEWEBSITE']                     = 'Используйте [b]двойной клик[/b] для выбора языка.';
$langFile['PAGESETUP_PAGES_TEXT_MAINLANGUAGE']                            = 'Основной язык';
$langFile['PAGESETUP_PAGES_TIP_MAINLANGUAGE']                             = 'Основной язык будет выбран, если нет соответствующего языка может быть определен автоматически.';

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
$langFile['PAGESETUP_CATEGORY_HINT_ACTIVATEPLUGINS']                      = 'Удерживайте клавишу CTRL для выбора нескольких расширений.';

$langFile['PAGESETUP_TEXT_EDITPAGEDATE']                                  = 'Редактировать дату';
$langFile['PAGESETUP_TIP_EDITPAGEDATE']                                   = 'Дата страницы может быть использована для сортировки.';

$langFile['PAGESETUP_TEXT_FEEDS']                                         = 'Включить xml-ленты';
$langFile['PAGESETUP_TIP_FEEDS']                                          = 'Включает выдачу xml-лент для категории в форматах: RSS 2.0 и Atom.';
$langFile['PAGESETUP_CATEGORY_TIP_FEEDS']                                 = 'Включает выдачу xml-лент для категории в форматах: RSS 2.0 и Atom.';

$langFile['PAGESETUP_TIP_SORTBYPAGEDATE']                                 = 'Сортировать страницы по дате';
$langFile['PAGESETUP_TIP_SORTBYDATE']                                     = 'Страницы созданные позже (более новые) будут выводится в списке [b]вверху[/b].[br][br][span class=hint]Деактивирует ручную сортировку.[/span]';

$langFile['PAGESETUP_TEXT_SORTMANUALLY']                                  = 'Ручная сотрировка';
$langFile['PAGESETUP_TIP_SORTMANUALLY']                                   = 'Последние созданные страницы [b]вверху[/b].';

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

/*
* statisticSetup.php
*/

// ---------- STATISITC SETUP (on toolTips tooTips.js converts the "[" and "]" tags in the tittle attribute to "<" ">")
$langFile['STATISTICSSETUP_ERROR_SAVE']                                   = $langFile['ERROR_SAVE_SETTINGS'].$langFile['ERROR_SAVE_FILE'].'%sconfig/statistic.config.php';

$langFile['STATISTICSSETUP_TITLE_STATISTICSSETTINGS']                     = 'Настройки статистики';
$langFile['STATISTICSSETUP_TEXT_MOSTVISTED']                              = 'Количество <b>наиболее посещаемых</b> страниц';
$langFile['STATISTICSSETUP_TIP_MOSTVISTED']                               = 'Количество наиболее посещаемых страниц выводящихся в списке секции [b]Статистика по страницам[/b] в [b]Сводке[/b].';
$langFile['STATISTICSSETUP_TEXT_LONGESTVIEWED']                           = 'Количество <b>дольше всего просматриваемых</b> страниц';
$langFile['STATISTICSSETUP_TIP_LONGESTVIEWED']                            = 'Количество дольше всего просматриваемых страниц выводящихся в списке секции [b]Статистика по страницам[/b] в [b]Сводке[/b].';
$langFile['STATISTICSSETUP_TEXT_LASTEDITED']                              = 'Количество <b>последних измененных</b> страниц';
$langFile['STATISTICSSETUP_TIP_LASTEDITED']                               = 'Количество последних измененных страниц выводящихся в списке секции [b]Статистика по страницам[/b] в [b]Сводке[/b].';
$langFile['STATISTICSSETUP_TEXT_LASTVISITED']                             = 'Количество <b>последних просмотренных</b> страниц';
$langFile['STATISTICSSETUP_TIP_LASTVISITED']                              = 'Количество последних просмотренных страниц выводящихся в списке секции [b]Статистика по страницам[/b] в [b]Сводке[/b].';
$langFile['STATISTICSSETUP_TEXT_REFERERNUMBER']                           = 'Количество <b>источников переходов</b>';
$langFile['STATISTICSSETUP_TIP_REFERERNUMBER']                            = 'Количество источников переходов выводящихся в списке секции [b]Статистика по страницам[/b] в [b]Сводке[/b].';
$langFile['STATISTICSSETUP_TEXT_ACTIVITYNUMBER']                          = 'Количество <b>последних действий</b>';
$langFile['STATISTICSSETUP_TIP_ACTIVITYNUMBER']                           = 'Максимальное количество выводящихся в левом сайд-баре последних действий.';


$langFile['statisticSetup_clearStatistic_h1']                             = 'Обнулить статистику';
$langFile['statisticSetup_clearStatistics_websiteStatistic']              = 'Статистика сайта';
$langFile['statisticSetup_clearStatistics_websiteStatistic_tip']          = '[b]Содержит[/b][ul][li]Статистика посещений/посетителей[/li][li]Статистика пауков/ботов[/li][li]Дата первого визита[/li][li]Дата последнего визита[/li][li]Статистика браузеров[/li][/ul]';
$langFile['statisticSetup_clearStatistics_pagesStatistic']                = 'Статистика по страницам';
$langFile['statisticSetup_clearStatistics_pagesStatistic_tip']            = '[b]Содержит[/b][ul][li]Количество посетителей[/li][li]Дата первого визита страницы[/li][li]Дата последнего визита страницы[/li][li]Самые короткие визиты[/li][li]Самые продолжительные визиты[/li][li]Ключевые слова из поиска[/li][/ul]';
$langFile['statisticSetup_clearStatistics_pagesStaylengthStatistics']     = 'Только статистику продолжительности пребывания на странице';
$langFile['statisticSetup_clearStatistics_pagesStaylengthStatistics_tip'] = 'Удалить только статистику продолжительности просмотров всех страниц';
$langFile['statisticSetup_clearStatistics_refererLog']                    = 'Источники переходов'; // engl.: referer
$langFile['statisticSetup_clearStatistics_refererLog_tip']                = 'Данные об источниках переходов на сайт.';
$langFile['statisticSetup_clearStatistics_taskLog']                       = 'Статистика действий';
$langFile['statisticSetup_clearStatistics_taskLog_tip']                   = 'Все последние операции и действия совершенные в панели управления.';

$langFile['statisticSetup_clearStatistics_question_h1']                   = 'Уверены что хотите обнулить статистику?';

$langFile['statisticSetup_clearStatistic_pagesStatistics_error_read']     = 'Произошла общибка при удалении файла статистики.'.$langFile['ERROR_SAVE_FOLDER_PART1'].'%sstatistic/pages/'.$langFile['ERROR_FOLDER_PART2'];

/*
* userSetup.php
*/

$langFile['userSetup_h1']                                                 = 'Учетные записи';
$langFile['userSetup_userSelection']                                      = 'Пользователи';

$langFile['userSetup_createUser']                                         = 'Создание нового пользователя';
$langFile['userSetup_createUser_created']                                 = 'Новый пользователь создан';
$langFile['userSetup_createUser_unnamed']                                 = 'Безымянный пользователь';

$langFile['userSetup_deleteUser']                                         = 'Удалить пользователя';
$langFile['userSetup_deleteUser_deleted']                                 = 'Пользователь удален';

$langFile['userSetup_username']                                           = 'Логин';
$langFile['userSetup_username_missing']                                   = 'Не установлено логина.';
$langFile['userSetup_password']                                           = 'пароль';
$langFile['userSetup_password_change']                                    = 'Изменить пароль';
$langFile['userSetup_password_confirm']                                   = 'Подтверждение пароля';
$langFile['userSetup_password_confirm_wrong']                             = 'Пароли не совпадают.';
$langFile['userSetup_password_missing']                                   = 'Не установлен пароль.';
$langFile['userSetup_password_success']                                   = 'Пароль изменен!';
$langFile['userSetup_email']                                              = 'E-Mail';
$langFile['userSetup_email_tip']                                          = 'Если пользователь потеряет пароль, его возможно восстановить на email.';

$langFile['userSetup_admin']                                              = 'Администратор';
$langFile['userSetup_admin_tip']                                          = 'Наделить пользователя правами администратора.';

$langFile['userSetup_error_create']                                       = '<b> Пользователь не может быть создан.</b>'.$langFile['ERROR_SAVE_FILE'].'%sconfig/user.config.php';
$langFile['userSetup_error_save']                                         = $langFile['ERROR_SAVE_SETTINGS'].$langFile['ERROR_SAVE_FILE'].'%sconfig/user.config.php';

/*
* editor.php
*/

// ---------- page info
$langFile['EDITOR_h1_createpage']                                         = 'Создание новой страницы';
$langFile['EDITOR_pageinfo_lastsavedate']                                 = 'последняя редакция';
$langFile['EDITOR_pageinfo_lastsaveauthor']                               = '-';
$langFile['EDITOR_pageinfo_linktothispage']                               = 'Ссылка на страницу';
$langFile['EDITOR_pageinfo_id']                                           = 'ID страницы';
$langFile['EDITOR_pageinfo_id_tip']                                       = 'С этим ID страница хранится на сервере.';
$langFile['EDITOR_pageinfo_category']                                     = 'Категории';
$langFile['EDITOR_pageinfo_category_noCategory']                          = 'без категории';

$langFile['EDITOR_TEXT_CHOOSETEMPLATE']                                   = 'использование шаблонов';

$langFile['EDITOR_block_edited']                                          = 'изменены';
$langFile['EDITOR_pageNotSaved']                                          = 'не сохранено';

// ---------- page settings
$langFile['EDITOR_pageSettings_h1']                                       = 'Настройки';
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
$langFile['EDITOR_pageSettings_pagedate_before_inputTip']                 = 'Текст до даты::например &quot;начиная с 31 июня&quot;.';
$langFile['EDITOR_pageSettings_pagedate_after_inputTip']                  = 'Текст после даты::';
$langFile['EDITOR_pageSettings_pagedate_day_inputTip']                    = 'День::';
$langFile['EDITOR_pageSettings_pagedate_month_inputTip']                  = 'Месяц::';
$langFile['EDITOR_pageSettings_pagedate_year_inputTip']                   = 'Год::[b]Формат[/b] YYYY';
$langFile['EDITOR_pageSettings_field4']                                   = 'Статус страницы';
$langFile['EDITOR_pageSettings_field4_tip']                               = '[b]Только активная страница отображается на сайте![/b]';

$langFile['EDITOR_pageSettings_pagedate_error']                           = 'Ошибочный формат даты';
$langFile['EDITOR_pageSettings_pagedate_error_tip']                       = 'В этом месяце не 31 день.[br]Формат даты может быть следующим:';

// ---------- page advanced settings
$langFile['EDITOR_advancedpageSettings_h1']                               = 'Дополнительные настройки';

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
$langFile['EDITOR_pluginSettings_h1']                                     = 'Настройки расширений';

/*
* unsavedPage.php
*/

$langFile['unsavedPage_question_h1']                                      = '<span class="brown">Страница отредактирована.</span><br>Сохранить изменения?';

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
* pageThumbnailDelete.php
*/

// ---------- PAGE THUMBNAIL DELETE
$langFile['PAGETHUMBNAIL_TEXT_DELETE_QUESTION_START']                     = 'Подтверждаете удаление миниатюры для страницы';
$langFile['PAGETHUMBNAIL_TEXT_DELETE_QUESTION_END']                       = '?';
$langFile['PAGETHUMBNAIL_ERROR_DELETE']                                   = 'ОШИБКА: миниатюра не может быть удалена!';


/*
* pageThumbnailUpload.php
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
$langFile['BACKUP_TEXT_RESTORE']                                          = 'Выберите <span class="logoname"><span>fein</span>dura</span> резервную копию, для возвращения к предыдущему состоянию.<br><span class="blue">До восстановления рекомендуем создать новую резервную копию.</ span>';
$langFile['BACKUP_TOOLTIP_DELETE']                                        = 'Удалить резервную копию';
$langFile['BACKUP_TEXT_DELETE_QUESTION']                                  = 'Удалить %s?'; // really delete backup 2010-11-05 15:03?

$langFile['BACKUP_TITLE_LASTBACKUPS']                                     = 'Скачать резервную копию';
$langFile['BACKUP_TEXT_NOBACKUP']                                         = 'Резервных копий не создано.';

$langFile['BACKUP_ERROR_FILENOTFOUND']                                    = 'Файл резервной копии не найден:';
$langFile['BACKUP_ERROR_NORESTROEFILE']                                   = 'Не выбрано файла резервной копии для восстановления.';
$langFile['BACKUP_ERROR_DELETE']                                          = 'Не удается удалить резервную копию!';


// -----------------------------------------------------------------------------------------------
// RETURN ****************************************************************************************
// -----------------------------------------------------------------------------------------------
return $langFile;

?>