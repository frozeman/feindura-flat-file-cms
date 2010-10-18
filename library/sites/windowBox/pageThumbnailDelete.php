<?php
/*
    feindura - Flat File Content Management System
    Copyright (C) Fabian Vogelsteller [frozeman.de]

    This program is free software;
    you can redistribute it and/or modify it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 3 of the License, or (at your option) any later version.

    This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY;
    without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
    See the GNU General Public License for more details.

    You should have received a copy of the GNU General Public License along with this program;
    if not,see <http://www.gnu.org/licenses/>.
*/
// pageThumbnailDelete.php version 0.91

include(dirname(__FILE__).'/../../includes/backend.include.php');

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
$pageContent = $generalFunctions->readPage($page,$category);
$thumbnail = $pageContent['thumbnail'];

// QUESTION
if(is_file(DOCUMENTROOT.$adminConfig['uploadPath'].$adminConfig['pageThumbnail']['path'].$thumbnail)) {
  $question = '<h1 class="red">'.$langFile['pageThumbnailDelete_question_part1'].' &quot;<span style="color:#000000;">'.$pageContent['title'].'</span>&quot; '.$langFile['pageThumbnailDelete_question_part2'].'</h1>';

// NOT EXISTING
} else {
  $question = '<h1>'.$langFile['pageThumbnailDelete_name'].' &quot;<span style="color:#000000;">'.$adminConfig['uploadPath'].$adminConfig['pageThumbnail']['path'].$thumbnail.'</span>&quot; '.$langFile['pageThumbnailDelete_notexisting_part2'].'</h1>
  <a href="?category='.$category.'&amp;page='.$page.'" class="ok center" onclick="closeWindowBox(\'index.php?site='.$site.'&amp;category='.$category.'&amp;page='.$page.'\');return false;">&nbsp;</a>';
  
  // if the thumbnail doesnt exists, delete it from the pageContent
  $pageContent['thumbnail'] = '';
  $generalFunctions->savePage($pageContent);
  
  // show only the ok button
  $asking = true;
}

// DELETING PROCESS
if($asking && is_file(DOCUMENTROOT.$adminConfig['uploadPath'].$adminConfig['pageThumbnail']['path'].$thumbnail)) {
  @chmod(DOCUMENTROOT.$adminConfig['uploadPath'].$adminConfig['pageThumbnail']['path'].$thumbnail, PERMISSIONS);
    
    // DELETING    
    $pageContent['thumbnail'] = '';
    if(unlink(DOCUMENTROOT.$adminConfig['uploadPath'].$adminConfig['pageThumbnail']['path'].$thumbnail) && $generalFunctions->savePage($pageContent)) {

        // DELETING FINISH --------------
        $question = '<h1>'.$langFile['pageThumbnailDelete_name'].' &quot;<span style="color:#000000;">'.$adminConfig['uploadPath'].$adminConfig['pageThumbnail']['path'].$thumbnail.'</span>&quot; '.$langFile['pageThumbnailDelete_finish_part2'].'</h1><br />
        <a href="?category='.$category.'&amp;page='.$page.'" class="ok center" onclick="closeWindowBox(\'index.php?site='.$site.'&amp;category='.$category.'&amp;page='.$page.'\');return false;">&nbsp;</a>'."\n";
        
        $statisticFunctions->saveTaskLog(5,'page='.$pageContent['id']); // <- SAVE the task in a LOG FILE
        
    } else {
      // DELETING ERROR --------------
      $question = '<h1>'.$langFile['pageThumbnailDelete_finish_error'].'</h1>
      <a href="?category='.$category.'&amp;page='.$page.'" class="ok center" onclick="closeWindowBox();return false;">&nbsp;</a>'."\n";
    }
}

echo ' '; // hack for safari, otherwise it throws an error that he could not find htmlentities like &ouml;
echo $question;

if(!$asking) {

?>
<div>
<form action="?site=deletePage" method="post" enctype="multipart/form-data" id="deletePageForm" onsubmit="requestSite('<?php echo $_SERVER['PHP_SELF']; ?>','','deletePageForm');return false;" accept-charset="UTF-8">
<input type="hidden" name="category" value="<?php echo $category; ?>" />
<input type="hidden" name="id" value="<?php echo $page; ?>" />
<input type="hidden" name="site" value="<?php echo $site; ?>" />
<input type="hidden" name="asking" value="true" />

<a href="?site=pages&amp;category=<?php echo $category; ?>&amp;page=<?php echo $page; ?>" class="cancel" onclick="closeWindowBox();return false;">&nbsp;</a>
<input type="submit" value="" class=" button submit" />
</form>

<!-- show a preview of the thumbnail -->
<div style="width:100%; text-align:center; padding-top:20px;">
<img src="<?php echo $adminConfig['uploadPath'].$adminConfig['pageThumbnail']['path'].$thumbnail; ?>" alt="thumbnail" title="<?php echo $adminConfig['uploadPath'].$adminConfig['pageThumbnail']['path'].$thumbnail; ?>" />
</div>
</div>
<?php
}
?>