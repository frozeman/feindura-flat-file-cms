<?php
/*                               *** CODE *** 
--------------------------------------------------------------------------------
*/

// a session will be started in the "feindura.include.php",
// therefor you have to include this file before the header of the HTML page is sent,
// which means before any HTML Tag.
require('cms/feindura.include.php');

// creates a new Feindura instance
$feindura = new Feindura();

// start to write HTML page
?>
<!DOCTYPE html>
  <html>
  <head>';
  <?php
    // John Doe is the author of the website.
    echo $feindura->createMetaTags('John Doe');
  ?>
  </head>
  <body>
  ...


<?php                               *** RESULT *** 
--------------------------------------------------------------------------------

<!DOCTYPE html>
<html>
<head>

  <meta charset="UTF-8">
  <title>Welcome - An Example Website</title>

  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"> <!-- enable google chrome frame, if available -->

  <meta name="author" content="Max Musterman">
  <meta name="publisher" content="Somebody From the Backend">
  <meta name="copyright" content="Somebody From the Backend">
  <meta name="generator" content="feindura - Flat File CMS 1.2 build:999">

  <link rel="alternate" type="application/atom+xml" title="Eine Beispiel Website (Atom, DE)" href="http://localhost/cms/pages/atom.de.xml">
  <link rel="alternate" type="application/rss+xml" title="Eine Beispiel Website (RSS 2.0, DE)" href="http://localhost/cms/pages/rss2.de.xml">
  <link rel="alternate" type="application/atom+xml" title="An Example Website (Atom, EN)" href="http://localhost/cms/pages/atom.en.xml">
  <link rel="alternate" type="application/rss+xml" title="An Example Website (RSS 2.0, EN)" href="http://localhost/cms/pages/rss2.en.xml">

  <link rel="stylesheet" type="text/css" href="/cms/plugins/contactForm/css/style.css">
  <link rel="stylesheet" type="text/css" href="/cms/plugins/imageGallery/milkbox/css/milkbox.css">
  <link rel="stylesheet" type="text/css" href="/cms/plugins/imageGallery/milkbox copy/css/milkbox.css">

</head>
<body>
...

?>