<?php
// created by Fabian Vogelsteller [frozeman.de]
// 
// contactform.php version 1.56 (needs Rmail (thirdparty/Rmail/))
//
// mit session (muss mit session_start(); gestartet werden)
//
// STYLES:
/* ----------------------- */
/* CHAPTA */
/*
.s {
	color: #666666;
	background-color: #666666;
	font: 5px Arial, Verdana, Sans-serif, Serif !important;
	line-height: 5px;
}
.w {
	background-color: transparent;
	font: 5px Arial, Verdana, Sans-serif, Serif !important;
	line-height: 5px;
}
*/
/*

  ben�tigt SPRACHDATEIVARIABLEN:*/
$langText['kontakt_h1'] = 'Kontaktformular';
$langText['kontakt_back'] = 'Zur&uuml;ck';
$langText['kontakt_sendfinish'] = 'Ihre Nachricht wurde erfolgreich versendet!';
$langText['kontakt_error_pflichtfelder'] = 'Folgende Felder m&uuml;ssen noch ausgef&uuml;llt werden:';
$langText['kontakt_error_chapta'] = '<b>Zahlenverifikation fehlgeschlagen!</b><br />Bitte &uuml;berpr&uuml;fen Sie die 4-stellige Zahleneingabe.';
$langText['kontakt_feld_anrede'] = 'Anrede';
$langText['kontakt_feld_anrede_man'] = 'Herr';
$langText['kontakt_feld_anrede_woman'] = 'Frau';
$langText['kontakt_feld_vorname'] = 'Vorname';
$langText['kontakt_feld_nachname'] = 'Nachname';
$langText['kontakt_feld_firma'] = 'Firma';
$langText['kontakt_feld_strasse'] = 'Stra&szlig;e';
$langText['kontakt_feld_nr'] = 'Nr.';
$langText['kontakt_feld_plz'] = 'PLZ';
$langText['kontakt_feld_ort'] = 'Ort';
$langText['kontakt_feld_land'] = 'Land';
$langText['kontakt_feld_internet'] = 'Internet';
$langText['kontakt_feld_email'] = 'E-Mail';
$langText['kontakt_feld_telefon'] = 'Telefon';
$langText['kontakt_feld_fax'] = 'Fax';
$langText['kontakt_feld_nachricht'] = 'Nachricht';
$langText['kontakt_feld_chapta'] = 'Bitte &uuml;bertragen Sie die Zahl in das Feld';
$langText['kontakt_feld_pflichtfelder'] = 'Notwendige Angaben';
$langText['kontakt_feld_senden'] = 'E-MAIL SENDEN';


include_once('chapta.php');

$contactMail = $websiteConfig['contactMail'];

$pflichtStern = ' <span style="color:#D23D30;">*</span>';
$pflichtColor = ' style="color:#D23D30;"';

// KONFIGURIERT die kontakt.php, wenn es nicht schon vorher geschehen ist
// $kontaktConf['beispiel'] = array(FELD ANZEIGEN?,PFLICHTFELD?);
if(!isset($kontaktConfig)) {
  $kontaktConfig['anrede'] = array(true,true);
  $kontaktConfig['vorname'] = array(true,true);
  $kontaktConfig['nachname'] = array(true,true);
  $kontaktConfig['firma'] = array(true,false);
  $kontaktConfig['strasse'] = array(true,false);
  $kontaktConfig['nr'] = array(true,false);
  $kontaktConfig['plz'] = array(true,false);
  $kontaktConfig['ort'] = array(true,false);
  $kontaktConfig['land'] = array(false,false);
  $kontaktConfig['internet'] = array(true,false);
  $kontaktConfig['email'] = array(true,true);
  $kontaktConfig['telefon'] = array(true,false);
  $kontaktConfig['fax'] = array(true,false);
}


// ->> Mail senden
// ----------------------------------------------------------------
if($_POST['send'] == true) {

$_SESSION['anrede'] = @$_POST['anrede'];
$_SESSION['vorname'] = @$_POST['vorname'];
$_SESSION['nachname'] = @$_POST['nachname'];
$_SESSION['strasse'] = @$_POST['strasse'];
$_SESSION['nr'] = @$_POST['nr'];
$_SESSION['plz'] = @$_POST['plz'];
$_SESSION['ort'] = @$_POST['ort'];
$_SESSION['land'] = @$_POST['land'];
$_SESSION['firma'] = @$_POST['firma'];
$_SESSION['internet'] = @$_POST['internet'];
$_SESSION['email'] = @$_POST['email'];
$_SESSION['telefon'] = @$_POST['telefon'];
$_SESSION['fax'] = @$_POST['fax'];
$_SESSION['nachricht_org'] = stripslashes($_POST['nachricht']);
$nachricht = str_replace("\n", '<br>', $_POST['nachricht']);

// CHAPTA CHECK (wird �ber url �bertragen)
if(isset($_SESSION['chaptacheck']) && $_POST['chapta'] == $_SESSION['chaptacheck']) {
  unset($_SESSION['chaptacheck']);  

  //�berpr�ft die PFLICHTFELDER
  $pflichtfelderOk = true;
  foreach($kontaktConfig as $key => $wert) {  
    // wenn das Feld NICHT aktiviert ist ODER
    // wenn das Feld KEIN PFLICHTFELD ist ODER
    // wenn das FELD NICHT LEER ist
    // versendet er die E-Mail
    if((!$wert[0] || !$wert[1] || !empty($_POST[$key]))) {   
      //echo '$key '.$key.' - '.$_POST[$key].'<br>';
    } else {
      //echo '$key:NO '.$key.' - '.$_POST[$key].'<br>';
      $pflichtfelderOk = false;      
      $emptyPflichtfelder[$key] = $langText['kontakt_feld_'.$key];
    }
  }
  
  if($pflichtfelderOk && !empty($_POST['nachricht'])) {
  
  $timestamp = time();
  $senddate	= date(d).".".date(m).".".date(Y);
  $sendtime = date("H:i",$timestamp);
  
  
  //zeigt die felder in der email an, wenn sie aktiviert sind und nicht leer
  if($kontaktConfig['anrede'] && $_POST['anrede'] != '-') $anrede = $_POST['anrede']."<br>\n";
  else $anrede = '';
    
  if($kontaktConfig['vorname'] && !empty($_POST['vorname'])) $vorname = $_POST['vorname']." ";
  else $vorname = '';
  
  if($kontaktConfig['nachname'] && !empty($_POST['nachname'])) $nachname = $_POST['nachname']."\n";
  else $nachname = '';
  
  if(($kontaktConfig['strasse'] ||
  $kontaktConfig['nr'] ||
  $kontaktConfig['plz'] ||
  $kontaktConfig['ort']) && (!empty($_POST['strasse']) || !empty($_POST['ort']))) $anschrift = "<br><b>Anschrift</b><br>\n";
  else $anschrift = '';
  
  if($kontaktConfig['strasse'] && !empty($_POST['strasse'])) $street = $_POST['strasse'].' '.$_POST['nr']."<br>\n";
  else $street = '';
  
  if($kontaktConfig['ort'] && !empty($_POST['ort'])) $ort = $_POST['plz'].' '.$_POST['ort']."<br>\n";
  else $ort = '';
  
  if($kontaktConfig['land'] && !empty($_POST['land'])) $land = $_POST['land']."<br>\n";
  else $land = '';
  
  if($kontaktConfig['internet'] && !empty($_POST['internet'])) $internet = '<br><b>Internet:</b> '.$_POST['internet']."\n";
  else $internet = '';
  
  if($kontaktConfig['email'] && !empty($_POST['email'])) $email = '<br><b>E-Mail:</b> '.$_POST['email']."\n";
  else $email = '';
  
  if($kontaktConfig['telefon'] && !empty($_POST['telefon'])) $telefon = '<br><b>Telefonnummer:</b> '.$_POST['telefon']."\n";
  else $telefon = '';
  
  if($kontaktConfig['fax'] && !empty($_POST['fax'])) $fax = '<br><b>Fax:</b> '.$_POST['fax']."\n";
  else $fax = '';
  
  // entfernt die \ aus dem text
  $nachricht = stripslashes($nachricht);
  
  $betreff = 'Nachricht vom '.$websiteConfig['title'].' Kontaktformular';
        
$mailcontent = '<html><head><title>'.$betreff.'</title>
</head><body style="font: 11pt Verdana, Arial, Helvetica;">
Ihnen wurde eine Nachricht vom <a href="http://'.$adminConfig['url'].'">'.$websiteConfig['title'].'</a> Kontaktformular zugesendet:<br><br>
<b>NACHRICHT</b> ---------------------------------------<br>
<br>
'.$nachricht.'<br>
<br>  
Gesendet am '.$senddate.' um '.$sendtime.'<br>
<br>
<b>VON</b> ---------------------------------------------<br>
<br>
'.$anrede.$vorname.$nachname.'
<br>
'.$anschrift.$street.$ort.$land.$internet.$email.$telefon.$fax.'<br>
-------------------------------------------------<br>
</body></html>';
  
    // verwendet Rmail, wenn die php version gr��er 5 ist
  if(substr(phpversion(),0,1) >= 5 && include_once('thirdparty/Rmail/Rmail.php')) {
    
    $mail = new Rmail();
    
    if(empty($_POST['email']))
      $mail->setFrom('no-reply <'.$contactMail.">");
    else
      $mail->setFrom($_POST['vorname'].' '.$_POST['nachname'].' <'.$_POST['email'].">");
    
    $mail->setSubject($betreff);
    $mail->setPriority('normal');
    
    
    $mail->setHTML($mailcontent);
    $mail->setText(preg_replace("/ +/", ' ', strip_tags($mailcontent)));
    
    $result = $mail->send(array($contactMail));
  
  // verschickt die mail ohne html wenn die phpversion <4 ist
  } else {
  
    $nachricht = preg_replace("/ +/", ' ', strip_tags($mailcontent));
    
    if(empty($_POST['email']))
      $header = 'From: no-reply <'.$contactMail.">\r\n";
    else
      $header = 'From: '.$_POST['vorname'].' '.$_POST['nachname'].' <'.$_POST['email'].">\r\n";
    
    $header .= 'X-Mailer: PHP/' . phpversion();
    
    mail($contactMail, $betreff, $nachricht, $header);
  
  }  
  
  echo '<p><b>'.$langText['kontakt_sendfinish'].'</b></p>';
  
  unset($_SESSION['anrede'],
  $_SESSION['vorname'],
  $_SESSION['nachname'],
  $_SESSION['strasse'],
  $_SESSION['nr'],
  $_SESSION['plz'],
  $_SESSION['ort'],
  $_SESSION['land'],
  $_SESSION['firma'],
  $_SESSION['internet'],
  $_SESSION['email'],
  $_SESSION['telefon'],
  $_SESSION['fax'],
  $_SESSION['nachricht_org']);
  
  // ERROR - PFLICHTFELDER LEER
  } else {
    
    $error = 'pflichtfeld';
        
    echo '<hr />
          <p'.$pflichtColor.'><b>'.$langText['kontakt_error_pflichtfelder'].'</b><br />';
      // listet die Pflichfelder die nochleer sind auf
      if(is_array($emptyPflichtfelder)) {
        $count = 1;
        foreach($emptyPflichtfelder as $emptyPflichtfeld) {
        
          if($count != 1) echo ', '; // zeigt das trenn ", " nicht an vor dem ersten item in der liste
          echo $emptyPflichtfeld;
          $count++;
        }
        
        // listet den nachrichtentext mit auf wenn er leer ist
        if(empty($_POST['nachricht'])) {
          echo ', '.$langText['kontakt_feld_nachricht'];
        }
      } else {
        // listet den nachrichtentext auf wenn NUR ER leer ist
        echo $langText['kontakt_feld_nachricht'];
      }
    //echo '<br /><br /><a href="?site='.$_GET['site'].'&'.htmlspecialchars(session_name().'='.session_id()).'">['.$langText['kontakt_back'].']</a></p>';
  }
  
  // ERROR - CHAPTA INCORRECT
  } else {
  echo '<hr />
        <p>'.$langText['kontakt_error_chapta'].'<br />
        <a href="?site='.$_GET['site'].'&'.htmlspecialchars(session_name().'='.session_id()).'">['.$langText['kontakt_back'].']</a></p>';
  }
  
} 

// KONTAKTFORMULAR EINBLENDEN
if(!$_POST['send'] || $error == 'pflichtfeld') {

?>


<h1><?php echo $langText['kontakt_h1']; ?></h1>

<center>
<form action="?site=contact&<?php echo htmlspecialchars(session_name().'='.session_id()); ?>" method="post" enctype="multipart/form-data" id="contactForm">

<table border="0" cellspacing="5" style="line-height:25px;">
<tr><td align="left" colspan="2">
  <?php
    if($kontaktConfig['anrede'][0]) {
      if($kontaktConfig['anrede'][1]) $pflicht = $pflichtStern; else $pflicht = '';
      if(!empty($emptyPflichtfelder['anrede'])) $notFilled = $pflichtColor; else $notFilled = '';
  ?>
  <?php echo '<label for="anrede_label"'.$notFilled.'><b>'.$langText['kontakt_feld_anrede'].$pflicht.'</b></label>' ?><br />
  <select name="anrede" id="anrede_label" size="1">
    <option></option>
    <option<?php if($_SESSION['anrede'] == $langText['kontakt_feld_anrede_man']) echo ' selected="selected"'; echo '>'.$langText['kontakt_feld_anrede_man']; ?></option>
    <option<?php if($_SESSION['anrede'] == $langText['kontakt_feld_anrede_woman']) echo ' selected="selected"'; echo '>'.$langText['kontakt_feld_anrede_woman']; ?></option>
  </select><br />
  <?php
    }
  ?>
</td></tr>
<tr><td align="left" valign="top">
  <?php  
  
    if($kontaktConfig['vorname'][0]) {
      if($kontaktConfig['vorname'][1]) $pflicht = $pflichtStern; else $pflicht = '';
      if(!empty($emptyPflichtfelder['vorname'])) $notFilled = $pflichtColor; else $notFilled = '';
      
      echo '<label for="vorname_label"'.$notFilled.'><b>'.$langText['kontakt_feld_vorname'].$pflicht.'</b></label><br />';
      echo '<input type="text" size="25" id="vorname_label" name="vorname" value="'.@$_SESSION['vorname'].'" /><br />';
  
    }
    
  echo '</td><td align="left" valign="top">';
  
    if($kontaktConfig['nachname'][0]) {
      if($kontaktConfig['nachname'][1]) $pflicht = $pflichtStern; else $pflicht = '';
      if(!empty($emptyPflichtfelder['nachname'])) $notFilled = $pflichtColor; else $notFilled = '';
      
    echo '<label for="nachname_label"'.$notFilled.'><b>'.$langText['kontakt_feld_nachname'].$pflicht.'</b></label><br />';
    echo '<input type="text" size="28" id="nachname_label" name="nachname" value="'.@$_SESSION['nachname'].'" /><br />';
  
    }
    
  echo '</td></tr><tr><td align="left" valign="top" colspan="2">';
  
    if($kontaktConfig['firma'][0]) {
      if($kontaktConfig['firma'][1]) $pflicht = $pflichtStern; else $pflicht = '';
      if(!empty($emptyPflichtfelder['firma'])) $notFilled = $pflichtColor; else $notFilled = '';
      
    echo '<label for="firma_label"'.$notFilled.'><b>'.$langText['kontakt_feld_firma'].$pflicht.'</b></label><br />';
    echo '<input type="text" size="25" id="firma_label" name="firma" value="'.@$_SESSION['firma'].'" /><br />';

    }    
      
  echo '</td></tr><tr><td align="left" valign="top">';
  
    // strasse, nr    
      if($kontaktConfig['strasse'][1]) $pflicht = $pflichtStern; else $pflicht = '';
      if(!empty($emptyPflichtfelder['strasse'])) $notFilled = $pflichtColor; else $notFilled = '';   
    if($kontaktConfig['strasse'][0]) echo '<label for="strasse_label"'.$notFilled.'><b>'.$langText['kontakt_feld_strasse'].$pflicht.'</b></label>';
      
      if($kontaktConfig['nr'][1]) $pflicht = $pflichtStern; else $pflicht = '';
      if(!empty($emptyPflichtfelder['nr'])) $notFilled = $pflichtColor; else $notFilled = '';  
    if($kontaktConfig['nr'][0]) echo ', <label for="nr_label"'.$notFilled.'><b>'.$langText['kontakt_feld_nr'].$pflicht.'</b></label><br />';
    if($kontaktConfig['strasse'][0]) echo '<input type="text" size="16" id="strasse_label" name="strasse" value="'.@$_SESSION['strasse'].'" />';
    if($kontaktConfig['nr'][0]) echo '<input type="text" size="5" id="nr_label" name="nr" value="'.@$_SESSION['nr'].'" /><br />';

    
    // plz, ort, land
      if($kontaktConfig['plz'][1]) $pflicht = $pflichtStern; else $pflicht = '';
      if(!empty($emptyPflichtfelder['plz'])) $notFilled = $pflichtColor; else $notFilled = '';    
    if($kontaktConfig['plz'][0]) echo '<label for="plz_label"'.$notFilled.'><b>'.$langText['kontakt_feld_plz'].$pflicht.'</b></label>';
    
      if($kontaktConfig['ort'][1]) $pflicht = $pflichtStern; else $pflicht = '';
      if(!empty($emptyPflichtfelder['ort'])) $notFilled = $pflichtColor; else $notFilled = '';
    if($kontaktConfig['ort'][0]) echo ', <label for="ort_label"'.$notFilled.'><b>'.$langText['kontakt_feld_ort'].$pflicht.'</b></label><br />';
    if($kontaktConfig['plz'][0]) echo '<input type="text" size="5" id="plz_label" name="plz" value="'.@$_SESSION['plz'].'" />';
    if($kontaktConfig['ort'][0]) echo '<input type="text" size="16" id="ort_label" name="ort" value="'.@$_SESSION['ort'].'" /><br />';
    
      if($kontaktConfig['land'][1]) $pflicht = $pflichtStern; else $pflicht = '';
      if(!empty($emptyPflichtfelder['land'])) $notFilled = $pflichtColor; else $notFilled = '';
    if($kontaktConfig['land'][0]) echo '<label for="land_label"'.$notFilled.'><b>'.$langText['kontakt_feld_land'].$pflicht.'</b></label><br />';
    if($kontaktConfig['land'][0]) echo '<input type="text" size="26"  id="land_label" name="land" value="'.@$_SESSION['land'].'" />';


  echo '</td><td align="left" valign="top">';
  
    if($kontaktConfig['internet'][0]) {
      if($kontaktConfig['internet'][1]) $pflicht = $pflichtStern; else $pflicht = '';
      if(!empty($emptyPflichtfelder['internet'])) $notFilled = $pflichtColor; else $notFilled = '';
      
    echo '<label for="internet_label"'.$notFilled.'><b>'.$langText['kontakt_feld_internet'].$pflicht.'</b></label><br />';
    echo '<input type="text" size="28" id="internet_label" name="internet" value="'.@$_SESSION['internet'].'" /><br />';

    }
    
    if($kontaktConfig['email'][0]) {
      if($kontaktConfig['email'][1]) $pflicht = $pflichtStern; else $pflicht = '';
      if(!empty($emptyPflichtfelder['email'])) $notFilled = $pflichtColor; else $notFilled = '';
      
    echo '<label for="email_label"'.$notFilled.'><b>'.$langText['kontakt_feld_email'].$pflicht.'</b></label><br />';
    echo '<input type="text" size="28" id="email_label" name="email" value="'.@$_SESSION['email'].'" /><br />';

    }
    
    
    if($kontaktConfig['telefon'][0]) {
      if($kontaktConfig['telefon'][1]) $pflicht = $pflichtStern; else $pflicht = '';
      if(!empty($emptyPflichtfelder['telefon'])) $notFilled = $pflichtColor; else $notFilled = '';
      
    echo '<label for="telefon_label"'.$notFilled.'><b>'.$langText['kontakt_feld_telefon'].$pflicht.'</b></label><br />';
    echo '<input type="text" size="28" id="telefon_label" name="telefon" value="'.@$_SESSION['telefon'].'" /><br />';

    }
    
    if($kontaktConfig['fax'][0]) {
      if($kontaktConfig['fax'][1]) $pflicht = $pflichtStern; else $pflicht = '';
      if(!empty($emptyPflichtfelder['fax'])) $notFilled = $pflichtColor; else $notFilled = '';
      
    echo '<label for="fax_label"'.$notFilled.'><b>'.$langText['kontakt_feld_fax'].$pflicht.'</b></label><br />';
    echo '<input type="text" size="28" id="fax_label" name="fax" value="'.@$_SESSION['fax'].'" /><br />';

    }
  ?>
</td></tr>
<tr><td align="left" colspan="2">
<?php

  if(empty($_POST['nachricht']) && $error == 'pflichtfeld') $notFilled = $pflichtColor; else $notFilled = '';

echo '<label for="nachricht_label"'.$notFilled.'><b>'.$langText['kontakt_feld_nachricht'].$pflichtStern.'</b></label><br />';

?>
<textarea style="width:455px;" rows="9" id="nachricht_label" name="nachricht"><?php echo @$_SESSION['nachricht_org']; ?></textarea><br />
<br />
<br />
<b><?php echo $langText['kontakt_feld_chapta'].$pflichtStern ?></b>
<div style="margin: 0px 10px; line-height: 0px !important;">
<?php
	$n = new Number(rand(1000,9999));
	$n->printNumber();
  $_SESSION['chaptacheck'] = $n->getNum();	
?>
<input style="position:relative;top:-25px;left:50px;width:31px;" name="chapta" size="4" autocomplete="off" type="text" maxlength="4" />
</div>

<input type="hidden" name="send" value="true" />

<p style="margin-left:8px">
<input type="submit" value="<?php echo $langText['kontakt_feld_senden'] ?>" class="buttons" />
<span style="font-size: 10px;"><?php echo $pflichtStern.' '.$langText['kontakt_feld_pflichtfelder'] ?></span>
</p>
</td></tr>
</table>

</form>
</center>
<?php
}
?>