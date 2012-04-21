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
 * The plugin include file
 * 
 * See the README.md for more.
 * 
 * The following variables are available in this script when it gets included by the {@link Feindura::showPlugins()} method:
 *     - $this          -> the current {@link Feindura} class instance with all its methods (use "$this->..")
 *     - $pluginConfig  -> contains the changed settings from the "config.php" from this plugin
 *     - $pluginName    -> the folder name of this plugin
 *     - $pageContent   -> the pageContent array of the page which has this plugin activated 
 * 
 * This file MUST RETURN the plugin ready to display in a HTML-page, like:
 * <code>
 * <?php
 * // Add the stylesheet files of this plugin to the current page
 * echo $this->addPluginStylesheets(dirname(__FILE__));
 * 
 * $plugin = '<p>Plugin HTML</p>';
 * 
 * return $plugin;
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

// Add the stylesheet files of this plugin to the current page (these CSS files can be anywhere in this plugin folder)
echo $this->addPluginStylesheets(dirname(__FILE__));

// vars
$plugin = '';

// because this is just and example pluign we will do nothing but display the plugin config for the current page:
$plugin .= '<div class="feinduraPlugin_examplePlugin">'; // we use that DIV, so the web designer can later style this plugin more easy
  $plugin .= '<p class="myPluginText">'.$pluginConfig['textToDisplay'].'</p>';
  $plugin .= '<span class="myPluginNumber">'.$pluginConfig['numberToDisplay'].'</span>';
$plugin .= '</div>';

// RETURN the plugin
// *****************
return $plugin;

?>