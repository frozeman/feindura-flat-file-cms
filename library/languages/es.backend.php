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
 * ENGLISH (EN) language-file for the feindura CMS (BACKEND)
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

$langFile['LOGIN_INPUT_USERNAME']                                         = 'Usuario';
$langFile['LOGIN_INPUT_PASSWORD']                                         = 'Contraseña';
$langFile['LOGIN_BUTTON_LOGIN']                                           = 'Iniciar sesión';
$langFile['LOGIN_TEXT_COOKIESNEEDED']                                     = '¡Las cookies deben estar activadas!';

$langFile['LOGIN_LINK_FORGOTPASSWORD']                                    = '¿Olvidaste tu contraseña?';
$langFile['LOGIN_LINK_BACKTOLOGIN']                                       = 'volver a la pantalla de inicio de sesión';
$langFile['LOGIN_BUTTON_SENDNEWPASSWORD']                                 = 'Modificar contraseña';
$langFile['LOGIN_TEXT_NEWPASSWORDEMAIL_SUBJECT']                          = 'Has solicitado tu contraseña de acceso a Feindura CMS desde ';
$langFile['LOGIN_TEXT_NEWPASSWORDEMAIL_MESSAGE']                          = 'Has solicitado una nueva contraseña desde tu Feindura CMS.
Tu usuario y nueva contraseña son:';

$langFile['LOGIN_ERROR_FORGOTPASSWORD_NOEMAIL']                           = 'El usuario no tiene dirección de correo electrónico';
$langFile['LOGIN_ERROR_FORGOTPASSWORD_NOTSEND']                           = 'ERROR<br> mientras se mandaba la nueva contraseña al usuario especificado en la dirección de correo electrónico';
$langFile['LOGIN_ERROR_FORGOTPASSWORD_NOTSAVED']                          = 'ERROR<br> no se puedo guardar la nueva contraseña.';
$langFile['LOGIN_ERROR_FORGOTPASSWORD_SUCCESS']                           = 'La nueva contraseña ha sido enviada a la siguiente dirección de correo electrónico.';

$langFile['LOGIN_ERROR_WRONGUSER']                                        = 'El usuario no existe';
$langFile['LOGIN_ERROR_WRONGPASSWORD']                                    = 'Contraseña errónea';

$langFile['LOGIN_TEXT_LOGOUT_PART1']                                      = 'Has salido correctamente.';
$langFile['LOGIN_TEXT_LOGOUT_PART2']                                      = 'ir al sitio web';

$langFile['LOGIN_TIP_AUTOLOGOUT']                                         = 'Desconectado automáticamente';


// -> GENERAL <-

$langFile['DATE_Y-M-D']                                                   = 'YYYY-MM-DD';
$langFile['DATE_D.M.Y']                                                   = 'DD.MM.YYYY';
$langFile['DATE_D/M/Y']                                                   = 'DD/MM/YYYY';
$langFile['DATE_M/D/Y']                                                   = 'MM/DD/YYYY';
$langFile['CATEGORIES_TEXT_NONCATEGORY']                                  = 'Páginas';
$langFile['CATEGORIES_TOOLTIP_NONCATEGORY']                               = 'Páginas sin categoria';
$langFile['TEXT_EXAMPLE']                                                 = 'Ejemplo';

$langFile['HEADER_BUTTON_GOTOWEBSITE_FRONTENDEDITING']                    = 'Edición directa::Pulsa aquí para modificar las páginas directamente en tu sitio web';

$langFile['BUTTON_MORE']                                                  = 'más';

// PERMISSIONS
$langFile['PERMISSIONS_TEXT_DONTHAVEPERMISSION']                          = 'No estás autorizado para realizar este tipo de modificaciones.';

// THUMBNAILS
$langFile['THUMBNAIL_TEXT_UNIT']                                          = 'pixel';

$langFile['THUMBNAIL_TEXT_NAME']                                          = 'Miniatura de la página';
$langFile['THUMBNAIL_TEXT_WIDTH']                                         = '<b>Ancho</b> de la miniatura';
$langFile['THUMBNAIL_TEXT_HEIGHT']                                        = '<b>Altura</b> de la miniatura';

$langFile['THUMBNAIL_TOOLTIP_WIDTH']                                      = 'Ancho estándar::El ancho de la miniatura en pixels.[br][br]La imagen ser redimiensionará a este valor despúes de haber sido subida al servidor.';
$langFile['THUMBNAIL_TOOLTIP_HEIGHT']                                     = 'Altura estándar::La altura de la miniatura en pixels.[br][br]La imagen ser redimiensionará a este valor despúes de haber sido subida al servidor.';

$langFile['THUMBNAIL_TEXT_RATIO']                                         = 'Ratio';
$langFile['THUMBNAIL_TEXT_KEEPRATIO']                                     = 'Mantener ratio';
$langFile['THUMBNAIL_TEXT_FIXEDRATIO']                                    = 'Ratio fijo';
$langFile['THUMBNAIL_TOOLTIP_FIXEDRATIO']                                 = 'La altura y el ancho se establecen manualmente';
$langFile['THUMBNAIL_TOOLTIP_KEEPRATIO_X']                                = 'Se alineará por el [i]ancho[/i].';
$langFile['THUMBNAIL_TOOLTIP_KEEPRATIO_Y']                                = 'Se alineará por [i]altura[/i].';

// STYLESHEETS
$langFile['STYLESHEETS_TEXT_STYLEFILE']                                   = 'Ficheros de hojas de estilo';
$langFile['STYLESHEETS_TEXT_ID']                                          = 'Id - Hoja de estilo';
$langFile['STYLESHEETS_TEXT_CLASS']                                       = 'Class - Hoja de estilo';

$langFile['STYLESHEETS_TOOLTIP_STYLEFILE']                                = 'Aquí puede especificar los ficheros de hojas de estilo que se aplicarán al contenido del editor HTML.';
$langFile['STYLESHEETS_TOOLTIP_ID']                                       = 'Aquí puede especificar un atributo ID que se añadirá a la etiqueta <body> del editor HTML.';
$langFile['STYLESHEETS_TOOLTIP_CLASS']                                    = 'Aquí puede especificar un atributo CLASS que se añadirá a la etiqueta <body> del editor HTML.';

$langFile['STYLESHEETS_TOOLTIP_ADDSTYLEFILE']                             = 'Añadir fichero de hoja de estilos';
$langFile['STYLESHEETS_EXAMPLE_STYLEFILE']                                = '<b>Ejemplo</b> &quot;/style/layout.css&quot;';

// PATHS
$langFile['PATHS_TEXT_ABSOLUTE']                                          = 'ruta absoluta';
$langFile['PATHS_TEXT_RELATIVE']                                          = 'ruta relativa';
$langFile['PATHS_TOOLTIP_ABSOLUTE']                                       = 'Ruta absoluta::Ruta absoluta del sistema de ficheros. (Pero relativa al directorio raiz de tu instalación de Feindura)[br][br][span class=hint]/server/htdocs[strong]/ruta/[/strong][/span]';
$langFile['PATHS_TOOLTIP_RELATIVE']                                       = 'Ruta relativa::Ruta relativa al documento actual.';

// STATISTICS
$langFile['STATISTICS_TITLE_BROWSERCHART']                                = 'Uso de navegadores';
$langFile['STATISTICS_TEXT_ROBOTCOUNT']                                   = 'Arañas web';
$langFile['STATISTICS_TOOLTIP_ROBOTCOUNT']                                = 'Arañas-web::O robots son programas de los motores de búsqueda que analizan e indexan los sitios web.';

$langFile['STATISTICS_TEXT_SEARCHWORD_PART1']                             = 'led'; // "exampleword" led 20 times to this website
$langFile['STATISTICS_TEXT_SEARCHWORD_PART2']                             = 'veces en este sitio';
$langFile['STATISTICS_TOOLTIP_SEARCHWORD']                                = 'Click para buscar esta palabra en el sitio web.';

$langFile['STATISTICS_TEXT_VISITORCOUNT']                                 = 'Visitas';
$langFile['STATISTICS_TEXT_CURRENTVISITORS']                              = 'Visitantes actuales';
$langFile['STATISTICS_TEXT_CURRENT']                                      = 'Actualmente';
$langFile['STATISTICS_TEXT_LASTACTIVITY']                                 = 'Última actividad';

$langFile['STATISTICS_TITLE_PAGESTATISTICS']                              = 'Estadísticas de la página';

$langFile['STATISTICS_TEXT_VISITTIME_MAX']                                = 'estancia más larga';
$langFile['STATISTICS_TEXT_VISITTIME_MIN']                                = 'estancia más corta';
$langFile['STATISTICS_TEXT_FIRSTVISIT']                                   = 'desde';
$langFile['STATISTICS_TEXT_LASTVISIT']                                    = 'a';
$langFile['STATISTICS_TEXT_NOVISIT']                                      = 'Hasta el momento nadia ha visitado este sitio web.';
$langFile['STATISTICS_TEXT_SEARCHWORD_DESCRIPTION']                       = '<span class="toolTipTop" title="::Which led from
Google, Yahoo or Bing (MSN) to this website.">Searchwords</span>';

$langFile['STATISTICS_TEXT_HOUR_SINGULAR']                                = 'hora';
$langFile['STATISTICS_TEXT_HOUR_PLURAL']                                  = 'horas';
$langFile['STATISTICS_TEXT_MINUTE_SINGULAR']                              = 'minuto';
$langFile['STATISTICS_TEXT_MINUTE_PLURAL']                                = 'minutos';
$langFile['STATISTICS_TEXT_SECOND_SINGULAR']                              = 'segundo';
$langFile['STATISTICS_TEXT_SECOND_PLURAL']                                = 'segundos';

$langFile['STATISTICS_TEXT_BROWSERCHART_OTHERS']                          = 'otro';

// LOG TEXTS
$langFile['LOG_PAGE_SAVED']                                               = 'Página guardada';
$langFile['LOG_PAGE_NEW']                                                 = 'Nueva página creada';
$langFile['LOG_PAGE_DELETE']                                              = 'Página eliminada';

$langFile['LOG_PAGE_MOVEDINCATEGORY']                                     = 'Página movida a categoría';
$langFile['LOG_PAGE_MOVEDTOCATEGORY_CATEGORY']                            = 'a categoria'; // Example Page in Category
$langFile['LOG_PAGE_SORTED']                                              = 'Ordenación de páginas modificada';

$langFile['LOG_THUMBNAIL_UPLOAD']                                         = 'Nueva miniatura subida';
$langFile['LOG_THUMBNAIL_DELETE']                                         = 'Miniatura eliminada';

$langFile['LOG_USER_ADD']                                                 = 'Nuevo usuario creado';
$langFile['LOG_USER_DELETED']                                             = 'Usuario eliminado';
$langFile['LOG_USER_PASSWORD_CHANGED']                                    = 'Contraseña de usuario cambiada';
$langFile['LOG_USER_SAVED']                                               = 'Usuario guardado';

$langFile['LOG_ADMINSETUP_SAVED']                                         = 'Configuración del administrador guardada';
$langFile['LOG_ADMINSETUP_CKSTYLES']                                      = '&quot;Estilos de formato&quot; del editor HTML guardados';

$langFile['LOG_WEBSITESETUP_SAVED']                                       = 'Configuración del sitio web guardada';

$langFile['LOG_STATISTICSETUP_SAVED']                                     = 'Configuración de estadisticas guardada';
$langFile['LOG_CLEARSTATISTICS_WEBSITESTATISTIC']                         = 'Estadísticas del sitio web eliminada';
$langFile['LOG_CLEARSTATISTICS_PAGESTATISTICS']                           = 'Estadísticas de la página eliminada';
$langFile['LOG_CLEARSTATISTICS_PAGESTAYLENGTH']                           = 'Estadísticas de duración de las visitas eliminada';
$langFile['LOG_CLEARSTATISTICS_REFERERLOG']                               = 'Registro de referidos eliminado';
$langFile['LOG_CLEARSTATISTICS_ACTIVITYLOG']                              = 'Registro de actividades eliminado';

$langFile['LOG_PAGESETUP_SAVED']                                          = 'Configuración de la página guardada';
$langFile['LOG_PAGESETUP_CATEGORIES_SAVED']                               = 'Categorias guardadas';

$langFile['LOG_PAGESETUP_CATEGORIES_NEW']                                 = 'Nueva categoria creada';
$langFile['LOG_PAGESETUP_CATEGORIES_DELETED']                             = 'Categoria eliminada';
$langFile['LOG_PAGESETUP_CATEGORIES_MOVED']                               = 'Categoria movida';

$langFile['LOG_FILE_SAVED']                                               = 'Fichero guardado';
$langFile['LOG_FILE_DELETED']                                             = 'Fichero eliminado';

$langFile['LOG_BACKUP_CREATED']                                           = 'Copia de seguridad creada';
$langFile['LOG_BACKUP_RESTORED']                                          = 'Copia de seguridad restaurada';
$langFile['LOG_BACKUP_DELETED']                                           = 'Copia de seguridad eliminada';

$langFile['LOG_PAGELANGUAGE_DELETED']                                     = 'Idioma eliminado &quot;%s&quot; para la página';
$langFile['LOG_PAGELANGUAGE_ADD']                                         = 'Añadir idioma &quot;%s&quot; para la página';

// PAGE/CATEGORY STATUS
$langFile['STATUS_PAGE_PUBLIC']                                           = 'La página es pública';
$langFile['STATUS_PAGE_NONPUBLIC']                                        = 'La página no es visible';

$langFile['STATUS_CATEGORY_PUBLIC']                                       = 'La categoria es publica';
$langFile['STATUS_CATEGORY_NONPUBLIC']                                    = 'La categoria no es visible';

// USER LIST
$langFile['USER_TEXT_USER']                                               = 'Usuario';
$langFile['USER_TEXT_NOUSER']                                             = 'No han sido creados usuarios.';
$langFile['USER_TEXT_CURRENTUSER']                                        = '¡Eres tu!';
$langFile['USER_TEXT_USERSONLINE']                                        = 'Este usuario está en linea::Ultima actividad';

$langFile['LOGO_TEXT']                                                    = 'Version';
$langFile['txt_logo_gotowebsite']                                         = 'Haz click aquí para ir a tu sitio web.';

// CKEDITOR transport
$langFile['CKEDITOR_TITLE_LINKS']                                         = 'paginas de feindura';
$langFile['CKEDITOR_TITLE_SNIPPETS']                                      = 'Bloques de código';
$langFile['CKEDITOR_TEXT_SNIPPETS']                                       = 'Elige un bloque de código para incorporar a la página.';
$langFile['CKEDITOR_BUTTON_EDITSNIPPET']                                  = 'Editar bloque de código';
$langFile['CKEDITOR_TITLE_PLUGINS']                                       = 'Complementos';
$langFile['CKEDITOR_BUTTON_EDITPLUGIN']                                   = 'Editar complemento';

$langFile['CKEDITOR_TEXT_PLUGINS']                                        = 'Elige un complemento para incorporar a la página.';

// -> BUTTON TEXTS

// MAIN MENU
$langFile['BUTTON_DASHBOARD']                                             = 'Inicio';
$langFile['BUTTON_PAGES']                                                 = 'Páginas';
$langFile['BUTTON_ADDONS']                                                = 'Extensiones';
$langFile['BUTTON_WEBSITESETTINGS']                                       = 'Configuración sitio web';
$langFile['BUTTON_SEARCH']                                                = 'Buscar páginas';

// ADMIN MENU
$langFile['HEADER_TITLE_ADMINMENU']                                       = 'Administracion';
$langFile['BUTTON_ADMINSETUP']                                            = 'Configuración administrador';
$langFile['BUTTON_PAGESETUP']                                             = 'Configuración de páginas';
$langFile['BUTTON_STATISTICSETUP']                                        = 'Configuración de estadísticas';
$langFile['BUTTON_USERSETUP']                                             = 'Usuarios';
$langFile['BUTTON_BACKUP']                                                = 'Copias de seguridad';

// SUB MENU/FOOTER
$langFile['BUTTON_FILEMANAGER']                                           = 'Gestor de archivos';
$langFile['BUTTON_TOOLTIP_FILEMANAGER']                                   = 'Gestiona tus ficheros e imágenes';
$langFile['BUTTON_CREATEPAGE']                                            = 'Nueva página';
$langFile['BUTTON_TOOLTIP_CREATEPAGE']                                    = 'Crear una nueva página';
$langFile['BUTTON_DELETEPAGE']                                            = 'Eliminar página';
$langFile['BUTTON_TOOLTIP_DELETEPAGE']                                    = 'Eliminar esta página';
$langFile['BUTTON_FRONTENDEDITPAGE']                                      = 'Edición directa';
$langFile['BUTTON_TOOLTIP_FRONTENDEDITPAGE']                              = 'Edita esta página directamente tal como se muestra en el navegador web.';
$langFile['BUTTON_THUMBNAIL_UPLOAD']                                      = 'Subir miniatura';
$langFile['BUTTON_TOOLTIP_THUMBNAIL_UPLOAD']                              = 'Subir una miniatura para esta página';
$langFile['BUTTON_THUMBNAIL_DELETE']                                      = 'Eliminar miniatura';
$langFile['BUTTON_TOOLTIP_THUMBNAIL_DELETE']                              = 'Eliminar la miniatura de esta página';
$langFile['BUTTON_WEBSITELANGUAGE_ADD']                                   = 'Añadir idioma';
$langFile['BUTTON_TOOLTIP_WEBSITELANGUAGE_ADD']                           = 'Añadir nuevo idioma a esta página';
$langFile['BUTTON_WEBSITELANGUAGE_DELETE']                                = 'Eliminar idioma';
$langFile['BUTTON_TOOLTIP_WEBSITELANGUAGE_DELETE']                        = 'Eliminar idioma &quot;%s&quot; para esta página';
$langFile['BUTTON_SHOWINMENU']                                            = 'Mostrar en menus';
$langFile['BUTTON_HIDEINMENU']                                            = 'Ocultar en menus';
$langFile['BUTTON_TOOLTIP_SHOWHIDEINMENU']                                = 'Determina si la página se muestra o no en los menus.';

// OTHER BUTTONS
$langFile['BUTTON_UP']                                                    = 'Arriba';
$langFile['BUTTON_INFO']                                                  = 'Información';
$langFile['BUTTON_EDIT']                                                  = 'Editar';
$langFile['BUTTON_RESET']                                                 = 'Restaurar';
$langFile['BUTTON_OK']                                                    = 'OK';

// -> GENERAL ERROR TEXTS
$langFile['ERROR_SAVE_SETTINGS']                                          = '<b>La configuración no pudo guardarse</b>';
$langFile['ERROR_SAVE_FILE']                                              = '<br><br>Por favor revisa los permisos de lectura-escritura para el fichero';

$langFile['ERROR_READ_FOLDER_PART1']                                      = '<br><br>Por favor revisa los permisos de lectura del &quot;';
$langFile['ERROR_SAVE_FOLDER_PART1']                                      = '<br><br>Por favor revisa los permisos de escritura del  &quot;';

$langFile['ERROR_FOLDER_PART2']                                           = '&quot; Directorio y sus subdirectorios y ficheros contenidos en el mismo.';

// -> WARNINGS
$langFile['WARNING_TITLE_STARTPAGE']                                      = '¡No hay establecida ninguna página de inicio!';
$langFile['WARNING_TEXT_STARTPAGE']                                       = 'Por favor selecciona una página de inicio.<br>Ve a <a href="?site=pages">'.$langFile['BUTTON_PAGES'].'</a> y pincha sobre el icono <span class="icons startpage"></span> de la página deseada.';

$langFile['WARNING_TITLE_DOCUMENTROOT']                                   = '¡La raiz de tu sistema de ficheros no se pudo obtener automáticamente!';
$langFile['WARNING_TEXT_DOCUMENTROOT']                                    = 'Para que <span class="feinduraInline">fein<em>dura</em></span> funcione adecuadamente debes indicar la raiz de tu sistema de ficheros manualmente en <a href="?site=adminSetup#adminSettings">Configuración del administrador</a>.';

$langFile['WARNING_TITLE_BASEPATH']                                       = '¡<span class="feinduraInline">fein<em>dura</em></span> no está configurado!';
$langFile['WARNING_TEXT_BASEPATH']                                        = 'La <i>ruta base</i> del CMS no se corresponde con la indicada en la configuración del administrator.<br>
Por favor vaya a <a href                                                  ="?site=adminSetup#adminSettings">configuración del administrador</a> y configure su <span class="feinduraInline">fein<em>dura</em></span> CMS.';

$langFile['WARNING_TITLE_JAVASCRIPT']                                     = 'Por favor active Javascript';
$langFile['WARNING_TEXT_JAVASCRIPT']                                      = '<strong>Para poder utilizar correctamente <span class="feinduraInline">fein<em>dura</em></span>, necesitas activar Javascript</strong>';

$langFile['WARNING_TITLE_UNTITLEDCATEGORIES']                             = 'Nombres de categorias no establecidos';

$langFile['DASHBOARD_TITLE_IEWARNING']                                    = '<span class="feinduraInline">fein<em>dura</em></span> no soporta versiones antiguas de Internet Explorer';
$langFile['DASHBOARD_TEXT_IEWARNING']                                     = 'Para el correcto funcionamiento de  <span class="feinduraInline">fein<em>dura</em></span> CMS necesitas al menos Internet Explorer 9.<br><br>Por favor instala una nueva versión de Internet Explorer,<br> o instala <a href="http://www.google.com/chromeframe" target="_blank">Google Chrome Frame Plugin</a> para Internet Explorer,<br>o descarga e instala <a href="http://www.mozilla.org/firefox/">Firefox</a> o <a href="http://www.google.com/chrome/">Chrome</a> Browser de forma totalmente gratuita.';

$langFile['GENERAL_TEXT_CURRENTLYEDITED']                                 = 'La página esta siendo actualmente editada...';

// MESSAGES
$langFile['MESSAGE_TEXT_CHANGEDSTATUS']                                   = 'El estado fue modificado con éxito.';
$langFile['MESSAGE_TEXT_CHANGEDSHOWINMENU']                               = 'El estado del menú fue modificado con éxito.';


/*
* leftSidebar.loader.php
*/

// ---------- QUICKMENU

$langFile['SIDEBARMENU_TITLE_CATEGORIES']                                 = 'Categorias';
$langFile['SIDEBARMENU_TITLE_PAGES']                                      = 'Páginas de ';

/*
* dashboard.php
*/

// ---------- DASHBOARD
$langFile['DASHBOARD_TITLE_USERINFO']                                     = 'Información del usuario';

$langFile['DASHBOARD_TITLE_WELCOME']                                      = 'Bienvenido a <span class="feinduraInline">fein<em>dura</em></span>,<br>el sistema de gestión de contenidos de tu sitio web';

$langFile['DASHBOARD_TITLE_STATISTICS']                                   = 'Estadísticas del sitio web';

$langFile['DASHBOARD_TITLE_USER']                                         = 'Usuarios';
$langFile['DASHBOARD_TITLE_ACTIVITY']                                     = 'Actividades';
$langFile['DASHBOARD_TEXT_ACTIVITY_NONE']                                 = 'ninguna';

$langFile['DASHBOARD_TITLE_STATISTICS_MOSTVISITED']                       = 'páginas más visitadas';
$langFile['DASHBOARD_TITLE_STATISTICS_LASTVISITED']                       = 'últimas páginas visitadas';
$langFile['DASHBOARD_TITLE_STATISTICS_LASTEDITED']                        = 'últimas páginas editadas';
$langFile['DASHBOARD_TITLE_STATISTICS_LONGESTVIEWED']                     = 'páginas más vistas';

$langFile['DASHBOARD_TITLE_REFERER']                                      = 'Las visitas vinieron de';

/*
* listPages.php
*/

// ---------- PAGES SORTABLE LIST
$langFile['SORTABLEPAGELIST_h1']                                          = 'El contenido de tu sitio web';
$langFile['SORTABLEPAGELIST_headText1']                                   = 'Filtro';
$langFile['SORTABLEPAGELIST_headText3']                                   = 'Visitas';
$langFile['SORTABLEPAGELIST_headText4']                                   = 'Estado';
$langFile['SORTABLEPAGELIST_headText5']                                   = 'Funciones';

$langFile['SORTABLEPAGELIST_TIP_PAGEDATE']                                = 'Fecha de la página';
$langFile['SORTABLEPAGELIST_TIP_LASTEDIT']                                = 'Última editada';
$langFile['SORTABLEPAGELIST_TIP_TAGS']                                    = 'Etiquetas';
$langFile['SORTABLEPAGELIST_TIP_LOCALIZATION']                            = 'Idiomas';

$langFile['SORTABLEPAGELIST_TIP_SORTALPHABETICAL']                        = 'orden alfabético';
$langFile['SORTABLEPAGELIST_TIP_SORTBYPAGEDATE']                          = 'orden cronológico';

$langFile['SORTABLEPAGELIST_functions_editPage']                          = 'Editar página';

$langFile['SORTABLEPAGELIST_TIP_CHANGESTATUS']                            = 'Pulsa aquí para cambiar el estado';

$langFile['SORTABLEPAGELIST_TOOLTIP_LANGUAGEMISSING']                     = 'Idiomas perdidos';

$langFile['file_error_read']                                              = '<b>No se puede leer la página.</b>'.$langFile['ERROR_READ_FOLDER_PART1'].'%spages/'.$langFile['ERROR_FOLDER_PART2'];
$langFile['SORTABLEPAGELIST_setStartPage_error_save']                     .= $langFile['ERROR_SAVE_FILE'].' &quot;%sconfig/website.config.php&quot;'; // also in en.shared.php
$langFile['SORTABLEPAGELIST_changeStatusPage_error_save']                 = '<b>No se pudo modificar el estado de la página.</b>'.$langFile['ERROR_SAVE_FOLDER_PART1'].'%spages/'.$langFile['ERROR_FOLDER_PART2'];
$langFile['SORTABLEPAGELIST_changeStatusCategory_error_save']             = '<b>No se pudo modificar el estado de la categoría.</b>'.$langFile['ERROR_SAVE_FOLDER_PART1'].'%spages/'.$langFile['ERROR_FOLDER_PART2'];

$langFile['SORTABLEPAGELIST_info']                                        = 'Puedes modificar <b>la ordenación</b> de las páginas y mover las páginas entre categorías <b>Arrastrando y Soltando</b>.';
$langFile['SORTABLEPAGELIST_save']                                        = 'Guardar nuevo ordenamiento ...';
$langFile['SORTABLEPAGELIST_save_finished']                               = 'Nuevo ordenamiento guardado con éxito';
$langFile['SORTABLEPAGELIST_error_save']                                  = '<b>No se pudo guardar la página.</b>'.$langFile['ERROR_SAVE_FOLDER_PART1'].'%spages/'.$langFile['ERROR_FOLDER_PART2'];
$langFile['SORTABLEPAGELIST_error_read']                                  = '<b>Las páginas no se pudieron leer.</b>'.$langFile['ERROR_READ_FOLDER_PART1'].'%spages/'.$langFile['ERROR_FOLDER_PART2'];
$langFile['SORTABLEPAGELIST_error_move']                                  = '<b>No se pudo mover la página a la nueva categoría.</b>'.$langFile['ERROR_SAVE_FOLDER_PART1'].'%spages/'.$langFile['ERROR_FOLDER_PART2'];
$langFile['SORTABLEPAGELIST_categoryEmpty']                               = 'No hay páginas disponibles';
$langFile['SORTABLEPAGELIST_TIP_DRATOREARRANGE']                          = 'Arrastra para reordenar.';

$langFile['SORTABLEPAGELIST_TIP_SUBCATEGORYOFPAGES_SINGULAR']             = 'Subcategoría de la página:';
$langFile['SORTABLEPAGELIST_TIP_SUBCATEGORYOFPAGES_PLURAL']               = 'Subcategoría de las páginas:';


// ---------- FORMULAR
$langFile['FORM_BUTTON_SUBMIT']                                           = 'Guardar';
$langFile['FORM_BUTTON_CANCEL']                                           = 'Resetear todas las entradas';


/*
* adminSetup.php
*/

// ---------- ADMIN SETUP (on toolTips tooTips.js converts the "[" and "]" tags in the title attribute to "<" ">")
$langFile['ADMINSETUP_TEXT_VERSION']                                      = '<span class="feinduraInline">fein<em>dura</em></span> version';
$langFile['ADMINSETUP_TEXT_PHPVERSION']                                   = 'PHP version';
$langFile['ADMINSETUP_TITLE_DOCUMENTROOT']                                = ' Raiz de la instalación';

$langFile['ADMINSETUP_TITLE_ERROR']                                       = 'Se han producido errores';
$langFile['ADMINSETUP_TOOLTIP_WRITEACCESSERROR']                          = 'Es necesario establecer los permisos de ficheros y directorios a %o.';

$langFile['ADMINSETUP_TEXT_WRITEACCESSERROR']                             = 'no se tiene acceso de escritura';
$langFile['ADMINSETUP_TEXT_ISFOLDERERROR']                                = 'no es un directorio';

// ---------- general Settings
$langFile['ADMINSETUP_GENERAL_error_save']                                = $langFile['ERROR_SAVE_SETTINGS'].$langFile['ERROR_SAVE_FILE'].'%sconfig/admin.config.php';

$langFile['ADMINSETUP_GENERAL_h1']                                        = 'Configuración Básica';

$langFile['ADMINSETUP_GENERAL_TEXT_DOCUMENTROOT']                         = 'Raiz de la instalación';
$langFile['ADMINSETUP_GENERAL_TOOLTIP_DOCUMENTROOT']                      = 'Por favor inserte la ruta raiz de su instalacion de feindura.[br][span class=hint]e.g. &quot;/server/user/htdocs&quot;[/span]';
$langFile['ADMINSETUP_GENERAL_field1']                                    = 'URL del sitio web';
$langFile['ADMINSETUP_GENERAL_field1_tip']                                = 'La URL de tu sitio web se añadirá automáticamente.';
$langFile['ADMINSETUP_GENERAL_field1_inputTip']                           = 'La URL sera añadida automáticamente';
$langFile['ADMINSETUP_GENERAL_field1_inputWarningText']                   = '¡Por favor, guarde los cambios!';
$langFile['ADMINSETUP_GENERAL_field2']                                    = 'ruta de feindura';
$langFile['ADMINSETUP_GENERAL_field2_tip']                                = 'La ruta se determinará automáticamente y se guardará la primera vez que se guarde la configuración.';
$langFile['ADMINSETUP_GENERAL_field2_inputTip']                           = 'La ruta será añadida automáticamente';
$langFile['ADMINSETUP_GENERAL_field2_inputWarningText']                   = '¡Por favor, guarde los cambios!';
$langFile['ADMINSETUP_GENERAL_field8']                                    = 'Ruta del sitio web';
$langFile['ADMINSETUP_GENERAL_field8_tip']                                = 'Ruta [strong]absoluta[/strong] de su sitio web.[br][br][span class=hint]Puede también contener nombres de ficheros ej. &quot;/website/index.php&quot;[/span]';
$langFile['ADMINSETUP_GENERAL_editfiles_additonal']                       = '[br][br]Estos ficheros pueden editarse más abajo, o en la configuración del sitio web (si está activado en la configuración de usuario).[br][br]';
$langFile['ADMINSETUP_GENERAL_field5']                                    = 'Ruta a los ficheros del sitio web';
$langFile['ADMINSETUP_GENERAL_field5_tip']                                = 'Aquí puedes añadir una ruta a ficheros específicos de tu sitio web, los cuales podrán editarse en [span class=feinduraInline]fein[em]dura[/em][/span].'.$langFile['ADMINSETUP_GENERAL_editfiles_additonal'];
$langFile['ADMINSETUP_GENERAL_field6']                                    = 'Ruta para hojas de estilo';
$langFile['ADMINSETUP_GENERAL_field6_tip']                                = 'Aquí puedes añadir una ruta a ficheros de hojas de estilo que podrán editarse en [span class=feinduraInline]fein[em]dura[/em][/span].'.$langFile['ADMINSETUP_GENERAL_editfiles_additonal'];
$langFile['ADMINSETUP_GENERAL_TEXT_PERMISSIONS']                          = 'Permisos para ficheros y carpetas';
$langFile['ADMINSETUP_GENERAL_TIP_PERMISSIONS']                           = 'Cada fichero o carpeta creado po [span class=feinduraInline]fein[em]dura[/em][/span] tendrá estos permisos.';
$langFile['ADMINSETUP_TEXT_VARNAMEPAGE']                                  = 'Nombre variable URL para las páginas';
$langFile['ADMINSETUP_TEXT_VARNAMECATEGORY']                              = 'Nombre variable URL para las categorías';
$langFile['ADMINSETUP_TEXT_VARNAMEMODUL']                                 = 'Nombre variable URL para los módulos';
$langFile['ADMINSETUP_TIP_VARNAME']                                       = 'El nombre que se utilizará en la URL para enlazar a las páginas.';
$langFile['ADMINSETUP_TIP_EMPTYVARNAME']                                  = 'Si el campo se deja vacío se utilizará el nombre estándar: ';
$langFile['ADMINSETUP_TEXT_TIMEZONE']                                     = 'Franja horaria';
$langFile['ADMINSETUP_TIP_TIMEZONE']                                      = 'Solo se utilizará por el [span class=feinduraInline]fein[em]dura[/em][/span] panel de administración.';
$langFile['ADMINSETUP_GENERAL_PRETTYURL']                               = 'Formato URL';
$langFile['ADMINSETUP_GENERAL_PRETTYURL_true']                          = 'URLs bonitas';
$langFile['ADMINSETUP_GENERAL_PRETTYURL_true_example']                  = '/%s/example-category/example-page';
$langFile['ADMINSETUP_GENERAL_PRETTYURL_false']                         = 'URLs con variables';
$langFile['ADMINSETUP_GENERAL_PRETTYURL_false_example']                 = 'index.php?%s=1&%s=1';
$langFile['ADMINSETUP_GENERAL_PRETTYURL_tip']                           = 'El formato de la URL que será utilizado para enlazar a las páginas.[br][br]Las URLs bonitas solo funcionan si el módulo [strong]mod_rewrite[/strong] del servidor [strong]Apache Server[/strong] está disponible.';
$langFile['ADMINSETUP_GENERAL_PRETTYURL_warning']                       = '¡ATENCIÓN!::[span class=red]Si se produce un error mientras se utilizan URLs bonitas se debe eliminar el archivo [strong].htaccess file[/strong] de la raiz de la instalación.[/span][br][br](En algunos programas FTP tienes que activar la opción de mostrar ficheros ocultos primero para poder ver el archivo .htaccess file)';

// ---------- Pretty url ERRORs
$langFile['ADMINSETUP_GENERAL_PRETTYURL_error_save']                    = '<b>Las URLs bonitas</b> no pudieron activarse'.$langFile['ERROR_SAVE_FILE'].'/.htaccess';
$langFile['ADMINSETUP_GENERAL_PRETTYURL_error_modul']                   = '<b>Las URLs bonitas</b> no pudieron activarse porque no se encontró el módulo MOD_REWRITE del servidor Apache';

// ---------- cache settings
$langFile['ADMINSETUP_TEXT_CACHE']                                        = 'Activar caché';
$langFile['ADMINSETUP_TIP_CACHE']                                         = 'Si se activa, todas las páginas se guardarán en caché lo que incrementará la velocidad del sitio web, pero también puede que no se muestre el contenido actual.[br][br][span class=hint]La caché se genera al guardar las páginas.[/span]';
$langFile['ADMINSETUP_TEXT_CACHETIMEOUT']                                 = 'Cache tiempo límite';
$langFile['ADMINSETUP_TIP_CACHETIMEOUT']                                  = 'Indica el tiempo durante el cual la caché es válida. Después volverá a generarse actualizando así el contenido.';
$langFile['ADMINSETUP_HINT_CACHETIMEOUT']                                 = 'horas';

// ---------- editor Settings
$langFile['adminSetup_editorSettings_h1']                                 = 'Configuración del editor HTML';
$langFile['ADMINSETUP_TEXT_EDITOR_HTMLLAWED']                             = 'El filtro HTML (utiliza <a href="http://www.bioinformatics.org/phplabware/internal_utilities/htmLawed/" target="_blank">htmlLawed</a>)';
$langFile['ADMINSETUP_TIP_EDITOR_HTMLLAWED']                              = 'Filtra el código HTML antes de guardarlo. Esto puede causar problemas en código HTML con mucho javascript.';
$langFile['ADMINSETUP_TEXT_EDITOR_SAFEHTML']                              = 'HTML seguro (<a href="http://www.bioinformatics.org/phplabware/internal_utilities/htmLawed/htmLawed_README.htm#s3.6" target="_blank">detalles</a>)';
$langFile['ADMINSETUP_TIP_EDITOR_SAFEHTML']                               = 'El código HTML será filtrado con los ajustes más seguros. Esto significa que por ejemplo las etiquetas &lt;applet&gt;,&lt;embed&gt;,&lt;embed&gt;,&lt;object &gt; and &lt;script&gt; no están permitidas.';
$langFile['ADMINSETUP_TEXT_EDITOR_EDITORSTYLES']                          = 'activar selección de estilo';
$langFile['ADMINSETUP_TIP_EDITOR_EDITORSTYLES']                           = 'La seleccio de estilos te permite utilizar elementos HTML propios en el editor HTML.[br][br][span class=hint]Si esta opción está activada, puedes editar/crear elementos HTML más abajo.[/span]';
$langFile['ADMINSETUP_TEXT_EDITOR_SNIPPETS']                              = 'activar bloques de código';
$langFile['ADMINSETUP_TIP_EDITOR_SNIPPETS']                               = 'Permite introducir bloques de código en las páginas.[br]Pulsa sobre el icono: [img class=icons src=library/thirdparty/ckeditor/plugins/feinduraSnippets/feinduraSnippetsIcon.png] del editor HTML[br][br][span class=hint]Si esta opción está activada, puedes editar/crear bloques de código más abajo.[/span]';
$langFile['adminSetup_editorSettings_field1']                             = 'Modo tecla INTRO';
$langFile['adminSetup_editorSettings_field1_hint']                        = 'MAYUSCULAS + INTRO genera un &quot;%s&quot;';
$langFile['adminSetup_editorSettings_field1_tip']                         = 'Establece que etiqueta HTML se añadirá al presionar la tecla INTRO en el editor HTML.[br][br][span class=hint]'.$langFile['adminSetup_editorSettings_field1_hint'].'.[/span]';
$langFile['adminSetup_editorSettings_field3_inputTip']                    = 'Si se deja vacío no se utilizará ningún atributo ID.';
$langFile['adminSetup_editorSettings_field4_inputTip']                    = 'Si se deja vacío no se utilizará ningún atributo CLASS';

// THUMBNAILS Settings
$langFile['adminSetup_thumbnailSettings_h1']                              = 'Configuración de miniaturas';

// ---------- styleFile Settings
$langFile['adminSetup_styleFileSettings_h1']                              = 'Editar la selección de estilos del editor HTML';
$langFile['adminSetup_styleFileSettings_error_save']                      = '<b>El fichero &quot;EditorStyles.js&quot; no pudo guardarse.</b>'.$langFile['ERROR_SAVE_FILE'];

// ---------- editFiles Settings
$langFile['EDITFILESSETTINGS_TITLE_STYLESHEETS']                          = 'Editar ficheros de hojas de estilo';
$langFile['EDITFILESSETTINGS_TITLE_WEBSITEFILES']                         = 'Editar ficheros del sitio web';
$langFile['EDITFILESSETTINGS_TITLE_SNIPPETS']                             = 'Editar bloques de código';
$langFile['EDITFILESSETTINGS_TEXT_NODIR']                                 = 'no es un directorio válido!';
$langFile['EDITFILESSETTINGS_TEXT_CHOOSEFILE']                            = 'Elige un fichero';
$langFile['EDITFILESSETTINGS_TEXT_CREATEFILE']                            = 'Crear nuevo fichero';
$langFile['EDITFILESSETTINGS_TIP_CREATEFILE']                             = 'Si escribes aquí un nombre de fichero, se creará un nuevo fichero y [strong]el fichero actual ¡no será guardado![/strong]';
$langFile['EDITFILESSETTINGS_TEXT_NOFILE']                                = 'No ha ficheros disponibles';

$langFile['EDITFILESSETTINGS_TEXT_DELETEFILE']                            = 'Eliminar este fichero';
$langFile['EDITFILESSETTINGS_TEXT_DELETEFILE_QUESTION']                   = '¿Realmente quiers eliminar el fichero %s?';

$langFile['EDITFILESSETTINGS_ERROR_SAVEFILE']                             = '<b>El fichero no pudo guardarse.</b>'.$langFile['ERROR_SAVE_FILE'];
$langFile['EDITFILESSETTINGS_ERROR_DELETEFILE']                           = '<b>No se pudo eliminar el fichero.</b>'.$langFile['ERROR_SAVE_FILE'];

/*
* pageSetup.php
*/

// ---------- CATEGORY SETUP (on toolTips tooTips.js converts the "[" and "]" tags in the title attribute to "<" ">")
$langFile['PAGESETUP_PAGES_TIP_TAG']                                      = 'Las etiquetas pueden utilizarse para crear conexiones entre páginas (dependiendo de la programación del sitio web)';

// ---------- page settings
$langFile['PAGESETUP_PAGES_TITLE_NONCATEGORYPAGES']                       = 'Páginas sin categoría';
$langFile['PAGESETUP_PAGES_TEXT_CREATEPAGES']                             = 'Crear/borrar páginas';
$langFile['PAGESETUP_PAGES_TIP_CREATEPAGES']                              = 'Indica si el usuario puede crear y borrar páginas sin categoría.';
$langFile['PAGESETUP_PAGES_TEXT_UPLOADTHUMBNAILS']                        = 'Subir miniaturas';
$langFile['PAGESETUP_PAGES_TIP_UPLOADTHUMBNAILS']                         = 'Indica si el usuario puede subir miniatura para páginas sin categoría.';
$langFile['PAGESETUP_PAGES_TEXT_EDITTAGS']                                = 'Editar etiquetas';
$langFile['PAGESETUP_PAGES_TIP_EDITTAGS']                                 = 'Indica si el usuario puede editar etiquetas en páginas sin categoría.[br]'.$langFile['PAGESETUP_PAGES_TIP_TAG'];
$langFile['PAGESETUP_PAGES_TEXT_ACTIVATEPLUGINS']                         = 'Activar complemento';
$langFile['PAGESETUP_PAGES_TIP_ACTIVATEPLUGINS']                          = 'Indica si el usuario puede utilizar complementos en páginas sin categoría.';

// ---------- category settings
$langFile['PAGESETUP_CATEGORY_TITLE_CATEGORIES']                          = 'Gestionar categorías';
$langFile['PAGESETUP_CATEGORY_TEXT_CATEGORYNAME']                         = 'Nombre';

$langFile['PAGESETUP_CATEGORY_TEXT_CREATECATEGORY']                       = 'Crear nueva categoría';
$langFile['PAGESETUP_CATEGORY_TEXT_CREATECATEGORY_CREATED']               = 'Nueva categoría creada';
$langFile['PAGESETUP_CATEGORY_TEXT_CREATECATEGORY_UNNAMED']               = 'Categoría sin nombre';

$langFile['PAGESETUP_CATEGORY_TEXT_DELETECATEGORY']                       = 'Eliminar categoría';
$langFile['PAGESETUP_CATEGORY_TEXT_DELETECATEGORY_WARNING']               = 'ATENCIÓN: Se eliminarán también todas las páginas incluidas en esta categoría!';
$langFile['PAGESETUP_CATEGORY_TEXT_DELETECATEGORY_DELETED']               = 'Categoría eliminada';
$langFile['PAGESETUP_CATEGORY_TEXT_DELETECATEGORY_QUESTION_START']        = 'Eliminar categoría'; // Kategorie "test" löschen?
$langFile['PAGESETUP_CATEGORY_TEXT_DELETECATEGORY_QUESTION_END']          = '?';

$langFile['PAGESETUP_CATEGORY_TEXT_MOVECATEGORY_MOVED']                   = 'Categoría movida';
$langFile['PAGESETUP_CATEGORY_TIP_MOVECATEGORY_UP']                       = 'Mover categoría hacia arriba';
$langFile['PAGESETUP_CATEGORY_TIP_MOVECATEGORY_DOWN']                     = 'Mover categoría hacia abajo';

$langFile['PAGESETUP_CATEGORY_ERROR_CREATECATEGORY']                      = '<b>No pudo crearse una nueva categoría.</b>'.$langFile['ERROR_SAVE_FOLDER_PART1'].'%sconfig/'.$langFile['ERROR_FOLDER_PART2'];
$langFile['PAGESETUP_CATEGORY_ERROR_CREATEDIR']                           = '<b>No pudo crearse el directorio para la nueva categoría.</b>'.$langFile['ERROR_SAVE_FOLDER_PART1'].'%spages/'.'&quot; Ordners.';
$langFile['PAGESETUP_CATEGORY_ERROR_DELETECATEGORY']                      = '<b>No se pudo eliminar la categoría</b>'.$langFile['ERROR_SAVE_FILE'].'%sconfig/category.config.php';
$langFile['PAGESETUP_CATEGORY_ERROR_DELETEDIR']                           = '<b>No se pudo eliminar el directorio de la categoría.</b>'.$langFile['ERROR_SAVE_FOLDER_PART1'].'%spages/'.$langFile['ERROR_FOLDER_PART2'];
$langFile['PAGESETUP_CATEGORY_ERROR_SAVE']                                = $langFile['ERROR_SAVE_SETTINGS'].$langFile['ERROR_SAVE_FILE'].'%sconfig/category.config.php';


$langFile['PAGESETUP_CATEGORY_TITLE_ADVANCEDSETTINGS']                    = 'Configuración avanzada';
$langFile['PAGESETUP_CATEGORY_HINT_ADVANCEDSETTINGS']                     = 'Si se activan estas opciones estas sobreescribirán las definidas en la configuración de miniaturas de arriba y la '.$langFile['adminSetup_editorSettings_h1'].' en la <a href="?site=adminSetup">administrator-settings</a>.';

$langFile['PAGESETUP_CATEGORY_TIP_STYLESHEETS_EMPTY']                     = 'Si se dejan todos los campos en blanco entonces se utilizará la configuración de hojas de estilos de la '.$langFile['adminSetup_editorSettings_h1'].'.';

$langFile['PAGESETUP_CATEGORY_TEXT_CATEGORYSTATUS']                       = 'Estado de la categoría';
$langFile['PAGESETUP_CATEGORY_TIP_CATEGORYSTATUS']                        = 'Indica si la categoria es visible en el sitio web.';
$langFile['PAGESETUP_CATEGORY_TEXT_CREATEPAGES']                          = 'Crear/Eliminar páginas';
$langFile['PAGESETUP_CATEGORY_TIP_CREATEPAGES']                           = 'Indica si el usuario puede crear y eliminar página en esta categoría.';
$langFile['PAGESETUP_CATEGORY_TEXT_UPLOADTHUMBNAILS']                     = 'Subir miniaturas';
$langFile['PAGESETUP_CATEGORY_TIP_UPLOADTHUMBNAILS']                      = 'Indica si el usuario puede subir miniaturas para páginas de esta categoría';
$langFile['PAGESETUP_CATEGORY_TEXT_EDITTAGS']                             = 'Editar etiquetas';
$langFile['PAGESETUP_CATEGORY_TIP_EDITTAGS']                              = 'Indica si el usuario puede editar etiquetas en páginas de esta categoría.[br]'.$langFile['PAGESETUP_PAGES_TIP_TAG'];
$langFile['PAGESETUP_CATEGORY_TEXT_ACTIVATEPLUGINS']                      = 'Activar complementos';
$langFile['PAGESETUP_CATEGORY_TIP_ACTIVATEPLUGINS']                       = 'Indica si el usuario puede utilizar complementos en páginas de esta categoría.';

$langFile['PAGESETUP_TEXT_EDITPAGEDATE']                                  = 'Editar fecha de la página';
$langFile['PAGESETUP_TIP_EDITPAGEDATE']                                   = 'La fecha de la página puede utilizarse para ordenar las páginas cronológicamente';
$langFile['PAGESETUP_TEXT_PAGEDATERANGE']                                 = 'como rango de fechas';

$langFile['PAGESETUP_TEXT_FEEDS']                                         = 'Activar fuentes';
$langFile['PAGESETUP_TIP_FEEDS']                                          = 'Activar fuentes RSS 2.0 y Atom para páginas sin categorías.';
$langFile['PAGESETUP_CATEGORY_TIP_FEEDS']                                 = 'Activar fuentes RSS 2.0 y Atom para páginas en esta categoría.';

$langFile['PAGESETUP_TEXT_SUBCATEGORY']                                   = 'Editar subcategorías';
$langFile['PAGESETUP_TIP_SUBCATEGORY']                                    = 'Permite elegir una subcategoría para cada página.';

$langFile['PAGESETUP_TIP_SORTBYPAGEDATE']                                 = 'Ordenar páginas cronológicamente';
$langFile['PAGESETUP_TIP_SORTBYDATE']                                     = 'Las páginas más recientes aparecerán [strong]encima[/strong]. [br][br][span class=hint]Desactiva la ordenación manual.[/span]';

$langFile['PAGESETUP_TEXT_SORTMANUALLY']                                  = 'Ordenar páginas manualmente';
$langFile['PAGESETUP_TIP_SORTMANUALLY']                                   = 'Las páginas que se creen posteriormente aparecerán [strong]encima[/strong].';

$langFile['PAGESETUP_TEXT_SORTALPHABETICAL']                              = 'Ordenar páginas alfabéticamente';
$langFile['PAGESETUP_TIP_SORTALPHABETICAL']                               = '[span class=hint]Desactiva la ordenación manual.[/span]';

$langFile['PAGESETUP_TEXT_SORTREVERSE']                                   = 'invertir orden';
$langFile['PAGESETUP_TIP_SORTREVERSE']                                    = 'Invierte la ordenación de las páginas.';


/*
* websiteSetup.php
*/

// ---------- WEBSITE SETUP (on toolTips tooTips.js converts the "[" and "]" tags in the tittle attribute to "<" ">")
$langFile['websiteSetup_websiteConfig_error_save']                        = $langFile['ERROR_SAVE_SETTINGS'].$langFile['ERROR_SAVE_FILE'].'%sconfig/website.config.php';

$langFile['websiteSetup_websiteConfig_h1']                                = 'Configuración del sitio web';
$langFile['websiteSetup_websiteConfig_field1']                            = 'Título del sitio web';
$langFile['websiteSetup_websiteConfig_field1_tip']                        = 'El título del sitio web que se monstrará en la barra del navegador.';
$langFile['websiteSetup_websiteConfig_field2']                            = 'Editor';
$langFile['websiteSetup_websiteConfig_field2_tip']                        = 'El nombre de la organciación/empresa/persona que ha creado el sitio web.';
$langFile['websiteSetup_websiteConfig_field3']                            = 'Derechos de autor';
$langFile['websiteSetup_websiteConfig_field3_tip']                        = 'El dueño de los derechos de autor del sitio web.';
$langFile['websiteSetup_websiteConfig_field4']                            = 'Palabras clave para motores de búsqueda';
$langFile['websiteSetup_websiteConfig_field4_tip']                        = 'Lista de palabras clave que los motores de búsqueda utilizarán para indexar el contenido de tu sitio web. Por ejemplo, si es un sitio de ocio podríamos utilizar: pubs, discotecas, actividades, despedidas de soltero. Es decir, las palabras por las que quieres que tu página aparezca en los resultados de las búsquedas.';
$langFile['websiteSetup_websiteConfig_field4_inputTip']                   = 'Las palabras clave deben ir separadas por &quot;,&quot;::'.$langFile['TEXT_EXAMPLE'].':[br]plabraclave1,plabraclave2,etc';
$langFile['websiteSetup_websiteConfig_field5']                            = 'Descripción del sitio web';
$langFile['websiteSetup_websiteConfig_field5_tip']                        = 'Una corta descripción de tu sitio web que aparecerá en los resultados de los motores de búsqueda.';
$langFile['websiteSetup_websiteConfig_field5_inputTip']                   = 'Un texto corto de no más de tres líneas.';

$langFile['WEBSITESETUP_TITLE_PAGESETTINGS']                              = 'Configuración avanzada del sitio web';
$langFile['WEBSITESETUP_TEXT_MAINTENANCE']                                = 'Desactivar sitio web';
$langFile['WEBSITESETUP_TIP_MAINTENANCE']                                 = 'Muestra un mensaje que dice que nuestro sitio web está siendo modificado, en lugar de mostrar nuestra página de inicio.';
$langFile['WEBSITESETUP_TEXT_SITEMAPFILES']                               = 'Crear mapa del sitio (<a href="http://www.sitemaps.org/" target="_blank">Detalles</a>)';
$langFile['WEBSITESETUP_TIP_SITEMAPFILES']                                = 'El mapa del sitio facilita la indexación de nuestro sitio a los motores de búsqueda. Es como proporcionarle un índice de nuestra web a Google, Bing, etc';
$langFile['WEBSITESETUP_TEXT_VISITORTIMEZONE']                            = 'Obtener la zona horaria de los visitantes';
$langFile['WEBSITESETUP_TIP_VISITORTIMEZONE']                             = 'Intenta obtener la zona horaria de las personas que visitan nuestro sitio web para mostrar la fecha en el formato correspondiente a dicha zona..[br][br][span class=hint]El sitio web se recargará en la primera visita.[/br]';
$langFile['WEBSITESETUP_TEXT_MULTILANGUAGEWEBSITE']                       = 'Sitio web multilingüe';
$langFile['WEBSITESETUP_TEXT_MAINLANGUAGE']                               = 'Idioma principal';
$langFile['WEBSITESETUP_TIP_MAINLANGUAGE']                                = 'El idioma que será seleccionado si no se puede determinar automáticamente.';
$langFile['WEBSITESETUP_TEXT_DATEFORMAT']                                 = 'Formato de fecha';
$langFile['WEBSITESETUP_TIP_DATEFORMAT']                                  = 'Se utilizará en el sitio web.';


/*
* statisticSetup.php
*/

// ---------- STATISITC SETUP (on toolTips tooTips.js converts the "[" and "]" tags in the tittle attribute to "<" ">")
$langFile['STATISTICSSETUP_ERROR_SAVE']                                   = $langFile['ERROR_SAVE_SETTINGS'].$langFile['ERROR_SAVE_FILE'].'%sconfig/statistic.config.php';

$langFile['STATISTICSSETUP_TITLE_STATISTICSSETTINGS']                     = 'Configuración de estadísticas';
$langFile['STATISTICSSETUP_TEXT_REFERERNUMBER']                           = 'Número de <b>URLs referidas</b>';
$langFile['STATISTICSSETUP_TIP_REFERERNUMBER']                            = 'Indica cuantas URLS referidas ([i]URLs que enlazan con tu sitio web[/i]) seran guardadas y mostradas.';
$langFile['STATISTICSSETUP_TEXT_ACTIVITYNUMBER']                          = 'Número de <b>registros de actividad</b>';
$langFile['STATISTICSSETUP_TIP_ACTIVITYNUMBER']                           = 'Indica cuantos registros de actividad serán guardados y mostrados.';


$langFile['statisticSetup_clearStatistic_h1']                             = 'Eliminar estadísticas';
$langFile['statisticSetup_clearStatistics_websiteStatistic']              = 'Estadísticas del sitio web';
$langFile['statisticSetup_clearStatistics_websiteStatistic_tip']          = '[strong]Contiene[/strong][ul][li]Número total de visitas[/li][li]Número total de arañas web[/li][li]Fecha de la primera visita[/li][li]Fecha de la última visita[/li][li]Uso de navegadores[/li][/ul]';
$langFile['statisticSetup_clearStatistics_pagesStatistic']                = 'Estadísticas de las páginas';
$langFile['statisticSetup_clearStatistics_pagesStatistic_tip']            = '[strong]Contiene[/strong][ul][li]Número de visitas a la página[/li][li]Fecha de la primera visita a la página[/li][li]Fecha de la última visíta a la página[/li][li]Menor tiempo de estancia[/li][li]Mayor tiempo de estancia[/li][li]Palabras clave que dirigieron a esta página[/li][/ul]';
$langFile['statisticSetup_clearStatistics_pagesStaylengthStatistics']     = 'solo estadísticas de la duración de las visitas a la página';
$langFile['statisticSetup_clearStatistics_pagesStaylengthStatistics_tip'] = '';
$langFile['statisticSetup_clearStatistics_refererLog']                    = 'Registro de URLs referidas'; // engl.: referer
$langFile['statisticSetup_clearStatistics_refererLog_tip']                = 'Una lista de URLs que enlazan a tu sitio web.';
$langFile['statisticSetup_clearStatistics_taskLog']                       = 'Registro de actividades';
$langFile['statisticSetup_clearStatistics_taskLog_tip']                   = 'Una lista de actividades de tu sitio web.';

$langFile['statisticSetup_clearStatistics_question_h1']                   = '¿Estás seguro de querer eliminar estas estadísticas?';

$langFile['statisticSetup_clearStatistic_pagesStatistics_error_read']     = 'Error al eliminar las estadísticas de la página.'.$langFile['ERROR_SAVE_FOLDER_PART1'].'%sstatistics/pages/'.$langFile['ERROR_FOLDER_PART2'];

/*
* userSetup.php
*/

$langFile['USERSETUP_h1']                                                 = 'Gestión de usuarios';
$langFile['USERSETUP_userSelection']                                      = 'Usuarios';

$langFile['USERSETUP_createUser']                                         = 'Crear nuevo usuario';
$langFile['USERSETUP_createUser_created']                                 = 'Nuevo usuario creado';
$langFile['USERSETUP_createUser_unnamed']                                 = 'Usuario sin nombre';

$langFile['USERSETUP_deleteUser']                                         = 'Eliminar usuario';
$langFile['USERSETUP_deleteUser_deleted']                                 = 'Usuario eliminado';

$langFile['USERSETUP_username']                                           = 'Nombre del usuario';
$langFile['USERSETUP_username_missing']                                   = 'No se le ha asignado un nombre a este usuario.';
$langFile['USERSETUP_password']                                           = 'Contraseña';
$langFile['USERSETUP_password_change']                                    = 'cambiar contraseña';
$langFile['USERSETUP_password_confirm']                                   = 'Confirmación de contraseña';
$langFile['USERSETUP_password_confirm_wrong']                             = 'Las contraseñas no coinciden.';
$langFile['USERSETUP_password_missing']                                   = 'No hay establecida ninguna contraseña.';
$langFile['USERSETUP_password_success']                                   = '¡Contraseña cambiada con éxito!';
$langFile['USERSETUP_email']                                              = 'Correo electrónico';
$langFile['USERSETUP_email_tip']                                          = 'Si el usuario olvida su contraseña se le enviará una nueva a esta dirección de correo.';

$langFile['USERSETUP_admin']                                              = 'Administrador';
$langFile['USERSETUP_admin_tip']                                          = 'Indica si el usuario tiene permisos de administrador.';

$langFile['USERSETUP_error_create']                                       = '<b> No pudo crearse un nuevo usuario.</b>'.$langFile['ERROR_SAVE_FILE'].'%sconfig/user.config.php';
$langFile['USERSETUP_error_save']                                         = $langFile['ERROR_SAVE_SETTINGS'].$langFile['ERROR_SAVE_FILE'].'%sconfig/user.config.php';

// ---------- USER PERMISSION
$langFile['USERSETUP_USERPERMISSIONS_TITLE']                              = 'Permisos del usuario';
$langFile['USERSETUP_USERPERMISSIONS_TEXT_ACTIVATEWEBSITESETTINGS']       = 'Editar configuración del sitio web';
$langFile['USERSETUP_USERPERMISSIONS_TEXT_EDITWEBSITEFILES']              = 'Editar los ficheros del sitio wen en la <a href="index.php?site=websiteSetup">Configuración del sitio web</a>';
$langFile['USERSETUP_USERPERMISSIONS_TEXT_EDITSTYLESHEETS']               = 'Editar las hojas de estilo en la <a href="index.php?site=websiteSetup">Configuración del sitio web</a>';
$langFile['USERSETUP_USERPERMISSIONS_TEXT_EDITSNIPPETS']                  = 'Editar bloques de código en la <a href="index.php?site=websiteSetup">Configuración del sitio web</a>';
$langFile['USERSETUP_USERPERMISSIONS_TEXT_FILEMANAGER']                   = 'Activar el gestor de archivos';
$langFile['USERSETUP_USERPERMISSIONS_TEXT_FRONTENDEDITING']               = 'Activar la edición directa';

$langFile['USERSETUP_USERPERMISSIONS_TEXT_USERINFORMATION']               = '<strong>Información del usuario</strong> en la página de  <a href="?site=dashboard">'.$langFile['BUTTON_DASHBOARD'].'</a>';
$langFile['USERSETUP_USERPERMISSIONS_TIP_USERINFORMATION']                = 'Información del usuario::Este texto se mostrará en la página de '.$langFile['BUTTON_DASHBOARD'].' del panel de administración de [span class=feinduraInline]fein[em]dura[/em][/span].';
$langFile['USERSETUP_USERPERMISSIONS_TIP_USERINFORMATION_NOINFO']         = 'Si no quieres mostrar ninguna información del usuario, deja este campo vacío.';

$langFile['USERSETUP_USERPERMISSIONS_TITLE_EDITABLECATEGORIES-PAGES']     = 'Selecciona las categorías y páginas que el usuario podrá editar<br>(Si no se selecciona ninguna, todo será editable)';
$langFile['USERSETUP_USERPERMISSIONS_TEXT_CLEARSELECTION']                = 'Borrar selección';

/*
* editor.php
*/

// ---------- page info
$langFile['EDITOR_TITLE_CREATEPAGE']                                      = 'Crear nueva página';
$langFile['EDITOR_TITLE_ADDLANGUAGE']                                     = 'Añadir &quot;%s&quot; a la página';
$langFile['EDITOR_pageinfo_lastsavedate']                                 = 'última edición el';
$langFile['EDITOR_pageinfo_lastsaveauthor']                               = 'por';
$langFile['EDITOR_pageinfo_linktothispage']                               = 'Enlace a esta página';
$langFile['EDITOR_pageinfo_id']                                           = 'ID de la página';
$langFile['EDITOR_pageinfo_id_tip']                                       = 'La página se guardará en el servidor con este identificador.';
$langFile['EDITOR_pageinfo_category']                                     = 'Categoría';
$langFile['EDITOR_pageinfo_category_noCategory']                          = 'sin categoría';

$langFile['EDITOR_TEXT_CHOOSETEMPLATE']                                   = 'Usar plantilla';
$langFile['EDITOR_TEXT_TEMPALATECOPYADDITION']                            = 'copiar';

$langFile['EDITOR_block_edited']                                          = 'fue editada';
$langFile['EDITOR_pageNotSaved']                                          = 'no guardada';

$langFile['EDITOR_EDITLINK']                                              = 'Editar enlace';

// ---------- page settings
$langFile['EDITOR_pagestatistics_h1']                                     = 'Estadísticas';

$langFile['EDITOR_pageSettings_title']                                    = 'Título';
$langFile['EDITOR_pageSettings_title_tip']                                = 'El título de la página, puede contener las siguientes etiquetas HTML:[br]<a> <span> <em> <strong> <i> <b> <abbr> <code> <samp> <kbd> <var>';
$langFile['EDITOR_pageSettings_field1']                                   = 'Descripción';
$langFile['EDITOR_pageSettings_field1_inputTip']                          = 'Si se deja vacía se utiliza la descripción de la configuración del sitio web.';
$langFile['EDITOR_pageSettings_field1_tip']                               = 'Un pequeño resumen del contenido de la página. Esta descripción se utilizará en las meta etiquetas de la página.[br][br][span class=hint]'.$langFile['EDITOR_pageSettings_field1_inputTip'].'[/span]';
$langFile['EDITOR_pageSettings_field2']                                   = 'Etiquetas';
$langFile['EDITOR_pageSettings_field2_tip']                               = 'Las etiquetas serán palabras clave para esta página.';
$langFile['EDITOR_pageSettings_field2_tip_inputTip']                      = 'Las etiquetas deben ir separadas por &quot;,&quot; (coma).';
$langFile['EDITOR_pageSettings_field3']                                   = 'Fecha de la página';
$langFile['EDITOR_pageSettings_field3_tip']                               = 'La fecha puede utilizarse para ordenar las páginas cronológicamente. (ej. para eventos)';
$langFile['EDITOR_pageSettings_field4']                                   = 'Estado de la página';
$langFile['EDITOR_pageSettings_field4_tip']                               = '[strong]¡Solo si la página es pública podrá mostrarse en el sitio web![/strong]';

$langFile['EDITOR_PAGESETTINGS_NOPAGEDATE']                               = 'Sin fecha';

$langFile['EDITOR_TEXT_SUBCATEGORY']                                      = 'Subcategoría';
$langFile['EDITOR_TIP_SUBCATEGORY']                                       = 'Permite crear un submenú para esta página en el sitio web.';

$langFile['EDITOR_BUTTON_RESTORELASTSTATE']                               = 'Restaurar a la versión de %s';
$langFile['EDITOR_MESSAGE_RESTOREDTOLASTSTATE']                           = 'Restaurado a la versión de %s.';

// ---------- page advanced settings
$langFile['EDITOR_advancedpageSettings_h1']                               = 'Configuración del editor HTML para la página';

$langFile['EDITOR_advancedpageSettings_field1']                           = 'Hoja de estilo para la página';
$langFile['EDITOR_advancedpageSettings_stylesheet_ifempty']               = 'Si los campos están vacios se utilizará la configuración establecida en la categoría.';

$langFile['EDITOR_htmleditor_hotkeys_h1']                                 = 'Atajos de teclado';
$langFile['EDITOR_htmleditor_hotkeys_field1']                             = 'seleccionar todo';
$langFile['EDITOR_htmleditor_hotkeys_field2']                             = 'copiar';
$langFile['EDITOR_htmleditor_hotkeys_field3']                             = 'pegar';
$langFile['EDITOR_htmleditor_hotkeys_field4']                             = 'cortar';
$langFile['EDITOR_htmleditor_hotkeys_field5']                             = 'deshacer';
$langFile['EDITOR_htmleditor_hotkeys_field6']                             = 'rehacer';
$langFile['EDITOR_htmleditor_hotkeys_field7']                             = 'asignar enlace';
$langFile['EDITOR_htmleditor_hotkeys_field8']                             = 'negrita';
$langFile['EDITOR_htmleditor_hotkeys_field9']                             = 'itálica';
$langFile['EDITOR_htmleditor_hotkeys_field10']                            = 'subrayado';
$langFile['EDITOR_htmleditor_hotkeys_or']                                 = 'o';

$langFile['EDITOR_savepage_error_save']                                   .= $langFile['ERROR_SAVE_FOLDER_PART1'].'%spages/'.$langFile['ERROR_FOLDER_PART2'];// also in en.shared.php

// ---------- plugin settings
$langFile['EDITOR_pluginSettings_h1']                                     = 'Añadir complemento';
$langFile['EDITOR_TEXT_EDITPLUGINSINEDITOR']                              = 'Después de activar un complemento arrástralo en el lugar que quieras dentro del editor, o bien insertarlo directamente utilizandoel icono %s.';
$langFile['EDITOR_MESSAGE_PLUGINSSAVED']                                  = '<div class="alert alert-success">¡Complementos guardados!</div>';//<div class="alert">Click on a plugin to edit its properties.</div>';
$langFile['EDITOR_TIP_DRAGPLUGIN']                                        = 'Arrástra el plugin hasta el editor.';

/*
* unsavedPage.php
*/

$langFile['UNSAVEDPAGE_QUESTION_CONTINUE']                                = '¡La página ha sido modificada!<br><span class="brown">¿Quiéres continuar?</span>';

/*
* deletePage.php
*/

// ---------- DELETE PAGE
$langFile['deletePage_question_part1']                                    = '¿Realmente quiéres eliminar la página';
$langFile['deletePage_question_part2']                                    = '?';

$langFile['deletePage_notexisting_part1']                                 = 'La página';
$langFile['deletePage_notexisting_part2']                                 = 'no existe';

$langFile['deletePage_finish_error']                                      = 'ERROR: ¡No pudo eliminarse la página!';

/*
* deletePageLanguage.php
*/

// ---------- DELETE PAGE LANGUAGE

$langFile['WINDOWBOX_TEXT_DELETEPAGELANGUAGE_QUESTION']                   = '¿Realmente quieres eliminar el idioma &quot;%s&quot; para ésta página?';

/*
* addPageLanguage.php
*/

// ---------- ADD PAGE LANGUAGE

$langFile['WINDOWBOX_TEXT_ADDPAGE_SELECTLANGUAGE']                        = 'Selecciona idioma';


/*
* deletewebsiteLanguages.php
*/

// ---------- DELETE WEBSITE LANGUAGES

$langFile['WINDOWBOX_TITLE_DELETEWEBSITELANGUAGES_QUESTION']              = '¡Los siguientes idiomas serán eliminados de todas las páginas!<br>&quot;%s&quot;';
$langFile['WINDOWBOX_TEXT_DELETEWEBSITELANGUAGES_QUESTION']               = '¡Se ha desactivado el soporte multi idioma para el sitio web!<br>Todas las páginas se establecerán a (<b>%s</b>) anterior idioma principal.';


/*
* deletePageThumbnail.php
*/

// ---------- PAGE THUMBNAIL DELETE
$langFile['PAGETHUMBNAIL_TEXT_DELETE_QUESTION_START']                     = '¿Realmente quieres eliminar la miniatura';
$langFile['PAGETHUMBNAIL_TEXT_DELETE_QUESTION_END']                       = 'para la página?';
$langFile['PAGETHUMBNAIL_ERROR_DELETE']                                   = 'ERROR: ¡La miniatura no pudo eliminarse!';


/*
* uploadPageThumbnail.php
*/

// ---------- PAGE THUMBNAIL UPLOAD
$langFile['pagethumbnail_h1_part1']                                       = 'Subir miniatura para la página de';
$langFile['pagethumbnail_h1_part2']                                       = '';
$langFile['pagethumbnail_field1']                                         = 'Seleccionar imagen';

$langFile['pagethumbnail_thumbinfo_formats']                              = 'Solo están permitidos los siguientes formatos'; //<br><b>JPG</b>, <b>JPEG</b>, <b>GIF</b>, <b>PNG</b>
$langFile['pagethumbnail_thumbinfo_filesize']                             = 'tamaño máximo del fichero';
$langFile['pagethumbnail_thumbinfo_standardthumbsize']                    = 'Tamaño estándar de la imagen';

$langFile['pagethumbnail_thumbsize_h1']                                   = 'Establece el tamaño de la imagen tu mismo';
$langFile['pagethumbnail_thumbsize_width']                                = 'Ancho';
$langFile['pagethumbnail_thumbsize_height']                               = 'Alto';

$langFile['pagethumbnail_submit_tip']                                     = 'Subir imagen';

$langFile['PAGETHUMBNAIL_ERROR_nofile']                                   = 'No has seleccionado ningún fichero.';
$langFile['PAGETHUMBNAIL_ERROR_nouploadedfile']                           = 'Ningún fichero ha sido subido.';
$langFile['PAGETHUMBNAIL_ERROR_filesize']                                 = 'Probablemente el tamaño de la imagen subida es demasiado grande.<br>El tamaño máximo permitido es';
$langFile['PAGETHUMBNAIL_ERROR_wrongformat']                              = 'El fichero seleccionado no es de un formato soportado';
$langFile['PAGETHUMBNAIL_ERROR_NODIR_START']                              = 'la carpeta de miniaturas'; // The thumbnail-folder..
$langFile['PAGETHUMBNAIL_ERROR_NODIR_END']                                = 'no existe.';
$langFile['PAGETHUMBNAIL_ERROR_CREATEDIR_END']                            = 'no pudo crearse.';
$langFile['PAGETHUMBNAIL_ERROR_COULDNTMOVEFILE']                          = 'No pudo moverse el fichero subido a la carpeta de miniaturas %s.';
$langFile['PAGETHUMBNAIL_ERROR_CHANGEIMAGESIZE']                          = 'No se pudo redimiensionar la imagen.';
$langFile['PAGETHUMBNAIL_ERROR_deleteoldfile']                            = 'No se pudo eliminar la imagen antigua.';
$langFile['PAGETHUMBNAIL_TEXT_fileexists']                                = 'Ya existe una imagen con este nombre.<br>La imagen subida ha sido renombrada a';
$langFile['PAGETHUMBNAIL_TEXT_finish']                                    = 'Imagen subida con éxito.';

// -> BACKUP

$langFile['BACKUP_TITLE_BACKUP']                                          = 'Copia de seguridad';
$langFile['BACKUP_TITLE_RESTORE']                                         = 'Restaurar';

$langFile['BACKUP_TITLE_RESTORE_FROMFILES']                               = 'Elija una copia de seguridad existente';
$langFile['BACKUP_TITLE_RESTORE_FROMUPLOAD']                              = 'Subir copia de seguridad';

$langFile['BACKUP_TEXT_RESTORE_BACKUPBEFORERESTORE']                      = 'Hacer copia de seguridad antes de restaurar';

$langFile['BACKUP_BUTTON_DOWNLOAD']                                       = 'crear copia de seguridad actual';
$langFile['BACKUP_TEXT_BACKUP']                                           = 'Una copia de seguridad crea un archivo <code>.zip</code> con las carpetas de <span class="blue">"páginas","configuración"</span> y <span class="blue">"estadísticas"</span>.<br>La carpeta (upload) de subidas no se guardará.';
$langFile['BACKUP_TEXT_RESTORE']                                          = '<p>Selecciona un fichero de copia de seguridad de <span class="feinduraName"><span>fein</span>dura</span> para restaurar a un estado anterior.</p><div class="alert"><strong>¡Aviso!</strong> Una copia de seguridad del estado actual se creará antes de la restauración.</div>';
$langFile['BACKUP_TOOLTIP_DELETE']                                        = 'Eliminar copia de seguridad';
$langFile['BACKUP_TEXT_DELETE_QUESTION']                                  = '¿Realmente quiere eliminar %s?'; // really delete backup 2010-11-05 15:03?

$langFile['BACKUP_TITLE_LASTBACKUPS']                                     = 'Descargar copias de seguridad';
$langFile['BACKUP_TEXT_NOBACKUP']                                         = 'No hay ninguna copia de seguridad.';

$langFile['BACKUP_ERROR_FILENOTFOUND']                                    = 'Copia de seguridad no encontrada en:';
$langFile['BACKUP_ERROR_NORESTROEFILE']                                   = 'No se seleccionó ningún archivo de copia de seguridad para restaurar.';
$langFile['BACKUP_ERROR_DELETE']                                          = '¡No pudo eliminarse la copia de seguridad!';

// -> ADDONS

$langFile['ADDONS_TITLE_ADDON']                                           = 'Elije una extensión de <span class="feinduraInline">fein<em>dura</em></span>';
$langFile['ADDONS_TEXT_AUTHOR']                                           = 'Autor';
$langFile['ADDONS_TEXT_WEBSITE']                                          = 'Sitio web';
$langFile['ADDONS_TEXT_VERSION']                                          = 'Version';
$langFile['ADDONS_TEXT_REQUIREMENTS']                                     = 'Requerimientos';


// -> UPDATE

$langFile['UPDATE_TITLE']                                                 = 'El contenido debe actualizarse';
$langFile['UPDATE_TEXT_CHECKPATHS']                                       = 'Asegúrate de que las siguientes rutas son correctas antes de actualizar.';
$langFile['UPDATE_TEXT_BASEPATH']                                         = 'La ruta a <span class="feinduraInline">fein<em>dura</em></span>';
$langFile['UPDATE_TEXT_WEBSITEPATH']                                      = 'Ruta al sitio web';
$langFile['UPDATE_TEXT_SUCCESS']                                          = '¡Contenido actualizado con éxito!';
$langFile['UPDATE_BUTTON_UPDATE']                                         = 'ACTUALIZAR';
$langFile['UPDATE_ERROR_MOVEUPLOADFOLDER']                                = '¡La carpeta de subidas no pudo moverse! Por favor mueva la carpeta "%s" manualmente a  "tu carpeta_de_feindura/upload/".';
$langFile['UPDATE_ERROR_MOVEPAGESFOLDER']                                 = '¡Las páginas no pudieron copiarse! Por favor mueve la carpeta "%s" manualmente a "tu_carpeta_de_feindura/pages/".';
$langFile['UPDATE_ERROR_SAVEADMINCONFIG']                                 = 'La configuración del administrador no pudo actualizarse.';
$langFile['UPDATE_ERROR_SAVECATEGORYCONFIG']                              = 'La configuración de categorias no pudo actualizarse.';
$langFile['UPDATE_ERROR_SAVEUSERCONFIG']                                  = 'La configuración de usuarios no pudo actualizarse.';
$langFile['UPDATE_ERROR_SAVEWEBSITECONFIG']                               = 'La configuración del sitio web no pudo actualizarse.';
$langFile['UPDATE_ERROR_SAVEPAGES']                                       = 'Las páginas no pudieron actualizarse.';
$langFile['UPDATE_ERROR_CLEARACTIVITYLOG']                                = 'No pudo eliminarse el registro de actividades.';
$langFile['UPDATE_ERROR_SAVEWEBSITESTATISTICS']                           = 'Las estadísticas del sitio web no pudieron actualizarse.';
$langFile['UPDATE_ERROR_SAVEREFERERLOG']                                  = 'El registro de referidas no pudo actualizarse.';
$langFile['UPDATE_ERROR_DELETEOLDFILES']                                  = 'No se pudieron eliminar los ficheros y carpetas antiguos,<br>Por favor localice estas carpetas y archivos y elimínelos manualmente:';
$langFile['UPDATE_ERROR_RENAMESTATISTICSFOLDER']                          = 'No se pudo renombrar la carpeta "feinduraFolder/statistic" a "feinduraFolder/statistic<strong>s</strong>, por favor modifique el nombre manualmente"';


// -----------------------------------------------------------------------------------------------
// RETURN ****************************************************************************************
// -----------------------------------------------------------------------------------------------
return $langFile;
