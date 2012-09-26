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
 * editPlugins.php
 *
 * @version 0.1
 */

/**
 * Includes the login.include.php and backend.include.php and filter the basic data
 */
require_once(dirname(__FILE__)."/../../includes/secure.include.php");

echo ' '; // hack for safari, otherwise it throws an error that he could not find htmlentities like &ouml;

// vars
$post = (!empty($_POST)) ? $_POST : $_GET;
$pageContent = GeneralFunctions::readPage($post['page'],$post['category']);

if(!$pageContent) {
  die('#CLOSE#
  <script type="text/javascript">
    feindura_showError("'.$langFile['errorWindow_h1'].'","'.sprintf($langFile['file_error_read'],$adminConfig['basePath']).'")
  </script>');
}


// WHEN THE FORM WAS SEND
if($post['send'] == 'true') {

  $pageContent['plugins'][$post['plugin']][$post['number']] = $post['pluginConfig'];

  if(GeneralFunctions::savePage($pageContent)) {
    // saveActivityLog(28,$savedUsername); // <- SAVE the task in a LOG FILE

    // CLOSE the windowBox, if the first part of the response is '#CLOSE#'
    die('#CLOSE#');

  } else
    echo '<div class="alert alert-error">'.sprintf($langFile['EDITOR_savepage_error_save'],$adminConfig['basePath']).'</div>';

  echo '<a href="?page='.$post['page'].'&amp;category='.$post['category'].'" class="button ok center" onclick="closeWindowBox();return false;"></a>';

// SHOW THE FORM
} else {

?>

<form action="?site=editPlugins" method="post" enctype="multipart/form-data" id="editPluginsForm" onsubmit="requestSite('<?php echo $_SERVER['PHP_SELF']; ?>','','editPluginsForm');return false;" accept-charset="UTF-8">
  <div>
    <input type="hidden" name="send" value="true">
    <input type="hidden" name="plugin" value="<?php echo $post['plugin']; ?>">
    <input type="hidden" name="number" value="<?php echo $post['number']; ?>">
    <input type="hidden" name="page" value="<?php echo $post['page']; ?>">
    <input type="hidden" name="category" value="<?php echo $post['category']; ?>">
  </div>
  <?php

    // vars
    $pluginCountryCode = (file_exists(dirname(__FILE__).'/../../../plugins/'.$post['plugin'].'/languages/'.$_SESSION['feinduraSession']['backendLanguage'].'.php'))
      ? $_SESSION['feinduraSession']['backendLanguage']
      : 'en';

    $pluginCredits   = @file(dirname(__FILE__).'/../../../plugins/'.$post['plugin'].'/credits.yml');

    $plugin['author']       = trim(str_replace('author:','',$pluginCredits[1]));
    $plugin['website']      = trim(str_replace('website:','',$pluginCredits[2]));
    $plugin['version']      = trim(str_replace('version:','',$pluginCredits[3]));
    $plugin['requirements'] = trim(str_replace('requirements:','',$pluginCredits[4]));

    $plugin['config'] = @include(dirname(__FILE__).'/../../../plugins/'.$post['plugin'].'/config.php');
    $plugin['langFile'] = @include(dirname(__FILE__).'/../../../plugins/'.$post['plugin'].'/languages/'.$pluginCountryCode.'.php');
    $plugin['name'] = (isset($plugin['langFile']['feinduraPlugin_title'])) ? $plugin['langFile']['feinduraPlugin_title'] : $post['plugin'];

    // description
    echo '<div class="row">';
      echo '<div class="span6 offset1">'.$plugin['langFile']['feinduraPlugin_description'].'</div>';

      // INFO BUTTON
      if(!empty($plugin['website']) || !empty($plugin['author']) || !empty($plugin['version'])) {
        echo '<div class="span1 center">';
            echo '<a href="#" class="btn btn-small inBlockSliderLink" data-inBlockSlider="'.$post['plugin'].'Info">'.$langFile['BUTTON_INFO'].'</a>';
        echo '</div>';
      }
    echo '</div>';

    // CREDITS
    if(!empty($plugin['website']) || !empty($plugin['author']) || !empty($plugin['version'])) {
      echo '<div class="row">';
        echo '<div class="span6 offset1">';

          echo '<div class="inBlockSlider hidden well" data-inBlockSlider="'.$post['plugin'].'Info">';

          if(!empty($plugin['author'])) {
            echo '<div class="row">
              <div class="span1 right">
              <strong>'.$langFile['ADDONS_TEXT_AUTHOR'].'</strong>
              </div>
              <div class="span2">
              '.$plugin['author'].'
              </div>
            </div>';
          }

          if(!empty($plugin['website'])) {
            echo '<div class="row">
              <div class="span1 right">
              <strong>'.$langFile['ADDONS_TEXT_WEBSITE'].'</strong>
              </div>
              <div class="span2">
              <a href="'.$plugin['website'].'" target="_blank">'.$plugin['website'].'</a>
              </div>
            </div>';
          }

          if(!empty($plugin['version'])) {
            echo '<div class="row">
              <div class="span1 right">
              <strong>'.$langFile['ADDONS_TEXT_VERSION'].'</strong>
              </div>
              <div class="span2">
              '.$plugin['version'].'
              </div>
            </div>';
          }

          if(!empty($plugin['requirements'])) {
            echo '<div class="row">
              <div class="span1 right">
              <strong>'.$langFile['ADDONS_TEXT_REQUIREMENTS'].'</strong>
              </div>
              <div class="span2">
              '.$plugin['requirements'].'
              </div>
            </div>';
          }
        echo '</div>';
      echo '</div>';
    }

    echo '<div class="spacer2x"></div>';

    // ->> LIST PLUGIN SETTINGS
    if(!empty($plugin['config']) && is_array($plugin['config'])) {

      // active field
      echo '<input type="hidden" name="pluginConfig[active]" value="true">';

      foreach($plugin['config'] as $key => $orgValue) {

        $value = (!isset($pageContent['plugins'][$post['plugin']][$post['number']][$key]) && $pageContent['plugins'][$post['plugin']][$post['number']][$key] !== false)
          ? $orgValue
          : $pageContent['plugins'][$post['plugin']][$post['number']][$key];
        $keyName = (isset($plugin['langFile'][$key]))
          ? $plugin['langFile'][$key]
          : $key ;
        $keyTipLeft  = (isset($plugin['langFile'][$key.'_tip'])) ? ' class="toolTipLeft" title="::'.$plugin['langFile'][$key.'_tip'].'::"' : '';
        $keyTipRight = (isset($plugin['langFile'][$key.'_tip'])) ? ' class="toolTipRight" title="::'.$plugin['langFile'][$key.'_tip'].'::"' : '';


        // BOOL
        if(!is_numeric($value) &&
           (is_bool($value) ||
            strpos(strtolower($key),'bool') !== false)) {
          $checked = ($value) ? ' checked' : '';
          echo '<div class="row">
                  <div class="span3 right">
                    <input type="hidden" name="pluginConfig['.$key.']" value="false">
                    <input type="checkbox" id="feinduraPlugin_'.$post['plugin'].'_config_'.$key.'" name="pluginConfig['.$key.']" value="true"'.$keyTipRight.$checked.'>
                  </div>
                  <div class="span5">
                    <label for="feinduraPlugin_'.$post['plugin'].'_config_'.$key.'"><span'.$keyTipRight.'>'.$keyName.'</span></label>
                  </div>
                </div>';

        // HIDDEN
        } elseif(strpos(strtolower($key),'hidden') !== false) {
          echo '<input type="hidden" id="feinduraPlugin_'.$post['plugin'].'_config_'.$key.'" name="pluginConfig['.$key.']" value="'.$value.'">';

        // SELECTION
        } elseif(strpos(strtolower($key),'selection') !== false) {
          echo '<div class="row">
                  <div class="span3 right">
                    <label for="feinduraPlugin_'.$post['plugin'].'_config_'.$key.'"><span'.$keyTipLeft.'>'.$keyName.'</span></label>
                  </div>
                  <div class="span5">
                    <select id="feinduraPlugin_'.$post['plugin'].'_config_'.$key.'" name="pluginConfig['.$key.']"'.$keyTipRight.'>';
                    foreach ($orgValue as $optionkey => $option) {
                      if($value == $option)
                        echo '<option value="'.$option.'" selected="selected">'.$option.'</option>';
                      else
                        echo '<option value="'.$option.'">'.$option.'</option>';
                    }

          echo '    </select>
                  </div>
                </div>';

        // JS FUNCTION
        } elseif(strpos(strtolower($key),'jsfunction') !== false) {

          if(strpos($value,'(') === false)
            $value .= '()';
          if(strpos($value,';') === false)
            $value .= ';';

          echo '<div class="spacer2x"></div>';
          echo '<div class="row">
                  <div class="offset3 span5">
                    <a href="#" class="btn btn-large btn-warning" onclick="'.$value.'return false;"'.$keyTipRight.'>'.$keyName.'</a>
                  </div>
                </div>';
          echo '<div class="spacer2x"></div>';

        // ECHO/PRINT
        } elseif(strpos(strtolower($key),'print') !== false || strpos(strtolower($key),'echo') !== false) {

          echo $value;

        // JS NUMBER
        } elseif(strpos(strtolower($key),'number') !== false || is_numeric($value)) {

          echo '<div class="row">
                  <div class="span3 right">
                    <label for="feinduraPlugin_'.$post['plugin'].'_config_'.$key.'"><span'.$keyTipLeft.'>'.$keyName.'</span></label>
                  </div>
                  <div class="span5">
                    <input type="number" id="feinduraPlugin_'.$post['plugin'].'_config_'.$key.'" name="pluginConfig['.$key.']" value="'.$value.'"'.$keyTipRight.'>
                  </div>
                </div>';

        // SCRIPT
        } elseif(strpos(strtolower($key),'script') !== false) {
          // prevent script from beeing add to an input, its add in the page scripts on the end

        // XSSFILTER VALUE
        } else {

          echo '<div class="row">
                  <div class="span3 right">
                    <label for="feinduraPlugin_'.$post['plugin'].'_config_'.$key.'"><span'.$keyTipLeft.'>'.$keyName.'</span></label>
                  </div>
                  <div class="span5">
                    <input type="text" id="feinduraPlugin_'.$post['plugin'].'_config_'.$key.'" name="pluginConfig['.$key.']" value="'.$value.'"'.$keyTipRight.'>
                  </div>
                </div>';
        }
      }
    }

  ?>

  <div class="row buttons">
    <div class="span4 center">
      <a href="?page=<?php echo $post['page']; ?>&amp;category=<?php echo $post['category']; ?>" class="button cancel" onclick="closeWindowBox();return false;"></a>
    </div>
    <div class="span4 center">
      <input type="submit" value="" class="button submit">
    </div>
  </div>
</form>

<!-- PAGE SCRIPTS -->
<script type="text/javascript">
/* <![CDATA[ */

  // event is fired when the windowBox is ready
  windowBox.addEvent('loaded',function(){

    inBlockSlider();

    <?php

    // LOAD PLUGIN SCRIPT
    if(!empty($plugin['config']) && is_array($plugin['config'])) {
      foreach($plugin['config'] as $key => $value) {
        if(strpos(strtolower($key),'script') !== false)
          echo $value;
      }
    }
    ?>
  });
/* ]]> */
</script>
<?php } ?>