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
 * The plugin file
 *
 * See the README.md for more.
 *
 * The following variables are available in this plugin:
 *
 *     - $feindura                  <- the current {@link Feindura} class instance with all its methods (use "$feindura->..")
 *     - $feinduraBaseURL           <- the base url of the feindura folder, e.g. "http://mysite.com/cms/"
 *     - $feinduraBasePath          <- the base path of the feindura folder, e.g. "/cms/". Be aware that this is a file system path and could differ from an URI path.
 *     - $pluginBaseURL             <- the base url of this plugins folder, e.g. "http://mysite.com/cms/plugins/examplePlugin/"
 *     - $pluginBasePath            <- the base path of this plugins folder, e.g. "/cms/plugins/examplePlugin/". Be aware that this is a file system path and could differ from an URI path.
 *     - $pluginConfig              <- contains the changed settings from the "config.php" from this plugin
 *     - $pluginName                <- the folder name of this plugin
 *     - $pluginNumber              <- the number of the plugin (to differ multiple plugins on the same page)
 *     - $pageContent               <- the pageContent array of the page which contains this plugin
 *     - the GeneralFunctions class <- for advanced methods. It's a static class so use "GeneralFunctions::exampleMethod(..);"
 *
 *
 * Example plugin:
 * <code>
 * <?php
 *
 * echo '<p>Plugin HTML</p>';
 *
 * ?>
 * </code>
 *
 * @package [Plugins]
 * @subpackage examplePlugin
 *
 * @author Fabian Vogelsteller <fabian@feindura.org>
 * @copyright Fabian Vogelsteller
 * @license http://www.gnu.org/licenses GNU General Public License version 3
 *
 */


// because this is just and example pluign we will do nothing but display the plugin config for the current page:
echo '<p>'.$pluginConfig['textToDisplay'].'</p>';
echo '<span>'.$pluginConfig['numberToDisplay'].'</span>';


?>