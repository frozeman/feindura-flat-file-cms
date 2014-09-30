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
 * The Controller Addon file
 *
 * Use this file to process, save and load the data you need for your Add-on.
 *
 * See the README.md for more.
 *
 * The following variables and functions are available in this script:
 *     - $_POST   <- from the submitted form
 *     - all functions from the "library/functions/backend.functions.php"
 *     - all the {@link GeneralFunctions::init() GeneralFunctions} class static methods. (call these like this: GeneralFunctions::isAdmin())
 *
 *
 * @package [Addons]
 * @subpackage exampleAddon
 *
 * @author Fabian Vogelsteller <fabian@feindura.org>
 * @copyright Fabian Vogelsteller
 * @license http://www.gnu.org/licenses GNU General Public License version 3
 *
 */


// $_POST isn't empty, means sombody send the form
if(!empty($_POST)) {

  // Lets just display Message Box with the results
  // the $NOTIFICATION will be display automatically when its not empty.
  $NOTIFICATION .= '<div class="alert alert-success">
                    The addon.controller.php just got a <code>$_POST</code> variable.
                    </div>';

  // if we set $DOCUMENTSAVED to true, it will show the saved icon shortly after the page is loaded
  $DOCUMENTSAVED = true;
}
