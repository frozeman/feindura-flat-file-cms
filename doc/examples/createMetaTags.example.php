<?php
/*                               *** CODE *** 
--------------------------------------------------------------------------------
*/

// the feindura.include.php has to be included BEFORE the header of the HTML page is sent
// because a session is startet in this file
require('cms/feindura.include.php');

// creates a new feindura instance
$myCms = new feinduraPages();

// start to write HTML page
echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
            "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
      <html lang="de" xmlns="http://www.w3.org/1999/xhtml">
      <head>';

// writes the meta tags in the <head>
echo $feindura->createMetaTags('UTF-8','Fabian Vogelsteller', true, true, true, '12');
    
echo '</head>
      <body>
      ...';



/*                              *** RESULT *** 
--------------------------------------------------------------------------------
*/

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
      "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="de" xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="content-type" content="application/xhtml+xml; charset=UTF-8" />
  <meta http-equiv="content-language" content="de" />

  <title>
  feinduraExample.com - Welcome
  </title>

  <meta name="siteinfo" content="robots.txt" />
  <meta name="robots" content="index" />
  <meta name="robots" content="nofollow" />

  <meta name="revisit_after" content="12" />

  <meta http-equiv="pragma" content="no-cache" /> <!-- browser/proxy does not cache -->
  <meta http-equiv="cache-control" content="no-cache" /> <!-- browser/proxy does not cache -->

  <meta name="title" content="feinduraExample.com - Welcome" />
  <meta name="author" content="Fabian Vogelsteller" />
  <meta name="publisher" content="Puslisher written in the Backend" />
  <meta name="copyright" content="Copyright written in the Backend" />
  <meta name="description" content="This example website is intended to show
  how easy it is to use feindura CMS." />
  <meta name="keywords" content="keyword1,keyword2,keyword3,keyword4" />
   
</head>
<body>
...

?>