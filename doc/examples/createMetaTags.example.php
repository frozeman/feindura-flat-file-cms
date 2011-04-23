<?php
/*                               *** CODE *** 
--------------------------------------------------------------------------------
*/

// a session will be started in the "feindura.include.php",
// therefor you have to include this file before the header of the HTML page is sent,
// which means before any HTML Tag.
require('cms/feindura.include.php');

// creates a new feindura instance
$myCms = new feindura();

// start to write HTML page
echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
            "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
      <html lang="en" xmlns="http://www.w3.org/1999/xhtml">
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
<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta charset="UTF-8" />
  <meta http-equiv="content-language" content="en" />

  <title>
   Welcome - feinduraExample.com
  </title>

  <meta name="siteinfo" content="robots.txt" />
  <meta name="revisit_after" content="12" />

  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" /> <!-- enable google chrome frame, if available -->
  <meta name="viewport" content="width=device-width, initial-scale=1.0" /> <!-- set width for mobile devices -->

  <meta name="title" content="feinduraExample.com - Welcome" />
  <meta name="author" content="Fabian Vogelsteller" />
  <meta name="publisher" content="Puslisher written in the Backend" />
  <meta name="copyright" content="Copyright written in the Backend" />
  <meta name="description" content="This example website is intended to show
  how easy it is to use feindura CMS." />
  <meta name="keywords" content="keyword1,keyword2,keyword3,keyword4" />
  
  <link rel="alternate" type="application/atom+xml" title="News - feinduraExample.com (Atom)" href="http://feinduraexample.com/cms/pages/1/atom.xml" />
  <link rel="alternate" type="application/rss+xml" title="News - feinduraExample.com (RSS 2.0)" href="http://feinduraexample.com/cms/pages/1/rss2.xml" />
   
</head>
<body>
...

?>