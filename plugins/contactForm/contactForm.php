<?php
/* contactForm plugin */
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
 * This file contains the {@link contactForm} class.
 * 
 * @package [Plugins]
 * @subpackage contactForm
 */

// include the chapta
require('chapta.php');

/**
* contactForm Plugin class
* 
* This class creates an contact form with a simple chapta check.
* 
* <b>Notice</b>: The contact form is surrounded by an '<div class="contactForm">' tag to help to style the contact form.
* 
* 
* @author Fabian Vogelsteller <fabian@feindura.org>
* @copyright Fabian Vogelsteller
* @license http://www.gnu.org/licenses GNU General Public License version 3
* 
* @package [Plugins]
* @subpackage contactForm
* 
* @version 1.01
* <br />
* <b>ChangeLog</b><br />
*    - 1.01 add plain mail in UTF-8 when php 4
*    - 1.0 initial release
* 
*/
class contactForm {

 /* ---------------------------------------------------------------------------------------------------------------------------- */
 /* *** PROPERTIES */
 /* **************************************************************************************************************************** */
  
 /**
  * TRUE when the pages content should be handled as XHTML
  *
  * In XHTML standalone tags end with " />" instead of ">".<br />
  * Therefor when a page content is displayed and this property is <i>FALSE</i> all " />" will be changed to ">".
  * 
  * @var bool
  * 
  */
  var $xHtml = true;

 /**
  * The languageFile for the texts of the contact form
  * 
  * @var string
  * 
  */
  var $langFile = null;
  
 /**
  * The receiver email adress of the form
  * 
  * @var string
  * @see contactForm::sendForm()  
  * 
  */
  var $recipient = 'name@example.net';

 /**
  * The title of the website from where the contact form is send
  * 
  * @var string
  * @see contactForm::sendForm()  
  * 
  */
  var $websiteTitle = '';

 /**
  * The URL of the website from where the contact form is send
  * 
  * @var string
  * @see contactForm::sendForm()  
  * 
  */
  var $websiteUrl = '';
  
 /**
  * Contains all settings for the contactForm
  * @var bool
  */
  var $config = true;
  
 /**
  * The string which will be used after a field, to mark the field as mandatory
  * 
  * @var string
  */
  var $mandatoryStar = ' <span style="color:#D23D30;">*</span>';
  
 /**
  * The string which will be add to a mandatory field, when its not filled 
  * 
  * @var string
  */
  var $mandatoryColor = ' style="color:#D23D30;"';
  
 /**
  * The current URL with ? or & add to it. (depending if GET varibales already exist or not)
  * 
  * @var string
  */
  var $currentUrl;

 /**
  * <b>Type</b> constructor<br /> 
  * <b>Name</b> contactForm()<br />
  * 
  * The constructor of the class, sets the recipient of the form
  * 
  * 
  * @param string $recipient the email of the recipient of the form
  * 
  * @return void
  * 
  * @version 1.0
  * <br />
  * <b>ChangeLog</b><br />
  *    - 1.0 initial release
  * 
  */
  function contactForm($recipient) {
    
    // sets the recipient of the form
    $this->recipient = $recipient;
    
    // check if the langFile was set
    if(!is_array($this->langFile))
      $this->langFile = include('languages/en.php');
    
    // add the session to the current URL
    if(strpos($_SERVER['REQUEST_URI'],session_name()) === false) {
      $this->currentUrl = (strpos($_SERVER['REQUEST_URI'],'?') === false)
        ? $_SERVER['REQUEST_URI'].'?'.htmlspecialchars(session_name().'='.session_id())
        : $_SERVER['REQUEST_URI'].'&amp;'.htmlspecialchars(session_name().'='.session_id());
    } else
       $this->currentUrl = $_SERVER['REQUEST_URI'];    
  }

 /* ---------------------------------------------------------------------------------------------------------------------------- */
 /* *** METHODS *** */
 /* **************************************************************************************************************************** */
 
  /**
  * <b>Name</b> sendForm()<br />
  * 
  * Sends the form an returns a message if everything was send succesfully or return an error message.
  * 
  * 
  * @param bool $mandatoryfieldsOk tells if the mandatory fields are not empty (this variable will be also changed outside of this method)
  * @param array $mandatoryFields stores the mandatory field which are empty (this variable will be also changed outside of this method)
  * 
  * @uses contactForm::langFile
  * @uses contactForm::config
  * @uses contactForm::websiteTitle
  * @uses contactForm::websiteUrl
  * 
  * @return string the finish or error messages
  * 
  * @version 1.0
  * <br />
  * <b>ChangeLog</b><br />
  *    - 1.0 initial release
  * 
  */
  function sendForm(&$mandatoryfieldsOk = true, &$mandatoryFields = array()) {
    // var
    $return = '';

    if($_POST['contactFormSend'] == 'true') {
    
      $_SESSION['appellation'] = @$_POST['appellation'];
      $_SESSION['firstname'] = @$_POST['firstname'];
      $_SESSION['lastname'] = @$_POST['lastname'];
      $_SESSION['street'] = @$_POST['street'];
      $_SESSION['housenumber'] = @$_POST['housenumber'];
      $_SESSION['zipcode'] = @$_POST['zipcode'];
      $_SESSION['city'] = @$_POST['city'];
      $_SESSION['country'] = @$_POST['country'];
      $_SESSION['company'] = @$_POST['company'];
      $_SESSION['website'] = @$_POST['website'];
      $_SESSION['email'] = @$_POST['email'];
      $_SESSION['phone'] = @$_POST['phone'];
      $_SESSION['fax'] = @$_POST['fax'];
      $_SESSION['message_raw'] = stripslashes($_POST['message']);
      $message = str_replace("\n", '<br>', $_POST['message']);
    
    // CHAPTA CHECK
    if(isset($_SESSION['chaptacheck']) && $_POST['chapta'] == $_SESSION['chaptacheck']) {
      unset($_SESSION['chaptacheck']);  
    
        // ->> CHECK the mandatory fields
        $mandatoryfieldsOk = true;
        foreach($this->config as $key => $wert) {
          // if the field is NOT MANDATORY OR
          // if the field is NOT ACTIVATED OR
          // if the field is NOT EMPTY
          $configMandatory = substr($key,-10);
          $config = substr($key,0,-10);
          
          // check for mandatory fields
          if($configMandatory == '_mandatory' && $wert === true && $this->config[$config] === true && empty($_POST[$config])) {
            $mandatoryfieldsOk = false;      
            $mandatoryFields[$config] = $this->langFile['field_'.$config];
          }
        }
        
        if($mandatoryfieldsOk && !empty($_POST['message'])) {
        
        $senddate  = date('d.m.Y');
        $sendtime = date("H:i");
        
        
        //zeigt die felder in der email an, wenn sie aktiviert sind und nicht leer
        if($this->config['appellation'] && $_POST['appellation'] != '-') $anrede = $_POST['appellation']."<br>\n";
        else $anrede = '';
          
        if($this->config['firstname'] && !empty($_POST['firstname'])) $vorname = $_POST['firstname']." ";
        else $vorname = '';
        
        if($this->config['lastname'] && !empty($_POST['lastname'])) $nachname = $_POST['lastname']."\n";
        else $nachname = '';
        
        if(($this->config['street'] ||
        $this->config['housenumber'] ||
        $this->config['zipcode'] ||
        $this->config['city']) && (!empty($_POST['street']) || !empty($_POST['city']))) $address = "<br><b>".$this->langFile['message_address']."</b><br>\n";
        else $address = '';
        
        if($this->config['street'] && !empty($_POST['street'])) $street = $_POST['street'].' '.$_POST['housenumber']."<br>\n";
        else $street = '';
        
        if($this->config['city'] && !empty($_POST['city'])) $city = $_POST['zipcode'].' '.$_POST['city']."<br>\n";
        else $city = '';
        
        if($this->config['country'] && !empty($_POST['country'])) $country = $_POST['country']."<br>\n";
        else $country = '';
        
        if($this->config['website'] && !empty($_POST['website'])) $website = '<br><b>'.$this->langFile['field_website'].':</b> '.$_POST['website']."\n";
        else $website = '';
        
        if($this->config['email'] && !empty($_POST['email'])) $email = '<br><b>'.$this->langFile['field_email'].':</b> '.$_POST['email']."\n";
        else $email = '';
        
        if($this->config['phone'] && !empty($_POST['phone'])) $phone = '<br><b>'.$this->langFile['field_phone'].':</b> '.$_POST['phone']."\n";
        else $phone = '';
        
        if($this->config['fax'] && !empty($_POST['fax'])) $fax = '<br><b>'.$this->langFile['field_fax'].':</b> '.$_POST['fax']."\n";
        else $fax = '';
        
        // entfernt die \ aus dem text
        $message = stripslashes($message);
        
        $subject = $this->websiteTitle.' '.$this->langFile['message_subject'];
              
$mailcontent = '<html><head><title>'.$subject.'</title>
</head><body style="font: 10pt Verdana, Arial, Helvetica;">
'.$this->langFile['message_title1'].' <a href="'.$this->websiteUrl.'">'.$this->websiteTitle.'</a> '.$this->langFile['message_title2'].':<br><br>
<b>'.$this->langFile['message_block1_title'].'</b><br>
<br>
'.$message.'<br>
<br>  
'.$this->langFile['message_senddate'].' '.$senddate.' '.$this->langFile['message_sendtime'].' '.$sendtime.'<br>
<br>
<b>'.$this->langFile['message_block2_title'].'</b><br>
<br>
'.$anrede.$vorname.$nachname.'
<br>
'.$address.$street.$city.$country.$website.$email.$phone.$fax.'<br>
</body></html>';
        
        // ->> use phpMailer
        if(@include('phpMailer/class.phpmailer.php')) {
          
          $mail = new phpmailer();
          
          $mail->CharSet = 'UTF-8';
          $mail->IsHTML(true);
          
          if(empty($_POST['email'])) {
            $mail->From = $this->recipient;
            $mail->FromName = "no-reply";
          } else {
            $mail->From = $_POST['email'];
            $mail->FromName = $_POST['firstname'].' '.$_POST['lastname'];
          }
          
          $mail->Subject = $subject;
          
          $mail->Body = $mailcontent;
          $mail->AltBody = preg_replace("/ +/", ' ', strip_tags($mailcontent));
          
          $mail->AddAddress($this->recipient);
          
          $result = $mail->Send();
        
        // ->> if PHP couldn't inlcude phpMailer
        } else {
        
          $message = preg_replace("/ +/", ' ', strip_tags($mailcontent));
          
          $header = 'MIME-Version: 1.0' . "\r\n" . 'Content-type: text/plain; charset=UTF-8' . "\r\n"; // UTF-8 plain text mail          
          $header .= (empty($_POST['email']))
            ? 'From: "no-reply" <'.$this->recipient.">\r\n"
            : 'From: "'.$_POST['firstname'].' '.$_POST['lastname'].'" <'.$_POST['email'].">\r\n";          
          $header .= 'X-Mailer: PHP/' . phpversion();
          
          mail($this->recipient, $subject, $message, $header);
        
        }  
        
        $return .= '<p><b>'.$this->langFile['form_send'].'</b></p>';
        
        unset($_SESSION['appellation'],
        $_SESSION['firstname'],
        $_SESSION['lastname'],
        $_SESSION['street'],
        $_SESSION['housenumber'],
        $_SESSION['zipcode'],
        $_SESSION['city'],
        $_SESSION['country'],
        $_SESSION['company'],
        $_SESSION['website'],
        $_SESSION['email'],
        $_SESSION['phone'],
        $_SESSION['fax'],
        $_SESSION['message_raw']);
        
        // ERROR - a MANDATORY FILED is empty
        } else {
              
          $return .= '<span id="contactForm_error"'.$this->mandatoryColor.'><b>'.$this->langFile['error_mandatoryfields'].'</b><br />'."\n";
            // listet die Pflichfelder die nochleer sind auf
            if(is_array($mandatoryFields)) {
              $count = 1;
              foreach($mandatoryFields as $emptyPflichtfeld) {
              
                if($count != 1) $return .= ', '; // zeigt das trenn ", " nicht an vor dem ersten item in der liste
                $return .= $emptyPflichtfeld;
                $count++;
              }
              
              // listet den nachrichtentext mit auf wenn er leer ist
              if(empty($_POST['message'])) {
                $mandatoryFields['message'] = $this->langFile['field_message'];
                $return .= ', '.$this->langFile['field_message'];
              }
            } else {
              // listet den nachrichtentext auf wenn NUR ER leer ist
              $return .= $this->langFile['field_message'];
            }
          
          $return .= '</span><br /><br />'."\n";
        }
      
      // ERROR - CHAPTA INCORRECT
      } else {
      $return .= '<span id="contactForm_error"><b>'.$this->langFile['error_chapta'].'</b><br />
            <a href="'.$this->currentUrl.'">'.$this->langFile['link_back'].'</a></span>'."\n";
      }
    }
    
    return $return;
  }

  /**
  * <b>Name</b> createForm()<br />
  * 
  * Creates the form ready to display in an HTML-page.
  * 
  * @param array $mandatoryFields stores the mandatory field which are empty (this variable will be also changed outside of this method)
  * 
  * @uses contactForm::xHtml
  * @uses contactForm::mandatoryStar
  * @uses contactForm::mandatoryColor
  * @uses contactForm::langFile
  * @uses contactForm::config
  * 
  * @return string the contact form
  * 
  * @version 1.0
  * <br />
  * <b>ChangeLog</b><br />
  *    - 1.0 initial release
  * 
  */
  function createForm($mandatoryFields = array()) {
    //var
    $return = '';

    $return .= '<form action="'.$this->currentUrl.'" method="post" enctype="multipart/form-data">
    <div>
    <input type="hidden" name="contactFormSend" value="true" />
    </div>
  
  <table>
  <tr><td align="left" colspan="2">';
      
      // APPELLATION
      if($this->config['appellation']) {
        if($this->config['appellation_mandatory']) $mandatory = $this->mandatoryStar; else $mandatory = '';
        if(!empty($mandatoryFields['appellation'])) $notFilled = $this->mandatoryColor; else $notFilled = '';
 
        $return .= '  <label for="contactForm_field_appellation"'.$notFilled.'><b>'.$this->langFile['field_appellation'].$mandatory.'</b></label><br />
    <select name="appellation" id="contactForm_field_appellation" size="1">
      <option></option>';
              
        $checkMan = ($_SESSION['appellation'] == $this->langFile['field_appellation_man']) ? ' selected="selected"' : '';
        $checkWoman = ($_SESSION['appellation'] == $this->langFile['field_appellation_woman']) ? ' selected="selected"' : '';
              
        $return .= '<option'.$checkMan.'>'.$this->langFile['field_appellation_man'].'</option>';
        $return .= '<option'.$checkWoman.'>'.$this->langFile['field_appellation_woman'].'</option>';
        $return .= '</select><br />';
      }

      $return .= '</td></tr>
      <tr><td align="left" valign="top">';
      
      // FIRSTNAME
      if($this->config['firstname']) {
        if($this->config['firstname_mandatory']) $mandatory = $this->mandatoryStar; else $mandatory = '';
        if(!empty($mandatoryFields['firstname'])) $notFilled = $this->mandatoryColor; else $notFilled = '';
        
        $return .= '<label for="contactForm_field_firstname"'.$notFilled.'><b>'.$this->langFile['field_firstname'].$mandatory.'</b></label><br />';
        $return .= '<input type="text" size="25" id="contactForm_field_firstname" name="firstname" value="'.@$_SESSION['firstname'].'" /><br />';
    
      }
        
      $return .= '</td><td align="left" valign="top">';
      
      // LASTNAME
      if($this->config['lastname']) {
        if($this->config['lastname_mandatory']) $mandatory = $this->mandatoryStar; else $mandatory = '';
        if(!empty($mandatoryFields['lastname'])) $notFilled = $this->mandatoryColor; else $notFilled = '';
        
        $return .= '<label for="contactForm_field_lastname"'.$notFilled.'><b>'.$this->langFile['field_lastname'].$mandatory.'</b></label><br />';
        $return .= '<input type="text" size="28" id="contactForm_field_lastname" name="lastname" value="'.@$_SESSION['lastname'].'" /><br />';
    
      }
        
      $return .= '</td></tr><tr><td align="left" valign="top" colspan="2">';
      
      // COMPANY
      if($this->config['company']) {
        if($this->config['company_mandatory']) $mandatory = $this->mandatoryStar; else $mandatory = '';
        if(!empty($mandatoryFields['company'])) $notFilled = $this->mandatoryColor; else $notFilled = '';
        
        $return .= '<label for="contactForm_field_company"'.$notFilled.'><b>'.$this->langFile['field_company'].$mandatory.'</b></label><br />';
        $return .= '<input type="text" size="25" id="contactForm_field_company" name="company" value="'.@$_SESSION['company'].'" /><br />';
  
      }    
          
      $return .= '</td></tr><tr><td align="left" valign="top">';
      
      // STREET, HOUSENUMBER
        if($this->config['street_mandatory']) $mandatory = $this->mandatoryStar; else $mandatory = '';
        if(!empty($mandatoryFields['street'])) $notFilled = $this->mandatoryColor; else $notFilled = '';   
      if($this->config['street']) $return .= '<label for="contactForm_field_street"'.$notFilled.'><b>'.$this->langFile['field_street'].$mandatory.'</b></label>';
        
        if($this->config['housenumber_mandatory']) $mandatory = $this->mandatoryStar; else $mandatory = '';
        if(!empty($mandatoryFields['housenumber'])) $notFilled = $this->mandatoryColor; else $notFilled = '';  
      if($this->config['housenumber']) $return .= ', <label for="contactForm_field_housenumber"'.$notFilled.'><b>'.$this->langFile['field_housenumber'].$mandatory.'</b></label><br />';
      if($this->config['street']) $return .= '<input type="text" size="16" id="contactForm_field_street" name="street" value="'.@$_SESSION['street'].'" />';
      if($this->config['housenumber']) $return .= '<input type="text" size="5" id="contactForm_field_housenumber" name="housenumber" value="'.@$_SESSION['housenumber'].'" /><br />';
  
      
      // ZIPCODE, CITY, COUNTRY
        if($this->config['zipcode_mandatory']) $mandatory = $this->mandatoryStar; else $mandatory = '';
        if(!empty($mandatoryFields['zipcode'])) $notFilled = $this->mandatoryColor; else $notFilled = '';    
      if($this->config['zipcode']) $return .= '<label for="contactForm_field_zipcode"'.$notFilled.'><b>'.$this->langFile['field_zipcode'].$mandatory.'</b></label>';
      
        if($this->config['city_mandatory']) $mandatory = $this->mandatoryStar; else $mandatory = '';
        if(!empty($mandatoryFields['city'])) $notFilled = $this->mandatoryColor; else $notFilled = '';
      if($this->config['city']) $return .= ', <label for="contactForm_field_city"'.$notFilled.'><b>'.$this->langFile['field_city'].$mandatory.'</b></label><br />';
      if($this->config['zipcode']) $return .= '<input type="text" size="5" id="contactForm_field_zipcode" name="zipcode" value="'.@$_SESSION['zipcode'].'" />';
      if($this->config['city']) $return .= '<input type="text" size="16" id="contactForm_field_city" name="city" value="'.@$_SESSION['city'].'" /><br />';
      
        if($this->config['country_mandatory']) $mandatory = $this->mandatoryStar; else $mandatory = '';
        if(!empty($mandatoryFields['country'])) $notFilled = $this->mandatoryColor; else $notFilled = '';
      if($this->config['country']) $return .= '<label for="contactForm_field_country"'.$notFilled.'><b>'.$this->langFile['field_country'].$mandatory.'</b></label><br />';
      if($this->config['country']) $return .= '<input type="text" size="26"  id="contactForm_field_country" name="country" value="'.@$_SESSION['country'].'" />';
  
    
      $return .= '</td><td align="left" valign="top">';
      
      // WEBSITE
      if($this->config['website']) {
        if($this->config['website_mandatory']) $mandatory = $this->mandatoryStar; else $mandatory = '';
        if(!empty($mandatoryFields['website'])) $notFilled = $this->mandatoryColor; else $notFilled = '';
        
        $return .= '<label for="contactForm_field_website"'.$notFilled.'><b>'.$this->langFile['field_website'].$mandatory.'</b></label><br />';
        $return .= '<input type="text" size="28" id="contactForm_field_website" name="website" value="'.@$_SESSION['website'].'" /><br />';
  
      }
      
      // EMAIL
      if($this->config['email']) {
        if($this->config['email_mandatory']) $mandatory = $this->mandatoryStar; else $mandatory = '';
        if(!empty($mandatoryFields['email'])) $notFilled = $this->mandatoryColor; else $notFilled = '';
        
        $return .= '<label for="contactForm_field_email"'.$notFilled.'><b>'.$this->langFile['field_email'].$mandatory.'</b></label><br />';
        $return .= '<input type="text" size="28" id="contactForm_field_email" name="email" value="'.@$_SESSION['email'].'" /><br />';
  
      }
        
      // PHONE
      if($this->config['phone']) {
        if($this->config['phone_mandatory']) $mandatory = $this->mandatoryStar; else $mandatory = '';
        if(!empty($mandatoryFields['phone'])) $notFilled = $this->mandatoryColor; else $notFilled = '';
        
        $return .= '<label for="contactForm_field_phone"'.$notFilled.'><b>'.$this->langFile['field_phone'].$mandatory.'</b></label><br />';
        $return .= '<input type="text" size="28" id="contactForm_field_phone" name="phone" value="'.@$_SESSION['phone'].'" /><br />';
  
      }
        
      // FAX
      if($this->config['fax']) {
        if($this->config['fax_mandatory']) $mandatory = $this->mandatoryStar; else $mandatory = '';
        if(!empty($mandatoryFields['fax'])) $notFilled = $this->mandatoryColor; else $notFilled = '';
        
        $return .= '<label for="contactForm_field_fax"'.$notFilled.'><b>'.$this->langFile['field_fax'].$mandatory.'</b></label><br />';
        $return .= '<input type="text" size="28" id="contactForm_field_fax" name="fax" value="'.@$_SESSION['fax'].'" /><br />';
  
      }
  
      $return .= '</td></tr>
      <tr><td align="left" colspan="2">';
    
      if(!empty($mandatoryFields['message'])) $notFilled = $this->mandatoryColor; else $notFilled = '';
      $return .= '<label for="contactForm_field_message"'.$notFilled.'><b>'.$this->langFile['field_message'].$this->mandatoryStar.'</b></label><br />';
    
    
    $return .= '<textarea rows="9" id="contactForm_field_message" name="message">'.@$_SESSION['message_raw'].'</textarea><br />
    <br />
    <b>'.$this->langFile['field_chapta'].$this->mandatoryStar.'</b>';

    $chapta = new chapta(rand(1000,9999));      
    $_SESSION['chaptacheck'] = $chapta->getNum();
    $return .= '<div id="contactForm_chaptaNumbers">'.$chapta->printNumber().'</div>';      
    $return .= '<input type="text" id="contactForm_field_chapta" name="chapta" size="4" autocomplete="off" maxlength="4" />';
    
    $return .= '<br /><input type="submit" id="contactForm_button_send" value="'.$this->langFile['button_send'].'" />
    <span id="contactForm_text_mandatoryfields">'.$this->mandatoryStar.' '.$this->langFile['text_mandatoryfields'].'</span>
    </td></tr>
    </table>
    
    </form>
    </center>';
    
    // clear xHTML tags from the content
    if($this->xHtml === false)
      $return = str_replace(' />','>',$return);
    
    return $return;
  }
  
 /**
  * <b>Name</b> showContactForm()<br />
  * 
  * Shows the form, ready to display in an HTML-page. Also the {@link contactForm::sendForm()} method will be called if the form is send.
  * 
  * <b>Notice</b>: The contact form is surrounded by an '<div class="contactForm">' tag to help to style the contact form.  
  * 
  *   
  * @param string $folder the absolute path of an folder to read
  * 
  * @uses contactForm::sendForm()
  * @uese contactForm::createForm()
  * 
  * @return string the contact form or the send messages    
  * 
  * @version 1.0
  * <br />
  * <b>ChangeLog</b><br />
  *    - 1.0 initial release
  * 
  */
  function showContactForm() {
    
    // var
    $return = '';
    $mandatoryfieldsOk = true;
    $mandatoryFields = array();
    
    $return .= '<h1>'.$this->langFile['form_title'].'</h1>'."\n";
    
    if(isset($_POST['contactFormSend']) && $_POST['contactFormSend'] == 'true')
      $return .= $this->sendForm($mandatoryfieldsOk,$mandatoryFields);
    
    // SHOW CONTACTFORM
    // but not when its send
    if((!isset($_POST['contactFormSend']) || $_POST['contactFormSend'] != 'true') ||
       $mandatoryfieldsOk === false)
      $return .= $this->createForm($mandatoryFields);
    
    return '<div class="contactForm">'.$return.'</div>';
  }
}
?>