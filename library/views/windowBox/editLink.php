<?php
/**
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
 *
 * editLink.php
 *
 * @version 0.1
 */

/**
 * Includes the login.include.php and backend.include.php and filter the basic data
 */
require_once(dirname(__FILE__)."/../../includes/secure.include.php");

echo ' '; // hack for safari, otherwise it throws an error that he could not find htmlentities like &ouml;

// gets the vars
$post = (!empty($_POST)) ? $_POST : $_GET;
$pageContent = GeneralFunctions::readPage($post['page'],$post['category']);

$encodesTitle = (empty($pageContent['editedLink'])) ? StatisticFunctions::urlEncode(GeneralFunctions::getLocalized($pageContent,'title')) : $pageContent['editedLink'];
$hrefBeginning = dirname(GeneralFunctions::createHref($pageContent));

// WHEN THE FORM WAS SEND
if($post['send'] == 'true') {

  // remove appending slash
  if(substr($post['link'], -1) == '/')
    $post['link'] = substr($post['link'],0,-1);

  if($post['link'] != StatisticFunctions::urlEncode(GeneralFunctions::getLocalized($pageContent,'title')))
    $pageContent['editedLink'] = StatisticFunctions::urlEncode($post['link']);
  else
    $pageContent['editedLink'] = false;


  // RESET if given
  if($post['reset'] == 'true')
    $pageContent['editedLink'] = false;


  if(GeneralFunctions::savePage($pageContent)) {
    // saveActivityLog(28,$savedUsername); // <- SAVE the task in a LOG FILE

    // CLOSE the windowBox, if the first part of the response is '#CLOSE#'
    echo '#CLOSE#'; // echo not die(), so it executes the javascript below, before closing
    ?>

    <script type="text/javascript">
    /* <![CDATA[ */
      if($('pageLink') != null) {
        $('pageLink').setProperty('href','<?php echo GeneralFunctions::createHref($pageContent,false,false,true); ?>');
        $('pageLink').set('text','<?php echo GeneralFunctions::createHref($pageContent,false,false,true); ?>');
      }
    /* ]]> */
    </script>

    <?php

  } else
    echo '<div class="alert alert-error">'.sprintf($langFile['EDITOR_savepage_error_save'],$adminConfig['basePath']).'</div>';

  echo '<a href="?page='.$post['page'].'&amp;category='.$post['category'].'" class="button ok center" onclick="closeWindowBox();return false;"></a>';

// SHOW THE FORM
} else {

?>

<form action="?site=editLink" method="post" enctype="multipart/form-data" id="editLinkForm" onsubmit="requestSite('<?php echo $_SERVER['PHP_SELF']; ?>','','editLinkForm');return false;" accept-charset="UTF-8">
  <div>
    <input type="hidden" name="category" value="<?php echo $post['category']; ?>">
    <input type="hidden" name="page" value="<?php echo $post['page']; ?>">
    <input type="hidden" name="send" value="true">
  </div>

  <div class="row">
    <div class="span8 center">
      <div class="input-prepend input-append">
        <span class="add-on"><?php echo $hrefBeginning.'/'; ?></span>
        <input type="text" name="link" value="<?php echo $encodesTitle; ?>" style="width:250px;" autofocus="autofocus">
        <a href="#" class="btn btn-inverse" onclick="requestSite('<?php echo $_SERVER['PHP_SELF']; ?>','',{page:<?php echo $post['page']; ?>,category:<?php echo $post['category']; ?>,send:true,reset:true});return false;"><?php echo $langFile['BUTTON_RESET']; ?></a>
      </div>
    </div>

  </div>

  <input type="submit" value="" class="button submit center">
</form>
<?php } ?>