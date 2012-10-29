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
 * The Main Addon file
 *
 * See the README.md for more.
 *
 * The following variables and functions are available in this script:
 *     - $addonLangFile   <- contains the current add-on language file, it loads the same language as the feindura backend language.
 *     - all functions from the "library/functions/backend.functions.php"
 *     - all the {@link GeneralFunctions::init() GeneralFunctions} class static methods. (call these like this: GeneralFunctions::isAdmin())
 *
 *
 * Example Addon:
 * <code>
 * <div class="block">
 *  <h1>Example Addon</h1>
 *  <div class="content">
 *    <?php
 *      echo 'Here is the content of my addon';
 *    ?>
 *  </div>
 * </div>
 * </code>
 *
 * @package [Addons]
 * @subpackage exampleAddon
 *
 * @author Fabian Vogelsteller <fabian@feindura.org>
 * @copyright Fabian Vogelsteller
 * @license http://www.gnu.org/licenses GNU General Public License version 3
 *
 */

?>

<h1>Example Addon</h1>
<p>This add-on does nothing, but shows you how you can create one.</p>


<!-- STANDARD BLOCK -->
<div class="block">
  <h1>Standard Block</h1>
  <div class="content">
    <p>You can localize your Add-on, by adding <code>&lt;country code&gt;.php</code> files inside your <code>yourAddon/languages/</code> folder and then use the <code>$addonLangFile</code> array to get the localized strings.</p>

    <div class="alert"><?php echo $addonLangFile['exampleText']; ?></div>

  </div>
</div>


<!-- STANDARD BLOCK WITH SLIDING -->
<div class="block hidden"> <!-- Add class "hidden", if you want to hide it on start -->
  <h1><a href="#">With sliding</a></h1> <!-- Just add a <a href="#"> -->
  <div class="content">
    <p>Some content</p>
  </div>
</div>


<!-- STANDARD BLOCK WITH IMAGE -->
<!-- <div class="block">
  <h1><img src="library/images/icons/addonIcon_middle.png" class="icons blockH1Icon">With image</h1>
  <div class="content">
    <p>Some content</p>
  </div>
</div> -->


<!-- BLOCK WITH A SMALL HEADLINE -->
<div class="block">
  <h2>Block with a small headline</h2> <!-- Just use <h2>, you can also put a link inside the <h2> to link to somwhere, it won't make it a slideing block. -->
  <div class="content">
    <p>Some content</p>
  </div>
</div>


<!-- BLOCK WITHOUT HEADLINE -->
<div class="block">
  <div class="content">
    <p>Block without headline</p>
  </div>
</div>


<!-- OTHER ELEMENTS -->
<div class="block">
  <h1>Other Elements</h1>
  <div class="content">
    <p>
      <span class="feinduraInline">fein<em>dura</em></span> uses the <a href="http://twitter.github.com/bootstrap/" target="_blank">Bootstrap CSS Framework</a>, you can use all the classes from there.<br>
      There are some <span class="feinduraInline">fein<em>dura</em></span> specific classes like:
    </p>

    <div class="row">
      <div class="span2"><span class="toolTipLeft" title="Title::Some text.">toolTipLeft</span></div>
      <div class="span2"><span class="toolTipRight" title="Title::Some text.">toolTipRight</span></div>
      <div class="span2"><span class="toolTipTop" title="Title::Some text.">toolTipTop</span></div>
      <div class="span2"><span class="toolTipBottom" title="Title::Some text.">toolTipBottom</span></div>
    </div>

    <div class="spacer"></div> <!-- You can also use "spacer2x" and "spacer4x" -->


    <h2>The Block Grid</h2>
    <p>
      Inside each block you have a grid of <strong>8 Colums</strong>, which you can use to position the content.<br>
      See the source code of the <code>addon.php</code> for details.<br>
    </p>

    <div class="row">
      <div class="span1 showGridBlocks">
        &nbsp;
      </div>
      <div class="span1 showGridBlocks">
        &nbsp;
      </div>
      <div class="span1 showGridBlocks">
        &nbsp;
      </div>
      <div class="span1 showGridBlocks">
        &nbsp;
      </div>
      <div class="span1 showGridBlocks">
        &nbsp;
      </div>
      <div class="span1 showGridBlocks">
        &nbsp;
      </div>
      <div class="span1 showGridBlocks">
        &nbsp;
      </div>
      <div class="span1 showGridBlocks">
        &nbsp;
      </div>
    </div>

    <div class="row">
      <div class="span2 showGridBlocks">
        &nbsp;
      </div>
      <div class="span3 showGridBlocks">
        &nbsp;
      </div>
      <div class="span2 showGridBlocks">
        &nbsp;
      </div>
      <div class="span1 showGridBlocks">
        &nbsp;
      </div>
    </div>

    <div class="row">
      <div class="span4 showGridBlocks">
        &nbsp;
      </div>
      <div class="span4 showGridBlocks">
        &nbsp;
      </div>
    </div>

  </div>
</div>


<!-- HOW TO MAKE FORMS -->
<form action="<?php echo $_SERVER['REQUEST_URI']; ?>" id="exampleForm" method="post" enctype="multipart/form-data" accept-charset="UTF-8">

  <!-- Here we can add a anchor, to which it will jump automatically when the form is submitted (needs the setupAnchor() function in the <script> tag below) -->
  <a id="exampleFormAnchor" class="anchorTarget"></a>

  <div class="block">
    <h1>How to make forms</h1>
    <div class="content">

      <p>With this add-on it automatically loads your <code>addon.controller.php</code> at the beginning. There you can get and save data, which can then be displayed here.</p>
      <div class="alert">Submit to see a nice notification.</div>

      <!-- number input small -->
      <div class="row">
        <div class="span3 right">example Number Input</div>
        <div class="span5"><input type="number" name="exampleNumberInput" value="123"></div>
      </div>

      <!-- input normal -->
      <div class="row">
        <div class="span3 right">example Input normal</div>
        <div class="span5"><input type="text" name="exampleInputNormal" value="value"></div>
      </div>

      <!-- input normal -->
      <div class="row">
        <div class="span3 right">example Input large</div>
        <div class="span5"><input type="text" name="exampleInputLarge" value="value" class="input-xlarge"></div>
      </div>

      <!-- textarea with autogrow -->
      <div class="row">
        <div class="span3 right">
          exampleTextarea
        </div>
        <div class="span5">
          <textarea name="exampleTextarea" class="input-xlarge autogrow">some text</textarea>
        </div>
      </div>

      <!-- checkbox -->
      <div class="row">
        <div class="span3 right">
          <input type="checkbox" id="exampleCheckbox" name="exampleCheckbox" value="true">
        </div>
        <div class="span5">
          <label for="exampleCheckbox"><span class="toolTipRight" title="::Checkbox toolTip">exampleCheckbox</span></label>
        </div>
      </div>

      <?php

      // Displays the $_POST variable, when its not empty
      if(!empty($_POST))
        DebugTools::dump($_POST);

      ?>

      <!-- Add a Submit button -->
      <input type="submit" value="" class="button submit center">
    </div>
  </div>
</form>


<!-- ADDON SCRIPTS -->
<script type="text/javascript">
/* <![CDATA[ */

  // this is needed for each form, so it will jump automatically to the next higher anchor, after submitting
  setupForm('exampleForm');

/* ]]> */
</script>