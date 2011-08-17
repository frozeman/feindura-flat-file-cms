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
 * pageThumbnailDelete.php
 * 
 * @version 0.91
 */

/**
 * Includes the login.include.php and backend.include.php and filter the basic data
 */
require_once(dirname(__FILE__)."/../../includes/secure.include.php");

echo ' '; // hack for safari, otherwise it throws an error that he could not find htmlentities like &ouml;

// gets the vars
if(isset($_POST['category']))
  $category = $_POST['category'];
else
  $category = $_GET['category'];  
if(isset($_POST['id']))
  $page = $_POST['id'];
else
  $page = $_GET['page'];
if(isset($_POST['site']))
  $site = $_POST['site'];
else
  $site = $_GET['site'];
$asking = $_POST['asking'];

// load the page
$pageContent = GeneralFunctions::readPage($page,$category);
$thumbnail = $pageContent['thumbnail'];

// QUESTION
$question = '<h1 class="red">'.$langFile['PAGETHUMBNAIL_TEXT_DELETE_QUESTION_START'].' &quot;<span style="color:#000000;">'.strip_tags($pageContent['title']).'</span>&quot; '.$langFile['PAGETHUMBNAIL_TEXT_DELETE_QUESTION_END'].'</h1>';

// DELETING PROCESS
if($asking && file_exists(DOCUMENTROOT.$adminConfig['uploadPath'].$adminConfig['pageThumbnail']['path'].$thumbnail)) {
  @chmod(DOCUMENTROOT.$adminConfig['uploadPath'].$adminConfig['pageThumbnail']['path'].$thumbnail, $adminConfig['permissions']);
    
    // DELETING    
    $pageContent['thumbnail'] = '';
    if(unlink(DOCUMENTROOT.$adminConfig['uploadPath'].$adminConfig['pageThumbnail']['path'].$thumbnail) && GeneralFunctions::savePage($pageContent)) {
        StatisticFunctions::saveTaskLog(5,'page='.$pageContent['id']); // <- SAVE the task in a LOG FILE
        
        $question = '';
        echo 'DONTSHOW';        
        echo '<script type="text/javascript">/* <![CDATA[ */closeWindowBox(\'index.php?site='.$site.'&category='.$category.'&page='.$page.'\');/* ]]> */</script>';
        
    } else {
      // DELETING ERROR --------------
      $question = '<h1>'.$langFile['PAGETHUMBNAIL_ERROR_DELETE'].'</h1>
      <a href="?category='.$category.'&amp;page='.$page.'" class="ok center" onclick="closeWindowBox();return false;">&nbsp;</a>'."\n";
    }
}

echo $question;

if(!$asking) {

?>
<div>
<form action="?site=deletePage" method="post" enctype="multipart/form-data" id="deletePageForm" onsubmit="requestSite('<?php echo $_SERVER['SCRIPT_NAME']; ?>','','deletePageForm');return false;" accept-charset="UTF-8">
<input type="hidden" name="category" value="<?php echo $category; ?>" />
<input type="hidden" name="id" value="<?php echo $page; ?>" />
<input type="hidden" name="site" value="<?php echo $site; ?>" />
<input type="hidden" name="asking" value="true" />

<a href="?site=pages&amp;category=<?php echo $category; ?>&amp;page=<?php echo $page; ?>" class="cancel" onclick="closeWindowBox();return false;">&nbsp;</a>
<input type="submit" value="" class=" button submit" />
</form>

<!-- show a preview of the thumbnail -->
<div style="width:100%; text-align:center; padding-top:20px;">
<?php
  // generates a random number to put on the end of the image, to prevent caching
  $randomImage = '?'.md5(uniqid(rand(),1));
?>
<img src="<?php echo $adminConfig['uploadPath'].$adminConfig['pageThumbnail']['path'].$thumbnail.$randomImage; ?>" alt="thumbnail" title="<?php echo $adminConfig['uploadPath'].$adminConfig['pageThumbnail']['path'].$thumbnail; ?>" />
</div>
</div>
<?php
}
?>